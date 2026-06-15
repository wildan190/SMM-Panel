<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_cookie(get_cookie('smm_login'));
        if ($this->session->userdata('login')) {
            if (user() == false)
                exit(redirect(base_url('auth/logout')));
        }
    }
    public function regenerate()
    {
        $this->user_model->update(array('api_key' => $this->lib->generate_api_key()), array('id' => user()));
        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil.', 'msg' => 'API Key berhasil dibuat ulang.'));
        redirect(base_url('api/documentation'));
    }
    public function documentation()
    {
        if (website_config('mt_web') == 1) {
            exit(redirect(base_url('maintenance')));
        }
        if (!$this->session->userdata('login'))
            exit(redirect(base_url()));
        $this->render('public/api/documentation', ['page_type' => 'Dokumentasi API']);
    }
    public function profile()
    {
        // filter input = 1
        header('Content-Type: application/json');
        $result = ['status' => false, 'data' => 'Permintaan salah'];
        if ($this->input->post()) {
            $this->form_validation->set_rules('api_id', 'API ID', 'required');
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            if ($this->form_validation->run() == true) {
                $data_post = [
                    'api_id' => $this->lib->encrypt_decrypt('decrypt', $this->db->escape_str($this->input->post('api_id'))),
                    'api_key' => $this->db->escape_str($this->input->post('api_key')),
                ];
                $user = $this->user_model->get_row(['id' => $data_post['api_id'], 'status' => '1']);
                if ($user == false) {
                    $result = ['status' => false, 'data' => 'API ID salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                if ($user->api_key <> $data_post['api_key']) {
                    $result = ['status' => false, 'data' => 'API KEY salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                $result = ['status' => true, 'data' => ['username' => $user->username, 'full_name' => $user->full_name, 'level' => $user->level, 'balance' => $user->balance, 'registered' => $user->created_at]];
            }
        }
        exit(json_encode($result, JSON_PRETTY_PRINT));
    }
    public function services()
    {
        header('Content-Type: application/json');
        $result = ['status' => false, 'data' => 'Permintaan salah'];

        if ($this->input->post()) {
            $this->form_validation->set_rules('api_id', 'API ID', 'required');
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');

            if ($this->form_validation->run() == true) {
                $api_id = $this->db->escape_str($this->input->post('api_id'));
                $api_key = $this->db->escape_str($this->input->post('api_key'));

                // Decrypt API ID
                $decrypted_api_id = $this->lib->encrypt_decrypt('decrypt', $api_id);

                $user = $this->user_model->get_row(['id' => $decrypted_api_id, 'status' => '1']);

                if ($user == false) {
                    $result = ['status' => false, 'data' => 'API ID salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }

                if ($user->api_key !== $api_key) {
                    $result = ['status' => false, 'data' => 'API KEY salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }

                $services = $this->service_model->get_rows([
                    'select' => 'service.id, service_category.name AS category, service.name, service.price, service.min, service.max, service.description AS description, service.average_time, service.status, service.refill, service.type',
                    'join' => [['table' => 'service_category', 'on' => 'service_category.id = service.service_category_id', 'param' => 'inner']],
                    'where' => [['service.status' => '1', 'service.api' => '1']],
                    'order_by' => 'service.id ASC'
                ]);

                if ($services) {
                    // Membersihkan karakter khusus dari deskripsi
                    foreach ($services as &$service) {
                        $service['description'] = htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8');
                    }
                    unset($service); // Hapus referensi terakhir

                    $result = ['status' => true, 'data' => $services];
                }
            }
        }

        exit(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }


    public function order()
    {
        // filter input = 1
        header('Content-Type: application/json');
        $result = ['status' => false, 'data' => 'Permintaan salah'];
        if ($this->input->post()) {
            $this->form_validation->set_rules('api_id', 'API ID', 'required');
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('service', 'Layanan', 'required|numeric');
            $this->form_validation->set_rules('target', 'Target', 'required');
            $this->form_validation->set_rules('quantity', 'Jumlah Pesan', 'numeric');
            if ($this->form_validation->run() == true) {
                $data_post = [
                    'api_id' => $this->lib->encrypt_decrypt('decrypt', $this->db->escape_str($this->input->post('api_id'))),
                    'api_key' => $this->db->escape_str($this->input->post('api_key')),
                    'service_id' => $this->db->escape_str($this->input->post('service')),
                    'target' => $this->db->escape_str(strip_tags($this->input->post('target'))),
                    'quantity' => $this->db->escape_str($this->input->post('quantity')),
                    'custom_comments' => ($this->input->post('custom_comments') <> '') ? $this->db->escape_str(strip_tags($this->input->post('custom_comments'))) : null,
                    'custom_link' => ($this->input->post('custom_link') <> '') ? $this->db->escape_str(strip_tags($this->input->post('custom_link'))) : null,
                ];
                $user = $this->user_model->get_row(['id' => $data_post['api_id'], 'status' => '1']);
                $saldo_awal = $this->user_model->get_by_id($data_post['api_id']);
                if ($user == false) {
                    $result = ['status' => false, 'data' => 'API ID salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                if ($user->api_key <> $data_post['api_key']) {
                    $result = ['status' => false, 'data' => 'API KEY salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }

                // CHECK SERVICE //
                $service = $this->service_model->get_row(['id' => $data_post['service_id'], 'status' => '1', 'api' => '1']);
                if ($service == false) {
                    $result = ['status' => false, 'data' => 'Layanan tidak tersedia'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }

                $data_input = [
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'target' => $data_post['target'],
                    'quantity' => $data_post['quantity'],
                    'price' => 0,
                    // reset
                    'profit' => 0,
                    // reset
                    'status' => 'Pending',
                    'is_refill' => 0,
                    'is_api' => 1,
                    'is_refund' => 0,
                    'start_count' => 0,
                    'remains' => $data_post['quantity'],
                    'api_id' => 0,
                    // reset
                    'api_order_id' => 0,
                    // reset
                    'api_log_order' => null,
                    // reset
                    'ip_address' => $this->input->ip_address(),
                    'custom_comments' => ($service->type == 'custom_comments' && $this->input->post('custom_comments')) ? $this->input->post('custom_comments') : (($this->input->post('username')) ? $this->input->post('username') : $data_post['custom_comments']),
                    'custom_link' => ($service->type == 'custom_comments' && $this->input->post('custom_comments')) ? '' : (($this->input->post('comments')) ? $this->input->post('comments') : $data_post['custom_link']),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                // LIMIT THE SAME ORDER TARGET //
                if (website_config('limit_order') > 0) {
                    if ($this->order_model->get_count(['where' => [['user_id' => $user->id, 'target' => $data_input['target']], "status IN ('Pending', 'Processing')"]]) >= website_config('limit_order')) {
                        $result = ['status' => false, 'data' => 'Mohon menunggu sampai pesanan sebelumnya dengan target yang sama selesai diproses.'];
                        exit(json_encode($result, JSON_PRETTY_PRINT));
                    }
                }
                // END LIMIT THE SAME ORDER TARGET //

                // jika type primary tetap data custom comments ada
                if (($service->type == 'primary') && ($data_input['custom_comments'] || $data_input['custom_link'])) {
                    $result = ['status' => false, 'data' => 'Layanan ini tidak support Custom Comments'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                if ($service->refill == '1') {
                    $data_input['is_refill'] = '1';
                }
                $data_input['service'] = $service->name;
                // END CHECK SERVICE //

                // CHECK SERVICE TYPE //
                if ($service->type == 'custom_comments') {
                    if ($service->max == '1') {
                        $data_input['quantity'] = 1;
                    } else {
                        $data_input['quantity'] = count(explode("\n", str_replace("\r\n", "\n", $data_input['custom_comments'])));
                    }
                }
                // END CHECK SERVICE TYPE //

                // CHECK ORDER DETAIL //
                if ($data_input['quantity'] < $service->min) {
                    $result = ['status' => false, 'data' => 'Minimal pesanan ' . $service->min . '.'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                } elseif ($data_input['quantity'] > $service->max) {
                    $result = ['status' => false, 'data' => 'Maksimal pesanan ' . $service->max . '.'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                // END CHECK ORDER DETAIL //

                // SET PRICE & PROFIT //
                if ($service->max == '1') {
                    $data_input['price'] = $data_input['quantity'] * $service->price;
                    $data_input['profit'] = $data_input['quantity'] * $service->profit;
                } else {
                    $data_input['price'] = $data_input['quantity'] * ($service->price / 1000);
                    $data_input['profit'] = $data_input['quantity'] * ($service->profit / 1000);
                }

                $custom_price = $this->custom_price_model->get_row(['service_id' => $data_input['service_id'], 'user_id' => $user->id]);
                if ($custom_price == true) {
                    if ($service->max == '1') {
                        $data_input['price'] = $data_input['quantity'] * $custom_price->price;
                        $data_input['profit'] = $data_input['quantity'] * $custom_price->profit;
                    } else {
                        $data_input['price'] = $data_input['quantity'] * ($custom_price->price / 1000);
                        $data_input['profit'] = $data_input['quantity'] * ($custom_price->profit / 1000);
                    }
                }
                // END SET PRICE & PROFIT //

                // CHECK USER BALANCE //
                if ($user->balance < $data_input['price']) {
                    $result = ['status' => false, 'data' => 'Saldo tidak mencukupi'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                // END CHECK USER BALANCE //

                // CHECK API //
                $api = $this->api_model->get_by_id($service->api_id);
                if ($api == false) {
                    $result = ['status' => false, 'data' => 'Layanan tidak tersedia pada system 1 .'];
                }
                $data_input['api_id'] = $api->id;
                // END CHECK API //
                $provider_order_id = false;
                if ($api->is_manual == '1') {
                    $provider_order_id = true;
                } else {
                    // CHECK API ORDER //
                    $api_order = $this->api_order_model->get_row(['api_id' => $service->api_id]);
                    if ($api_order == false) {
                        $result = ['status' => false, 'data' => 'Layanan tidak tersedia pada system 2.'];
                    }
                    // END CHECK API ORDER //
                    $params = [];
                    $api_request_param = $this->db->get_where('api_request_param', ['api_id' => $service->api_id, 'api_type' => 'order']);
                    if (!empty($api_request_param)) {
                        foreach ($api_request_param->result_array() as $row) {

                            if ($row['param_type'] === 'custom') {

                                $params[$row['param_key']] = $row['param_value'];
                            } else {

                                if (in_array($row['param_value'], ['custom_comment', 'custom_comments', 'comments', 'comment']) && $service->type == 'custom_comments') {
                                    $params[$row['param_key']] = str_replace("\n", "\r\n", str_replace("\r\n", "\n", $data_input['custom_comments']));
                                } else if (in_array($row['param_value'], ['custom_link', 'custom_links']) && $service->type == 'custom_link') {
                                    $params[$row['param_key']] = $data_input['custom_link'];
                                } else if ($row['param_value'] == 'service_id') {
                                    $params[$row['param_key']] = $service->api_service_id;
                                } else if ($row['param_value'] == 'target') {
                                    $params[$row['param_key']] = $data_input['target'];
                                } else if ($row['param_value'] == 'quantity') {
                                    $params[$row['param_key']] = $data_input['quantity'];
                                } else if ($row['param_value'] == 'api_id') {
                                    $params[$row['param_key']] = $api->api_id;
                                } else if ($row['param_value'] == 'api_key') {
                                    $params[$row['param_key']] = $api->api_key;
                                } else if ($row['param_value'] == 'secret_key') {
                                    $params[$row['param_key']] = $api->secret_key;
                                } else if ($row['param_value'] == 'username') {
                                    $params[$row['param_key']] = $this->db->escape_str($this->input->post('username'));
                                } else if ($row['param_value'] == 'usernames') {
                                    $params[$row['param_key']] = $this->db->escape_str($this->input->post('usernames'));
                                } else if ($row['param_value'] == 'hashtags') {
                                    $params[$row['param_key']] = $this->db->escape_str($this->input->post('hashtags'));
                                } else if ($row['param_value'] == 'hashtag') {
                                    $params[$row['param_key']] = $this->db->escape_str($this->input->post('hashtag'));
                                } else if ($row['param_value'] == 'media') {
                                    $params[$row['param_key']] = $this->db->escape_str($this->input->post('media'));
                                } else if ($row['param_value'] == 'answer_number') {
                                    $params[$row['param_key']] = $this->db->escape_str($this->input->post('answer_number'));
                                } else if ($row['param_value'] == 'groups') {
                                    $params[$row['param_key']] = $this->db->escape_str($this->input->post('groups'));
                                } else if (in_array($row['param_value'], ['comments', 'custom_comments', 'custom_comment', 'comment'])) {
                                    if ($service->type == 'Comment Replies') {
                                        $params[$row['param_key']] = str_replace("\n", "\r\n", str_replace("\r\n", "\n", $this->input->post('comments')));
                                    }
                                }
                            }
                        }
                        $client = new GuzzleHttp\Client();

                        try {
                            $param_key = 'form_params';

                            $request = $client->request('POST', $api_order->end_point, [
                                $param_key => $params,
                                'headers' => ['Accept' => 'application/json'],
                                'timeout' => 30,
                            ]);

                            $response = $request->getBody()->getContents();
                            $json_result = json_decode($response, true);

                            if ($request->getStatusCode() === 200) {
                                $provider_order_id = $json_result['order'] ?? search_key($json_result, $api_order->order_id_key);
                                if ($provider_order_id) {
                                    $data_input['api_order_id'] = $provider_order_id;
                                }
                                $data_input['api_log_order'] = $this->db->escape($response);
                                $data_input['service'] = $service->name;
                            }
                        } catch (Exception $e) {
                            log_message('error', 'API Guzzle Error: ' . $e->getMessage());
                            $result = ['status' => false, 'data' => 'Gagal terhubung ke provider pusat.'];
                            exit(json_encode($result, JSON_PRETTY_PRINT));
                        }
                    }
                }
                if ($provider_order_id != null) {
                    $this->db->trans_start();
                    $this->user_model->update(['balance' => $user->balance - $data_input['price']], ['id' => $user->id]);
                    $insert_order = $this->order_model->insert($data_input);
                    $this->log_balance_usage_model->insert([
                        'user_id' => $user->id,
                        'type' => 'minus',
                        'category' => 'place order',
                        'amount' => $data_input['price'],
                        'description' => 'Melakukan pemesanan API #' . $insert_order . '.',
                        'before' => $user->balance,
                        'after' => $user->balance - $data_input['price'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() == true) {
                        $result = ['status' => true, 'data' => ['id' => $insert_order, 'price' => $data_input['price']]];
                    } else {
                        $result = ['status' => false, 'data' => 'Kesalahan tidak terduga'];
                    }
                } else {
                    $error_msg = $json_result['error'] ?? ($json_result['message'] ?? 'Respon provider tidak valid.');
                    $result = ['status' => false, 'data' => 'Pesan dari Provider: ' . $error_msg];
                }
            }
        }
        exit(json_encode($result, JSON_PRETTY_PRINT));
    }
    public function status()
    {
        // filter input = 1
        header('Content-Type: application/json');
        $result = ['status' => false, 'data' => 'Permintaan salah'];
        if ($this->input->post()) {
            $this->form_validation->set_rules('api_id', 'API ID', 'required');
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('id', 'ID Pesanan', 'required|numeric');
            if ($this->form_validation->run() == true) {
                $data_post = [
                    'api_id' => $this->lib->encrypt_decrypt('decrypt', $this->db->escape_str($this->input->post('api_id'))),
                    'api_key' => $this->db->escape_str($this->input->post('api_key')),
                    'id' => $this->db->escape_str($this->input->post('id')),
                ];
                $user = $this->user_model->get_row(['id' => $data_post['api_id'], 'status' => '1']);
                if ($user == false) {
                    $result = ['status' => false, 'data' => 'API ID salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                if ($user->api_key <> $data_post['api_key']) {
                    $result = ['status' => false, 'data' => 'API KEY salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }

                // CHECK ORDER //
                $order = $this->order_model->get_row(array('user_id' => $user->id, 'id' => $data_post['id']));
                if ($order == false) {
                    $result = ['status' => false, 'data' => 'Pesanan tidak ditemukan'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                } else {
                    $result = ['status' => true, 'data' => ['status' => $order->status, 'start_count' => $order->start_count, 'remains' => $order->remains]];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
            }
        }
    }
    public function refill()
    {
        // filter input = 1
        header('Content-Type: application/json');
        $result = ['status' => false, 'data' => 'Permintaan salah'];
        if ($this->input->post()) {
            $this->form_validation->set_rules('api_id', 'API ID', 'required');
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('id', 'ID Pesanan', 'required|numeric');
            if ($this->form_validation->run() == true) {
                $data_post = [
                    'api_id' => $this->lib->encrypt_decrypt('decrypt', $this->db->escape_str($this->input->post('api_id'))),
                    'api_key' => $this->db->escape_str($this->input->post('api_key')),
                    'id' => $this->db->escape_str($this->input->post('id')),
                ];
                $user = $this->user_model->get_row(['id' => $data_post['api_id'], 'status' => '1']);
                if ($user == false) {
                    $result = ['status' => false, 'data' => 'API ID salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                if ($user->api_key <> $data_post['api_key']) {
                    $result = ['status' => false, 'data' => 'API KEY salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }

                // CHECK ORDER //
                $order = $this->order_model->get_row(array('user_id' => $user->id, 'id' => $data_post['id']));
                if ($order == false) {
                    $result = ['status' => false, 'data' => 'Pesanan tidak ditemukan'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                } else {
                    $data_input = [
                        'user_id' => $user->id,
                        'order_id' => $order->id,
                        'api_id' => $order->api_id,
                        'service' => $order->service,
                        'target' => $order->target,
                        'status' => 'Pending',
                        'api_refill_id' => 0,
                        // reset
                        'api_log_refill' => 0,
                        // reset
                        'ip_address' => $this->input->ip_address(),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    if (time() > strtotime($order->next_refill)) {
                        $api = $this->api_model->get_by_id($order->api_id);
                        if ($api == false) {
                            print('API False');
                        }
                        // END CHECK API //
                        $provider_order_id = false;
                        if ($api->is_manual == '1') {
                            $provider_order_id = true;
                        } else {
                            // CHECK API ORDER //
                            $api_refill = $this->api_refill_model->get_row(['api_id' => $order->api_id]);
                            if ($api_refill == false) {
                                print('API Refill False');
                                die;
                            }
                            // END CHECK API ORDER //
                            $params = [];
                            $api_request_param = $this->db->get_where('api_request_param', ['api_id' => $order->api_id, 'api_type' => 'refill']);
                            //$this->lib->print_data($api_request_param);
                            if (!empty($api_request_param)) {
                                foreach ($api_request_param->result_array() as $row) {

                                    if ($row['param_type'] === 'custom') {
                                        $params[$row['param_key']] = $row['param_value'];
                                    } else {
                                        if ($row['param_value'] == 'order_id') {
                                            $params[$row['param_key']] = $order->api_order_id;
                                        } else if ($row['param_value'] == 'api_id') {
                                            $params[$row['param_key']] = $api->api_id;
                                        } else if ($row['param_value'] == 'api_key') {
                                            $params[$row['param_key']] = $api->api_key;
                                        } else if ($row['param_value'] == 'secret_key') {
                                            $params[$row['param_key']] = $api->secret_key;
                                        }
                                    }
                                }
                                $client = new GuzzleHttp\Client();
                                try {
                                    $param_key = 'form_params';

                                    $request = $client->request('POST', $api_refill->end_point, [
                                        $param_key => $params,
                                        'headers' => ['Accept' => 'application/json'],
                                    ]);
                                    if ($request->getStatusCode() === 200) {
                                        $response = $request->getBody()->getContents();
                                        $json_result = json_decode($response, true);
                                        //$this->lib->print_data($response); die;
                                        $status = search_key($json_result, $api_refill->refill_id_key);
                                        if ($status === true || $status === false) {
                                            unset($json_result[$api_refill->refill_id_key]);
                                        }

                                        $provider_order_id = search_key($json_result, $api_refill->refill_id_key);
                                        $data_input['api_refill_id'] = $provider_order_id;
                                        $data_input['api_log_refill'] = $this->db->escape($response);
                                    }
                                } catch (Exception $e) {
                                    print_r($e->getMessage());
                                }
                            }
                        }
                        if ($provider_order_id != null) {
                            $this->db->trans_start();
                            $this->order_model->update(['api_log_refill' => $this->db->escape($response), 'next_refill' => date('Y-m-d H:i:s', time() + (60 * 60 * 24))], ['id' => $order->id]);
                            $insert = $this->refill_model->insert($data_input);
                            $this->db->trans_complete();
                            $result = ['status' => true, 'data' => ['refill_id' => $insert, 'order_id' => $order->id, 'msg' => 'Berhasil melakukan permintaan Refill.']];
                            exit(json_encode($result, JSON_PRETTY_PRINT));
                        } else {
                            $result = ['status' => false, 'data' => ['refill_id' => 0, 'order_id' => $order->id, 'msg' => 'Gagal melakukan permintaan Refill.']];
                            exit(json_encode($result, JSON_PRETTY_PRINT));
                        }
                    } else {
                        $result = ['status' => false, 'data' => 'Gagal Melakukan Permintaan Refill (Waktu Refill Sebelumnya Belum Selesai)'];
                        exit(json_encode($result, JSON_PRETTY_PRINT));
                    }
                }
            }
        }
    }
    public function status_refill()
    {
        // filter input = 1
        header('Content-Type: application/json');
        $result = ['status' => false, 'data' => 'Permintaan salah'];
        if ($this->input->post()) {
            $this->form_validation->set_rules('api_id', 'API ID', 'required');
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('id', 'ID Refill', 'required|numeric');
            if ($this->form_validation->run() == true) {
                $data_post = [
                    'api_id' => $this->lib->encrypt_decrypt('decrypt', $this->db->escape_str($this->input->post('api_id'))),
                    'api_key' => $this->db->escape_str($this->input->post('api_key')),
                    'id' => $this->db->escape_str($this->input->post('id')),
                ];
                $user = $this->user_model->get_row(['id' => $data_post['api_id'], 'status' => '1']);
                if ($user == false) {
                    $result = ['status' => false, 'data' => 'API ID salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
                if ($user->api_key <> $data_post['api_key']) {
                    $result = ['status' => false, 'data' => 'API KEY salah'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }

                // CHECK ORDER //
                $refill = $this->refill_model->get_row(array('user_id' => $user->id, 'id' => $data_post['id']));
                if ($refill == false) {
                    $result = ['status' => false, 'data' => 'Refill tidak ditemukan'];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                } else {
                    $result = ['status' => true, 'data' => ['status' => $refill->status]];
                    exit(json_encode($result, JSON_PRETTY_PRINT));
                }
            }
        }
    }
    
    public function user_aktif()
{
    header('Content-Type: application/json');

    // Cek apakah parameter email telah diberikan
    if(isset($_GET['email'])) {
        // Ambil nilai email dari parameter
        $email = $_GET['email'];

        // Di sini, Anda bisa melakukan proses pengambilan data dari database
        // Saya akan membuat data contoh untuk keperluan demonstrasi
        $data = [
            [
                "id" => "2066",
                "email" => $email, // Gunakan email dari parameter
                "mac" => "823202185216",
                "tgl_aktivasi" => "2025-06-05",
                "status" => "aktif",
                "keterangan" => "baru",
                "username_tele" => "herusuandana"
            ]
        ];

        // Siapkan hasil untuk dikirimkan
        $result = $data;
    } else {
        // Jika parameter email tidak diberikan, beri respon error
        $result = ['error' => 'Parameter email tidak diberikan'];
    }

    // Mengembalikan response dalam format JSON
    exit(json_encode($result, JSON_PRETTY_PRINT));
}

}
