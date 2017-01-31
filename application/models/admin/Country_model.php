<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country_model extends CI_Model{

	public function get_list($start=false, $limit=false) {

		// $this->db->where('limit');
		$this->db->select('country_master.*, t2.full_name, t2.short_name');
	    $this->db->join('user_master as t2', 'country_master.user_id = t2.user_id', 'LEFT');
	    $this->db->order_by('country_id', 'DESC');
		$query = $this->db->get('country_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return false;
	}
	
    function get_country()
    {
        $this->db->select('*');
        $query = $this->db->get('country_master');
    		if ($query && $query->num_rows())	{
    			$result = $query->result_array();
    			return $result;
    		}
    		return false;
    }

    public function get_country_list($txtVal) {

      $this->db->select('country_id, country_name');
  		$this->db->like('country_name', $txtVal);
  		$query = $this->db->get('country_master');

  		if ($query && $query->num_rows())	{
  			$result = $query->result_array();
  			return $result;
  		}
  		return false;
  	}

    function get_outside_country($id)
    {
        $this->db->select('post_job.country,country.country, COUNT(post_job.country) as number_of_jobs');

        $this->db->from('post_job');

        $this->db->where('post_job.country !=', 1);
        $this->db->where('cat_job_sub.cat_job', $id);
        $this->db->group_by("post_job.country");
        $this->db->join('country', 'country.id = post_job.country', 'left');
        $this->db->join('cat_job_sub', 'cat_job_sub.id = post_job.cat_job_sub', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    public function add_country($data) {

  		$this->db->set($data);
  		$this->db->insert('country_master');

  		if($this->db->affected_rows()) {
        return $this->db->insert_id();
  		}
  		return false;
  	}


    //fetches the list of records for the the autocomplete 
    public function get_select_list_data($txtVal) {

      $this->db->select('country_id, country_name');
      $this->db->like('country_name', $txtVal);
      //$this->db->like('currency_symbol', $txtVal);
      //$this->db->limit(10);
      $query = $this->db->get('country_master');

      if ($query && $query->num_rows()) {
        $result = $query->result_array();
        return $result; 
      }
      return false;
    }

	public function get_nationalities() {

		$this->db->select('country_id, nationality', false, false);
		$this->db->order_by('nationality', 'ASC');
		$query = $this->db->get('country_master');

		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return false;
	}
	
	public function all_nationalities($txtVal) {

		$this->db->select('country_id, nationality');
		$this->db->like('nationality', $txtVal);     
		$this->db->limit(10);
		$query = $this->db->get('country_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return false;
	}
	
	public function get_city_data($start=false, $limit=false) {

		// $this->db->where('limit');
		$this->db->select('city_master.*, t2.country_name, t3.full_name, t3.short_name');
    $this->db->join('country_master as t2', 'city_master.country_id = t2.country_id', 'LEFT');
    $this->db->join('user_master as t3', 'city_master.user_id = t3.user_id', 'LEFT');
    $this->db->order_by('city_id', 'DESC');
		$query = $this->db->get('city_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return false;
	}

	public function get_town_data($start=false, $limit=false) {

		// $this->db->where('limit');
		$this->db->select('town_master.*, t2.country_name, t3.full_name, t3.short_name, t4.city_name');
    $this->db->join('country_master as t2', 'town_master.country_id = t2.country_id', 'LEFT');
    $this->db->join('user_master as t3', 'town_master.user_id = t3.user_id', 'LEFT');
    $this->db->join('city_master as t4', 'town_master.city_id = t4.city_id', 'LEFT');
    $this->db->order_by('town_id', 'DESC');
		$query = $this->db->get('town_master');
		if ($query && $query->num_rows())	{
			$result = $query->result_array();
			return $result;
		}
		return false;
	}
	
	public function delete_country($coId) {
		$query = $this->db->get_where('city_master', array('country_id' => $coId));		
		if ($query && $query->num_rows())	{
			return false;
		}
		else{
			$this->db->delete('country_master', array('country_id' => $coId)); 
			return true;
		}
		
				
	}
	
	public function delete_city($ciId) {
		$query = $this->db->get_where('town_master', array('city_id' => $ciId));		
		if ($query && $query->num_rows())	{			
			return false;
		}else
		{
			$this->db->delete('city_master', array('city_id' => $ciId)); 
			return true;
		}
		
	}
	
	public function delete_town($toId) {
		$this->db->select('client_master.town_id, town_master.town_id')
        ->from('client_master AS t1, client_master AS t2')
        ->where('t1.town_id = t2.town_id')
        ->where('t1.town_id', $toId);
		  
		$query = $this->db->get('client_master');
		  
		if ($query && $query->num_rows()) {
			return false;
		}
		else
		{
			$this->db->delete('town_master', array('town_id' => $toId)); 
			return true;
		}
		
	}
	
	public function all_countries() {
		$query = $this->db->get('country_master');
		if ($query && $query->num_rows()) {
		  
		  $result = $query->result_array();
			return $result;
		}
		return false;
	}
	
	public function all_cities() {
		$query = $this->db->get('city_master');
		if ($query && $query->num_rows()) {
		  
		  $result = $query->result_array();
			return $result;
		}
		return false;
	}

	public function add_city($data) {

		$this->db->set($data);
		$this->db->insert('city_master');

		if($this->db->affected_rows()) {
			return $this->db->insert_id();
		}
		return false;
	}
	
	public function add_town($data) {

		$this->db->set($data);
		$this->db->insert('town_master');

		if($this->db->affected_rows()) {
			return $this->db->insert_id();
		}
		return false;
	}

}



?>
