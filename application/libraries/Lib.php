<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lib
{
	function __construct()
	{
		$this->ci = &get_instance();
	}
	function calculateRating($five, $four, $three, $two, $one)
	{
		$calculate = (5 * $five + 4 * $four + 3 * $three + 2 * $two + 1 * $one) / ($five + $four + $three + $two + $one);
		return substr($calculate, 0, $calculate < 0 ? 3 : 3);
	}
	function showrating($amount)
	{
		$ratings = substr($amount, 0, -2);
		$string = 'dsa';
		for ($i = 1; $i <= $ratings; $i++) {
			$string .= '<i class="fa fa-fw fa-star text-secondary"></i>';
			dd($string);
		}

		dd($string);
	}
	function dataicon($category)
    {
        $data_icon = ''; // Default icon value

        // Checking and setting the category type and icon based on category name
        if ($this->pregmatch('Instagram', $category)) {
            $data_icon = 'fab fa-instagram';
        } elseif ($this->pregmatch('Facebook', $category)) {
            $data_icon = 'fab fa-facebook';
        } elseif ($this->pregmatch('Twitter', $category)) {
            $data_icon = 'fab fa-twitter';
        } elseif ($this->pregmatch('Youtube', $category)) {
            $data_icon = 'fab fa-youtube';
        } elseif ($this->pregmatch('Spotify', $category)) {
            $data_icon = 'fab fa-spotify';
        } elseif ($this->pregmatch('Telegram', $category)) {
            $data_icon = 'fab fa-telegram';
        } elseif ($this->pregmatch('Website', $category)) {
            $data_icon = 'fas fa-globe';
        } elseif ($this->pregmatch('Website Traffic', $category)) {
            $data_icon = 'fas fa-traffic-light';
        } elseif ($this->pregmatch('Tiktok', $category) || $this->pregmatch('Tik Tok', $category)) {
            $data_icon = 'fab fa-tiktok';
        } elseif ($this->pregmatch('Reviews', $category)) {
            $data_icon = 'fas fa-star';
        } elseif ($this->pregmatch('Linkedin', $category)) {
            $data_icon = 'fab fa-linkedin';
        } elseif ($this->pregmatch('Snapchat', $category)) {
            $data_icon = 'fab fa-snapchat';
        } elseif ($this->pregmatch('SoundCloud', $category)) {
            $data_icon = 'fab fa-soundcloud';
        } elseif ($this->pregmatch('Google', $category)) {
            $data_icon = 'fab fa-google';
        } elseif ($this->pregmatch('Twitch', $category)) {
            $data_icon = 'fab fa-twitch';
        } elseif ($this->pregmatch('Threads', $category)) {
            $data_icon = 'fab fa-threads';
        } elseif ($this->pregmatch('Promo', $category)) {
            $data_icon = 'fas fa-gift';
        } elseif ($this->pregmatch('Whatsapp', $category)) {
            $data_icon = 'fab fa-whatsapp';
        } elseif ($this->pregmatch('Aplikasi', $category)) {
            $data_icon = 'fab fa-adn';
        } elseif ($this->pregmatch('Shopee', $category)) {
            $data_icon = 'fab fa-shopify';
        } elseif ($this->pregmatch('Discord', $category)) {
            $data_icon = 'fab fa-discord';
        } elseif ($this->pregmatch('SnackVideo', $category)) {
            $data_icon = 'fas fa-video';
        } elseif ($this->pregmatch('Pinterest', $category)) {
            $data_icon = 'fab fa-pinterest';
        } elseif ($this->pregmatch('Apple', $category)) {
            $data_icon = 'fab fa-apple';
        }

        return $data_icon;
    }

	function generate_api_key()
	{
		return implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6));
	}
	function sum_date($date, $parameter)
	{
		return date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($date)) . $parameter));
	}

	function pregmatch($filter, $name)
	{
		return preg_match("/" . $filter . "/i", $name);
	}
	function diff_date($date_a, $date_b)
	{
		$date_a = date_create($date_a);
		$date_b = date_create($date_b);
		$diff = date_diff($date_a, $date_b);
		return $diff->format("%R%a");
	}
	function list_date_range($start, $end, $format = 'Y-m-d')
	{
		$end = new DateTime($end);
		$end = $end->add(new DateInterval('P1D'))->format('Y-m-d');

		$period = new DatePeriod(
			new DateTime($start),
			new DateInterval('P1D'),
			new DateTime($end)
		);
		$date_list = [];
		foreach ($period as $key => $value) {
			$date_list[] = $value->format($format);
		}
		return $date_list;
	}

	function random_strings($length_of_string)
	{

		// String of all alphanumeric character
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		// Shuffle the $str_result and returns substring
		// of specified length
		return substr(
			str_shuffle($str_result),
			0,
			$length_of_string
		);
	}

	function print_data($data)
	{
		print_r('<pre>');
		print_r($data);
		print_r('</pre>');
		die;
	}
	function curlget($url, $post, $headers)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$headers == null ? curl_setopt($ch, CURLOPT_POST, 1) : curl_setopt($ch, CURLOPT_HTTPGET, 1);
		if ($headers !== null)
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$result = curl_exec($ch);
		$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
		$cookies = array();
		foreach ($matches[1] as $item) {
			parse_str($item, $cookie);
			$cookies = array_merge($cookies, $cookie);
		}
		return array(
			$header,
			$body,
			$cookies
		);
	}
	function get_between($string, $start, $end)
	{
		$string = " " . $string;
		$ini = strpos($string, $start);
		if ($ini == 0)
			return "";
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	function get_between_array($string, $start, $end)
	{
		$aa = explode($start, $string);
		for ($i = 0; $i < count($aa); $i++) {
			$su = explode($end, $aa[$i]);
			$uu[] = $su[0];
		}
		unset($uu[0]);
		$uu = array_values($uu);
		return $uu;
	}
	function curlig($url, $post, $headers)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		if ($headers !== null)
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if ($post !== null)
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($ch);
		$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
		$cookies = array();
		foreach ($matches[1] as $item) {
			parse_str($item, $cookie);
			$cookies = array_merge($cookies, $cookie);
		}
		return array(
			$header,
			$body,
			$cookies
		);
	}
	function format_datetime($a)
	{
		$month = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		];
		$split = explode(" ", $a);
		$date = explode("-", $split[0]);
		$format_date = $date[2] . ' ' . $month[$date[1]] . ' ' . $date[0];
		return $format_date . ', ' . $split[1];
	}
	function format_date($a)
	{
		$ymdhis = explode(' ', $a);
		$month = [
			1 => 'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		];
		$explode = explode('-', $ymdhis[0]);
		$formatted = $explode[2] . ' ' . $month[(int) $explode[1]] . ' ' . $explode[0];
		$format = isset($ymdhis[1]) ? $formatted . ' (' . substr($ymdhis[1], 0, 5) . ' WIB)' : $formatted;

		return $format;
	}


	function format_chart($a)
	{
		$month = [
			'01' => 'Jan',
			'02' => 'Feb',
			'03' => 'Mar',
			'04' => 'Apr',
			'05' => 'Mei',
			'06' => 'Jun',
			'07' => 'Jul',
			'08' => 'Aug',
			'09' => 'Sept',
			'10' => 'Okt',
			'11' => 'Nov',
			'12' => 'Des',
		];
		$date = explode("-", $a);
		$format_date = $date[2] . ' ' . $month[$date[1]];
		return $format_date;
	}
	function format_time($t, $f = ':')
	{ // t = seconds, f = separator  {
		return sprintf("%02d%s%02d%s%02d", floor($t / 3600), $f, ($t / 60) % 60, $f, $t % 60);
	}
	function time_elapsed_string($datetime, $full = false)
	{
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'tahun',
			'm' => 'bulan',
			'w' => 'minggu',
			'd' => 'hari',
			'h' => 'jam',
			'i' => 'menit',
			's' => 'detik',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full)
			$string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
	}
	function status_info($i)
	{
		if ($i == 'info') {
			$color = 'info';
		} elseif ($i == 'service') {
			$color = 'primary';
		} elseif ($i == 'maintenance') {
			$color = 'danger';
		} elseif ($i == 'update') {
			$color = 'warning';
		} else {
			$color = 'secondary';
		}
		return '' . strtoupper($i) . '';
	}
	function status_info_bg($i)
	{
		if ($i == 'info') {
			$color = 'info';
		} elseif ($i == 'service') {
			$color = 'success';
		} elseif ($i == 'maintenance') {
			$color = 'danger';
		} elseif ($i == 'update') {
			$color = 'warning';
		} else {
			$color = 'secondary';
		}
		return $color;
	}
	function slug($string, $spaceRepl = "-")
	{
		$string = str_replace("&", "and", $string);

		$string = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);

		$string = strtolower($string);

		$string = preg_replace("/[ ]+/", " ", $string);

		$string = str_replace(" ", $spaceRepl, $string);

		return $string;
	}
	function conv_format($num)
	{

		if ($num > 1000) {

			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array('K', 'JT', 'B', 'T');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];

			return $x_display;
		}

		return $num;
	}
	function status_ticket($i)
	{
		if ($i == 'Waiting') {
			$color = 'warning';
			$icon = 'far fa-clock fs-6 me-2';
		} elseif ($i == 'User Reply') {
			$color = 'info';
			$icon = 'far fa-clock fs-6 me-2';
		} elseif ($i == 'Responded') {
			$color = 'success';
			$icon = 'fas fa-check-circle fs-6 me-2';
		} elseif ($i == 'Closed') {
			$color = 'danger';
			$icon = 'fas fa-times-circle fs-6 me-2';
		} else {
			$color = 'secondary';
		}
		return '<span class="btn btn-sm bg-gradient btn-' . $color . '"><i class="' . $icon . '"></i>' . strtoupper($i) . '</span>';
	}
	function status_ticket_admin($i)
	{
		if ($i == 'Waiting') {
			$color = 'warning';
			$icon = 'far fa-clock fs-6 me-2';
		} elseif ($i == 'User Reply') {
			$color = 'info';
			$icon = 'far fa-clock fs-6 me-2';
		} elseif ($i == 'Responded') {
			$color = 'success';
			$icon = 'fas fa-check-circle fs-6 me-2';
		} elseif ($i == 'Closed') {
			$color = 'danger';
			$icon = 'fas fa-times-circle fs-6 me-2';
		} else {
			$color = 'secondary';
		}
		return $color;
	}
	function status_order($i)
	{
		if ($i == 'Pending') {
			$color = 'warning';
			$icon = 'far fa-clock fs-6 me-2';
		} elseif ($i == 'Processing') {
			$color = 'info';
			$icon = 'fas fa-spinner fs-6 me-2';
		} elseif ($i == 'In progress') {
			$color = 'info';
			$icon = 'fas fa-spinner fs-6 me-2';
		} elseif ($i == 'Completed' || $i == 'Success') {
			$color = 'success';
			$icon = 'fas fa-check-circle fs-6 me-2';
		} elseif ($i == 'Canceled' || $i == 'Error' || $i == 'Partial' || $i == 'Refund') {
			$color = 'danger';
			$icon = 'fas fa-times-circle fs-6 me-2';
		} elseif ($i == 'Unpaid') {
			$color = 'dark';
			$icon = 'fas fa-times-circle fs-6 me-2';
		} else {
			$color = 'secondary';
			$icon = 'fas fa-times-circle fs-6 me-2';
		}
		return '<span class="btn btn-sm bg-gradient btn-' . $color . '"><i class="' . $icon . '"></i>' . $i . '</span>';
	}
	function status_order_admin($i)
	{
		if ($i == 'Pending') {
			$color = 'warning';
			$icon = 'far fa-clock fs-6 me-2';
		} elseif ($i == 'Processing') {
			$color = 'info';
			$icon = 'fas fa-spinner fs-6 me-2';
		} elseif ($i == 'In progress') {
			$color = 'info';
			$icon = 'fas fa-spinner fs-6 me-2';
		} elseif ($i == 'Completed' || $i == 'Success') {
			$color = 'success';
			$icon = 'fas fa-check-circle fs-6 me-2';
		} elseif ($i == 'Canceled' || $i == 'Error' || $i == 'Partial' || $i == 'Refund') {
			$color = 'danger';
			$icon = 'fas fa-times-circle fs-6 me-2';
		} elseif ($i == 'Unpaid') {
			$color = 'dark';
			$icon = 'fas fa-times-circle fs-6 me-2';
		} else {
			$color = 'secondary';
			$icon = 'fas fa-times-circle fs-6 me-2';
		}
		return '<button class="btn btn-sm bg-gradient btn-' . $color . ' dropdown-toggle-split" type="button"><i class="' . $icon . '"></i>' . $i . '</button>';
	}
	function status_order_bg($i)
	{
		if ($i == 'Pending') {
			$color = 'warning';
		} elseif ($i == 'Processing') {
			$color = 'info';
		} elseif ($i == 'In progress') {
			$color = 'info';
		} elseif ($i == 'Completed' || $i == 'Success') {
			$color = 'success';
		} elseif ($i == 'Canceled' || $i == 'Error' || $i == 'Partial' || $i == 'Refund') {
			$color = 'danger';
		} elseif ($i == 'Unpaid') {
			$color = 'dark';
		} else {
			$color = 'secondary';
		}
		return $color;
	}
	function table_order($i)
	{
		if ($i == 'Pending') {
			$color = 'warning';
		} elseif ($i == 'Processing') {
			$color = 'info';
		} elseif ($i == 'In progress') {
			$color = 'info';
		} elseif ($i == 'Completed' || $i == 'Success') {
			$color = 'success';
		} elseif ($i == 'Canceled' || $i == 'Partial' || $i == 'Refund') {
			$color = 'danger';
		} else {
			$color = 'secondary';
		}
		return 'class="table-' . $color . '"';
	}
	function status_deposit($i)
	{
		if ($i == 'Pending') {
			$color = 'warning';
			$icon = 'far fa-clock fs-6 me-2';
		} elseif ($i == 'Processing') {
			$color = 'info';
			$icon = 'fas fa-spinner fs-6 me-2';
		} elseif ($i == 'In progress') {
			$color = 'info';
			$icon = 'fas fa-spinner fs-6 me-2';
		} elseif ($i == 'Completed' || $i == 'Success') {
			$color = 'success';
			$icon = 'fas fa-check-circle fs-6 me-2';
		} elseif ($i == 'Canceled' || $i == 'Error' || $i == 'Partial' || $i == 'Refund') {
			$color = 'danger';
			$icon = 'fas fa-times-circle fs-6 me-2';
		} elseif ($i == 'Unpaid') {
			$color = 'dark';
			$icon = 'fas fa-times-circle fs-6 me-2';
		} else {
			$color = 'secondary';
			$icon = 'fas fa-times-circle fs-6 me-2';
		}
		return '<span class="btn btn-sm bg-gradient btn-' . $color . '"><i class="' . $icon . '"></i>' . $i . '</span>';
	}
	function curl($end_point, $post = '', $header = null, $method = 'POST')
	{
		$_post = [];
		if (is_array($post)) {
			foreach ($post as $name => $value) {
				$_post[] = $name . '=' . urlencode($value);
			}
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $end_point);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
		curl_setopt($ch, CURLOPT_TIMEOUT, 240); // 4 mnt
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		if ($header !== null) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		if ($post !== '') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			if (is_array($post)) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			} else {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			}
		}
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		$result = curl_exec($ch);
		if (curl_errno($ch) != 0 && empty($result)) {
			return false;
		}
		curl_close($ch);
		return $result;
	}

	function testcurl($end_point, $post)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $end_point);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
		$headers = array();
		$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.5249.91 Safari/537.36';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch) != 0 && empty($result)) {
			return false;
		}
		curl_close($ch);
		return $result;
	}
	function curlpaydisini($end_point, $post = '', $header = null, $method = 'POST')
	{
		$_post = [];

		// Merubah data menjadi query string jika berupa array
		if (is_array($post)) {
			$post = http_build_query($post);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $end_point . '?' . $post); // Menambahkan data ke URL
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
		curl_setopt($ch, CURLOPT_TIMEOUT, 240); // 4 mnt
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		if ($header <> null) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		if ($post <> '') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			if (is_array($post)) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
			} else {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			}
		}
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.5249.91 Safari/537.36');
		$result = curl_exec($ch);
		if (curl_errno($ch) != 0 && empty($result)) {
			return false;
		}
		curl_close($ch);
		return $result;
	}

	function encrypt_decrypt($action, $string)
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'heruc0d3';
		$secret_iv = 'herudev';
		// hash
		$key = hash('sha256', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'encrypt') {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if ($action == 'decrypt') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

	function timeProcess($start, $end, $shennsana = false)
	{
		if ($start === $end) {
			return '0 detik';
		} else {
			$diff = abs(strtotime($end) - strtotime($start));

			$years = floor($diff / (365 * 24 * 60 * 60));
			$months = floor(($diff - $years * 365 * 24 * 60 * 60) / (30 * 24 * 60 * 60));
			$days = floor(($diff - $years * 365 * 24 * 60 * 60 - $months * 30 * 24 * 60 * 60) / (24 * 60 * 60));
			$hours = floor(($diff - $years * 365 * 24 * 60 * 60 - $months * 30 * 24 * 60 * 60 - $days * 24 * 60 * 60) / (60 * 60));
			$minutes = floor(($diff - $years * 365 * 24 * 60 * 60 - $months * 30 * 24 * 60 * 60 - $days * 24 * 60 * 60 - $hours * 60 * 60) / 60);
			$seconds = $diff % 60;

			$timeUnits = array(
				"tahun" => $years,
				"bulan" => $months,
				"hari" => $days,
				"jam" => $hours,
				"menit" => $minutes
			);

			$resultArray = array();
			foreach ($timeUnits as $unit => $value) {
				if ($value > 0) {
					$resultArray[] = "$value $unit";
				}
			}

			// Tambahkan detik hanya jika hasilnya kurang dari 1 menit
			if ($minutes == 0) {
				$resultArray[] = "$seconds detik";
			}

			$result = implode(", ", $resultArray);

			return $result;
		}
	}

	function day($date)
	{
		$hari = date('D M j Y H:i:s', $date);
		$split = explode(" ", $hari);
		switch ($split[0]) {
			case 'Sun':
				$hari_ini = "Minggu";
				break;
			case 'Mon':
				$hari_ini = "Senin";
				break;
			case 'Tue':
				$hari_ini = "Selasa";
				break;
			case 'Wed':
				$hari_ini = "Rabu";
				break;
			case 'Thu':
				$hari_ini = "Kamis";
				break;
			case 'Fri':
				$hari_ini = "Jumat";
				break;
			case 'Sat':
				$hari_ini = "Sabtu";
				break;
			default:
				$hari_ini = "Tidak di ketahui";
				break;
		}
		$month = [
			'Jan' => 'Januari',
			'Feb' => 'Februari',
			'Mar' => 'Maret',
			'Apr' => 'April',
			'Mei' => 'Mei',
			'Jun' => 'Juni',
			'Jul' => 'Juli',
			'Aug' => 'Agustus',
			'Sep' => 'September',
			'Oct' => 'Oktober',
			'Nov' => 'November',
			'Dec' => 'Desember',
		];
		$date = explode(" ", $hari);
		$pecahmenit = explode(":", $date[4]);
		$format_date = $hari_ini . ', ' . $split[2] . ' ' . $month[$date[1]] . ' ' . $split[3] . ' - ' . $pecahmenit[0] . ':' . $pecahmenit[1];

		echo $format_date;
	}
	function hp($nohp)
	{
		// Hapus spasi dan karakter tidak diperlukan
		$nohp_cleaned = preg_replace('/[^+0-9]/', '', trim($nohp));

		if ($nohp_cleaned) {
			if (substr($nohp_cleaned, 0, 1) == '0') {
				// Jika dimulai dengan '0', hilangkan '0' dan tambahkan '62'
				$nohp_cleaned = '62' . substr($nohp_cleaned, 1);
			} elseif (substr($nohp_cleaned, 0, 2) != '62') {
				// Jika tidak dimulai dengan '62', tambahkan '62' di depan
				$nohp_cleaned = '62' . $nohp_cleaned;
			}
		}

		return $nohp_cleaned; // Mengembalikan nomor setelah diproses
	}


	function nohp($nohp)
	{
		$hp = $nohp;
		if (!preg_match('/[^+0-9]/', trim($nohp))) {
			if (substr(trim($nohp), 0, 1) == '0') {
				$hp = trim($nohp);
			} else if (substr(trim($nohp), 0, 2) == '62') {
				$hp = '0' . substr(trim($nohp), 2);
			}
		}

		return $hp;
	}


	private function connect($x, $n = '')
	{
		$ch = curl_init();
// 		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($x));
		curl_setopt($ch, CURLOPT_URL, website_config('wa_endpoint') . $n);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return json_decode($result, true);
	}

	public function sendMessage($apikey, $phone, $msg)
	{
		return $this->connect([
			'api_key' => website_config('wa_app_key'),
			"sender" => website_config('wa_auth_key'),
			'number' => $phone,
			'message' => $msg
		], 'send-message');
	}

	public function sendPicture($phone, $msg, $file)
	{
		return $this->connect([
			'api_key' => website_config('wa_app_key'),
			"sender" => website_config('wa_auth_key'),
			'number' => $phone,
			'message' => $msg
		], 'send-message');
	}

	function tanggal_indonesia($tanggal)
	{
		$hari_ini = date('Y-m-d');
		$kemarin = date('Y-m-d', strtotime('-1 day', strtotime($hari_ini)));
		$split = explode(" ", $tanggal);

		if ($split[0] == $hari_ini) {
			return 'Hari ini, ' . date('H:i', strtotime($tanggal)) . ' WIB';
		} elseif ($split[0] == $kemarin) {
			return 'Kemarin, ' . date('H:i', strtotime($tanggal)) . ' WIB';
		} else {

			// Daftar nama hari dalam bahasa Indonesia
			$nama_hari = array(
				'Minggu',
				'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu'
			);

			// Ubah format tanggal dari 'Y-m-d' (default) menjadi 'd F Y, Nama Hari'
			$bulan = array(
				1 => 'Jan',
				'Feb',
				'Mar',
				'Apr',
				'Mei',
				'Jun',
				'Jul',
				'Agu',
				'Sep',
				'Okt',
				'Nov',
				'Des'
			);
			$split = explode(" ", $tanggal);
			$date = explode("-", $split[0]);
			$bulan_indonesia = $bulan[(int) $date[1]];
			$nama_hari_indonesia = $nama_hari[date('w', strtotime($tanggal))];

			return $nama_hari_indonesia . ', ' . $date[2] . ' ' . $bulan_indonesia . ' ' . $date[0] . ' - ' . date('H:i', strtotime($tanggal)) . ' WIB';
		}
	}
	function tgl_indo($tanggal)
	{
		$hari_ini = date('Y-m-d');
		$kemarin = date('Y-m-d', strtotime('-1 day', strtotime($hari_ini)));
		$split = explode(" ", $tanggal);

		if ($split[0] == $hari_ini) {
			return 'Hari ini';
		} elseif ($split[0] == $kemarin) {
			return 'Kemarin';
		} else {

			// Daftar nama hari dalam bahasa Indonesia
			$nama_hari = array(
				'Minggu',
				'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu'
			);

			// Ubah format tanggal dari 'Y-m-d' (default) menjadi 'd F Y, Nama Hari'
			$bulan = array(
				1 => 'Jan',
				'Feb',
				'Mar',
				'Apr',
				'Mei',
				'Jun',
				'Jul',
				'Agu',
				'Sep',
				'Okt',
				'Nov',
				'Des'
			);
			$split = explode(" ", $tanggal);
			$date = explode("-", $split[0]);
			$bulan_indonesia = $bulan[(int) $date[1]];
			$nama_hari_indonesia = $nama_hari[date('w', strtotime($tanggal))];

			return $nama_hari_indonesia . ', ' . $date[2] . ' ' . $bulan_indonesia . ' ' . $date[0] . '';
		}
	}
	function waktu_indonesia($a)
	{
		$ymdhis = explode(' ', $a);
		$format = isset($ymdhis[1]) ? substr($ymdhis[1], 0, 5) : '';

		return $format;
	}
	private function connect_tele($x, $n = '')
	{
		// $bot_token = '1388970112:AAEzPqQR9UXeUrFPUdKIlDx-3RBrVt7-6xI';
		// $api_url = 'https://api.telegram.org/bot1388970112:AAEzPqQR9UXeUrFPUdKIlDx-3RBrVt7-6xI/';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($x));
		curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot7183184647:/' . $n);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result, true);
	}

	public function kirim_pesan_tele($chat_id, $pesan_tele, $message_thread_id)
	{
		return $this->connect_tele([
			'chat_id' => $chat_id,
			'text' => $pesan_tele,
			'parse_mode' => 'HTML',
			'message_thread_id' => $message_thread_id
			// Memanfaatkan message_thread_id untuk membalas pesan?
		], 'sendMessage');
	}
	function replaceKeywords($text, $replacements)
	{
		foreach ($replacements as $replacement) {
			$text = str_replace($replacement['name'], $replacement['target'], $text);
		}
		return $text;
	}
}
