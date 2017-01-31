<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends CI_Model {

	public function get_data() {

		$this->db->select('department_master.*, t2.full_name, t2.short_name');
	    $this->db->join('user_master as t2', 'department_master.user_id = t2.user_id', 'LEFT');
	  	$this->db->order_by('department_id', 'DESC');
		$query = $this->db->get('department_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function add_department($data) {

		$this->db->set($data);
		$this->db->insert('department_master');

		if($this->db->affected_rows()) {

			$insert_id = $this->db->insert_id();
			$this->db->select('department_master.*, t2.full_name, t2.short_name');
		    $this->db->join('user_master as t2', 'department_master.user_id = t2.user_id', 'LEFT');
	    	$this->db->order_by('department_id', 'DESC');
			$this->db->where('department_id', $insert_id);
			$query = $this->db->get('department_master');

			if ($query && $query->num_rows())	{
				$result = $query->result_array();
				return $result;
			}
		}
		return FALSE;
	}

	public function delete_department($deId) {

		$this->db->where('department_id', $deId);
		$this->db->delete('department_master');

		if($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	//fetches the list of records for the the autocomplete 
	public function get_select_list_data($txtVal) {

		$this->db->select('department_id, department_name');
		$this->db->like('department_name', $txtVal);
		$this->db->limit(5);
		$query = $this->db->get('department_master');

		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}
}