<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Industry_model extends CI_Model {

	public function get_data() {

		$this->db->select('industry_master.*, t2.full_name, t2.short_name');
	    $this->db->join('user_master as t2', 'industry_master.user_id = t2.user_id', 'LEFT');
	  	$this->db->order_by('industry_id', 'DESC');
		$query = $this->db->get('industry_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function add_industri($data) {

		$this->db->set($data);
		$this->db->insert('industry_master');

		if($this->db->affected_rows()) {
			return $this->db->insert_id();
		}
		return FALSE;
	}


	public function add_industry($data) {

		$this->db->set($data);
		$this->db->insert('industry_master');

		if($this->db->affected_rows()) {

			$insert_id = $this->db->insert_id();
			$this->db->select('industry_master.*, t2.full_name, t2.short_name');
		    $this->db->join('user_master as t2', 'industry_master.user_id = t2.user_id', 'LEFT');
	    	$this->db->order_by('industry_id', 'DESC');
			$this->db->where('industry_id', $insert_id);
			$query = $this->db->get('industry_master');

			if ($query && $query->num_rows())	{
				$result = $query->result_array();
				return $result;
			}
		}
		return FALSE;
	}

	public function delete_industry($inId) {

		$this->db->where('industry_id', $inId);
		$this->db->delete('industry_master');

		if($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	//fetches the list of records for the the autocomplete
	public function get_select_list_data($txtVal) {

		$this->db->select('industry_name, industry_id');
		$this->db->like('industry_name', $txtVal);
		// $this->db->where_not_in('specialty_id', $ignore);
		$this->db->limit(5);
		$query = $this->db->get('industry_master');

		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

}
