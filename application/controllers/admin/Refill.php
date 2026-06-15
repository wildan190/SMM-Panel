<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refill extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_cookie_admin(get_cookie('admin_login'));
		if (admin() == false) exit(redirect(base_url('admin/auth/logout')));
	}
	public function index()
	{
		// FORM INPUT //
		$field = [
			'refill.id' => 'ID',
			'refill.order_id' => 'ORDER ID',
			'refill.created_at' => 'TANGGAL/WAKTU',
			'refil.service' => 'PENGGUNA',
			'refill.target' => 'TARGET',
			'refill.status' => 'STATUS',
		];
		$operator = [
			'equal' => 'WHERE =',
			'not_equal' => 'WHERE <>',
			'less_than' => 'WHERE <=',
			'more_than' => 'WHERE >=',
			'like' => 'LIKE %value%'
		];
		$status = [
			'Pending' => ['name' => 'Pending', 'color' => 'warning'],
			'Processing' => ['name' => 'Processing', 'color' => 'info'],
			'Success' => ['name' => 'Success', 'color' => 'success'],
			'Error' => ['name' => 'Error', 'color' => 'danger'],
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'refill.*, user.username as user_name, api.name as api_name',
			'join' => [
				[
					'table' => 'user',
					'on' => 'user.id = refill.user_id',
					'param' => 'LEFT'
				],
				[
					'table' => 'api',
					'on' => 'api.id = refill.api_id',
					'param' => 'LEFT'
				],
			],
			'where' => [['refill.target <>' => 'bot_fake_order'], ($this->input->get('status')) ? ['refill.status' => $this->input->get('status')] : ['refill.status <>' => 'MVHIRDPY']],
			'order_by' => 'refill.id DESC',
			'limit' => '30',
			'offset' => ($this->uri->segment(4)) ? $this->uri->segment(4) : 0
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
		// SESSION FILTER //
		if ($this->session->userdata('filter_order_user') <> '') {
			$data_query['where'][]['refill.user_id'] = $this->session->userdata('filter_order_user');
		}
		if ($this->session->userdata('filter_order_status') <> '') {
			$data_query['where'][]['refill.status'] = $this->session->userdata('filter_order_status');
		}
		if ($this->session->userdata('filter_order_service') <> '') {
			$data_query['where'][]['refill.service'] = $this->session->userdata('filter_order_service');
		}
		if ($this->session->userdata('filter_order_api') <> '') {
			$data_query['where'][]['refill.api_id'] = $this->session->userdata('filter_order_api');
		}
		// END SESSION FILTER //
		// PAGINATION //
		if ($this->uri->segment(4) <> '' and is_numeric($this->uri->segment(4)) == false) exit('No direct script access allowed');
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->refill_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->refill_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator, 'status' => $status, 'user' => $this->user_model->get_rows(), 'service' => $this->service_model->get_rows(), 'api' => $this->api_model->get_rows()]);
	}

	public function delete($i = '')
	{
		$target = $this->refill_model->get_by_id($i);
		if ($target == false) show_404();
		$delete_target = $this->refill_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function order($i = '')
	{
		$target = $this->refill_model->get_rows(['status' => $i]);
		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target, 'user' => $this->user_model->get_by_id($target->user_id), 'service' => $this->service_model->get_by_id($target->service_id), 'api' => $this->api_model->get_by_id($target->api_id)]);
	}
	public function detail($i = '')
	{
		$target = $this->refill_model->get_by_id($i);
		if ($target == false) show_404();
		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target, 'user' => $this->user_model->get_by_id($target->user_id), 'service' => $this->service_model->get_row(['name' => $target->service]), 'api' => $this->api_model->get_by_id($target->api_id)]);
	}
	public function status($i = '', $status = '')
	{
		$target = $this->refill_model->get_by_id($i);
		$status = str_replace('%20', ' ', $status);
		if ($target == false) show_404();
		if (in_array($status, ['Pending', 'In progress', 'Processing', 'Success', 'Error', 'Partial',]) == false) show_404();
		$update_target = $this->refill_model->update(['status' => $status], ['id' => $i]);
		if ($update_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function filter()
	{
		$api = $this->api_model->get_by_id($this->input->post('api'));
		if ($api) {
			$this->session->set_userdata('filter_order_api', $this->input->post('api'));
		} else {
			$this->session->unset_userdata('filter_order_api');
		}
		$service = $this->service_model->get_row(['name' => $this->input->post('service')]);
		if ($service) {
			$this->session->set_userdata('filter_order_service', $this->input->post('service'));
		} else {
			$this->session->unset_userdata('filter_order_service');
		}
		$status = $this->refill_model->get_rows(['status' => $this->input->post('status')]);
		if ($status) {
			$this->session->set_userdata('filter_order_status', $this->input->post('status'));
		} else {
			$this->session->unset_userdata('filter_order_status');
		}
		$user = $this->user_model->get_by_id($this->input->post('user'));
		if ($user) {
			$this->session->set_userdata('filter_order_user', $this->input->post('user'));
		} else {
			$this->session->unset_userdata('filter_order_user');
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
}
