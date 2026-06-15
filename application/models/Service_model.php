<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_model extends CI_Model
{
	public $table = 'service';

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
		return $this->db->insert($this->table, $data);
	}

	public function update($data, $where)
	{
		return $this->db->update($this->table, $data, $where);
	}

	public function delete($where)
	{
		return $this->db->delete($this->table, $where);
	}

    // Fungsi tambahan agar tombol 'Hapus Semua' di index.php bisa bekerja
	public function is_empty()
	{
		return $this->db->empty_table($this->table);
	}
}