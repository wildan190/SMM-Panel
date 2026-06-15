<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (website_config('mt_web') == 1) {
			exit(redirect(base_url('maintenance')));
		}
		check_cookie(get_cookie('smm_login'));
		if ($this->session->userdata('login')) {
			if (user() == false)
				exit(redirect(base_url('auth/logout')));
		}
	}
	public function not_found()
	{
		$this->output->set_status_header('404');
		$this->render('public/not_found');
	}
	public function tool()
	{
		$this->render('public/page/tool', ['page_type' => 'Tool']);
	}
	public function site($i = false)
	{
		// filter input = 1
		if ($i === false)
			show_404();
		$i = $this->db->escape_str($i);
		$page = $this->page_model->get_by_slug($i);
		if ($page == false)
			show_404();
		$this->render('public/page/site', ['page_type' => $page->title, 'target' => $page]);
	}

	public function info()
	{
		if ($this->session->userdata('login') == false)
			exit(redirect(base_url()));
		// SETTINGS //
		$data_query = [
			'order_by' => 'id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit('shafou.com');
		$config['base_url'] = base_url('page/info');
		$config['total_rows'] = $this->info_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/page/info', ['page_type' => 'Informasi', 'table' => $this->info_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}
	public function service_log()
	{
		if ($this->session->userdata('login') == false)
			exit(redirect(base_url()));

		$rows = [
			'10' => '10',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];
		$type = [
			'price_increased' => 'Kenaikan Harga',
			'price_decreased' => 'Penurunan Harga',
			'update_min' => 'Perubahan Minimal',
			'update_max' => 'Perubahan Maksimal',
			'enabled' => 'Aktif Layanan',
			'insert' => 'Penambahan Layanan',
			'disabled' => 'Nonaktif Layanan',
		];

		// SETTINGS //
		$data_query = [
			'order_by' => 'id DESC',
			'limit' => '20',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('page/service_log')));
			$data_query['limit'] = $this->input->get('rows');
		}
		if ($this->input->get('type') <> '') {
			if (array_key_exists($this->input->get('type'), $type) == false)
				exit(redirect(base_url('page/service_log')));
			$data_query['where'][] = ['type' => $this->input->get('type')];
		}
		// END SORT & SEARCH
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit('shafou.com');
		$config['base_url'] = base_url('page/service_log');
		$config['total_rows'] = $this->service_logs_model->get_count($data_query);
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/page/service_log', ['page_type' => 'Log Layanan', 'table' => $this->service_logs_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'rows' => $rows, 'type' => $type, 'awal' => $config['awal'], 'akhir' => $config['akhir']]);
	}
	public function hof()
	{
		if ($this->session->userdata('login') == false)
			exit(redirect(base_url()));

		// Mendapatkan status manipulasi untuk setiap top pesanan, top deposit, dan top service
		$status_manipulation_order = [];
		$status_manipulation_deposit = [];
		$status_manipulation_service = [];

		for ($i = 1; $i <= 10; $i++) {
			$status_manipulation_order[$i] = custom_statistic("s_top_order_$i");
			$status_manipulation_deposit[$i] = custom_statistic("s_top_deposit_$i");
			$status_manipulation_service[$i] = custom_statistic("s_top_service_$i");
		}

		// Ambil data manipulasi untuk top order
		$order_manipulasi = [];
		for ($i = 1; $i <= 10; $i++) {
			if ($status_manipulation_order[$i] == 1) {
				$order_manipulasi[] = [
					'full_name' => custom_statistic("u_top_order_$i"),
					'rupiah' => custom_statistic("a_top_order_$i"),
					'total' => custom_statistic("c_top_order_$i"),
				];
			}
		}

		// Hitung jumlah status manipulasi yang aktif untuk top order
		$active_status_count_order = count($order_manipulasi);

		// Tentukan limit berdasarkan jumlah status manipulasi yang aktif untuk top order
		$limit_order = 10 - $active_status_count_order;

		// Ambil data asli untuk melengkapi jika limit masih tersedia untuk top order
		$order_asli = [];
		if ($limit_order > 0) {
			$order_asli = $this->user_model->get_rows([
				'select' => 'user.full_name, SUM(order_list.price) AS rupiah, COUNT(order_list.price) AS total',
				'join' => [['table' => 'order_list', 'on' => 'order_list.user_id = user.id', 'param' => 'right outer']],
				'where' => [['user.status' => '1', 'MONTH(order_list.created_at)' => date('m'), 'YEAR(order_list.created_at)' => date('Y')]],
				'group_by' => 'user.id',
				'order_by' => 'rupiah DESC, total DESC',
				'limit' => $limit_order,
			]);
		}

		// Gabungkan data asli dan manipulasi
		$order = array_merge($order_manipulasi, $order_asli);

		// Fungsi untuk mengurutkan array berdasarkan 'rupiah' dan 'total'
		usort($order, function ($a, $b) {
			if ($a['rupiah'] == $b['rupiah']) {
				return $b['total'] - $a['total'];
			}
			return $b['rupiah'] - $a['rupiah'];
		});

		// Batasi hasil akhir ke top 10
		$order = array_slice($order, 0, 10);

		// Ambil data manipulasi untuk top deposit
		$deposit_manipulasi = [];
		for ($i = 1; $i <= 10; $i++) {
			if ($status_manipulation_deposit[$i] == 1) {
				$deposit_manipulasi[] = [
					'full_name' => custom_statistic("u_top_deposit_$i"),
					'rupiah' => custom_statistic("a_top_deposit_$i"),
					'total' => custom_statistic("c_top_deposit_$i"),
				];
			}
		}

		// Hitung jumlah status manipulasi yang aktif untuk top deposit
		$active_status_count_deposit = count($deposit_manipulasi);

		// Tentukan limit berdasarkan jumlah status manipulasi yang aktif untuk top deposit
		$limit_deposit = 10 - $active_status_count_deposit;

		// Ambil data asli untuk melengkapi jika limit masih tersedia untuk top deposit
		$deposit_asli = [];
		if ($limit_deposit > 0) {
			$deposit_asli = $this->user_model->get_rows([
				'select' => 'user.full_name, SUM(deposit.balance) AS rupiah, COUNT(deposit.balance) AS total',
				'join' => [['table' => 'deposit', 'on' => 'deposit.user_id = user.id', 'param' => 'right outer']],
				'where' => [['user.status' => '1', 'MONTH(deposit.created_at)' => date('m'), 'YEAR(deposit.created_at)' => date('Y'), 'deposit.status' => 'Success']],
				'group_by' => 'user.id',
				'order_by' => 'rupiah DESC, total DESC',
				'limit' => $limit_deposit,
			]);
		}

		// Gabungkan data asli dan manipulasi
		$deposit = array_merge($deposit_manipulasi, $deposit_asli);

		// Fungsi untuk mengurutkan array berdasarkan 'rupiah' dan 'total'
		usort($deposit, function ($a, $b) {
			if ($a['rupiah'] == $b['rupiah']) {
				return $b['total'] - $a['total'];
			}
			return $b['rupiah'] - $a['rupiah'];
		});

		// Batasi hasil akhir ke top 10
		$deposit = array_slice($deposit, 0, 10);

		// Ambil data manipulasi untuk top service
		$service_manipulasi = [];
		for ($i = 1; $i <= 10; $i++) {
			if ($status_manipulation_service[$i] == 1) {
				$service_manipulasi[] = [
					'name' => custom_statistic("sc_top_service_$i"),
					'rupiah' => custom_statistic("a_top_service_$i"),
					'total' => custom_statistic("c_top_service_$i"),
				];
			}
		}

		// Hitung jumlah status manipulasi yang aktif untuk top service
		$active_status_count_service = count($service_manipulasi);

		// Tentukan limit berdasarkan jumlah status manipulasi yang aktif untuk top service
		$limit_service = 10 - $active_status_count_service;

		// Ambil data asli untuk melengkapi jika limit masih tersedia untuk top service
		$service_asli = [];
		if ($limit_service > 0) {
			$service_asli = $this->service_model->get_rows([
				'select' => 'service.id, service.name AS name, SUM(order_list.price) AS rupiah, COUNT(order_list.price) AS total',
				'join' => [['table' => 'order_list', 'on' => 'order_list.service_id = service.id', 'param' => 'right outer']],
				'where' => [['service.status' => '1', 'MONTH(order_list.created_at)' => date('m'), 'YEAR(order_list.created_at)' => date('Y')]],
				'group_by' => 'service.id',
				'order_by' => 'rupiah DESC, total DESC',
				'limit' => $limit_service,
			]);
		}

		// Gabungkan data asli dan manipulasi
		$service = array_merge($service_manipulasi, $service_asli);

		// Fungsi untuk mengurutkan array berdasarkan 'rupiah' dan 'total'
		usort($service, function ($a, $b) {
			if ($a['rupiah'] == $b['rupiah']) {
				return $b['total'] - $a['total'];
			}
			return $b['rupiah'] - $a['rupiah'];
		});

		// Batasi hasil akhir ke top 10
		$service = array_slice($service, 0, 10);
		
		$this->render('public/page/hof', [
			'page_type' => 'Top Pengguna',
			'order' => $order,
			'deposit' => $deposit,
			'service' => $service
		]);
	}
	
	
	



	public function detail_service($i = '')
	{
		$i = $this->db->escape_str($i);
		$data = $this->service_model->get_row(['id' => $i]);
		$this->load->view('public/page/detail_service', ['target' => $data, 'service_category' => $this->service_category_model->get_by_id($data->service_category_id)]);
	}
	public function monitor_service($i = '')
	{
		$i = $this->db->escape_str($i);

		// waktu rata-rata pesanan
		$average = get_service_average($i);

		// cari total order sesuai status
		$total_order = $this->order_model->get_count([
			'where' => [['service_id' => $i]]
		]);
		$pending = $this->order_model->get_count([
			'where' => [['service_id' => $i, 'status' => 'Pending']]
		]);
		$processing = $this->order_model->get_count([
			'where' => [['service_id' => $i, 'status' => 'Processing']]
		]);
		$success = $this->order_model->get_count([
			'where' => [['service_id' => $i, 'status' => 'Success']]
		]);
		$error = $this->order_model->get_count([
			'where' => [['service_id' => $i, 'status' => 'Error']]
		]);
		$partial = $this->order_model->get_count([
			'where' => [['service_id' => $i, 'status' => 'Partial']]
		]);

		// hitung total pesanan yang sukses, error, dan partial
		$combined_total = $success + $error + $partial;

		// hitung persentase sesuai status
		$combined_percent = number_format(($combined_total > 0) ? (($combined_total / $total_order) * 100) : 0, 2);
		$processing_percent = number_format(($total_order > 0) ? (($processing / $total_order) * 100) : 0, 2);
		$pending_percent = number_format(($total_order > 0) ? (($pending / $total_order) * 100) : 0, 2);

		$this->load->view('public/page/monitor_service', [
			'target' => $i,
			'average_time' => $average,
			'total_order' => $total_order,
			'combined_percent' => $combined_percent,
			'processing_percent' => $processing_percent,
			'pending_percent' => $pending_percent
		]);
	}


	public function service_rating($i = '')
	{
		$i = $this->db->escape_str($i);
		$data = $this->service_model->get_row(['id' => $i]);
		if ($data == false) echo 'layanan tidak ditemukan..';
		$checkOrder = $this->order_model->get_row(['service_id' => $data->id]);
		$count_review = $this->service_rating_model->get_count(['where' => [['service_id' => $data->id]]]);
		$countFive = $this->service_rating_model->get_count(['where' => [['service_id' => $data->id, 'rating' => '5']]]);
		$countFour = $this->service_rating_model->get_count(['where' => [['service_id' => $data->id, 'rating' => '4']]]);
		$countThree = $this->service_rating_model->get_count(['where' => [['service_id' => $data->id, 'rating' => '3']]]);
		$countTwo  = $this->service_rating_model->get_count(['where' => [['service_id' => $data->id, 'rating' => '2']]]);
		$countOne = $this->service_rating_model->get_count(['where' => [['service_id' => $data->id, 'rating' => '1']]]);
		if ($count_review <> 0) {
			$calculateRating = $this->lib->calculateRating($countFive, $countFour, $countThree, $countTwo, $countOne);
		} else {
			$calculateRating = 0;
		}
		$this->load->view('public/page/service_rating', ['target' => $data, 'order' => $checkOrder, 'rating' => $calculateRating]);
	}

	public function monitor()
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
			'where' => [['order_list.status' => 'Completed', 'order_list.status' => 'Success']],
			'limit' => '100',
		];
		$data_query['where'][] = ['user_id <>' => '1'];
		// END PAGINATION //
		$this->render('public/user/monitoring', ['page_type' => 'Monitoring Pesanan', 'table' => $this->order_model->get_rows($data_query)]);
	}

	public function layanan($i = null)
	{
		$i = htmlentities($this->db->escape_str($i));
		if ($i == '' or $i == 'all') {
			$service_category = $this->service_category_model->get_rows();
		} else {
			$service_category = $this->service_category_model->get_rows(['where' => [['id' => $i]]]);
		}
		$service = [];
		foreach ($service_category as $key => $value) {
			$data_query = [
				'select' => 'service.*, service_category.name AS category_name',
				'join' => [
					[
						'table' => 'service_category',
						'on' => 'service_category.id = service.service_category_id',
						'param' => 'inner'
					]
				],
				'where' => [
					[
						'service.service_category_id' => $this->db->escape_str($value['id']),
						'service.status' => '1'
					]
				],
				'order_by' => 'service.name ASC',
			];

			$service[$key] = $this->service_model->get_rows($data_query);
			$service_category[$key]['count'] = $this->service_model->get_count(['where' => [['service_category_id' => $value['id'], 'status' => '1']]]);
		}
		$this->render('public/' . $this->uri->segment(1) . '/layanan', ['page_type' => 'Daftar Harga', 'service' => $service, 'service_category' => $service_category, 'categories' => $this->service_category_model->get_rows(['where' => [['type' => 'SM']]])]);
	}
	public function price_list()
	{
		$data['field'] = [
			'service.id' => 'ID',
			'service.name' => 'LAYANAN',
			'service.min' => 'MIN',
			'service.max' => 'MAKS',
			'service.price' => 'HARGA',
		];

		$data['sort_field'] = [
			'service.id' => 'ID',
			'service.name' => 'LAYANAN',
			'service.min' => 'MIN',
			'service.max' => 'MAKS',
			'service.price' => 'HARGA',
			'service.average_time' => 'WAKTU RATA-RATA',
			'service.updated_at' => 'PEMBARUAN TERAKHIR',
		];

		$data['sort_type'] = [
			'asc' => 'ASC',
			'desc' => 'DESC',
		];

		$data['rows'] = [
			'20' => '20',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];

		$data['categories'] = $this->service_category_model->get_rows(['order_by' => 'name ASC']);

		$data_query = [
			'select' => 'service.*, service_category.name AS category_name',
			'join' => [
				[
					'table' => 'service_category',
					'on' => 'service_category.id = service.service_category_id',
					'param' => 'LEFT',
				],
			],
			'where' => [['service.status' => '1']],
			'order_by' => 'service_category.name ASC, service.price ASC',
			'limit' => '20',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0,
		];
		// END SETTINGS //

		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $data['rows']) == false) {
				exit(redirect(base_url('page/price_list')));
			}
			$data_query['limit'] = $this->input->get('rows');
		} else {
			// Set limit default jika tidak ada filter yang dipilih
			$data_query['limit'] = '20';
		}

		if ($this->input->get('category') <> '') {
			$data_query['where'][]['service.service_category_id'] = $this->input->get('category');
		}

		// filter cari
		if ($this->input->get('field') <> '' and $this->input->get('value') <> '') {
			if (array_key_exists($this->input->get('field'), $data['field']) == false) {
				exit(redirect(base_url('page/price_list')));
			}
			if ($this->input->get('field') == 'service.id') {
				$data_query['where'][] = ['service.id' => $this->input->get('value')];
			} elseif ($this->input->get('field') == 'service.name') {
				$data_query['where'][] = ['service.name LIKE' => '%' . $this->input->get('value') . '%'];
			} elseif ($this->input->get('field') == 'service.min') {
				$data_query['where'][] = ['service.min' => $this->input->get('value')];
			} elseif ($this->input->get('field') == 'service.max') {
				$data_query['where'][] = ['service.max' => $this->input->get('value')];
			} elseif ($this->input->get('field') == 'service.price') {
				$data_query['where'][] = ['service.price' => $this->input->get('value')];
			}
		}

		// filter sortir
		if ($this->input->get('sort_field') && array_key_exists($this->input->get('sort_field'), $data['sort_field'])) {
			$sort_field = $this->input->get('sort_field');
			$sort_type = $this->input->get('sort_type') == 'desc' ? 'DESC' : 'ASC';
			$data_query['order_by'] = $sort_field . ' ' . $sort_type;
		}
		// END SORT & SEARCH

		$config['base_url'] = base_url('page/price_list');
		$config['total_rows'] = $this->service_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();

		$data['page_type'] = 'Daftar Layanan';
		$data['table'] = $this->service_model->get_rows($data_query);
		$data['total_data'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['awal'] = $data_query['offset'] + 1;
		$data['akhir'] = $data_query['offset'] + $data_query['limit'];

		$this->render('public/' . $this->uri->segment(1) . '/price_list', $data);
	}

	public function monitoring()
	{
		$data['rows'] = [
			'20' => '20',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];

		$data['categories'] = $this->service_category_model->get_rows(['order_by' => 'name ASC']);

		$data_query = [
			'select' => 'service.*, service_category.name AS category_name, 
                     order_list.id AS last_order_id, 
                     order_list.created_at AS last_order_created, 
                     order_list.updated_at AS last_order_updated, 
                     order_list.quantity AS last_order_quantity, 
                     order_list.price AS last_order_price',
			'join' => [
				[
					'table' => 'service_category',
					'on' => 'service_category.id = service.service_category_id',
					'param' => 'LEFT'
				],
				[
					'table' => '(SELECT order_list.* FROM order_list 
                            INNER JOIN (SELECT MAX(id) AS max_id FROM order_list WHERE status = "Success" GROUP BY service_id) max_order
                            ON order_list.id = max_order.max_id) as order_list',
					'on' => 'order_list.service_id = service.id',
					'param' => 'INNER'
				]
			],
			'where' => [
				['service.status' => '1']
			],
			'group_by' => 'service.id',
			'order_by' => 'service_category.name ASC, service.price ASC, order_list.id DESC',
			'limit' => $this->input->get('rows') ? $this->input->get('rows') : 20,
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];

		if ($this->input->get('category') <> '') {
			$data_query['where'][] = ['service.service_category_id' => $this->input->get('category')];
		}
		if ($this->input->get('search') <> '') {
			$data_query['where'][] = ['service.id' => $this->input->get('search')];
		}

		$config['base_url'] = base_url('page/monitoring');
		$config['total_rows'] = $this->service_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();

		$data['page_type'] = 'Monitoring Layanan';
		$data['table'] = $this->service_model->get_rows($data_query);
		$data['total_data'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['awal'] = $data_query['offset'] + 1;
		$data['akhir'] = $data_query['offset'] + $data_query['limit'];

		$this->render('public/' . $this->uri->segment(1) . '/monitoring', $data);
	}
	public function fav_services()
	{
		if ($this->session->userdata('login') == false)
			exit(redirect(base_url()));

		$data['rows'] = [
			'10' => '10',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];

		$data['categories'] = $this->service_category_model->get_rows(['order_by' => 'name ASC']);

		$data_query = [
			'select' => 'service_favorit.*, service.name AS service_name, service_category.name AS category_name, service.min, service.max, service.price',
			'join' => [
				[
					'table' => 'service',
					'on' => 'service.id = service_favorit.service_id',
					'param' => 'LEFT',
				],
				[
					'table' => 'service_category',
					'on' => 'service_category.id = service.service_category_id',
					'param' => 'LEFT',
				],
			],
			'where' => [['service_favorit.user_id' => user()]],
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0,
		];

		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $data['rows']) == false)
				exit(redirect(base_url('page/fav_services')));
			$data_query['limit'] = $this->input->get('rows');
		}

		if ($this->input->get('sort_field') && $this->input->get('sort_type')) {
			$sort_field = $this->input->get('sort_field');
			if ($sort_field === 'services.min') {
				$data_query['order_by'] = 'service.min ' . $this->input->get('sort_type');
			} elseif ($sort_field === 'services.max') {
				$data_query['order_by'] = 'service.max ' . $this->input->get('sort_type');
			} elseif ($sort_field === 'services.price') {
				$data_query['order_by'] = 'service.price ' . $this->input->get('sort_type');
			} elseif ($sort_field === 'service.name') {
				// Kolom nama layanan, tambahkan alias 'service.'
				$data_query['order_by'] = 'service.name ' . $this->input->get('sort_type');
			} elseif ($sort_field === 'service_category.name') {
				// Kolom nama kategori, tambahkan alias 'service_category.'
				$data_query['order_by'] = 'service_category.name ' . $this->input->get('sort_type');
			} else {
				$data_query['order_by'] = $sort_field . ' ' . $this->input->get('sort_type');
			}
		} else {
			$data_query['order_by'] = 'service_category.name ASC, service.price ASC';
		}


		$config['base_url'] = base_url('page/fav_services');
		$config['total_rows'] = $this->service_favorit_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();

		$data['page_type'] = 'Favorit Layanan';
		$data['table'] = $this->service_favorit_model->get_rows($data_query);
		$data['total_data'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['awal'] = $data_query['offset'] + 1;
		$data['akhir'] = $data_query['offset'] + $data_query['limit'];
		$this->render('public/' . $this->uri->segment(1) . '/fav_services', $data);
	}

	public function delete_fav($i = '')
	{
		$user_id = user();
		$target = $this->service_favorit_model->get_row(['service_id' => $i, 'user_id' => $user_id]);

		if ($target == false) {
			show_404();
		}

		$delete_target = $this->service_favorit_model->delete(['service_id' => $i, 'user_id' => $user_id]);

		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Berhasil', 'msg' => 'Layanan <b>#' . $i . '</b> berhasil dihapus dari favorit.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal', 'msg' => 'Kesalahan tidak terduga.'));
		}

		redirect(base_url('page/fav_services'));
	}
}
