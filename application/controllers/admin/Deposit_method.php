<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposit_method extends MY_Controller
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
			'type' => 'TIPE',
			'number_account' => 'NO REKENING/HP',
			'account_name' => 'ATAS NAMA',
			'category' => 'KATEGORI',
			'rate' => 'RATE',
			'min_deposit' => 'MINIMAL DEPOSIT',
			'status' => 'STATUS',
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
		$offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->deposit_method_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->deposit_method_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator, 'status' => $status]);
	}
	public function form($i = '')
	{
		$target = $this->deposit_method_model->get_by_id($i);
		if ($target == false) { // add
			if ($this->input->post()) {
				$this->form_validation->set_rules('name', 'Nama', 'required|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('type', 'Tipe', 'required|in_list[tripay,paydisini,midtrans,manual]');
				$this->form_validation->set_rules('category', 'Kategori', 'required|in_list[qris,bank,pulsa,virtual_account,mini_market,ewallet]');
				$this->form_validation->set_rules('rate', 'Rate', 'required');
				$this->form_validation->set_rules('name_account', 'Atas Nama', 'required');
				$this->form_validation->set_rules('number_account', 'No Rekening/HP', 'required');
				$this->form_validation->set_rules('description', 'Deskripsi', 'required');
				$this->form_validation->set_rules('min_deposit', 'Minimal Deposit', 'required|numeric');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'name' => $this->db->escape_str($this->input->post('name')),
						'type' => $this->db->escape_str($this->input->post('type')),
						'category' => $this->db->escape_str($this->input->post('category')),
						'rate' => $this->db->escape_str($this->input->post('rate')),
						'name_account' => $this->db->escape_str($this->input->post('name_account')),
						'number_account' => $this->db->escape_str($this->input->post('number_account')),
						'description' => strip_tags($this->input->post('description')),
						'min_deposit' => $this->db->escape_str($this->input->post('min_deposit')),
						'status' => '1',
						'is_gateway' => $this->input->post('gateway'),
						'gateway_code' => $this->input->post('gateway_code'),
						'gateway_instruction' => $this->input->post('gateway_instruction'),
						'thumbnail_payment' => '', //reset
					];
					if (isset($_FILES['thumbnail']['name']) && !empty($_FILES['thumbnail']['name'])) {

						// preparing upload bukti trf
						$config['upload_path']   = './uploads';
						$config['allowed_types'] = 'gif|jpg|png|pdf|jpeg';
						$config['max_size']      = 5000;
						$config['max_width']     = 5000;
						$config['max_height']    = 5000;
						$config['file_name'] = urlencode(str_replace(' ', '_', $_FILES['thumbnail']['name']));
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('thumbnail')) {
							$data_input['thumbnail_payment'] = $config['file_name'];
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' =>  $this->upload->display_errors()));
						}
					}
					if ($this->deposit_method_model->get_row(['name' => $data_input['name']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama sudah ada didatabase.'));
					} else {
						$insert_data = $this->deposit_method_model->insert($data_input);
						if ($insert_data) {
							$title_key = $this->input->post('title');
							$instruction_key = $this->input->post('instruction');

							$this->deposit_method_instruction_model->insert([
								'deposit_method_id' => $insert_data,
								'title' => json_encode($title_key),
								'instruction' => json_encode($instruction_key),
							]);


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
				$this->form_validation->set_rules('name', 'Nama', 'required|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('type', 'Tipe', 'required|in_list[tripay,paydisini,midtrans,manual]');
				$this->form_validation->set_rules('category', 'Kategori', 'required|in_list[qris,bank,pulsa,virtual_account,mini_market,ewallet]');
				$this->form_validation->set_rules('rate', 'Rate', 'required|numeric');
				$this->form_validation->set_rules('name_account', 'Atas Nama', 'required');
				$this->form_validation->set_rules('number_account', 'No Rekening/HP', 'required');
				$this->form_validation->set_rules('description', 'Deskripsi', 'required');
				$this->form_validation->set_rules('min_deposit', 'Minimal Deposit', 'required|numeric');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'name' => $this->db->escape_str($this->input->post('name')),
						'type' => $this->db->escape_str($this->input->post('type')),
						'category' => $this->db->escape_str($this->input->post('category')),
						'rate' => $this->db->escape_str($this->input->post('rate')),
						'name_account' => $this->db->escape_str($this->input->post('name_account')),
						'number_account' => $this->db->escape_str($this->input->post('number_account')),
						'description' => strip_tags($this->input->post('description')),
						'min_deposit' => $this->db->escape_str($this->input->post('min_deposit')),
						'status' => $this->db->escape_str($this->input->post('status')),
						'is_gateway' => $this->input->post('gateway'),
						'gateway_code' => $this->input->post('gateway_code'),
						'gateway_instruction' => $this->input->post('gateway_instruction'),
						'thumbnail_payment' => $target->thumbnail_payment, //reset
					];
					if (isset($_FILES['thumbnail']['name']) && !empty($_FILES['thumbnail']['name'])) {

						// preparing upload bukti trf
						$config['upload_path']   = './uploads';
						$config['allowed_types'] = 'gif|jpg|png|pdf|jpeg';
						$config['max_size']      = 5000;
						$config['max_width']     = 5000;
						$config['max_height']    = 5000;
						$config['file_name'] = urlencode(str_replace(' ', '_', $_FILES['thumbnail']['name']));
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('thumbnail')) {
							$data_input['thumbnail_payment'] = $config['file_name'];
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' =>  $this->upload->display_errors()));
						}
					}
					if ($data_input['name'] <> $target->name and $this->deposit_method_model->get_row(['name' => $data_input['name']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama sudah ada didatabase.'));
					} else {
						$update_target = $this->deposit_method_model->update($data_input, ['id' => $i]);
						if ($update_target) {
							$title_key = $this->input->post('title');
							$instruction_key = $this->input->post('instruction');

							$this->deposit_method_instruction_model->delete(['deposit_method_id' => $target->id]);

							$this->deposit_method_instruction_model->insert([
								'deposit_method_id' => $target->id,
								'title' => json_encode($title_key),
								'instruction' => json_encode($instruction_key),
							]);

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
		$target = $this->deposit_method_model->get_by_id($i);
		if ($target == false) show_404();
		$delete_target = $this->deposit_method_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function detail($i = '')
	{
		$target = $this->deposit_method_model->get_by_id($i);
		if ($target == false) show_404();
		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target]);
	}
	public function status($i = '', $status = '')
	{
		$target = $this->deposit_method_model->get_by_id($i);
		if ($target == false) show_404();
		if (in_array($status, ['0', '1']) == false) show_404();
		$update_target = $this->deposit_method_model->update(['status' => $status], ['id' => $i]);
		if ($update_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
}
