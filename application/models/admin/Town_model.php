<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Town_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->table = "town_master";
		$this->table_id = "town_id";
	}

	public function all($format = 'object'){
		$this->db->select($this->table.".*, t2.country_name, t3.city_name, t4.full_name");
		$this->db->from($this->table);
		$this->db->join('country_master as t2', "t2.country_id = {$this->table}.country_id", 'inner');
		$this->db->join('city_master as t3', "t3.city_id = {$this->table}.city_id", 'inner');
		$this->db->join('user_master as t4', "t4.user_id = {$this->table}.user_id", 'inner');
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
		$this->db->select($this->table.".*, t2.country_name, t3.city_name, t4.full_name");
		$this->db->from($this->table);
		$this->db->join('country_master as t2', "t2.country_id = {$this->table}.country_id", 'inner');
		$this->db->join('city_master as t3', "t3.city_id = {$this->table}.city_id", 'inner');
		$this->db->join('user_master as t4', "t4.user_id = {$this->table}.user_id", 'inner');
		$this->db->where($this->table_id, $id);
		$res = $this->db->get();

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

	public function check($data){
		$this->db->select("*");
		$this->db->where("LOWER(town_name)", strtolower($data['town_name']));
		$this->db->where('country_id', $data['country_id']);
		$this->db->where('city_id', $data['city_id']);
		$res = $this->db->get($this->table);
		if( $res->num_rows() > 0 )
			return true; // already exists
		return false;
	}

	/**
	 * Just an alias for check function
	 *
	 */
	public function exists($data){
		return $this->check($data);
	}

	// returns data for autocomplete source
	public function getByCountry($page = 1, $term = '', $country_id){
		$resultCount = 25;
	    $offset = ($page - 1) * $resultCount;

		$this->db->select('town_name as text, '.$this->table_id.' as id');
		$this->db->like('town_name', $term);
		$this->db->where('country_id', $country_id, false);

		$this->db->order_by('text', 'ASC');
	    $this->db->limit($resultCount, $offset); 

		$records = $this->db->get($this->table)->result();

		$count =  $this->db->count_all_results($this->table);

	    $endCount = $offset + $resultCount;
	    $morePages = $endCount > $count;

	    $results = array(
			"results" => $records,
			"pagination" => array(
				"more" => $morePages
			)
	    );

		return $results;
	}

	public function paginate($page, $term, $country_id){
	    $resultCount = 25;
	    $offset = ($page - 1) * $resultCount;

	    $this->db->select('town_name as text, '.$this->table_id.' as id');
	    $this->db->like('town_name', $term);
	    $this->db->where('country_id', $country_id);
	    $this->db->order_by('text', 'ASC');
	    $this->db->limit($resultCount, $offset); 

	    $res = $this->db->get($this->table);

	    $cities = $res->result_array();

	    $count =  $this->db->count_all_results($this->table);



	    $endCount = $offset + $resultCount;
	    $morePages = $endCount > $count;

	    $results = array(
			"results" => $cities,
			"pagination" => array(
				"more" => $morePages
			)
	    );

	    return $results;
	}

}