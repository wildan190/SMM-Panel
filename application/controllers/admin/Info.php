<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Info extends MY_Controller
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
			'category' => 'KATEGORI',
			'content' => 'KONTEN',
			'created_at' => 'TANGGAL DIBUAT',
			'updated_at' => 'TANGGAL DIPERBAHARUI',
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
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->info_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->info_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator]);
	}
	public function form($i = '')
	{
		$target = $this->info_model->get_by_id($i);
		if ($target == false) { // add
			if ($this->input->post()) {
				$this->form_validation->set_rules('category', 'Kategori', 'required|in_list[info,service,maintenance,update]');
				$this->form_validation->set_rules('content', 'Konten', 'required');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'category' => $this->db->escape_str($this->input->post('category')),
						'content' => $this->input->post('content'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
						'is_popup' => ($this->input->post('is_popup') == '1') ? '1' : '0',
					];
					$insert_data = $this->info_model->insert($data_input);
					if ($insert_data) {
						if ($data_input['is_popup'] == '1') $this->db->update('user', ['is_read_popup' => '0']);
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Tambah data berhasil!', 'msg' => 'Data <b>#' . $insert_data . '</b> berhasil ditambahkan.'));
						exit(redirect(base_url('admin/' . $this->uri->segment(2))));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
			}
			$this->render_admin('admin/' . $this->uri->segment(2) . '/add');
		} else { // edit
			if ($this->input->post()) {
				$this->form_validation->set_rules('category', 'Kategori', 'required|in_list[info,service,maintenance,update]');
				$this->form_validation->set_rules('content', 'Konten', 'required');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'category' => $this->db->escape_str($this->input->post('category')),
						'content' => $this->input->post('content'),
						'updated_at' => date('Y-m-d H:i:s'),
						'is_popup' => ($this->input->post('is_popup') == '1') ? '1' : '0',
					];
					$update_target = $this->info_model->update($data_input, ['id' => $i]);
					if ($update_target) {
						if ($data_input['is_popup'] == '1') $this->db->update('user', ['is_read_popup' => '0']);
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diperbaharui.'));
						exit(redirect(base_url('admin/' . $this->uri->segment(2))));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
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
		$target = $this->info_model->get_by_id($i);
		if ($target == false) show_404();
		$delete_target = $this->info_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
}
