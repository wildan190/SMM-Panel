<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank_account extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_cookie_admin(get_cookie('admin_login'));
		if (admin() == false) exit(redirect(base_url('admin/auth/logout')));
		if (admin('level') <> 'owner') {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Akses Tidak Sah!', 'msg' => 'Anda tidak memiliki akses ke halaman tersebut.'));
			exit(redirect(base_url('admin')));
		}
		$this->load->model(array(
			'bank_account_model',

		));
		$this->load->library('Gopay');
		$this->load->library('Ovo');
		$this->load->library('Bca');
		$this->load->library('user_agent');
	}
	public function index()
	{
		$data = [
			'page' => 'Akun Bank',
			'borneo_gateway' => [
				'api_key' => website_config('borneo_gateway_token'),
				'bank_provider' => [
					'bca' => 'BCA',
					'bni' => 'BNI',
					'gopay' => 'GOPAY',
					'ovo' => 'OVO'
				],
				'bank_account' => $this->bank_account_model->get_rows([
					'where' => [[
						'payment_gateway' => 'borneo_gateway'
					]]
				])
			],
			'cekmutasi' => [
				'api_key' => website_config('cek_mutasi_token'),
				'bank_provider' => [
					'bca' => 'BCA',
					'bri' => 'BRI',
					'bni' => 'BNI',
					'mandiri' => 'MANDIRI',
					'mandiri_online ' => 'MANDIRI ONLINE',
					'btpn_jenius ' => 'BTPN JENIUS'
				],
				'bank_account' => $this->bank_account_model->get_rows([
					'where' => [[
						'payment_gateway' => 'cekmutasi'
					]]
				])
			],
		];
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', $data);
	}
	public function borneo_gateway()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		if ($this->input->post()) {
			$bank_provider = ['bca', 'bni', 'gopay', 'ovo'];
			set_website_config('borneo_gateway_token', $this->input->post('borneo_gateway_token'));
			[
				'bca' => $this->input->post('borneo_gateway_bca'),
				'bni' => $this->input->post('borneo_gateway_bni'),
				'gopay' => $this->input->post('borneo_gateway_gopay'),
				'ovo' => $this->input->post('borneo_gateway_ovo'),
			];
			foreach ($bank_provider as $key => $value) {
				$this->bank_account_model->update([
					'username' => null,
					'pin' => null,
					'otp' => null,
					'token' => null,
					'access_token' => $this->input->post('borneo_gateway_' . $value)
				], ['name' => $value, 'payment_gateway' => 'borneo_gateway']);
			}
			return $this->output->set_content_type('application/json')->set_output(json_encode([
				'result' => true,
				'type' => 'alert',
				'msg' => 'Update Akun Bank Borneo Gateway Berhasil !!.',
				'redirect_url' => $this->agent->referrer()
			]));
		}
	}
	public function cek_mutasi()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		if ($this->input->post()) {
			$bank_provider = ['bca', 'bri', 'mandiri', 'bni', 'mandiri_online', 'btpn_jenius'];
			set_website_config('cekmutasi_token', $this->input->post('cekmutasi_token'));
			foreach ($bank_provider as $key => $value) {
				$this->bank_account_model->update([
					'username' => $this->input->post('cekmutasi_' . $value),
					'pin' => null,
					'otp' => null,
					'token' => null,
					'access_token' => null
				], ['name' => $value, 'payment_gateway' => 'cekmutasi']);
			}
			return $this->output->set_content_type('application/json')->set_output(json_encode([
				'result' => true,
				'type' => 'alert',
				'msg' => 'Update Akun Bank Cek Mutasi Berhasil !!.',
				'redirect_url' => $this->agent->referrer()
			]));
		}
	}
	public function gopay($i = false)
	{
		$gopay = $this->bank_account_model->get_row(['name' => 'gopay']);
		if ($i == '1') {  //KIRIM OTP
			$this->form_validation->set_rules('nomor', 'Nomor', 'required|numeric');
			if ($this->form_validation->run() == true) {
				$data_input['username'] = $this->input->post('nomor');
				$send_otp = $this->gopay->sendRequest($data_input['username']);
				if ($send_otp) {
					$data_input['token'] = $send_otp;
					$this->bank_account_model->update($data_input, ['name' => 'gopay']);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sip, kode otp berhasil dikirim'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/gopay')));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/gopay')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/gopay')));
			}
		} elseif ($i == '2') {  //VERIFIKASI OTP
			$this->form_validation->set_rules('otp', 'Kode OTP', 'required|numeric');
			if ($this->form_validation->run() == true) {
				$data_input['otp'] = $this->input->post('otp');
				$confirm_otp = $this->gopay->konfirmasiCode($gopay->token, $data_input['otp'], $gopay->username);
				if ($confirm_otp <> 'Failed') {
					$data_input['access_token'] = $confirm_otp;
					$this->bank_account_model->update($data_input, ['name' => 'gopay']);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sip, autentikasi berhasil.'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/gopay')));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/gopay')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/gopay')));
			}
		} elseif ($i == '3') { // RESET
			$mutation_gopay = $this->gopay->seeMutation($gopay->access_token);
			//print_r(json_decode($mutation_gopay, true));
			$result = json_decode($mutation_gopay, true);
			if (!isset($result['data'])) {
				echo 'Terjadi Kesalahan !!';
				$result['data']['success'][0]['effective_balance_after_transaction'];
			} else {
				foreach ($result['data']['success'] as $key => $value) {
					if ($value['type'] == 'credit') {
						echo '==========================</br>';
						echo '<b>Type </b>: ' . strtoupper($value['type']) . '</br>';
						echo '<b>Ref Transaksi </b>: ' . $value['transaction_ref'] . '</br>';
						echo '<b>Deskripsi </b>: ' . $value['description'] . '</br>';
						echo '<b>Jumlah </b>: ' . $value['amount']['value'] . '</br>';
						echo '<b>Waktu </b>: ' . substr($value['transacted_at'], 0, 19) . '</br>';
						echo '==========================</br>';
					} else {
						echo '<b>Tidak ada tipe credit dalam mutasi </b></br>';
					}
				}
			}
		} elseif ($i == '4') {  //RESET
			$data_update = [
				'username' => '',
				'otp' => '',
				'token' => '',
				'access_token' => ''
			];
			if ($this->bank_account_model->update($data_update, ['name' => 'gopay'])) {
				$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sip, Reset berhasil.'));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/gopay')));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan.'));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/gopay')));
			}
		} else {
			$data = [
				'page' => 'Akun Gopay',
				'gopay' => $gopay
			];
			$this->render_admin('admin/' . $this->uri->segment(2) . '/gopay', $data);
		}
	}
	public function ovo($i = false)
	{
		$ovo = $this->bank_account_model->get_row(['name' => 'ovo']);
		if ($i == '1') {  //KIRIM OTP
			$this->form_validation->set_rules('nomor', 'Nomor', 'required|numeric');
			if ($this->form_validation->run() == true) {
				$data_input['username'] = $this->input->post('nomor');
				$data_input['token'] = $this->ovo->getDevice();
				$send_otp = $this->ovo->sendRequest2FA($data_input['username'], $data_input['token']);
				if ($send_otp == true) {
					$this->lib->print_data($send_otp);

					$this->bank_account_model->update($data_input, ['name' => 'ovo']);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sip, kode otp berhasil dikirim'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
				} else {
					$this->lib->print_data($send_otp);
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
			}
		} else if ($i == '2') {  //VERIFIKASI OTP
			$this->form_validation->set_rules('otp', 'Kode OTP', 'required|numeric');
			if ($this->form_validation->run() == true) {
				$data_input['otp'] = $this->input->post('otp');
				$confirm_otp = $this->ovo->konfirmasiCode($ovo->username, $ovo->token, $data_input['otp']);
				if ($confirm_otp == true) {
					$data_input['access_token'] = $confirm_otp;
					$this->bank_account_model->update($data_input, ['name' => 'ovo']);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sip, verifikasi otp berhasil.'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
			}
		} elseif ($i == '3') {  //VERIFIKASI PIN
			$this->form_validation->set_rules('pin', 'Kode PIN', 'required|numeric');
			if ($this->form_validation->run() == true) {
				$data_input['pin'] = $this->input->post('pin');
				$result = $this->ovo->konfirmasiSecurityCode($ovo->username, $ovo->token, $data_input['pin']);
				if ($result['status'] == true) {
					$data_input['access_token'] = $result['data'];
					$this->bank_account_model->update($data_input, ['name' => 'ovo']);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sip, autentikasi berhasil.'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
			}
		} elseif ($i == '4') {  //GET MUTATION
			$mutation_ovo = $this->ovo->seeMutation($ovo->access_token);
			$result = json_decode($mutation_ovo, true);
			print_r($result);
			if (!$result[0]) {
				echo 'Terjadi Kesalahan !!';
				$result['data']['success'][0]['effective_balance_after_transaction'];
			} else {
				foreach ($result as $key => $value) {
					echo 'MENAMBAH DATA MUTASI OVO BERHASIL</br>';
					echo '==========================</br>';
					echo '<b>Ref Transaksi </b>: ' . $value['merchant_invoice'] . '</br>';
					echo '<b>Pengirim </b>: ' . $value['desc3'] . '</br>';
					echo '<b>Deskripsi </b>: ' . $value['desc1'] . '</br>';
					echo '<b>Jumlah </b>: ' . $value['emoney_topup'] . '</br>';
					echo '<b>Waktu </b>: ' . $value['transaction_date'] . '  ' . $value['transaction_time'] . '</br>';
					echo '==========================</br>';
				}
			}
		} elseif ($i == '5') {  //RESET
			$data_update = [
				'username' => '',
				'otp' => '',
				'pin' => '',
				'token' => '',
				'access_token' => ''
			];
			if ($this->bank_account_model->update($data_update, ['name' => 'ovo'])) {
				$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sip, Reset berhasil.'));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan.'));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/ovo')));
			}
		} else {
			$data = [
				'page' => 'Akun Ovo',
				'ovo' => $ovo
			];
			$this->render_admin('admin/' . $this->uri->segment(2) . '/ovo', $data);
		}
	}
	public function bca($i = false)
	{
		$bca = $this->bank_account_model->get_row(['name' => 'bca']);
		if ($i == '1') { // UPDATE DATA BCA
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('pin', 'Pin', 'required');
			if ($this->form_validation->run() == true) {
				$data_input['username'] = $this->input->post('username');
				$data_input['pin'] = $this->input->post('pin');
				if ($this->bank_account_model->update($data_input, ['name' => 'bca'])) {
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sip, data akun bca berhasil diupdate'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/bca')));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/bca')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/bca')));
			}
		} else if ($i == '2') {  //MUTASI
			$curl = json_decode($this->lib->curl('https:user-side.xyz/api/mutation/bca', [
				'username' =>  $bca->username,
				'password' => $bca->pin
			]), true);
			if ($curl['status'] === false) {
				exit('Gagal: ' . $curl['data']['message']);
			} else {
				foreach ($curl['data'] as $val) {
					if ($val['type'] == 'CR') { // MENDAPATKAN MUTASI TIPE CREDIT
						echo '==========================</br>';
						if ($this->bank_mutation_model->get_row(['type' => 'bank', 'name' => 'bca', 'amount' => $val['amount'], 'description' => $val['note']]) == true) {
							echo '<b>Data mutasi sudah tersedia </b></br>';
						} else {
							$data_input = [
								'type' => 'bank',
								'name' => 'bca',
								'transaction_id' => null,
								'amount' => $val['amount'],
								'description' => $val['note'],
								'created_at' => date('Y-m-d H:i:s'),
							];
							if ($this->bank_mutation_model->insert($data_input)) {
								echo '==========================</br>';
								echo 'MENAMBAH DATA MUTASI BCA BERHASIL</br>';
								echo '==========================</br>';
								echo '<b>Deskripsi </b>: ' . $val['note'] . '</br>';
								echo '<b>Jumlah </b>: ' . $val['amount'] . '</br>';
								echo '<b>Waktu </b>: ' . $val['transaction_at'] . '</br>';
								echo '==========================</br>';
							} else {
								echo 'Terjadi Kesalahan 2</br>';
							}
						}
					}  //SELESAI MENDAPATKAN MUTASI TIPE CREDIT
					ob_flush();
					flush();
				}
			}
		} else {
			$data = [
				'page' => 'Akun BCA',
				'bca' => $bca
			];
			$this->render_admin('admin/' . $this->uri->segment(2) . '/bca', $data);
		}
	}
}
