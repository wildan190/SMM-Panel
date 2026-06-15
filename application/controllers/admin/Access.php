<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Access extends MY_Controller
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
	}
	public function index()
	{
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index');
	}
	public function form($i = '')
	{
		$target = $this->admin_model->get_by_id($i);
		if ($target == false) { // add
			if ($this->input->post()) {
				$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[5]|max_length[12]');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
				$this->form_validation->set_rules('level', 'Hak Akses', 'required|in_list[owner,admin]');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'username' => $this->db->escape_str($this->input->post('username')),
						'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
						'full_name' => $this->db->escape_str($this->input->post('full_name')),
						'level' => $this->db->escape_str($this->input->post('level')),
					];
					if ($this->admin_model->get_row(['username' => $data_input['username']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username sudah ada didatabase.'));
					} else {
						$insert_data = $this->admin_model->insert($data_input);
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
				$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|alpha_numeric_spaces|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[5]|max_length[12]');
				$this->form_validation->set_rules('password', 'Password', 'min_length[5]');
				$this->form_validation->set_rules('level', 'Hak Akses', 'required|in_list[owner,admin]');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'username' => $this->db->escape_str($this->input->post('username')),
						'full_name' => $this->db->escape_str($this->input->post('full_name')),
						'level' => $this->db->escape_str($this->input->post('level')),
					];
					if ($this->input->post('password') <> '') $data_input['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
					if ($data_input['username'] <> $target->username and $this->admin_model->get_row(['username' => $data_input['username']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username sudah ada didatabase.'));
					} else {
						$update_target = $this->admin_model->update($data_input, ['id' => $i]);
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
		$target = $this->admin_model->get_by_id($i);
		if ($target == false) show_404();
		$delete_target = $this->admin_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
}
