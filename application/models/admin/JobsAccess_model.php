<?php
class JobsAccess_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->table = "jobs_access";
		$this->table_id = "jobs_access_id";
	}

	public function all($format = 'object'){
		$res = $this->db->get($this->table);

		$this->db->select("a.{$this->table_id},u.full_name,c.company_name,f.function_name,a.date");
		$this->db->from($this->table." as a");
	    $this->db->join("user_master as u", "a.user_id = u.user_id", 'INNER');
	    $this->db->join("company_master as c", "a.company_id = c.company_id", 'INNER');
	    $this->db->join("function_master as f", "a.function_id = f.function_id", 'INNER');
	    $res = $this->db->get();
	    
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
		$this->update($this->table);

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
}