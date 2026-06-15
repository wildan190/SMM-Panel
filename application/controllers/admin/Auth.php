<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_cookie_admin(get_cookie('admin_login'));
		if ($this->session->userdata('login_admin') and $this->uri->segment(2) <> 'logout') {
			if (admin() == false)
				exit(redirect(base_url('admin/auth/logout')));
		}
	}

	public function index()
	{
		if (admin()) {
			$chart_item = $this->lib->list_date_range(substr($this->lib->sum_date(date('Y-m-d'), '-14 days'), 0, 10), date('Y-m-d'));
			$chart = [];
			foreach ($chart_item as $key => $value) {
				array_push($chart, [
					'date' => $value,
					'service_order' => $this->order_model->get_rows([
						'select' => 'service, COUNT(service_id) AS total_service',
						'where' => [['DATE(created_at)' => $value]],
						'order_by' => 'total_service',
						'group_by' => 'service_id',
						'limit' => 3
					]),
					'order' => $this->order_model->get_count(['select' => 'id', 'where' => [['DATE(created_at)' => $value]]]),
					'refund' => $this->order_model->get_count(['select' => 'id', 'where' => [['DATE(created_at)' => $value, 'is_refund' => '1']]]),
					'deposit' => $this->deposit_model->get_count(['select' => 'id', 'where' => [['DATE(created_at)' => $value]]]),
				]);
			}
			$widget = [
				'service_order' => $this->order_model->get_rows([
					'select' => 'service, COUNT(service_id) AS total_service',
					'order_by' => 'total_service DESC',
					'group_by' => 'service_id',
					'where' => [['MONTH(order_list.created_at)' => date('m'), 'YEAR(order_list.created_at)' => date('Y')]],
					'limit' => 5
				]),
				'order' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total']),
				'refund' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total', 'where' => ["is_refund = '1'"]]),
				'deposit' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Success']]]),
				'user' => $this->user_model->get_rows(['select' => 'SUM(balance) AS rupiah, COUNT(id) AS total', 'where' => ["level != 'Owner'"]]),
				'api' => $this->api_model->get_rows(['select' => 'SUM(balance) AS rupiah, COUNT(id) AS total']),
				'chart' => $chart
			];
			$order = $this->user_model->get_rows([
				'select' => 'user.full_name, SUM(order_list.price) AS rupiah, COUNT(order_list.price) AS total',
				'join' => [['table' => 'order_list', 'on' => 'order_list.user_id = user.id', 'param' => 'right outer']],
				'where' => [['user.status' => '1', 'MONTH(order_list.created_at)' => date('m'), 'YEAR(order_list.created_at)' => date('Y')]],
				'order_by' => 'rupiah DESC',
				'group_by' => 'user.id',
				'limit' => '3',
			]);
			$this->render_admin('admin/auth/index', ['widget' => $widget, 'chart' => $chart, 'order' => $order]);
		} else {
			exit(redirect(base_url('admin/auth/login')));
		}
	}

	public function login()
	{
		if ($this->session->userdata('login_admin')) {
			exit(redirect(base_url('admin')));
		}

		// filter input = 1
		if ($this->input->post()) {
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'username' => $this->db->escape_str($this->input->post('username')),
					'password' =>  $this->db->escape_str($this->input->post('password'))
				];
				$admin = $this->admin_model->get_row(['username' => $data_input['username']]);
				if ($admin == false || !password_verify($data_input['password'], $admin->password)) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username atau Password salah.'));
					exit(redirect(base_url('admin/auth/login')));
				} else {
					// Ambil informasi browser
					$user_agent = $this->input->user_agent();
					$browser_name = $this->agent->browser();
					$browser_version = $this->agent->version();
					$platform = $this->agent->platform();
					$device = isset($_SERVER['HTTP_USER_AGENT']) ? $this->input->devices() : 'unknown';

					$data_cookie = [
						'user_id' => $admin->id,
						'cookie' => random_string('alnum', 100),
						'login' => 'admin',
						'ua' => $user_agent,
						'browser' => $browser_name,
						'browser_version' => $browser_version,
						'platform' => $platform,
						'ud' => $device,
						'created_at' => date('Y-m-d H:i:s'),
						'expired_at' => date('Y-m-d H:i:s', strtotime(($this->input->post('remember') == '1') ? '+30 days' : '+2 hours')),
					];
					$this->cookie_model->insert($data_cookie);


					if ($this->input->post('remember') == '1') {
						set_cookie('admin_login', $data_cookie['cookie'], 2592000); // 30 days
					} else {
						set_cookie('admin_login', $data_cookie['cookie'], 7200); // 2 hours
					}

					$this->log_login_admin_model->insert([
						'admin_id' => $admin->id,
						'ip_address' => $this->input->ip_address(),
						'created_at' => date('Y-m-d H:i:s'),
					]);
					$this->session->set_userdata('login_admin', $admin->id);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil Masuk', 'msg' => 'Halo ' . $admin->username . ', semoga harimu menyenangkan.'));
					exit(redirect(base_url('admin/auth/index')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('admin/auth/login')));
			}
		}

		$this->render_admin('admin/auth/login');
	}

	public function setting()
	{
		if (admin() == false) {
			exit(redirect(base_url()));
		}
		if ($this->input->post()) {
			$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
			$this->form_validation->set_rules('new_password', 'Password Baru', 'min_length[5]');
			$this->form_validation->set_rules('confirm_new_password', 'Konfirmasi Password Baru', 'matches[new_password]');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'full_name' => $this->db->escape_str($this->input->post('full_name'))
				];
				if ($this->input->post('new_password') <> '') {
					$data_input['password'] = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
				}
				if (!password_verify($this->input->post('password'), admin('password'))) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Password salah.'));
				} else {
					$update_admin = $this->admin_model->update($data_input, ['id' => admin()]);
					if ($update_admin) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan akun berhasil!', 'msg' => 'Informasi akun Anda berhasil diperbaharui.'));
						exit(redirect(base_url('admin/auth/setting')));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					}
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render_admin('admin/auth/setting');
	}

	public function logout()
	{
		if ($this->session->userdata('login_admin') == false) {
			exit(redirect(base_url('admin')));
		}
		$this->cookie_model->delete(['cookie' => get_cookie('admin_login')]);
		delete_cookie('admin_login');
		$this->session->unset_userdata('login_admin');
		$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil Keluar', 'msg' => 'Sampai jumpa kembali.'));
		redirect(base_url('admin/auth/login'));
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
			'where' => [['user_id' => admin(), 'login' => 'admin']],
			'order_by' => 'id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(4)) ? $this->uri->segment(4) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/session')));
			$data_query['limit'] = $this->input->get('rows');
		}
		// END SORT & SEARCH
		// PAGINATION //
		// PAGINATION //
		if ($this->uri->segment(4) <> '' and is_numeric($this->uri->segment(4)) == false)
			exit('No direct script access allowed');

		$cookieValue = get_cookie('admin_login');
		$browser = $this->cookie_model->get_by_value($cookieValue);

		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/session');
		$config['total_rows'] = $this->cookie_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/auth/session', ['page_type' => 'Sesi Aktif', 'table' => $this->cookie_model->get_rows($data_query), 'browser' => $browser, 'total_data' => $config['total_rows'], 'rows' => $rows, 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}
	public function cabut_sesi($i = '')
	{
		// Validasi admin untuk cookie model
		$user_id = admin();
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

		// Redirect ke halaman sesi admin
		redirect(base_url('admin/auth/session/'));
	}
}
