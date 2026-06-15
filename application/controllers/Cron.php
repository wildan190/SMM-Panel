<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('Gopay');
        // $this->load->library('Ovo');
        // $this->load->library('Bca');
    }
    public function update_status()
    {
        // Mendapatkan data API dari model
        $data_api = $this->api_model->get_rows(['where' => [['is_manual' => '0']]]);
        // Membuat client Guzzle
        $client = $this->create_guzzle_client();
        $param_key = 'form_params';

        // Loop melalui setiap data API
        $servicesIds = [];
        foreach ($data_api as $data) {
            if ($data['auto_update'] == '1') {
                $api_service = $this->db->get_where('api_service', ['api_id' => $data['id']])->row();
                $api_request_param = $this->api_request_param_model->get_rows(['where' => [['api_id' => $data['id'], 'api_type' => 'service']]]);
                $params = $this->prepare_params($api_request_param, $data);
                try {
                    // Mengirim request ke endpoint API
                    $request = $client->request('POST', $api_service->end_point, [
                        $param_key => $params,
                        'headers' => ['Accept' => 'application/json'],
                        'timeout' => 60,
                    ]);

                    if ($request->getStatusCode() === 200) {
                        // Mendapatkan response dan decode JSON
                        $response = $request->getBody()->getContents();
                        $json_result = json_decode($response, true);

                        if (count($json_result) < 1) {
                            $this->lib->print_data($json_result);
                            die;
                        }

                        // Memproses data service dari response
                        $data_service_key = $api_service->data_service_key;
                        $data_services = ($data_service_key <> '-') ? $json_result[$data_service_key] : $json_result;
                        foreach ($data_services as $value) {
                            if (isset($value['status']) && $value['status'] == '0') continue;
                            $servicesIds[$data['name']][$value[$api_service->service_id_key]][$data['id']] = $data['name'];
                        }
                    }
                } catch (Exception $e) {
                    // Tangani exception atau log error
        log_message('error', $e->getMessage());
                }
            }
        }
        $services = $this->service_model->get_rows(['where' => [[
            'status' => '1'
        ]]]);
        $servicesExists = [];
        foreach ($services as $service) {
            $data_api = $this->api_model->get_row(['id' => $service['api_id']]);
            if (!$servicesIds[$data_api->name][$service['api_service_id']][$service['api_id']]) {
                $data_update = [
                    'status' => '0',
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $this->db->trans_start();
                $this->db->set($data_update);
                $this->db->where(['id' => $service['id']]);
                $this->db->update('service');
                $this->db->trans_complete();

                $data_service_logs = [
                    'service_id' => $service['id'],
                    'service_name' => $service['name'],
                    'before_update' => '1',
                    'after_update' => '0',
                    'type' => 'disabled',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->service_logs_model->insert($data_service_logs);
            }
        }
        $this->lib->print_data($servicesExists);
        die;
    }

    private function create_guzzle_client()
    {
        // Membuat instance client Guzzle
        return new GuzzleHttp\Client([
            'config' => [
                'http' => [
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                    'allow_self_signed' => false,
                    'ciphers' => 'DEFAULT:!DH',
                    'disable_compression' => true,
                    'protocol_version' => '1.2',
                ],
            ],
        ]);
    }
    private function prepare_params($api_request_param, $data)
    {
        $params = [];
        foreach ($api_request_param as $row) {
            if ($row['param_type'] === 'custom') {
                $params[$row['param_key']] = $row['param_value'];
            } else {
                switch ($row['param_value']) {
                    case 'api_id':
                        $params[$row['param_key']] = $data['api_id'];
                        break;
                    case 'api_key':
                        $params[$row['param_key']] = $data['api_key'];
                        break;
                    case 'secret_key':
                        $params[$row['param_key']] = $data['secret_key'];
                        break;
                }
            }
        }
        return $params;
    }
}
