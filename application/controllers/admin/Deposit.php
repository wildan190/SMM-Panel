<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposit extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_cookie_admin(get_cookie('admin_login'));
		if (admin() == false)
			exit(redirect(base_url('admin/auth/logout')));
	}
	public function report()
	{
		if ($this->input->get('date')) {
			$date_range = explode(" to ", $this->input->get('date'));

			if (count($date_range) == 2) {
				// Jika ada dua bagian setelah dipecah, maka gunakan sebagai rentang tanggal
				$start = date('Y-m-d', strtotime($date_range[0]));
				$end = date('Y-m-d', strtotime($date_range[1]));
			} else {
				// Jika tidak sesuai format, atur tanggal awal dan akhir ke bulan ini
				$start = date('Y-m-01');
				$end = date('Y-m-t');
			}
		} else {
			// Jika parameter 'date' tidak ada, atur tanggal awal ke tanggal 1 dan akhir ke tanggal saat ini
			$start = date('Y-m-01');
			$end = date('Y-m-d');
		}

		$widget = [
			'pending' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Pending', 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
			'success' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Success', 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
			'canceled' => $this->deposit_model->get_rows(['select' => 'SUM(amount) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Canceled', 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
		];
		$chart_item = $this->lib->list_date_range($start, $end);
		$chart = [];
		foreach ($chart_item as $key => $value) {
			array_push($chart, [
				'date' => $this->lib->format_chart($value),
				'all' => (int) $this->deposit_model->get_count(['where' => [['DATE(created_at)' => $value]]]),
				'success' => (int) $this->deposit_model->get_count(['where' => [['status' => 'Success', 'DATE(created_at)' => $value]]]),
				'pending' => (int) $this->deposit_model->get_count(['where' => [['status' => 'Pending', 'DATE(created_at)' => $value]]]),
				'canceled' => (int) $this->deposit_model->get_count(['where' => [['status' => 'Canceled', 'DATE(created_at)' => $value]]]),
			]);
		}

		$this->render_admin('admin/' . $this->uri->segment(2) . '/report', ['widget' => $widget, 'chart' => $chart, 'start' => $start, 'end' => $end]);
	}
	public function direct()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('user', 'Pengguna', 'required');
			$this->form_validation->set_rules('deposit_method', 'Metode Deposit', 'required|numeric');
			$this->form_validation->set_rules('amount', 'Jumlah', 'required|numeric');
			if ($this->form_validation->run() == true) {
				$user = $this->user_model->get_by_username($this->db->escape_str($this->input->post('user')));
				$data_input = [
					'user_id' => $user->id,
					'deposit_method_id' => $this->db->escape_str($this->input->post('deposit_method')),
					'amount' => $this->db->escape_str($this->input->post('amount')),
					'balance' => $this->db->escape_str($this->input->post('amount')),
					'status' => 'Success',
					'phone_number' => null,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];

				$deposit_method = $this->deposit_method_model->get_by_id($data_input['deposit_method_id']);
				if ($user == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Pengguna tidak ditemukan.'));
				} elseif ($deposit_method == false) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Metode deposit tidak ditemukan.'));
				} else {
					$insert_deposit = $this->deposit_model->insert($data_input);
					if ($insert_deposit) {
						$this->user_model->update([
							'balance' => $user->balance + $data_input['amount']
						], ['id' => $user->id]);
						$this->log_balance_usage_model->insert([
							'user_id' => $user->id,
							'type' => 'plus',
							'category' => 'deposit',
							'amount' => $data_input['amount'],
							'description' => 'Deposit #' . $insert_deposit . '.',
							'created_at' => date('Y-m-d H:i:s')
						]);
						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Kirim saldo berhasil!', 'msg' => '<br />Pengguna: ' . $user->username . '<br />Jumlah: Rp ' . number_format($data_input['amount'], 0, ',', '.')));
						exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/direct')));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					}
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render_admin('admin/deposit/direct', ['user' => $this->user_model->get_rows(), 'deposit_method' => $this->deposit_method_model->get_rows(['where' => [['status' => '1']]])]);
	}
	public function index()
	{
		// FORM INPUT //
		$field = [
			'deposit.id' => 'ID',
			'deposit.created_at' => 'TANGGAL/WAKTU',
			'user.username' => 'PENGGUNA',
			'deposit_method.name' => 'METODE DEPOSIT',
			'deposit.amount' => 'JUMLAH',
			'deposit.balance' => 'SALDO DIDAPAT',
			'deposit.status' => 'STATUS',
		];
		$operator = [
			'equal' => 'WHERE =',
			'not_equal' => 'WHERE <>',
			'less_than' => 'WHERE <=',
			'more_than' => 'WHERE >=',
			'like' => 'LIKE %value%'
		];
		$status = [
			'Pending' => ['name' => 'Pending', 'color' => 'warning'],
			'Success' => ['name' => 'Success', 'color' => 'success'],
			'Canceled' => ['name' => 'Canceled', 'color' => 'danger'],
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'deposit.*, user.username, deposit_method.name AS deposit_method_name',
			'join' => [
				[
					'table' => 'user',
					'on' => 'user.id = deposit.user_id',
					'param' => 'inner'
				],
				[
					'table' => 'deposit_method',
					'on' => 'deposit_method.id = deposit.deposit_method_id',
					'param' => 'inner'
				]
			],
			'order_by' => 'deposit.id DESC',
			'limit' => '30',
			'offset' => ($this->uri->segment(4)) ? $this->uri->segment(4) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('sort_field') <> '' and $this->input->get('sort_type') <> '') {
			if (array_key_exists($this->input->get('sort_field'), $field) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			if (in_array($this->input->get('sort_type'), array('asc', 'desc')) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			$data_query['order_by'] = $this->input->get('sort_field') . ' ' . $this->input->get('sort_type');
		}
		if ($this->input->get('field') <> '' and $this->input->get('operator') <> '' and $this->input->get('value') <> '') {
			if (array_key_exists($this->input->get('field'), $field) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
			if (array_key_exists($this->input->get('operator'), $operator) == false)
				exit(redirect(base_url('admin/' . $this->uri->segment(2) . '/index')));
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
		if ($this->session->userdata('filter_deposit_user') <> '') {
			$data_query['where'][]['deposit.user_id'] = $this->session->userdata('filter_deposit_user');
		}
		if ($this->session->userdata('filter_deposit_deposit_method') <> '') {
			$data_query['where'][]['deposit.deposit_method_id'] = $this->session->userdata('filter_deposit_deposit_method');
		}
		// END SESSION FILTER //
		// PAGINATION //
		if ($this->uri->segment(4) <> '' and is_numeric($this->uri->segment(4)) == false)
			exit('No direct script access allowed');
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->deposit_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->deposit_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator, 'status' => $status, 'user' => $this->user_model->get_rows(), 'deposit_method' => $this->deposit_method_model->get_rows()]);
	}
	public function delete($i = '')
	{
		$target = $this->deposit_model->get_by_id($i);
		if ($target == false)
			show_404();
		$delete_target = $this->deposit_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function confirm($i = '', $status = '')
	{
		$target = $this->deposit_model->get_by_id($i);
		if (!$target) {
			show_404();
		}

		if ($target->status !== 'Pending') {
			show_404();
		}

		if ($status !== '') {
			if (!in_array($status, ['Success', 'Canceled'])) {
				show_404();
			}

			$this->deposit_model->update([
				'status' => $status,
				'updated_at' => date('Y-m-d H:i:s'),
			], ['id' => $i]);
			if ($status == 'Success') {
				$user = $this->user_model->get_by_id($target->user_id);
				$this->user_model->update([
					'balance' => $user->balance + $target->balance
				], ['id' => $user->id]);
				$this->log_balance_usage_model->insert([
					'user_id' => $user->id,
					'type' => 'plus',
					'category' => 'deposit',
					'amount' => $target->balance,
					'description' => 'Deposit #' . $i . '.',
					'before' => $user->balance,
					'after' => $user->balance + $target->balance,
					'created_at' => date('Y-m-d H:i:s')
				]);
				$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Konfirmasi deposit berhasil!', 'msg' => '<br />Pengguna: ' . $user->username . '<br />Jumlah: Rp ' . number_format($target->balance, 0, ',', '.')));
				// NOTIF WA //
				$hasil = $this->deposit_model->get_row(['id' => $i]);
				$deposit_method = $this->deposit_method_model->get_row(['id' => $target->deposit_method_id]);
				$user = $this->user_model->get_by_id($target->user_id);
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
						$i,
						$deposit_method->name,
						currency($target->amount),
						currency($target->balance),
						'Canceled',
						$this->lib->format_date($hasil->created_at),
						$this->lib->format_date($hasil->updated_at)
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
						$i,
						$deposit_method->name,
						currency($target->amount),
						currency($target->balance),
						$hasil->status,
						$this->lib->format_date($hasil->created_at),
						$this->lib->format_date($hasil->updated_at)
					),
					$message1
				);
				if (website_config('send_wa_deposit') == 'on') {
					$this->lib->sendMessage($apikey, $phone, $pesan);
					$this->lib->sendMessage($apikey, $phone1, $pesan1);
				}
				// END NOTIF WA //
			} else {
				$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Konfirmasi deposit berhasil!', 'msg' => 'Deposit dibatalkan.'));
				// NOTIF WA //
				$hasil = $this->deposit_model->get_row(['id' => $i]);
				$deposit_method = $this->deposit_method_model->get_row(['id' => $target->deposit_method_id]);
				$user = $this->user_model->get_by_id($target->user_id);
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
						$i,
						$deposit_method->name,
						currency($target->amount),
						currency($target->balance),
						'Canceled',
						$this->lib->format_date($hasil->created_at),
						$this->lib->format_date($hasil->updated_at)
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
						$i,
						$deposit_method->name,
						currency($target->amount),
						currency($target->balance),
						$hasil->status,
						$this->lib->format_date($hasil->created_at),
						$this->lib->format_date($hasil->updated_at)
					),
					$message1
				);

				if (website_config('send_wa_deposit') == 'on') {
					$this->lib->sendMessage($apikey, $phone, $pesan);
					$this->lib->sendMessage($apikey, $phone1, $pesan1);
				}
				// END NOTIF WA //
			}
			exit(redirect(base_url('admin/' . $this->uri->segment(2))));
		}
		$this->load->view('admin/' . $this->uri->segment(2) . '/confirm', ['target' => $target]);
	}
	public function detail($i = '')
	{
		$i = $this->db->escape_str($i);
		$target = $this->deposit_model->get_row(['id' => $i]);

		if ($target) {
			$deposit_method = $this->deposit_method_model->get_by_id($target->deposit_method_id);
			$data['target'] = $target;
			$data['deposit_method'] = $deposit_method;

			// ambil instruksi pembayaran paydisini
			$apiKey = website_config('paydisini_api_key');
			$service = $deposit_method->gateway_code;
			$sign = md5($apiKey . $service . 'PaymentGuide');
			$post = [
				'key' => $apiKey,
				'request' => 'payment_guide',
				'service' => $service,
				'signature' => $sign
			];

			// Menggunakan library cURL yang sudah dibuat sebelumnya
			$curl = $this->lib->curlpaydisini('https://paydisini.co.id/api/', $post);

			if ($curl) {
				$json_result = json_decode($curl, true);

				if ($json_result) {
					$data['instruksi'] = $json_result;
				} else {
					// Tangani kesalahan jika gagal mendecode JSON
					$data['instruksi'] = [];
					log_message('error', 'Gagal mendecode JSON dari API paydisini');
				}

				$this->load->view('admin/' . $this->uri->segment(2) . '/detail', $data);
			} else {
				// Tangani kesalahan jika curl gagal
				show_error('Gagal melakukan permintaan ke API paydisini', 500);
			}
		} else {
			show_404(); // Tampilkan halaman 404 jika data deposit tidak ditemukan.
		}
	}
	public function status($i = '', $status = '')
	{
		$target = $this->deposit_model->get_by_id($i);
		if ($target == false)
			show_404();
		if ($target->status <> 'Pending') {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Deposit yang bisa diubah hanya berstatus <i>Pending</i>.'));
			redirect(base_url('admin/' . $this->uri->segment(2)));
		}
		if (in_array($status, ['Pending', 'Success', 'Canceled']) == false)
			show_404();
		$update_target = $this->deposit_model->update(['status' => $status], ['id' => $i]);
		if ($update_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function filter()
	{
		$deposit_method = $this->deposit_method_model->get_by_id($this->input->post('deposit_method'));
		if ($deposit_method) {
			$this->session->set_userdata('filter_deposit_deposit_method', $this->input->post('deposit_method'));
		} else {
			$this->session->unset_userdata('filter_deposit_deposit_method');
		}
		$user = $this->user_model->get_by_id($this->input->post('user'));
		if ($user) {
			$this->session->set_userdata('filter_deposit_user', $this->input->post('user'));
		} else {
			$this->session->unset_userdata('filter_deposit_user');
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
}
