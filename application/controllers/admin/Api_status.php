<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_status extends MY_Controller
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
			'api_status.id' => 'ID',
			'api_status.name' => 'NAMA',
		];
		$operator = [
			'equal' => 'WHERE =',
			'not_equal' => 'WHERE <>',
			'less_than' => 'WHERE <=',
			'more_than' => 'WHERE >=',
			'like' => 'LIKE %value%'
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'api_status.*, api.name',
			'order_by' => 'api_status.id DESC',
			'join' => [
				[
					'table' => 'api',
					'on' => 'api.id = api_status.api_id',
					'param' => 'inner'
				]
			],
			'limit' => '30',
			'offset' => ($this->uri->segment(4)) ? $this->uri->segment(4) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('sort_field') <> '' and $this->input->get('sort_type') <> '') {
			if (array_key_exists($this->input->get('sort_field'), $field) == false) {
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			}
			if (in_array($this->input->get('sort_type'), array('asc', 'desc')) == false) {
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			}
			$data_query['order_by'] = $this->input->get('sort_field') . ' ' . $this->input->get('sort_type');
		}
		if ($this->input->get('field') <> '' and $this->input->get('operator') <> '' and $this->input->get('value') <> '') {
			if (array_key_exists($this->input->get('field'), $field) == false) {
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			}
			if (array_key_exists($this->input->get('operator'), $operator) == false) {
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			}
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
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->api_status_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->api_status_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator]);
	}
	public function form($i = '')
	{
		$target = $this->api_status_model->get_row(['api_id' => $i]);
		if ($target == false) { // add
			if ($this->input->post()) {
				$this->form_validation->set_rules('name', 'Nama Provider', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('end_point', 'API URL', 'required');
				$this->form_validation->set_rules('method', 'HTTP Method', 'required');
				$this->form_validation->set_rules('success_response', 'Success Response', 'required');
				$this->form_validation->set_rules('status_key', 'Response Status', 'required');
				$this->form_validation->set_rules('start_count_key', 'Response Start Count', 'required');
				$this->form_validation->set_rules('remains_key', 'Response Remains', 'required');
				$data_input = [
					'api_id' => $this->db->escape_str($this->input->post('name')),
					'end_point' => $this->db->escape_str($this->input->post('end_point')),
					'method' => $this->input->post('method'),
					'success_response' => str_replace('\t', '', $this->input->post('success_response')),
					'status_key' => $this->input->post('status_key'),
					'start_count_key' => $this->input->post('start_count_key'),
					'remains_key' => $this->input->post('remains_key'),
					'mass_status' => (empty($this->input->post('mass_status') ? '0' : '1')),
				];
				if ($this->form_validation->run() == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				} else {
					if ($this->api_model->get_row(['id' => $data_input['api_id']]) == false) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Provider tidak ada didatabase.'));
					} elseif ($this->api_status_model->get_row(['api_id' => $data_input['api_id']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Provider sudah ada didatabase.'));
					} else {
						$insert_data = $this->api_status_model->insert($data_input);
						if ($insert_data) {
							// Order status Parameters
							$param_keys = $this->input->post('param_key');
							$param_values = $this->input->post('param_value');
							$param_types = $this->input->post('param_type');

							for ($i = 0; $i < count($param_keys); $i++) {
								$this->api_request_param_model->insert([
									'param_key' => trim($param_keys[$i]),
									'param_value' => trim($param_values[$i]),
									'param_type' => trim($param_types[$i]),
									'api_type' => 'status',
									'api_id' => $data_input['api_id'],
								]);
							}
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Parameter Status Order Provider <b>#' . $data_input['api_id'] . '</b> berhasil ditambahkan.'));
							
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
				}
				redirect($this->agent->referrer());
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/add', ['api' => $this->api_model->get_rows()]);
			// $this->render_admin('admin/' . $this->uri->segment(2) . '/add', ['api' => $this->api_model->get_rows()]);
		} else { // edit
			if ($this->input->post()) {
				$this->form_validation->set_rules('name', 'Nama Provider', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('end_point', 'API URL', 'required');
				$this->form_validation->set_rules('method', 'HTTP Method', 'required');
				$this->form_validation->set_rules('success_response', 'Success Response', 'required');
				$this->form_validation->set_rules('status_key', 'Response Status', 'required');
				$this->form_validation->set_rules('start_count_key', 'Response Start Count', 'required');
				$this->form_validation->set_rules('remains_key', 'Response Remains', 'required');
				$data_input = [
					'api_id' => $this->db->escape_str($this->input->post('name')),
					'end_point' => $this->db->escape_str($this->input->post('end_point')),
					'method' => $this->input->post('method'),
					'success_response' => str_replace('\t', '', $this->input->post('success_response')),
					'status_key' => $this->input->post('status_key'),
					'start_count_key' => $this->input->post('start_count_key'),
					'remains_key' => $this->input->post('remains_key'),
					'mass_status' => empty($this->input->post('mass_status') ? '0' : '1'),
				];
				if ($this->form_validation->run() == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				} else {
					if ($this->api_model->get_row(['id' => $data_input['api_id']]) == false) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Provider tidak ada didatabase.'));
					} else {
						$this->api_status_model->update($data_input, ['api_id' => $target->api_id]);
						$this->api_request_param_model->delete(['api_id' => $i, 'api_type' => 'status']);

						$param_keys = $this->input->post('param_key');
						$param_values = $this->input->post('param_value');
						$param_types = $this->input->post('param_type');

						for ($i = 0; $i < count($param_keys); $i++) {
							$this->api_request_param_model->insert([
								'param_key' => trim($param_keys[$i]),
								'param_value' => trim($param_values[$i]),
								'param_type' => trim($param_types[$i]),
								'api_type' => 'status',
								'api_id' => $data_input['api_id'],
							]);
						}
						
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Parameter Status Order Provider <b>#' . $target->api_id . '</b> berhasil diperbaharui.'));
						
					}
				}
				redirect($this->agent->referrer());
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/edit', ['target' => $target, 'api' => $this->api_model->get_rows(), 'api_request_param' => $this->api_request_param_model->get_rows(['where' => [['api_id' => $i, 'api_type' => 'status']]])]);
			// $this->render_admin('admin/' . $this->uri->segment(2) . '/edit', ['target' => $target, 'api' => $this->api_model->get_rows(), 'api_request_param' => $this->api_request_param_model->get_rows(['where' => [['api_id' => $i, 'api_type' => 'status']]])]);
		}
	}
	public function delete($i = '')
	{
		$target = $this->api_status_model->get_row(['api_id' => $i]);
		if ($target == false) show_404();
		$delete_target = $this->api_status_model->delete(['api_id' => $i]);
		if ($delete_target) {
			$this->api_request_param_model->delete(['api_id' => $i, 'api_type' => 'status']);
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
}
