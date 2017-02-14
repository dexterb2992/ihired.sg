<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Qualifications_model extends CI_Model {
	
	public function __construct(){
		$this->table = "qualifications_master";
		$this->table_id = "qualifications_id";
	}

	public function get_data() {

		$this->db->select('qualifications_master.*, t2.full_name, t2.short_name');
	    $this->db->join('user_master as t2', 'qualifications_master.user_id = t2.user_id', 'LEFT');
	  	$this->db->order_by('qualifications_id', 'DESC');
		$query = $this->db->get('qualifications_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return FALSE;
	}

	public function add_qualifications($data) {

		$this->db->set($data);
		$this->db->insert('qualifications_master');

		if($this->db->affected_rows()) {

			$insert_id = $this->db->insert_id();
			$this->db->select('qualifications_master.*, t2.full_name, t2.short_name');
		    $this->db->join('user_master as t2', 'qualifications_master.user_id = t2.user_id', 'LEFT');
	    	$this->db->order_by('qualifications_id', 'DESC');
			$this->db->where('qualifications_id', $insert_id);
			$query = $this->db->get('qualifications_master');

			if ($query && $query->num_rows())	{
				$result = $query->result_array();
				return $result;
			}
		}
		return FALSE;
	}

	public function delete_qualifications($deId) {

		$this->db->where('qualifications_id', $deId);
		$this->db->delete('qualifications_master');

		if($this->db->affected_rows()) {
			return TRUE;
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