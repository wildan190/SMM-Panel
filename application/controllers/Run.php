<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Run extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Gopay');
		$this->load->library('Ovo');
		$this->load->library('Bca');
	}

	public function proses_followers()
	{
		$database = $this->database_model->get_rows();
		foreach ($database as $key => $value) {

			$ds_user_id = $value['user_id'];
			$sessionid = $value['session_id'];
			$username = 'herusuandana';
			$cookie = $this->lib->curlig("https://www.instagram.com/accounts/web_create_ajax/attempt/", null, null);
			$csrf = $cookie[2]["csrftoken"];
			$mid = $cookie[2]["mid"];
			$igdid = $cookie[2]["ig_did"];

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0",
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
				"Accept-Language: id,en-US;q=0.7,en;q=0.3",
				// 'Accept-Encoding: gzip, deflate',
				"Connection: close",
				"Cookie: ig_did=" .
					$igdid .
					"; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; rur=FRC; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					'; urlgen="{\"125.166.41.46\": 7713}:1kKMPt:68Piy2PtMvleaRjEsHGCMaVyKhQ"',
				"Upgrade-Insecure-Requests: 1",
			];

			$profile = $this->lib->curlget(
				"https://www.instagram.com/" . $username . "/",
				null,
				$headers
			);
			$pageid = $this->lib->get_between($profile[1], "profilePage_", '"');

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0",
				"Accept: */*",
				"Accept-Language: id,en-US;q=0.7,en;q=0.3",
				"X-CSRFToken: " . $csrf . "",
				"Content-Type: application/x-www-form-urlencoded",
				"X-Requested-With: XMLHttpRequest",
				"Origin: https://www.instagram.com",
				"Connection: close",
				"Referer: https://www.instagram.com/" . $username . "/",
				"Cookie: ig_did=" .
					$igdid .
					"; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; rur=FRC; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					';',
			];

			$headers = [
				'Cookie: ig_did=' . $igdid . '; ig_nrcb=1; mid=' . $mid . '; csrftoken=' . $csrf . '; ds_user_id=' . $ds_user_id . '; sessionid=' . $sessionid . '',
				'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:98.0) Gecko/20100101 Firefox/98.0',
				'Accept: */*',
				'Accept-Language: id,en-US;q=0.7,en;q=0.3',
				'X-Csrftoken: ' . $csrf . '',
				'Content-Type: application/x-www-form-urlencoded',
				'X-Requested-With: XMLHttpRequest',
				'Origin: https://www.instagram.com',
				'Referer: https://www.instagram.com/herusuandana/',
				'Sec-Fetch-Dest: empty',
				'Sec-Fetch-Mode: cors',
				'Sec-Fetch-Site: same-origin',
				'Te: trailers',
			];

			$follow = $this->lib->curlig(
				"https://www.instagram.com/web/friendships/" . $pageid . "/follow/",
				null,
				$headers
			);
			$getData = $this->lib->curlget('https://www.instagram.com/accounts/onetap/?next=%2F', null, $headers);
			$unameMu = $this->lib->get_between($getData[1], '"username\":\"', '\",\"badge_count');
			if ($unameMu) {
				if (strpos($follow[0], "302")) {
					echo "[+] " . date('Y-m-d H:i:s') . " SUKSES | USERNAME: $unameMu Berhasil Follow $username<br />";
				} else {
					echo "[+] Gagal Follow USERNAME: $unameMu\n";
				}
			} else {
				$this->lib->print_data($follow);
			}
		}
	}

	public function proses_likes()
	{
		$database = $this->database_model->get_rows();
		foreach ($database as $key => $value) {

			$ds_user_id = $value['user_id'];
			$sessionid = $value['session_id'];
			$url = 'https://www.instagram.com/p/CxcsmNcPfBN/';

			$cookie = $this->lib->curlig("https://www.instagram.com/accounts/web_create_ajax/attempt/", null, null);
			$csrf = $cookie[2]["csrftoken"];
			$mid = $cookie[2]["mid"];
			$igdid = $cookie[2]["ig_did"];
			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0",
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Connection: close",
				"Cookie: ig_did=" .
					$igdid .
					"; ig_nrcb=1; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; rur=PRN; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					"",
				"Upgrade-Insecure-Requests: 1",
				"Cache-Control: max-age=0",
			];

			$getCookie = $this->lib->curlget($url, null, $headers);
			$mediaid = $this->lib->get_between($getCookie[1], "media?id=", '"');

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0",
				"Accept: */*",
				"Accept-Language: id,en-US;q=0.7,en;q=0.3",
				"X-CSRFToken: " . $csrf . "",
				"Content-Type: application/x-www-form-urlencoded",
				"X-Requested-With: XMLHttpRequest",
				"Origin: https://www.instagram.com",
				"Connection: close",
				"Referer: " . $url . "",
				"Cookie: ig_did=" .
					$igdid .
					"; ig_nrcb=1; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					'; rur=VLL; urlgen="{\"36.70.59.241\": 7713}:1kQVAl:WUMo75HZ8TwyvMFJdhXGqOZcRUA"',
			];
			$like = $this->lib->curlig(
				"https://www.instagram.com/api/v1/web/likes/" . $mediaid . "/like/",
				null,
				$headers
			);

			$getData = $this->lib->curlget('https://www.instagram.com/accounts/onetap/?next=%2F', null, $headers);
			$unameMu = $this->lib->get_between($getData[1], '"username\":\"', '\",\"badge_count');
			if ($unameMu) {
				if (strpos($like[1], '"ok"}')) {
					print('USERNAME: ' . $unameMu . ' - SUCCESS - LIKED POST -> ' . $url . ' ');
				} else {
					print('USERNAME: ' . $unameMu . ' - FAILURE - ERROR SYSTEM');
				}
			} else {
				print('USERNAME: ' . $unameMu . ' - FAILURE - COOKIE DEAD');
			}
		}
	}
	public function proses_comments()
	{
		$database = $this->database_model->get_rows();
		foreach ($database as $key => $value) {

			$ds_user_id = $value['user_id'];
			$sessionid = $value['session_id'];
			$url = 'https://www.instagram.com/p/CxcsmNcPfBN/';

			$cookie = $this->lib->curlig("https://www.instagram.com/accounts/web_create_ajax/attempt/", null, null);
			$csrf = $cookie[2]["csrftoken"];
			$mid = $cookie[2]["mid"];
			$igdid = $cookie[2]["ig_did"];

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0",
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Connection: close",
				"Cookie: ig_did=" .
					$igdid .
					"; ig_nrcb=1; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; rur=PRN; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					"",
				"Upgrade-Insecure-Requests: 1",
				"Cache-Control: max-age=0",
			];

			$textComment = 'Follback bg';

			$getCookie = $this->lib->curlget($url, null, $headers);
			$mediaid = $this->lib->get_between($getCookie[1], "media?id=", '"');

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0",
				"Accept: */*",
				"Accept-Language: id,en-US;q=0.7,en;q=0.3",
				"X-CSRFToken: " . $csrf . "",
				"Content-Type: application/x-www-form-urlencoded",
				"X-Requested-With: XMLHttpRequest",
				"Origin: https://www.instagram.com",
				"Connection: close",
				"Referer: " . $url . "",
				"Cookie: ig_did=" .
					$igdid .
					"; ig_nrcb=1; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					'; rur=VLL; urlgen="{\"36.70.59.241\": 7713}:1kQVAl:WUMo75HZ8TwyvMFJdhXGqOZcRUA"',
			];
			$data = "comment_text=" . $textComment . "&replied_to_comment_id=";
			$commentPost = $this->lib->curlig(
				"https://www.instagram.com/web/comments/$mediaid/add/",
				$data,
				$headers
			);

			if (strpos($commentPost[1], 'id":"')) {
				print('USERID: ' . $ds_user_id . ' - SUCCESS - COMMENTED POST -> ' . $url . ' - COMMENT TEXT -> ' . $textComment . '<br />');
			} else {
				print('USERID: ' . $ds_user_id . ' - FAILURE - COOKIE DEAD<br />');
			}
		}
	}
	public function proses_reply()
	{
		$database = $this->database_model->get_rows();
		foreach ($database as $key => $value) {

			$ds_user_id = $value['user_id'];
			$sessionid = $value['session_id'];
			$url = 'https://www.instagram.com/p/Cf58yAJrXVA/';

			$cookie = $this->lib->curlig("https://www.instagram.com/accounts/web_create_ajax/attempt/", null, null);
			$csrf = $cookie[2]["csrftoken"];
			$mid = $cookie[2]["mid"];
			$igdid = $cookie[2]["ig_did"];

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0",
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Connection: close",
				"Cookie: ig_did=" .
					$igdid .
					"; ig_nrcb=1; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; rur=PRN; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					"",
				"Upgrade-Insecure-Requests: 1",
				"Cache-Control: max-age=0",
			];

			$textComment = 'Nice';

			$getCookie = $this->lib->curlget($url, null, $headers);
			$mediaid = $this->lib->get_between($getCookie[1], "media?id=", '"');

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0",
				"Accept: */*",
				"Accept-Language: id,en-US;q=0.7,en;q=0.3",
				"X-CSRFToken: " . $csrf . "",
				"Content-Type: application/x-www-form-urlencoded",
				"X-Requested-With: XMLHttpRequest",
				"Origin: https://www.instagram.com",
				"Connection: close",
				"Referer: " . $url . "",
				"Cookie: ig_did=" .
					$igdid .
					"; ig_nrcb=1; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					'; rur=VLL; urlgen="{\"36.70.59.241\": 7713}:1kQVAl:WUMo75HZ8TwyvMFJdhXGqOZcRUA"',
			];
			$data = "comment_text=" . $textComment . "&replied_to_comment_id=17966885114016223";
			$commentPost = $this->lib->curlig(
				"https://www.instagram.com/web/comments/$mediaid/add/",
				$data,
				$headers
			);

			if (strpos($commentPost[1], 'id":"')) {
				print('USERID: ' . $ds_user_id . ' - SUCCESS - COMMENTED POST -> ' . $url . ' - COMMENT TEXT -> ' . $textComment . '<br />');
			} else {
				print('USERID: ' . $ds_user_id . ' - FAILURE - COOKIE DEAD<br />');
			}
		}
	}
	public function proses_like_comments()
	{
		$database = $this->database_model->get_rows();
		foreach ($database as $key => $value) {

			$ds_user_id = $value['user_id'];
			$sessionid = $value['session_id'];
			$url = 'https://www.instagram.com/p/Cf58yAJrXVA/';

			$cookie = $this->lib->curlig("https://www.instagram.com/accounts/web_create_ajax/attempt/", null, null);
			$csrf = $cookie[2]["csrftoken"];
			$mid = $cookie[2]["mid"];
			$igdid = $cookie[2]["ig_did"];

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0",
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Connection: close",
				"Cookie: ig_did=" .
					$igdid .
					"; ig_nrcb=1; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; rur=PRN; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					"",
				"Upgrade-Insecure-Requests: 1",
				"Cache-Control: max-age=0",
			];

			$textComment = 'Nice';

			$getCookie = $this->lib->curlget($url, null, $headers);
			$mediaid = $this->lib->get_between($getCookie[1], "media?id=", '"');
			$this->lib->print_data($mediaid);

			$headers = [
				"Host: www.instagram.com",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0",
				"Accept: */*",
				"Accept-Language: id,en-US;q=0.7,en;q=0.3",
				"X-CSRFToken: " . $csrf . "",
				"Content-Type: application/x-www-form-urlencoded",
				"X-Requested-With: XMLHttpRequest",
				"Origin: https://www.instagram.com",
				"Connection: close",
				"Referer: " . $url . "",
				"Cookie: ig_did=" .
					$igdid .
					"; ig_nrcb=1; csrftoken=" .
					$csrf .
					"; mid=" .
					$mid .
					"; ds_user_id=" .
					$ds_user_id .
					"; sessionid=" .
					$sessionid .
					'; rur=VLL; urlgen="{\"36.70.59.241\": 7713}:1kQVAl:WUMo75HZ8TwyvMFJdhXGqOZcRUA"',
			];
			$commentPost = $this->lib->curlig(
				"https://www.instagram.com/web/comments/like/$mediaid/",
				null,
				$headers
			);

			if (strpos($commentPost[1], 'id":"')) {
				print('USERID: ' . $ds_user_id . ' - SUCCESS - COMMENTED POST -> ' . $url . ' - COMMENT TEXT -> ' . $textComment . '<br />');
			} else {
				$this->lib->print_data($commentPost);
				print('USERID: ' . $ds_user_id . ' - FAILURE - COOKIE DEAD<br />');
			}
		}
	}
	public function updatecategory()
	{
		$check_category = $this->service_category_model->get_rows(['where' => [['type' => 'SM']]]);
		foreach ($check_category as $key => $value) {
			$category = $value['name'];
			$type = null;
			if ($this->lib->pregmatch('Instagram', $category)) {
				$type = 'Instagram';
			} elseif ($this->lib->pregmatch('Facebook', $category)) {
				$type = 'Facebook';
			} elseif ($this->lib->pregmatch('Twitter', $category)) {
				$type = 'Twitter';
			} elseif ($this->lib->pregmatch('Youtube', $category)) {
				$type = 'Youtube';
			} elseif ($this->lib->pregmatch('Spotify', $category)) {
				$type = 'Spotify';
			} elseif ($this->lib->pregmatch('Telegram', $category)) {
				$type = 'Telegram';
			} elseif ($this->lib->pregmatch('Website', $category)) {
				$type = 'Website';
			} elseif ($this->lib->pregmatch('Website Traffic', $category)) {
				$type = 'Website';
			} elseif ($this->lib->pregmatch('Tiktok', $category)) {
				$type = 'Tiktok';
			} elseif ($this->lib->pregmatch('Tik Tok', $category)) {
				$type = 'Tiktok';
			} elseif ($this->lib->pregmatch('Reviews', $category)) {
				$type = 'Reviews';
			} elseif ($this->lib->pregmatch('Linkedin', $category)) {
				$type = 'Linkedin';
			} elseif ($this->lib->pregmatch('Snapchat', $category)) {
				$type = 'Snapchat';
			} elseif ($this->lib->pregmatch('SoundCloud', $category)) {
				$type = 'SoundCloud';
			} elseif ($this->lib->pregmatch('Twitter', $category)) {
				$type = 'Twitter';
			} elseif ($this->lib->pregmatch('Google', $category)) {
				$type = 'Google';
			} elseif ($this->lib->pregmatch('Twitch', $category)) {
				$type = 'Twitch';
			} elseif ($this->lib->pregmatch('Threads', $category)) {
				$type = 'Threads';
			} elseif ($this->lib->pregmatch('Promo', $category)) {
				$type = 'Promo';
			} else {
				$type = 'Other';
			}

			$update = $this->service_category_model->update(['type_category' => $type], ['id' => $value['id']]);
			if ($update == true) {
				print('BERHASIL UPDATE CATEGORY ' . $value['name'] . '<br />');
			} else {
				print('GAGAL! <br />');
			}
		}
	}

	public function mutasi()
	{
		//exit();
		$curl = $this->lib->curl(base_url('auto/bca.php'));
		$result = json_decode($curl, true);
		//print_r($result);
		if (!isset($result))
			die('FAILED');
		foreach ($result as $key => $value) {
			$timestamp = time();
			$created_at = date('Y-m-d H:i:s', $timestamp);
			if ($value['jenis'] == 'DB')
				continue;
			$md5 = md5(trim($value['keterangan'] . $value['mutasi']));
			if ($this->log_deposit_bank_model->get_count('*', array('log_code' => $md5)) == 0) {
				$this->log_deposit_bank_model->insert(
					array(
						'log_code' => $md5,
						'deposit_method_id' => '1',
						'bank' => 'BCA',
						'amount' => $value['mutasi'],
						'note' => $value['keterangan'],
						'created_at' => $created_at
					)
				);
				print_r($value);
			}
			print('<br />');
		}
	}

	public function callback()
	{
		$cekmutasi = [
			'api_signature' => 'XsaztyL0J8uB6gkAEoXVrQwaQbTssy4C',
		];

		$incomingApiSignature = isset($_SERVER['HTTP_API_SIGNATURE']) ? $_SERVER['HTTP_API_SIGNATURE'] : '';

		// validasi API Signature
		if (!hash_equals($cekmutasi['api_signature'], $incomingApiSignature)) {
			exit('Invalid Signature');
		}

		$post = file_get_contents('php://input');
		$json = json_decode($post);

		if (json_last_error() !== JSON_ERROR_NONE) {
			exit('Invalid JSON');
		}

		if ($json->action === 'payment_report') {
			foreach ($json->content->data as $data) {
				// Waktu transaksi dalam format unix timestamp
				$time = $data->unix_timestamp;

				// Tipe transaksi : credit / debit
				$type = $data->type;

				// Jumlah (2 desimal) : 50000.00
				$amount = round($data->amount);

				// Berita transfer
				$description = $data->description;

				// Saldo rekening (2 desimal) : 1500000.00
				$balance = $data->balance;

				if ($type === 'credit') { // dana masuk
					$check_deposit = $this->invoice_model->get_row(['amount' => $amount]);
					if ($check_deposit->status == 'Unpaid') {
						if ($check_deposit == true) {
							$this->db->trans_start();
							$this->invoice_model->update([
								'status' => 'Paid',
								'updated_at' => date('Y-m-d H:i:s'),
							], ['id' => $check_deposit->id]);
							$this->db->trans_complete();
							if ($this->db->trans_status() == true) {
								print('ID INVOICE: ' . $check_deposit->id . ' -> AMOUNT INVOICE: ' . $amount . ' INVOICE SUCCESS <br />');
								echo json_encode(['success' => true]);
							} else {
								print('error insert');
							}
						} else {
							print('ID INVOICE: TIDAK DITEMUKAN <br />');
							echo json_encode(['success' => false]);
						}
					} else {
						print('status invoice sudah ' . $check_deposit->status . '');
					}
				}
			}
		} else {
			die('no action was taken');
		}
	}

	public function tripay()
	{
		$json = file_get_contents("php://input");

		$callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';
		$signature = hash_hmac('sha256', $json, website_config('tripay_private_key'));

		if ($callbackSignature !== $signature) {
			exit("Invalid Signature");
		}
		$event = $_SERVER['HTTP_X_CALLBACK_EVENT'];

		$data = json_decode($json);
		if ($event == 'payment_status') {

			$merchantRef = $data->merchant_ref;
			$ref = $data->reference;
			$amount = $data->total_amount;

			if ($data->status == 'PAID') {
				$deposit = $this->deposit_model->get_row(['reference' => $ref]);
				$deposit_method = $this->deposit_method_model->get_row(['id' => $deposit->deposit_method_id]);
				if ($deposit == true) {
					$saldo_awal = $this->user_model->get_by_id($deposit->user_id);
					if ($deposit->status == 'Pending') {
						$this->deposit_model->update([
							'status' => 'Success',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['reference' => $deposit->reference]);
						$user = $this->user_model->get_by_id($deposit->user_id);
						if ($user == false)
							die;
						$this->user_model->update([
							'balance' => $user->balance + $deposit->balance,
						], ['id' => $user->id]);
						$this->log_balance_usage_model->insert([
							'user_id' => $user->id,
							'type' => 'plus',
							'category' => 'deposit',
							'amount' => $deposit->balance,
							'description' => 'Deposit #' . $deposit->id . '.',
							'before' => $saldo_awal->balance,
							'after' => $saldo_awal->balance + $deposit->balance,
							'created_at' => date('Y-m-d H:i:s')
						]);
						echo json_encode(['success' => true]);

						$user = $this->user_model->get_by_id($deposit->user_id);
						$phone = $this->lib->hp($user->whatsapp);
						$phone1 = website_config('wa_admin');
						$message = website_config('wa_deposit_success');
						$message1 = website_config('wa_admin_deposit_success');
						$pesan = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$user->full_name,
								$user->username,
								$deposit->id,
								$deposit_method->name,
								currency($deposit->amount),
								currency($deposit->balance),
								'Success',
								$this->lib->format_date($deposit->created_at),
								$this->lib->format_date(date('Y-m-d H:i:s'))
							),
							$message
						);
						$pesan1 = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$user->full_name,
								$user->username,
								$deposit->id,
								$deposit_method->name,
								currency($deposit->amount),
								currency($deposit->balance),
								'Success',
								$this->lib->format_date($deposit->created_at),
								$this->lib->format_date(date('Y-m-d H:i:s'))
							),
							$message1
						);
						$this->lib->sendMessage('', $phone, $pesan);
						$this->lib->sendMessage('', $phone1, $pesan1);
					} else {
						print('ID DEPOSIT BERSTATUS ' . $deposit->status . ' <br />');
						echo json_encode(['success' => false]);
					}
				} else {
					print('REFERENCE TIDAK DITEMUKAN');
				}
			} elseif ($data->status == 'EXPIRED') {
				$deposit = $this->deposit_model->get_row(['reference' => $ref]);
				if ($deposit == true) {
					if ($deposit->status == 'Pending') {
						$this->deposit_model->update([
							'status' => 'Canceled',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['reference' => $deposit->reference]);
						echo json_encode(['success' => true]);


						$deposit_method = $this->deposit_method_model->get_row(['id' => $deposit->deposit_method_id]);
						$user = $this->user_model->get_by_id($deposit->user_id);
						$phone = $this->lib->hp($user->whatsapp);
						$phone1 = website_config('wa_admin');
						$message = website_config('wa_deposit_canceled');
						$message1 = website_config('wa_admin_deposit_canceled');
						$pesan = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$user->full_name,
								$user->username,
								$deposit->id,
								$deposit_method->name,
								currency($deposit->amount),
								currency($deposit->balance),
								'Canceled',
								$this->lib->format_date($deposit->created_at),
								$this->lib->format_date(date('Y-m-d H:i:s'))
							),
							$message
						);
						$pesan1 = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$user->full_name,
								$user->username,
								$deposit->id,
								$deposit_method->name,
								currency($deposit->amount),
								currency($deposit->balance),
								'Canceled',
								$this->lib->format_date($deposit->created_at),
								$this->lib->format_date(date('Y-m-d H:i:s'))
							),
							$message1
						);
						$this->lib->sendMessage($phone, $pesan);
						$this->lib->sendMessage($phone1, $pesan1);
					}
				}
			}
		} else {
			die("No action was taken");
		}
	}

	public function paydisini()
	{
		$apiKey = website_config('paydisini_api_key');
		$allowedIpAddress = $_SERVER['REMOTE_ADDR'];

		if ($_POST['key'] == $apiKey && $_SERVER['REMOTE_ADDR'] == $allowedIpAddress) {
			$ref = $_POST['unique_code']; // Mengambil reference dari callback
			$deposit = $this->deposit_model->get_row(['reference' => $ref]);
			$deposit_method = $this->deposit_method_model->get_row(['id' => $deposit->deposit_method_id]);

			if ($deposit !== false) {
				$saldo_awal = $this->user_model->get_by_id($deposit->user_id);
				if ($deposit->status == 'Pending') {
					$payment_id = $deposit->reference;
					$key = $_POST['key'];
					$unique_code = $_POST['unique_code'];
					$status = $_POST['status'];
					$signature = $_POST['signature'];
					$sign = md5($apiKey . $payment_id . 'CallbackStatus');

					if ($signature != $sign) {
						// jika sign tidak valid
						$result = json_encode(['success' => false]);
					} else if ($status == 'Success') {
						// Update status deposit menjadi Success
						$this->deposit_model->update([
							'status' => 'Success',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['reference' => $deposit->reference]);

						$user = $this->user_model->get_by_id($deposit->user_id);
						if ($user !== false) {
							$this->user_model->update([
								'balance' => $user->balance + $deposit->balance,
							], ['id' => $user->id]);

							$this->log_balance_usage_model->insert([
								'user_id' => $user->id,
								'type' => 'plus',
								'category' => 'deposit',
								'amount' => $deposit->balance,
								'description' => 'Deposit #' . $deposit->id . '.',
								'before' => $saldo_awal->balance,
								'after' => $saldo_awal->balance + $deposit->balance,
								'created_at' => date('Y-m-d H:i:s')
							]);

							$user = $this->user_model->get_by_id($deposit->user_id);
							$phone = $this->lib->hp($user->whatsapp);
							$phone1 = website_config('wa_admin');
							$message = website_config('wa_deposit_success');
							$message1 = website_config('wa_admin_deposit_success');
							$pesan = preg_replace(
								array(
									'/{{url}}/',
									'/{{title}}/',
									'/{{user_fullname}}/',
									'/{{user_username}}/',
									'/{{deposit_id}}/',
									'/{{deposit_method}}/',
									'/{{deposit_transfer}}/',
									'/{{deposit_amount}}/',
									'/{{deposit_status}}/',
									'/{{deposit_create}}/',
									'/{{deposit_update}}/'
								),
								array(
									base_url(),
									website_config('title'),
									$user->full_name,
									$user->username,
									$deposit->id,
									$deposit_method->name,
									currency($deposit->amount),
									currency($deposit->balance),
									'Success',
									$this->lib->format_date($deposit->created_at),
									$this->lib->format_date(date('Y-m-d H:i:s'))
								),
								$message
							);

							$pesan1 = preg_replace(
								array(
									'/{{url}}/',
									'/{{title}}/',
									'/{{user_fullname}}/',
									'/{{user_username}}/',
									'/{{deposit_id}}/',
									'/{{deposit_method}}/',
									'/{{deposit_transfer}}/',
									'/{{deposit_amount}}/',
									'/{{deposit_status}}/',
									'/{{deposit_create}}/',
									'/{{deposit_update}}/'
								),
								array(
									base_url(),
									website_config('title'),
									$user->full_name,
									$user->username,
									$deposit->id,
									$deposit_method->name,
									currency($deposit->amount),
									currency($deposit->balance),
									'Success',
									$this->lib->format_date($deposit->created_at),
									$this->lib->format_date(date('Y-m-d H:i:s'))
								),
								$message1
							);

							$apikey = website_config('wa_gateway_key');
							$this->lib->sendMessage($apikey, $phone, $pesan);
							$apikey = website_config('wa_gateway_key');
							$this->lib->sendMessage($apikey, $phone1, $pesan1);
							$result = json_encode(['success' => true]);
						}
					} else if ($status == 'Canceled') {
						// Update status deposit menjadi Canceled
						$this->deposit_model->update([
							'status' => 'Canceled',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['reference' => $deposit->reference]);

						$user = $this->user_model->get_by_id($deposit->user_id);
						$phone = $this->lib->hp($user->whatsapp);
						$phone1 = website_config('wa_admin');
						$message = website_config('wa_deposit_canceled');
						$message1 = website_config('wa_admin_deposit_canceled');
						$pesan = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$user->full_name,
								$user->username,
								$deposit->id,
								$deposit_method->name,
								currency($deposit->amount),
								currency($deposit->balance),
								'Canceled',
								$this->lib->format_date($deposit->created_at),
								$this->lib->format_date(date('Y-m-d H:i:s'))
							),
							$message
						);

						$pesan1 = preg_replace(
							array(
								'/{{url}}/',
								'/{{title}}/',
								'/{{user_fullname}}/',
								'/{{user_username}}/',
								'/{{deposit_id}}/',
								'/{{deposit_method}}/',
								'/{{deposit_transfer}}/',
								'/{{deposit_amount}}/',
								'/{{deposit_status}}/',
								'/{{deposit_create}}/',
								'/{{deposit_update}}/'
							),
							array(
								base_url(),
								website_config('title'),
								$user->full_name,
								$user->username,
								$deposit->id,
								$deposit_method->name,
								currency($deposit->amount),
								currency($deposit->balance),
								'Canceled',
								$this->lib->format_date($deposit->created_at),
								$this->lib->format_date(date('Y-m-d H:i:s'))
							),
							$message1
						);

						$apikey = website_config('wa_gateway_key');
							$this->lib->sendMessage($apikey, $phone, $pesan);
						$apikey = website_config('wa_gateway_key');
							$this->lib->sendMessage($apikey, $phone1, $pesan1);
						$result = json_encode(['success' => true]);
					} else {
						// jika status tidak Success & Canceled
						$result = json_encode(['success' => false]);
					}
				}
			} else {
				// jika $deposit false
				$result = json_encode(['success' => false]);
			}
		} else {
			die("No action was taken");
		}

		header('Content-type: application/json');
		echo $result;
	}

	public function refill()
	{
		$target = $this->refill_model->get_rows([
			'where' => [['status' => 'Success']],
		]);

		foreach ($target as $key => $value) {
			$data_input = [
				'user_id' => $value['user_id'],
				'order_id' => $value['order_id'],
				'api_id' => $value['api_id'],
				'service' => $value['service'],
				'target' => $value['target'],
				'status' => 'Pending',
				'api_refill_id' => 0,
				// reset
				'api_log_refill' => 0,
				// reset
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
			$data_order = $this->order_model->get_by_id($value['order_id']);
			$api = $this->api_model->get_by_id($value['api_id']);
			if ($api == false) {
				print('API False');
			}
			// END CHECK API //
			$provider_order_id = false;
			if ($api->is_manual == '1') {
				$provider_order_id = true;
			} else {
				// CHECK API ORDER //
				$api_refill = $this->api_refill_model->get_row(['api_id' => $value['api_id']]);
				if ($api_refill == false) {
					print('API Refill False');
				}
				// END CHECK API ORDER //
				$params = [];
				$data_api = $this->api_model->get_by_id($value['api_id']);
				$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $value['api_id'], 'api_type' => 'refill']);
				//$this->lib->print_data($api_request_param);
				if (!empty($api_request_param)) {
					foreach ($api_request_param->result_array() as $row) {
						if ($row['param_type'] === 'custom') {
							$params[$row['param_key']] = $row['param_value'];
						} else {
							if ($row['param_value'] == 'order_id') {
								$params[$row['param_key']] = $data_order->api_order_id;
							} else if ($row['param_value'] == 'api_id') {
								$params[$row['param_key']] = $data_api->api_id;
							} else if ($row['param_value'] == 'api_key') {
								$params[$row['param_key']] = $data_api->api_key;
							} else if ($row['param_value'] == 'secret_key') {
								$params[$row['param_key']] = $data_api->secret_key;
							}
						}
						//$this->lib->print_data($row);
					}
					//die;
					$client = new GuzzleHttp\Client();
					try {
						$param_key = 'form_params';

						$request = $client->request('POST', $api_refill->end_point, [
							$param_key => $params,
							'headers' => ['Accept' => 'application/json'],
						]);
						if ($request->getStatusCode() === 200) {
							$response = $request->getBody()->getContents();
							$json_result = json_decode($response, true);

							$status = search_key($json_result, $api_refill->refill_id_key);
							if ($status === true || $status === false) {
								unset($json_result[$api_refill->refill_id_key]);
							}

							$provider_order_id = search_key($json_result, $api_refill->refill_id_key);
							//$this->lib->print_data($response);
							$data_input['api_refill_id'] = $provider_order_id;
							$data_input['api_log_refill'] = $this->db->escape($response);
						}
					} catch (Exception $e) {
						log_message('error', $e->getMessage());
						print_r($e->getMessage());
					}
				}
			}
			if ($provider_order_id != null) {
				$this->db->trans_start();
				$this->refill_model->update($data_input, ['id' => $value['id']]);
				$this->db->trans_complete();
				print('Berhasil Refill. ID Refill: ' . $provider_order_id . '<br />');
			} else {
				$this->lib->print_data($response);
			}
		}
	}

	public function tesdepo()
	{
		$invoice = $this->invoice_model->get_rows(['where' => [['status' => 'Unpaid']]]);
		if ($invoice == false) {
			print('invoice kosong');
		} else {
			foreach ($invoice as $key => $value) {
				//print_r('<pre>'); print_r($value); print_r('</pre>'); die;
				$deposit_method = $this->deposit_method_model->get_by_id($value['method_payment']);

				$start_date = date_create($value['expired_payment']);
				$end_date = date_create(date('Y-m-d H:i:s'));
				$diff = date_diff($start_date, $end_date);
				if ($diff->format("%a days") > 0) { // lebih dari 1 hari
					$this->invoice_model->update(array('updated_at' => date('Y-m-d H:i:s'), 'status' => 'Expired'), array('id' => $value['id']));
					print('request exp');
					print('<br />');
					continue;
				}

				if ($deposit_method->category == 'bank' and $deposit_method->name == 'BANK BCA') {
					$mutasi = $this->log_deposit_bank_model->get_row(array('amount' => $value['amount'], 'status' => '0', 'bank' => 'BCA'));
					//print_r('<pre>'); print_r($mutasi); print_r('</pre>'); die;
					if ($mutasi === FALSE) {
						print('INVOICE ' . $value['id'] . ' - NOMINAL RP ' . currency($value['amount']) . ' TIDAK ADA PEMBAYARAN');
					} else {
						$this->db->trans_start();
						$this->invoice_model->update([
							'status' => 'Paid',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['invoice_code' => $value['invoice_code']]);

						$order = $this->order_model->get_rows([
							'where' => [
								['id' => $value['order_id']]
							],
						]);
						foreach ($order as $data_order) {
							$this->order_model->update([
								'status_payment' => 'Paid',
								'updated_at' => date('Y-m-d H:i:s'),
								'payment_success_date' => date('Y-m-d H:i:s')
							], ['id' => $data_order['id']]);
						}
						// update log deposit
						$this->log_deposit_bank_model->update(
							array(
								'status' => '1'
							),
							array('id' => $mutasi->id)
						);
						$this->db->trans_complete();

						print('ID INVOICE: ' . $value['id'] . ' -> AMOUNT INVOICE: ' . $value['amount'] . ' INVOICE SUCCESS <br />');
					}
				} else {
					print('ID INVOICE: ' . $value['id'] . ' PEMBAYARAN BUKAN BCA<br />');
				}
			}
		}
	}

	public function balance()
	{
		$target = $this->api_model->get_rows([
			'where' => [['is_manual' => '0']],
		]);

		foreach ($target as $key => $value) {
			// CHECK API BALANCE //
			$api_balance = $this->api_balance_model->get_row(['api_id' => $value['id']]);
			if ($api_balance == false) {
				print('API Refill False');
			}
			// END CHECK API BALANCE //
			$params = [];
			$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $value['id'], 'api_type' => 'balance']);
			//$this->lib->print_data($api_request_param);
			if (!empty($api_request_param)) {
				foreach ($api_request_param->result_array() as $row) {

					if ($row['param_type'] === 'custom') {
						$params[$row['param_key']] = $row['param_value'];
					} else {
						if ($row['param_value'] == 'api_id') {
							$params[$row['param_key']] = $value['api_id'];
						} else if ($row['param_value'] == 'api_key') {
							$params[$row['param_key']] = $value['api_key'];
						} else if ($row['param_value'] == 'secret_key') {
							$params[$row['param_key']] = $value['secret_key'];
						}
					}
					// $this->lib->print_data($row);
				}
				//die;
				$client = new GuzzleHttp\Client();
				try {
					$param_key = 'form_params';
					$request = $client->request('POST', $api_balance->end_point, [
						$param_key => $params,
						'headers' => ['Accept' => 'application/json'],
					]);
					if ($request->getStatusCode() === 200) {
						$response = $request->getBody()->getContents();
						$json_result = json_decode($response, true);

						$balance = search_key($json_result, $api_balance->balance_key);

						// Tambahkan pengujian saldo 0 di sini
						if ($balance !== null) {
							$this->db->trans_start();
							if ($value['kurs'] == 'USD') {
								$balance = $balance * $value['rate'];
							}

							// Tambahkan pengujian saldo 0 di sini
							if ($balance === 0) {
								$data_input = ['balance' => $balance];
								$this->api_model->update($data_input, ['id' => $value['id']]);
								$this->db->trans_complete();
								print('<font color="green"><pre>[●] API: ***** - Rp ' . currency($balance) . ' </pre></font><hr>');
							} else {
								$data_input = ['balance' => $balance];
								$this->api_model->update($data_input, ['id' => $value['id']]);
								$this->db->trans_complete();
								print('<font color="green"><pre>[●] API: ***** - Rp ' . currency($balance) . '</pre></font><hr>');
							}
						} else {
							print('<font color="red"><pre>[●] API: ' . $$response . '</pre></font><hr>');
							// $this->lib->print_data($response);
						}
					}
				} catch (Exception $e) {
					log_message('error', $e->getMessage());
					print_r($e->getMessage());
				}
			}
		}
	}

	public function status_refill()
	{
		$refill_list = $this->refill_model->get_rows([
			'where' => ["status NOT IN ('Completed', 'Gagal', 'Canceled', 'Error', 'Partial', 'Success')"],
			'order_by' => 'id DESC',
			'limit' => '20'
		]);
		foreach ($refill_list as $key => $value) {
			if ($value['api_refill_id'] == 0) {
				print('ID ORDER ' . $value['id'] . ' - TIDAK ADA REFILL ID <br />');
			} else {
				//$this->lib->print_data($value);
				$api_status = $this->api_refill_status_model->get_row(['api_id' => $value['api_id']]);
				if ($api_status == false) {
					print('API False');
				}
				// END CHECK API ORDER //
				$params = [];
				$data_api = $this->api_model->get_by_id($value['api_id']);
				$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $value['api_id'], 'api_type' => 'status_refill']);
				if (!empty($api_request_param)) {
					foreach ($api_request_param->result_array() as $row) {
						if ($row['param_type'] === 'custom') {
							$params[$row['param_key']] = $row['param_value'];
						} else {
							if ($row['param_value'] == 'refill_id') {
								$params[$row['param_key']] = $value['api_refill_id'];
							} else if ($row['param_value'] == 'api_id') {
								$params[$row['param_key']] = $data_api->api_id;
							} else if ($row['param_value'] == 'api_key') {
								$params[$row['param_key']] = $data_api->api_key;
							} else if ($row['param_value'] == 'secret_key') {
								$params[$row['param_key']] = $data_api->secret_key;
							}
						}
						//$this->lib->print_data($row);
					}
					//die;
					$client = new GuzzleHttp\Client();
					try {
						$param_key = 'form_params';

						$request = $client->request('POST', $api_status->end_point, [
							$param_key => $params,
							'headers' => ['Accept' => 'application/json'],
						]);
						if ($request->getStatusCode() === 200) {
							$response = $request->getBody()->getContents();
							$json_result = json_decode($response, true);
							$status = search_key($json_result, $api_status->refill_id_key);

							if ($status === true || $status === false) {
								unset($json_result[$api_status->refill_id_key]);
							}

							$status = search_key($json_result, $api_status->refill_id_key);
							//$this->lib->print_data($status_order);
						}
					} catch (Exception $e) {
						// Handle the error, log it, or print a message
						print('<font color="red"><pre>[●] ' . $value['id'] . ' - GAGAL MENGIRIM PERMINTAAN: ' . $e->getMessage() . '</pre></font><hr>');
						continue; // Skip to the next iteration if there is an error
					}
				}
				if ($status) {
					if (strtoupper(trim($status)) == 'COMPLETED' || strtoupper(trim($status)) == 'COMPLETE' || strtoupper(trim($status)) == 'SUCCESS') {
						$this->refill_model->update([
							'status' => 'Success',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['id' => $value['id']]);
					} elseif (strtoupper(trim($status)) == 'INPROGRESS' || strtoupper(trim($status)) == 'IN_PROGRESS' || strtoupper(trim($status)) == 'IN-PROGRESS' || strtoupper(trim($status)) == 'IN PROGRESS' || strtoupper(trim($status)) == 'PROCESSING' || strtoupper(trim($status)) == 'PROGRESS' || strtoupper(trim($status)) == 'PROSES') {

						$this->refill_model->update([
							'status' => 'Processing',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['id' => $value['id']]);
					} elseif (strtoupper(trim($status)) == 'PENDING') {

						$this->refill_model->update([
							'status' => 'Pending',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['id' => $value['id']]);
					} elseif (in_array(strtoupper(trim($status)), ['PARTIAL', 'PARTIALLY', 'PARTIALLY COMPLETED', 'PARTIAL COMPLETE'])) {
						$this->refill_model->update([
							'status' => 'Partial',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['id' => $value['id']]);
					} elseif (
						in_array(strtoupper(trim($status)), [
							'CANCEL',
							'CANCELLED',
							'CANCELED',
							'ERROR',
							'REJECTED',
							'GAGAL'
						])
					) {
						$this->refill_model->update([
							'status' => 'Error',
							'updated_at' => date('Y-m-d H:i:s'),
						], ['id' => $value['id']]);
					}
					$this->refill_model->update(['api_log_status_refill' => $this->db->escape($response)], ['id' => $value['id']]);
					print('<font color="green"><pre>[●] ' . $value['id'] . ' - STATUS REFILL: ' . $status . '</pre></font><hr>');
				} else {
					print('<font color="green"><pre>[●] ' . $value['id'] . ' - ' . print_r($json_result, true) . '</pre></font><hr>');
				}
			}
		}
	}

public function refund()
{
    $order_list = $this->order_model->get_rows([
        'where' => [
            ['is_refund' => '0'],
            "status IN ('Canceled', 'Partial', 'Error')"
        ],
        'order_by' => 'RAND()'
    ]);

    if (empty($order_list)) {
        // Cetak pesan jika tidak ada pesanan yang diproses
        print('Tidak ada pesanan yang perlu di-refund.');
        print('<br />');
        return;
    }

    foreach ($order_list as $key => $value) {
        // Mulai transaksi database
        $this->db->trans_start();

        // Pastikan order tidak telah di-refund oleh proses lain
        $current_order = $this->order_model->get_row(['id' => $value['id'], 'is_refund' => '0']);
        if (!$current_order) {
            // Jika order sudah di-refund oleh proses lain, batalkan transaksi
            $this->db->trans_complete();
            continue;
        }

        $saldo_awal = $this->user_model->get_row(['id' => $value['user_id']]);
        $price = $value['price'];
        $profit = $value['profit'];

        if ($value['status'] == 'Partial') {
            if ($value['remains'] <= $value['quantity']) {
                $price = $value['remains'] * ($value['price'] / $value['quantity']);
                $profit = $value['remains'] * ($value['profit'] / $value['quantity']);
            }
        }

        // Update order
        $update_order = [
            'price' => $value['price'] - $price,
            'profit' => $value['profit'] - $profit,
            'is_refund' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->order_model->update($update_order, ['id' => $value['id']]);

        // Update saldo user
        $user = $this->user_model->get_by_id($value['user_id']);
        if ($user) {
            $update_user = [
                'balance' => $user->balance + $price
            ];
            $this->user_model->update($update_user, ['id' => $value['user_id']]);
        }

        // Insert log balance usage
        $this->log_balance_usage_model->insert([
            'user_id' => $value['user_id'],
            'type' => 'plus',
            'category' => 'refund order',
            'amount' => $price,
            'description' => 'Pengembalian dana pesanan #' . $value['id'] . '.',
            'before' => $saldo_awal->balance,
            'after' => $saldo_awal->balance + $price,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Mengambil informasi user & referral
        $user = $this->user_model->get_row(['id' => $value['user_id']]); // Pengorder
        $check_referral = $this->user_model->get_row(['id' => $user->uplink]); // Pendapat komisi

        // Mengambil rate referral berdasarkan level benefit user
        $rate_referral = website_config('referral_rate_' . strtolower($check_referral->benefit) . '');
        $referral_calculate = ($update_order['price'] * $rate_referral) / 100;

        // Menyimpan log referral & update saldo komisi user
        if ($update_order['price'] != 0 && $check_referral->referral_status != 0 && $user->id != $check_referral->uplink && website_config('referral_status') != 0) {
            $data_insert = [
                'user_id' => $check_referral->id,
                'rate' => $rate_referral,
                'amount' => $referral_calculate,
                'description' => '' . $user->full_name . ' melakukan Pemesanan - Rp ' . currency($update_order['price']) . '',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->referral_log_model->insert($data_insert);

            // Update saldo komisi user
            $this->user_model->update(['referral_saldo' => $check_referral->referral_saldo + $referral_calculate], ['id' => $check_referral->id]);
        }

        // Update point benefit user
        if ($update_order['price'] != 0) {
            $awal_progress = $user->benefit_progress; // sisah transaksi user
            $awal_point = $user->benefit_point; // awal point sebelum melakukan penambahan point
            $total_order = $awal_progress + $update_order['price']; // total transaksi

            // Hitung jumlah point berdasarkan setiap Rp 50.000 total transaksi
            $point = floor($total_order / website_config('benefit_trx'));

            // Ambil sisa dari pembagian untuk mengetahui nilai kurang atau lebih dari kelipatan Rp 50.000
            $sisa_progress = $total_order % website_config('benefit_trx');

            // Update benefit_point dan benefit_progress user
            $this->user_model->update([
                'benefit_point' => $awal_point + $point, // Menambahkan point yang sudah dihitung
                'benefit_progress' => $sisa_progress, // Update sisah transaksi user
            ], ['id' => $user->id]);
        }

        // Selesaikan transaksi database
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Jika ada masalah dalam transaksi, rollback perubahan
            $this->db->trans_rollback();
            print('Refund gagal untuk pesanan #' . $value['id'] . '.');
            print('<br />');
        } else {
            print('SUKSES: Refund untuk pesanan #' . $value['id'] . ' sebesar Rp ' . number_format($price, 2, ',', '.') . '.');
            print('<br />');
        }
    }
}


	public function status()
	{
		$api_statuses = $this->api_status_model->get_rows(['where' => [['mass_status' => 0]]]);

		foreach ($api_statuses as $key => $data_api) {
			$order_list = $this->order_model->get_rows([
				'where' => ["status IN ('Pending', 'Processing') AND api_id = " . $data_api['api_id'] . ""],
				'order_by' => 'id DESC'
			]);

			foreach ($order_list as $key => $value) {
				if ($value['api_order_id'] == 0) {
					print('ID ORDER ' . $value['id'] . ' TRANSAKSI BELUM VALID <br />');
				} else {
					$api_status = $this->api_status_model->get_row(['api_id' => $value['api_id']]);

					if ($api_status == false) {
						print('API False');
					}

					$params = [];
					$api_data = $this->api_model->get_by_id($value['api_id']);
					$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $value['api_id'], 'api_type' => 'status']);

					if (!empty($api_request_param)) {
						foreach ($api_request_param->result_array() as $row) {
							if ($row['param_type'] === 'custom') {
								$params[$row['param_key']] = $row['param_value'];
							} else {
								if ($row['param_value'] == 'id') {
									$params[$row['param_key']] = $value['api_order_id'];
								} else if ($row['param_value'] == 'api_id') {
									$params[$row['param_key']] = $api_data->api_id;
								} else if ($row['param_value'] == 'api_key') {
									$params[$row['param_key']] = $api_data->api_key;
								} else if ($row['param_value'] == 'secret_key') {
									$params[$row['param_key']] = $api_data->secret_key;
								}
							}
						}

						$client = new GuzzleHttp\Client();

						try {
							$param_key = 'form_params';

							$request = $client->request('POST', $api_status->end_point, [
								$param_key => $params,
								'headers' => ['Accept' => 'application/json'],
							]);

							if ($request->getStatusCode() === 200) {
								$response = $request->getBody()->getContents();
								$json_result = json_decode($response, true);

								$statusKey = $api_status->status_key;

								// Pencarian nilai status
								$status = search_key($json_result, $statusKey);

								// Pemeriksaan apakah nilai status adalah boolean
								if ($status === true || $status === false) {
									// Menghapus elemen dengan kunci status jika status adalah boolean
									unset($json_result[$statusKey]);

									// Mencari nilai status kembali setelah penghapusan
									$status = search_key($json_result, $statusKey);
								}
								// Validasi nilai status
								if ($status !== null) {
									$start_count = search_key($json_result, $api_status->start_count_key);
									$remains_count = search_key($json_result, $api_status->remains_key);
									$status_order = search_key($json_result, $api_status->status_key);

									// Proses pembaruan status dan lainnya
									$this->processOrderStatus($value, $status, $start_count, $remains_count, $response);
								} else {
									print('<font color="red"><pre>[●] ' . $value['id'] . ' - Status tidak valid</pre></font><hr>');
								}
							}
						} catch (Exception $e) {
							print('<font color="red"><pre>[●] ' . $value['id'] . ' - GAGAL MENGIRIM PERMINTAAN: ' . $e->getMessage() . '</pre></font><hr>');
						}
					}
				}
			}
		}
	}

	private function processOrderStatus($order, $status, $start_count, $remains_count, $response)
	{
		if ($status) {
			switch (strtoupper(trim($status))) {
				case 'COMPLETED':
				case 'COMPLETE':
				case 'SUCCESS':
					$this->order_model->update([
						'status' => 'Success',
						'start_count' => $start_count,
						'remains' => $remains_count,
						'api_log_status' => $response,
						'updated_at' => date('Y-m-d H:i:s'),
					], ['id' => $order['id']]);

					// Mengambil informasi user & referral
					$user = $this->user_model->get_row(['id' => $order['user_id']]); // Pengorder
					$check_referral = $this->user_model->get_row(['id' => $user->uplink]); // Pendapat komisi

					// Mengambil rate referral berdasarkan level benefit user
					$rate_referral = website_config('referral_rate_' . strtolower($check_referral->benefit) . '');
					$referral_calculate = ($order['price'] * $rate_referral) / 100;

					// Menyimpan log referral & update saldo komisi user
					if ($order['price'] != 0 && $check_referral->referral_status != 0 && $user->id != $check_referral->uplink && website_config('referral_status') != 0) {

						$data_insert = [
							'user_id' => $check_referral->id,
							'rate' => $rate_referral,
							'amount' => $referral_calculate,
							'description' => '' . $user->full_name . ' melakukan Pemesanan - Rp ' . currency($order['price']) . '',
							'created_at' => date('Y-m-d H:i:s')
						];

						$this->referral_log_model->insert($data_insert);

						// Update saldo komisi user
						$this->user_model->update(['referral_saldo' => $check_referral->referral_saldo + $referral_calculate], ['id' => $check_referral->id]);
					}

					if ($order['price'] != 0) {
						// Update benefit user
						$awal_progress = $user->benefit_progress; // sisah transaksi user
						$awal_point = $user->benefit_point; // awal point sebelum melakukan penambahan point
						$total_order = $awal_progress + $order['price']; // total transaksi

						// Hitung jumlah point berdasarkan setiap Rp 50.000 total transaksi
						$point = floor($total_order / website_config('benefit_trx'));

						// Ambil sisa dari pembagian untuk mengetahui nilai kurang atau lebih dari kelipatan Rp 50.000
						$sisa_progress = $total_order % website_config('benefit_trx');

						// Update benefit_point dan benefit_progress user
						$this->user_model->update([
							'benefit_point' => $awal_point + $point, // Menambahkan point yang sudah dihitung
							'benefit_progress' => $sisa_progress, // Update sisah transaksi user
						], ['id' => $user->id]);
					}
					break;

				case 'INPROGRESS':
				case 'IN_PROGRESS':
				case 'IN-PROGRESS':
				case 'IN PROGRESS':
				case 'PROCESSING':
				case 'PROGRESS':
					$this->order_model->update([
						'status' => 'Processing',
						'start_count' => $start_count,
						'remains' => $remains_count,
						'api_log_status' => $response,
						'updated_at' => date('Y-m-d H:i:s'),
					], ['id' => $order['id']]);
					break;

				case 'PENDING':
					$this->order_model->update([
						'status' => 'Pending',
						'start_count' => $start_count,
						'remains' => $remains_count,
						'api_log_status' => $response,
						'updated_at' => date('Y-m-d H:i:s'),
					], ['id' => $order['id']]);
					break;

				case 'PARTIAL':
				case 'PARTIALLY':
				case 'PARTIALLY COMPLETED':
				case 'PARTIAL COMPLETE':
					$this->order_model->update([
						'status' => 'Partial',
						'start_count' => $start_count,
						'remains' => $remains_count,
						'api_log_status' => $response,
						'updated_at' => date('Y-m-d H:i:s'),
					], ['id' => $order['id']]);
					break;

				case 'CANCEL':
				case 'CANCELLED':
				case 'CANCELED':
				case 'ERROR':
				case 'REJECTED':
					$this->order_model->update([
						'status' => 'Error',
						'start_count' => $start_count,
						'remains' => $remains_count,
						'api_log_status' => $response,
						'updated_at' => date('Y-m-d H:i:s'),
					], ['id' => $order['id']]);
					break;

				default:
					print('<font color="red"><pre>[●] ' . $order['id'] . ' - Status tidak valid: ' . $status . '</pre></font><hr>');
					break;
			}

			print('<font color="green"><pre>[●] ' . $order['id'] . ' - ' . $status . '</pre></font><hr>');
		} else {
			print('<font color="red"><pre>[●] ' . $order['id'] . ' - Status tidak valid</pre></font><hr>');
		}
	}
	public function mass_status()
	{
		$api_statuses = $this->api_status_model->get_rows(['where' => [['mass_status' => 1]]]);

		if (!$api_statuses) {
			echo 'tidak ada';
			return;
		}

		foreach ($api_statuses as $key => $value) {
			$orders = $this->order_model->get_rows(['where' => ["status IN ('Pending', 'Processing') AND api_id = " . $value['api_id'] . ""]]);
			$ID = [];

			foreach ($orders as $key => $data_order) {
				$ID[] = $data_order['api_order_id'];
			}

			$orderIDs = array_chunk($ID, 100); // Memecah id ke dalam kelompok-kelompok dengan maksimal 100 id per kelompok

			foreach ($orderIDs as $orderID) {
				$params = [];
				$orderIDStr = implode(",", $orderID);

				$api_data = $this->api_model->get_by_id($value['api_id']);
				$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $value['api_id'], 'api_type' => 'status']);

				if (!empty($api_request_param)) {
					foreach ($api_request_param->result_array() as $row) {
						if ($row['param_type'] === 'custom') {
							$params[$row['param_key']] = $row['param_value'];
						} else {
							if ($row['param_value'] == 'id') {
								$params[$row['param_key']] = $orderIDStr;
							} else if ($row['param_value'] == 'api_id') {
								$params[$row['param_key']] = $api_data->api_id;
							} else if ($row['param_value'] == 'api_key') {
								$params[$row['param_key']] = $api_data->api_key;
							} else if ($row['param_value'] == 'secret_key') {
								$params[$row['param_key']] = $api_data->secret_key;
							}
						}
					}

					$client = new GuzzleHttp\Client();

					try {
						$param_key = 'form_params';

						$request = $client->request('POST', $value['end_point'], [
							$param_key => $params,
							'headers' => ['Accept' => 'application/json'],
						]);

						if ($request->getStatusCode() === 200) {
							$response = $request->getBody()->getContents();
							$json_result = json_decode($response, true);

							if ($json_result) {
								foreach ($orders as $control_order) {
									if (array_key_exists($control_order['api_order_id'], $json_result)) {
										$status = search_key($json_result[$control_order['api_order_id']], $value['status_key']);
										$start_count = search_key($json_result[$control_order['api_order_id']], $value['start_count_key']);
										$remains_count = search_key($json_result[$control_order['api_order_id']], $value['remains_key']);

										$status_order = search_key($json_result[$control_order['api_order_id']], $value['status_key']);

										// Update status berdasarkan hasil dari API
										switch (strtoupper(trim($status))) {
											case 'COMPLETED':
											case 'COMPLETE':
											case 'SUCCESS':
												$order_status = 'Success';
												break;
											case 'IN PROGRESS':
											case 'INPROGRESS':
											case 'IN_PROGRESS':
											case 'IN-PROGRESS':
											case 'PROCESSING':
											case 'PROGRESS':
												$order_status = 'Processing';
												break;
											case 'PENDING':
												$order_status = 'Pending';
												break;
											case 'PARTIAL':
											case 'PARTIALLY':
											case 'PARTIALLY COMPLETED':
											case 'PARTIAL COMPLETE':
												$order_status = 'Partial';
												break;
											case 'CANCEL':
											case 'CANCELLED':
											case 'CANCELED':
											case 'ERROR':
											case 'REJECTED':
												$order_status = 'Error';
												break;
											default:
												$order_status = 'Unknown';
												break;
										}

										$this->order_model->update([
											'status' => $order_status,
											'api_log_status' => json_encode($json_result[$control_order['api_order_id']]),
											'start_count' => $start_count,
											'remains' => $remains_count,
											'updated_at' => date('Y-m-d H:i:s'),
										], ['id' => $control_order['id']]);

										// Tambahkan log referral jika diperlukan dan update saldo komisi user
										if ($order_status == 'Success') {
											$user = $this->user_model->get_row(['id' => $control_order['user_id']]);
											$check_referral = $this->user_model->get_row(['id' => $user->uplink]);
											$rate_referral = website_config('referral_rate_' . strtolower($check_referral->benefit) . '');
											$referral_calculate = ($control_order['price'] * $rate_referral) / 100;

											if ($control_order['price'] != 0 && $check_referral->referral_status != 0 && $user->id != $check_referral->uplink && website_config('referral_status') != 0) {
												$data_insert = [
													'user_id' => $check_referral->id,
													'rate' => $rate_referral,
													'amount' => $referral_calculate,
													'description' => '' . $user->full_name . ' melakukan Pemesanan - Rp ' . currency($control_order['price']) . '',
													'created_at' => date('Y-m-d H:i:s')
												];
												$this->referral_log_model->insert($data_insert);
												$this->user_model->update(['referral_saldo' => $check_referral->referral_saldo + $referral_calculate], ['id' => $check_referral->id]);
											}

											if ($control_order['price'] != 0) {
												$awal_progress = $user->benefit_progress;
												$awal_point = $user->benefit_point;
												$total_order = $awal_progress + $control_order['price'];
												$point = floor($total_order / website_config('benefit_trx'));
												$sisa_progress = $total_order % website_config('benefit_trx');

												$this->user_model->update([
													'benefit_point' => $awal_point + $point,
													'benefit_progress' => $sisa_progress,
												], ['id' => $user->id]);
											}
										}
									}
									print('<font color="green"><pre>[●] ' . $control_order['id'] . ' - ' . $status . '</pre></font><hr>');
								}
							} else {
								// Print pesan error jika response JSON tidak valid
								print('<font color="red"><pre>[●] ' . $value['api_id'] . ' - Response JSON tidak valid</pre></font><hr>');
							}
						}
					} catch (Exception $e) {
						// Handle exception
						print('<font color="red"><pre>[●] ' . $value['api_id'] . ' - GAGAL MENGIRIM PERMINTAAN: ' . $e->getMessage() . '</pre></font><hr>');
					}
				}
			}
		}
	}
	
	public function mutasi_qris()
	{
	    $apikey = website_config("qris_api_key");
	    $usqris = website_config("qris_us_qris");
	    $username = website_config("qris_username");
	    
	    $postdata = http_build_query(['api_key' => $apikey, 'us_qris' => $usqris, 'us_username' => $username]);
	    
	    $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_URL, "https://solusimediapulsa.com/api/h2h-qris?" . $postdata);
	    
	    $response = curl_exec($ch);
	    
		curl_close($ch);
		$deposit_mutasi = json_decode($response, true);
		$deposit_method = $this->deposit_method_model->get_rows(['where' => [['name' => 'QRIS Otomatis [No Fee] [Bonus 10%]', 'gateway_code' => 'manual']], 'limit' => 1])[0];
		
		if (!$deposit_method) {
		    exit(die("Methode deposit tidak ditemukan"));
		} else {
    	    $data_deposit = $this->deposit_model->get_rows(['where' => [['status' => 'Pending', 'deposit_method_id' => $deposit_method['id']]]]);
    	    
    	    if (!$data_deposit) {
    	        exit(die("Deposit qris pending tidak ditemukan"));
    	    } else {
    	        foreach($data_deposit as $j => $data) {
    	            $j = $j + 1;
    	            
    	            echo "<font color='green'>========== [ Pengecekkan $j dimulai ] ==========</font>";
    	            echo "<br />";
    	            echo "<br />";
    	            
    	            foreach($deposit_mutasi['data'] as $i => $row) {
	                    $user = $this->user_model->get_by_id($data['user_id']);
                        $depost = $this->deposit_model->get_by_id($data['id']);
    	                    
	                    if ($depost->status === "Pending") {
        	                if ($data['amount'] == $row['kredit']) {
        	                    $update = $this->deposit_model->update(['updated_at' => date('Y-m-d H:i:s'), 'status' => 'Success'], ['id' => $data['id']]);
        	                    
        	                    if ($update) {
                                    $balance = $data['balance'] + ($data['amount'] - ($data['balance'] / $deposit_method['rate']));
            	                   
                                    $phone = $this->lib->hp($user->whatsapp);
                                    $phone1 = website_config('wa_admin');
                                    $message = website_config('wa_deposit_success');
                                    $message1 = website_config('wa_admin_deposit_success');
                                    
                                    $pesan = preg_replace(
                                    	array(
                                    		'/{{url}}/',
                                    		'/{{title}}/',
                                    		'/{{user_fullname}}/',
                                    		'/{{user_username}}/',
                                    		'/{{deposit_id}}/',
                                    		'/{{deposit_method}}/',
                                    		'/{{deposit_transfer}}/',
                                    		'/{{deposit_amount}}/',
                                    		'/{{deposit_status}}/',
                                    		'/{{deposit_create}}/',
                                    		'/{{deposit_update}}/'
                                    	),
                                    	array(
                                    		base_url(),
                                    		website_config('title'),
                                    		$user->full_name,
                                    		$user->username,
                                    		$data['id'],
                                    		$deposit_method['name'],
                                    		currency($data['amount']),
                                    		currency($balance),
                                    		'Success',
                                    		$this->lib->format_date($data['created_at']),
                                    		$this->lib->format_date(date('Y-m-d H:i:s'))
                                    	),
                                    	$message
                                    );
                                    
                                    $pesan1 = preg_replace(
                                    	array(
                                    		'/{{url}}/',
                                    		'/{{title}}/',
                                    		'/{{user_fullname}}/',
                                    		'/{{user_username}}/',
                                    		'/{{deposit_id}}/',
                                    		'/{{deposit_method}}/',
                                    		'/{{deposit_transfer}}/',
                                    		'/{{deposit_amount}}/',
                                    		'/{{deposit_status}}/',
                                    		'/{{deposit_create}}/',
                                    		'/{{deposit_update}}/'
                                    	),
                                    	array(
                                    		base_url(),
                                    		website_config('title'),
                                    		$user->full_name,
                                    		$user->username,
                                    		$data['id'],
                                    		$deposit_method['name'],
                                    		currency($data['amount']),
                                    		currency($balance),
                                    		'Success',
                                    		$this->lib->format_date($deposit['created_at']),
                                    		$this->lib->format_date(date('Y-m-d H:i:s'))
                                    	),
                                    	$message1
                                    );
                                    
                                    $this->lib->sendMessage('', $phone, $pesan);
                                    $this->lib->sendMessage('', $phone1, $pesan1);
            	                    
        	                        $this->log_balance_usage_model->insert([
            							'user_id' => $user->id,
            							'type' => 'plus',
            							'category' => 'deposit',
            							'amount' => $balance,
            							'description' => 'Deposit #' . $data['id'] . '.',
            							'before' => $user->balance,
            							'after' => $user->balance + $balance,
            							'created_at' => date('Y-m-d H:i:s')
            						]);
            						
            	                    $this->user_model->update(['updated_at' => date('Y-m-d H:i:s'), 'balance' => $user->balance + $balance], ['id' => $data['user_id']]);
            	                    
            	                    echo "<font color='green'>SUCCESS</font>: deposit $data[id] cocok dengan mutasi ke $i";
            	                    echo "<br />";
        	                    } else {
            	                    echo " <font color='blue'>PENDING</font>: deposit $data[id] tidak cocok dengan mutasi ke $i";
            	                    echo "<br />";
        	                    }
        	                } else {
        	                    $datenow = strtotime(date('Y-m-d H:i:s'));
        	                    $tgldepo = strtotime($data['created_at']) + strtotime('+2 Hours') - $datenow;
        	                    
        	                    if ($tgldepo <= $datenow) {
        	                        $update = $this->deposit_model->update(['updated_at' => date('Y-m-d H:i:s'), 'status' => 'Canceled'], ['id' => $data['id']]);
        	                        
        	                        if ($update) {
        	                            $balance = $data['balance'] + ($data['amount'] - ($data['balance'] / $deposit_method['rate']));
            	                   
                                        $phone = $this->lib->hp($user->whatsapp);
                                        $phone1 = website_config('wa_admin');
                                        $message = website_config('wa_deposit_canceled');
                                        $message1 = website_config('wa_admin_deposit_canceled');
                                        
                                        $pesan = preg_replace(
                                        	array(
                                        		'/{{url}}/',
                                        		'/{{title}}/',
                                        		'/{{user_fullname}}/',
                                        		'/{{user_username}}/',
                                        		'/{{deposit_id}}/',
                                        		'/{{deposit_method}}/',
                                        		'/{{deposit_transfer}}/',
                                        		'/{{deposit_amount}}/',
                                        		'/{{deposit_status}}/',
                                        		'/{{deposit_create}}/',
                                        		'/{{deposit_update}}/'
                                        	),
                                        	array(
                                        		base_url(),
                                        		website_config('title'),
                                        		$user->full_name,
                                        		$user->username,
                                        		$data['id'],
                                        		$deposit_method['name'],
                                        		currency($data['amount']),
                                        		currency($balance),
                                        		'Canceled',
                                        		$this->lib->format_date($data['created_at']),
                                        		$this->lib->format_date(date('Y-m-d H:i:s'))
                                        	),
                                        	$message
                                        );
                                        
                                        $pesan1 = preg_replace(
                                        	array(
                                        		'/{{url}}/',
                                        		'/{{title}}/',
                                        		'/{{user_fullname}}/',
                                        		'/{{user_username}}/',
                                        		'/{{deposit_id}}/',
                                        		'/{{deposit_method}}/',
                                        		'/{{deposit_transfer}}/',
                                        		'/{{deposit_amount}}/',
                                        		'/{{deposit_status}}/',
                                        		'/{{deposit_create}}/',
                                        		'/{{deposit_update}}/'
                                        	),
                                        	array(
                                        		base_url(),
                                        		website_config('title'),
                                        		$user->full_name,
                                        		$user->username,
                                        		$data['id'],
                                        		$deposit_method['name'],
                                        		currency($data['amount']),
                                        		currency($balance),
                                        		'Canceled',
                                        		$this->lib->format_date($deposit['created_at']),
                                        		$this->lib->format_date(date('Y-m-d H:i:s'))
                                        	),
                                        	$message1
                                        );
                                        
                                        $this->lib->sendMessage('', $phone, $pesan);
                                        $this->lib->sendMessage('', $phone1, $pesan1);
                                    
        	                            echo "<font color='red'>CANCELED</font>: deposit $data[id] tidak cocok dengan mutasi ke $i";
                	                    echo "<br />";
        	                        } else {
                	                    echo " <font color='blue'>PENDING</font>: deposit $data[id] tidak cocok dengan mutasi ke $i";
                	                    echo "<br />";
        	                        }
        	                    } else if ($tgldepo > $datenow) {
            	                    echo " <font color='blue'>PENDING</font>: deposit $data[id] tidak cocok dengan mutasi ke $i";
            	                    echo "<br />";
        	                    }
        	                    
        	                }
	                    }
    	                
    	            }
    	                
                    echo "<br />";
    	            echo "<font color='green'>========== [ Pengecekkan $j selesai ] ==========</font>";
    	            echo "<br />";
    	            echo "<br />";
    	        }
    	    }
		}
	}
	
	public function update_layanan()
	{
		$data_api = $this->api_model->get_rows(['where' => [['is_manual' => '0']]]);
		foreach ($data_api as $data) {
			if ($data['auto_update'] == '1' && $data['profit'] > 0) {
				$params = [];
				$api_service = $this->db->get_where('api_service', ['api_id' => $data['id']])->row();
				$api_request_param = $this->api_request_param_model->get_rows(['where' => [['api_id' => $data['id'], 'api_type' => 'service']]]);
				foreach ($api_request_param as $row) {
					if ($row['param_type'] === 'custom') {
						$params[$row['param_key']] = $row['param_value'];
					} else {
						if ($row['param_value'] == 'api_id') {
							$params[$row['param_key']] = $data['api_id'];
						} else if ($row['param_value'] == 'api_key') {
							$params[$row['param_key']] = $data['api_key'];
						} else if ($row['param_value'] == 'secret_key') {
							$params[$row['param_key']] = $data['secret_key'];
						}
					}
				}
				$client = new GuzzleHttp\Client([
					'config' => [
						'http' => [
							'verify_peer' => true,
							'verify_peer_name' => true,
							'allow_self_signed' => false,
							'ciphers' => 'DEFAULT:!DH',
							'disable_compression' => true,
							'protocol_version' => '1.2',
						],
					],
				]);
				$param_key = 'form_params';

				$request = $client->request('POST', $api_service->end_point, [
					$param_key => $params,
					'headers' => ['Accept' => 'application/json'],
					'timeout' => 60, // Tambahkan timeout di sini (dalam detik)
				]);
				$data_service = array();
				if ($request->getStatusCode() === 200) {
					$response = $request->getBody()->getContents();
					$json_result = json_decode($response, true);
					if (count($json_result) < 1) {
						$this->lib->print_data($json_result);
						die;
					}
					if ($api_service->data_service_key <> '-') {
						foreach ($json_result[$api_service->data_service_key] as $key => $value) {
							//$this->lib->print_data($value);

							$check_service = $this->service_model->get_row(['api_service_id' => $value[$api_service->service_id_key], 'api_id' => $data['id']]);

							if ($data['auto_name_service'] == '1') { // auto update nama layanan
								if (isset($value[$api_service->service_name_key])) {
									$name = $value[$api_service->service_name_key];
									$data_replace = $this->replace_keyword_model->get_rows();

									if ($data_replace && is_array($data_replace)) {
										$name = $this->lib->replaceKeywords($name, $data_replace);
									}
								}
							} else {
								// Tambahkan pengecekan sebelum mengakses properti "name"
								if ($check_service) {
									$name = $check_service->name; // Nama layanan tidak diubah
								} else {
									// Tindakan yang perlu diambil jika $check_service adalah false
									// Contoh: $name = "Nama Layanan Default";
								}
							}


							if ($data['kurs'] == 'USD') {
								$price = $value[$api_service->price_key] * $data['rate'];
							} else {
								$price = $value[$api_service->price_key];
							}

							if ($data['profit_type'] == 'persen') {
								$profit = $price * convert_percent($data['profit']);
							} else {
								$profit = $data['profit'];
							}

							$total_price = $price + $profit;
							$total_profit = $profit;

							// Tentukan deskripsi berdasarkan data di database jika tidak ada dalam JSON
							$descriptionKey = $api_service->description_key;

							if ($descriptionKey !== '-') {
								// Tambahkan pengecekan sebelum mengakses properti "description"
								if (isset($value[$descriptionKey])) {
									$description = strip_tags($value[$descriptionKey]);
								} else {
									// Tindakan yang perlu diambil jika $value[$descriptionKey] tidak terdefinisi
									// Contoh: $description = "Deskripsi Default";
									$description = '-';
								}
							} else {
								// Jangan lakukan perubahan deskripsi jika $descriptionKey = -
								$description = isset($check_service->description) ? strip_tags($check_service->description) : '-';
							}

							$phone = website_config('wa_admin');
							// Ganti dengan ID grup atau saluran yang ingin Anda tuju
							$chat_id = '-1001284854567';
							$message_thread_id = '216';
							if ($check_service == true) {

								$this->db->trans_start();
								$data_update = [
									'api_id' => $api_service->api_id,
									'api_service_id' => $value[$api_service->service_id_key],
									'name' => $name,
									'price' => $total_price,
									'profit' => $total_profit,
									'description' => $description,
									'min' => $value[$api_service->min_key],
									'max' => $value[$api_service->max_key],
									'api' => '1',
									'type' => (strtoupper(trim($value[$api_service->type_key])) === 'CUSTOM COMMENTS' || strtoupper(trim($value[$api_service->type_key])) === 'CUSTOM COMMENTS PACKAGE') ? 'custom_comments' : 'primary',
									'refill' => ($value[$api_service->refill_key] == true || $value[$api_service->refill_key] == 1) ? '1' : '0',
									'average_time' => get_service_average($check_service->id),
									'status' => '1',
									'updated_at' => date('Y-m-d H:i:s')
								];
								if ($data_update['min'] <> $check_service->min) {
									$data_service_logs = [
										'service_id' => $check_service->id,
										'service_name' => $name,
										'before_update' => $check_service->min,
										'after_update' => $data_update['min'],
										'type' => 'update_min',
										'created_at' => date('Y-m-d H:i:s')
									];
									$this->service_logs_model->insert($data_service_logs);
									$pesan_tele = '<b>Perubahan Minimal Layanan</b>
<b>[•] ' . $check_service->id . '</b> - ' . $name . '
Sebelum: ' . currency($check_service->min) . '
Sesudah: ' . currency($data_update['min']) . '';
									$pesan = 'Perubahan Minimal Layanan
[•] ' . $check_service->id . ' - ' . $name . '
Sebelum: ' . currency($check_service->min) . '
Sesudah: ' . currency($data_update['min']) . '';
									$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
									// $this->lib->sendMessage($phone, $pesan);
								}
								if ($data_update['max'] <> $check_service->max) {
									$data_service_logs = [
										'service_id' => $check_service->id,
										'service_name' => $name,
										'before_update' => $check_service->max,
										'after_update' => $data_update['max'],
										'type' => 'update_max',
										'created_at' => date('Y-m-d H:i:s')
									];
									$this->service_logs_model->insert($data_service_logs);
									$pesan_tele = '<b>Perubahan Maksimal Layanan</b>
<b>[•] ' . $check_service->id . '</b> - ' . $name . '
Sebelum: ' . currency($check_service->max) . '
Sesudah: ' . currency($data_update['max']) . '';
									$pesan = 'Perubahan Maksimal Layanan
[•] ' . $check_service->id . ' - ' . $name . '
Sebelum: ' . currency($check_service->max) . '
Sesudah: ' . currency($data_update['max']) . '';
									$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
									// $this->lib->sendMessage($phone, $pesan);
								}
								if ($data_update['status'] <> $check_service->status) {
									$data_service_logs = [
										'service_id' => $check_service->id,
										'service_name' => $name,
										'before_update' => '0',
										'after_update' => '1',
										'type' => 'enabled',
										'created_at' => date('Y-m-d H:i:s')
									];
									$this->service_logs_model->insert($data_service_logs);
									$pesan_tele = '<b>AKTIF LAYANAN</b>
<b>[✓] ' . $check_service->id . '</b> - ' . $name . ' - Rp ' . currency($data_update['price']) . '';
									$pesan = 'AKTIF LAYANAN
[✓] ' . $check_service->id . ' - ' . $name . ' - Rp ' . currency($data_update['price']) . '';
									$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
									// $this->lib->sendMessage($phone, $pesan);
								}
								if (round($data_update['price']) <> round($check_service->price)) {
									$data_service_logs = [
										'service_id' => $check_service->id,
										'service_name' => $name,
										'before_update' => $check_service->price,
										'after_update' => $data_update['price'],
										'type' => ($data_update['price'] > $check_service->price ? 'price_increased' : 'price_decreased'),
										'created_at' => date('Y-m-d H:i:s')
									];
									$this->service_logs_model->insert($data_service_logs);
									$pesan_tele = '<b>Perubahan Harga Layanan</b>
<b>[•] ' . $check_service->id . '</b> - ' . $name . '
Sebelum: Rp ' . currency($check_service->price) . '
Sesudah: Rp ' . currency($data_update['price']) . '';
									$pesan = 'Perubahan Harga Layanan
[•] ' . $check_service->id . ' - ' . $name . '
Sebelum: Rp ' . currency($check_service->price) . '
Sesudah: Rp ' . currency($data_update['price']) . '';
									$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
									// $this->lib->sendMessage($phone, $pesan);
								}
								$this->db->set($data_update);
								$this->db->where(['id' => $check_service->id, 'api_id' => $data['id']]);
								$this->db->update('service');
								$this->db->trans_complete();
								$this->db->error();
								echo '<pre style="color: green;">[●]  Update Layanan: ' . $check_service->id . ' | ' . $data_update['name'] . ' Berhasil | Harga asli ' . currency($price) . ' | Profit ' . currency($total_profit) . ' | Harga akhir ' . currency($total_price) . '</pre><hr>';
								// echo "Update Layanan: " . $data_update['name'] . " Berhasil | Harga asli " . currency($price) . "  | + | Profit " . currency($total_profit) . " | Harga akhir " . currency($total_price) . "<br/><br/>";
							}
						}
					} else {
						foreach ($json_result as $key => $value) {
							//$this->lib->print_data($value);

							$check_service = $this->service_model->get_row(['api_service_id' => $value[$api_service->service_id_key], 'api_id' => $data['id']]);
							if ($data['auto_name_service'] == '1') { // auto update nama layanan
								if (isset($value[$api_service->service_name_key])) {
									$name = $value[$api_service->service_name_key];
									$data_replace = $this->replace_keyword_model->get_rows();

									if ($data_replace && is_array($data_replace)) {
										$name = $this->lib->replaceKeywords($name, $data_replace);
									}
								}
							} else {
								// Tambahkan pengecekan sebelum mengakses properti "name"
								if ($check_service) {
									$name = $check_service->name; // Nama layanan tidak diubah
								} else {
									// Tindakan yang perlu diambil jika $check_service adalah false
									// Contoh: $name = "Nama Layanan Default";
								}
							}

							if ($data['kurs'] == 'USD') {
								$price = $value[$api_service->price_key] * $data['rate'];
							} else {
								$price = $value[$api_service->price_key];
							}

							if ($data['profit_type'] == 'persen') {
								$profit = $price * convert_percent($data['profit']);
							} else {
								$profit = $data['profit'];
							}

							$total_price = $price + $profit;
							$total_profit = $profit;

							// Tentukan deskripsi berdasarkan data di database jika tidak ada dalam JSON
							$descriptionKey = $api_service->description_key;

							if ($descriptionKey !== '-') {
								// Tambahkan pengecekan sebelum mengakses properti "description"
								if (isset($value[$descriptionKey])) {
									$description = strip_tags($value[$descriptionKey]);
								} else {
									// Tindakan yang perlu diambil jika $value[$descriptionKey] tidak terdefinisi
									// Contoh: $description = "Deskripsi Default";
									$description = '-';
								}
							} else {
								// Jangan lakukan perubahan deskripsi jika $descriptionKey = -
								$description = isset($check_service->description) ? strip_tags($check_service->description) : '-';
							}

							$phone = website_config('wa_admin');
							// Ganti dengan ID grup atau saluran yang ingin Anda tuju
							$chat_id = '-1001284854567';
							$message_thread_id = '216';
							//$this->lib->print_data($data_service);
							if ($check_service == true) {
								$this->db->trans_start();
								$data_update = [
									'api_id' => $api_service->api_id,
									'api_service_id' => $value[$api_service->service_id_key],
									'name' => $name,
									'description' => $description,
									'price' => $total_price,
									'profit' => $total_profit,
									'min' => $value[$api_service->min_key],
									'max' => $value[$api_service->max_key],
									'api' => '1',
									'type' => (strtoupper(trim($value[$api_service->type_key])) === 'CUSTOM COMMENTS' || strtoupper(trim($value[$api_service->type_key])) === 'CUSTOM COMMENTS PACKAGE') ? 'custom_comments' : 'primary',
									'refill' => ($value[$api_service->refill_key] == true || $value[$api_service->refill_key] == 1) ? '1' : '0',
									'cancel' => ($value['cancel'] == true || $value['cancel'] == 1) ? '1' : '0',
									'average_time' => get_service_average($check_service->id),
									'status' => '1',
									'updated_at' => date('Y-m-d H:i:s')
								];

								if ($data_update['min'] <> $check_service->min) {
									$data_service_logs = [
										'service_id' => $check_service->id,
										'service_name' => $name,
										'before_update' => $check_service->min,
										'after_update' => $data_update['min'],
										'type' => 'update_min',
										'created_at' => date('Y-m-d H:i:s')
									];
									$this->service_logs_model->insert($data_service_logs);
									$pesan_tele = '<b>Perubahan Minimal Layanan</b>
<b>[•] ' . $check_service->id . '</b> - ' . $name . '
Sebelum: ' . currency($check_service->min) . '
Sesudah: ' . currency($data_update['min']) . '';
									$pesan = 'Perubahan Minimal Layanan
[•] ' . $check_service->id . ' - ' . $name . '
Sebelum: ' . currency($check_service->min) . '
Sesudah: ' . currency($data_update['min']) . '';
									$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
									// $this->lib->sendMessage($phone, $pesan);
								}
								if ($data_update['max'] <> $check_service->max) {
									$data_service_logs = [
										'service_id' => $check_service->id,
										'service_name' => $name,
										'before_update' => $check_service->max,
										'after_update' => $data_update['max'],
										'type' => 'update_max',
										'created_at' => date('Y-m-d H:i:s')
									];
									$this->service_logs_model->insert($data_service_logs);
									$pesan_tele = '<b>Perubahan Maksimal Layanan</b>
<b>[•] ' . $check_service->id . '</b> - ' . $name . '
Sebelum: ' . currency($check_service->max) . '
Sesudah: ' . currency($data_update['max']) . '';
									$pesan = 'Perubahan Maksimal Layanan
[•] ' . $check_service->id . ' - ' . $name . '
Sebelum: ' . currency($check_service->max) . '
Sesudah: ' . currency($data_update['max']) . '';
									$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
									// $this->lib->sendMessage($phone, $pesan);
								}
								if ($data_update['status'] <> $check_service->status) {
									$data_service_logs = [
										'service_id' => $check_service->id,
										'service_name' => $name,
										'before_update' => '0',
										'after_update' => '1',
										'type' => 'enabled',
										'created_at' => date('Y-m-d H:i:s')
									];
									$this->service_logs_model->insert($data_service_logs);
									$pesan_tele = '<b>AKTIF LAYANAN</b>
<b>[✓] ' . $check_service->id . '</b> - ' . $name . ' - Rp ' . currency($data_update['price']) . '';
									$pesan = 'AKTIF LAYANAN
[✓] ' . $check_service->id . ' - ' . $name . ' - Rp ' . currency($data_update['price']) . '';
									$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
									// $this->lib->sendMessage($phone, $pesan);
								}
								if (round($data_update['price']) <> round($check_service->price)) {
									$data_service_logs = [
										'service_id' => $check_service->id,
										'service_name' => $name,
										'before_update' => $check_service->price,
										'after_update' => $data_update['price'],
										'type' => ($data_update['price'] > $check_service->price ? 'price_increased' : 'price_decreased'),
										'created_at' => date('Y-m-d H:i:s')
									];
									$this->service_logs_model->insert($data_service_logs);
									$pesan_tele = '<b>Perubahan Harga Layanan</b>
<b>[•] ' . $check_service->id . '</b> - ' . $name . '
Sebelum: Rp ' . currency($check_service->price) . '
Sesudah: Rp ' . currency($data_update['price']) . '';
									$pesan = 'Perubahan Harga Layanan
[•] ' . $check_service->id . ' - ' . $name . '
Sebelum: Rp ' . currency($check_service->price) . '
Sesudah: Rp ' . currency($data_update['price']) . '';
									$this->lib->kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id);
									// $this->lib->sendMessage($phone, $pesan);
								}

								$this->db->set($data_update);
								$this->db->where(['id' => $check_service->id, 'api_id' => $data['id']]);
								$this->db->update('service');
								$this->db->trans_complete();
								$this->db->error();

								echo '<pre style="color: green;">[●] Update Layanan: ' . $check_service->id . ' | ' . $data_update['name'] . ' | Harga asli ' . currency($price) . ' | Profit ' . currency($total_profit) . ' | Harga akhir ' . currency($total_price) . '</pre><hr>';
								// echo "Update Layanan: " . $data_update['name'] . " Berhasil | Harga asli " . currency($price) . "  | + | Profit " . currency($total_profit) . " | Harga akhir " . currency($total_price) . "<br/><br/>";
							}
						}
					}
				}
			} else {
				echo '<pre style="color: red;">[X] ' . $data['name'] . ' skipped: auto update tidak dinyalakan / keuntungan belum di setting</pre><hr>';
			}
		}
	}
	public function auto_deposit()
	{
		$deposit = $this->db->select('*')->where(array('status' => 'Pending', 'type' => 'auto'))->order_by('RAND()')->get('deposit', 100, 0)->result_array();
		foreach ($deposit as $key => $value) {
			$deposit_method = $this->deposit_method_model->get_by_id($value['deposit_method_id']);

			$start_date = date_create($value['created_at']);
			$end_date = date_create(date('Y-m-d H:i:s'));
			$diff = date_diff($start_date, $end_date);
			if ($diff->format("%a days") > 0) { // lebih dari 1 hari
				$this->deposit_model->update(array('updated_at' => date('Y-m-d H:i:s'), 'status' => 'Canceled'), array('id' => $value['id']));
				print('request exp');
				print('<br />');
				continue;
			}
		}
	}

	public function benefit()
	{
		$user = $this->user_model->get_rows();

		foreach ($user as $key => $value) {
			$order = $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah', 'where' => [['user_id' => $value['id']]]]);
			$total_order = $order[0]['rupiah'];

			$trx_silver = benefit('trx', 'Silver'); // value 0
			$trx_gold = benefit('trx', 'Gold'); //value 15000000
			$trx_platinum = benefit('trx', 'Platinum'); // value 30000000
			$trx_diamond = benefit('trx', 'Diamond'); // value 50000000

			// Inisialisasi nilai default
			$data_update = 'Silver';

			if ($total_order >= $trx_diamond) {
				$data_update = 'Diamond';
			} elseif ($total_order >= $trx_platinum) {
				$data_update = 'Platinum';
			} elseif ($total_order >= $trx_gold) {
				$data_update = 'Gold';
			}

			$this->user_model->update(['benefit' => $data_update], ['id' => $value['id']]);

			// Menggunakan print dengan pemisah <br>
			print "$value[username] - $data_update<br>";
		}
	}

	public function versi()
	{

		echo phpversion();
	}
	
}