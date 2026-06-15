<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MY_Controller
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
			'gross' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(price) AS total', 'where' => [['DATE(created_at) >=' => $start, 'DATE(created_at) <=' => $end]]]),
			'net' => $this->order_model->get_rows(['select' => 'SUM(profit) AS rupiah, COUNT(profit) AS total', 'where' => [['DATE(created_at) >=' => $start, 'DATE(created_at) <=' => $end]]]),
			'gross_success' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(price) AS total', 'where' => [['status' => 'Success', 'DATE(created_at) >=' => $start, 'DATE(created_at) <=' => $end]]]),
			'net_success' => $this->order_model->get_rows(['select' => 'SUM(profit) AS rupiah, COUNT(profit) AS total', 'where' => [['status' => 'Success', 'DATE(created_at) >=' => $start, 'DATE(created_at) <=' => $end]]]),
			'gross_error' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(price) AS total', 'where' => [['status' => 'Error', 'DATE(created_at) >=' => $start, 'DATE(created_at) <=' => $end]]]),
			'net_error' => $this->order_model->get_rows(['select' => 'SUM(profit) AS rupiah, COUNT(profit) AS total', 'where' => [['status' => 'Error', 'DATE(created_at) >=' => $start, 'DATE(created_at) <=' => $end]]]),
			'pending' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Pending', 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
			'processing' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Processing', 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
			'success' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Success', 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
			'error' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Error', 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
			'partial' => $this->order_model->get_rows(['select' => 'SUM(price) AS rupiah, COUNT(id) AS total', 'where' => [['status' => 'Partial', 'DATE(created_at) >=' => $this->db->escape_str($start), 'DATE(created_at) <=' => $this->db->escape_str($end)]]]),
		];
		$chart_item = $this->lib->list_date_range($start, $end);
		$chart = [];
		foreach ($chart_item as $key => $value) {
			array_push($chart, [
				'date' => $this->lib->format_chart($value),
				'all' => (int) $this->order_model->get_count(['where' => [['DATE(created_at)' => $value]]]),
				'success' => (int) $this->order_model->get_count(['where' => [['status' => 'Success', 'DATE(created_at)' => $value]]]),
				'pending' => (int) $this->order_model->get_count(['where' => [['status' => 'Pending', 'DATE(created_at)' => $value]]]),
				'processing' => (int) $this->order_model->get_count(['where' => [['status' => 'Processing', 'DATE(created_at)' => $value]]]),
				'error' => (int) $this->order_model->get_count(['where' => [['status' => 'Error', 'DATE(created_at)' => $value]]]),
				'partial' => (int) $this->order_model->get_count(['where' => [['status' => 'Partial', 'DATE(created_at)' => $value]]]),
			]);
		}

		$this->render_admin('admin/' . $this->uri->segment(2) . '/report', ['widget' => $widget, 'chart' => $chart, 'start' => $start, 'end' => $end]);
	}

	public function tes($huruf)
	{
		echo $this->lib->format_datetime(date('Y-m-d H:i:s'));
		echo $huruf;
	}
	public function index()
	{
		// FORM INPUT //
		$field = [
			'order_list.id' => 'ID',
			'order_list.api_order_id' => 'ID PROVIDER',
			'order_list.created_at' => 'TANGGAL/WAKTU',
			'user.username' => 'PENGGUNA',
			'service.name' => 'LAYANAN',
			'order_list.target' => 'TARGET',
			'order_list.quantity' => 'JUMLAH',
			'order_list.price' => 'HARGA',
			'order_list.status' => 'STATUS',
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
			'Processing' => ['name' => 'Processing', 'color' => 'info'],
			'Success' => ['name' => 'Success', 'color' => 'success'],
			'Partial' => ['name' => 'Partial', 'color' => 'danger'],
			'Error' => ['name' => 'Error', 'color' => 'danger'],
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => 'order_list.*, user.username, service.name AS service_name',
			'join' => [
				[
					'table' => 'user',
					'on' => 'user.id = order_list.user_id',
					'param' => 'LEFT'
				],
				[
					'table' => 'service',
					'on' => 'service.id = order_list.service_id',
					'param' => 'LEFT'
				]
			],
			'where' => [['order_list.target <>' => 'bot_fake_order'], ($this->input->get('status')) ? ['order_list.status' => $this->input->get('status')] : ['order_list.status <>' => 'HERUSUANDANA']],
			'order_by' => 'order_list.id DESC',
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
		if ($this->session->userdata('filter_order_user') <> '') {
			$data_query['where'][]['order_list.user_id'] = $this->session->userdata('filter_order_user');
		}
		if ($this->session->userdata('filter_order_status') <> '') {
			$data_query['where'][]['order_list.status'] = $this->session->userdata('filter_order_status');
		}
		if ($this->session->userdata('filter_order_service') <> '') {
			$data_query['where'][]['order_list.service_id'] = $this->session->userdata('filter_order_service');
		}
		if ($this->session->userdata('filter_order_api') <> '') {
			$data_query['where'][]['order_list.api_id'] = $this->session->userdata('filter_order_api');
		}
		// END SESSION FILTER //
		// PAGINATION //
		if ($this->uri->segment(4) <> '' and is_numeric($this->uri->segment(4)) == false)
			exit('No direct script access allowed');
		$config['base_url'] = base_url('admin/' . $this->uri->segment(2) . '/index');
		$config['total_rows'] = $this->order_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/index', ['table' => $this->order_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'field' => $field, 'operator' => $operator, 'status' => $status, 'user' => $this->user_model->get_rows(), 'service' => $this->service_model->get_rows(), 'api' => $this->api_model->get_rows()]);
	}
	public function mass_form()
	{
		$service_keys = $this->input->post('id');
		$status = $this->input->post('status');
		$start_count = $this->input->post('start_count');
		$remains = $this->input->post('remains');
		for ($i = 0; $i < count($service_keys); $i++) {
			$this->db->trans_start();
			$this->order_model->update([
				'status' => $status[$i],
				'start_count' => $start_count[$i],
				'remains' => $remains[$i],
			], ['id' => $service_keys[$i]]);
			$this->db->trans_complete();

			if ($status[$i] == 'Success') {
				// Mengambil data order
				$order = $this->order_model->get_by_id($service_keys[$i]);
				// Mengambil informasi user & referral
				$user = $this->user_model->get_row(['id' => $order->user_id]); // Pengorder
				$check_referral = $this->user_model->get_row(['id' => $user->uplink]); // Pendapat komisi

				// Mengambil rate referral berdasarkan level benefit user
				$rate_referral = website_config('referral_rate_' . strtolower($check_referral->benefit) . '');
				$referral_calculate = ($order->price * $rate_referral) / 100;

				// Menyimpan log referral & update saldo komisi user
				if ($order->price != 0 && $check_referral->referral_status != 0 && $user->id != $check_referral->uplink && website_config('referral_status') != 0) {

					$data_insert = [
						'user_id' => $check_referral->id,
						'rate' => $rate_referral,
						'amount' => $referral_calculate,
						'description' => '' . $user->full_name . ' melakukan Pemesanan - Rp ' . currency($order->price) . '',
						'created_at' => date('Y-m-d H:i:s')
					];

					$this->referral_log_model->insert($data_insert);

					// Update saldo komisi user
					$this->user_model->update(['referral_saldo' => $check_referral->referral_saldo + $referral_calculate], ['id' => $check_referral->id]);
				}

				// Update point benefit user
				if ($order->price != 0) {
					$awal_progress = $user->benefit_progress; // sisah transaksi user
					$awal_point = $user->benefit_point; // awal point sebelum melakukan penambahan point
					$total_order = $awal_progress + $order->price; // total transaksi

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
			}
		}
		$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data berhasil diperbaharui.'));
		exit(redirect(base_url('admin/' . $this->uri->segment(2))));
	}

	public function mass_edit()
	{
		$status = [
			'Pending' => ['name' => 'Pending', 'color' => 'warning'],
			'Processing' => ['name' => 'Processing', 'color' => 'info'],
			'Success' => ['name' => 'Success', 'color' => 'success'],
			'Partial' => ['name' => 'Partial', 'color' => 'danger'],
			'Error' => ['name' => 'Error', 'color' => 'danger'],
		];

		$data = explode(",", $this->input->post('list_id'));
		$this->db->select('*');
		$this->db->from('order_list');
		$this->db->where_in('id', $data);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		$data_order = $query->result_array();
		$this->render_admin('admin/' . $this->uri->segment(2) . '/mass_edit', ['target' => $data_order, 'status' => $status]);
	}

	public function form($i = '')
	{
		$target = $this->order_model->get_by_id($i);
		if ($target == false) {
			show_404();
		} else { // edit
			$status = [
				'Pending' => ['name' => 'Pending', 'color' => 'warning'],
				'Processing' => ['name' => 'Processing', 'color' => 'info'],
				'Success' => ['name' => 'Success', 'color' => 'success'],
				'Partial' => ['name' => 'Partial', 'color' => 'secondary'],
				'Refund' => ['name' => 'Refund', 'color' => 'danger'],
				'Error' => ['name' => 'Error', 'color' => 'danger'],
			];

			if ($this->input->post()) {
				$this->form_validation->set_rules('start_count', 'Jumlah Awal', 'required|numeric');
				$this->form_validation->set_rules('remains', 'Jumlah Kurang', 'required|numeric');
				$this->form_validation->set_rules('status', 'Status', 'required');
				if ($this->form_validation->run() == true) {
					$data_input = [
						'start_count' => $this->db->escape_str($this->input->post('start_count')),
						'remains' => $this->db->escape_str($this->input->post('remains')),
						'status' => $this->db->escape_str($this->input->post('status')),
						'api_order_id' => ($this->input->post('mass_status') == null ? $this->db->escape_str($this->input->post('api_order_id')) : $this->input->post('mass_status')),
						'updated_at' => date('Y-m-d H:i:s')
					];
					$update_target = $this->order_model->update($data_input, ['id' => $i]);
					if ($update_target) {
						if ($data_input['status'] == 'Success') {
							// Mengambil data order
							$order = $this->order_model->get_by_id($i);
							// Mengambil informasi user & referral
							$user = $this->user_model->get_row(['id' => $order->user_id]); // Pengorder
							$check_referral = $this->user_model->get_row(['id' => $user->uplink]); // Pendapat komisi

							// Mengambil rate benefit berdasarkan level benefit user
							$rate_benefit = website_config('referral_rate_' . $check_referral->benefit . '');
							$referral_calculate = ($order->price * $rate_benefit) / 100;

							// Menyimpan log referral & update saldo komisi user
							if ($order->price != 0 && $check_referral->referral_status != 0 && $user->id != $check_referral->uplink && website_config('referral_status') != 0) {

								$data_insert = [
									'user_id' => $check_referral->id,
									'rate' => $rate_benefit,
									'amount' => $referral_calculate,
									'description' => '' . $user->full_name . ' melakukan Pemesanan - Rp ' . currency($order->price) . '',
									'created_at' => date('Y-m-d H:i:s')
								];

								$this->referral_log_model->insert($data_insert);

								// Update saldo komisi user
								$this->user_model->update(['referral_saldo' => $check_referral->referral_saldo + $referral_calculate], ['id' => $check_referral->id]);
							}

							// Update point benefit user
							if ($order->price != 0) {
								$awal_progress = $user->benefit_progress; // sisah transaksi user
								$awal_point = $user->benefit_point; // awal point sebelum melakukan penambahan point
								$total_order = $awal_progress + $order->price; // total transaksi

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
						}

						$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diperbaharui.'));
					} else {
						$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					}
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				}
				exit(redirect(base_url('admin/' . $this->uri->segment(2))));
			}
			$this->load->view('admin/' . $this->uri->segment(2) . '/edit', ['target' => $target, 'status' => $status]);
		}
	}
	public function delete($i = '')
	{
		$target = $this->order_model->get_by_id($i);
		if ($target == false)
			show_404();
		$delete_target = $this->order_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Hapus data berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function order($i = '')
	{
		$target = $this->order_model->get_rows(['status' => $i]);
		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target, 'user' => $this->user_model->get_by_id($target->user_id), 'service' => $this->service_model->get_by_id($target->service_id), 'api' => $this->api_model->get_by_id($target->api_id)]);
	}
	public function detail($i = '')
	{
		$target = $this->order_model->get_by_id($i);
		if ($target == false)
			show_404();
		$this->load->view('admin/' . $this->uri->segment(2) . '/detail', ['target' => $target, 'user' => $this->user_model->get_by_id($target->user_id), 'service' => $this->service_model->get_by_id($target->service_id), 'api' => $this->api_model->get_by_id($target->api_id)]);
	}
	public function status($i = '', $status = '')
	{
		$target = $this->order_model->get_by_id($i);
		$status = str_replace('%20', ' ', $status);
		if ($target == false)
			show_404();
		if (in_array($status, ['Pending', 'In progress', 'Processing', 'Success', 'Error', 'Partial',]) == false)
			show_404();
		$update_target = $this->order_model->update(['status' => $status], ['id' => $i]);
		if ($update_target) {
			if ($status == 'Success') {
				// Mengambil data order
				$order = $this->order_model->get_by_id($i);
				// Mengambil informasi user & referral
				$user = $this->user_model->get_row(['id' => $order->user_id]); // Pengorder
				$check_referral = $this->user_model->get_row(['id' => $user->uplink]); // Pendapat komisi

				// Mengambil rate benefit berdasarkan level benefit user
				$rate_benefit = website_config('referral_rate_' . strtolower($check_referral->benefit) . '');
				$referral_calculate = ($order->price * $rate_benefit) / 100;

				// Menyimpan log referral & update saldo komisi user
				if ($order->price != 0 && $check_referral->referral_status != 0 && $user->id != $check_referral->uplink && website_config('referral_status') != 0) {

					$data_insert = [
						'user_id' => $check_referral->id,
						'rate' => $rate_benefit,
						'amount' => $referral_calculate,
						'description' => '' . $user->full_name . ' melakukan Pemesanan - Rp ' . currency($order->price) . '',
						'created_at' => date('Y-m-d H:i:s')
					];

					$this->referral_log_model->insert($data_insert);

					// Update saldo komisi user
					$this->user_model->update(['referral_saldo' => $check_referral->referral_saldo + $referral_calculate], ['id' => $check_referral->id]);
				}

				// Update point benefit user
				if ($order->price != 0) {
					$awal_progress = $user->benefit_progress; // sisah transaksi user
					$awal_point = $user->benefit_point; // awal point sebelum melakukan penambahan point
					$total_order = $awal_progress + $order->price; // total transaksi

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
			}
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan status berhasil!', 'msg' => 'Data <b>#' . $i . '</b> berhasil diubah.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}

	public function filter()
	{
		$api = $this->api_model->get_by_id($this->input->post('api'));
		if ($api) {
			$this->session->set_userdata('filter_order_api', $this->input->post('api'));
		} else {
			$this->session->unset_userdata('filter_order_api');
		}
		$service = $this->service_model->get_by_id($this->input->post('service'));
		if ($service) {
			$this->session->set_userdata('filter_order_service', $this->input->post('service'));
		} else {
			$this->session->unset_userdata('filter_order_service');
		}
		$status = $this->order_model->get_rows(['status' => $this->input->post('status')]);
		if ($status) {
			$this->session->set_userdata('filter_order_status', $this->input->post('status'));
		} else {
			$this->session->unset_userdata('filter_order_status');
		}
		$user = $this->user_model->get_by_id($this->input->post('user'));
		if ($user) {
			$this->session->set_userdata('filter_order_user', $this->input->post('user'));
		} else {
			$this->session->unset_userdata('filter_order_user');
		}
		redirect(base_url('admin/' . $this->uri->segment(2)));
	}
	public function monitoring()
	{
		if ($this->session->userdata('login') == false)
			exit(redirect(base_url()));
		// SETTINGS //
		$data_query = [
			'select' => 'order_list.*, service.name AS service_name',
			'join' => [
				[
					'table' => 'service',
					'on' => 'service.id = order_list.service_id',
					'param' => 'LEFT'
				]
			],
			'order_by' => 'order_list.id DESC',
			'where' => [['order_list.status' => 'Success']],
			'limit' => '100',
		];
		$data_query['where'][] = ['user_id <>' => '1'];
		// END PAGINATION //
		$this->render_admin('admin/' . $this->uri->segment(2) . '/monitoring', ['table' => $this->order_model->get_rows($data_query)]);
	}

	public function refill($i = '', $csrf = '')
	{
		// filter input = 1
		if ($csrf <> $this->security->get_csrf_hash())
			exit(show_404());
		$i = $this->db->escape_str($i);
		$target = $this->order_model->get_row(['id' => $i]);
		if ($target == false) {
			show_404();
		} else {
			$data_input = [
				'user_id' => $target->user_id,
				'order_id' => $target->id,
				'api_id' => $target->api_id,
				'service' => $target->service,
				'target' => $target->target,
				'status' => 'Pending',
				'api_refill_id' => 0,
				// reset
				'api_log_refill' => 0,
				// reset
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
			if (time() > strtotime($target->next_refill)) {

				$api = $this->api_model->get_by_id($target->api_id);
				if ($api == false) {
					print('API False');
				}
				// END CHECK API //
				$provider_order_id = false;
				if ($api->is_manual == '1') {
					$provider_order_id = true;
				} else {
					// CHECK API ORDER //
					$api_refill = $this->api_refill_model->get_row(['api_id' => $target->api_id]);
					if ($api_refill == false) {
						print('API Refill False');
						die;
					}
					// END CHECK API ORDER //
					$params = [];
					$api_request_param = $this->db->get_where('api_request_param', ['api_id' => $target->api_id, 'api_type' => 'refill']);
					//$this->lib->print_data($api_request_param);
					if (!empty($api_request_param)) {
						foreach ($api_request_param->result_array() as $row) {

							if ($row['param_type'] === 'custom') {

								$params[$row['param_key']] = $row['param_value'];
							} else {

								if ($row['param_value'] == 'order_id') {

									$params[$row['param_key']] = $target->api_order_id;
								}
							}
						}
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
								//$this->lib->print_data($response); die;
								$status = search_key($json_result, $api_refill->refill_id_key);
								if ($status === true || $status === false) {
									unset($json_result[$api_refill->refill_id_key]);
								}

								$provider_order_id = search_key($json_result, $api_refill->refill_id_key);
								$data_input['api_refill_id'] = $provider_order_id;
								$data_input['api_log_refill'] = $this->db->escape($response);
							}
						} catch (Exception $e) {
							print_r($e->getMessage());
						}
					}
				}
				if ($provider_order_id != null) {
					$this->db->trans_start();
					$this->order_model->update(['api_log_refill' => $this->db->escape($response), 'next_refill' => date('Y-m-d H:i:s', time() + (60 * 60 * 24))], ['id' => $target->id]);
					$this->refill_model->insert($data_input);
					$this->db->trans_complete();
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Refill berhasil diproses'));
					exit(redirect(base_url('admin/' . $this->uri->segment(2))));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Ups!', 'msg' => '' . (isset($json_result['error']) ? $json_result['error'] : $json_result['msg']) . ''));
					exit(redirect(base_url('admin/' . $this->uri->segment(2))));
				}
			}
		}
	}
}
