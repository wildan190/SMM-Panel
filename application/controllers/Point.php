<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Point extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (website_config('mt_web') == 1) {
            exit(redirect(base_url('maintenance')));
        }
        check_cookie(get_cookie('smm_login'));
        if (user() == false)
            exit(redirect(base_url('auth/logout')));
    }
    public function new()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('amount', 'Jumlah Point', 'required');
            if ($this->form_validation->run() == true) {
                $jumlah = $this->db->escape_str($this->input->post('amount'));
                $total_saldo = benefit('rate_payout', user('benefit')) * $jumlah;
                if ($jumlah > user('benefit_point')) {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Jumlah Point Anda tidak cukup.'));
                } elseif (benefit('min_payout', user('benefit')) > $jumlah) {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Minimum Payout adalah ' . currency(benefit('min_payout', user('benefit'))) . ' Point.'));
                } else {
                    $saldo_user = user('balance');
                    $this->db->trans_start();
                    $this->user_model->update(['benefit_point' => user('benefit_point') - $jumlah], ['id' => user()]);
                    $this->user_model->update(['balance' => user('balance') + $total_saldo], ['id' => user()]);
                    $data_insert = [
                        'user_id' => user(),
                        'rate' => benefit('rate_payout', user('benefit')),
                        'amount' => $jumlah,
                        'balance' => $total_saldo,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $insert = $this->benefit_payout_model->insert($data_insert);
                    $this->log_balance_usage_model->insert([
                        'user_id' => user(),
                        'type' => 'plus',
                        'category' => 'payout point',
                        'amount' => $total_saldo,
                        'before' => $saldo_user,
                        'after' => $saldo_user + $total_saldo,
                        'description' => 'Penukaran ' . currency($jumlah) . ' Point menjadi Rp ' . currency($total_saldo) . ' Saldo - #' . $insert . '.',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() == true) {
                        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Payout berhasil, Anda mendapatkan Saldo Rp ' . currency($total_saldo) . '.'));
                    } else {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi Kesalahan'));
                    }
                }
            } else {
                $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => validation_errors()));
            }
        }
        $this->render('public/point/new', ['page_type' => 'Payout Point']);
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
            exit(redirect(base_url('point/history')));
        }
        $config['base_url'] = base_url('referral/history');
        $config['total_rows'] = $this->benefit_payout_model->get_count($data_query);
        $config['awal'] = $data_query['offset'] + 1;
        $config['akhir'] = $data_query['offset'] + $data_query['limit'];
        $config['per_page'] = $data_query['limit'];
        $this->pagination->initialize($config);
        // END PAGINATION //

        $this->render('public/point/history', [
            'page_type' => 'Riwayat Payout',
            'table' => $this->benefit_payout_model->get_rows($data_query),
            'total_data' => $config['total_rows'],
            'per_page' => $config['per_page'],
            'rows' => $rows,
            'awal' => $config['awal'],
            'akhir' => $config['akhir']
        ]);
    }
    // public function update()
    // {
    //     $user = $this->user_model->get_rows();
    //     foreach ($user as $key => $value) {
    //         $awal_point = $value['benefit_point'];
    //         $order = $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total', 'where' => [['user_id' => $value['id']]]]);
    //         $total_order = $order[0]['rupiah'];

    //         // Hitung jumlah point berdasarkan setiap Rp 50.000 total transaksi
    //         $point = round($total_order / website_config('benefit_trx'));

    //         // Ambil sisa dari pembagian untuk mengetahui nilai kurang atau lebih dari kelipatan Rp 50.000
    //         $sisa_progress = round($total_order % website_config('benefit_trx'));

    //         $update = $this->user_model->update([
    //             'benefit_point' => round($point), // Menambahkan point yang sudah dihitung
    //             'benefit_progress' => $sisa_progress, // Update sisa transaksi user
    //         ], ['id' => $value['id']]);

    //         // Print echo sesuai format yang diinginkan
    //         echo "$value[username] - $update[benefit_point]\n";
    //     }
    // }
}
