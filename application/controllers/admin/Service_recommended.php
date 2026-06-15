<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_recommended extends MY_Controller
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
            'service_recommended.id' => 'ID',
            'service.name' => 'LAYANAN',
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
            'select' => 'service_recommended.*, service.name AS service_name',
            'join' => [
                [
                    'table' => 'service',
                    'on' => 'service.id = service_recommended.service_id',
                    'param' => 'inner'
                ],
            ],
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
        $config['total_rows'] = $this->service_recommended_model->get_count($data_query);
        $config['per_page'] = $data_query['limit'];
        $this->pagination->initialize($config);
        // END PAGINATION //
        $this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->service_recommended_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator]);
    }

    public function service_list($i = '')
    {
        // filter input = 1
        $i = $this->db->escape_str($i);
        if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash()) exit("No direct script access allowed");
        header('Content-Type: application/json');
        $service = $this->service_model->get_rows(['where' => [['service_category_id' => $i, 'status' => '1']]]);
        if (count($service) < 1) {
            $result = ['msg' => '<option value="">Layanan tidak tersedia.</option>'];
        } else {
            $list = '<option value="">Pilih...</option>';
            foreach ($service as $key => $value) {
                $list .= '<option value="' . $value['id'] . '"> ' . $value['id'] . ' - ' . $value['name'] . ' - Rp ' . number_format($value['price'], 0, ',', '.') . ' per 1000</option>';
            }
            $result = ['msg' => $list];
        }
        exit(json_encode($result, JSON_PRETTY_PRINT));
    }
    public function form($i = '')
    {
        $target = $this->service_recommended_model->get_by_id($i);
        if ($target == false) { // add
            if ($this->input->post()) {
                $this->form_validation->set_rules('service', 'Layanan', 'required|numeric');
                if ($this->form_validation->run() == true) {
                    $data_input = [
                        'service_id' => $this->db->escape_str($this->input->post('service')),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if ($this->service_recommended_model->get_row(['service_id' => $data_input['service_id']])) {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan ini sudah ada di Database.'));
                    } elseif ($this->service_model->get_row(['id' => $data_input['service_id']]) == false) {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak ditemukan.'));
                    } else {
                        $insert_data = $this->service_recommended_model->insert($data_input);
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
            $this->render_admin('admin/' . $this->uri->segment(2) . '/add', ['service_category' => $this->service_category_model->get_rows(), 'service' => $this->service_model->get_rows(['order_by' => 'name ASC'])]);
        } else { // edit
            if ($this->input->post()) {
                $this->form_validation->set_rules('service', 'Layanan', 'required|numeric');
                if ($this->form_validation->run() == true) {
                    $data_input = [
                        'service_id' => $this->db->escape_str($this->input->post('service')),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if ($data_input['service_id'] <> $target->service_id and $this->service_recommended_model->get_row(['service_id' => $data_input['service_id']])) {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan ini sudah ada di Database.'));
                    } elseif ($this->service_model->get_row(['id' => $data_input['service_id']]) == false) {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Layanan tidak ditemukan.'));
                    } else {
                        $update_target = $this->service_recommended_model->update($data_input, ['id' => $i]);
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
            $this->render_admin('admin/' . $this->uri->segment(2) . '/edit', ['target' => $target, 'service_category' => $this->service_category_model->get_rows(), 'service' => $this->service_model->get_rows(['order_by' => 'name ASC'])]);
        }
    }
    public function delete($i = '')
    {
        $target = $this->service_recommended_model->get_by_id($i);
        if ($target == false) show_404();
        $delete_target = $this->service_recommended_model->delete(['id' => $i]);
        if ($delete_target) {
            $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
        } else {
            $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
        }
        redirect(base_url('admin/' . $this->uri->segment(2)));
    }
}
