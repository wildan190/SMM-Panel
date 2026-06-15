<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service extends MY_Controller
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
		$data['field'] = [
			'service.id' => 'ID',
			'service.api_service_id' => 'SID',
			'service_category.name' => 'KATEGORI',
			'api.name' => 'API',
			'service.name' => 'NAMA',
			'service.price' => 'HARGA',
			'service.profit' => 'KEUNTUNGAN',
			'service.status' => 'STATUS',
		];
		$data['operator'] = [
			'equal' => 'WHERE =',
			'not_equal' => 'WHERE <>',
			'less_than' => 'WHERE <=',
			'more_than' => 'WHERE >=',
			'like' => 'LIKE %value%'
		];
		$data['status'] = [
			'1' => ['status_id' => '1', 'name' => 'Aktif', 'color' => 'success'],
			'0' => ['status_id' => '0', 'name' => 'Non Aktif', 'color' => 'danger'],
		];

		$data['sort_type'] = [
			'asc' => 'ASC',
			'desc' => 'DESC',
		];

		$data['rows'] = [
			'20' => '20',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];

		$data['service_category'] = $this->service_category_model->get_rows();
		$data['api'] = $this->api_model->get_rows();

		$data['categories'] = $this->service_category_model->get_rows(['order_by' => 'name ASC']);

		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'service.*, service_category.name AS service_category_name, api.name AS api_name, service_category.name AS category_name',
			'join' => [
				[
					'table' => 'service_category',
					'on' => 'service_category.id = service.service_category_id',
					'param' => 'left'
				],
				[
					'table' => 'api',
					'on' => 'api.id = service.api_id',
					'param' => 'left'
				]
			],
			'order_by' => 'service_category.name ASC, service.price ASC',
			'limit' => '25',
			'offset' => ($this->uri->segment(4)) ? $this->uri->segment(4) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('sort_field') <> '' and $this->input->get('sort_type') <> '') {
			if (array_key_exists($this->input->get('sort_field'), $data['field']) == false) {
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			}
			if (in_array($this->input->get('sort_type'), array('asc', 'desc')) == false) {
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			}
			$data_query['order_by'] = $this->input->get('sort_field') . ' ' . $this->input->get('sort_type');
		}
		if ($this->input->get('field') <> '' and $this->input->get('operator') <> '' and $this->input->get('value') <> '') {
			if (array_key_exists($this->input->get('field'), $data['field']) == false) {
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			}
			if (array_key_exists($this->input->get('operator'), $data['operator']) == false) {
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
		// SESSION FILTER //
		if ($this->session->userdata('filter_service_service_category') <> '') {
			$data_query['where'][]['service.service_category_id'] = $this->session->userdata('filter_service_service_category');
		}
		if ($this->session->userdata('filter_service_api') <> '') {
			$data_query['where'][]['service.api_id'] = $this->session->userdata('filter_service_api');
		}
		// END SESSION FILTER //

		// PAGINATION //
		if ($this->uri->segment(4) <> '' and is_numeric($this->uri->segment(4)) == false)
			exit('No direct script access allowed');
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->service_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();
		$data['table'] = $this->service_model->get_rows($data_query);
		$data['total_data'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['awal'] = $data_query['offset'] + 1;
		$data['akhir'] = $data_query['offset'] + $data_query['limit'];
		// END PAGINATION //

		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', $data);
	}
	public function deactivate_by_category()
{
    if ($this->input->method() == 'post') {
        $category_id = $this->input->post('category_id');
        $this->db->where('service_category_id', $category_id);
        $this->db->update('service', ['status' => '0']);
        
        // Log the deactivation
        $this->log_category_action($category_id, 'deactivated');
        
        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Layanan dalam kategori ini telah dinonaktifkan.'));
        redirect('admin/service/deactivate_by_category');
    }
    
    $data['service_category'] = $this->service_category_model->get_rows();
    $data['deactivation_history'] = $this->get_category_action_history('deactivated');
    $data['page'] = 'Nonaktifkan Layanan per Kategori';
    $this->render_admin('admin/service/deactivate_by_category', $data);
}

public function activate_by_category()
{
    if ($this->input->method() == 'post') {
        $category_id = $this->input->post('category_id');
        $this->db->where('service_category_id', $category_id);
        $this->db->update('service', ['status' => '1']);
        
        // Remove from deactivation history
        $this->db->where('category_id', $category_id);
        $this->db->where('action', 'deactivated');
        $this->db->delete('service_category_action_logs');
        
        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Layanan dalam kategori ini telah diaktifkan.'));
        redirect('admin/service/activate_by_category');
    }
    
    $data['service_category'] = $this->service_category_model->get_rows();
    $data['deactivation_history'] = $this->get_category_action_history('deactivated');
    $data['page'] = 'Aktifkan Layanan per Kategori';
    $this->render_admin('admin/service/activate_by_category', $data);
}


private function log_category_action($category_id, $action)
{
    $category = $this->service_category_model->get_by_id($category_id);
    $data = [
        'category_id' => $category_id,
        'category_name' => $category->name,
        'action' => $action,
        'created_at' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('service_category_action_logs', $data);
}

private function get_category_action_history($action)
{
    $this->db->where('action', $action);
    $this->db->order_by('created_at', 'DESC');
    $this->db->limit(10);
    return $this->db->get('service_category_action_logs')->result();
}



	public function form($i = '')
	{
		$target = $this->service_model->get_by_id($i);
		if ($target == false) { // add
			if ($this->input->post()) {
				$this->form_validation->set_rules('service_category_id', 'Kategori', 'required|numeric');
				$this->form_validation->set_rules('api_id', 'API', 'required|numeric');
				$this->form_validation->set_rules('api_service_id', 'API ID Layanan', 'required|alpha_numeric_spaces');
				$this->form_validation->set_rules('name', 'Nama', 'required');
				$this->form_validation->set_rules('description', 'Deskripsi', 'required');
				$this->form_validation->set_rules('price', 'Harga', 'required|numeric');
				$this->form_validation->set_rules('profit', 'Keuntungan', 'required|numeric');
				$this->form_validation->set_rules('min', 'Minimal Pesan', 'required|numeric');
				$this->form_validation->set_rules('max', 'Maksimal Pesan', 'required|numeric');
				$this->form_validation->set_rules('type', 'Tipe', 'required|in_list[primary,custom_comments,custom_link]');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'service_category_id' => $this->db->escape_str($this->input->post('service_category_id')),
						'api_id' => $this->db->escape_str($this->input->post('api_id')),
						'api_service_id' => $this->db->escape_str($this->input->post('api_service_id')),
						'name' => $this->db->escape_str($this->input->post('name')),
						'description' => strip_tags($this->input->post('description')),
						'price' => $this->db->escape_str($this->input->post('price')),
						'profit' => $this->db->escape_str($this->input->post('profit')),
						'min' => $this->db->escape_str($this->input->post('min')),
						'max' => $this->db->escape_str($this->input->post('max')),
						'api' => ($this->input->post('api') <> '') ? '1' : '0',
						'refill' => ($this->input->post('refill') <> '') ? '1' : '0',
						'type' => $this->db->escape_str($this->input->post('type')),
					];
					if ($this->service_model->get_row(['name' => $data_input['name']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama sudah ada didatabase.'));
					} else {
						$insert_data = $this->service_model->insert($data_input);
						if ($insert_data) {
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Layanan <b>#' . $insert_data . '</b> berhasil ditambahkan.'));
							exit();
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
				redirect($this->agent->referrer());
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/add', ['service_category' => $this->service_category_model->get_rows(['where' => [['type' => 'SM']]]), 'api' => $this->api_model->get_rows()]);
		} else { // edit
			if ($this->input->post()) {
				$this->form_validation->set_rules('service_category_id', 'Kategori', 'required|numeric');
				$this->form_validation->set_rules('api_id', 'API', 'required|numeric');
				$this->form_validation->set_rules('api_service_id', 'API ID Layanan', 'required|alpha_numeric_spaces');
				$this->form_validation->set_rules('name', 'Nama', 'required|min_length[1]|max_length[230]');
				$this->form_validation->set_rules('description', 'Deskripsi', 'required');
				$this->form_validation->set_rules('price', 'Harga', 'required|numeric');
				$this->form_validation->set_rules('profit', 'Keuntungan', 'required|numeric');
				$this->form_validation->set_rules('min', 'Minimal Pesan', 'required|numeric');
				$this->form_validation->set_rules('max', 'Maksimal Pesan', 'required|numeric');
				$this->form_validation->set_rules('type', 'Tipe', 'required|in_list[primary,custom_comments,custom_link]');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'service_category_id' => $this->db->escape_str($this->input->post('service_category_id')),
						'api_id' => $this->db->escape_str($this->input->post('api_id')),
						'api_service_id' => $this->db->escape_str($this->input->post('api_service_id')),
						'name' => $this->db->escape_str($this->input->post('name')),
						'description' => strip_tags($this->input->post('description')),
						'price' => $this->db->escape_str($this->input->post('price')),
						'profit' => $this->db->escape_str($this->input->post('profit')),
						'min' => $this->db->escape_str($this->input->post('min')),
						'max' => $this->db->escape_str($this->input->post('max')),
						'api' => ($this->input->post('api') <> '') ? '1' : '0',
						'refill' => ($this->input->post('refill') <> '') ? '1' : '0',
						'type' => $this->db->escape_str($this->input->post('type')),
					];
					if ($data_input['min'] <> $target->min) {
						$data_service_logs = [
							'service_id' => $target->id,
							'service_name' => $target->name,
							'before_update' => $target->min,
							'after_update' => $data_input['min'],
							'type' => 'update_min',
							'created_at' => date('Y-m-d H:i:s')
						];
						$this->service_logs_model->insert($data_service_logs);
					} elseif ($data_input['max'] <> $target->max) {
						$data_service_logs = [
							'service_id' => $target->id,
							'service_name' => $target->name,
							'before_update' => $target->max,
							'after_update' => $data_input['max'],
							'type' => 'update_max',
							'created_at' => date('Y-m-d H:i:s')
						];
						$this->service_logs_model->insert($data_service_logs);
					} elseif ($data_input['price'] <> $target->price) {
						$data_service_logs = [
							'service_id' => $target->id,
							'service_name' => $target->name,
							'before_update' => $target->price,
							'after_update' => $data_input['price'],
							'type' => ($data_input['price'] > $target->price ? 'price_increased' : 'price_decreased'),
							'created_at' => date('Y-m-d H:i:s')
						];
						$this->service_logs_model->insert($data_service_logs);
					}
					if ($data_input['name'] <> $target->name and $this->service_model->get_row(['name' => $data_input['name']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama sudah ada didatabase.'));
					} else {
						$update_target = $this->service_model->update($data_input, ['id' => $i]);
						if ($update_target) {
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Layanan <b>#' . $i . '</b> berhasil diubah.'));
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Tidak ada perubahan data.'));
						}
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
				redirect($this->agent->referrer());
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/edit', ['target' => $target, 'service_category' => $this->service_category_model->get_rows(['where' => [['type' => 'SM']]]), 'api' => $this->api_model->get_rows()]);
		}
	}
	public function delete($i = '')
	{
		$target = $this->service_model->get_by_id($i);
		if ($target == false)
			show_404();
		$delete_target = $this->service_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect($this->agent->referrer());
	}
	public function detail($i = '')
	{
		$target = $this->service_model->get_by_id($i);
		if ($target == false) show_404();
		$query = $this->order_model->get_rows(['select' => 'SUM(profit) as rupiah, COUNT(id) as total', 'where' => [['service_id' => $target->id]]]);
		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target, 'service_category' => $this->service_category_model->get_by_id($target->service_category_id), 'api' => $this->api_model->get_by_id($target->api_id), 'order' => $query]);
	}
	public function status($i = '', $status = '')
	{
		$target = $this->service_model->get_by_id($i);
		if ($target == false)
			show_404();
		if (in_array($status, ['0', '1']) == false)
			show_404();
		$update_target = $this->service_model->update(['status' => $status], ['id' => $i]);
		if ($update_target) {
			$data_service_logs = [
				'service_id' => $target->id,
				'service_name' => $target->name,
				'before_update' => ($status == '1' ? '0' : '1'),
				'after_update' => ($status == '1' ? '1' : '0'),
				'type' => ($status == '1' ? 'enabled' : 'disabled'),
				'created_at' => date('Y-m-d H:i:s')
			];
			// Ganti dengan ID grup atau saluran yang ingin Anda tuju
			$chat_id = '-1001284854567';
			$message_thread_id = '216';
			$phone = website_config('wa_admin');
			$pesan_tele = '<b>' . ($status == '1' ? 'AKTIF' : 'NONAKTIF') . ' LAYANAN</b>
<b>[' . ($status == '1' ? '✓' : '✗') . '] ' . $target->id . '</b> - ' . $target->name . ' - Rp ' . currency($target->price) . '';
			$pesan = '*' . ($status == '1' ? 'AKTIF' : 'NONAKTIF') . ' LAYANAN*
*[' . ($status == '1' ? '✓' : '✗') . ']* ' . $target->id . ' - ' . $target->name . ' - Rp ' . currency($target->price) . '';
			$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
			// $this->lib->sendMessage($phone, $pesan);
			$this->service_logs_model->insert($data_service_logs);
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect($this->agent->referrer());
	}
	public function filter()
	{
		$api = $this->api_model->get_by_id($this->input->post('api'));
		if ($api) {
			$this->session->set_userdata('filter_service_api', $this->input->post('api'));
		} else {
			$this->session->unset_userdata('filter_service_api');
		}
		$service_category = $this->service_category_model->get_by_id($this->input->post('service_category'));
		if ($service_category) {
			$this->session->set_userdata('filter_service_service_category', $this->input->post('service_category'));
		} else {
			$this->session->unset_userdata('filter_service_service_category');
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function empty()
	{
		if ($this->service_model->is_empty()) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Semua layanan berhasil di hapus'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function desc()
	{
		$provider_id = $this->input->post('api_service_id');
		$api_id = $this->input->post('api_id'); // Tambahkan ini untuk mendapatkan api_id
		$target = $this->service_model->get_row(['api_service_id' => $provider_id, 'api_id' => $api_id]);

		if ($this->input->post()) {
			$this->form_validation->set_rules('api_id', 'ID API', 'required|numeric'); // Tambahkan aturan validasi untuk api_id
			$this->form_validation->set_rules('api_service_id', 'ID Provider', 'required|numeric');
			$this->form_validation->set_rules('description', 'Deskripsi', 'required');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'api_service_id' => $this->db->escape_str($this->input->post('api_service_id')),
					'description' => strip_tags($this->input->post('description'))
				];

				$update_target = $this->service_model->update($data_input, ['api_service_id' => $target->api_service_id, 'api_id' => $api_id]); // Perbarui filter ke api_id juga

				if ($update_target) {
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'ID Provider <b>#' . $target->api_service_id . '</b> berhasil diperbaharui.'));
					redirect($this->agent->referrer());
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$api_data = $this->api_model->get_rows();
		$data = [
			'page' => 'Update Deskripsi',
			'api' => $api_data, // Tambahkan data 'api' ke dalam data
		];
		$this->render_admin('admin/' . $this->uri->segment(2) . '/desc', $data);
	}
	public function nonaktif()
	{
		if ($this->input->post()) {
			$api_service_ids = explode(',', $this->input->post('api_service_id'));
			foreach ($api_service_ids as $api_service_id) {
				$api_service_id = trim($api_service_id);
				if (!empty($api_service_id) && is_numeric($api_service_id)) {
					$target = $this->service_model->get_row(['api_service_id' => $api_service_id]);

					$data_input = [
						'api_service_id' => $this->db->escape_str($api_service_id),
						'status' => '0'
					];

					$update_target = $this->service_model->update($data_input, ['api_service_id' => $target->api_service_id]);

					if ($update_target) {
						$data_service_logs = [
							'service_id' => $target->id,
							'service_name' => $target->name,
							'before_update' => ($status == '1' ? '0' : '1'),
							'after_update' => ($status == '1' ? '1' : '0'),
							'type' => ($status == '1' ? 'enabled' : 'disabled'),
							'created_at' => date('Y-m-d H:i:s')
						];
						// Ganti dengan ID grup atau saluran yang ingin Anda tuju
						$chat_id = '-1001284854567';
						$message_thread_id = '216';
						$phone = website_config('wa_admin');

						$pesan_tele = '<b>' . ($status == '1' ? 'AKTIF' : 'NONAKTIF') . ' LAYANAN</b>
<b>[' . ($status == '1' ? '✓' : '✗') . '] ' . $target->id . '</b> - ' . $target->name . ' - Rp ' . currency($target->price) . '';

						$pesan = '*' . ($status == '1' ? 'AKTIF' : 'NONAKTIF') . ' LAYANAN*
*[' . ($status == '1' ? '✓' : '✗') . ']* ' . $target->id . ' - ' . $target->name . ' - Rp ' . currency($target->price) . '';

						$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
						$this->lib->sendMessage($phone, $pesan);
						$this->service_logs_model->insert($data_service_logs);
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'ID Provider <b>#' . $target->api_service_id . '</b> di Nonaktifkan.'));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'ID Provider tidak valid.'));
				}
			}
			exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/nonaktif')));
		}

		$data = [
			'page' => 'Nonaktifkan Layanan',
		];
		$this->render_admin('admin/' . $this->uri->segment(2) . '/nonaktif', $data);
	}
}
