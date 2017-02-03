<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->table = "user_master";
		$this->table_id = "user_id";
	}

	public function create($full_name, $short_name, $email_id) {

		if( !$this->checkExistingEmail($email_id) ){ // make sure email doesn't exists yet
			// set dash_access to "Pending" by default
			$data = array(
				'full_name' 	=> $full_name,
				'short_name' 	=> $short_name,
				'email_id'		=> $email_id,
				'user_type' 	=> 'U',
				'created_on' 	=> date('Y-m-d'),
				'active' 			=> 'Y',
				'last_login' 	=> date('Y-m-d H:i:s'),
				'dash_access' => 'P'
			);

			$this->db->set($data);
			$this->db->insert($this->table);

			$last_ins = $this->db->insert_id();

			$this->db->where($this->table_id, $last_ins);
			$query = $this->db->get($this->table);

			if($query->num_rows() > 0)
				return $query->row_array();	
			return false;
		}

		return array('success' => false, 'data' => 'Email address already exists.');
		
	}

	public function set_image($id, $img) {

		$this->db->where($this->table_id, $id);
		$this->db->set('user_image', $img);
		$this->db->update($this->table);

		if($this->db->affected_rows())
			return true;
		return false;
	}

	public function remove_image($id){
		$this->db->where($this->table_id, $id);
		$this->db->set('user_image', NULL);
		$this->db->update($this->table);

		if($this->db->affected_rows())
			return true;
		return false;
	}

	public function delete($id){
		$this->db->where($this->table_id, $id);
		$this->db->delete($this->table);

		if($this->db->affected_rows())
			return true;
		return false;
	}

	public function checkExistingEmail($email){
		$this->db->where('email_id', $email);
		$res = $this->db->get($this->table);
		
		if( $res->num_rows() > 0 )
			return true;
		return false;
	}

	public function authenticate($email, $password){
		$this->db 
			->select("*")
			->from("user_master")
			->where("email_id", $email)
			->where("password", md5($password));

		$result_set = $this->db->get();
	
		return $result_set->row();
	}

	public function password_change($user_id, $new_password)	{

		$hash = md5($new_password);
		$this->db->where($this->table_id, $user_id);	
		
		$data = array(
			"password" => $hash,
		);

		$res = $this->db->update('user_master', $data);
		
		if($res)
			return true;
		return false;
	}

	public function change_request($user_id, $req_stat) {

		if($req_stat == NULL) {
			$this->session->set_userdata('u_req', NULL);
		}
		$this->db->where($this->table_id, $user_id);	
		$this->db->set('request', $req_stat);
		$query = $this->db->update($this->table);
		
		if($this->db->affected_rows())
			return true;
		return false;
	}

	public function change_access($id, $access){
		$this->db->where($this->table_id, $id);	
		$this->db->set('dash_access', $access);
		$query = $this->db->update($this->table);
		
		if($this->db->affected_rows())
			return true;
		return false;
	}

	public function get_list($start=FALSE, $limit=FALSE) {
		
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
			return $query->result_array();
		return FALSE;
	}

	public function find($email_id, $format = 'object'){
		$this->db->where('email_id', $email_id);
		$res = $this->db->get($this->table);

		if( $res->num_rows() > 0 )
			return $format == 'array' ? $res->row_array() : $res->row();
		return false;
	}

	public function get($columns = "*", $format = 'object'){
		$this->db->select($columns);
		$res = $this->db->get($this->table);

		if( $res->num_rows() > 0 )
			return $format == 'array' ? $res->result_array() : $res->results();
		return array();
	}

}