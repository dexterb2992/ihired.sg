<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->table = "country_master";
		$this->table_id = "country_id";
	}

	public function all($format = 'object'){
		$this->db->select("$this->table.*, t2.full_name");
		$this->db->from($this->table);
		$this->db->join('user_master as t2', "t2.user_id = {$this->table}.user_id", 'inner');
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

	/**
	 * Returns an array for select2 dropdown source
	 * 
	 * @param integer page
	 * @param string term
	 *
	 * @return array
	 */
	public function paginate($page, $term){
	    $resultCount = 25;
	    $offset = ($page - 1) * $resultCount;

	    $this->db->select('country_name as text, country_id as id');
	    $this->db->like('country_name', $term);
	    $this->db->order_by('text', 'ASC');
	    $this->db->limit($resultCount, $offset); 

	    $res = $this->db->get($this->table);

	    $countries = $res->result_array();

	    $count =  $this->db->count_all_results($this->table);



	    $endCount = $offset + $resultCount;
	    $morePages = $endCount > $count;

	    $results = array(
			"results" => $countries,
			"pagination" => array(
				"more" => $morePages
			)
	    );

	    return $results;
	}

	/**
	 * Checks if a country has a state 
	 * 
	 * @param integer $country_id
	 *
	 * @return boolean
	 */
	public function has_states($country_id){
		$this->db->where('country_id', $country_id);
		$res = $this->db->get('state_master');

		if( $res->num_rows() > 0 )
			return true;
		return false;
	}

	/**
	 * Checks for duplicates
	 *
	 * @param array data
	 *
	 * @return boolean
	 */
	public function check($data){
		$this->db->select("*");
		$this->db->where('LOWER(country_name)', strtolower($data['country_name']));
		$this->db->where('LOWER(country_code)', strtolower($data['country_code']));
		$this->db->where('LOWER(nationality)', strtolower($data['nationality']));
		$this->db->where('LOWER(currency_symbol)', strtolower($data['currency_symbol']));
		$this->db->where('LOWER(currency_name)', strtolower($data['currency_name']));
		$res = $this->db->get($this->table);
		if( $res->num_rows() > 0 )
			return true; // already exists
		return false;
	}

	/**
	 * Just an alias for check function
	 *
	 * @param array data
	 *
	 * @return boolean
	 */
	public function exists($data){
		return $this->check($data);
	}
}