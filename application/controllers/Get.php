<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function run()
	{
		// filter input = 1
		header('Content-Type: application/json');
		$this->db->from('order_list');
		$this->db->where('is_get', '0');
		$this->db->where('status', 'Pending');
		$this->db->order_by('quantity', 'DESC');
		$this->db->limit(1);
		$order_list = $this->db->get();
		$order_list = $order_list->result();
		if ($order_list == null) {
			$result = ['code' => false, 'data' => 'Pesanan Kosong.'];
		} else {
			foreach ($order_list as $key => $value) {
				$update_order = [
					'status' => 'Processing',
					'is_get' => '1',
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$this->db->where('id', $value->id);
				$update = $this->db->update('order_list', $update_order);
				if ($update == true) {
					$result = ['code' => true, 'id' => '' . $value->id . '', 'quantity' => '' . $value->quantity . '', 'data' => '' . $value->target . ''];
				} else {
					$result = ['code' => false, 'data' => 'Gagal'];
				}
			}
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
}
