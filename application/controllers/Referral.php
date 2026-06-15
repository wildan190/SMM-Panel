<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Referral extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (website_config('mt_web') == 1) {
            exit(redirect(base_url('maintenance')));
        } elseif (website_config('referral_status') == 0) {
            $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Sistem Referral dinonaktifkan.'));
            exit(redirect(base_url()));
        }
        check_cookie(get_cookie('smm_login'));
        if (user() == false)
            exit(redirect(base_url('auth/logout')));
    }
    public function statistic()
    {
        // Memeriksa apakah ada parameter act pada URL
        $action = $this->input->get('act');

        if (!empty($action)) {
            // Jalankan set_website_config jika gr_status ada dan nilainya on atau off
            if ($action === 'on') {
                $this->user_model->update(['referral_status' => 1], ['id' => user()]);
                redirect(site_url('referral/' . url_title($this->uri->segment(2))));
            }
        }

        // filter input = 1

        // FORM INPUT //
        $rows = [
            '10' => '10',
            '25' => '25',
            '50' => '50',
            '100' => '100',
        ];
        // END FORM INPUT //
        // SETTINGS //
        $data_query = [
            'where' => [['uplink' => user()]],
            'order_by' => 'id DESC',
            'limit' => 10,
            'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
        ];
        // END SETTINGS //
        // SORT & SEARCH
        if ($this->input->get('rows')) {
            if (array_key_exists($this->input->get('rows'), $rows) == false)
                exit(redirect(base_url('referral/statistic')));
            $data_query['limit'] = $this->input->get('rows');
        }

        if ($this->input->get('search') <> '') {
            $data_query['where'][] = "full_name LIKE '%" . $this->db->escape_str(strip_tags($this->input->get('search'))) . "%'";
        }

        // END SETTINGS //
        // PAGINATION //
        if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
            exit(base_url());
        $config['base_url'] = base_url('referral/statistic');
        $config['total_rows'] = $this->user_model->get_count($data_query);
        $config['awal'] = $data_query['offset'] + 1;
        $config['akhir'] = $data_query['offset'] + $data_query['limit'];
        $config['per_page'] = $data_query['limit'];
        $this->pagination->initialize($config);
        // END PAGINATION //
        $this->render('public/referral/statistic', [
            'page_type' => 'Statistik Referral',
            'table' => $this->user_model->get_rows($data_query),
            'widget_order' => $this->order_model->get_rows([
                'select' => 'SUM(price) AS rupiah, COUNT(id) AS total',
                'where' => [
                    ['uplink' => user()],
                    "status IN ('Success', 'Partial')"
                ],
            ]),
            'total_convert' => $this->referral_komisi_model->get_rows([
                'select' => 'SUM(amount) AS rupiah',
                'where' => [['user_id' => user()]],
            ]),
            'total_user' => $this->user_model->get_count(['where' => [['uplink' => user()]]]),
            'total_data' => $config['total_rows'],
            'per_page' => $config['per_page'],
            'rows' => $rows,
            'awal' => $config['awal'],
            'akhir' => $config['akhir']
        ]);
    }
    public function new()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('amount', 'Jumlah Saldo', 'required');
            if ($this->form_validation->run() == true) {
                $jumlah = $this->db->escape_str($this->input->post('amount'));
                if ($jumlah > user('referral_saldo')) {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Jumlah Saldo Referral Anda tidak cukup.'));
                } elseif (website_config('referral_minimun_convert') > $jumlah) {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Minimum Convert adalah Rp ' . currency(website_config('referral_minimun_convert')) . '.'));
                } else {
                    $saldo_user = user('balance');
                    $this->db->trans_start();
                    $this->user_model->update(['referral_saldo' => user('referral_saldo') - $jumlah], ['id' => user()]);
                    $this->user_model->update(['balance' => user('balance') + $jumlah], ['id' => user()]);
                    $data_insert = [
                        'user_id' => user(),
                        'amount' => $jumlah,
                        'balance' => $jumlah,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $insert = $this->referral_komisi_model->insert($data_insert);
                    $this->log_balance_usage_model->insert([
                        'user_id' => user(),
                        'type' => 'plus',
                        'category' => 'komisi referral',
                        'amount' => $jumlah,
                        'before' => $saldo_user,
                        'after' => $saldo_user + $jumlah,
                        'description' => 'Pencairan <b>Saldo Komisi Referral Rp ' . currency($jumlah) . '</b> - #' . $insert . '.',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() == true) {
                        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Convert Komisi berhasil, Anda mendapatkan Saldo Rp ' . currency($jumlah) . '.'));
                    } else {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi Kesalahan'));
                    }
                }
            } else {
                $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => validation_errors()));
            }
        }
        $this->render('public/referral/new', ['page_type' => 'Convert Komisi', 'table' => $this->referral_komisi_model->get_rows(['where' => [['user_id' => user()]], 'order_by' => 'id DESC'])]);
    }
    public function history()
    {
        // FORM INPUT //
        $rows = [
            '10' => '10',
            '25' => '25',
            '50' => '50',
            '100' => '100',
        ];
        // END FORM INPUT //

        // SETTINGS //
        $data_query = [
            'where' => [['user_id' => user()]],
            'order_by' => 'id DESC',
            'limit' => 10,
            'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
        ];
        // END SETTINGS //

        // SORT & SEARCH //
        if ($this->input->get('rows')) {
            if (!array_key_exists($this->input->get('rows'), $rows)) {
                exit(redirect(base_url('referral/history')));
            }
            $data_query['limit'] = $this->input->get('rows');
        }

        if ($this->input->get('search') <> '') {
            $data_query['where'][] = "full_name LIKE '%" . $this->db->escape_str(strip_tags($this->input->get('search'))) . "%'";
        }
        // END SORT & SEARCH //

        // PAGINATION //
        if ($this->uri->segment(3) <> '' and !is_numeric($this->uri->segment(3))) {
            exit(redirect(base_url('referral/history')));
        }
        $config['base_url'] = base_url('referral/history');
        $config['total_rows'] = $this->referral_komisi_model->get_count($data_query);
        $config['awal'] = $data_query['offset'] + 1;
        $config['akhir'] = $data_query['offset'] + $data_query['limit'];
        $config['per_page'] = $data_query['limit'];
        $this->pagination->initialize($config);
        // END PAGINATION //

        $this->render('public/referral/history', [
            'page_type' => 'Riwayat Convert',
            'table' => $this->referral_komisi_model->get_rows($data_query),
            'total_data' => $config['total_rows'],
            'per_page' => $config['per_page'],
            'rows' => $rows,
            'awal' => $config['awal'],
            'akhir' => $config['akhir']
        ]);
    }
    public function log()
    {
        // FORM INPUT //
        $rows = [
            '10' => '10',
            '25' => '25',
            '50' => '50',
            '100' => '100',
        ];
        // END FORM INPUT //

        // SETTINGS //
        $data_query = [
            'where' => [['user_id' => user()]],
            'order_by' => 'id DESC',
            'limit' => 10,
            'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
        ];
        // END SETTINGS //

        // SORT & SEARCH //
        if ($this->input->get('rows')) {
            if (!array_key_exists($this->input->get('rows'), $rows)) {
                exit(redirect(base_url('referral/log')));
            }
            $data_query['limit'] = $this->input->get('rows');
        }

        if ($this->input->get('search') <> '') {
            $data_query['where'][] = "full_name LIKE '%" . $this->db->escape_str(strip_tags($this->input->get('search'))) . "%'";
        }
        // END SORT & SEARCH //

        // PAGINATION //
        if ($this->uri->segment(3) <> '' and !is_numeric($this->uri->segment(3))) {
            exit(redirect(base_url('referral/log')));
        }
        $config['base_url'] = base_url('referral/log');
        $config['total_rows'] = $this->referral_log_model->get_count($data_query);
        $config['awal'] = $data_query['offset'] + 1;
        $config['akhir'] = $data_query['offset'] + $data_query['limit'];
        $config['per_page'] = $data_query['limit'];
        $this->pagination->initialize($config);
        // END PAGINATION //

        $this->render('public/referral/log', [
            'page_type' => 'Riwayat Komisi',
            'table' => $this->referral_log_model->get_rows($data_query),
            'total_data' => $config['total_rows'],
            'per_page' => $config['per_page'],
            'rows' => $rows,
            'awal' => $config['awal'],
            'akhir' => $config['akhir']
        ]);
    }
}
