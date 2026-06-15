<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gojek_mutation_model extends CI_Model {
	public $table = 'gojek_mutation';
	public function get_by_id($id) {
		$data = $this->db->get_where($this->table, array('id' => $id));
		if ($data->num_rows() == 0) {
			return false;
		} else {
			return $data->row();
		}
	}
	public function get_count($select = '*', $where = null, $like = null) {
		if ($where <> null) $this->db->where($where);
		if ($like <> null) $this->db->like($like);
		$data = $this->db->select($select)->from($this->table)->get();
		return $data->num_rows();
	}
	public function get_rows($select = '*', $where = null, $like = null, $order = null, $limit = null, $offset = null) {
		if ($where <> null) $this->db->where($where);
		if ($like <> null) $this->db->like($like);
		if ($order <> null) $this->db->order_by($order);
		if ($limit <> null) $this->db->limit($limit);
		if ($offset <> null) $this->db->offset($offset);
		$data = $this->db->select($select)->from($this->table)->get();
		return $data->result_array();
	}
	public function get_row($where) {
		$data = $this->db->get_where($this->table, $where);
		if ($data->num_rows() == 0) {
			return false;
		} else {
			return $data->row();
		}
	}
	public function insert($data) {
		$this->db->set($data);
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}
	public function update($data, $where) {
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update($this->table);
	}
	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}
	public function empty() {
		return $this->db->truncate($this->table);
	}
}