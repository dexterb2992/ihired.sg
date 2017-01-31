<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position_model extends CI_Model {


	public function get_select_list_data($txtVal) {

		$this->db->like('position_name', $txtVal);
		$this->db->limit(5);
		$query = $this->db->get('position_master');

		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function get_data() {

		$this->db->select('position_master.*, t2.full_name, t2.short_name');
	    $this->db->join('user_master as t2', 'position_master.user_id = t2.user_id', 'LEFT');
	  	$this->db->order_by('position_id', 'DESC');
		$query = $this->db->get('position_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function add_position($data) {

		$this->db->set($data);
		$this->db->insert('position_master');

		if($this->db->affected_rows()) {

			$insert_id = $this->db->insert_id();
			$this->db->select('position_master.*, t2.full_name, t2.short_name');
		    $this->db->join('user_master as t2', 'position_master.user_id = t2.user_id', 'LEFT');
	    	$this->db->order_by('position_id', 'DESC');
			$this->db->where('position_id', $insert_id);
			$query = $this->db->get('position_master');

			if ($query && $query->num_rows())	{
				$result = $query->result_array();
				return $result;
			}
		}
		return FALSE;
	}

	public function delete_position($deId) {

		$this->db->where('position_id', $deId);
		$this->db->delete('position_master');

		if($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}
}
