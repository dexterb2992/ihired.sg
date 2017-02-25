<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model{
	protected $table;
	protected $table_id;

	public function __construct(){
		parent::__construct();
		$table = "company_master";
		$table_id = "company_id";
		$this->table = $table;
		$this->table_id = $table_id;
	}

	public function all($format = 'object'){
		$res = $this->db->get($this->table);

		$this->db->select("{$this->table}.*, t2.industry_name");
	    $this->db->join("industry_master as t2", "{$this->table}.industry_id = t2.industry_id", 'INNER');
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

	public function get_opento($company_id, $format = 'object'){
		$this->db->where('company_id', $company_id);
		$res = $this->db->get('open_to');

		if( $res->num_rows() > 0 )
			return $format == 'array' ? $res->result_array() : $res->result();
		return array();
	}

	/**
	 * @param array $values
	 */
	public function create_opento($values){
		$this->db->set($values);
		$this->db->insert('open_to');

		$insert_id = $this->db->insert_id();
		if( $insert_id > 0 ) 
			return $insert_id;
		return false;
	}

	/**
	 *  @param integer $id
	 *
	 */
	public function delete_opento($id){
		$this->db->where('open_to_id', $id);
		$this->db->delete('open_to');

		if($this->db->affected_rows())
			return true;
		return false;
	}


	public function check_opento($name, $company_id){
		$this->db->select("*");
		$this->db->where('LOWER(open_to)', strtolower($name));
		$this->db->where('company_id', $company_id, FALSE);
		$res = $this->db->get('open_to');
		if( $res->num_rows() > 0 )
			return true; // already exists
		return false;
	}

	public function get_locations($company_id, $format = 'object'){
		$this->db->select('company_locations.*, t1.company_name, t2.country_name, t3.city_name, t4.town_name, t5.station_name, t6.zone, t7.state_name');
		$this->db->join('company_master as t1', 't1.company_id = company_locations.company_id', 'inner');
		$this->db->join('country_master as t2', 't2.country_id = company_locations.country_id', 'inner');
		$this->db->join('state_master as t7', 't7.state_id = company_locations.state_id', 'left');
		$this->db->join('city_master as t3', 't3.city_id = company_locations.city_id', 'inner');
		$this->db->join('town_master as t4', 't4.town_id = company_locations.town_id', 'inner');
		$this->db->join('train_master as t5', 't5.train_id = company_locations.train_id', 'left');
		$this->db->join('zone_master as t6', 't6.zone_id = company_locations.zone_id', 'left');
		
		
		$res =$this->db->get('company_locations');
	    
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
	public function create_location($values){
		$this->db->set($values);
		$this->db->insert('company_locations');

		$insert_id = $this->db->insert_id();
		if( $insert_id > 0 ) 
			return $insert_id;
		return false;
	}

	/**
	 *  @param integer $id
	 *
	 */
	public function delete_location($id){
		$this->db->where('location_id', $id);
		$this->db->delete('company_locations');

		if($this->db->affected_rows())
			return true;
		return false;
	}

	/**
	 * @param array $values
	 *
	 */
	public function check_location($values){
		$this->db->select("*");

		$this->db->where('company_id', $values['company_id']);
		$this->db->where('country_id', $values['country_id']);
		$this->db->where('state_id', $values['state_id']);
		$this->db->where('city_id', $values['city_id']);
		$this->db->where('town_id', $values['town_id']);
		$this->db->where('train_id', $values['train_id']);
		$this->db->where('zone_id', $values['zone_id']);

		$res = $this->db->get('company_locations');

		if( $res->num_rows() > 0 )
			return true; // already exists
		return false;
	}

	/** 
	 * @param integer $id
	 *
	 */
	public function find_location($id){
		$this->db->select('company_locations.*, t1.company_name, t2.country_name, t3.city_name, t4.town_name, t5.station_name, t6.zone, t7.state_name');
		$this->db->join('company_master as t1', 't1.company_id = company_locations.company_id', 'inner');
		$this->db->join('country_master as t2', 't2.country_id = company_locations.country_id', 'inner');
		$this->db->join('state_master as t7', 't7.state_id = company_locations.state_id', 'left');
		$this->db->join('city_master as t3', 't3.city_id = company_locations.city_id', 'inner');
		$this->db->join('town_master as t4', 't4.town_id = company_locations.town_id', 'inner');
		$this->db->join('train_master as t5', 't5.train_id = company_locations.train_id', 'left');
		$this->db->join('zone_master as t6', 't6.zone_id = company_locations.zone_id', 'left');
		$this->db->where('location_id', $id);
		
		
		$res = $this->db->get('company_locations');

		if( $res->num_rows() > 0 )
			return $res->row();
		
		return false;
	}
}