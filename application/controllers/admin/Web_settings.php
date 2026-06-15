<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web_settings extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_cookie_admin(get_cookie('admin_login'));
        if (admin() == false)
            exit(redirect(base_url('admin/auth/logout')));
        if (admin('level') <> 'owner') {
            $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Akses Tidak Sah!', 'msg' => 'Anda tidak memiliki akses ke halaman tersebut.'));
            exit(redirect(base_url('admin')));
        }
    }

    public function index()
    {
        exit(redirect(base_url('admin/web_settings/general')));
    }
    public function general()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('title', 'Full Title', 'required');
                $this->form_validation->set_rules('short_title', 'Short Title', 'required');
                $this->form_validation->set_rules('meta_author', 'Meta Author', 'required');
                $this->form_validation->set_rules('bartitle', 'Bar Title', 'required');
                $this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
                $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
                $this->form_validation->set_rules('footer', 'Footer', 'required');
                $this->form_validation->set_rules('top_order', 'Top 10 Pesanan', 'required');
                $this->form_validation->set_rules('top_deposit', 'Top 10 Deposit', 'required');
                $this->form_validation->set_rules('top_service', 'Top 10 Layanan', 'required');
                $this->form_validation->set_rules('referral_status', 'Sistem Referral', 'required');
                $this->form_validation->set_rules('rating_status', 'Ratiing Layanan', 'required');
                $this->form_validation->set_rules('page_register', 'Status Register', 'required');
                $this->form_validation->set_rules('page_forgot', 'Status Forgot Password', 'required');
                if ($this->form_validation->run() == true) {
                    if (isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])) {
                        $config['upload_path']      = FCPATH . '/uploads/website/';
                        $config['allowed_types']    = 'gif|jpg|png|jpeg|ico|svg';
                        $config['max_size']         = 10000;
                        $config['max_width']        = 10000;
                        $config['max_height']       = 10000;
                        $config['encrypt_name']     = true;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('logo')) {
                            $data_image = $this->upload->data();
                            @unlink(website_config('logo'));
                            set_website_config('logo', $data_image['file_name']);
                        } else {
                            $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' =>  $this->upload->display_errors()));
                        }
                    }
                    if (isset($_FILES['favicon']['name']) && !empty($_FILES['favicon']['name'])) {
                        $config['upload_path']      = FCPATH . '/uploads/website/';
                        $config['allowed_types']    = 'ico|png|jpg|jpeg';
                        $config['max_size']         = 10000;
                        $config['max_width']        = 10000;
                        $config['max_height']       = 10000;
                        $config['encrypt_name']     = true;
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('favicon')) {
                            $data_image = $this->upload->data();
                            @unlink(website_config('favicon'));
                            set_website_config('favicon', $data_image['file_name']);
                        } else {
                            $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' =>  $this->upload->display_errors()));
                        }
                    }
                    // if (isset($_FILES['meta_tags_image']['name']) && !empty($_FILES['meta_tags_image']['name'])) {
                    //     $config['upload_path']      = FCPATH . $this->default_path;
                    //     $config['allowed_types']    = 'gif|jpg|png|jpeg|ico|svg';
                    //     $config['max_size']         = 10000;
                    //     $config['max_width']        = 10000;
                    //     $config['max_height']       = 10000;
                    //     $config['encrypt_name']     = true;
                    //     $this->load->library('upload', $config);
                    //     if ($this->upload->do_upload('meta_tags_image')) {
                    //         $data_image = $this->upload->data();
                    //         @unlink(website_config('meta_tags_image'));
                    //         set_website_config('meta_tags_image', $config['upload_path'] . $data_image['file_name']);
                    //     } else {
                    //         $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' =>  $this->upload->display_errors()));
                    //     }
                    // }
                    set_website_config('mode_theme', $this->input->post('mode_theme'));
                    set_website_config('contrast_theme', $this->input->post('contrast_theme'));
                    set_website_config('color_theme', $this->input->post('color_theme'));
                    set_website_config('title', $this->input->post('title'));
                    set_website_config('short_title', $this->input->post('short_title'));
                    set_website_config('meta_author', $this->input->post('meta_author'));
                    set_website_config('bartitle', $this->input->post('bartitle'));
                    set_website_config('meta_description', $this->input->post('meta_description'));
                    set_website_config('meta_keywords', $this->input->post('meta_keywords'));
                    set_website_config('custom_tag', $this->input->post('custom_tag'));
                    set_website_config('gtm_head', $this->db->escape_str($this->input->post('gtm_head')));
                    set_website_config('gtm_body', $this->db->escape_str($this->input->post('gtm_body')));
                    set_website_config('footer', $this->input->post('footer'));
                    set_website_config('top_order', $this->input->post('top_order'));
                    set_website_config('top_deposit', $this->input->post('top_deposit'));
                    set_website_config('top_service', $this->input->post('top_service'));
                    set_website_config('referral_status', $this->input->post('referral_status'));
                    set_website_config('rating_status', $this->input->post('rating_status'));
                    set_website_config('page_register', $this->input->post('page_register'));
                    set_website_config('page_forgot', $this->input->post('page_forgot'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Website</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'Umum'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/' . $this->uri->segment(3), $data);
    }
    public function landing_page()
    {
        if ($this->input->post()) {
            //dd($this->input->post());
            if ($this->input->post()) {
                $this->form_validation->set_rules('title_landing', 'Title Landing', 'required');
                $this->form_validation->set_rules('meta_description_landing', 'Meta Description Landing', 'required');
                $this->form_validation->set_rules('meta_keywords_landing', 'Meta Keyword Landing', 'required');
                $this->form_validation->set_rules('navbar_brand', 'Navbar Brand Landing', 'required');
                $this->form_validation->set_rules('description_1', 'Description 1', 'required');
                $this->form_validation->set_rules('description_2', 'Description 2', 'required');
                $this->form_validation->set_rules('about_title', 'About Title', 'required');
                $this->form_validation->set_rules('about_description', 'About Description', 'required');
                $this->form_validation->set_rules('about_1_title', 'About 1 - Title', 'required');
                $this->form_validation->set_rules('about_1_content', 'About 1 - Content', 'required');
                $this->form_validation->set_rules('about_2_title', 'About 2 - Title', 'required');
                $this->form_validation->set_rules('about_2_content', 'About 2 - Content', 'required');
                $this->form_validation->set_rules('about_3_title', 'About 3 - Title', 'required');
                $this->form_validation->set_rules('about_3_content', 'About 3 - Content', 'required');
                $this->form_validation->set_rules('feature_title', 'Feature Title', 'required');
                $this->form_validation->set_rules('feature_description', 'Feature Description', 'required');
                $this->form_validation->set_rules('testi_title', 'Testimonial Title', 'required');
                $this->form_validation->set_rules('testi_description', 'Testimonial Description', 'required');
                if ($this->form_validation->run() == true) {

                    if ($this->input->post('features_title')) {
                        $this->landing_config_model->delete(['type' => 'features']);
                        $title = $this->input->post('features_title');
                        $content = $this->input->post('features_content');
                        for ($i = 0; $i < count($title); $i++) {
                            $this->landing_config_model->insert([
                                'type' => 'features',
                                'title' => trim($title[$i]),
                                'content' => trim($content[$i]),
                            ]);
                        }
                    }

                    if ($this->input->post('testimonials_top_title')) {
                        $this->landing_config_model->delete(['type' => 'testimonial_top']);
                        $icon = $this->input->post('testimonials_top_avatar');
                        $name = $this->input->post('testimonials_top_name');
                        $title = $this->input->post('testimonials_top_title');
                        $content = $this->input->post('testimonials_top_content');
                        for ($i = 0; $i < count($icon); $i++) {
                            $this->landing_config_model->insert([
                                'type' => 'testimonial_top',
                                'icon' => trim($icon[$i]),
                                'name' => trim($name[$i]),
                                'title' => trim($title[$i]),
                                'content' => trim($content[$i]),
                            ]);
                        }
                    }

                    if ($this->input->post('testimonials_bottom_title')) {
                        $this->landing_config_model->delete(['type' => 'testimonial_bottom']);
                        $icon = $this->input->post('testimonials_bottom_avatar');
                        $name = $this->input->post('testimonials_bottom_name');
                        $title = $this->input->post('testimonials_bottom_title');
                        $content = $this->input->post('testimonials_bottom_content');
                        for ($i = 0; $i < count($icon); $i++) {
                            $this->landing_config_model->insert([
                                'type' => 'testimonial_bottom',
                                'icon' => trim($icon[$i]),
                                'name' => trim($name[$i]),
                                'title' => trim($title[$i]),
                                'content' => trim($content[$i]),
                            ]);
                        }
                    }

                    set_website_config('title_landing', $this->input->post('title_landing'));
                    set_website_config('meta_description_landing', $this->input->post('meta_description_landing'));
                    set_website_config('meta_keywords_landing', $this->input->post('meta_keywords_landing'));
                    set_website_config('navbar_brand_landing', $this->input->post('navbar_brand'));
                    set_website_config('description1_landing', $this->input->post('description_1'));
                    set_website_config('description2_landing', $this->input->post('description_2'));
                    set_website_config('about_title_landing', $this->input->post('about_title'));
                    set_website_config('about_description_landing', $this->input->post('about_description'));
                    set_website_config('about_1_title', $this->input->post('about_1_title'));
                    set_website_config('about_1_content', $this->input->post('about_1_content'));
                    set_website_config('about_2_title', $this->input->post('about_2_title'));
                    set_website_config('about_2_content', $this->input->post('about_2_content'));
                    set_website_config('about_3_title', $this->input->post('about_3_title'));
                    set_website_config('feature_title', $this->input->post('feature_title'));
                    set_website_config('feature_description', $this->input->post('feature_description'));
                    set_website_config('testi_title', $this->input->post('testi_title'));
                    set_website_config('testi_description', $this->input->post('testi_description'));

                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Website</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'Landing Page',
            'avatars_labels' => [
                'avatar-1.jpg' => 'Laki-Laki 1',
                'avatar-2.jpg' => 'Laki-Laki 2',
                'avatar-4.jpg' => 'Laki-Laki 3',
                'avatar-5.jpg' => 'Laki-Laki 4',
                'avatar-7.jpg' => 'Laki-Laki 5',
                'avatar-8.jpg' => 'Laki-Laki 6',
                'avatar-3.jpg' => 'Perempuan 1',
                'avatar-6.jpg' => 'Perempuan 2',
                'avatar-9.jpg' => 'Perempuan 3',
                'avatar-10.jpg' => 'Perempuan 4',
            ],
            'avatars' => [
                'avatar-1.jpg',
                'avatar-2.jpg',
                'avatar-4.jpg',
                'avatar-5.jpg',
                'avatar-7.jpg',
                'avatar-8.jpg',
                'avatar-3.jpg',
                'avatar-6.jpg',
                'avatar-9.jpg',
                'avatar-10.jpg',
            ],
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/' . $this->uri->segment(3), $data);
    }
    public function info()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('limit_order', 'Limit Pesanan', 'required');
                $this->form_validation->set_rules('terms_link', 'Link Ketentuan Layanan', 'required');
                $this->form_validation->set_rules('order_info', 'Order Info', 'required');
                $this->form_validation->set_rules('deposit_info', 'Deposit Info', 'required');
                $this->form_validation->set_rules('payout_info', 'Payout Info', 'required');
                $this->form_validation->set_rules('convert_info', 'Convert Info', 'required');
                if ($this->form_validation->run() == true) {
                    set_website_config('limit_order', $this->input->post('limit_order'));
                    set_website_config('terms_link', $this->input->post('terms_link'));
                    set_website_config('order_info', $this->input->post('order_info'));
                    set_website_config('deposit_info', $this->input->post('deposit_info'));
                    set_website_config('payout_info', $this->input->post('payout_info'));
                    set_website_config('convert_info', $this->input->post('convert_info'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Informasi</b> berhasil diubah.'));
                    exit(redirect(base_url('admin/web_settings/general')));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                    exit(redirect(base_url('admin/web_settings/general')));
                }
            }
        }
        $data = [
            'page' => 'Pengaturan Info / Tutorial'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/general', $data);
    }
    public function login_page()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('title_login', 'Title Login', 'required');
                $this->form_validation->set_rules('meta_description_login', 'Meta Description Login', 'required');
                $this->form_validation->set_rules('meta_keywords_login', 'Meta Keywords Login', 'required');
                $this->form_validation->set_rules('brand_login', 'Brand Login', 'required');
                if ($this->form_validation->run() == true) {
                    set_website_config('title_login', $this->input->post('title_login'));
                    set_website_config('meta_description_login', $this->input->post('meta_description_login'));
                    set_website_config('meta_keywords_login', $this->input->post('meta_keywords_login'));
                    set_website_config('brand_login', $this->input->post('brand_login'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Login Page</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'Login Page'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/login_page', $data);
    }
    public function register_page()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('title_register', 'Title Register', 'required');
                $this->form_validation->set_rules('meta_description_register', 'Meta Description Register', 'required');
                $this->form_validation->set_rules('meta_keywords_register', 'Meta Keywords Register', 'required');
                $this->form_validation->set_rules('brand_register', 'Brand Register', 'required');
                if ($this->form_validation->run() == true) {
                    set_website_config('title_register', $this->input->post('title_register'));
                    set_website_config('meta_description_register', $this->input->post('meta_description_register'));
                    set_website_config('meta_keywords_register', $this->input->post('meta_keywords_register'));
                    set_website_config('brand_register', $this->input->post('brand_register'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Register Page</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'Register Page'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/register_page', $data);
    }
    public function forgot_page()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('title_forgot', 'Title Forgot', 'required');
                $this->form_validation->set_rules('meta_description_forgot', 'Meta Description Forgot', 'required');
                $this->form_validation->set_rules('meta_keywords_forgot', 'Meta Keywords Forgot', 'required');
                $this->form_validation->set_rules('brand_forgot', 'Brand Forgot', 'required');
                if ($this->form_validation->run() == true) {
                    set_website_config('title_forgot', $this->input->post('title_forgot'));
                    set_website_config('meta_description_forgot', $this->input->post('meta_description_forgot'));
                    set_website_config('meta_keywords_forgot', $this->input->post('meta_keywords_forgot'));
                    set_website_config('brand_forgot', $this->input->post('brand_forgot'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Forgot Page</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'Forgot Page'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/forgot_page', $data);
    }
        public function grecaptcha()
    {
        // Handle Switch Status via GET
        $grStatus = $this->input->get('gr_status');
        if (!empty($grStatus)) {
            if ($grStatus === 'on' || $grStatus === 'off') {
                set_website_config('gr_status', $grStatus);
                redirect(site_url('admin/web_settings/grecaptcha'));
            }
        }

        if ($this->input->post()) {
            // JIKA FORM GOOGLE LOGIN DISUBMIT
            if (isset($_POST['submit_google'])) {
                $this->form_validation->set_rules('google_client_id', 'Client ID', 'required');
                $this->form_validation->set_rules('google_client_secret', 'Client Secret', 'required');
                $this->form_validation->set_rules('google_redirect_url', 'Redirect URL', 'required');

                if ($this->form_validation->run() == true) {
                    set_website_config('google_client_id', $this->input->post('google_client_id'));
                    set_website_config('google_client_secret', $this->input->post('google_client_secret'));
                    set_website_config('google_redirect_url', $this->input->post('google_redirect_url'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Konfigurasi Google Login diperbarui.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => validation_errors()));
                }
                redirect(site_url('admin/web_settings/grecaptcha'));
            }

            // JIKA FORM RECAPTCHA DISUBMIT
            if (isset($_POST['submit_recaptcha'])) {
                $this->form_validation->set_rules('gr_site_key', 'Site Key', 'required');
                $this->form_validation->set_rules('gr_secret_key', 'Secret Key', 'required');

                if ($this->form_validation->run() == true) {
                    set_website_config('gr_site_key', $this->input->post('gr_site_key'));
                    set_website_config('gr_secret_key', $this->input->post('gr_secret_key'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Konfigurasi ReCaptcha diperbarui.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => validation_errors()));
                }
                redirect(site_url('admin/web_settings/grecaptcha'));
            }
        }

        $data = ['page' => 'G-Recaptcha & Google Auth'];
        $this->render_admin('admin/web_settings/grecaptcha', $data);
    }
    public function smtp()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('smtp_host', 'Host', 'required');
                $this->form_validation->set_rules('smtp_username', 'Username', 'required');
                // $this->form_validation->set_rules('smtp_password', 'Password', 'required');
                $this->form_validation->set_rules('smtp_encrypt', 'Encrypt', 'required');
                $this->form_validation->set_rules('smtp_port', 'Port', 'required');
                if ($this->form_validation->run() == true) {
                    set_website_config('smtp_host', $this->input->post('smtp_host'));
                    set_website_config('smtp_username', $this->input->post('smtp_username'));
                    // Periksa apakah input password diisi
                    if ($this->input->post('smtp_password') != '') {
                        set_website_config('smtp_password', $this->input->post('smtp_password'));
                    }
                    set_website_config('smtp_encrypt', $this->input->post('smtp_encrypt'));
                    set_website_config('smtp_port', $this->input->post('smtp_port'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>SMTP</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'SMTP'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/smtp', $data);
    }
    public function gateway()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('wa_admin', 'Notifikasi Whatsapp Admin', 'required');
                $this->form_validation->set_rules('wa_endpoint', 'Endpoint', 'required');
                $this->form_validation->set_rules('wa_app_key', 'APP Key', 'required');
                $this->form_validation->set_rules('wa_auth_key', 'Auth Key', 'required');
                $this->form_validation->set_rules('send_wa_otp', 'Send OTP', 'required');
                $this->form_validation->set_rules('send_wa_deposit', 'Send Deposit', 'required');
                $this->form_validation->set_rules('send_wa_ticket_user', 'Send Ticket User', 'required');
                $this->form_validation->set_rules('send_wa_ticket_admin', 'Send Ticket Admin', 'required');
                if ($this->form_validation->run() == true) {
                    set_website_config('wa_admin', $this->input->post('wa_admin'));
                    set_website_config('wa_endpoint', $this->input->post('wa_endpoint'));
                    set_website_config('wa_app_key', $this->input->post('wa_app_key'));
                    set_website_config('wa_auth_key', $this->input->post('wa_auth_key'));
                    set_website_config('send_wa_otp', $this->input->post('send_wa_otp'));
                    set_website_config('send_wa_deposit', $this->input->post('send_wa_deposit'));
                    set_website_config('send_wa_ticket_user', $this->input->post('send_wa_ticket_user'));
                    set_website_config('send_wa_ticket_admin', $this->input->post('send_wa_ticket_admin'));
                    set_website_config('wa_otp_login', $this->input->post('wa_otp_login'));
                    set_website_config('wa_otp_register', $this->input->post('wa_otp_register'));
                    set_website_config('wa_admin_otp_register', $this->input->post('wa_admin_otp_register'));
                    set_website_config('wa_otp_reset', $this->input->post('wa_otp_reset'));
                    set_website_config('wa_deposit_pending', $this->input->post('wa_deposit_pending'));
                    set_website_config('wa_deposit_success', $this->input->post('wa_deposit_success'));
                    set_website_config('wa_deposit_canceled', $this->input->post('wa_deposit_canceled'));
                    set_website_config('wa_admin_deposit_pending', $this->input->post('wa_admin_deposit_pending'));
                    set_website_config('wa_admin_deposit_success', $this->input->post('wa_admin_deposit_success'));
                    set_website_config('wa_admin_deposit_canceled', $this->input->post('wa_admin_deposit_canceled'));
                    set_website_config('wa_ticket_create', $this->input->post('wa_ticket_create'));
                    set_website_config('wa_ticket_reply', $this->input->post('wa_ticket_reply'));
                    set_website_config('wa_ticket_close', $this->input->post('wa_ticket_close'));
                    set_website_config('wa_admin_ticket_create', $this->input->post('wa_admin_ticket_create'));
                    set_website_config('wa_admin_ticket_reply', $this->input->post('wa_admin_ticket_reply'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Whatsapp Gateway</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'WA Gateway'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/gateway', $data);
    }
    public function maintenance()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('mt_web', 'Maintenance Web', 'required');
                $this->form_validation->set_rules('mt_api', 'Maintenance Api', 'required');
                if ($this->form_validation->run() == true) {
                    set_website_config('mt_api', $this->input->post('mt_api'));
                    set_website_config('mt_web', $this->input->post('mt_web'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Maintenance</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'Maintenance'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/maintenance', $data);
    }
    public function custom_statistic()
    {
        if ($this->input->get('act') == 'total') {
            if ($this->input->post()) {
                if ($this->input->post()) {
                    $this->form_validation->set_rules('total_user', 'Manipulasi Total User', 'required');
                    $this->form_validation->set_rules('total_deposit', 'Manipulasi Total Deposit', 'required');
                    $this->form_validation->set_rules('total_order', 'Manipulasi Total Pesanan', 'required');
                    if ($this->form_validation->run() == true) {
                        set_custom_statistic('total_user', $this->input->post('total_user'), 'total');
                        set_custom_statistic('total_deposit', $this->input->post('total_deposit'), 'total');
                        set_custom_statistic('total_order', $this->input->post('total_order'), 'total');
                        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Custom Statistic</b> berhasil diubah.'));
                    } else {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                    }
                    redirect(site_url('admin/' . url_title($this->uri->segment(2)) . '/' . url_title($this->uri->segment(3))));
                }
            }
        } elseif ($this->input->get('act') == 'online') {
            if ($this->input->post()) {
                if ($this->input->post()) {
                    $this->form_validation->set_rules('total_admin_online', 'Manipulasi Admin Online', 'required');
                    $this->form_validation->set_rules('total_user_online', 'Manipulasi User Online', 'required');
                    if ($this->form_validation->run() == true) {
                        set_custom_statistic('total_admin_online', $this->input->post('total_admin_online'), 'online');
                        set_custom_statistic('total_user_online', $this->input->post('total_user_online'), 'online');
                        $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Custom Statistic</b> berhasil diubah.'));
                    } else {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                    }
                    redirect(site_url('admin/' . url_title($this->uri->segment(2)) . '/' . url_title($this->uri->segment(3))));
                }
            }
        } elseif ($this->input->get('act') == 'top_order') {
            if ($this->input->post()) {
                for ($i = 1; $i <= 10; $i++) {
                    $s_top_order = "s_top_order_$i";
                    $u_top_order = "u_top_order_$i";
                    $a_top_order = "a_top_order_$i";
                    $c_top_order = "c_top_order_$i";

                    $this->form_validation->set_rules($s_top_order, "Manipulasi Top Pesanan #$i", "required");

                    if ($this->form_validation->run() == true) {
                        $data_to_save[$s_top_order] = $this->input->post($s_top_order);

                        if ($this->input->post($s_top_order) == 1) {
                            $data_to_save[$u_top_order] = $this->input->post($u_top_order);
                            $data_to_save[$a_top_order] = $this->input->post($a_top_order);
                            $data_to_save[$c_top_order] = $this->input->post($c_top_order);
                        }
                    } else {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                        redirect(site_url('admin/' . url_title($this->uri->segment(2)) . '/' . url_title($this->uri->segment(3))));
                    }
                }

                // Simpan data jika tidak ada kesalahan validasi
                if (!empty($data_to_save)) {
                    foreach ($data_to_save as $key => $value) {
                        set_custom_statistic($key, $value, 'top_order');
                    }

                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Data <b>Top Pesanan</b> berhasil diubah.'));
                    redirect(site_url('admin/' . url_title($this->uri->segment(2)) . '/' . url_title($this->uri->segment(3))));
                }
            }
        } elseif ($this->input->get('act') == 'top_deposit') {
            if ($this->input->post()) {
                for ($i = 1; $i <= 10; $i++) {
                    $s_top_deposit = "s_top_deposit_$i";
                    $u_top_deposit = "u_top_deposit_$i";
                    $a_top_deposit = "a_top_deposit_$i";
                    $c_top_deposit = "c_top_deposit_$i";

                    $this->form_validation->set_rules($s_top_deposit, "Manipulasi Top Deposit #$i", "required");

                    if ($this->form_validation->run() == true) {
                        $data_to_save[$s_top_deposit] = $this->input->post($s_top_deposit);

                        if ($this->input->post($s_top_deposit) == 1) {
                            $data_to_save[$u_top_deposit] = $this->input->post($u_top_deposit);
                            $data_to_save[$a_top_deposit] = $this->input->post($a_top_deposit);
                            $data_to_save[$c_top_deposit] = $this->input->post($c_top_deposit);
                        }
                    } else {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                        redirect(site_url('admin/' . url_title($this->uri->segment(2)) . '/' . url_title($this->uri->segment(3))));
                    }
                }

                // Simpan data jika tidak ada kesalahan validasi
                if (!empty($data_to_save)) {
                    foreach ($data_to_save as $key => $value) {
                        set_custom_statistic($key, $value, 'top_deposit');
                    }

                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Data <b>Top Deposit</b> berhasil diubah.'));
                    redirect(site_url('admin/' . url_title($this->uri->segment(2)) . '/' . url_title($this->uri->segment(3))));
                }
            }
        } elseif ($this->input->get('act') == 'top_service') {
            if ($this->input->post()) {
                for ($i = 1; $i <= 10; $i++) {
                    $s_top_service = "s_top_service_$i";
                    $sc_top_service = "sc_top_service_$i";
                    $a_top_service = "a_top_service_$i";
                    $c_top_service = "c_top_service_$i";

                    $this->form_validation->set_rules($s_top_service, "Manipulasi Top Layanan #$i", "required");

                    if ($this->form_validation->run() == true) {
                        $data_to_save[$s_top_service] = $this->input->post($s_top_service);

                        if ($this->input->post($s_top_service) == 1) {
                            $data_to_save[$sc_top_service] = $this->input->post($sc_top_service);
                            $data_to_save[$a_top_service] = $this->input->post($a_top_service);
                            $data_to_save[$c_top_service] = $this->input->post($c_top_service);
                        }
                    } else {
                        $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                        redirect(site_url('admin/' . url_title($this->uri->segment(2)) . '/' . url_title($this->uri->segment(3))));
                    }
                }

                // Simpan data jika tidak ada kesalahan validasi
                if (!empty($data_to_save)) {
                    foreach ($data_to_save as $key => $value) {
                        set_custom_statistic($key, $value, 'top_service');
                    }

                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Data <b>Top Layanan</b> berhasil diubah.'));
                    redirect(site_url('admin/' . url_title($this->uri->segment(2)) . '/' . url_title($this->uri->segment(3))));
                }
            }
        }

        $data = [
            'page' => 'Custom Statistic'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/custom_statistic', $data);
    }
    public function referral()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('referral_rate_silver', 'Rate Komisi Silver', 'required');
                $this->form_validation->set_rules('referral_rate_gold', 'Rate Komisi Gold', 'required');
                $this->form_validation->set_rules('referral_rate_platinum', 'Rate Komisi Platinum', 'required');
                $this->form_validation->set_rules('referral_rate_diamond', 'Rate Komisi Diamond', 'required');
                $this->form_validation->set_rules('referral_minimun_convert', 'Minimum Convert Komisi', 'required');
                if ($this->form_validation->run() == true) {
                    set_website_config('referral_rate_silver', $this->input->post('referral_rate_silver'));
                    set_website_config('referral_rate_gold', $this->input->post('referral_rate_gold'));
                    set_website_config('referral_rate_platinum', $this->input->post('referral_rate_platinum'));
                    set_website_config('referral_rate_diamond', $this->input->post('referral_rate_diamond'));
                    set_website_config('referral_minimun_convert', $this->input->post('referral_minimun_convert'));
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Referral</b> berhasil diubah.'));
                    exit(redirect(base_url('admin/web_settings/benefit')));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                    exit(redirect(base_url('admin/web_settings/benefit')));
                }
            }
        }
        $data = [
            'page' => 'Benefit',
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/benefit', $data);
    }
    public function benefit()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('min_payout_silver', 'Minimum Payout Silver', 'required');
            $this->form_validation->set_rules('rate_payout_silver', 'Rate Payout Silver', 'required');
            $this->form_validation->set_rules('trx_gold', 'Transaksi User Gold', 'required');
            $this->form_validation->set_rules('min_payout_gold', 'Minimun Payout Gold', 'required');
            $this->form_validation->set_rules('rate_payout_gold', 'Rate Payout Gold', 'required');
            $this->form_validation->set_rules('trx_platinum', 'Transaksi User Platinum', 'required');
            $this->form_validation->set_rules('min_payout_platinum', 'Minimum Payout Platinum', 'required');
            $this->form_validation->set_rules('rate_payout_platinum', 'Rate Payout Platinum', 'required');
            $this->form_validation->set_rules('trx_diamond', 'Transaksi User Diamond', 'required');
            $this->form_validation->set_rules('min_payout_diamond', 'Minimum Payout Diamond', 'required');
            $this->form_validation->set_rules('rate_payout_diamond', 'Rate Payout Diamond', 'required');
            $this->form_validation->set_rules('benefit_trx', 'Total Transaksi = 1 Point', 'required');

            if ($this->form_validation->run() == true) {
                set_benefit('min_payout', $this->input->post('min_payout_silver'), 'Silver');
                set_benefit('rate_payout', $this->input->post('rate_payout_silver'), 'Silver');
                set_benefit('trx', $this->input->post('trx_gold'), 'Gold');
                set_benefit('min_payout', $this->input->post('min_payout_gold'), 'Gold');
                set_benefit('rate_payout', $this->input->post('rate_payout_gold'), 'Gold');
                set_benefit('trx', $this->input->post('trx_platinum'), 'Platinum');
                set_benefit('min_payout', $this->input->post('min_payout_platinum'), 'Platinum');
                set_benefit('rate_payout', $this->input->post('rate_payout_platinum'), 'Platinum');
                set_benefit('trx', $this->input->post('trx_diamond'), 'Diamond');
                set_benefit('min_payout', $this->input->post('min_payout_diamond'), 'Diamond');
                set_benefit('rate_payout', $this->input->post('rate_payout_diamond'), 'Diamond');
                set_website_config('benefit_trx', $this->input->post('benefit_trx'));

                $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Benefit</b> berhasil diubah.'));
            } else {
                $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
            }
        }

        $data = [
            'page' => 'Benefit',
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/benefit', $data);
    }

    public function payment_gateway()
    {
        if ($this->input->post()) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('tripay_merchant_code', 'Merchant Code Tripay', 'required');
                $this->form_validation->set_rules('tripay_api_key', 'Api Key Tripay', 'required');
                $this->form_validation->set_rules('tripay_private_key', 'Private Key Tripay', 'required');
                $this->form_validation->set_rules('paydisini_api_key', 'Api Key Paydisini', 'required');
                
                if ($this->form_validation->run() == true) {
                    set_website_config('tripay_merchant_code', $this->input->post('tripay_merchant_code'));
                    set_website_config('tripay_api_key', $this->input->post('tripay_api_key'));
                    set_website_config('tripay_private_key', $this->input->post('tripay_private_key'));
                    set_website_config('paydisini_api_key', $this->input->post('paydisini_api_key'));
                    
                    $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Payment Gateway</b> berhasil diubah.'));
                } else {
                    $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
                }
            }
        }
        $data = [
            'page' => 'Payment Gateway'
        ];
        $this->render_admin('admin/' . $this->uri->segment(2) . '/payment_gateway', $data);
    }
}
