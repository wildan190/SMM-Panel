<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_api extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_cookie_admin(get_cookie('admin_login'));
		if (admin() == false)
			exit(redirect(base_url('admin/auth/logout')));
		if (admin('level') <> 'owner') {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Akses Tidak Sah!', 'msg' => 'Anda tidak memiliki akses ke halaman tersebut.'));
			exit(redirect(base_url('admin')));
		}
	}
	public function index()
	{
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['api' => $this->api_model->get_rows()]);
	}
	public function api()
	{
		$params = [];
		$result = [];
		$api_service = $this->db->get_where('api_service', ['api_id' => $this->input->post('api')])->row();
		$api_request_param = $this->api_request_param_model->get_rows(['where' => [['api_id' => $this->input->post('api'), 'api_type' => 'service']]]);
		$data_api = $this->api_model->get_by_id($this->input->post('api'));
		foreach ($api_request_param as $row) {
			if ($row['param_type'] === 'custom') {
				$params[$row['param_key']] = $row['param_value'];
			} else {
				if ($row['param_value'] == 'api_id') {
					$params[$row['param_key']] = $data_api->api_id;
				} else if ($row['param_value'] == 'api_key') {
					$params[$row['param_key']] = $data_api->api_key;
				} else if ($row['param_value'] == 'secret_key') {
					$params[$row['param_key']] = $data_api->secret_key;
				}
			}
		}

		$client = new GuzzleHttp\Client();
		$param_key = 'form_params';

		$request = $client->request('POST', $api_service->end_point, [
			$param_key => $params,
		]);

		$data_service = array();

		if ($request->getStatusCode() === 200) {
			$response = $request->getBody()->getContents();
			$json_result = json_decode($response, true);

			if ($api_service->data_service_key <> '-') {
				foreach ($json_result[$api_service->data_service_key] as $key => $value) {
					if (!isset($value[$api_service->category_key])) {
						echo 'Gagal';
					}
					if ($value[$api_service->category_key] == $this->input->post('category')) {
						$price = $value[$api_service->price_key];

						if ($this->input->post('currency') == 'dollar_us') {
							$price = $price * $this->input->post('kurs');
							$kurs = $this->input->post('kurs');
						} else {
							$kurs = 1;
						}

						$profit = $price * convert_percent($this->input->post('profit'));
						$total_price = $price + $profit;

						$value[$api_service->price_key] = $price;
						$value['profit'] = $profit;
						$value['total_price'] = $total_price;

						array_push($result, $value);
					}
				}
			} else {
				$result = [];
				foreach ($json_result as $key => $value) {
					if (!isset($value[$api_service->category_key])) {
						echo 'Gagal';
					}
					if ($value[$api_service->category_key] == $this->input->post('category')) {
						$price = $value[$api_service->price_key];

						if ($this->input->post('currency') == 'dollar_us') {
							$price = $price * $this->input->post('kurs');
							$kurs = $this->input->post('kurs');
						} else {
							$kurs = 1;
						}

						$profit = $price * convert_percent($this->input->post('profit'));
						$total_price = $price + $profit;

						$value[$api_service->price_key] = $price;
						$value['profit'] = $profit;
						$value['total_price'] = $total_price;

						array_push($result, $value);
					}
				}
			}
		}

		$kurs = ($this->input->post('kurs') <> '') ? $this->input->post('kurs') : 1;
		$this->load->view('admin/' . $this->uri->segment(2) . '/result', ['api' => $api_service, 'result' => $result, 'kurs' => $kurs]);
	}

	public function service($id, $kurs, $api_id)
	{
		$params = [];
		$api_service = $this->db->get_where('api_service', ['api_id' => $api_id])->row();
		$api_request_param = $this->api_request_param_model->get_rows(['where' => [['api_id' => $api_id, 'api_type' => 'service']]]);
		$data_api = $this->api_model->get_by_id($api_id);
		foreach ($api_request_param as $row) {
			if ($row['param_type'] === 'custom') {
				$params[$row['param_key']] = $row['param_value'];
			} else {
				if ($row['param_value'] == 'api_id') {
					$params[$row['param_key']] = $data_api->api_id;
				} else if ($row['param_value'] == 'api_key') {
					$params[$row['param_key']] = $data_api->api_key;
				} else if ($row['param_value'] == 'secret_key') {
					$params[$row['param_key']] = $data_api->secret_key;
				}
			}
		}
		$client = new GuzzleHttp\Client();
		$param_key = 'form_params';
		$request = $client->request('POST', $api_service->end_point, [
			$param_key => $params,
		]);
		if ($request->getStatusCode() === 200) {
			$response = $request->getBody()->getContents();
			$json_result = json_decode($response, true);

			if ($api_service->data_service_key <> '-') {
				foreach ($json_result[$api_service->data_service_key] as $key => $value) {
					if (!isset($value[$api_service->service_id_key])) {
						echo 'Gagal';
					}
					if ($value[$api_service->service_id_key] == $id) {
						$value[$api_service->price_key] = $value[$api_service->price_key] * $kurs;
						$result = $value;
					}
				}
			} else {
				$result = [];
				foreach ($json_result as $key => $value) {
					if (!isset($value[$api_service->service_id_key])) {
						echo 'Gagal';
					}
					if ($value[$api_service->service_id_key] == $id) {
						$value[$api_service->price_key] = $value[$api_service->price_key] * $kurs;
						$result = $value;
					}
				}
			}
		}
		$this->load->view('admin/' . $this->uri->segment(2) . '/add_service', ['api' => $api_service, 'result' => $result, 'service_category' => $this->service_category_model->get_rows(), 'api_provider' => $this->api_model->get_rows()]);
	}


	public function add()
	{
		$this->form_validation->set_rules('service_category_id', 'Kategori', 'required|numeric');
		$this->form_validation->set_rules('api_id', 'API', 'required|numeric');
		$this->form_validation->set_rules('api_service_id', 'API ID Layanan', 'required|alpha_numeric_spaces');
		$this->form_validation->set_rules('name', 'Nama', 'required');
		$this->form_validation->set_rules('price', 'Harga', 'required|numeric');
		$this->form_validation->set_rules('profit', 'Keuntungan', 'required|numeric');
		$this->form_validation->set_rules('min', 'Minimal Pesan', 'required|numeric');
		$this->form_validation->set_rules('max', 'Maksimal Pesan', 'required|numeric');
		$this->form_validation->set_rules('type', 'Tipe', 'required|in_list[primary,custom_comments,custom_link]');
		if ($this->form_validation->run() == true) {
			$data_input = [
				'service_category_id' => $this->db->escape_str($this->input->post('service_category_id')),
				'api_id' => $this->db->escape_str($this->input->post('api_id')),
				'api_service_id' => $this->db->escape_str($this->input->post('api_service_id')),
				'name' => $this->db->escape_str($this->input->post('name')),
				'description' => ($this->input->post('description') <> '') ? strip_tags($this->input->post('description')) : '-',
				'price' => $this->db->escape_str($this->input->post('price')) + ($this->db->escape_str($this->input->post('price')) * convert_percent($this->input->post('profit'))),
				'profit' => $this->db->escape_str($this->input->post('price')) * convert_percent($this->input->post('profit')),
				'min' => $this->db->escape_str($this->input->post('min')),
				'max' => $this->db->escape_str($this->input->post('max')),
				'api' => ($this->input->post('api') <> '') ? '1' : '0',
				'type' => $this->db->escape_str($this->input->post('type')),
			];
			// Periksa apakah kedua api_id dan api_service_id sudah ada di database
			if ($this->service_model->get_row(['api_id' => $data_input['api_id'], 'api_service_id' => $data_input['api_service_id']])) {
				$result = array('alert' => 'danger', 'msg' => 'ID Provider untuk API tersebut sudah ada di database.');
			} else {
				$insert_data = $this->service_model->insert($data_input);
				if ($insert_data) {

					$phone = website_config('whatsapp_gateway');
					// Ganti dengan ID grup atau saluran yang ingin Anda tuju
					$chat_id = '-1001284854567';
					$message_thread_id = '216';

					$pesan_tele = '<b>PENAMBAHAN LAYANAN</b>
<b>[+] ' . $insert_data . '</b> - ' . $data_input['name'] . ' - Rp ' . currency($data_input['price']) . '';
					$pesan = '*PENAMBAHAN LAYANAN*
*[+]* ' . $insert_data . ' - ' . $data_input['name'] . ' - Rp ' . currency($data_input['price']) . '';

					$data_service_logs = [
						'service_id' => $insert_data,
						'service_name' => $data_input['name'],
						'before_update' => '0',
						'after_update' => '1',
						'type' => 'insert',
						'created_at' => date('Y-m-d H:i:s')
					];
					$this->service_logs_model->insert($data_service_logs);
					$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
					// $this->lib->sendMessage($apikey, $sender, $phone, $pesan);
					$result = array('alert' => 'success', 'msg' => 'Tambah data berhasil!', 'msg' => 'Data <b>#' . $insert_data . '</b> berhasil ditambahkan.');
				} else {
					$result = array('alert' => 'danger', 'msg' => 'Terjadi kesalahan.');
				}
			}
		} else {
			$result = array('alert' => 'danger', 'msg' => 'Harap isi semua input.');
		}
		$this->load->view('admin/result', $result);
	}
	public function list_category($i)
	{
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');

		$check_api = $this->api_model->get_by_id($i);
		$params = [];
		$api_service = $this->db->get_where('api_service', ['api_id' => $i])->row();
		$api_request_param = $this->api_request_param_model->get_rows(['where' => [['api_id' => $i, 'api_type' => 'service']]]);
		foreach ($api_request_param as $row) {
			if ($row['param_type'] === 'custom') {
				$params[$row['param_key']] = $row['param_value'];
			} else {
				if ($row['param_value'] == 'api_id') {
					$params[$row['param_key']] = $check_api->api_id;
				} else if ($row['param_value'] == 'api_key') {
					$params[$row['param_key']] = $check_api->api_key;
				} else if ($row['param_value'] == 'secret_key') {
					$params[$row['param_key']] = $check_api->secret_key;
				}
			}
		}
		$client = new GuzzleHttp\Client();
		$param_key = 'form_params';

		$request = $client->request('POST', $api_service->end_point, [
			$param_key => $params,
		]);
		$data_service = array();
		if ($request->getStatusCode() === 200) {
			$response = $request->getBody()->getContents();
			$json_result = json_decode($response, true);
			if ($api_service->data_service_key <> '-') {
				$list = '<option value="">Pilih...</option>,';
				foreach ($json_result[$api_service->data_service_key] as $key => $value) {
					if (!isset($value[$api_service->category_key])) {
						$list .= 'Gagal';
					}
					$list .= '<option value="' . $value[$api_service->category_key] . '">' . $value[$api_service->category_key] . '</option>,';
				}
				$result = ['msg' => implode('', array_unique(explode(',', $list)))];
				//print(json_encode($result, JSON_PRETTY_PRINT));
			} else {
				$list = '<option value="">Pilih...</option>,';
				foreach ($json_result as $key => $value) {
					if (!isset($value[$api_service->category_key])) {
						$list .= 'Gagal';
					}
					$list .= '<option value="' . $value[$api_service->category_key] . '">' . $value[$api_service->category_key] . '</option>,';
				}
				$result = ['msg' => implode('', array_unique(explode(',', $list)))];
			}
		}
		$result = ['msg' => implode('', array_unique(explode(',', $list)))];
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
}
