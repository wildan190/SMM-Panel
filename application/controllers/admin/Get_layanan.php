<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get_layanan extends MY_Controller
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
		$result = [];
		$api_id = $this->input->post('api');
		$api_service = $this->db->get_where('api_service', ['api_id' => $api_id])->row();
		$data_api = $this->db->get_where('api', ['id' => $api_id])->row();

		$file_path = FCPATH . 'provider/' . $api_id . '.json';

		if (file_exists($file_path)) {
			$json_result = file_get_contents($file_path);
			$json_result = json_decode($json_result, true);

			if ($json_result) {

				if ($api_service->data_service_key !== '-') {
					foreach ($json_result[$api_service->data_service_key] as $key => $value) {
						if (!isset($value[$api_service->category_key])) {
							echo 'Gagal mengambil data Service dari file JSON';
						}
						if ($value[$api_service->category_key] == $this->input->post('category')) {
							$price = $value[$api_service->price_key];

							if ($data_api->kurs == 'USD') {
								$price = $price * $data_api->rate;
							}

							if ($data_api->profit_type == 'persen') {
								$profit = $price * convert_percent($data_api->profit);
							} else {
								$profit = $price + $data_api->profit;
							}

							$total_price = $price + $profit;

							$value[$api_service->price_key] = $price;
							$value['profit'] = $profit;
							$value['total_price'] = $total_price;

							array_push($result, $value);
						}
					}
				} else {
					foreach ($json_result as $key => $value) {
						if (!isset($value[$api_service->category_key])) {
							echo 'Gagal mengambil data Service dari file JSON';
						}
						if ($value[$api_service->category_key] == $this->input->post('category')) {
							$price = $value[$api_service->price_key];

							if ($data_api->kurs == 'USD') {
								$price = $price * $data_api->rate;
							}

							if ($data_api->profit_type == 'persen') {
								$profit = $price * convert_percent($data_api->profit);
							} else {
								$profit = $price + $data_api->profit;
							}

							$total_price = $price + $profit;

							$value[$api_service->price_key] = $price;
							$value['profit'] = $profit;
							$value['total_price'] = $total_price;

							array_push($result, $value);
						}
					}
				}
			}
		} else {
			exit("File not found");
		}
		$this->load->view('admin/' . $this->uri->segment(2) . '/result', ['api' => $api_service, 'data_api' => $data_api, 'result' => $result]);
	}

	public function service($id, $kurs, $api_id)
	{
		$api_service = $this->db->get_where('api_service', ['api_id' => $api_id])->row();
		$data_api = $this->api_model->get_by_id($api_id);

		$file_path = FCPATH . 'provider/' . $api_id . '.json';

		if (file_exists($file_path)) {
			$json_result = file_get_contents($file_path);
			$json_result = json_decode($json_result, true);

			if ($json_result) {
				$result = [];

				if ($api_service->data_service_key !== '-') {
					foreach ($json_result[$api_service->data_service_key] as $key => $value) {
						if (!isset($value[$api_service->service_id_key])) {
							echo 'Gagal';
						}
						if ($value[$api_service->service_id_key] == $id) {
							$price = $value[$api_service->price_key];

							if ($data_api->kurs == 'USD') {
								$price = $value[$api_service->price_key] * $kurs;
							}


							$value[$api_service->price_key] = $price;
							$result = $value;
						}
					}
				} else {
					foreach ($json_result as $key => $value) {
						if (!isset($value[$api_service->service_id_key])) {
							echo 'Gagal';
						}
						if ($value[$api_service->service_id_key] == $id) {
							$price = $value[$api_service->price_key];

							if ($data_api->kurs == 'USD') {
								$price = $value[$api_service->price_key] * $kurs;
							}


							$value[$api_service->price_key] = $price;
							$result = $value;
						}
					}
				}
			}
		} else {
			exit("File not found");
		}

		$this->load->view('admin/' . $this->uri->segment(2) . '/add_service', ['api' => $api_service, 'data_api' => $data_api, 'result' => $result, 'service_category' => $this->service_category_model->get_rows(), 'api_provider' => $this->api_model->get_rows()]);
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
				'price' => $this->db->escape_str($this->input->post('price')),
				'profit' => $this->db->escape_str($this->input->post('profit')),
				'min' => $this->db->escape_str($this->input->post('min')),
				'max' => $this->db->escape_str($this->input->post('max')),
				'api' => ($this->input->post('api') <> '') ? '1' : '0',
				'refill' => ($this->input->post('refill') <> '') ? '0' : '1',
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
		if ($this->input->get($this->security->get_csrf_token_name()) !== $this->security->get_csrf_hash()) {
			exit("No direct script access allowed");
		}

		header('Content-Type: application/json');

		$file_path = FCPATH . 'provider/' . $i . '.json';

		if (file_exists($file_path)) {
			$json_result = file_get_contents($file_path);
			$json_result = json_decode($json_result, true);

			if ($json_result) {
				$list = '<option value="">Pilih...</option>,';

				$api_service = $this->db->get_where('api_service', ['api_id' => $i])->row();
				$api = $this->db->get_where('api', ['id' => $i])->row();

				if ($api_service && $api_service->data_service_key !== '-') {
					foreach ($json_result[$api_service->data_service_key] as $key => $value) {
						if (!isset($value[$api_service->category_key])) {
							$list .= 'Gagal';
						}
						$list .= '<option value="' . $value[$api_service->category_key] . '">' . $value[$api_service->category_key] . '</option>,';
					}
				} else {
					foreach ($json_result as $key => $value) {
						if (!isset($value[$api_service->category_key])) {
							$list .= 'Gagal';
						}
						$list .= '<option value="' . $value[$api_service->category_key] . '">' . $value[$api_service->category_key] . '</option>,';
					}
				}

				$result = ['msg' => implode('', array_unique(explode(',', $list))), 'profit' => $api->profit, 'kurs' => $api->rate, 'currency' => $api->kurs];
				exit(json_encode($result, JSON_PRETTY_PRINT));
			}
		} else {
			exit("File not found");
		}
	}
	public function by_category()
	{
		$this->render_admin('admin/' . $this->uri->segment(2) . '/by_category', ['api' => $this->api_model->get_rows(), 'category' => $this->service_category_model->get_rows()]);
	}
	public function get_by_category()
	{
		$result = [];
		$api_id = $this->input->post('api');
		$api_service = $this->db->get_where('api_service', ['api_id' => $api_id])->row();
		$data_api = $this->api_model->get_by_id($api_id);

		$file_path = FCPATH . 'provider/' . $api_id . '.json';
		if (file_exists($file_path)) {
			$json_result = file_get_contents($file_path);
			$json_result = json_decode($json_result, true);

			if ($api_service->data_service_key <> '-') {
				foreach ($json_result[$api_service->data_service_key] as $key => $value) {
					if (!isset($value[$api_service->category_key])) {
						echo 'Gagal';
					}
					if ($value[$api_service->category_key] == $this->input->post('category_api')) {
						$category = $this->service_category_model->get_row(['id' => $this->input->post('category_web')]);
						if ($category == false)
							echo 'Kategori tidak ada';

						if ($this->input->post('currency') == 'dollar_us') {
							$price = $value[$api_service->price_key] * $this->input->post('kurs');
						} else {
							$price = $value[$api_service->price_key];
						}

						if ($this->input->post('profit_type') == 'persen') {
							$profit_member = $price * convert_percent($this->input->post('profit_member'));
						} else {
							$profit_member = $this->input->post('profit_member');
						}

						$check_service = $this->db->get_where('service', ['api_service_id' => $value[$api_service->service_id_key], 'api_id' => $api_id]);
						$name = $value[$api_service->service_name_key];
						$data = $this->replace_keyword_model->get_rows();
						foreach ($data as $key => $changing) {
							$name = strtr($name, [
								$changing['name'] => $changing['target'],
							]);
						}
						if ($check_service->num_rows() > 0) {
							$this->db->trans_start();

							$data_update = [
								'service_category_id' => $category->id,
								'api_id' => $api_service->api_id,
								'api_service_id' => $value[$api_service->service_id_key],
								'name' => $name,
								'description' => ($api_service->description_key <> '-') ? strip_tags($value[$api_service->description_key]) : '-',
								'price' => $price + $profit_member,
								'profit' => $profit_member,
								'min' => $value[$api_service->min_key],
								'max' => $value[$api_service->max_key],
								'api' => '1',
								'type' => ($value['type'] == 'Custom Comments' || $value['type'] == 'Custom Comments Package') ? 'custom_comments' : 'primary',
								'refill' => ($value['refill'] == true ? '1' : '0'),
								'masa_refill' => '0',
							];
							$this->db->set($data_update);
							$this->db->where(['api_service_id' => $data_update['api_service_id'], 'api_id' => $api_id]);
							$this->db->update('service');
							$this->db->trans_complete();
							$this->db->error();
							echo "<span style=\"color:green\" class=\"fw-bold\">[ UPDATE ]</span> Layanan " . $data_update['name'] . " | DONE ! HARGA PUSAT: Rp " . currency($price) . " -  HARGA MEMBER: Rp " . currency($data_update['price']) . "<br> ";
						} else {
							$data_insert = [
								'service_category_id' => $category->id,
								'api_id' => $api_service->api_id,
								'api_service_id' => $value[$api_service->service_id_key],
								'name' => $name,
								'description' => ($api_service->description_key <> '-') ? strip_tags($value[$api_service->description_key]) : '-',
								'price' => $price + $profit_member,
								'profit' => $profit_member,
								'min' => $value[$api_service->min_key],
								'max' => $value[$api_service->max_key],
								'api' => '1',
								'type' => ($value['type'] == 'Custom Comments' || $value['type'] == 'Custom Comments Package') ? 'custom_comments' : 'primary',
								'refill' => ($value['refill'] == true ? '1' : '0'),
							];
							$this->db->trans_start();
							$gas = $this->service_model->insert($data_insert);
							if ($gas == true) {
								echo "<span style=\"color:green\" class=\"fw-bold\">[ BERHASIL ]</span> Layanan " . $data_insert['name'] . " | DONE ! PRICE PUSAT: Rp " . currency($price) . " -  PRICE MEMBER: Rp " . currency($data_insert['price']) . "<br>======================================<br>";
							}
							$this->db->trans_complete();
							$this->db->error();
						}
					}
				}
			} else {
				$result = [];
				foreach ($json_result as $key => $value) {
					if (!isset($value[$api_service->category_key])) {
						echo 'Gagal';
					}
					if ($value[$api_service->category_key] == $this->input->post('category_api')) {
						$category = $this->service_category_model->get_row(['id' => $this->input->post('category_web')]);

						if ($this->input->post('currency') == 'dollar_us') {
							$price = $value[$api_service->price_key] * $this->input->post('kurs');
						} else {
							$price = $value[$api_service->price_key];
						}

						if ($this->input->post('profit_type') == 'persen') {
							$profit_member = $price * convert_percent($this->input->post('profit_member'));
						} else {
							$profit_member = $this->input->post('profit_member');
						}
						$service = $value[$api_service->service_name_key];
						$name = $value[$api_service->service_name_key];
						$data = $this->replace_keyword_model->get_rows();
						foreach ($data as $key => $changing) {
							$name = strtr($name, [
								$changing['name'] => $changing['target'],
							]);
						}
						$check_service = $this->db->get_where('service', ['api_service_id' => $value[$api_service->service_id_key], 'api_id' => $api_id]);
						if ($check_service->num_rows() > 0) {
							$this->db->trans_start();
							$data_update = [
								'service_category_id' => $category->id,
								'api_id' => $api_service->api_id,
								'api_service_id' => $value[$api_service->service_id_key],
								'name' => $name,
								'description' => ($api_service->description_key <> '-') ? strip_tags($value[$api_service->description_key]) : '-',
								'price' => $price + $profit_member,
								'profit' => $profit_member,
								'min' => $value[$api_service->min_key],
								'max' => $value[$api_service->max_key],
								'api' => '1',
								'type' => ($value['type'] == 'Custom Comments' || $value['type'] == 'Custom Comments Package') ? 'custom_comments' : 'primary',
								'refill' => ($value['refill'] == true ? '1' : '0')
							];
							$this->db->set($data_update);
							$this->db->where(['api_service_id' => $data_update['api_service_id'], 'api_id' => $api_id]);
							$this->db->update('service');
							$this->db->trans_complete();
							$this->db->error();
							echo "<span style=\"color:green\" class=\"fw-bold\">[ UPDATE ]</span> Layanan " . $data_update['name'] . " | DONE ! PRICE PUSAT: Rp " . currency($price) . " -  PRICE MEMBER: Rp " . currency($data_update['price']) . "<br>======================================<br>";
						} else {
							$data_insert = [
								'service_category_id' => $category->id,
								'api_id' => $api_service->api_id,
								'api_service_id' => $value[$api_service->service_id_key],
								'name' => $name,
								'description' => ($api_service->description_key <> '-') ? strip_tags($value[$api_service->description_key]) : '-',
								'price' => $price + $profit_member,
								'profit' => $profit_member,
								'min' => $value[$api_service->min_key],
								'max' => $value[$api_service->max_key],
								'api' => '1',
								'type' => ($value['type'] == 'Custom Comments' || $value['type'] == 'Custom Comments Package') ? 'custom_comments' : 'primary',
								'refill' => ($value['refill'] == true ? '1' : '0')
							];
							$this->db->trans_start();
							$this->db->insert('service', $data_insert);
							$this->db->trans_complete();
							$this->db->error();
							echo "<span style=\"color:green\" class=\"fw-bold\">[ INSERT ]</span> Layanan " . $data_insert['name'] . " | DONE ! PRICE PUSAT: Rp " . currency($price) . " -  PRICE MEMBER: Rp " . currency($data_insert['price']) . "<br>======================================<br>";
						}
					}
				}
			}
		}
	}
}
