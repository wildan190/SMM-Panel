<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_category extends MY_Controller
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
			'service_category.id' => 'ID',
			'service_category.name' => 'NAMA',
			'service_category.type_category' => 'PLATFORM',
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
			'select' => 'service_category.*',
			'order_by' => 'service_category.name ASC',
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
		$config['total_rows'] = $this->service_category_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->service_category_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'awal' => $config['awal'], 'akhir' => $config['akhir'], 'field' => $field, 'operator' => $operator, 'type_category' => $this->type_category_model->get_rows()]);
	}
	public function form($i = '')
	{
		$target = $this->service_category_model->get_by_id($i);
		if ($target == false) { // add
			if ($this->input->post()) {
				$this->form_validation->set_rules('name', 'Nama Kategori', 'required|min_length[1]|max_length[100]');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'name' => $this->db->escape_str($this->input->post('name')),
						'slug' => $this->lib->slug($this->db->escape_str($this->input->post('name')))
					];
					if ($this->service_category_model->get_row(['name' => $data_input['name']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Kategori sudah ada didatabase.'));
					} else {
						$insert_data = $this->service_category_model->insert($data_input);
						if ($insert_data) {
							self::update_category();
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Kategori <b>#' . $insert_data . '</b> berhasil ditambahkan.'));
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
				redirect($this->agent->referrer());
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/add');
		} else { // edit
			if ($this->input->post()) {
				$this->form_validation->set_rules('name', 'Nama Kategori', 'required|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('type', 'Tipe Kategori', 'required|min_length[1]|max_length[100]');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'name' => $this->db->escape_str($this->input->post('name')),
						'type_category' => $this->input->post('type'),
						'slug' => $this->lib->slug($this->db->escape_str($this->input->post('name')))
					];
					if ($data_input['name'] <> $target->name and $this->service_category_model->get_row(['name' => $data_input['name']])) {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Kategori sudah ada didatabase.'));
					} else {
						$update_target = $this->service_category_model->update($data_input, ['id' => $i]);
						if ($update_target) {
							$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Kategori  <b>#' . $i . '</b> berhasil diperbaharui.'));
						} else {
							$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
						}
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
				redirect($this->agent->referrer());
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/edit', ['target' => $target]);
		}
	}
	public function delete($id = null)
{
    // Cek login admin
    if (admin() == false) exit(redirect(base_url('admin/auth/logout')));

    if (!isset($id) || $id == null) {
        redirect(base_url('admin/' . $this->uri->segment(2)));
    }

    // Ambil data kategori untuk memastikan ID valid
    $target = $this->db->get_where('service_category', ['id' => $id])->row();

    if (!$target) {
        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.'));
        redirect(base_url('admin/' . $this->uri->segment(2)));
    }

    // Mulai proses hapus secara transaksional
    $this->db->trans_start();

    // 1. HAPUS LAYANAN (Nama tabel 'service', nama kolom 'service_category_id')
    $this->db->where('service_category_id', $id);
    $this->db->delete('service'); 

    // 2. HAPUS KATEGORI (Nama tabel 'service_category', nama kolom 'id')
    $this->db->where('id', $id);
    $this->db->delete('service_category');

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan sistem saat menghapus data.'));
    } else {
        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Kategori dan semua layanan di dalamnya berhasil dihapus.'));
    }

    redirect(base_url('admin/' . $this->uri->segment(2)));
}
        public function delete_all()
{
    // Cek login admin
    if (admin() == false) exit(redirect(base_url('admin/auth/logout')));

    // Menghapus seluruh isi tabel kategori saja
    if ($this->db->empty_table('service_category')) {
        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Seluruh kategori telah berhasil dihapus.'));
    } else {
        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan saat menghapus data.'));
    }

    redirect(base_url('admin/' . $this->uri->segment(2)));
}

	public function update_category()
	{
		$check_category = $this->service_category_model->get_rows([
			[
				'order_by' => 'id ASC'
			]
		]);

		if ($check_category == false) {
			$this->lib->print_data('Kosong..');
		} else {
			foreach ($check_category as $key => $value) {
				$type = null;
				$category = $value['name'];
				if (preg_match("/Instagram/i", $category) == 1) {
					$type = 'Instagram';
				} elseif (preg_match("/Facebook/i", $category) == 1) {
					$type = 'Facebook';
				} elseif (preg_match("/Twitter/i", $category) == 1) {
					$type = 'Twitter';
				} elseif (preg_match("/Youtube/i", $category) == 1) {
					$type = 'Youtube';
				} elseif (preg_match("/Spotify/i", $category) == 1) {
					$type = 'Spotify';
				} elseif (preg_match("/Telegram/i", $category) == 1) {
					$type = 'Telegram';
				} elseif (preg_match("/Website/i", $category) == 1) {
					$type = 'Website';
				} elseif (preg_match("/Tiktok/i", $category) == 1) {
					$type = 'Tiktok';
				} elseif (preg_match("/Reviews/i", $category) == 1) {
					$type = 'Reviews';
				} elseif (preg_match("/Linkedin/i", $category) == 1) {
					$type = 'Linkedin';
				} elseif (preg_match("/Snapchat/i", $category) == 1) {
					$type = 'Snapchat';
				} elseif (preg_match("/Twitter/i", $category) == 1) {
					$type = 'Twitter';
				} elseif (preg_match("/Google/i", $category) == 1) {
					$type = 'Google';
				} elseif (preg_match("/Twitch/i", $category) == 1) {
					$type = 'Twitch';
				} elseif (preg_match("/Threads/i", $category) == 1) {
					$type = 'Threads';
				} elseif (preg_match("/SoundCloud/i", $category) == 1) {
					$type = 'SoundCloud';
				} elseif (preg_match("/Discord/i", $category) == 1) {
					$type = 'Discord';
				} elseif (preg_match("/Promo/i", $category) == 1) {
					$type = 'Promo';
				} else {
					$type = 'Other';
				}
				$update = $this->service_category_model->update(['name' => $value['name'], 'type_category' => $type], ['id' => $value['id']]);
				if ($update == true) {
					print_r('CATEGORY NAME: ' . $value['name'] . ' BERHASIL UPDATE<br />');
				} else {
					print_r('update gagal<br />');
				}
			}
		}
	}
}
