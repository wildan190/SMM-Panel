<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (website_config('mt_web') == 1) {
			exit(redirect(base_url('maintenance')));
		}
		check_cookie(get_cookie('smm_login'));
		if (user() == false) exit(redirect(base_url('auth/logout')));
		if (user('level') == 'Member') exit(redirect(base_url()));
	}
	public function add_user()
	{
		$price_bonus = [
			'Member' => ['price' => '0', 'bonus' => '0'],
			'Agen' => ['price' => '25000', 'bonus' => '10000'],
			'Reseller' => ['price' => '75000', 'bonus' => '50000'],
		];
		if (user('level') == 'Owner') {
			$list_level = ['Member', 'Agen', 'Reseller'];
		} elseif (user('level') == 'Reseller') {
			$list_level = ['Member', 'Agen'];
		} elseif (user('level') == 'Agen') {
			$list_level = ['Member'];
		} else {
			exit(redirect(base_url()));
		}
		$valid_level = '';
		foreach ($list_level as $key => $value) {
			$valid_level .= $value;
			if ($key < (count($list_level) - 1)) $valid_level .= ',';
		}
		if ($this->input->post()) {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
			$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
			$this->form_validation->set_rules('level', 'Hak Akses', 'required|in_list[' . $valid_level . ']');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'username' => $this->db->escape_str($this->input->post('username')),
					'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
					'full_name' => $this->db->escape_str($this->input->post('full_name')),
					'email' => $this->db->escape_str($this->input->post('email')),
					'level' => $this->input->post('level'),
					'balance' => $price_bonus[$this->input->post('level')]['bonus'],
					'status' => '1',
					'api_key' => $this->lib->generate_api_key(),
					'verification_key' => random_string('alnum', 200),
					'is_verif' => '1',
					'created_at' => date('Y-m-d H:i:s')
				];
				if (user('balance') < $price_bonus[$this->input->post('level')]['price']) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Sisa saldo Anda tidak cukup untuk melakukan pendaftaran pengguna.'));
				} elseif ($this->user_model->get_row(['email' => $data_input['email']])) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Email sudah terdaftar.'));
				} elseif ($this->user_model->get_row(['username' => $data_input['username']])) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username sudah terdaftar.'));
				} else {
					$this->db->trans_start();
					$update_user = $this->user_model->update([
						'balance' => user('balance') - $price_bonus[$this->input->post('level')]['price']
					], ['id' => user()]);
					if ($update_user) {
						$insert_data = $this->user_model->insert($data_input);
						if ($insert_data) {
							$log_balance = $this->log_balance_usage_model->insert([
								'user_id' => user(),
								'type' => 'minus',
								'category' => 'add user',
								'amount' => $price_bonus[$this->input->post('level')]['price'],
								'description' => 'Pendaftaran pengguna #' . $data_input['username'] . '.',
								'created_at' => date('Y-m-d H:i:s')
							]);
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Pengguna berhasil didaftarkan!', 'msg' => 'Username: ' . $data_input['username'] . '<br />Password: ' . $this->input->post('password')));
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
					$this->db->trans_complete();
				}
				exit(redirect(base_url('staff/add_user')));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render('public/staff/add_user', ['page_type' => 'Tambah Pengguna', 'list_level' => $list_level, 'price_bonus' => $price_bonus]);
	}
	public function balance_transfer()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
			$this->form_validation->set_rules('amount', 'Jumlah Transfer Saldo', 'required|greater_than[999]');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'username' => strtolower($this->input->post('username')),
					'amount' => $this->input->post('amount')
				];
				$saldo_awal = $this->user_model->get_by_id(user());
				$target = $this->user_model->get_row(['username' => $data_input['username']]);
				if ($target == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username tidak terdaftar.'));
				} elseif ($data_input['username'] == user('username')) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username tidak terdaftar.'));
				} elseif (user('balance') < $data_input['amount']) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Sisa saldo Anda tidak cukup untuk melakukan transfer saldo.'));
				} else {
					$this->db->trans_start();
					$update_user = $this->user_model->update([
						'balance' => user('balance') - $data_input['amount']
					], ['id' => user()]);
					if ($update_user) {
						$update_target = $this->user_model->update([
							'balance' => $target->balance + $data_input['amount']
						], ['id' => $target->id]);
						if ($update_target) {
							$this->log_balance_usage_model->insert([
								'user_id' => user(),
								'type' => 'minus',
								'category' => 'balance transfer',
								'amount' => $data_input['amount'],
								'description' => 'Transfer saldo ke pengguna #' . $data_input['username'] . '.',
								'before' => $saldo_awal->balance,
								'after' => $saldo_awal->balance - $data_input['amount'],
								'created_at' => date('Y-m-d H:i:s')
							]);
							$this->log_balance_usage_model->insert([
								'user_id' => $target->id,
								'type' => 'plus',
								'category' => 'deposit',
								'amount' => $data_input['amount'],
								'description' => 'Transfer saldo dari pengguna #' . user('username') . '.',
								'before' => $target->balance,
								'after' => $target->balance + $data_input['amount'],
								'created_at' => date('Y-m-d H:i:s')
							]);
							$this->deposit_model->insert([
								'user_id' => $target->id,
								'deposit_method_id' => '1',
								'amount' => $data_input['amount'],
								'balance' => $data_input['amount'],
								'status' => 'Success',
								'phone_number' => null,
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s'),
							]);
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Transfer saldo berhasil!', 'msg' => 'Username (Penerima): ' . $data_input['username'] . '<br />Jumlah Transfer Saldo: Rp ' . number_format($data_input['amount'], 0, ',', '.')));
							// NOTIF WA //
							$nama = $target->full_name;
							$pengirim = user('username');
							$phone = $this->lib->hp($target->whatsapp);
							$pesan = "Hallo _" . $nama . "_,
			
Kamu telah mendapatkan transfer saldo ke akun mu.
							
*- Pengirim:* " . $pengirim . "
*- Jumlah Saldo:* Rp " . number_format($data_input['amount'], 0, ',', '.') . "
			
Terimakasih telah menggunakan *" . website_config('title') . "*";

							if (website_config('send_wa_deposit') == 'on') {
								$this->lib->sendMessage($apikey, $phone, $pesan);
							}
							// END NOTIF WA //
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
					$this->db->trans_complete();
				}
				exit(redirect(base_url('staff/balance_transfer')));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render('public/staff/balance_transfer', [
			'page_type' => 'Transfer Saldo',
		]);
	}
}
