<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Impor kelas PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// if (website_config('mt_web') == 1) {
		// 	exit(redirect(base_url('maintenance')));
		// }
		check_cookie(get_cookie('smm_login'));
		if ($this->session->userdata('login') and $this->uri->segment(2) <> 'logout') {
			if (user() == false)
				exit(redirect(base_url('auth/logout')));
		}
	}
	    // --- KODE GOOGLE LOGIN START ---
    
        public function google_login($type = 'login') {
        require_once FCPATH . 'vendor/autoload.php';
        
        // Simpan tanda (login/register) ke session agar tahu asal klik user
        $this->session->set_userdata('google_auth_type', $type);

        $client = new Google_Client();
        $client->setClientId(website_config('google_client_id'));
        $client->setClientSecret(website_config('google_client_secret'));
        $client->setRedirectUri(website_config('google_redirect_url'));
        $client->addScope("email");
        $client->addScope("profile");

        redirect($client->createAuthUrl());
    }

    public function google_callback() {
        require_once FCPATH . 'vendor/autoload.php';
        
        $client = new Google_Client();
        $client->setClientId(website_config('google_client_id'));
        $client->setClientSecret(website_config('google_client_secret'));
        $client->setRedirectUri(website_config('google_redirect_url'));

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            
            if(isset($token['error'])) {
                $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal', 'msg' => 'Autentikasi Google Gagal.']);
                redirect(base_url('auth/login'));
            }

            $client->setAccessToken($token);
            $google_oauth = new Google_Service_Oauth2($client);
            $google_info = $google_oauth->userinfo->get();

            $email = $google_info->email;
            $google_id = $google_info->id;
            $name = $google_info->name;

            // Ambil informasi asal klik (login/register) dari session
            $auth_type = $this->session->userdata('google_auth_type');
            $this->session->unset_userdata('google_auth_type');

            // Cek apakah email sudah ada di database
            $user = $this->db->get_where('user', ['email' => $email])->row_array();

            if ($user) {
                // --- KONDISI 1: USER SUDAH PUNYA AKUN ---
                
                if ($user['status'] == '0') {
                    $this->session->set_flashdata('result', ['alert' => 'danger', 'title' => 'Gagal', 'msg' => 'Akun Anda dinonaktifkan.']);
                    redirect(base_url('auth/login'));
                }

                // Proses Login: Set Log & Cookie
                $user_agent = $this->input->user_agent();
                $device = isset($_SERVER['HTTP_USER_AGENT']) ? $this->input->devices() : 'unknown';

                $data_cookie = [
                    'user_id' => $user['id'],
                    'cookie' => random_string('alnum', 100),
                    'ip_address' => $this->input->ip_address(),
                    'login' => 'user',
                    'ua' => $user_agent,
                    'browser' => $this->agent->browser(),
                    'browser_version' => $this->agent->version(),
                    'platform' => $this->agent->platform(),
                    'ud' => $device,
                    'created_at' => date('Y-m-d H:i:s'),
                    'expired_at' => date('Y-m-d H:i:s', strtotime('+2 hours')),
                ];

                $this->cookie_model->insert($data_cookie);
                $this->log_login_user_model->insert([
                    'user_id' => $user['id'],
                    'ip_address' => $this->input->ip_address(),
                    'ua' => $user_agent,
                    'ud' => $device,
                    'browser' => $this->agent->browser(),
                    'browser_version' => $this->agent->version(),
                    'platform' => $this->agent->platform(),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                set_cookie('smm_login', $data_cookie['cookie'], 7200);

                // Update Google ID di database jika belum ada
                if (empty($user['google_id'])) {
                    $this->db->update('user', ['google_id' => $google_id], ['id' => $user['id']]);
                }
                
                $this->session->set_userdata('login', $user['id']);
                $this->session->set_flashdata('result', ['alert' => 'success', 'title' => 'Berhasil Masuk', 'msg' => 'Halo ' . $name . ', Selamat datang kembali.']);
                
                // REDIRECT KE DASHBOARD SESUAI PERMINTAAN
                redirect(base_url('auth/index')); 

            } else {
                // --- KONDISI 2: USER BELUM PUNYA AKUN ---

                if ($auth_type === 'register') {
                    // Buat Akun Otomatis karena user klik dari halaman REGISTER
                    $data_user = [
                        'google_id' => $google_id,
                        'username' => strtolower(explode('@', $email)[0]) . rand(11,99),
                        'full_name' => $name,
                        'email' => $email,
                        'password' => password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT),
                        'balance' => 0,
                        'level' => 'Member',
                        'status' => '1',
                        'is_verif' => '1',
                        'api_key' => bin2hex(random_bytes(16)),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('user', $data_user);
                    
                    $this->session->set_flashdata('result', [
                        'alert' => 'success', 
                        'title' => 'Pendaftaran Berhasil', 
                        'msg' => 'Akun berhasil dibuat. Silakan Login dengan Google sekali lagi untuk masuk.'
                    ]);
                    redirect(base_url('auth/login'));
                } else {
                    // Tolak Login karena belum punya akun (klik dari halaman LOGIN)
                    $this->session->set_flashdata('result', [
                        'alert' => 'danger', 
                        'title' => 'Gagal Masuk', 
                        'msg' => 'Email ' . $email . ' belum terdaftar. Silakan buat akun terlebih dahulu di halaman registrasi.'
                    ]);
                    redirect(base_url('auth/register'));
                }
            }
        } else {
            redirect(base_url('auth/login'));
        }
    }

    // --- KODE GOOGLE LOGIN END ---

	public function ip()
	{
		echo $this->input->ip_address();
	}
	public function index()
	{

		if ($this->session->userdata('login')) {
			$chart_item = $this->lib->list_date_range(substr($this->lib->sum_date(date('Y-m-d'), '-7 days'), 0, 10), date('Y-m-d'));
			$chart = [];
			foreach ($chart_item as $key => $value) {
				array_push($chart, [
					'date' => $value,
					'count' => $this->order_model->get_count(['select' => 'id', 'where' => [['user_id' => user(), 'DATE(created_at)' => $value]]]),
				]);
			}
			$data_query = [
				'select' => 'order_list.*, service.name AS service_name',
				'join' => [
					[
						'table' => 'service',
						'on' => 'service.id = order_list.service_id',
						'param' => 'LEFT'
					]
				],
				'where' => [['user_id' => user()]],
				'order_by' => 'order_list.id DESC',
				'limit' => '10',
			];
			$data_service_logs = [
				'select' => 'service_logs.*',
				'order_by' => 'service_logs.id DESC',
				'limit' => '10',
			];
			$service_recommended = [
				'select' => 'service_recommended.*, service.name AS service_name',
				'join' => [
					[
						'table' => 'service',
						'on' => 'service.id = service_recommended.service_id',
						'param' => 'inner'
					],
				],
				'order_by' => 'id ASC',
			];
			$service_top = $this->service_model->get_rows([
				'select' => 'service.id, service.name, SUM(order_list.price) AS rupiah, COUNT(order_list.price) AS total',
				'join' => [['table' => 'order_list', 'on' => 'order_list.service_id = service.id', 'param' => 'right outer']],
				'where' => [['service.status' => '1', 'MONTH(order_list.created_at)' => date('m'), 'YEAR(order_list.created_at)' => date('Y')]],
				'order_by' => 'total DESC, rupiah DESC',
				'group_by' => 'service.id',
				'limit' => '10',
			]);

			if (user('benefit') == 'Silver') {
				$next = 'Gold';
			} elseif (user('benefit') == 'Gold') {
				$next = 'Platinum';
			} elseif (user('benefit') == 'Platinum') {
				$next = 'Diamond';
			} elseif (user('benefit') == 'Diamond') {
				$next = 'null';
			}

			$this->render('public/auth/index', ['page_type' => 'Halaman Utama', 'next_level' => $next, 'service_recommended' => $this->service_recommended_model->get_rows($service_recommended), 'service_top' => $service_top, 'info' => $this->info_model->get_rows(['order_by' => 'id DESC', 'limit' => '5']), 'info_popup' => $this->info_model->get_rows(['where' => [['is_popup' => 1]], 'order_by' => 'id DESC']), 'last_order' => $this->order_model->get_rows($data_query), 'service_logs' => $this->service_logs_model->get_rows($data_service_logs), 'chart' => $chart, 'widget_order' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total', 'where' => [['user_id' => user()]]]), 'widget_deposit' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => [['user_id' => user(), 'status' => 'Success']]])]);
		} else {
			$this->load->view('public/landing.php');
		}
	}

	public function home()
	{
		$this->render('public/page/dashboard', ['page_type' => 'Halaman Utama']);
	}
	public function login()
	{
		// filter input = 1
		if ($this->session->userdata('login')) {
			exit(redirect(base_url()));
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$recaptcha = $this->input->post('g-recaptcha-response');
			$response = $this->recaptcha->verifyResponse($recaptcha);

			if ($this->form_validation->run() == true) {
				$data_input = [
					'username' => $this->db->escape_str($this->input->post('username')),
					'password' => $this->db->escape_str($this->input->post('password'))
				];

				$user = $this->user_model->get_row(['username' => $data_input['username']]);

				if (website_config('gr_status') == 'on' && (!isset($response['success']) || $response['success'] !== true)) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Harap mengisi captcha dengan benar.'));
				} elseif ($user == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username atau Password salah.'));
				} elseif (password_verify($data_input['password'], $user->password) == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username atau Password salah.'));
				} elseif ($user->is_verif == '0') {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Akun belum diverifikasi.'));
				} elseif ($user->status == '0') {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Akun dinonaktifkan.'));
				} else {
					// Ambil informasi browser
					$user_agent = $this->input->user_agent();
					$browser_name = $this->agent->browser();
					$browser_version = $this->agent->version();
					$platform = $this->agent->platform();
					$device = isset($_SERVER['HTTP_USER_AGENT']) ? $this->input->devices() : 'unknown';

					$data_cookie = [
						'user_id' => $user->id,
						'cookie' => random_string('alnum', 100),
						'ip_address' => $this->input->ip_address(),
						'login' => 'user',
						'ua' => $user_agent,
						'browser' => $browser_name,
						'browser_version' => $browser_version,
						'platform' => $platform,
						'ud' => $device,
						'created_at' => date('Y-m-d H:i:s'),
						'expired_at' => date('Y-m-d H:i:s', strtotime(($this->input->post('remember') == '1') ? '+30 days' : '+2 hours')),
					];

					$this->cookie_model->insert($data_cookie);

					if ($this->input->post('remember') == '1') {
						// Ubah periode kadaluarsa sesuai dengan yang ada di database
						$cookie_expiry = strtotime($data_cookie['expired_at']) - time();
						set_cookie('smm_login', $data_cookie['cookie'], $cookie_expiry);
					} else {
						set_cookie('smm_login', $data_cookie['cookie'], 7200); // 2 jam
					}


					$data_log_login = $this->log_login_user_model->insert([
						'user_id' => $user->id,
						'ip_address' => $this->input->ip_address(),
						'ua' => $user_agent,
						'ud' => $device,
						'browser' => $browser_name,
						'browser_version' => $browser_version,
						'platform' => $platform,
						'created_at' => date('Y-m-d H:i:s'),
					]);

					// mengambil data setelah insert log login user
					$data_login = $this->log_login_user_model->get_by_id($data_log_login);
					$this->session->set_userdata('login', $user->id);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil Masuk', 'msg' => 'Halo ' . $user->full_name . ',  Selamat datang.'));
					$phone = $this->lib->hp($user->whatsapp);
					$tgl = $this->lib->format_date(date('Y-m-d H:i:s'));
					$message = website_config('wa_otp_login');
					$ua_device = $data_login->ud;
					$ua_browser = $data_login->browser . ' ' . $data_login->browser_version . ' (' . $data_login->platform . ')';
					$ip_address = $data_login->ip_address;
					$user_email = $user->email;
					$user_whatsapp = $user->whatsapp;
					$pesan = preg_replace(
						array(
							'/{{url}}/',
							'/{{title}}/',
							'/{{user_fullname}}/',
							'/{{user_username}}/',
							'/{{login_time}}/',
							'/{{ua_device}}/',
							'/{{ua_browser}}/',
							'/{{ip_address}}/',
							'/{{user_email}}/',
							'/{{user_whatsapp}}/'
						),
						array(
							base_url(),
							website_config('title'),
							user('full_name'),
							user('username'),
							$tgl,
							$ua_device,
							$ua_browser,
							$ip_address,
							$user_email,
							$phone
						),
						$message
					);
					
					if (website_config('send_wa_otp') == 'on') {
    $apikey = website_config('wa_gateway_key'); // Sesuaikan 'wa_gateway_key' dengan nama config di database Anda
    $this->lib->sendMessage($apikey, $phone, $pesan);
					}
					exit(redirect(base_url('auth/index')));
				}

				exit(redirect(base_url('auth/login')));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}

		$this->render_login('public/auth/login', ['page_type' => 'Masuk', 'captcha' => $this->recaptcha->getWidget(), 'script_captcha' => $this->recaptcha->getScriptTag()]);
	}
	public function login_instagram()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == true) {
				$data_input = [
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
				];
				$unixTimestamp = time();
				$mysqlTimestamp = date("Y-m-d H:i:s", $unixTimestamp);
				$unixTimestamp = strtotime($mysqlTimestamp);
				$password = "#PWD_INSTAGRAM_BROWSER:0:" . $unixTimestamp . ":" . $data_input['password'] . "";

				$cookie = $this->lib->curlig("https://www.instagram.com/accounts/web_create_ajax/attempt/", null, null);
				$csrf = $cookie[2]["csrftoken"];
				$mid = $cookie[2]["mid"];
				$igdid = $cookie[2]["ig_did"];



				$headers = [
					"Host: www.instagram.com",
					"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36",
					"Accept: */*",
					"Accept-Language: id,en-US;q=0.7,en;q=0.3",
					"X-CSRFToken: " . $csrf . "",
					"Content-Type: application/x-www-form-urlencoded",
					"X-Requested-With: XMLHttpRequest",
					"Origin: https://www.instagram.com",
					"Connection: close",
					"Referer: https://www.instagram.com/",
					"Cookie: Cookie: ig_did=" . $igdid . "; mid=" . $mid . "; csrftoken=" . $csrf . "",
				];

				$data = "username=" . $data_input['username'] . "&enc_password=" . $password . "&queryParams=%7B%7D&optIntoOneTap=true";
				$login = $this->lib->curlig("https://www.instagram.com/accounts/login/ajax/", $data, $headers);
				if ($login[2]['ds_user_id'] == false) {
					$this->lib->print_data($login);
				} else {
					$ds_user_id = $login[2]["ds_user_id"];
					$sessionid = $login[2]["sessionid"];
				}
				if (strpos($login[1], "userId")) {
					$data_account = [
						'username' => $data_input['username'],
						'password' => $data_input['password'],
						'user_id' => $ds_user_id,
						'session_id' => $sessionid,
						'created_at' => date('Y-m-d H:i:s')
					];
					$this->database_model->insert($data_account);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Akun ' . $data_input['username'] . ' berhasil login.'));
				} elseif (strpos($login[1], "checkpoint_required.")) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Ups!', 'msg' => 'Harap tunggu beberapa menit sebelum mencoba lagi.'));
				} else {
					$this->lib->print_data($login);
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render_auth('public/auth/login_instagram', ['captcha' => $this->recaptcha->getWidget(), 'script_captcha' => $this->recaptcha->getScriptTag()]);
	}


	public function register()
	{
		if (website_config('page_register') != 1) {
			$this->session->set_flashdata('swalalert', array('alert' => 'danger', 'title' => 'Ups!', 'msg' => 'Pendaftaran dinonaktifkan oleh Administrator.'));
			exit(redirect(base_url()));
		}

		// Periksa apakah kode referral disediakan dalam URL
		if ($this->input->get('referral')) {
			$referral_code = $this->db->escape_str($this->input->get('referral'));
			$check_visitor = $this->user_model->get_row(['referral_code' => $referral_code]);

			if (!$check_visitor) {
				$this->session->set_flashdata('result', [
					'alert' => 'danger',
					'title' => 'Gagal!',
					'msg' => 'Kode referral tidak valid.'
				]);

				exit(redirect(base_url('auth/register')));
			}

			// Perbarui jumlah tampilan referral
			$this->user_model->update(['referral_view' => $check_visitor->referral_view + 1], ['referral_code' => $referral_code]);

			// Simpan kode referral dalam sesi dengan kedaluwarsa 30 menit
			$this->session->set_userdata('referral_code', $referral_code);
			$this->session->mark_as_temp('referral_code', 1800); // 30 menit
		}

		if ($this->session->userdata('login')) {
			exit(redirect(base_url()));
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('whatsapp', 'No HP / Whatsapp', 'required|integer|min_length[11]');
			$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|alpha_numeric_spaces|min_length[3]|max_length[25]');
			$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
			$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
			$this->form_validation->set_rules('terms', 'Ketentuan Layanan', 'required');
			$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
			$recaptcha = $this->input->post('g-recaptcha-response');
			$response = $this->recaptcha->verifyResponse($recaptcha);
			if ($this->form_validation->run() == true) {
				$check_referral = $this->user_model->get_row(['referral_code' => $this->db->escape_str($this->input->post('referral_code'))]);
				$data_input = [
					'username' => strtolower($this->db->escape_str($this->input->post('username'))),
					'whatsapp' => $this->lib->hp($this->input->post('whatsapp')),
					'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
					'full_name' => $this->db->escape_str($this->input->post('full_name')),
					'email' => $this->db->escape_str($this->input->post('email')),
					'balance' => '0',
					'benefit' => 'Silver',
					'status' => '1',
					'api_key' => $this->lib->generate_api_key(),
					'verification_key' => random_string('alnum', 150),
					'is_verif' => '1',
					'layout' => website_config('color_theme'),
					'mode' => website_config('mode_theme'),
					'contrast' => website_config('contrast_theme'),
					'created_at' => date('Y-m-d H:i:s'),
					'referral_code' => time(),
					'gender' => $this->db->escape_str($this->input->post('gender')),
					'uplink' => ($check_visitor && isset($check_visitor->id)) ? $check_visitor->id : '1'
				];
				if (website_config('gr_status') == 'on' && (!isset($response['success']) || $response['success'] !== true)) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Harap mengisi captcha dengan benar.'));
				} elseif ($this->user_model->get_row(['username' => $data_input['username']]) == true) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username sudah terdaftar.'));
				} elseif ($this->user_model->get_row(['email' => $data_input['email']]) == true) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Email sudah terdaftar.'));
				} else {

					$insert_user = $this->user_model->insert($data_input);
					if ($insert_user) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Registrasi berhasil.', 'msg' => 'Silahkan login.'));
						// NOTIF WA //
						$nama = $data_input['full_name'];
						$username = $data_input['username'];
						$email = $data_input['email'];
						$tanggal = $this->lib->format_date($data_input['created_at']);
						$phone = $this->lib->hp($data_input['whatsapp']);
						$phone1 = website_config('wa_admin');
						$message = website_config('wa_otp_register');
						$message1 = website_config('wa_admin_otp_register');
						$pesan = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{login_time}}/',
								'/{{user_email}}/',
								'/{{user_whatsapp}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$nama,
								$username,
								$tanggal,
								$email,
								$phone
							),
							$message
						);
						$pesan1 = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{login_time}}/',
								'/{{user_email}}/',
								'/{{user_whatsapp}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$nama,
								$username,
								$tanggal,
								$email,
								$phone
							),
							$message1
						);

						if (website_config('send_wa_otp') == 'on') {
							$this->lib->sendMessage($apikey, $phone, $pesan);
							$this->lib->sendMessage($apikey, $phone1, $pesan1);
						}
						// END NOTIF WA //

						exit(redirect(base_url('auth/login')));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga 1.'));
					}
				}
				exit(redirect(base_url('auth/register')));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render_register('public/auth/register', ['page_type' => 'Daftar', 'captcha' => $this->recaptcha->getWidget(), 'script_captcha' => $this->recaptcha->getScriptTag()]);
	}
	public function verification($code = false)
	{
		if ($code === false) {
			show_404();
		} else {
			$data_user = $this->user_model->get_row(['verification_key' => $this->db->escape_str($code)]);
			if ($data_user == false) {
				show_404();
			} else {
				$update = $this->user_model->update(['status' => '1', 'is_verif' => '1'], ['id' => $data_user->id]);
				if ($update) {
					$data['status'] = true;
				} else {
					$data['status'] = false;
				}
				$this->render_auth('public/auth/verif', ['status' => true, 'captcha' => $this->recaptcha->getWidget(), 'script_captcha' => $this->recaptcha->getScriptTag()]);
			}
		}
	}
	public function forgot()
	{
		if ($this->session->userdata('login')) {
			exit(redirect(base_url()));
		}
		if (website_config('page_forgot') != 1) {
			$this->session->set_flashdata('swalalert', array('alert' => 'danger', 'title' => 'Ups!', 'msg' => 'Lupa Password dinonaktifkan oleh Administrator.'));
			exit(redirect(base_url()));
		}

		if ($this->input->post()) {
			$recaptcha = $this->input->post('g-recaptcha-response');
			$response = $this->recaptcha->verifyResponse($recaptcha);
			$selectedMethod = $this->input->post('recovery_method');

			$this->form_validation->set_rules('email_or_whatsapp', 'Email/WhatsApp', 'required');
			$this->form_validation->set_rules('recovery_method', 'Metode Pemulihan', 'required');

			if ($this->form_validation->run() == true) {
				$emailOrWhatsApp = $this->db->escape_str($this->input->post('email_or_whatsapp'));
				$user = null;
				$token = random_string('alnum', 150); // Definisikan token di sini

				if ($selectedMethod == 'email') {
					$user = $this->user_model->get_row(['email' => $emailOrWhatsApp]);
				} elseif ($selectedMethod == 'whatsapp') {
					$user = $this->user_model->get_row(['whatsapp' => $this->lib->hp($emailOrWhatsApp)]);
				}

				if (!$user) {
					if ($selectedMethod == 'email') {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Email tidak ditemukan.'));
					} elseif ($selectedMethod == 'whatsapp') {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'WhatsApp tidak ditemukan.'));
					}
					exit(redirect(base_url('auth/forgot')));
				}

				if (website_config('gr_status') == 'on' && (!isset($response['success']) || $response['success'] !== true)) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Harap mengisi captcha dengan benar.'));
				} else {
					// Berdasarkan pilihan metode yang dipilih, kirim email atau pesan WhatsApp
					if ($selectedMethod == 'email') {
						// Sisipkan logika pengiriman email reset password di sini
						$data_view['full_name'] = $user->full_name;
						$data_view['username'] = $user->username;
						$data_view['email'] = $user->email;
						$data_view['subject'] = 'Reset Password - ' . website_config('title');
						$data_view['view'] = 'email/forgot';
						$data_view['token'] = $token; // Gunakan token yang sudah didefinisikan
						$this->sendMailForgot($data_view);
					} elseif ($selectedMethod == 'whatsapp') {
						// Sisipkan logika pengiriman pesan WhatsApp di sini
						$phone = $user->whatsapp;
						$tanggal = $this->lib->format_date(date('Y-m-d H:i:s'));
						$otp = base_url('auth/reset-password/' . $token);
						$message = website_config('wa_otp_reset');
						$pesan = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{user_email}}/',
								'/{{user_whatsapp}}/',
								'/{{login_time}}/',
								'/{{otp}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$user->fullname,
								$user->username,
								$user->email,
								$user->whatsapp,
								$tanggal,
								$otp
							),
							$message
						);
						if (website_config('send_wa_otp') == 'on') {
							$this->lib->sendMessage($apikey, $phone, $pesan);
						}
					}

					$data_input = [
						'username' => $user->username,
						'token' => $token,
						'updated_at' => date('Y-m-d H:i:s')
					];

					$update = $this->user_model->update($data_input, ['id' => $user->id]);
					if ($update) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Sistem telah mengirimkan pesan pemulihan sesuai metode yang dipilih.'));
						exit(redirect(base_url('auth/forgot')));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					}
				}
				exit(redirect(base_url('auth/forgot')));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}

		$this->render_forgot('public/auth/forgot', ['page_type' => 'Lupa Password', 'captcha' => $this->recaptcha->getWidget(), 'script_captcha' => $this->recaptcha->getScriptTag()]);
	}

	public function reset_password($token = null)
	{
		if ($this->session->userdata('login'))
			exit(redirect(base_url()));
		if (!$token)
			show_404();
		$token = $this->db->escape_str($token);
		$user = $this->user_model->get_row(['token' => $token]);
		if (!$user) {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Token Reset Password tidak ditemukan.'));
			exit(redirect(base_url('auth/login')));
		}
		if ($this->input->post()) {
			$this->form_validation->set_rules('password', 'Password Baru', 'required|min_length[5]');
			$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password Baru', 'required|matches[password]');
			$recaptcha = $this->input->post('g-recaptcha-response');
			$response = $this->recaptcha->verifyResponse($recaptcha);
			if ($this->form_validation->run() == true) {
				$data_input = [
					'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				];
				$check_due = $this->lib->diff_date(date('Y-m-d H:i:s'), $user->updated_at);
				if (website_config('gr_status') == 'on' && (!isset($response['success']) || $response['success'] !== true)) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Harap mengisi captcha dengan benar.'));
				} elseif ($user == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Request permintaan reset password tidak ditemukan.'));
				} elseif ($check_due < 0) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Request reset password sudah melebihi 24 jam !! harap meminta request baru.'));
				} else {
					$data_input['token'] = NULL;
					$update = $this->user_model->update($data_input, ['id' => $user->id]);
					if ($update) {
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Reset password berhasil!', 'msg' => 'Reset password berhasil silahkan login.'));
						exit(redirect(base_url('auth/login')));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					}
				}
				exit(redirect(base_url('auth/reset-password/' . $token)));
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render_auth('public/auth/reset-password', ['user' => $user, 'captcha' => $this->recaptcha->getWidget(), 'script_captcha' => $this->recaptcha->getScriptTag()]);
	}
	public function logout()
	{
		if ($this->session->userdata('login') == false)
			exit(redirect(base_url('auth/login')));
		$this->cookie_model->delete(['cookie' => get_cookie('smm_login')]);
		delete_cookie('smm_login');
		$this->session->unset_userdata('login');
		$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil keluar!', 'msg' => 'Sampai jumpa.'));
		redirect(base_url('auth/login'));
	}

	public function sendMailRegister($data = [])
	{
		$mail = new PHPMailer(true);

		try {
			// Konfigurasi SMTP
			$mail->isSMTP();
			$mail->SMTPSecure = website_config('smtp_encrypt');
			$mail->Host = website_config('smtp_host'); // hostname masing-masing provider email
			$mail->SMTPDebug = 2; // Ubah menjadi 2 untuk menampilkan debug log
			$mail->Port = website_config('smtp_port');
			$mail->SMTPAuth = true;
			$mail->Username = website_config('smtp_username'); // user email
			$mail->Password = website_config('smtp_password'); // password email

			// Set email pengirim
			$mail->setFrom(website_config('smtp_username'), website_config('title'));

			// Set email penerima
			$mail->addAddress($data['email'], "");

			// Mengatur format HTML pada email
			$mail->isHTML(true);

			// Set subyek email
			$mail->Subject = $data['subject'];

			// Set isi email
			$mail->Body = $this->load->view($data['view'], $data, true);

			// Set pesan alternatif (jika email client tidak mendukung HTML)
			$mail->AltBody = website_config('title');

			// Kirim email
			if ($mail->Send()) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			// Tangkap kesalahan dan tampilkan pesan kesalahan
			log_message('error', $e->getMessage());
			return false;
		}
	}

	protected function sendMailForgot($data = [])
	{
		$mail = new PHPMailer(true);

		try {
			// Konfigurasi SMTP
			$mail->isSMTP();
			$mail->SMTPSecure = website_config('smtp_encrypt');
			$mail->Host = website_config('smtp_host'); // hostname masing-masing provider email
			$mail->SMTPDebug = 0;
			$mail->Port = website_config('smtp_port');
			$mail->SMTPAuth = true;
			$mail->Username = website_config('smtp_username'); // user email
			$mail->Password = website_config('smtp_password'); // password email

			// Set email pengirim
			$mail->setFrom(website_config('smtp_username'), website_config('title'));

			// Set email penerima
			$mail->addAddress($data['email'], "");

			// Mengatur format HTML pada email
			$mail->isHTML(true);

			// Set subyek email
			$mail->Subject = $data['subject'];

			// Set isi email
			$mail->Body = $this->load->view($data['view'], $data, true);

			// Set pesan alternatif (jika email client tidak mendukung HTML)
			$mail->AltBody = website_config('title');

			// Kirim email
			if ($mail->Send()) {
				return true;
			} else {
				// Tampilkan informasi kesalahan jika gagal mengirim email
				$this->lib->print_data($mail->ErrorInfo);
				return false;
			}
		} catch (Exception $e) {
			// Tangkap kesalahan dan tampilkan pesan kesalahan
			echo "Email gagal dikirim. Pesan kesalahan: {$e->getMessage()}";
			return false;
		}
	}

	public function detail_account($i = '')
	{
		$i = $this->db->escape_str($i);
		$data = $this->user_model->get_row(['id' => $i]);
		$total_referral = $this->user_model->get_count(['where' => [['uplink' => user()]]]);
		$this->load->view('public/auth/detail', [
			'target' => $data, 'total_referral' => $total_referral, 'total_order' => $this->order_model->get_rows([
				'select' => 'SUM(price) AS rupiah, COUNT(id) AS total',
				'where' => [
					['user_id' => user()],
					// Menambahkan kondisi untuk filter berdasarkan bulan sekarang
					['MONTH(created_at)' => date('n')],
					['YEAR(created_at)' => date('Y')],
				]
			]),
			'total_deposit' => $this->deposit_model->get_rows([
				'select' => 'SUM(amount) AS rupiah, COUNT(id) AS total',
				'where' => [
					['user_id' => user(), 'status' => 'Success'],
					// Menambahkan kondisi untuk filter berdasarkan bulan sekarang
					['MONTH(created_at)' => date('n')],
					['YEAR(created_at)' => date('Y')],
				]
			]),
		]);
	}
}
