<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends MY_Controller
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
			'id' => 'ID',
			'name' => 'NAMA',
			'profit' => 'PROFIT',
			'profit_type' => 'TIPE PROFIT',
			'kurs' => 'MATA UANG',
			'rate' => 'KURS',
			'balance' => 'SISA SALDO'
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
			'select' => '*',
			'order_by' => 'id DESC',
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
		$config['total_rows'] = $this->api_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->api_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator]);
	}

	public function form($i = '')
	{
		$target = $this->api_model->get_by_id($i);
		if ($target == false) { // add
			if ($this->input->post()) {
				$this->form_validation->set_rules('name', 'Nama Provider', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('profit', 'Keuntungan', 'required');
				$this->form_validation->set_rules('profit_type', 'Tipe Keuntungan', 'required');
				$this->form_validation->set_rules('kurs', 'Mata Uang', 'required');
				// $this->form_validation->set_rules('rate', 'Kurs', 'required');
				$data_input = [
					'name' => $this->db->escape_str($this->input->post('name')),
					'api_id' => $this->db->escape_str($this->input->post('api_id')),
					'api_key' => $this->db->escape_str($this->input->post('api_key')),
					'secret_key' => $this->db->escape_str($this->input->post('secret_key')),
					'is_manual' => (empty($this->input->post('is_manual')) ? '0' : '1'),
					'auto_add' => (empty($this->input->post('auto_add')) ? '0' : '1'),
					'auto_update' => (empty($this->input->post('auto_update')) ? '0' : '1'),
					'auto_status' => (empty($this->input->post('auto_status')) ? '0' : '1'),
					'auto_name_service' => (empty($this->input->post('auto_name_service')) ? '0' : '1'),
					'profit' => $this->db->escape_str($this->input->post('profit')),
					'profit_type' => $this->db->escape_str($this->input->post('profit_type')),
					'kurs' => $this->db->escape_str($this->input->post('kurs')),
					'rate' => $this->db->escape_str($this->input->post('rate')),
				];
				if ($this->form_validation->run() == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				} else {
					if ($this->api_model->get_row(['name' => $data_input['name']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama sudah ada didatabase.'));
						redirect(base_url('admin/' . $this->uri->segment(2)));
						exit();
					} else {
						$insert_data = $this->api_model->insert($data_input);
						if ($insert_data) {
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Data Provider <b>#' . $insert_data . '</b> berhasil ditambahkan.'));
							redirect(base_url('admin/' . $this->uri->segment(2)));
							exit();
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
				}
				redirect(base_url('admin/' . $this->uri->segment(2)));
				exit();
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/add');
		} else { // edit
			if ($this->input->post()) {
				$this->form_validation->set_rules('name', 'Nama Provider', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('profit', 'Keuntungan', 'required');
				$this->form_validation->set_rules('profit_type', 'Tipe Keuntungan', 'required');
				$this->form_validation->set_rules('kurs', 'Mata Uang', 'required');
				$this->form_validation->set_rules('rate', 'Kurs', 'required');
				$data_input = [
					'name' => $this->db->escape_str($this->input->post('name')),
					'api_id' => $this->db->escape_str($this->input->post('api_id')),
					'api_key' => $this->db->escape_str($this->input->post('api_key')),
					'secret_key' => $this->db->escape_str($this->input->post('secret_key')),
					'is_manual' => (empty($this->input->post('is_manual')) ? '0' : '1'),
					'auto_add' => (empty($this->input->post('auto_add')) ? '0' : '1'),
					'auto_update' => (empty($this->input->post('auto_update')) ? '0' : '1'),
					'auto_status' => (empty($this->input->post('auto_status')) ? '0' : '1'),
					'auto_name_service' => (empty($this->input->post('auto_name_service')) ? '0' : '1'),
					'profit' => $this->db->escape_str($this->input->post('profit')),
					'profit_type' => $this->db->escape_str($this->input->post('profit_type')),
					'kurs' => $this->db->escape_str($this->input->post('kurs')),
					'rate' => $this->db->escape_str($this->input->post('rate')),
				];
				if ($this->form_validation->run() == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				} else {
					if ($data_input['name'] <> $target->name and $this->api_model->get_row(['name' => $data_input['name']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Provider sudah ada didatabase.'));
						redirect(base_url('admin/' . $this->uri->segment(2)));
						exit();
					} else {
						$update_target = $this->api_model->update($data_input, ['id' => $target->id]);
						if ($update_target) {
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Data Provider <b>#' . $target->id . '</b> berhasil diperbaharui.'));
							redirect(base_url('admin/' . $this->uri->segment(2)));
							exit();
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Tidak ada perubahan data.'));
							redirect(base_url('admin/' . $this->uri->segment(2)));
							exit();
						}
					}
				}
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/edit', ['target' => $target]);
		}
	}

	public function delete($i = '')
	{
		$target = $this->api_model->get_by_id($i);
		if ($target == false) show_404();
		$delete_target = $this->api_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->api_order_model->delete(['api_id' => $i]);
			$this->api_status_model->delete(['api_id' => $i]);
			$this->api_service_model->delete(['api_id' => $i]);
			$this->api_balance_model->delete(['api_id' => $i]);
			$this->api_refill_model->delete(['api_id' => $i]);
			$this->api_refill_status_model->delete(['api_id' => $i]);
			$this->api_request_param_model->delete(['api_id' => $i]);
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Data Provider <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}


	public function detail($i = '')
	{

		$target = $this->api_model->get_by_id($i);
		if ($target == false) show_404();
		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target]);
	}
	public function quick_update($i = '')
	{
		$target = $this->api_model->get_rows(['where' => [['id' => $i]]]);
		if ($target == false) show_404();

		foreach ($target as $key => $value) {
			// CHECK API BALANCE //
			$api_balance = $this->api_balance_model->get_row(['api_id' => $value['id']]);
			if ($api_balance == false) {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Parameter Profile belum diatur.'));
			} else {
				// END CHECK API BALANCE //
				$params = [];
				$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $value['id'], 'api_type' => 'balance']);
				if (!empty($api_request_param->result_array())) {
					foreach ($api_request_param->result_array() as $row) {

						if ($row['param_type'] === 'custom') {

							$params[$row['param_key']] = $row['param_value'];
						} else {
							if ($row['param_value'] == 'api_id') {
								$params[$row['param_key']] = $value['api_id'];
							} else if ($row['param_value'] == 'api_key') {
								$params[$row['param_key']] = $value['api_key'];
							} else if ($row['param_value'] == 'secret_key') {
								$params[$row['param_key']] = $value['secret_key'];
							}
						}
					}
					//die;
					$client = new GuzzleHttp\Client();
					try {
						$param_key = 'form_params';
						$request = $client->request('POST', $api_balance->end_point, [
							$param_key => $params,
							'headers' => ['Accept' => 'application/json'],
						]);
						if ($request->getStatusCode() === 200) {
							$response = $request->getBody()->getContents();
							$json_result = json_decode($response, true);

							$balance = search_key($json_result, $api_balance->balance_key);
						}
					} catch (Exception $e) {
						log_message('error', $e->getMessage());
						print_r($e->getMessage());
					}
				}
				if ($balance !== null) {
					$this->db->trans_start();
					if ($value['kurs'] == 'USD') {
						$balance = $balance * $value['rate'];
					}
					$data_input = ['balance' => $balance];
					$this->api_model->update($data_input, ['id' => $value['id']]);
					$this->db->trans_complete();
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil Update Saldo', 'msg' => '' . $value['name'] . ' - Rp ' . currency($balance) . ''));
				} else {
					$this->lib->print_data($json_result);
				}
			}
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
}
