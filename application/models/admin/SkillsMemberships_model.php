<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SkillsMemberships_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->table = "skills_memberships";
		$this->table_id = "sm_id";
	}

	public function all($format = 'object'){

		$this->db->select("{$this->table}.*, t2.membership_name, t3.skills_name");
	    $this->db->join("memberships_master as t2", "{$this->table}.membership_id = t2.membership_id", 'INNER');
	    $this->db->join("skills_master as t3", "{$this->table}.skills_id = t3.skills_id", 'INNER');
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

	public function check($skills_id, $membership_id){
		$this->db->select("*");
		$this->db->where('skills_id', $skills_id);
		$this->db->where('membership_id', $membership_id);
		$res = $this->db->get($this->table);
		if( $res->num_rows() > 0 )
			return true; // already exists
		return false;
	}

}