<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Childpanel extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		// PERBAIKAN: Memuat model yang dibutuhkan agar tidak Error "Call to a member function... on null"
		$this->load->model('childpanel_model');
		$this->load->model('user_model');
		$this->load->model('deposit_method_model');

		// Proteksi Admin
		check_cookie_admin(get_cookie('admin_login'));
		if (admin() == false)
			exit(redirect(base_url('admin/auth/logout')));
	}

	public function index()
	{
		// FORM INPUT //
		$field = [
			'childpanel.created_at' => 'TANGGAL/WAKTU',
			'user.username' => 'PENGGUNA',
			'childpanel.domain' => 'DOMAIN',
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
			'Active' => ['name' => 'Active', 'color' => 'success'],
			'Expired' => ['name' => 'Expired', 'color' => 'danger'],
		];
		// END FORM INPUT //

		// SETTINGS //
		$data_query = [
			'select' => 'childpanel.*, user.username',
			'join' => [
				[
					'table' => 'user',
					'on' => 'user.id = childpanel.user_id',
					'param' => 'inner'
				]
			],
			'order_by' => 'childpanel.id DESC', // Diubah ke ID atau created_at jika order_date tidak ada
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
				$data_query['where'][] = $this->input->get('field') . " LIKE '%" . $this->db->escape_like_str($this->input->get('value')) . "%'";
			}
		}
		// END SORT & SEARCH

		// PAGINATION //
		if ($this->uri->segment(4) <> '' and is_numeric($this->uri->segment(4)) == false)
			exit('No direct script access allowed');

		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->childpanel_model->get_count($data_query); // Baris 86 yang sebelumnya error
		$config['per_page'] = $data_query['limit'];
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //

		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', [
			'table' => $this->childpanel_model->get_rows($data_query),
			'total_data' => $config['total_rows'],
			'field' => $field,
			'operator' => $operator,
			'status' => $status,
			'user' => $this->user_model->get_rows(),
			'deposit_method' => $this->deposit_method_model->get_rows(),
			'awal' => $config['awal'],
			'akhir' => $config['akhir'],
		]);
	}

	public function status($i = '', $status = '')
	{
		$target = $this->childpanel_model->get_by_id($i);
		if ($target == false)
			show_404();

		if ($target->status <> 'Pending') {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Child panel yang bisa diubah hanya berstatus <i>Pending</i>.'));
			redirect(base_url('admin/' . $this->uri->segment(2)));
		}

		if (in_array($status, ['Pending', 'Active', 'Expired']) == false)
			show_404();

		$update_target = $this->childpanel_model->update(['status' => $status], ['id' => $i]);
		if ($update_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}

	public function detail($i = '')
	{
		$i = $this->db->escape_str($i);
		$target = $this->childpanel_model->get_row(['id' => $i]);

		if (!$target) {
			show_404();
		}

		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target]);
	}
}