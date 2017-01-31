<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Common_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	function tbl_unique($tbl, $col, $rec, $row_id, $where=FALSE) {

		if($col!=$rec)
		$this->db->select($col .', '. $rec);
		else
		$this->db->select($col);
		if($where)
		$this->db->where($where, FALSE, FALSE);
		$query = $this->db->get($tbl);

		if($query && $query->num_rows() > 0) {

			if( $query->row()->$rec == $row_id )
				return FALSE;
			else
				return TRUE;
		}
		return FALSE;
	}

	function ck_ifexists($tbl, $col, $where) {

		$this->db->select($col);
		$this->db->where($where);
		$query = $this->db->get($tbl);

		if($query && $query->num_rows) 
			return $query->row_array();
		return false;
	}

	function mt_rand_str() {
		$l = 6;
		$c = 'abcdefghijklmnopqrstuvwxyz1234567890';
	  for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
	  return $s;
	}
}