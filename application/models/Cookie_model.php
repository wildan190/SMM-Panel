<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cookie_model extends CI_Model
{
	public $table = 'cookie';
	public function get_by_id($id)
	{
		$data = $this->db->get_where($this->table, array('id' => $id));
		if ($data->num_rows() == 0) {
			return false;
		} else {
			return $data->row();
		}
	}
	public function get_rows($data = [])
	{
		$this->db->select((isset($data['select'])) ? $data['select'] : '*');
		if (isset($data['join'][0])) {
			foreach ($data['join'] as $key => $value) {
				$this->db->join($value['table'], $value['on'], $value['param']);
			}
		}
		if (isset($data['where'][0])) {
			foreach ($data['where'] as $key => $value) {
				$this->db->where($value);
			}
		}
		if (isset($data['group_by'])) $this->db->group_by($data['group_by']);
		if (isset($data['order_by'])) $this->db->order_by($data['order_by']);
		if (isset($data['limit'])) $this->db->limit($data['limit']);
		if (isset($data['offset'])) $this->db->offset($data['offset']);
		return $this->db->get((isset($data['from'])) ? $data['from'] : $this->table)->result_array();
	}
	public function get_count($data = [])
	{
		$this->db->select((isset($data['select'])) ? $data['select'] : '*');
		if (isset($data['join'][0])) {
			foreach ($data['join'] as $key => $value) {
				$this->db->join($value['table'], $value['on'], $value['param']);
			}
		}
		if (isset($data['where'][0])) {
			foreach ($data['where'] as $key => $value) {
				$this->db->where($value);
			}
		}
		if (isset($data['group_by'])) $this->db->group_by($data['group_by']);
		return $this->db->get((isset($data['from'])) ? $data['from'] : $this->table)->num_rows();
	}
	public function get_row($where)
	{
		$data = $this->db->get_where($this->table, $where);
		if ($data->num_rows() == 0) {
			return false;
		} else {
			return $data->row();
		}
	}
	public function insert($data)
	{
		$this->db->set($data);
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}
	public function update($data, $where)
	{
		$this->db->set($data);
		$this->db->where($where);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}
	public function delete($where)
	{
		$this->db->where($where);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function is_empty()
	{
		return $this->db->truncate($this->table);
	}
	public function isBrowserRegistered($user_id, $browser_name, $browser_version, $platform, $device)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('browser', $browser_name);
		$this->db->where('browser_version', $browser_version);
		$this->db->where('platform', $platform);
		$this->db->where('ud', $device);

		$query = $this->db->get($this->table);

		return $query->num_rows() > 0;
	}
	public function isCookieExpired($expiredAt)
	{
		return (strtotime($expiredAt) < time());
	}

	public function get_by_value($cookieValue)
	{
		$this->db->where('cookie', $cookieValue);
		$this->db->where('expired_at >', date('Y-m-d H:i:s')); // Menambahkan kondisi expired_at > waktu sekarang
		$data = $this->db->get($this->table);

		return $data->num_rows() > 0 ? $data->row() : false;
	}
}
