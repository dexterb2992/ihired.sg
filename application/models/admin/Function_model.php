<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Function_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->table = "function_master";
		$this->table_id = "function_id";
	}

	public function get_data() {

		$this->db->select("t1.*, t2.full_name, t2.short_name");
		$this->db->from($this->table." as t1");
	    $this->db->join('user_master as t2', 't1.user_id = t2.user_id', 'LEFT');
	  	$this->db->order_by($this->table_id, 'DESC');
		$query = $this->db->get();
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function add_function($data) {

		$this->db->set($data);
		$this->db->insert($this->table);

		if($this->db->affected_rows()) {

			$insert_id = $this->db->insert_id();
			$this->db->select("t1.*, t2.full_name, t2.short_name");
			$this->from($this->table." as t1");
		    $this->db->join('user_master as t2', 't1.user_id = t2.user_id', 'LEFT');
	    	$this->db->order_by($this->table_id, 'DESC');
			$this->db->where($this->table_id, $insert_id);
			$query = $this->db->get();

			if ($query && $query->num_rows())	{
				$result = $query->result_array();
				return $result;
			}
		}
		return FALSE;
	}

	public function delete_function($deId) {

		$this->db->where($this->table_id, $deId);
		$this->db->delete($this->table);

		if($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	//fetches the list of records for the the autocomplete 
	public function get_select_list_data($txtVal) {

		$this->db->select("$this->table_id, function_name");
		$this->db->like('function_name', $txtVal);
		$this->db->limit(5);
		$query = $this->db->get($this->table);

		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function get($columns = "*", $format = 'object'){
		$this->db->select($columns);
		$res = $this->db->get($this->table);

		if( $res->num_rows() > 0 )
			return $format == 'array' ? $res->result_array() : $res->result();
		return array();
	}
}