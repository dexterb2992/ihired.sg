<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shift_model extends CI_Model {

	public function get_data() {

		$this->db->select('shift_master.*, t2.full_name, t2.short_name');
	    $this->db->join('user_master as t2', 'shift_master.user_id = t2.user_id', 'LEFT');
	  	$this->db->order_by('shift_id', 'DESC');
		$query = $this->db->get('shift_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function get_shifts() {

		$this->db->select('shift_master.*');
  		$this->db->order_by('shift_id', 'ASC');
		$query = $this->db->get('shift_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function add_shift($data) {

		$this->db->set($data);
		$this->db->insert('shift_master');

		if($this->db->affected_rows()) {

			$insert_id = $this->db->insert_id();
			$this->db->select('shift_master.*, t2.full_name, t2.short_name');
		    $this->db->join('user_master as t2', 'shift_master.user_id = t2.user_id', 'LEFT');
	    	$this->db->order_by('shift_id', 'DESC');
			$this->db->where('shift_id', $insert_id);
			$query = $this->db->get('shift_master');

			if ($query && $query->num_rows())	{
				$result = $query->result_array();
				return $result;
			}
		}
		return FALSE;
	}

	public function delete_shift($deId) {

		$this->db->where('shift_id', $deId);
		$this->db->delete('shift_master');

		if($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}
}
