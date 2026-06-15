<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (website_config('mt_web') == 1) {
			exit(redirect(base_url('maintenance')));
		}
	}
	public function index()
	{
		echo 'a';
	}
	public function ppob()
	{
		$postdata = array(
			'key' => '26bdde3d76a24512b55ef1719969a1f2',
			'sign' => md5("5qkPF0cx" . "26bdde3d76a24512b55ef1719969a1f2"),
			'type' => 'services',
			'filter_type' => '',
			'filter_value' => '',
		);
		$header = array(
			'Content-Type: application/json',
		);
		$curl = $this->lib->curl('https://vip-reseller.co.id/api/prepaid', $postdata);
		$result = json_decode($curl, true);

		//$this->lib->print_data($curl);
		foreach ($result['data'] as $key => $value) {
			$code = $value['code'];
			$provider = $value['type'];
			$category = $value['brand'];
			$service = $value['name'];
			$price = $value['price']['basic'];
			$profit  = ($price * 10) / 100;
			$description = $value['note'];
			$status = ($value['status'] == 'available') ? '1' : '0';

			$original_price = $price + $profit;
			$type = $provider;
			if ($type == "pulsa-reguler") :
				$type = "Pulsa";
			elseif ($type == "paket-internet") :
				$type = "PaketInternet";
			elseif ($type == "paket-telepon") :
				$type = "PaketSMS";
			elseif ($type == "token-pln") :
				$type = "TokenListrik";
			elseif ($type == "pulsa-transfer") :
				$type = "PulsaTransfer";
			elseif ($type == "saldo-emoney") :
				$type = "Emoney";
			elseif ($type == "voucher-game") :
				$type = "VoucherGame";
			else :
				$type = "Other";
			endif;

			$check_category = $this->service_category_model->get_row(['name' => $category, 'type' => 'SM', 'type_category' => $type]);
			//$this->lib->print_data($check_category);
			if ($check_category == false) {
				$insert_category = $this->db->insert('service_category', ['name' => $category, 'type' => 'SM', 'type_category' => $type]);
				if ($insert_category == TRUE) {
					$check_category = $this->service_category_model->get_row(['name' => $category, 'type' => 'SM', 'type_category' => $type]);
					$category_id = $check_category->id;
				} else {
					$category_id = $check_category->id;
				}
			}

			$check_service = $this->db->get_where('service_pulsa', ['api_service_id' => $code]);
			if ($check_service->num_rows() > 0) {
				$this->db->trans_start();
				$data_update = [
					'api_id' => '1',
					'api_service_id' => $code,
					'service_category_id' => $check_category->id,
					'name' => $service,
					'description' => $description,
					'price' => $price + $profit,
					'profit' => $profit,
					'status' => $status,
					'api' => '1',
				];
				$this->db->set($data_update);
				$this->db->where(['api_service_id' => $code]);
				$this->db->update('service_pulsa');
				$this->db->trans_complete();
				$this->db->error();
				echo "Update Layanan " . $service . " Berhasil <br/><br/>";
			} else {
				$data_insert = [
					'api_id' => '1',
					'api_service_id' => $code,
					'service_category_id' => $check_category->id,
					'name' => $service,
					'description' => $description,
					'price' => $price + $profit,
					'profit' => $profit,
					'status' => $status,
					'api' => '1',
				];
				$this->db->trans_start();
				$this->db->insert('service_pulsa', $data_insert);
				$this->db->trans_complete();
				$this->db->error();
				echo "Insert Layanan " . $service . " Berhasil <br/><br/>";
			}
		}
	}
	public function game()
	{
		$postdata = array(
			'key' => '26bdde3d76a24512b55ef1719969a1f2',
			'sign' => md5("5qkPF0cx" . "26bdde3d76a24512b55ef1719969a1f2"),
			'type' => 'services',
			'filter_type' => 'game',
			'filter_value' => '',
		);
		$header = array(
			'Content-Type: application/json',
		);
		$curl = $this->lib->curl('https://vip-reseller.co.id/api/game-feature', $postdata);
		$result = json_decode($curl, true);

		//		$this->lib->print_data($curl);
		foreach ($result['data'] as $key => $value) {
			$code = $value['code'];
			$category = $value['game'];
			$service = $value['name'];
			$price = $value['price']['basic'];
			$profit  = ($price * 10) / 100;
			$description = "-";
			$status = ($value['status'] == 'available') ? '1' : '0';

			$original_price = $price + $profit;
			$type = 'GAME';

			$check_category = $this->service_category_model->get_row(['name' => $category, 'type' => $type, 'type_category' => $category]);
			if ($check_category == false) {
				$insert_category = $this->db->insert('service_category', ['name' => $category, 'type' => $type, 'type_category' => $category]);
				if ($insert_category == TRUE) {
					$check_category = $this->service_category_model->get_row(['name' => $category, 'type' => $type, 'type_category' => $category]);
					$category_id = $check_category->id;
				} else {
					$category_id = $check_category->id;
				}
			}

			$check_service = $this->db->get_where('service_pulsa', ['api_service_id' => $code]);
			if ($check_service->num_rows() > 0) {
				$this->db->trans_start();
				$data_update = [
					'api_id' => '3',
					'api_service_id' => $code,
					'service_category_id' => $check_category->id,
					'name' => $service,
					'description' => $description,
					'price' => $price + $profit,
					'profit' => $profit,
					'status' => $status,
					'api' => '1',
					'game' => $this->lib->slug($category)
				];
				$this->db->set($data_update);
				$this->db->where(['api_service_id' => $code]);
				$this->db->update('service_game');
				$this->db->trans_complete();
				$this->db->error();
				echo "Update Layanan " . $service . " Berhasil <br/><br/>";
			} else {
				$data_insert = [
					'api_id' => '3',
					'api_service_id' => $code,
					'service_category_id' => $check_category->id,
					'name' => $service,
					'description' => $description,
					'price' => $price + $profit,
					'profit' => $profit,
					'status' => $status,
					'api' => '1',
					'game' => $this->lib->slug($category)
				];
				$this->db->trans_start();
				$this->db->insert('service_game', $data_insert);
				$this->db->trans_complete();
				$this->db->error();
				echo "Insert Layanan " . $service . " Berhasil <br/><br/>";
			}
		}
	}
	public function test()
	{
		$postdata = array(
			'cmd' => 'prepaid',
			'username' => 'bokapuDlwPRo',
			'sign' => md5("bokapuDlwPRo" . "dev-1db7bb50-db53-11ea-a45d-b78c437b9e8b" . "pricelist")
		);
		$header = array(
			'Content-Type: application/json',
		);
		$curl = $this->lib->curl('https://api.digiflazz.com/v1/price-list', json_encode($postdata), $header);
		$result = json_decode($curl, true);

		$data['curl'] = $result;
		$this->load->view('curl', $data);
	}
	public function haha()
	{
		$order_placed = false;
		$api = $this->api_model->get_by_id('2');
		$params = [];
		$api_request_param = $this->api_request_param_model->get_rows(['where' => [['api_id' => '2', 'api_type' => 'order']]]);
		foreach ($api_request_param as $row) {
			if ($row['param_type'] === 'custom') {
				$params[$row['param_key']] = $row['param_value'];
			} else {
				if ($row['param_value'] == 'service_id') {
					$params[$row['param_key']] = '3097';
				} else if ($row['param_value'] == 'target') {
					$params[$row['param_key']] = '2';
				} else if ($row['param_value'] == 'quantity') {
					$params[$row['param_key']] = '1000';
				}
			}
		}
		$client = new GuzzleHttp\Client();
		$param_key = 'form_params';

		$request = $client->request('POST', $api->order_end_point, [
			$param_key => $params,
		]);
		if ($request->getStatusCode() === 200) {
			$response = $request->getBody()->getContents();
			$json_result = json_decode($response, true);
			print_r($json_result);
			$provider_order_id = search_key($json_result, $api->order_id_key);
		}
		if ($provider_order_id == false) log_message('error', $response);
		$order_id = $provider_order_id;
		$data['params'] = $params;
		$data['order_id'] = $order_id;
		$this->load->view('curl', $data);
	}
}
