<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qualification_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->table = "qualifications_master";
		$this->table_id = "qualifications_id";
	}

	public function all($format = 'object'){
		$this->db->select($this->table.".*, t2.full_name, t3.function_name, t4.type");
		$this->db->join('user_master as t2', "t2.user_id = {$this->table}.user_id", 'INNER');
		$this->db->join('function_master as t3', "t3.function_id = {$this->table}.function_id", 'INNER');
		$this->db->join('qualifications_type as t4', "t4.qt_id = {$this->table}.qt_id", 'INNER');
	    $res = $this->db->get($this->table);
	    
		switch ($format) {
			case 'array':
				$res = $res->result_array();
				break;
				
			case 'json':
				$res = json_encode($res->result_array());
				break;

			default:
				$res = $res->result();
				break;
		}

		return $res;
	}

	/**
	 * @param array $values
	 */
	public function create($values){
		$this->db->set($values);
		$this->db->insert($this->table);

		$insert_id = $this->db->insert_id();
		if( $insert_id > 0 ) 
			return $insert_id;
		return false;
	}

	/**
	 * @param integer $id
	 * @param array $values
	 */
	public function edit($id, $values){
		$this->db->set($values);
		$this->db->where($this->table_id, $id);
		$this->db->update($this->table);

		if( $this->db->affected_rows() )
			return true;
		return false;
	}

	/**
	 * @param integer $id
	 * @param string $format
	 */
	public function find($id, $format = 'object'){
		$this->db->where($this->table_id, $id);
		$res = $this->db->get($this->table);

		if( $res->num_rows() > 0 )
			return $format == 'array' ? $res->row_array() : $res->row();
		return false;
	}


	/**
	 *  @param integer $id
	 *
	 */
	public function delete($id){
		$this->db->where($this->table_id, $id);
		$this->db->delete($this->table);

		if($this->db->affected_rows())
			return true;
		return false;
	}

	public function get($columns = "*", $format = 'object'){
		$this->db->select($columns);
		$res = $this->db->get($this->table);

		if( $res->num_rows() > 0 )
			return $format == 'array' ? $res->result_array() : $res->result();
		return array();
	}

	public function check($name, $function_id, $qt_id){
		$this->db->select("*");
		$this->db->where('LOWER(qualifications_name)', strtolower($name));
		$this->db->where('function_id', $function_id, FALSE);
		$this->db->where('qt_id', $qt_id, FALSE);
		$res = $this->db->get($this->table);
		if( $res->num_rows() > 0 )
			return true; // already exists
		return false;
	}

}