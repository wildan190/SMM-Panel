<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_cookie_admin(get_cookie('admin_login'));
		if (admin() == false) exit(redirect(base_url('admin/auth/logout')));
	}
	public function hof()
	{
		if ($this->input->get('start') and $this->input->get('end')) {
			$start = $this->input->get('start');
			$end = $this->input->get('end');
		} else {
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}
		$order = $this->user_model->get_rows([
			'select' => 'user.username, SUM(order_list.price) AS rupiah, COUNT(order_list.price) AS total',
			'join' => [['table' => 'order_list', 'on' => 'order_list.user_id = user.id', 'param' => 'left outer']],
			'where' => [['user.status' => '1', 'user.id <>' => '1', 'DATE(order_list.created_at) >=' => $start, 'DATE(order_list.created_at) <=' => $end]],
			'order_by' => 'rupiah DESC',
			'group_by' => 'user.id',
			'limit' => '10',
		]);
		$deposit = $this->user_model->get_rows([
			'select' => 'user.username, SUM(deposit.balance) AS rupiah, COUNT(deposit.balance) AS total',
			'join' => [['table' => 'deposit', 'on' => 'deposit.user_id = user.id', 'param' => 'left outer']],
			'where' => [['user.status' => '1', 'user.id <>' => '1', 'DATE(deposit.created_at) >=' => $start, 'DATE(deposit.created_at) <=' => $end, 'deposit.status' => 'Success']],
			'order_by' => 'rupiah DESC',
			'group_by' => 'user.id',
			'limit' => '10',
		]);
		$this->render_admin('admin/' . $this->uri->segment(2) . '/hof', ['order' => $order, 'deposit' => $deposit, 'start' => $start, 'end' => $end]);
	}
	public function index()
	{
		// FORM INPUT //
		$field = [
			'user.id' => 'ID',
			'user.username' => 'USERNAME',
			'user.email' => 'EMAIL',
			'user.full_name' => 'NAMA LENGKAP',
			'user.level' => 'HAK AKSES',
			'user.status' => 'STATUS',
			'user.is_verif' => 'VERIFIKASI',
		];
		$operator = [
			'equal' => 'WHERE =',
			'not_equal' => 'WHERE <>',
			'less_than' => 'WHERE <=',
			'more_than' => 'WHERE >=',
			'like' => 'LIKE %value%'
		];
		$status = [
			'1' => ['status_id' => '1', 'name' => 'Aktif', 'color' => 'success'],
			'0' => ['status_id' => '0', 'name' => 'Non Aktif', 'color' => 'danger'],
		];

		$verif = [
			'1' => ['verif_id' => '1', 'name' => 'Aktif', 'color' => 'success'],
			'0' => ['verif_id' => '0', 'name' => 'Non Aktif', 'color' => 'danger'],
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'user.*',
			'order_by' => 'user.id DESC',
			'group_by' => 'user.id',
			'limit' => 30,
			'offset' => $this->uri->segment(4) ? $this->uri->segment(4) : 0
		];

		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('sort_field') <> '' and $this->input->get('sort_type') <> '') {
			if (array_key_exists($this->input->get('sort_field'), $field) == false) exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			if (in_array($this->input->get('sort_type'), array('asc', 'desc')) == false) exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			$data_query['order_by'] = $this->input->get('sort_field') . ' ' . $this->input->get('sort_type');
		}
		if ($this->input->get('field') <> '' and $this->input->get('operator') <> '' and $this->input->get('value') <> '') {
			if (array_key_exists($this->input->get('field'), $field) == false) exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			if (array_key_exists($this->input->get('operator'), $operator) == false) exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			if ($this->input->get('operator') == 'equal') {
				$data_query['where'][] = [$this->input->get('field') => $this->input->get('value')];
			} elseif ($this->input->get('operator') == 'not_equal') {
				$data_query['where'][] = [$this->input->get('field') . ' <>' => $this->input->get('value')];
			} elseif ($this->input->get('operator') == 'less_than') {
				$data_query['where'][] = [$this->input->get('field') . ' <=' => $this->input->get('value')];
			} elseif ($this->input->get('operator') == 'more_than') {
				$data_query['where'][] = [$this->input->get('field') . ' >=' => $this->input->get('value')];
			} else {
				$data_query['where'][] = $this->input->get('field') . " LIKE '%" . $this->input->get('value') . "%'";
			}
		}
		// END SORT & SEARCH
		// PAGINATION //
		if ($this->uri->segment(4) <> '' and is_numeric($this->uri->segment(4)) == false) exit('No direct script access allowed');
		$offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->user_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->user_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator, 'status' => $status, 'verif' => $verif]);
	}
	public function form($i = '')
	{
		$target = $this->user_model->get_by_id($i);
		if ($target == false) { // add
			if ($this->input->post()) {
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[5]|max_length[12]');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
				$this->form_validation->set_rules('level', 'Hak Akses', 'required|in_list[Member,Agen,Reseller,Owner]');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'username' => $this->db->escape_str($this->input->post('username')),
						'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
						'full_name' => $this->db->escape_str($this->input->post('full_name')),
						'email' => $this->db->escape_str($this->input->post('email')),
						'level' => $this->db->escape_str($this->input->post('level')),
						'balance' => '0',
						'status' => '1',
						'api_key' => $this->lib->generate_api_key(),
						'verification_key' => random_string('alnum', 200),
						'is_verif' => '1',
						'refferal_code' => time(),
						'created_at' => date('Y-m-d H:i:s'),
						'uplink' =>	1,
					];
					if ($this->user_model->get_row(['email' => $data_input['email']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Email sudah ada didatabase.'));
					} elseif ($this->user_model->get_row(['username' => $data_input['username']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username sudah ada didatabase.'));
					} else {
						$insert_data = $this->user_model->insert($data_input);
						if ($insert_data) {
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Tambah data berhasil!', 'msg' => 'Data <b>#' . $insert_data . '</b> berhasil ditambahkan.'));
							exit(redirect(base_url('admin/' . $this->uri->segment(2))));
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
			}
			$this->render_admin('admin/' . $this->uri->segment(2) . '/add');
		} else { // edit
			if ($this->input->post()) {
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[5]|max_length[12]');
				$this->form_validation->set_rules('password', 'Password', 'min_length[5]');
				$this->form_validation->set_rules('balance', 'Saldo', 'required|numeric|greater_than[-1]');
				$this->form_validation->set_rules('api_key', 'API Key', 'required');
				$this->form_validation->set_rules('level', 'Hak Akses', 'required|in_list[Member,Agen,Reseller,Owner]');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'username' => $this->db->escape_str($this->input->post('username')),
						'full_name' => $this->db->escape_str($this->input->post('full_name')),
						'email' => $this->db->escape_str($this->input->post('email')),
						'level' => $this->db->escape_str($this->input->post('level')),
						'balance' => $this->db->escape_str($this->input->post('balance')),
						'api_key' => $this->db->escape_str($this->input->post('api_key'))
					];
					if ($this->input->post('password') <> '') $data_input['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
					if ($data_input['email'] <> $target->email and $this->user_model->get_row(['email' => $data_input['email']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Email sudah ada didatabase.'));
					} elseif ($data_input['username'] <> $target->username and $this->user_model->get_row(['username' => $data_input['username']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username sudah ada didatabase.'));
					} else {
						$update_target = $this->user_model->update($data_input, ['id' => $i]);
						if ($update_target) {
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diperbaharui.'));
							exit(redirect(base_url('admin/' . $this->uri->segment(2))));
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
			}
			$this->render_admin('admin/' . $this->uri->segment(2) . '/edit', ['target' => $target]);
		}
	}
	public function delete($i = '')
	{
		$target = $this->user_model->get_by_id($i);
		if ($target == false) show_404();
		$delete_target = $this->user_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function detail($i = '')
	{
		$target = $this->user_model->get_by_id($i);
		if ($target == false) show_404();
		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target, 'total_order' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(price) AS total', 'where' => [['user_id' => $target->id]]]), 'total_deposit' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(amount) AS total', 'where' => [['user_id' => $target->id], ['status' => 'Success']]])]);
	}
	public function status($i = '', $status = '')
	{
		$target = $this->user_model->get_by_id($i);
		if ($target == false) show_404();
		if (in_array($status, ['0', '1']) == false) show_404();
		$update_target = $this->user_model->update(['status' => $status], ['id' => $i]);
		if ($update_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function verif($i = '', $status = '')
	{
		$target = $this->user_model->get_by_id($i);
		if ($target == false) show_404();
		if (in_array($status, ['0', '1']) == false) show_404();
		$update_target = $this->user_model->update(['is_verif' => $status], ['id' => $i]);
		if ($update_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status verifikasi berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function generate_api_key()
	{
		print($this->lib->generate_api_key());
	}
}
