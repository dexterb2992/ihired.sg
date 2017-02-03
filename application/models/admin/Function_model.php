<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Function_model extends CI_Model {

	public function get_data() {

		$this->db->select('function_master.*, t2.full_name, t2.short_name');
	    $this->db->join('user_master as t2', 'function_master.user_id = t2.user_id', 'LEFT');
	  	$this->db->order_by('function_id', 'DESC');
		$query = $this->db->get('function_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function add_function($data) {

		$this->db->set($data);
		$this->db->insert('function_master');

		if($this->db->affected_rows()) {

			$insert_id = $this->db->insert_id();
			$this->db->select('function_master.*, t2.full_name, t2.short_name');
		    $this->db->join('user_master as t2', 'function_master.user_id = t2.user_id', 'LEFT');
	    	$this->db->order_by('function_id', 'DESC');
			$this->db->where('function_id', $insert_id);
			$query = $this->db->get('function_master');

			if ($query && $query->num_rows())	{
				$result = $query->result_array();
				return $result;
			}
		}
		return FALSE;
	}

	public function delete_function($deId) {

		$this->db->where('function_id', $deId);
		$this->db->delete('function_master');

		if($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	//fetches the list of records for the the autocomplete 
	public function get_select_list_data($txtVal) {

		$this->db->select('function_id, function_name');
		$this->db->like('function_name', $txtVal);
		$this->db->limit(5);
		$query = $this->db->get('function_master');

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
			return $format == 'array' ? $res->row_array() : $res->row();
		return false;
	}
}