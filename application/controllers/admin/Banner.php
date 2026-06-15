<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Menggunakan MY_Controller agar fitur keamanan bawaan aktif
class Banner extends MY_Controller {
    protected $default_path = 'assets/images/slider/';

    public function __construct(){
        parent::__construct();
        // Fungsi bawaan sistem Anda untuk cek login admin
        if (admin() == false) exit(redirect(base_url('admin/auth/logout')));
        
        // Memastikan level adalah 'owner' sesuai di video Anda
        if (admin('level') <> 'owner') {
            $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Akses Ditolak!', 'msg' => 'Hanya Owner yang boleh akses.'));
            exit(redirect(base_url('admin')));
        }
    }

    public function index() {
        $data = [
            'page' => 'Kelola Banner',
            'banners' => $this->db->get('banners')->result_array()
        ];
        // Menggunakan render_admin agar tampilan mengikuti template admin Anda
        $this->render_admin('admin/banner/index', $data);
    }

    public function upload() {
        $config['upload_path']   = './' . $this->default_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('banner_file')) {
            $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => $this->upload->display_errors()));
        } else {
            $file = $this->upload->data();
            $this->db->insert('banners', [
                'image'  => $file['file_name'],
                'title'  => $this->input->post('title', true),
                'status' => 'active'
            ]);
            $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Banner baru telah ditambahkan.'));
        }
        redirect(base_url('admin/banner'));
    }

    public function delete($id) {
        $banner = $this->db->get_where('banners', ['id' => $id])->row_array();
        if ($banner) {
            @unlink('./' . $this->default_path . $banner['image']);
            $this->db->delete('banners', ['id' => $id]);
            $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Dihapus!', 'msg' => 'Banner berhasil dihapus.'));
        }
        redirect(base_url('admin/banner'));
    }
}