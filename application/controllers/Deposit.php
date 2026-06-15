<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposit extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (website_config('mt_web') == 1) {
			exit(redirect(base_url('maintenance')));
		}
		check_cookie(get_cookie('smm_login'));
		if (user() == false)
			exit(redirect(base_url('auth/logout')));
		$this->load->library('Gopay');
		$this->load->library('Ovo');
		$this->load->library('Bca');
	}
	public function baru()
	{
		// filter input = 1
		if ($this->input->post()) {
			$this->form_validation->set_rules('method', 'Metode Deposit', 'required|numeric');
			$this->form_validation->set_rules('phone_number', 'Nomor Telepon Pengirim', 'numeric');
			$this->form_validation->set_rules('amount', 'Jumlah Deposit', 'required|numeric');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'user_id' => user(),
					'deposit_method_id' => $this->db->escape_str($this->input->post('method')),
					'amount' => $this->db->escape_str($this->input->post('amount')),
					'balance' => 0,
					// reset
					'status' => 'Pending',
					'phone_number' => ($this->input->post('phone_number') <> '') ? $this->db->escape_str($this->input->post('phone_number')) : null,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					'additional_data' => '-',
					'result' => '-',
				];

				// LIMIT DEPOSIT REQUEST //
				if ($this->deposit_model->get_count(['where' => [['user_id' => user(), 'status' => 'Pending']]]) >= 1) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Anda membuat terlalu banyak permintaan deposit, batalkan permintaan sebelumnya.'));
					// Permintaan deposit Anda sebelumnya belum selesai diproses.
					exit(redirect(base_url('deposit/history')));
				}
				// END LIMIT DEPOSIT REQUEST //

				// CHECK DEPOSIT METHOD //
				$deposit_method = $this->deposit_method_model->get_row(['id' => $data_input['deposit_method_id'], 'status' => '1']);
				if ($deposit_method == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Metode deposit tidak tersedia.'));
					exit(redirect(base_url('deposit/new')));
				}
				// END CHECK DEPOSIT METHOD //
				$payment_gateway = 0;
				$data_input['balance'] = $deposit_method->rate * $data_input['amount'];
				// CHECK DEPOSIT METHOD TYPE & CATEGORY //
				if ($deposit_method->type == 'manual' and $deposit_method->category <> 'pulsa') {
					for ($i = 0; $i < 100; $i++) {
						$unique_amount = $data_input['amount'] + rand(100, 300);
						if ($this->deposit_model->get_row(['amount' => $unique_amount, 'status' => 'Pending']) == true)
							continue;
						break;
					}
					$data_input['amount'] = $unique_amount;
				}
				// END CHECK DEPOSIT METHOD TYPE & CATEGORY //

				// SET GET BALANCE //

				// END SET GET BALANCE //

				if ($deposit_method->gateway_code <> 'MANUAL') {
					if ($deposit_method->type == 'tripay') {
						$apiKey = website_config('tripay_api_key');
						$privateKey = website_config('tripay_private_key');
						$merchantCode = website_config('tripay_merchant_code');
						$merchantRef = $this->lib->random_strings(10);

						$data = [
							'method' => $deposit_method->gateway_code,
							'merchant_ref' => $merchantRef,
							'amount' => $data_input['amount'],
							'customer_name' => user('full_name'),
							'customer_email' => (user('email') == '' ? 'ferdiananda.id@gmail.com' : user('email')),
							'customer_phone' => $this->lib->nohp(user('whatsapp')),
							'order_items' => [
								[
									'name' => 'Deposit - ' . $deposit_method->name . '',
									'price' => $data_input['amount'],
									'quantity' => 1,
								]
							],
							'return_url' => base_url('deposit/history'),
							'expired_time' => (time() + (24 * 60 * 60)),
							// 24 jam
							'signature' => hash_hmac('sha256', $merchantCode . $merchantRef . $data_input['amount'], $privateKey)
						];
						// var_dump($data); die;
						$curl = curl_init();

						curl_setopt_array($curl, [
							CURLOPT_FRESH_CONNECT => true,
							CURLOPT_URL => 'https://tripay.co.id/api/transaction/create',
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HEADER => false,
							CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
							CURLOPT_FAILONERROR => false,
							CURLOPT_POST => true,
							CURLOPT_POSTFIELDS => http_build_query($data)
						]);

						$response = curl_exec($curl);
						$error = curl_error($curl);

						curl_close($curl);
						$json_result = json_decode($response, true);
						//print_r('<pre>');
						//print_r($json_result);
						//print_r('</pre>'); die;
						if ($json_result['success'] == true) {
							$payment_gateway = 1;
							$data_input['result'] = $json_result['data'];
							$data_input['amount'] = $json_result['data']['amount'];
							$data_input['reference'] = $json_result['data']['reference'];
							$data_input['additional_data'] = ($json_result['data']['pay_code'] ? $json_result['data']['pay_code'] : $json_result['data']['qr_url']);
							$data_input['result'] = json_encode($json_result['data']);
						}
					} else if ($deposit_method->type == 'paydisini') {
						$apiKey = website_config('paydisini_api_key');
						$uniqueCode = $this->lib->random_strings(10);
						// $service = $deposit_method->gateway_code;
						$service = $deposit_method->gateway_code;
						$amount = $data_input['amount'];
						$typeFee = '1';
						$note = 'Deposit - ' . $deposit_method->name . '';
						$validTime = '10800';

						$sign = md5($apiKey . $uniqueCode . $service . $amount . $validTime . 'NewTransaction');

						$data = [
							'key' => $apiKey,
							'request' => 'new',
							'unique_code' => $uniqueCode,
							'service' => $service,
							'amount' => $amount,
							'note' => $note,
							'valid_time' => $validTime,
							'ewallet_phone' => $this->lib->nohp(user('whatsapp')),
							'type_fee' => $typeFee,
							'signature' => $sign
						];

						// Menggunakan library cURL yang sudah dibuat sebelumnya
						$curl = $this->lib->curlpaydisini('https://paydisini.co.id/api/', $data);
						$json_result = json_decode($curl, true);

						if ($json_result['success'] == true) {
							$payment_gateway = 1;
							$data_input['amount'] = $json_result['data']['amount'];
							$data_input['reference'] = $json_result['data']['unique_code'];
							$data_input['additional_data'] = ($json_result['data']['qrcode_url'] ?? ($json_result['data']['virtual_account'] ?? $json_result['data']['payment_code']));
							$data_input['result'] = json_encode($json_result['data']);
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan saat melakukan permintaan deposit. Error: ' . $json_result['msg']));
							exit(redirect(base_url('deposit/new')));
						}
					} else if ($deposit_method->type == 'midtrans') {
						$this->load->library('midtrans');
						$merchantRef = $this->lib->random_strings(10);
						$params = [
							'transaction_details' => [
								'order_id' => $merchantRef,
								'gross_amount' => (int)$data_input['amount'],
							],
							'customer_details' => [
								'first_name' => user('full_name'),
								'email' => (user('email') == '' ? 'customer@example.com' : user('email')),
								'phone' => $this->lib->nohp(user('whatsapp')),
							],
							'callbacks' => [
								'finish' => base_url('deposit/finish'),
							]
						];

						$snapResponse = $this->midtrans->getSnapToken($params, base_url('webhook/midtrans'));

						if (isset($snapResponse['token'])) {
							$payment_gateway = 1;
							$data_input['reference'] = $merchantRef;
							$data_input['additional_data'] = $snapResponse['token'];
							$data_input['result'] = json_encode($snapResponse);
						} else {
							log_message('error', 'Midtrans Error: ' . json_encode($snapResponse));
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan Midtrans: ' . ($snapResponse['error_messages'][0] ?? 'Unknown error')));
							exit(redirect(base_url('deposit/new')));
						}
					} else {
						$data_input['balance'] = $deposit_method->rate * $data_input['amount'];
					}
				}


				// CHECK DEPOSIT DETAIL //
				if ($data_input['amount'] < $deposit_method->min_deposit) {
					$this->session->set_flashdata('result', array(
						'alert' => 'danger',
						'title' => 'Gagal!',
						'msg' => 'Minimal Deposit Rp ' . currency($deposit_method->min_deposit)
					));
					
					exit(redirect(base_url('deposit/new')));
				}
				// END CHECK DEPOSIT DETAIL //
				
				$insert_deposit = $this->deposit_model->insert($data_input);
				
				if ($insert_deposit == true) {
					if ($deposit_method->type <> 'manual') {
						if ($deposit_method->gateway_instruction == '1') {

							$phone = $this->lib->hp(user('whatsapp'));
							$phone1 = website_config('wa_admin');
							$message = website_config('wa_deposit_pending');
							$message1 = website_config('wa_admin_deposit_pending');
							$pesan = preg_replace(
								array(
									'/{{url}}/',
									'/{{title}}/',
									'/{{user_fullname}}/',
									'/{{user_username}}/',
									'/{{deposit_id}}/',
									'/{{deposit_method}}/',
									'/{{deposit_transfer}}/',
									'/{{deposit_amount}}/',
									'/{{deposit_status}}/',
									'/{{deposit_create}}/',
									'/{{deposit_update}}/'
								),
								array(
									base_url(),
									website_config('title'),
									user('full_name'),
									user('username'),
									$insert_deposit,
									$deposit_method->name,
									currency($data_input['amount']),
									currency($data_input['balance']),
									$data_input['status'],
									$this->lib->format_date($data_input['created_at']),
									$this->lib->format_date($data_input['updated_at'])
								),
								$message
							);
							
							$pesan1 = preg_replace(
								array(
									'/{{url}}/',
									'/{{title}}/',
									'/{{user_fullname}}/',
									'/{{user_username}}/',
									'/{{deposit_id}}/',
									'/{{deposit_method}}/',
									'/{{deposit_transfer}}/',
									'/{{deposit_amount}}/',
									'/{{deposit_status}}/',
									'/{{deposit_create}}/',
									'/{{deposit_update}}/'
								),
								array(
									base_url(),
									website_config('title'),
									user('full_name'),
									user('username'),
									$insert_deposit,
									$deposit_method->name,
									currency($data_input['amount']),
									currency($data_input['balance']),
									$data_input['status'],
									$this->lib->format_date($data_input['created_at']),
									$this->lib->format_date($data_input['updated_at'])
								),
								$message1
							);
							
							$apikey = website_config('wa_gateway_key');
							if (website_config('send_wa_deposit') == 'on') {
    							$this->lib->sendMessage($apikey, $phone, $pesan);
    				            $this->lib->sendMessage($apikey, $phone1, $pesan1);
						    }
						        
							exit(redirect(base_url('deposit/invoice/' . $insert_deposit)));
						} else {
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Segera lunasi pembayaran!', 'msg' => '<br />Metode Deposit: ' . $deposit_method->name . '<br />Silahkan ikuti intruksi pembayaran yang ada.'));

							$phone = $this->lib->hp(user('whatsapp'));
							$phone1 = website_config('wa_admin');
							$message = website_config('wa_deposit_pending');
							$message1 = website_config('wa_admin_deposit_pending');
							$pesan = preg_replace(
								array(
									'/{{url}}/',
									'/{{title}}/',
									'/{{user_fullname}}/',
									'/{{user_username}}/',
									'/{{deposit_id}}/',
									'/{{deposit_method}}/',
									'/{{deposit_transfer}}/',
									'/{{deposit_amount}}/',
									'/{{deposit_status}}/',
									'/{{deposit_create}}/',
									'/{{deposit_update}}/'
								),
								array(
									base_url(),
									website_config('title'),
									user('full_name'),
									user('username'),
									$insert_deposit,
									$deposit_method->name,
									currency($data_input['amount']),
									currency($data_input['balance']),
									$data_input['status'],
									$this->lib->format_date($data_input['created_at']),
									$this->lib->format_date($data_input['updated_at'])
								),
								$message
							);
							
							$pesan1 = preg_replace(
								array(
									'/{{url}}/',
									'/{{title}}/',
									'/{{user_fullname}}/',
									'/{{user_username}}/',
									'/{{deposit_id}}/',
									'/{{deposit_method}}/',
									'/{{deposit_transfer}}/',
									'/{{deposit_amount}}/',
									'/{{deposit_status}}/',
									'/{{deposit_create}}/',
									'/{{deposit_update}}/'
								),
								array(
									base_url(),
									website_config('title'),
									user('full_name'),
									user('username'),
									$insert_deposit,
									$deposit_method->name,
									currency($data_input['amount']),
									currency($data_input['balance']),
									$data_input['status'],
									$this->lib->format_date($data_input['created_at']),
									$this->lib->format_date($data_input['updated_at'])
								),
								$message1
							);
							
							$apikey = website_config('wa_gateway_key');
							if (website_config('send_wa_deposit') == 'on') {
    							$this->lib->sendMessage($apikey, $phone, $pesan);
    				            $this->lib->sendMessage($apikey, $phone1, $pesan1);
						    }

							exit(redirect(base_url('deposit/invoice/' . $insert_deposit)));
						}
					} else {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Segera lunasi pembayaran!', 'msg' => '<br />Metode Deposit: ' . $deposit_method->name . '<br /><h3 style="color:red;">Jumlah Transfer: Rp ' . number_format($data_input['amount'], 0, ',', '.') . '</h3>Saldo Didapat: Rp ' . number_format($data_input['balance'], 0, ',', '.') . '<br />Tujuan Pembayaran: ' . $deposit_method->number_account . ' A/N ' . $deposit_method->name_account . '<br />' . $deposit_method->description . ''));

						$phone = $this->lib->hp(user('whatsapp'));
						$phone1 = website_config('wa_admin');
						$message = website_config('wa_deposit_pending');
						$message1 = website_config('wa_admin_deposit_pending');
						$pesan = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								user('full_name'),
								user('username'),
								$insert_deposit,
								$deposit_method->name,
								currency($data_input['amount']),
								currency($data_input['balance']),
								$data_input['status'],
								$this->lib->format_date($data_input['created_at']),
								$this->lib->format_date($data_input['updated_at'])
							),
							$message
						);
						
						$pesan1 = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								user('full_name'),
								user('username'),
								$insert_deposit,
								$deposit_method->name,
								currency($data_input['amount']),
								currency($data_input['balance']),
								$data_input['status'],
								$this->lib->format_date($data_input['created_at']),
								$this->lib->format_date($data_input['updated_at'])
							),
							$message1
						);
						
						$apikey = website_config('wa_gateway_key');
							if (website_config('send_wa_deposit') == 'on') {
							$this->lib->sendMessage($apikey, $phone, $pesan);
				            $this->lib->sendMessage($apikey, $phone1, $pesan1);
						}
						
						exit(redirect(base_url('deposit/invoice/' . $insert_deposit)));
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan tidak terduga.'));
					exit(redirect(base_url('deposit/new')));
				}
				exit(redirect(base_url('deposit/new')));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$data_query = [
			'select' => 'deposit.*, deposit_method.name AS deposit_name',
			'join' => [
				[
					'table' => 'deposit_method',
					'on' => 'deposit_method.id = deposit.deposit_method_id',
					'param' => 'LEFT'
				]
			],
			'where' => [['user_id' => user()]],
			'order_by' => 'deposit.id DESC',
			'limit' => '5',
		];
		$this->render('public/deposit/new', ['page_type' => 'Deposit Baru', 'last_deposit' => $this->deposit_model->get_rows($data_query)]);
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
			'Pending' => 'Pending',
			'Success' => 'Success',
			'Canceled' => 'Canceled',
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'deposit.*, deposit_method.name AS deposit_method_name, deposit_method.description as deposit_note',
			'join' => [
				[
					'table' => 'deposit_method',
					'on' => 'deposit_method.id = deposit.deposit_method_id',
					'param' => 'inner'
				]
			],
			'where' => [['user_id' => user()]],
			'order_by' => 'deposit.id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('deposit/history')));
			$data_query['limit'] = $this->input->get('rows');
		}

		if ($this->input->get('status') <> '') {
			if (array_key_exists($this->input->get('status'), $status) == false)
				exit(redirect(base_url('deposit/history')));
			$data_query['where'][]['deposit.status'] = $this->input->get('status');
		}
		if ($this->input->get('search') <> '') {
			$data_query['where'][] = "deposit.id LIKE '%" . $this->db->escape_str(strip_tags(htmlspecialchars($this->input->get('search'), ENT_QUOTES))) . "%'";
		}
		// END SORT & SEARCH
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit('shafou.com');
		$config['base_url'] = base_url('deposit/history');
		$config['total_rows'] = $this->deposit_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/deposit/history', ['page_type' => 'Riwayat Deposit', 'table' => $this->deposit_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'rows' => $rows, 'status' => $status, 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}
	public function invoice($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		$target = $this->deposit_model->get_row(['user_id' => user(), 'id' => $i]);

		if ($target == false)
			show_404();

		$target_result = json_decode($target->result, true);
		$target->checkout_url = (isset($target_result['checkout_url_beta'])) ? $target_result['checkout_url_beta'] : null;

		$this->load->library('midtrans');
		$this->render('public/deposit/invoice', [
			'page_type' => 'Invoice Deposit',
			'target' => $target,
			'deposit_method' => $this->deposit_method_model->get_by_id($target->deposit_method_id),
			'midtrans' => $this->midtrans
		]);
	}

	public function finish()
	{
		$order_id = $this->input->get('order_id');
		if ($order_id) {
			$deposit = $this->deposit_model->get_row(['reference' => $order_id]);
			
			if ($deposit && $deposit->status == 'Pending') {
				// Cek status ke Midtrans API secara real-time
				$this->load->library('midtrans');
				$server_key = $this->midtrans->getServerKey();
				$url = $this->midtrans->isProduction() ? 'https://api.midtrans.com/v2/' : 'https://api.sandbox.midtrans.com/v2/';
				$url .= $order_id . '/status';

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic ' . base64_encode($server_key . ':')
				]);
				$response = curl_exec($ch);
				curl_close($ch);
				$result = json_decode($response, true);

				if (isset($result['transaction_status'])) {
					$status = $result['transaction_status'];
					if ($status == 'settlement' || $status == 'capture') {
						// UPDATE OTOMATIS: Berikan saldo langsung tanpa tunggu admin
						$this->db->trans_start();
						
						// 1. Update status deposit
						$this->deposit_model->update([
							'status' => 'Success',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['id' => $deposit->id]);

						// 2. Tambah saldo user
						$user = $this->user_model->get_by_id($deposit->user_id);
						if ($user) {
							$this->user_model->update([
								'balance' => $user->balance + $deposit->balance,
							], ['id' => $user->id]);

							// 3. Catat log penggunaan saldo
							$this->load->model('log_balance_usage_model');
							$this->log_balance_usage_model->insert([
								'user_id' => $user->id,
								'type' => 'plus',
								'category' => 'deposit',
								'amount' => $deposit->balance,
								'description' => 'Deposit #' . $deposit->id . ' via Midtrans (Auto-Finish).',
								'before' => $user->balance,
								'after' => $user->balance + $deposit->balance,
								'created_at' => date('Y-m-d H:i:s')
							]);
						}

						$this->db->trans_complete();

						if ($this->db->trans_status() === TRUE) {
							$this->session->set_flashdata('result', [
								'alert' => 'success',
								'title' => 'Berhasil!',
								'msg' => 'Pembayaran Anda telah diterima dan saldo telah ditambahkan secara otomatis.'
							]);
						} else {
							$this->session->set_flashdata('result', [
								'alert' => 'danger',
								'title' => 'Gagal!',
								'msg' => 'Terjadi kesalahan saat memperbarui saldo. Silahkan hubungi Admin.'
							]);
						}
					}
				}
			} else if ($deposit && $deposit->status == 'Success') {
				$this->session->set_flashdata('result', [
					'alert' => 'success',
					'title' => 'Sudah Berhasil!',
					'msg' => 'Deposit Anda sebelumnya sudah berhasil diproses.'
				]);
			}
		}
		redirect(base_url('deposit/history'));
	}
	public function detail($i = '')
	{
		$i = $this->db->escape_str($i);
		$target = $this->deposit_model->get_row(['id' => $i]);

		if ($target) {
			$deposit_method = $this->deposit_method_model->get_by_id($target->deposit_method_id);
			$data['target'] = $target;
			$data['deposit_method'] = $deposit_method;

			if ($deposit_method->type == 'paydisini') {
				// ambil instruksi pembayaran paydisini
				$apiKey = website_config('paydisini_api_key');
				$service = $deposit_method->gateway_code;
				$sign = md5($apiKey . $service . 'PaymentGuide');
				$post = [
					'key' => $apiKey,
					'request' => 'payment_guide',
					'service' => $service,
					'signature' => $sign
				];

				// Menggunakan library cURL yang sudah dibuat sebelumnya
				$curl = $this->lib->curlpaydisini('https://paydisini.co.id/api/', $post);

				if ($curl) {
					$json_result = json_decode($curl, true);

					if ($json_result) {
						$data['instruksi'] = $json_result;
					} else {
						// Tangani kesalahan jika gagal mendecode JSON
						$data['instruksi'] = [];
						log_message('error', 'Gagal mendecode JSON dari API paydisini');
					}
				} else {
					$data['instruksi'] = [];
				}
			} else {
				$data['instruksi'] = [];
			}

			$this->load->view('public/deposit/detail', $data);
		} else {
			show_404(); // Tampilkan halaman 404 jika data deposit tidak ditemukan.
		}
	}

	public function confirm($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		$target = $this->deposit_model->get_row(['user_id' => user(), 'id' => $i, 'status' => 'Pending']);
		if ($target == false)
			show_404();
		$deposit_method = $this->deposit_method_model->get_row(['id' => $target->deposit_method_id, 'type' => 'auto', 'status' => '1']);
		if ($deposit_method == false)
			show_404();
		if ($this->input->post()) {
			$deposit_method_name = strtoupper($deposit_method->name);
			$gopay = $this->bank_account_model->get_row(['name' => 'gopay']);
			$ovo = $this->bank_account_model->get_row(['name' => 'ovo']);
			$bca = $this->bank_account_model->get_row(['name' => 'bca']);

			// END CHECK DEPOSIT METHOD //
			if (password_verify($this->input->post('password'), user('password')) == false) {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Password salah.'));
				exit(redirect(base_url('deposit/history')));
			} else {
				$confirm = false;
				if (preg_match("/GOPAY/", $deposit_method_name)) {
					$confirm = cekMutasi($target->amount, $this->gopay->seeMutation($gopay->access_token));
				} else if (preg_match("/OVO/", $deposit_method_name)) {
					$confirm = cekMutasi($target->amount, $this->ovo->seeMutation($ovo->access_token));
				} else if (preg_match("/BCA/", $deposit_method_name)) {
					$confirm = cekMutasi($target->amount, str_replace('.00', '', json_encode($this->bca->getTransactions('BCA', $bca->username, $bca->pin), JSON_PRETTY_PRINT)));
				} else {
					$confirm = false;
				}

				if ($confirm == true) {
					$update_deposit = $this->deposit_model->update(['status' => 'Success', 'updated_at' => date('Y-m-d H:i:s')], ['id' => $i]);
					if ($update_deposit == true) {
						$user = $this->user_model->get_by_id($target->user_id);
						$this->user_model->update([
							'balance' => $user->balance + $target->balance
						], ['id' => $user->id]);
						$this->log_balance_usage_model->insert([
							'user_id' => $user->id,
							'type' => 'plus',
							'category' => 'deposit',
							'amount' => $target->balance,
							'description' => 'Deposit #' . $i . '.',
							'created_at' => date('Y-m-d H:i:s')
						]);
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Konfirmasi deposit berhasil !!.'));
						exit(redirect(base_url('deposit/invoice/' . $i)));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan tidak terduga.'));
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'ID : ' . $target->id . '<br/>Nominal Transfer : ' . $target->amount . '<br/>Pesan: Harap transfer sesuai jumlah deposit terlebih dahulu.<br/>'));
				}
				exit(redirect(base_url('deposit/invoice/' . $i)));
			}
		}
		$this->load->view('public/deposit/confirm', ['page_type' => 'Deposit Konfirmasi', 'target' => $target]);
	}
	public function cancel($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		$target = $this->deposit_model->get_row(['user_id' => user(), 'id' => $i, 'status' => 'Pending']);
		$deposit_method = $this->deposit_method_model->get_row(['id' => $target->deposit_method_id]);

		if ($target == false) {
			show_404();
		}

		if ($this->input->post()) {
			if (password_verify($this->input->post('password'), user('password')) == false) {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Password salah.'));
				exit(redirect(base_url('deposit/history')));
			} else {
				if ($deposit_method->type == 'paydisini') {
					// post curl Canceled Deposit ke paydisini
					$apiKey = website_config('paydisini_api_key');
					$uniqueCode = $target->reference;
					$sign = md5($apiKey . $uniqueCode . 'CancelTransaction');

					$post = [
						'key' => $apiKey,
						'request' => 'cancel',
						'unique_code' => $uniqueCode,
						'signature' => $sign
					];

					// Menggunakan library cURL yang sudah dibuat sebelumnya
					$curl = $this->lib->curlpaydisini('https://paydisini.co.id/api/', $post);
					$json_result = json_decode($curl, true);

					if ($json_result['success'] == true) {
						$payment_gateway = 1;
						$data_input['amount'] = $json_result['data']['amount'];
						$data_input['reference'] = $json_result['data']['unique_code'];
						$data_input['additional_data'] = ($json_result['data']['qrcode_url'] ?? ($json_result['data']['virtual_account'] ?? ($json_result['data']['payment_code'] ?? null)));
						$data_input['result'] = json_encode($json_result['data']);
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Error: ' . $json_result['msg']));
						exit(redirect(base_url('deposit/history')));
					}

					$update_deposit = $this->deposit_model->update(['status' => 'Canceled', 'updated_at' => date('Y-m-d H:i:s')], ['id' => $i]);
					if ($update_deposit == true) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Permintaan deposit berhasil dibatalkan.'));
						// NOTIF WA //
						$hasil = $this->deposit_model->get_row(['user_id' => user(), 'id' => $i]);
						$phone = $this->lib->hp(user('whatsapp'));
						$phone1 = website_config('wa_admin');
						$message = website_config('wa_deposit_canceled');
						$message1 = website_config('wa_admin_deposit_canceled');
						$pesan = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								user('full_name'),
								user('username'),
								$i,
								$deposit_method->name,
								currency($target->amount),
								currency($target->balance),
								$hasil->status,
								$this->lib->format_date($hasil->created_at),
								$this->lib->format_date($hasil->updated_at)
							),
							$message
						);
						$pesan1 = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								user('full_name'),
								user('username'),
								$i,
								$deposit_method->name,
								currency($target->amount),
								currency($target->balance),
								$hasil->status,
								$this->lib->format_date($hasil->created_at),
								$this->lib->format_date($hasil->updated_at)
							),
							$message1
						);
						$apikey = website_config('wa_gateway_key');
							if (website_config('send_wa_deposit') == 'on') {
							$this->lib->sendMessage($apikey, $phone, $pesan);
				            $this->lib->sendMessage($apikey, $phone1, $pesan1);
						}
						// END NOTIF WA //
						exit(redirect(base_url('deposit/history/')));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan tidak terduga.'));
					}
				} else {
					$update_deposit = $this->deposit_model->update(['status' => 'Canceled', 'updated_at' => date('Y-m-d H:i:s')], ['id' => $i]);
					if ($update_deposit == true) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Permintaan deposit berhasil dibatalkan.'));
						// NOTIF WA //
						$hasil = $this->deposit_model->get_row(['user_id' => user(), 'id' => $i]);
						$phone = $this->lib->hp(user('whatsapp'));
						$phone1 = website_config('wa_admin');
						$message = website_config('wa_deposit_canceled');
						$message1 = website_config('wa_admin_deposit_canceled');
						$pesan = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								user('full_name'),
								user('username'),
								$i,
								$deposit_method->name,
								currency($target->amount),
								currency($target->balance),
								$hasil->status,
								$this->lib->format_date($hasil->created_at),
								$this->lib->format_date($hasil->updated_at)
							),
							$message
						);
						$pesan1 = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								user('full_name'),
								user('username'),
								$i,
								$deposit_method->name,
								currency($target->amount),
								currency($target->balance),
								$hasil->status,
								$this->lib->format_date($hasil->created_at),
								$this->lib->format_date($hasil->updated_at)
							),
							$message1
						);
						$apikey = website_config('wa_gateway_key');
							if (website_config('send_wa_deposit') == 'on') {
							$this->lib->sendMessage($apikey, $phone, $pesan);
				            $this->lib->sendMessage($apikey, $phone1, $pesan1);
						}
						// END NOTIF WA //
						exit(redirect(base_url('deposit/history/')));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan tidak terduga.'));
					}
				}
				exit(redirect(base_url('deposit/history/')));
			}
		}
		$this->load->view('public/deposit/cancel', ['page_type' => 'Batalkan Deposit', 'target' => $target]);
	}
	// public function graph()
	// {
	// 	if ($this->input->get('start_date') and $this->input->get('end_date') <> '') {
	// 		$start = $this->input->get('start_date');
	// 		$end = $this->input->get('end_date');
	// 	} else {
	// 		$start = date('Y-m-01');
	// 		$end = date('Y-m-d'); // Menggunakan tanggal saat ini
	// 	}
	// 	$widget = [
	// 		'success' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(amount) AS total', 'where' => [['status' => 'Success', 'user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
	// 		'canceled' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(amount) AS total', 'where' => [['status' => 'Canceled', 'user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
	// 	];
	// 	$chart_item = $this->lib->list_date_range($start, $end);
	// 	$chart = [];
	// 	foreach ($chart_item as $key => $value) {
	// 		array_push($chart, [
	// 			'date' => $value,
	// 			'count' => $this->deposit_model->get_count(['where' => [['user_id' => user(), 'DATE(created_at)' => $value]]])
	// 		]);
	// 	}
	// 	$this->render('public/deposit/graph', ['page_type' => 'Grafik Deposit', 'chart' => $chart, 'widget' => $widget]);
	// }
	public function graph()
	{
		if ($this->input->get('date')) {
			$date_range = explode(" to ", $this->input->get('date'));

			if (count($date_range) == 2) {
				// Jika ada dua bagian setelah dipecah, maka gunakan sebagai rentang tanggal
				$start = date('Y-m-d', strtotime($date_range[0]));
				$end = date('Y-m-d', strtotime($date_range[1]));
			} else {
				// Jika tidak sesuai format, atur tanggal awal dan akhir ke bulan ini
				$start = date('Y-m-01');
				$end = date('Y-m-t');
			}
		} else {
			// Jika parameter 'date' tidak ada, atur tanggal awal ke tanggal 1 dan akhir ke tanggal saat ini
			$start = date('Y-m-01');
			$end = date('Y-m-d');
		}

		$widget = [
			'pending' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Pending', 'user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
			'success' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Success', 'user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
			'canceled' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Canceled', 'user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
		];

		$chart_item = $this->lib->list_date_range($start, $end);
		$chart = [];

		foreach ($chart_item as $key => $value) {
			$chart[] = [
				'date' => $this->lib->format_chart($value),
				'all' => (int) $this->deposit_model->get_count(['where' => [['user_id' => user(), 'DATE(created_at)' => $value]]]),
				'success' => (int) $this->deposit_model->get_count(['where' => [['user_id' => user(), 'status' => 'Success', 'DATE(created_at)' => $value]]]),
				'pending' => (int) $this->deposit_model->get_count(['where' => [['user_id' => user(), 'status' => 'Pending', 'DATE(created_at)' => $value]]]),
				'canceled' => (int) $this->deposit_model->get_count(['where' => [['user_id' => user(), 'status' => 'Canceled', 'DATE(created_at)' => $value]]]),
			];
		}

		$data = [
			'page_type' => 'Grafik Deposit',
			'chart' => $chart,
			'widget' => $widget,
			'start' => $start,
			'end' => $end
		];

		$this->render('public/deposit/graph', $data);
	}
}
