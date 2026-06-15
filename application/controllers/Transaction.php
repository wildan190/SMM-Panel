<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (website_config('mt_web') == 1) {
			exit(redirect(base_url('maintenance')));
		}
	}

	public function submit()
	{
		// filter input = 1
		if ($this->input->post()) {
			$this->form_validation->set_rules('service', 'Layanan', 'required|numeric');
			$this->form_validation->set_rules('target', 'Target', 'required');
			if ($this->form_validation->run() == true) {

				$data_input = [
					'user_id' => 2,
					'service_id' => $this->db->escape_str($this->input->post('service')),
					'target' =>  htmlentities($this->db->escape_str(strip_tags($this->input->post('target')))),
					'price' => 0, // reset
					'profit' => 0, // reset
					'status' => 'Pending',
					'is_api' => 0,
					'is_refund' => 0,
					'api_id' => 0, // reset
					'api_order_id' => 0, // reset
					'api_log_order' => null, // reset
					'ip_address' => $this->input->ip_address(),
					'custom_link' => $this->input->post('no_meter'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];


				// CHECK SERVICE //
				$service = $this->service_pulsa_model->get_row(['id' => $this->input->post('service'), 'status' => '1']);
				if ($service == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia.'));
					exit(redirect(base_url('transaction/new')));
				}
				$data_input['service'] = $service->name;


				// SET PRICE & PROFIT //
				$rand_num = rand(1, 999);
				$unique_code = $rand_num;
				$data_input['price'] = $service->price + $rand_num;
				$data_input['profit'] = $service->profit;
				$payment_gateway = 0;
				// END SET PRICE & PROFIT //


				// CHECK API //
				$api = $this->api_model->get_by_id($service->api_id);
				if ($api == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia 1.'));
					exit(redirect(base_url()));
				}
				$data_input['api_id'] = $api->id;
				// END CHECK API //
				$provider_order_id = true;
				if ($provider_order_id == true) {
					$deposit_method = $this->deposit_method_model->get_row(['id' => $this->db->escape_str($this->input->post('payment_method'))]);
					if ($deposit_method->tripay_code != '-') {
						$payment_gateway = 1;
						if ($data_input['price'] < 10000 && $deposit_method->tripay_code != 'QRISC') {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!!!', 'msg' => 'Untuk transaksi dibawah Rp 10.000 silahkan gunakan metode pembayaran QRIS'));
							exit(redirect(base_url('transaction/new')));
						} else {
							$apiKey       = 'mhgrzTZ4K3rYGduelqTu1NYVqgstTgA4vYrhgLKq';
							$privateKey   = '6TKvX-m5KqY-X2N3o-wyOO3-GNOp6';
							$merchantCode = 'T10874';
							$merchantRef  = $this->lib->random_strings(10);
							$price = round($service->price + $rand_num);

							$data = [
								'method'         => $deposit_method->tripay_code,
								'merchant_ref'   => $merchantRef,
								'amount'         => $price,
								'customer_name'  => 'Guess',
								'customer_email' => 'guess@kedepay.co.id',
								'customer_phone' => '089533782640',
								'order_items'    => [
									[
										'name'        => 'ORDER - ' . $service->name . '',
										'price'       => $price,
										'quantity'    => 1,
									]
								],
								'return_url'   => base_url('deposit/history'),
								'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
								'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $price, $privateKey)
							];

							$curl = curl_init();

							curl_setopt_array($curl, [
								CURLOPT_FRESH_CONNECT  => true,
								CURLOPT_URL            => 'https://tripay.co.id/api/transaction/create',
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_HEADER         => false,
								CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
								CURLOPT_FAILONERROR    => false,
								CURLOPT_POST           => true,
								CURLOPT_POSTFIELDS     => http_build_query($data)
							]);

							$response = curl_exec($curl);
							$error = curl_error($curl);

							curl_close($curl);
							$json_result = json_decode($response, true);
							//print_r('<pre>');
							//print_r($json_result);
							//print_r('</pre>'); die;
							if ($json_result['success'] == true) {
								//$this->lib->print_data($json_result);
								$data_input['price'] = $json_result['data']['amount'];
								$data_transaction = [
									'deposit_method_id' => $deposit_method->id,
									'reference' => $json_result['data']['reference'],
									'merchant_ref' => $merchantRef,
									'amount' => $data_input['price'],
									'type' => 'Payment',
									'status' => 'Pending',
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								];
								$this->transaction_model->insert($data_transaction);
							} else {
								$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!!!', 'msg' => 'Terjadi kesalahan pembayaran'));
								exit(redirect(base_url('transaction/new')));
							}
						}
					}
					$this->db->trans_start();
					$insert_order = $this->order_pulsa_model->insert($data_input);
					$data_invoice = [
						'order_id' => $insert_order,
						'type' => 'Pulsa',
						'amount' => $data_input['price'],
						'unique_code' => $unique_code,
						'status' => 'Unpaid',
						'payment_id' => $this->db->escape_str($this->input->post('payment_method')),
						'payment_expired' => date('Y-m-d H:i:s', time() + (60 * 60 * 24)),
						'reference' => ($payment_gateway == 1 ? $data_transaction['reference'] : 'NULL'),
						'merchant_ref' => ($payment_gateway == 1 ? $data_transaction['merchant_ref'] : 'NULL'),
						'payment_gateway' => ($payment_gateway == 1 ? '1' : '0'),
						'additional_data' => ($deposit_method->category == 'bank' ? $json_result['data']['pay_code'] :
							'-'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					];
					$insert_invoice = $this->invoice_model->insert($data_invoice);
					$this->db->trans_complete();
					if ($this->db->trans_status() == true) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Transaksi berhasil dibuat!'));
						exit(redirect(base_url('transaction/order_detail/' . $insert_invoice)));
					} else {
						log_message('error', $data_input);
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!!!', 'msg' => 'Terjadi kesalahan tidak terduga.'));
						exit(redirect(base_url('transaction/new')));
					}
					exit(redirect(base_url('transaction/new')));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan sedang mengalami gangguan 2'));
					exit(redirect(base_url('transaction/new')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('transaction/new')));
			}
		}
	}

	public function submit_order()
	{
		// filter input = 1
		if ($this->input->post()) {
			$this->form_validation->set_rules('service', 'Layanan', 'required|numeric');
			$this->form_validation->set_rules('target', 'Target', 'required');
			$this->form_validation->set_rules('quantity', 'Jumlah', 'required|numeric');
			if ($this->form_validation->run() == true) {

				$data_input = [
					'user_id' => 2,
					'service_id' => $this->db->escape_str($this->input->post('service')),
					'target' =>  htmlentities($this->db->escape_str(strip_tags($this->input->post('target')))),
					'price' => 0, // reset
					'profit' => 0, // reset
					'status' => 'Pending',
					'quantity' => $this->db->escape_str($this->input->post('quantity')),
					'is_api' => 0,
					'is_refund' => 0,
					'api_id' => 0, // reset
					'api_order_id' => 0, // reset
					'api_log_order' => null, // reset
					'ip_address' => $this->input->ip_address(),
					'custom_comments' => ($this->input->post('username')) ? $this->input->post('username') : $this->input->post('custom_comments'),
					'custom_link' => ($this->input->post('comments')) ? $this->input->post('comments') : $this->input->post('custom_link'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];

				// CHECK SERVICE //
				$service = $this->service_model->get_row(['id' => $this->input->post('service'), 'status' => '1']);
				if ($service == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia.'));
					exit(redirect(base_url('transaction/new')));
				}
				if ($service->refill == 1) $data_input['is_refill'] == 1;
				$data_input['service'] = $service->name;

				// CHECK SERVICE TYPE //
				if ($service->type == 'custom_comments') {
					$data_input['quantity'] = count(explode("\n", $data_input['custom_comments']));
				}
				// END CHECK SERVICE TYPE //


				// CHECK ORDER DETAIL //
				if (!$service->type == 'custom_comments') {
					if ($data_input['quantity'] < $service->min) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Jumlah Pesan tidak sesuai.1'));
						exit(redirect(base_url('transaction/new')));
					} elseif ($data_input['quantity'] > $service->max) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Jumlah Pesan tidak sesuai.2'));
						exit(redirect(base_url('transaction/new')));
					}
				}


				// SET PRICE & PROFIT //
				$rand_num = rand(1, 999);
				$unique_code = $rand_num;
				$data_input['price'] = round($data_input['quantity'] * ($service->price / 1000) + $rand_num);
				$data_input['profit'] = $data_input['quantity'] * ($service->profit / 1000) + $rand_num;
				$payment_gateway = 0;
				// END SET PRICE & PROFIT //


				// CHECK API //
				$api = $this->api_model->get_by_id($service->api_id);
				if ($api == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak tersedia 1.'));
					exit(redirect(base_url()));
				}
				$data_input['api_id'] = $api->id;
				// END CHECK API //
				$provider_order_id = true;
				if ($provider_order_id == true) {
					$deposit_method = $this->deposit_method_model->get_row(['id' => $this->db->escape_str($this->input->post('payment_method'))]);
					if ($deposit_method->tripay_code != '-') {
						$payment_gateway = 1;
						if ($data_input['price'] < 10000 && $deposit_method->tripay_code != 'QRISC') {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!!!', 'msg' => 'Untuk transaksi dibawah Rp 10.000 silahkan gunakan metode pembayaran QRIS'));
							exit(redirect(base_url('transaction/new')));
						} else {
							$apiKey       = 'mhgrzTZ4K3rYGduelqTu1NYVqgstTgA4vYrhgLKq';
							$privateKey   = '6TKvX-m5KqY-X2N3o-wyOO3-GNOp6';
							$merchantCode = 'T10874';
							$merchantRef  = $this->lib->random_strings(10);

							$data = [
								'method'         => $deposit_method->tripay_code,
								'merchant_ref'   => $merchantRef,
								'amount'         => $data_input['price'],
								'customer_name'  => 'Guess',
								'customer_email' => 'guess@kedepay.co.id',
								'customer_phone' => '089533782640',
								'order_items'    => [
									[
										'name'        => 'ORDER - ' . $service->name . '',
										'price'       => $data_input['price'],
										'quantity'    => 1,
									]
								],
								'return_url'   => base_url('transaction/new'),
								'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
								'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $data_input['price'], $privateKey)
							];
							// var_dump($data); die;
							$curl = curl_init();

							curl_setopt_array($curl, [
								CURLOPT_FRESH_CONNECT  => true,
								CURLOPT_URL            => 'https://tripay.co.id/api/transaction/create',
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_HEADER         => false,
								CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
								CURLOPT_FAILONERROR    => false,
								CURLOPT_POST           => true,
								CURLOPT_POSTFIELDS     => http_build_query($data)
							]);

							$response = curl_exec($curl);
							$error = curl_error($curl);

							curl_close($curl);
							$json_result = json_decode($response, true);

							if ($json_result['success'] == true) {
								//$this->lib->print_data($json_result);
								$data_input['price'] = $json_result['data']['amount'];
								$data_transaction = [
									'deposit_method_id' => $deposit_method->id,
									'reference' => $json_result['data']['reference'],
									'merchant_ref' => $merchantRef,
									'amount' => $data_input['price'],
									'type' => 'Payment',
									'status' => 'Pending',
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								];
								$this->transaction_model->insert($data_transaction);
							} else {
								$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!!!', 'msg' => 'Terjadi kesalahan pembayaran'));
								exit(redirect(base_url('transaction/new')));
							}
						}
					}
					$this->db->trans_start();
					$insert_order = $this->order_model->insert($data_input);
					$data_invoice = [
						'order_id' => $insert_order,
						'type' => 'SosialMedia',
						'amount' => $data_input['price'],
						'status' => 'Unpaid',
						'unique_code' => $unique_code,
						'payment_id' => $this->db->escape_str($this->input->post('payment_method')),
						'payment_expired' => date('Y-m-d H:i:s', time() + (60 * 60 * 24)),
						'reference' => ($payment_gateway == 1 ? $data_transaction['reference'] : 'NULL'),
						'merchant_ref' => ($payment_gateway == 1 ? $data_transaction['merchant_ref'] : 'NULL'),
						'payment_gateway' => ($payment_gateway == 1 ? '1' : '0'),
						'additional_data' => ($payment_gateway == 1 ? $json_result['data']['pay_code'] :
							'-'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					];
					$insert_invoice = $this->invoice_model->insert($data_invoice);
					$this->db->trans_complete();
					if ($this->db->trans_status() == true) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil', 'msg' => 'Transaksi berhasil dibuat!'));
						exit(redirect(base_url('transaction/order_detail/' . $insert_invoice)));
					} else {
						log_message('error', $data_input);
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!!!', 'msg' => 'Terjadi kesalahan tidak terduga.'));
						exit(redirect(base_url('transaction/new')));
					}
					exit(redirect(base_url('transaction/new')));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan sedang mengalami gangguan 2'));
					exit(redirect(base_url('transaction/new')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('transaction/new')));
			}
		}
	}

	public function new()
	{
		$this->render('public/page/transaction', ['page_type' => 'Transaksi Langsung']);
	}

	public function form($i = '')
	{
		$i = $this->db->escape_str($i);
		if (in_array($i, ['Pulsa', 'PaketInternet', 'PaketSMS', 'VoucherGame', 'Emoney', 'TokenListrik', 'Games', 'SosialMedia', 'Other']) == false) show_404();
		$data = $this->service_category_model->get_row(['type' => $i]);
		$payment = $this->deposit_method_model->get_rows(['where' => [['is_payment' => 1]]]);
		$this->load->view('public/page/transaction_form', ['type' => $data, 'payment_method' => $payment, 'category' => $this->service_category_model->get_rows(['where' => [['type' => $i]]])]);
	}
	public function form_sosmed($i = '')
	{
		$i = $this->db->escape_str($i);
		if (in_array($i, ['SosialMedia']) == false) show_404();
		$data = $this->service_category_model->get_rows(['where' => [['type' => $i]]]);
		$payment = $this->deposit_method_model->get_rows(['where' => [['is_payment' => 1]]]);
		//print_r($payment); die;
		$this->load->view('public/page/transaction_sosmed', ['service_category' => $data, 'payment_method' => $payment]);
	}

	public function check_order()
	{
		$this->render('public/page/check_order', ['page_type' => 'Cari Invoice']);
	}

	public function order_detail($i = '')
	{
		$i = $this->db->escape_str($i);
		$data_invoice = $this->invoice_model->get_row(['id' => $i]);
		$model = ($data_invoice->type == 'Pulsa' ? 'order_pulsa_model' : 'order_model');
		$method = $this->deposit_method_model->get_row(['id' => $data_invoice->payment_id]);
		if ($method->tripay_code <> '-') $trx = $this->transaction_model->get_row(['deposit_method_id' => $method->id]);
		$data_order = $this->$model->get_row(['id' => $data_invoice->order_id]);
		if ($data_order == false) {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'ID Invoice tidak ditemukan'));
			exit(redirect(base_url('transaction/check_order')));
		} else {
			$this->render('public/page/detail_order', ['page_type' => 'Detail Invoice', 'data_invoice' => $data_invoice, 'data_order' => $data_order, 'payment' => $method]);
		}
	}

	public function check_order_form()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('id', 'ID Pesanan', 'required|numeric');
			if ($this->form_validation->run() == true) {
				$data_invoice = $this->invoice_model->get_row(['id' => $this->db->escape_str($this->input->post('id'))]);
				$model = ($data_invoice->type == 'Pulsa' ? 'order_pulsa_model' : 'order_model');
				$data_order = $this->$model->get_row(['id' => $data_invoice->order_id]);
				$method = $this->deposit_method_model->get_row(['id' => $data_invoice->payment_id]);
				if ($method->tripay_code <> '-') $trx = $this->transaction_model->get_row(['deposit_method_id' => $method->id]);
				if ($data_invoice == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'ID Invoice tidak ditemukan'));
					exit(redirect(base_url('transaction/check_order')));
				} else {
					$this->render('public/page/detail_order', ['page_type' => 'Detail Invoice', 'data_invoice' => $data_invoice, 'data_order' => $data_order, 'payment' => $method, 'trx' => $trx]);
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
	}

	public function ajax_order($i = '')
	{
		// filter input = 1
		header('Content-Type: application/json');
		$type = $this->db->escape_str($this->input->get('type'));

		$category = $this->service_category_model->get_row(['name' => $i, 'type' => $type]);
		if ($category == false) {
			print('<option value="">Provider tidak dikenal...</option>');
		} else {
			$service = $this->service_pulsa_model->get_rows(['where' => [['service_category_id' => $category->id, 'status' => '1']]]);
			//print_r($service); die;

			if ($service == false) {
				print('<option value="">Layanan kosong...</option>');
			} else {
				print('<option value="">-- Pilih Layanan --</option>');
				foreach ($service as $key => $value) {
					print('<option value="' . $value['id'] . '"> ' . $value['id'] . ' - ' . $value['name'] . ' - Rp ' . number_format($value['price'], 0, ',', '.') . '</option>');
				}
			}
		}
	}

	public function type_list($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash()) exit("No direct script access allowed");
		header('Content-Type: application/json');
		$service = $this->service_category_model->get_rows(['where' => [['type' => $i]]]);
		if (count($service) < 1) {
			$result = ['msg' => '<option value="">Kategori tidak tersedia.</option>'];
		} else {
			$list = '<option value="">Pilih...</option>';
			foreach ($service as $key => $value) {
				$list .= '<option value="' . $value['id'] . '"> ' . $value['id'] . ' - ' . $value['name'] . '</option>';
			}
			$result = ['msg' => $list];
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}

	public function service_detail($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		header('Content-Type: application/json');
		$service = $this->service_pulsa_model->get_row(['id' => $i, 'status' => '1']);
		if ($service == false) {
			$msg = [
				'type' => 0,
				'is_custom_price' => 0,
				'price' => 0,
				'description' => 'Deskripsi layanan.',
			];
		} else {
			$description = str_replace('\r\nd', '', $service->description);
			//$description = str_replace('\\r\\n', '', $description);
			//$description = str_replace('<br>', '', $description);
			$msg = [
				'type' => $service->type,
				'is_custom_price' => '0',
				'price' => $service->price,
				//'description' => nl2br($service->description),
				'description' => $description
			];
		}
		$result = ['msg' => $msg];
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
}
