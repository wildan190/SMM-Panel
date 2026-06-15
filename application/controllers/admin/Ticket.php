<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_cookie_admin(get_cookie('admin_login'));
		if (admin() == false)
			exit(redirect(base_url('admin/auth/logout')));
	}
	public function index()
	{
		// FORM INPUT //
		$field = [
			'ticket.id' => 'ID',
			'ticket.created_at' => 'TANGGAL/WAKTU DBUAT',
			'ticket.updated_at' => 'PEMBAHARUAN TERAKHIR',
			'user.username' => 'PENGGUNA',
			'ticket.subject' => 'SUBJEK',
			'ticket.status' => 'STATUS',
		];
		$operator = [
			'equal' => 'WHERE =',
			'not_equal' => 'WHERE <>',
			'less_than' => 'WHERE <=',
			'more_than' => 'WHERE >=',
			'like' => 'LIKE %value%'
		];
		$status = [
			'Waiting' => ['name' => 'Waiting', 'color' => 'warning'],
			'User Reply' => ['name' => 'User Reply', 'color' => 'info'],
			'Responded' => ['name' => 'Responded', 'color' => 'success'],
			'Closed' => ['name' => 'Closed', 'color' => 'danger'],
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'ticket.*, user.username',
			'join' => [
				[
					'table' => 'user',
					'on' => 'user.id = ticket.user_id',
					'param' => 'inner'
				]
			],
			'order_by' => 'ticket.updated_at DESC',
			'limit' => '30',
			'offset' => ($this->uri->segment(4)) ? $this->uri->segment(4) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('sort_field') <> '' and $this->input->get('sort_type') <> '') {
			if (array_key_exists($this->input->get('sort_field'), $field) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			if (in_array($this->input->get('sort_type'), array('asc', 'desc')) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			$data_query['order_by'] = $this->input->get('sort_field') . ' ' . $this->input->get('sort_type');
		}
		if ($this->input->get('field') <> '' and $this->input->get('operator') <> '' and $this->input->get('value') <> '') {
			if (array_key_exists($this->input->get('field'), $field) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			if (array_key_exists($this->input->get('operator'), $operator) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
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
		if ($this->session->userdata('filter_ticket_user') <> '') {
			$data_query['where'][]['ticket.user_id'] = $this->session->userdata('filter_ticket_user');
		}
		// END SESSION FILTER //
		// PAGINATION //
		if ($this->uri->segment(4) <> '' and is_numeric($this->uri->segment(4)) == false)
			exit('No direct script access allowed');
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->ticket_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->ticket_model->get_rows($data_query), 'awal' => $config['awal'], 'akhir' => $config['akhir'], 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator, 'status' => $status, 'user' => $this->user_model->get_rows()]);
	}
	public function delete($i = '')
	{
		$target = $this->ticket_model->get_by_id($i);
		if ($target == false)
			show_404();
		$delete_target = $this->ticket_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function status($i = '', $status = '')
	{
		$target = $this->ticket_model->get_by_id($i);
		if ($target == false)
			show_404();
		$status = str_replace('%20', ' ', $status);
		if (in_array($status, ['Waiting', 'User Reply', 'Responded', 'Closed']) == false)
			show_404();
		$update_target = $this->ticket_model->update(['status' => $status], ['id' => $i]);
		if ($update_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function filter()
	{
		$user = $this->user_model->get_by_id($this->input->post('user'));
		if ($user) {
			$this->session->set_userdata('filter_ticket_user', $this->input->post('user'));
		} else {
			$this->session->unset_userdata('filter_ticket_user');
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function submit()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('user', 'Pengguna', 'required|numeric');
			$this->form_validation->set_rules('subject', 'Subjek', 'required|alpha_numeric_spaces|min_length[1]|max_length[255]');
			$this->form_validation->set_rules('msg', 'Pesan', 'required');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'user_id' => $this->db->escape_str($this->input->post('user')),
					'subject' => $this->db->escape_str($this->input->post('subject')),
					'status' => 'Waiting',
					'is_read_admin' => '1',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$insert_ticket = $this->ticket_model->insert($data_input);
				if ($insert_ticket) {
					$this->ticket_reply_model->insert([
						'ticket_id' => $insert_ticket,
						'sender' => 'admin',
						'msg' => $this->db->escape_str(strip_tags($this->input->post('msg'))),
						'created_at' => date('Y-m-d H:i:s'),
					]);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Tiket berhasil dikirim.'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2))));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render_admin('admin/' . $this->uri->segment(2) . '/submit', ['user' => $this->user_model->get_rows()]);
	}
	public function reply($i = '')
	{
		$target = $this->ticket_model->get_by_id($i);
		if ($target == false)
			show_404();
		$this->ticket_model->update(['is_read_admin' => '1'], ['id' => $i]);
		if ($this->input->post()) {
			$this->form_validation->set_rules('msg', 'Pesan', 'required');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'ticket_id' => $i,
					'sender' => 'admin',
					'msg' => $this->db->escape_str(strip_tags($this->input->post('msg'))),
					'created_at' => date('Y-m-d H:i:s'),
				];
				$insert_reply = $this->ticket_reply_model->insert($data_input);
				if ($insert_reply) {
					$this->ticket_model->update(['is_read_user' => '0', 'status' => 'Responded', 'updated_at' => date('Y-m-d H:i:s')], ['id' => $i]);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Balasan berhasil dikirim.'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/reply/' . $i)));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render_admin('admin/' . $this->uri->segment(2) . '/reply', ['target' => $target, 'user' => $this->user_model->get_by_id($target->user_id), 'ticket_reply' => $this->ticket_reply_model->get_rows(['where' => [['ticket_id' => $i]]])]);
	}
}
