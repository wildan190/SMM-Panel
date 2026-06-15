<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fetch_service extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_cookie_admin(get_cookie('admin_login'));
		if (admin() == false)
			exit(redirect(base_url('admin/auth/logout')));
	}
	public function index()
	{
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['api' => $this->api_model->get_rows()]);
	}
	public function by_category()
	{
		$this->render_admin('admin/' . $this->uri->segment(2) . '/by_category', ['api' => $this->api_model->get_rows(), 'category' => $this->service_category_model->get_rows()]);
	}
	public function api()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('api', 'API', 'required|numeric');
			$this->form_validation->set_rules('currency', 'Mata Uang', 'required');
			$this->form_validation->set_rules('profit_type', 'Tipe Profit', 'required');
			$this->form_validation->set_rules('profit', 'Keuntungan', 'numeric');
			if ($this->form_validation->run() == true) {
				$params = [];
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

// Perbaikan: Cek apakah $json_result adalah array dan tidak kosong
if (!is_array($json_result) || count($json_result) < 1) {
    die('error: Response API tidak valid atau kosong.');
}
					if ($api_service->data_service_key <> '-') {
						foreach ($json_result[$api_service->data_service_key] as $key => $value) {
							if (!isset($value[$api_service->category_key])) {
								print_r($value);
								die;
							}
							$check_category = $this->db->get_where('service_category', ['name' => $value[$api_service->category_key]]);
							$data_category = $check_category->row_array();
							if ($check_category->num_rows() == 0) {
								$category = $value[$api_service->category_key];
								$type = null;
								if ($this->lib->pregmatch('Instagram', $category)) {
									$type = 'Instagram';
								} elseif ($this->lib->pregmatch('Facebook', $category)) {
									$type = 'Facebook';
								} elseif ($this->lib->pregmatch('Twitter', $category)) {
									$type = 'Twitter';
								} elseif ($this->lib->pregmatch('Youtube', $category)) {
									$type = 'Youtube';
								} elseif ($this->lib->pregmatch('Spotify', $category)) {
									$type = 'Spotify';
								} elseif ($this->lib->pregmatch('Telegram', $category)) {
									$type = 'Telegram';
								} elseif ($this->lib->pregmatch('Website Traffic', $category)) {
									$type = 'Website Traffic';
								} elseif ($this->lib->pregmatch('Web Traffic', $category)) {
									$type = 'Website Traffic';
								} elseif ($this->lib->pregmatch('Tiktok', $category)) {
									$type = 'Tiktok';
								} elseif ($this->lib->pregmatch('Tik Tok', $category)) {
									$type = 'Tiktok';
								} elseif ($this->lib->pregmatch('Reviews', $category)) {
									$type = 'Reviews';
								} elseif ($this->lib->pregmatch('Linkedin', $category)) {
									$type = 'Linkedin';
								} elseif ($this->lib->pregmatch('Snapchat', $category)) {
									$type = 'Snapchat';
								} elseif ($this->lib->pregmatch('Twitter', $category)) {
									$type = 'Twitter';
								} elseif ($this->lib->pregmatch('Google', $category)) {
									$type = 'Google';
								} elseif ($this->lib->pregmatch('Twitch', $category)) {
									$type = 'Twitch';
								} else {
									$type = 'Other';
								}
								$insert_category = $this->db->insert('service_category', ['name' => $value[$api_service->category_key], 'type_category' => $type]);
								//$this->lib->print_data($insert_category);
								if ($insert_category == TRUE) {
									$check_data_category = $this->service_category_model->get_row(['name' => $value[$api_service->category_key]]);

									$value[$api_service->category_key] = $check_data_category->id;
								} else {
									$value[$api_service->category_key] = $value[$api_service->category_key];
								}
							} else {
								$value[$api_service->category_key] = $data_category['id'];
								$category_from_api = $value[$api_service->category_key];
							}

							if ($this->input->post('currency') == 'dollar_us') {
								$price = $value[$api_service->price_key] * $this->input->post('kurs');
							} else {
								$price = $value[$api_service->price_key];
							}

							if ($this->input->post('profit_type') == 'persen') {
								$profit = $price * convert_percent($this->input->post('profit'));
							} else {
								$profit = $this->input->post('profit');
							}

							$total_price = $price + $profit;
							$total_profit = $profit;
							$check_service = $this->db->get_where('service', ['api_service_id' => $value[$api_service->service_id_key], 'api_id' => $this->input->post('api')]);
							if ($check_service->num_rows() > 0) {
								$this->db->trans_start();
								$data_update = [
									'service_category_id' => $value[$api_service->category_key],
									'api_id' => $api_service->api_id,
									'api_service_id' => $value[$api_service->service_id_key],
									'name' => $value[$api_service->service_name_key],
									'description' => ($api_service->description_key <> '-') ? strip_tags($value[$api_service->description_key]) : '-',
									'price' => $total_price,
									'profit' => $total_profit,
									'min' => $value[$api_service->min_key],
									'max' => $value[$api_service->max_key],
									'api' => '1',
									'status' => '1',
									'refill' => ($value[$api_service->refill_key] == true ? '1' : '0'),
								];
								$this->db->set($data_update);
								$this->db->where(['api_service_id' => $data_update['api_service_id']]);
								$this->db->update('service');
								$this->db->trans_complete();
								$this->db->error();
								echo "Update Layanan <b>" . $data_update['name'] . "</b> | Harga asli <b>" . $price . "</b>  | + | Profit <b>" . $total_profit . "</b> | Harga akhir <b>" . $total_price . "</b><hr>";
							} else {
								$data_insert = [
									'service_category_id' => $value[$api_service->category_key],
									'api_id' => $api_service->api_id,
									'api_service_id' => $value[$api_service->service_id_key],
									'name' => $value[$api_service->service_name_key],
									'description' => ($api_service->description_key <> '-') ? strip_tags($value[$api_service->description_key]) : '-',
									'price' => $total_price,
									'profit' => $total_profit,
									'min' => $value[$api_service->min_key],
									'max' => $value[$api_service->max_key],
									'api' => '1',
									'status' => '1',
									'refill' => ($value[$api_service->refill_key] == true ? '1' : '0'),

								];
								$this->db->trans_start();
								$this->db->insert('service', $data_insert);
								$this->db->trans_complete();
								$this->db->error();
								echo "Insert Layanan <b>" . $data_insert['name'] . "</b> | Harga asli <b>" . $price . "</b>  | + | Profit <b>" . $total_profit . "</b> | Harga akhir <b>" . $total_price . "</b><hr>";
							}
						}
					} else {
						foreach ($json_result as $key => $value) {
							if (!isset($value[$api_service->category_key])) {
								print_r($json_result);
							}
							//$this->lib->print_data($value);
							$check_category = $this->db->get_where('service_category', ['name' => $value[$api_service->category_key]]);
							$data_category = $check_category->row_array();
							if ($check_category->num_rows() == 0) {
								$category = $value[$api_service->category_key];
								$type = null;
								if ($this->lib->pregmatch('Instagram', $category)) {
									$type = 'Instagram';
								} elseif ($this->lib->pregmatch('Facebook', $category)) {
									$type = 'Facebook';
								} elseif ($this->lib->pregmatch('Twitter', $category)) {
									$type = 'Twitter';
								} elseif ($this->lib->pregmatch('Youtube', $category)) {
									$type = 'Youtube';
								} elseif ($this->lib->pregmatch('Spotify', $category)) {
									$type = 'Spotify';
								} elseif ($this->lib->pregmatch('Telegram', $category)) {
									$type = 'Telegram';
								} elseif ($this->lib->pregmatch('Website Traffic', $category)) {
									$type = 'Website Traffic';
								} elseif ($this->lib->pregmatch('Web Traffic', $category)) {
									$type = 'Website Traffic';
								} elseif ($this->lib->pregmatch('Tiktok', $category)) {
									$type = 'Tiktok';
								} elseif ($this->lib->pregmatch('Tik Tok', $category)) {
									$type = 'Tiktok';
								} elseif ($this->lib->pregmatch('Reviews', $category)) {
									$type = 'Reviews';
								} elseif ($this->lib->pregmatch('Linkedin', $category)) {
									$type = 'Linkedin';
								} elseif ($this->lib->pregmatch('Snapchat', $category)) {
									$type = 'Snapchat';
								} elseif ($this->lib->pregmatch('Twitter', $category)) {
									$type = 'Twitter';
								} elseif ($this->lib->pregmatch('Google', $category)) {
									$type = 'Google';
								} elseif ($this->lib->pregmatch('Twitch', $category)) {
									$type = 'Twitch';
								} else {
									$type = 'Other';
								}
								$insert_category = $this->db->insert('service_category', ['name' => $value[$api_service->category_key], 'type' => 'SosialMedia', 'type_category' => $type]);
								if ($insert_category == TRUE) {
									$check_data_category = $this->service_category_model->get_row(['id' => $insert_category]);

									$value[$api_service->category_key] = $check_data_category->id;
								} else {
									$value[$api_service->category_key] = $value[$api_service->category_key];
								}
							} else {
								$value[$api_service->category_key] = $data_category['id'];
								$category_from_api = $value[$api_service->category_key];
							}

							if ($this->input->post('currency') == 'dollar_us') {
								$price = $value[$api_service->price_key] * $this->input->post('kurs');
							} else {
								$price = $value[$api_service->price_key];
							}

							if ($this->input->post('profit_type') == 'persen') {
								$profit = $price * convert_percent($this->input->post('profit'));
							} else {
								$profit = $this->input->post('profit');
							}

							$total_price = $price + $profit;
							$total_profit = $profit;
							$check_service = $this->db->get_where('service', ['api_service_id' => $value[$api_service->service_id_key], 'api_id' => $this->input->post('api')]);
							if ($check_service->num_rows() > 0) {
								$this->db->trans_start();
								$data_update = [
									'service_category_id' => $value[$api_service->category_key],
									'api_id' => $api_service->api_id,
									'api_service_id' => $value[$api_service->service_id_key],
									'name' => $value[$api_service->service_name_key],
									'description' => ($api_service->description_key <> '-') ? strip_tags($value[$api_service->description_key]) : '-',
									'price' => $total_price,
									'profit' => $total_profit,
									'min' => $value[$api_service->min_key],
									'max' => $value[$api_service->max_key],
									'api' => '1',
									'refill' => ($value[$api_service->refill_key] == true ? '1' : '0'),
								];
								$this->db->set($data_update);
								$this->db->where(['api_service_id' => $data_update['api_service_id']]);
								$this->db->update('service');
								$this->db->trans_complete();
								$this->db->error();
								echo "Update Layanan <b>" . $data_update['name'] . "</b> | Harga asli <b>" . $price . "</b>  | + | Profit <b>" . $total_profit . "</b> | Harga akhir <b>" . $total_price . "</b><hr>";
							} else {
								$data_insert = [
									'service_category_id' => $value[$api_service->category_key],
									'api_id' => $api_service->api_id,
									'api_service_id' => $value[$api_service->service_id_key],
									'name' => $value[$api_service->service_name_key],
									'description' => ($api_service->description_key <> '-') ? strip_tags($value[$api_service->description_key]) : '-',
									'price' => $total_price,
									'profit' => $total_profit,
									'min' => $value[$api_service->min_key],
									'max' => $value[$api_service->max_key],
									'api' => '1',
									'refill' => ($value[$api_service->refill_key] == true ? '1' : '0'),
								];
								$this->db->trans_start();
								$this->db->insert('service', $data_insert);
								$this->db->trans_complete();
								$this->db->error();
								echo "Insert Layanan <b>" . $data_insert['name'] . "</b> | Harga asli <b>" . $price . "</b>  | + | Profit <b>" . $total_profit . "</b> | Harga akhir <b>" . $total_price . "</b><hr>";
							}
						}
					}
				}
			} else {
				echo 'Harap mengisi semua input';
			}
		}
	}
	public function delete($i = '')
	{
		$target = $this->api_order_model->get_row(['api_id' => $i]);
		if ($target == false)
			show_404();
		$delete_target = $this->api_order_model->delete(['api_id' => $i]);
		if ($delete_target) {
			$this->api_request_param_model->delete(['api_id' => $i, 'api_type' => 'order']);
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function get_by_category()
	{
		$params = [];
		$result = [];
		$api_id = $this->input->post('api');
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
		$data_service = array();
		if ($request->getStatusCode() === 200) {
			$response = $request->getBody()->getContents();
			$json_result = json_decode($response, true);

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
