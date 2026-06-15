<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
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
		$this->load->library('user_agent');
	}
	public function read_popup()
	{
		$this->user_model->update(['is_read_popup' => '1'], ['id' => user()]);
	}

	public function mode($mode = '')
	{
		$this->user_model->update(['mode' => $mode], ['id' => user()]);
		redirect($this->agent->referrer());
	}

	public function layout($layout = '')
	{
		$this->user_model->update(['layout' => $layout], ['id' => user()]);
		redirect($this->agent->referrer());
	}

	public function log_login()
	{
		// filter input = 1
		// FORM INPUT //
		if ($this->input->get('start_date') and $this->input->get('end_date') <> '') {
			$start = $this->input->get('start_date');
			$end = $this->input->get('end_date');
		} else {
			$start = date('2000-01-01');
			$end = date('Y-m-t');
		}
		$rows = [
			'10' => '10',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'where' => [['user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]],
			'order_by' => 'id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('user/log_login')));
			$data_query['limit'] = $this->input->get('rows');
		}

		if ($this->input->get('search') <> '') {
			$data_query['where'][] = "ip LIKE '%" . $this->db->escape_str(strip_tags($this->input->get('search'))) . "%'";
		}
		// END SORT & SEARCH
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit('shafou.com');
		$config['base_url'] = base_url('user/log_login');
		$config['total_rows'] = $this->log_login_user_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/user/log_login', ['page_type' => 'Log Masuk', 'table' => $this->log_login_user_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'rows' => $rows, 'start' => $start, 'end' => $end, 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}
	public function log_balance_usage()
	{
		// filter input = 1
		// FORM INPUT //
		if ($this->input->get('start_date') and $this->input->get('end_date') <> '') {
			$start = $this->input->get('start_date');
			$end = $this->input->get('end_date');
		} else {
			$start = date('2000-01-01');
			$end = date('Y-m-t');
		}
		$rows = [
			'10' => '10',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];
		$category = [
			'place order' => 'PLACE ORDER',
			'deposit' => 'DEPOSIT',
			'refund order' => 'REFUND ORDER',
			'komisi referral' => 'KOMISI REFERRAL',
			'payout point' => 'PAYOUT POINT',
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'where' => [['user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]],
			'order_by' => 'id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('user/log_balance_usage')));
			$data_query['limit'] = $this->input->get('rows');
		}
		if ($this->input->get('search') <> '') {
			$data_query['where'][] = "amount LIKE '%" . $this->db->escape_str(strip_tags($this->input->get('search'))) . "%'";
		}
		if ($this->input->get('category') <> '') {
			if (array_key_exists($this->input->get('category'), $category) == false)
				exit(redirect(base_url('user/log_balance_usage')));
			$data_query['where'][]['category'] = $this->input->get('category');
		}
		// END SORT & SEARCH
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit('shafou.com');

		$kategori = $this->input->get('category');

		$minus_where = [['type' => 'minus', 'user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]];
		$plus_where = [['type' => 'plus', 'user_id' => user(), 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]];

		if (!empty($kategori)) {
			$minus_where[] = ['category' => $kategori];
			$plus_where[] = ['category' => $kategori];
		}

		$widget = [
			'minus' => $this->log_balance_usage_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => $minus_where]),
			'plus' => $this->log_balance_usage_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => $plus_where]),
		];
		$config['base_url'] = base_url('user/log_balance_usage');
		$config['total_rows'] = $this->log_balance_usage_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/user/log_balance_usage', ['page_type' => 'Mutasi Saldo', 'table' => $this->log_balance_usage_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'rows' => $rows, 'category' => $category, 'widget' => $widget, 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}
	public function setting()
	{
		if ($this->input->get('act') == 'theme') {
			$original_layout = user('layout');

			$data_input = [
				'mode' => $this->db->escape_str($this->input->post('theme_mode')),
				'contrast' => $this->db->escape_str($this->input->post('theme_contrast')),
				'layout' => ($this->input->post('theme_preset') == $original_layout) ? $original_layout : $this->db->escape_str($this->input->post('theme_preset')),
			];

			$update_user = $this->user_model->update($data_input, ['id' => user()]);
			if ($update_user) {
				$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil', 'msg' => 'Tema telah di perbarui.'));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal', 'msg' => 'Tidak ada perubahan tema.'));
			}
			redirect($this->agent->referrer());
		} elseif ($this->input->get('act') == 'reset_theme') {
			$data_input = [
				'mode' => 'light',
				'contrast' => 'false',
				'layout' => website_config('color_theme')
			];

			$update_user = $this->user_model->update($data_input, ['id' => user()]);
			if ($update_user) {
				$this->session->set_flashdata('result', ['alert' => 'success', 'title' => 'Berhasil', 'msg' => 'Tema di reset.']);
			} else {
				$this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal', 'msg' => 'Terjadi kesalahan.']);
			}

			// Hapus redirect yang tidak perlu di sini
			redirect($this->agent->referrer());
		} elseif ($this->input->get('act') == 'foto') {

			if ($this->input->method() === 'post') {

				// Menyiapkan upload foto profil
				$file_name = user('username') . '_' . time(); // Nama file unik dengan ID pengguna dan timestamp

				$config['upload_path'] = FCPATH . '/uploads/profil/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['file_name'] = $file_name;
				$config['overwrite'] = false;
				$config['max_size'] = 5120;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('foto_profil')) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => $this->upload->display_errors()));
					redirect(base_url('user/setting'));
				} else {
					$uploaded_data = $this->upload->data();

					// Memperbarui database dengan referensi nama file yang baru
					$update_user = $this->user_model->update(['foto' => $uploaded_data['file_name'], 'crop_foto' => '0'], ['id' => user('id')]);
					if ($update_user) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Foto Profil berhasil diubah.'));
						redirect(base_url('user/setting'));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						redirect(base_url('user/setting'));
					}
				}
			}
		} elseif ($this->input->get('act') == 'reset_foto') {
			$user = user();
			if (!$user) {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Akses tidak diizinkan.'));
				exit(redirect(base_url()));
			} else {
				// Mendapatkan username pengguna
				$username = user('username');

				// Mencari file-file dengan nama yang berhubungan dengan username
				$filesToDelete = glob(FCPATH . "/uploads/profil/{$username}_*.*");

				// Menghapus semua file yang ditemukan
				foreach ($filesToDelete as $file) {
					unlink($file);
				}

				if (user('gender') == 'male') {
					// Set foto menjadi male.jpg
					$update_user = $this->user_model->update(['foto' => 'male.jpg', 'crop_foto' => '1'], ['id' => user('id')]);
				} else { // Set foto menjadi female.jpg
					$update_user = $this->user_model->update(['foto' => 'female.jpg', 'crop_foto' => '1'], ['id' => user('id')]);
				}

				if ($update_user) {
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Foto Profil berhasil direset.'));
					redirect(base_url('user/setting'));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					redirect(base_url('user/setting'));
				}
			}
		} elseif ($this->input->get('act') == 'password') {
			if ($this->input->post()) {
				$this->form_validation->set_rules('new_password', 'Password Baru', 'min_length[5]');
				$this->form_validation->set_rules('confirm_new_password', 'Konfirmasi Password Baru', 'matches[new_password]');
				$this->form_validation->set_rules('password', 'Password', 'required');
				if ($this->form_validation->run() == true) {

					if ($this->input->post('new_password') <> '') {
						$data_input['password'] = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
					}

					if (password_verify($this->input->post('password'), user('password')) == false) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Password salah.'));
					} else {
						$update_user = $this->user_model->update($data_input, ['id' => user()]);
						if ($update_user) {

							$this->cookie_model->delete(['user_id' => user(), 'login' => 'user']);

							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Password berhasil di ganti. Silahkan login kembali menggunakan Password terbaru.'));
							exit(redirect(base_url('auth/login')));
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
			}
		} else {
			if ($this->input->get('act') == 'profil') {
				if ($this->input->post()) {
					$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|alpha_numeric_spaces|min_length[1]|max_length[20]');
					$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
					$this->form_validation->set_rules('password', 'Password', 'required');

					// Periksa apakah ada perubahan pada Telegram atau WhatsApp
					$telegram_changed = ($this->input->post('telegram') != user('telegram'));
					$whatsapp_changed = ($this->input->post('whatsapp') != user('whatsapp'));

					if ($telegram_changed) {
						$this->form_validation->set_rules('telegram', 'Username Telegram', 'trim|is_unique[user.telegram]', array('is_unique' => 'Username Telegram sudah tertaut dengan akun lain.'));
					}

					if ($whatsapp_changed) {
						$this->form_validation->set_rules('whatsapp', 'Nomor WhatsApp', 'trim|is_unique[user.whatsapp]', array('is_unique' => 'Nomor WhatsApp sudah tertaut dengan akun lain.'));
					}

					if ($this->form_validation->run() == true) {
						$data_input = [
							'full_name' => $this->db->escape_str($this->input->post('full_name')),
							'gender' => $this->db->escape_str($this->input->post('gender')),
						];

						// Update Telegram dan WhatsApp hanya jika ada perubahan
						if ($telegram_changed) {
							$data_input['telegram'] = $this->db->escape_str($this->input->post('telegram'));
						}

						if ($whatsapp_changed) {
							$data_input['whatsapp'] = $this->db->escape_str($this->input->post('whatsapp'));
						}

						if (password_verify($this->input->post('password'), user('password')) == false) {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Password salah.'));
						} else {
							$update_user = $this->user_model->update($data_input, ['id' => user()]);
							if ($update_user) {
								$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Informasi akun Anda berhasil diperbaharui.'));
								exit(redirect(base_url('user/setting')));
							} else {
								$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
							}
						}
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
					}
				}
			}
		}
		$this->render('public/user/setting', ['page_type' => 'Pengaturan']);
	}

	public function session()
	{
		$rows = [
			'10' => '10',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'where' => [['user_id' => user(), 'login' => 'user']],
			'order_by' => 'id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('user/session')));
			$data_query['limit'] = $this->input->get('rows');
		}
		// END SORT & SEARCH
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit('shafou.com');

		$cookieValue = get_cookie('smm_login');
		$browser = $this->cookie_model->get_by_value($cookieValue);

		$config['base_url'] = base_url('user/session');
		$config['total_rows'] = $this->cookie_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/user/session', ['page_type' => 'Sesi Aktif', 'table' => $this->cookie_model->get_rows($data_query), 'browser' => $browser, 'total_data' => $config['total_rows'], 'rows' => $rows, 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}

	public function cabut_sesi($i = '')
	{
		// Validasi user untuk cookie model
		$user_id = user();
		$target = $this->cookie_model->get_row(['id' => $i, 'user_id' => $user_id]);

		if (!$target) {
			// Tampilkan 404 jika sesi tidak ditemukan atau bukan milik user
			show_404();
		}

		// Hapus sesi jika validasi berhasil
		$delete_target = $this->cookie_model->delete(['id' => $i]);

		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil', 'msg' => 'Sesi berhasil di cabut.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}

		// Redirect ke halaman sesi user
		redirect(base_url('user/session/'));
	}
	public function benefit($i = '')
	{
		$i = $this->db->escape_str($i);
		$next = '';
		$prev = '';

		if ($i == 'Silver') {
			$prev = 'null';
			$next = 'Gold';
		} elseif ($i == 'Gold') {
			$prev = 'Silver';
			$next = 'Platinum';
		} elseif ($i == 'Platinum') {
			$prev = 'Gold';
			$next = 'Diamond';
		} elseif ($i == 'Diamond') {
			$prev = 'Platinum';
			$next = 'null';
		}

		// Mengambil informasi benefit sesuai dengan tipe
		$benefit_info = $this->get_benefit_info($i);
		$next_benefit_info = $this->get_next_benefit_info($i); // Mendapatkan informasi untuk level berikutnya
		$data['next_benefit'] = $next;
		$data['prev_benefit'] = $prev;
		$data['benefit_info'] = $benefit_info; // Menambahkan informasi benefit ke data yang akan dikirim ke view
		$data['next_benefit_info'] = $next_benefit_info; // Menambahkan informasi benefit level berikutnya
		$data['total_order'] = $this->order_model->get_rows([
			'select' => 'SUM(price) AS total_rupiah, COUNT(price) AS total_order',
			'where' => [['user_id' => user()]]
		]);

		$this->load->view('public/user/benefit', $data);
	}

	private function get_benefit_info($type)
	{
		// Implementasikan logika untuk mengambil informasi benefit, min_payout, dan rate_payout sesuai dengan tipe (Silver, Gold, Platinum, Diamond)

		switch ($type) {
			case 'Silver':
			case 'Gold':
			case 'Platinum':
			case 'Diamond':
				return [
					'min_payout' => benefit('min_payout', $type) ?? 0,
					'rate_payout' => benefit('rate_payout', $type) ?? 0,
					'trx' => benefit('trx', $type) ?? 0,
					'title' => $type
				];
			default:
				return ['min_payout' => 0, 'rate_payout' => 0, 'trx' => 0, 'title' => 'Level tidak ditemukan'];
		}
	}

	private function get_next_benefit_info($type)
	{
		// Implementasikan logika untuk mengambil informasi benefit, min_payout, dan rate_payout sesuai dengan tipe level berikutnya (Silver, Gold, Platinum, Diamond)
		switch ($type) {
			case 'Silver':
			case 'Gold':
			case 'Platinum':
			case 'Diamond':
				return [
					'min_payout' => benefit('min_payout', $type) ?? 0,
					'rate_payout' => benefit('rate_payout', $type) ?? 0,
					'trx' => benefit('trx', $type) ?? 0,
					'title' => $type
				];
			default:
				return ['min_payout' => 0, 'rate_payout' => 0, 'trx' => 0, 'title' => 'Level tidak ditemukan'];
		}
	}
}
