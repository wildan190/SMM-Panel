<?php
ini_set('memory_limit', '7000M');
ini_set('max_execution_time', 300); // 300 seconds = 5 minutes
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (website_config('mt_web') == 1) {
			redirect(base_url('maintenance'));
		}
		check_cookie(get_cookie('smm_login'));
		if (!user()) {
			redirect(base_url('auth/logout'));
		}
	}

	public function neworder()
	{
		$this->render('public/order/neworder', ['page_type' => 'Pesanan Baru']);
	}

	public function page()
	{
		$this->load->view('public/order/page');
	}

	public function tesangka()
	{
		$nominal = 100000;
		$hitung = $nominal * 1 / website_config('referral_rate');
		echo $hitung;
	}

	public function single()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('service', 'Layanan', 'required|numeric');
			$this->form_validation->set_rules('target', 'Target', 'required');
			$this->form_validation->set_rules('quantity', 'Jumlah Pesan', 'required|numeric');

			if ($this->form_validation->run() === true) {
				$service = $this->service_model->get_row(['id' => $this->input->post('service'), 'status' => '1']);

				if (!$service) {
					$this->session->set_flashdata('prev_input', $this->input->post());
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia.']);
					redirect(base_url('order/single'));
				}

				$data_input = [
					'user_id' => user(),
					'service_id' => $service->id,
					'target' => $this->db->escape_str($this->input->post('target')),
					'quantity' => $this->db->escape_str($this->input->post('quantity')),
					'price' => 0,
					'profit' => 0,
					'status' => 'Pending',
					'is_refill' => 0,
					'is_api' => 0,
					'is_refund' => 0,
					'api_id' => 0,
					'api_order_id' => 0,
					'api_log_order' => null,
					'start_count' => 0,
					'ip_address' => $this->input->ip_address(),
					'custom_comments' => ($service->type == 'custom_comments' && $this->input->post('custom_comments')) ? $this->input->post('custom_comments') : (($this->input->post('username')) ? $this->input->post('username') : $this->input->post('custom_comments')),
					'custom_link' => ($service->type == 'custom_comments' && $this->input->post('custom_comments')) ? '' : (($this->input->post('comments')) ? $this->input->post('comments') : $this->input->post('custom_link')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					'next_refill' => date('Y-m-d H:i:s', time() + (60 * 60 * 24)),
					'uplink' => user('uplink'),
				];

				if ($service->refill == '1') {
					$data_input['is_refill'] = '1';
				}
				$data_input['service'] = $service->name;

				if (website_config('limit_order') > 0) {
					if ($this->order_model->get_count(['where' => [['user_id' => user(), 'target' => $data_input['target']], "status IN ('Pending', 'Processing')"]]) >= website_config('limit_order')) {
						$this->session->set_flashdata('prev_input', $this->input->post());
						$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Mohon menunggu sampai pesanan sebelumnya dengan target yang sama selesai diproses.']);
						redirect(base_url('order/single'));
					}
				}

				if ($service->type == 'custom_comments') {
					$data_input['quantity'] = $service->max == '1' ? '1' : count(explode("\n", $data_input['custom_comments']));
				}

				if ($data_input['quantity'] < $service->min) {
					$this->session->set_flashdata('prev_input', $this->input->post());
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Minimal pesanan ' . $service->min . '.']);
					redirect(base_url('order/single'));
				} elseif ($data_input['quantity'] > $service->max) {
					$this->session->set_flashdata('prev_input', $this->input->post());
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Maksimal pesanan ' . $service->max . '.']);
					redirect(base_url('order/single'));
				}

				$data_input['price'] = $service->max == '1' ? $data_input['quantity'] * $service->price : $data_input['quantity'] * ($service->price / 1000);
				$data_input['profit'] = $service->max == '1' ? $data_input['quantity'] * $service->profit : $data_input['quantity'] * ($service->profit / 1000);

				$custom_price = $this->custom_price_model->get_row(['service_id' => $data_input['service_id'], 'user_id' => user()]);
				if ($custom_price) {
					$data_input['price'] = $service->max == '1' ? $data_input['quantity'] * $custom_price->price : $data_input['quantity'] * ($custom_price->price / 1000);
					$data_input['profit'] = $service->max == '1' ? $data_input['quantity'] * $custom_price->profit : $data_input['quantity'] * ($custom_price->profit / 1000);
				}

				if (user('balance') < $data_input['price']) {
					$this->session->set_flashdata('prev_input', $this->input->post());
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Sisa saldo Anda tidak cukup untuk membuat pesanan ini.']);
					redirect(base_url('order/single'));
				}

				$api = $this->api_model->get_by_id($service->api_id);
				if (!$api) {
					$this->session->set_flashdata('prev_input', $this->input->post());
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia.']);
					redirect(base_url('order/single'));
				}
				$data_input['api_id'] = $api->id;

				$provider_order_id = false;
				if ($api->is_manual == '1') {
					$provider_order_id = true;
				} else {
					$api_order = $this->api_order_model->get_row(['api_id' => $service->api_id]);
					if (!$api_order) {
						$this->session->set_flashdata('prev_input', $this->input->post());
						$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia.']);
						redirect(base_url('order/single'));
					}

					$params = [];
					$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $service->api_id, 'api_type' => 'order']);
					if (!empty($api_request_param)) {
						foreach ($api_request_param->result_array() as $row) {
							if ($row['param_type'] === 'custom') {
								$params[$row['param_key']] = $row['param_value'];
							} else {
								if ($service->type !== 'primary') {
									if (in_array($row['param_value'], ['custom_comment', 'custom_comments', 'comments', 'comment']) && $service->type == 'custom_comments') {
										$params[$row['param_key']] = str_replace("\n", "\r\n", str_replace("\r\n", "\n", $data_input['custom_comments']));
									} else if (in_array($row['param_value'], ['custom_link', 'custom_links']) && $service->type == 'custom_link') {
										$params[$row['param_key']] = $data_input['custom_link'];
									}
								}

								switch ($row['param_value']) {
									case 'service_id':
										$params[$row['param_key']] = $service->api_service_id;
										break;
									case 'target':
										$params[$row['param_key']] = $data_input['target'];
										break;
									case 'quantity':
										$params[$row['param_key']] = $data_input['quantity'];
										break;
									case 'api_id':
										$params[$row['param_key']] = $api->api_id;
										break;
									case 'api_key':
										$params[$row['param_key']] = $api->api_key;
										break;
									case 'secret_key':
										$params[$row['param_key']] = $api->secret_key;
										break;
									case 'username':
										$params[$row['param_key']] = $this->db->escape_str($this->input->post('username'));
										break;
									case 'usernames':
										$params[$row['param_key']] = $this->db->escape_str($this->input->post('usernames'));
										break;
									case 'hashtags':
										$params[$row['param_key']] = $this->db->escape_str($this->input->post('hashtags'));
										break;
									case 'hashtag':
										$params[$row['param_key']] = $this->db->escape_str($this->input->post('hashtag'));
										break;
									case 'media':
										$params[$row['param_key']] = $this->db->escape_str($this->input->post('media'));
										break;
									case 'answer_number':
										$params[$row['param_key']] = $this->db->escape_str($this->input->post('answer_number'));
										break;
									case 'groups':
										$params[$row['param_key']] = $this->db->escape_str($this->input->post('groups'));
										break;
									case 'comments':
									case 'custom_comments':
									case 'custom_comment':
									case 'comment':
										if ($service->type == 'Comment Replies') {
											$params[$row['param_key']] = str_replace("\n", "\r\n", str_replace("\r\n", "\n", $this->input->post('comments')));
										} else if ($service->type == 'custom_comments') {
											$params[$row['param_key']] = str_replace("\n", "\r\n", str_replace("\r\n", "\n", $data_input['custom_comments']));
										}
										break;
								}
							}
						}

						$client = new GuzzleHttp\Client();
						try {
							$request = $client->request('POST', $api_order->end_point, [
								'form_params' => $params,
								'headers' => ['Accept' => 'application/json'],
								'timeout' => 30, // Tambahkan timeout
							]);

							$response = $request->getBody()->getContents();
							$json_result = json_decode($response, true);
							
							if ($request->getStatusCode() === 200) {
								$provider_order_id = $json_result['order'] ?? search_key($json_result, $api_order->order_id_key);
								if ($provider_order_id) {
									$data_input['api_order_id'] = $provider_order_id;
								} else {
									$error_msg = $json_result['error'] ?? ($json_result['message'] ?? 'Respon provider tidak valid.');
									$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Pesan dari Provider: ' . $error_msg]);
								}
								$data_input['api_log_order'] = $this->db->escape($response);
							} else {
								$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Provider mengembalikan status code: ' . $request->getStatusCode()]);
							}
						} catch (Exception $e) {
							log_message('error', 'Guzzle Error: ' . $e->getMessage());
							$this->session->set_flashdata('prev_input', $this->input->post());
							$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Gagal terhubung ke provider. Silakan coba beberapa saat lagi.']);
							redirect(base_url('order/single'));
						}
					}
				}

				if ($provider_order_id) {
					$saldo_awal = $this->user_model->get_by_id(user());
					$this->db->trans_start();
					$this->user_model->update(['balance' => user('balance') - $data_input['price']], ['id' => user()]);
					$insert_order = $this->order_model->insert($data_input);

					$this->log_balance_usage_model->insert([
						'user_id' => user(),
						'type' => 'minus',
						'category' => 'place order',
						'amount' => $data_input['price'],
						'description' => 'Melakukan pemesanan #' . $insert_order . '.',
						'before' => $saldo_awal->balance,
						'after' => $saldo_awal->balance - $data_input['price'],
						'created_at' => date('Y-m-d H:i:s')
					]);
					$this->db->trans_complete();

					if ($this->db->trans_status() === true) {
						$this->session->set_userdata('last_category_id', $service->category_id);
						$this->session->set_userdata('last_service_id', $service->id);
						$this->session->set_flashdata('prev_input', array_merge($this->input->post(), ['category_id' => $service->category_id]));
						$this->session->set_flashdata('alert', [
							'alert' => 'success',
							'title' => '<b>Gotcha! Pesanan anda berhasil di buat</b>',
							'msg' => '<br>Berikut detail pesanan Anda:
                                <ul class="mb-0" style="padding-left: 0.80rem !important;">
                                    <li>
                                        <span class="text-break"><b>ID Pesanan: </b>' . $insert_order . '</span>
                                    </li>
                                    <li>
                                        <span class="text-break"><b>Layanan: </b>' . $service->name . '</span>
                                    </li>
                                    <li>
                                        <span class="text-break"><b>Target: </b>' . $data_input['target'] . '</span>
                                    </li>
                                    <li>
                                        <span class="text-break"><b>Jumlah: </b>' . $data_input['quantity'] . '</span>
                                    </li>
                                </ul>'
						]);
						$this->session->set_flashdata('swalalert', ['alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Pesanan <b>#' . $insert_order . '</b> berhasil dibuat.']);
					} else {
						log_message('error', json_encode($data_input));
						$this->session->set_flashdata('swalalert', ['alert' => 'danger', 'title' => 'Ups!', 'msg' => 'Terjadi kesalahan tidak terduga.']);
					}
					redirect(base_url('order/single'));
				} else {
					// Tidak lagi menonaktifkan layanan secara otomatis untuk menghindari false positive (seperti salah target atau saldo provider habis)
					if (!$this->session->flashdata('result')) {
						$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan saat memproses pesanan ke provider.']);
					}
					redirect(base_url('order/single'));
				}
			} else {
				$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => validation_errors()]);
			}
		}
		
		// Mendapatkan tanggal hari ini
        $datenow = date('Y-m-d');
        
        // Filter berdasarkan tanggal dan status
        $this->db->where('DATE(created_at)', $datenow);
        $this->db->where_in('status', ['Pending', 'Processing', 'Success']); // Memfilter berdasarkan status
        
        $cek_user_checkout = $this->db->get('order_list');
        $purchases = [];
        
        if ($cek_user_checkout->num_rows() > 0) {
            foreach ($cek_user_checkout->result() as $row) {
                // Mendapatkan nama pengguna berdasarkan user_id
                $this->db->select('full_name');
                $this->db->where('id', $row->user_id);
                $cek_username = $this->db->get('user')->row_array();
        
                // Menyusun hasil
                $result = [
                    'user_checkout' => isset($cek_username['full_name']) ? $cek_username['full_name'] : 'Unknown User',
                    'product' => urldecode($row->service),
                    'qty' => number_format($row->quantity, 0, ',', '.'),
                    'price' => number_format($row->price, 0, ',', '.'),
                    'status' => $row->status, // Menambahkan status,
                ];
                $purchases[] = $result;
            }
        }

		$this->render('public/order/single', [
			'page_type' => 'Pesanan Baru',
			'service' => $this->service_model->get_row(['id' => $this->input->post('service'), 'status' => '1']),
			'category_favorit' => $this->service_favorit_model->get_category_favorit(['user_id' => user()]),
			'service_category' => $this->service_category_model->get_rows(['order_by' => 'name ASC']),
            'purchases' => $purchases
		]);
	}

		public function massal()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('service', 'Layanan', 'required|numeric');
			$this->form_validation->set_rules('data_order', 'Target|Jumlah Pesan', 'required');

			if ($this->form_validation->run() === true) {
				$data_input = [
					'service_id' => $this->db->escape_str($this->input->post('service')),
					'data_order' => $this->db->escape_str(strip_tags($this->input->post('data_order'))),
				];

				$service = $this->service_model->get_row(['id' => $data_input['service_id'], 'status' => '1']);
				if (!$service) {
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia.']);
					redirect(base_url('order/massal'));
				}

				if ($service->type !== 'primary') {
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan ini tidak dapat dipesan melalui halaman ini.']);
					redirect(base_url('order/massal'));
				}

				$api = $this->api_model->get_by_id($service->api_id);
				if (!$api) {
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia.']);
					redirect(base_url('order/massal'));
				}
				$data_input['api_id'] = $api->id;

				$api_order = $this->api_order_model->get_row(['api_id' => $service->api_id]);
				if (!$api_order && $api->is_manual == '0') {
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia.']);
					redirect(base_url('order/massal'));
				}

				$data_order_row = explode("\r\n", str_replace('\r\n', "\r\n", $data_input['data_order']));
				if (count($data_order_row) > 10) {
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Maksimal 10 baris perintah.']);
					redirect(base_url('order/massal'));
				}

				$result = '';
				foreach ($data_order_row as $value) {
					$data_order = explode("|", $value);
					if (count($data_order) !== 2 || !is_numeric($data_order[1])) {
						$result .= $value . ' = Gagal (Format salah).<br />';
						continue;
					}

					$data_input_order = [
						'user_id' => user(),
						'service_id' => $data_input['service_id'],
						'service' => $service->name,
						'target' => $data_order[0],
						'quantity' => $data_order[1],
						'price' => 0,
						'profit' => 0,
						'status' => 'Pending',
						'is_api' => 0,
						'is_refund' => 0,
						'is_refill' => $service->refill,
						'api_id' => $api->id,
						'api_order_id' => 0,
						'api_log_order' => null,
						'ip_address' => $this->input->ip_address(),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
						'next_refill' => date('Y-m-d H:i:s', time() + (60 * 60 * 24)),
						'uplink' => user('uplink'),
					];

					if (website_config('limit_order') > 0) {
						if ($this->order_model->get_count(['where' => [['user_id' => user(), 'target' => $data_input_order['target']], "status IN ('Pending', 'Processing')"]]) >= website_config('limit_order')) {
							$result .= $value . ' = Gagal (Limit pemesanan).<br />';
							continue;
						}
					}

					if ($data_order[1] < $service->min) {
						$result .= $value . ' = Gagal (Jumlah Minimal Pesanan tidak sesuai).<br />';
						continue;
					} elseif ($data_order[1] > $service->max) {
						$result .= $value . ' = Gagal (Jumlah Maksimal Pesanan tidak sesuai).<br />';
						continue;
					}

					$data_input_order['price'] = $service->max == '1' ? $data_input_order['quantity'] * $service->price : $data_input_order['quantity'] * ($service->price / 1000);
					$data_input_order['profit'] = $service->max == '1' ? $data_input_order['quantity'] * $service->profit : $data_input_order['quantity'] * ($service->profit / 1000);

					$custom_price = $this->custom_price_model->get_row(['service_id' => $data_input_order['service_id'], 'user_id' => user()]);
					if ($custom_price) {
						$data_input_order['price'] = $service->max == '1' ? $data_input_order['quantity'] * $custom_price->price : $data_input_order['quantity'] * ($custom_price->price / 1000);
						$data_input_order['profit'] = $service->max == '1' ? $data_input_order['quantity'] * $custom_price->profit : $data_input_order['quantity'] * ($custom_price->profit / 1000);
					}

					if (user('balance') < $data_input_order['price']) {
						$result .= $value . ' = Gagal (Saldo tidak cukup).<br />';
						continue;
					}

					$provider_order_id = false;
					if ($api->is_manual == '1') {
						$provider_order_id = true;
					} else {
						$params = [];
						$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $service->api_id, 'api_type' => 'order']);
						if (!empty($api_request_param)) {
							foreach ($api_request_param->result_array() as $row) {
								if ($row['param_type'] === 'custom') {
									$params[$row['param_key']] = $row['param_value'];
								} else {
									switch ($row['param_value']) {
										case 'service_id':
											$params[$row['param_key']] = $service->api_service_id;
											break;
										case 'target':
											$params[$row['param_key']] = $data_input_order['target'];
											break;
										case 'quantity':
											$params[$row['param_key']] = $data_input_order['quantity'];
											break;
										case 'api_id':
											$params[$row['param_key']] = $api->api_id;
											break;
										case 'api_key':
											$params[$row['param_key']] = $api->api_key;
											break;
										case 'secret_key':
											$params[$row['param_key']] = $api->secret_key;
											break;
									}
								}
							}

							$client = new GuzzleHttp\Client();
							try {
								$request = $client->request('POST', $api_order->end_point, [
									'form_params' => $params,
									'headers' => ['Accept' => 'application/json'],
								]);

								if ($request->getStatusCode() === 200) {
									$response = $request->getBody()->getContents();
									$json_result = json_decode($response, true);
									$provider_order_id = search_key($json_result, $api_order->order_id_key);
									if ($provider_order_id) {
										$data_input_order['api_order_id'] = $provider_order_id;
									} else {
										$error_msg = $json_result['error'] ?? ($json_result['message'] ?? 'Respon provider tidak valid.');
										$result .= $value . ' = Gagal (Pesan dari Provider: ' . $error_msg . ').<br />';
									}
									$data_input_order['api_log_order'] = $this->db->escape($response);
								} else {
									$result .= $value . ' = Gagal (Provider mengembalikan status code: ' . $request->getStatusCode() . ').<br />';
								}
							} catch (Exception $e) {
								log_message('error', 'Mass Guzzle Error: ' . $e->getMessage());
								$result .= $value . ' = Gagal (Gagal terhubung ke provider).<br />';
							}
						}
					}

					if ($provider_order_id) {
						$saldo_awal = $this->user_model->get_by_id(user());
						$this->db->trans_start();
						$this->user_model->update(['balance' => user('balance') - $data_input_order['price']], ['id' => user()]);
						$insert_order = $this->order_model->insert($data_input_order);

						$this->log_balance_usage_model->insert([
							'user_id' => user(),
							'type' => 'minus',
							'category' => 'place order',
							'amount' => $data_input_order['price'],
							'description' => 'Melakukan pemesanan #' . $insert_order . '.',
							'before' => $saldo_awal->balance,
							'after' => $saldo_awal->balance - $data_input_order['price'],
							'created_at' => date('Y-m-d H:i:s')
						]);
						$this->db->trans_complete();

						if ($this->db->trans_status() === true) {
							$this->session->set_userdata('last_category_id', $service->category_id);
							$this->session->set_userdata('last_service_id', $service->id);
							$result .= $value . ' = Berhasil (ID Pesanan: ' . $insert_order . ').<br />';
						} else {
							log_message('error', json_encode($data_input_order));
							$result .= $value . ' = Gagal (Terjadi kesalahan tidak terduga).<br />';
						}
					} else {
						// Tidak lagi menonaktifkan layanan secara otomatis
						if (!strpos($result, $value)) {
							$result .= $value . ' = Gagal (Terjadi kesalahan saat memproses pesanan).<br />';
						}
					}
				}

				$this->session->set_flashdata('result', ['alert' => 'success', 'title' => 'Perintah berhasil!', 'msg' => $result]);
				redirect(base_url('order/massal'));
			} else {
				$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()]);
			}
		}

		// --- LOGIKA LIVE ORDER UNTUK HALAMAN MASSAL ---
		$datenow = date('Y-m-d');
		$this->db->where('DATE(created_at)', $datenow);
		$this->db->where_in('status', ['Pending', 'Processing', 'Success']);
		
		$cek_user_checkout = $this->db->get('order_list');
		$purchases = [];
		
		if ($cek_user_checkout->num_rows() > 0) {
			foreach ($cek_user_checkout->result() as $row) {
				$this->db->select('full_name');
				$this->db->where('id', $row->user_id);
				$cek_username = $this->db->get('user')->row_array();
		
				$result = [
					'user_checkout' => isset($cek_username['full_name']) ? $cek_username['full_name'] : 'Unknown User',
					'product' => urldecode($row->service),
					'qty' => number_format($row->quantity, 0, ',', '.'),
					'price' => number_format($row->price, 0, ',', '.'),
					'status' => $row->status,
				];
				$purchases[] = $result;
			}
		}
		// --- END LOGIKA LIVE ORDER ---

		$this->render('public/order/massal', [
			'page_type' => 'Pesanan Massal',
			'category_favorit' => $this->service_favorit_model->get_category_favorit(['user_id' => user()]),
			'service_category' => $this->service_category_model->get_rows(['order_by' => 'name ASC']),
			'purchases' => $purchases // Mengirim data live order ke view
		]);
	}
					
	public function refill($i = '', $csrf = '')
	{
		if ($csrf !== $this->security->get_csrf_hash()) {
			show_404();
		}

		$i = $this->db->escape_str($i);
		$target = $this->order_model->get_row(['user_id' => user(), 'id' => $i]);

		if (!$target) {
			show_404();
		} else {
			$data_input = [
				'user_id' => user(),
				'order_id' => $target->id,
				'api_id' => $target->api_id,
				'service' => $target->service,
				'target' => $target->target,
				'status' => 'Pending',
				'api_refill_id' => 0,
				'api_log_refill' => 0,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];

			if (time() > strtotime($target->next_refill)) {
				$api = $this->api_model->get_by_id($target->api_id);
				if (!$api) {
					print('API False');
				}

				$provider_order_id = false;
				if ($api->is_manual == '1') {
					$provider_order_id = true;
				} else {
					$api_refill = $this->api_refill_model->get_row(['api_id' => $target->api_id]);
					if (!$api_refill) {
						print('API Refill False');
						die;
					}

					$params = [];
					$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $target->api_id, 'api_type' => 'refill']);
					if (!empty($api_request_param)) {
						foreach ($api_request_param->result_array() as $row) {
							if ($row['param_type'] === 'custom') {
								$params[$row['param_key']] = $row['param_value'];
							} else {
								switch ($row['param_value']) {
									case 'order_id':
										$params[$row['param_key']] = $target->api_order_id;
										break;
									case 'api_id':
										$params[$row['param_key']] = $api->api_id;
										break;
									case 'api_key':
										$params[$row['param_key']] = $api->api_key;
										break;
									case 'secret_key':
										$params[$row['param_key']] = $api->secret_key;
										break;
								}
							}
						}

						$client = new GuzzleHttp\Client();
						try {
							$request = $client->request('POST', $api_refill->end_point, [
								'form_params' => $params,
								'headers' => ['Accept' => 'application/json'],
							]);

							if ($request->getStatusCode() === 200) {
								$response = $request->getBody()->getContents();
								$json_result = json_decode($response, true);
								$provider_order_id = search_key($json_result, $api_refill->refill_id_key);
								$data_input['api_refill_id'] = $provider_order_id;
								$data_input['api_log_refill'] = $this->db->escape($response);
							}
						} catch (Exception $e) {
							print_r($e->getMessage());
						}
					}
				}

				if ($provider_order_id) {
					$this->db->trans_start();
					$this->order_model->update(['api_log_refill' => $this->db->escape($response), 'next_refill' => date('Y-m-d H:i:s', time() + (60 * 60 * 24))], ['id' => $target->id]);
					$this->refill_model->insert($data_input);
					$this->db->trans_complete();
					$this->session->set_flashdata('result', ['alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Refill berhasil diproses']);
					redirect(base_url('order/history'));
				} else {
					$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Ups!', 'msg' => 'Refill not allowed.']);
					redirect(base_url('order/history'));
				}
			}
		}
	}
	public function refill_history()
	{
		// filter input = 1
		// FORM INPUT //
		$rows = [
			'10' => '10',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];
		$status = [
			'pending' => 'Pending',
			'processing' => 'Processing',
			'success' => 'Success',
			'error' => 'Error',
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'refill.*, order_list.id AS order_id',
			'join' => [
				[
					'table' => 'order_list',
					'on' => 'order_list.id = refill.order_id',
					'param' => 'right'
				]
			],
			'where' => [['refill.user_id' => user()]],
			'order_by' => 'refill.id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('order/refill_history')));
			$data_query['limit'] = $this->input->get('rows');
		}

		if ($this->input->get('status') <> '') {
			if (array_key_exists($this->input->get('status'), $status) == false)
				exit(redirect(base_url('order/refill_history')));
			$data_query['where'][]['refill.status'] = $this->input->get('status');
		}
		if ($this->input->get('search') <> '') {
			$data_query['where'][] = "refill.id LIKE '%" . $this->db->escape_str(strip_tags($this->input->get('search'))) . "%' OR refill.target LIKE '%" . $this->db->escape_str(strip_tags($this->input->get('search'))) . "%'";
		}
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit(redirect(base_url('order/refill_history')));
		$config['base_url'] = base_url('order/refill_history');
		$config['total_rows'] = $this->refill_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/order/refill_history', ['page_type' => 'Riwayat Refill', 'table' => $this->refill_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'rows' => $rows, 'status' => $status, 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}
	public function history()
	{
		// filter input = 1
		// FORM INPUT //
		$rows = [
			'10' => '10',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];
		$status = [
			'pending' => 'Pending',
			'processing' => 'Processing',
			'success' => 'Success',
			'error' => 'Error',
			'partial' => 'Partial',
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'order_list.*, service.name AS service_name',
			'join' => [
				[
					'table' => 'service',
					'on' => 'service.id = order_list.service_id',
					'param' => 'LEFT'
				]
			],
			'where' => [['order_list.user_id' => user()]],
			'order_by' => 'order_list.id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('order/history')));
			$data_query['limit'] = $this->input->get('rows');
		}

		if ($this->input->get('status') <> '') {
			if (array_key_exists($this->input->get('status'), $status) == false)
				exit(redirect(base_url('order/history')));
			$data_query['where'][]['order_list.status'] = $this->input->get('status');
		}
		if ($this->input->get('search') <> '') {
			$filter_by = $this->input->get('filter_by');
			$search = $this->db->escape_str($this->input->get('search'));
			if ($filter_by == 'id') {
				$data_query['where'][]['order_list.id'] = $search;
			} elseif ($filter_by == 'target') {
				$data_query['where'][]['order_list.target LIKE'] = '%' . $search . '%';
			} elseif ($filter_by == 'service') {
				$data_query['where'][]['service.name LIKE'] = '%' . $search . '%';
			} else {
				$data_query['where'][]['order_list.id'] = $search;
			}
		}
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit(redirect(base_url('order/refill_history')));
		$config['base_url'] = base_url('order/history');
		$config['total_rows'] = $this->order_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/order/history', ['page_type' => 'Riwayat Pesanan', 'table' => $this->order_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'rows' => $rows, 'status' => $status, 'per_page' => $config['per_page'], 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}

	public function detail($i = '', $csrf = '')
	{
		if ($csrf !== $this->security->get_csrf_hash()) {
			show_404();
		}

		$i = $this->db->escape_str($i);
		$target = $this->order_model->get_row(['user_id' => user(), 'id' => $i]);

		if (!$target) {
			show_404();
		}

		$this->load->view('public/order/detail', ['page_type' => 'Detail Data', 'target' => $target, 'service' => $this->service_model->get_by_id($target->service_id)]);
	}

	public function graph()
	{
		// Fungsi untuk memproses tanggal rentang
		$process_date_range = function ($date) {
			if ($date) {
				$date_range = explode(" to ", $date);
				if (count($date_range) == 2) {
					return [
						'start' => date('Y-m-d', strtotime($date_range[0])),
						'end' => date('Y-m-d', strtotime($date_range[1])),
					];
				}
			}
			return [
				'start' => date('Y-m-01'),
				'end' => date('Y-m-d'),
			];
		};

		// Ambil tanggal rentang dari input
		$dates = $process_date_range($this->input->get('date'));
		$start = $dates['start'];
		$end = $dates['end'];

		// Query utama untuk widget dengan GROUP BY status
		$query_template = "
        SELECT status, SUM(price) AS rupiah, COUNT(id) AS total
        FROM order_list
        WHERE user_id = ? AND DATE(created_at) >= ? AND DATE(created_at) <= ?
        GROUP BY status
    ";
		$query_result = $this->db->query($query_template, [user(), $start, $end])->result_array();

		// Inisialisasi widget array
		$widget = array_fill_keys(array_map('strtolower', ['Success', 'Pending', 'Processing', 'Error', 'Partial']), ['rupiah' => 0, 'total' => 0]);

		// Isi widget dengan hasil query
		foreach ($query_result as $row) {
			$status_key = strtolower($row['status']);
			if (isset($widget[$status_key])) {
				$widget[$status_key] = [
					'rupiah' => (int) $row['rupiah'],
					'total' => (int) $row['total'],
				];
			}
		}

		// Query untuk data chart dengan GROUP BY tanggal dan status
		$chart_query = "
        SELECT DATE(created_at) AS date, status, COUNT(id) AS total
        FROM order_list
        WHERE user_id = ? AND DATE(created_at) >= ? AND DATE(created_at) <= ?
        GROUP BY DATE(created_at), status
        ORDER BY DATE(created_at) ASC
    ";
		$chart_result = $this->db->query($chart_query, [user(), $start, $end])->result_array();

		// Proses hasil chart menjadi array yang diperlukan
		$chart_item = $this->lib->list_date_range($start, $end);
		$chart = [];
		foreach ($chart_item as $value) {
			$chart[$value] = [
				'date' => $this->lib->format_chart($value),
				'all' => 0,
				'success' => 0,
				'pending' => 0,
				'processing' => 0,
				'error' => 0,
				'partial' => 0,
			];
		}

		foreach ($chart_result as $row) {
			$date_key = $row['date'];
			$status_key = strtolower($row['status']);
			if (isset($chart[$date_key])) {
				$chart[$date_key]['all'] += (int)$row['total'];
				if (isset($chart[$date_key][$status_key])) {
					$chart[$date_key][$status_key] = (int)$row['total'];
				}
			}
		}

		$data = [
			'page_type' => 'Grafik Pesanan',
			'chart' => array_values($chart),
			'widget' => $widget,
			'start' => $start,
			'end' => $end
		];

		$this->render('public/order/graph', $data);
	}

public function childpanel()
{
    // Validasi input
    $this->form_validation->set_rules('domain', 'Domain', 'required|valid_url');
    $this->form_validation->set_rules('plan', 'Paket', 'required|integer');

    if ($this->input->server('REQUEST_METHOD') === 'POST') {
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('result', [
                'alert' => 'danger',
                'title' => 'Gagal!',
                'msg' => validation_errors()
            ]);
            $data = ['page_type' => 'Child Panel', 'errors' => validation_errors()];
            $this->render('public/order/childpanel', $data);
            return;
        } else {
            $domain = $this->input->post('domain');
            $plan = $this->input->post('plan');
            $user = $this->user_model->get_by_id(user());

            // 1. Tentukan harga & expired berdasarkan plan
            if ($plan == 39) {
                $harga = 50000;
                $expired = date('Y-m-d H:i:s', strtotime('+1 month'));
            } elseif ($plan == 40) {
                $harga = 100000;
                $expired = date('Y-m-d H:i:s', strtotime('+1 month'));
            } elseif ($plan == 42) {
                $harga = 200000;
                $expired = date('Y-m-d H:i:s', strtotime('+1 month'));
            } elseif ($plan == 43) {
                $harga = 300000;
                $expired = date('Y-m-d H:i:s', strtotime('+1 month'));
            } elseif ($plan == 47) {
                $harga = 1500000;
                $expired = date('Y-m-d H:i:s', strtotime('+10000 month'));
            } else {
                $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Paket tidak valid.']);
                redirect('order/childpanel');
                return;
            }

            if ($user->balance < $harga) {
                $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Saldo tidak mencukupi.']);
                redirect('order/childpanel');
                return;
            }

            $saldo_awal = $user->balance;
            $this->db->trans_start();

            $this->user_model->update(['balance' => $saldo_awal - $harga], ['id' => $user->id]);

            // 2. SIMPAN DATA KE DATABASE (Sertakan kolom 'plan')
            $insert_order = $this->childpanel_model->insert([
                'domain' => $domain,
                'user_id' => $user->id,
                'plan' => $plan, // <--- Data plan disimpan di sini
                'status' => 'Pending',
                'order_date' => date('Y-m-d H:i:s'),
                'expired_date' => $expired,
            ]);

            $this->log_balance_usage_model->insert([
                'user_id' => $user->id,
                'type' => 'minus',
                'category' => 'place order',
                'amount' => $harga,
                'description' => 'Pemesanan Child Panel #' . $insert_order,
                'before' => $saldo_awal,
                'after' => $saldo_awal - $harga,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan sistem.']);
            } else {
                // Notifikasi WhatsApp
                $phone = website_config('wa_admin');
                $pesan = "*Order Child Panel Baru*\nID: $insert_order\nUser: $user->username\nPlan: $plan\nDomain: $domain";
                $apikey = website_config('wa_gateway_key');
                $this->lib->sendMessage($apikey, $phone, $pesan);

                $this->session->set_flashdata('result', ['alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Order berhasil dilakukan. Silakan Hubungi Admin untuk aktivasi.']);
            }
            redirect('order/childpanel');
        }
    } else {
        $data = ['page_type' => 'Child Panel'];
        $this->render('public/order/childpanel', $data);
    }
}

public function perpanjang($id)
{
    // 1. Ambil data pesanan
    $id = $this->db->escape_str($id);
    $order = $this->childpanel_model->get_by_id($id);

    if (!$order || $order->status != 'Active') {
        $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Pesanan tidak ditemukan atau belum aktif.']);
        redirect('order/childpanel');
    }

    // 2. Tentukan harga perpanjang berdasarkan plan yang tersimpan di DB
    $plan = $order->plan;
    $harga_perpanjang = 0;
    $tambah_bulan = '+1 month';

    if ($plan == 39) {
        $harga_perpanjang = 50000;
    } elseif ($plan == 40) {
        $harga_perpanjang = 100000;
    } elseif ($plan == 42) {
        $harga_perpanjang = 200000;
    } elseif ($plan == 43) {
        $harga_perpanjang = 300000;
    } elseif ($plan == 47) {
        $harga_perpanjang = 1500000;
        $tambah_bulan = '+10000 month'; // Sesuai logika plan 47 Anda
    } else {
        $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Harga paket tidak ditemukan.']);
        redirect('order/childpanel');
        return;
    }

    $user = $this->user_model->get_by_id(user());

    if ($user->balance < $harga_perpanjang) {
        $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Saldo tidak cukup. Perlu Rp ' . number_format($harga_perpanjang)]);
        redirect('order/childpanel');
        return;
    }

    // 3. Eksekusi Perpanjangan
    $this->db->trans_start();
    $saldo_awal = $user->balance;

    // Potong Saldo
    $this->user_model->update(['balance' => $saldo_awal - $harga_perpanjang], ['id' => $user->id]);

    // Update Tanggal Expired
    $new_expired_date = date('Y-m-d H:i:s', strtotime($tambah_bulan, strtotime($order->expired_date)));
    $this->childpanel_model->update(['expired_date' => $new_expired_date], ['id' => $id]);

    // Log Saldo
    $this->log_balance_usage_model->insert([
        'user_id' => $user->id,
        'type' => 'minus',
        'category' => 'perpanjang order',
        'amount' => $harga_perpanjang,
        'description' => 'Perpanjang Child Panel #' . $id,
        'before' => $saldo_awal,
        'after' => $saldo_awal - $harga_perpanjang,
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan saat memproses.']);
    } else {
        $this->session->set_flashdata('result', ['alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Berhasil diperpanjang hingga ' . date('d M Y', strtotime($new_expired_date))]);
    }

    redirect('order/childpanel');
    }
}
