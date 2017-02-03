<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_access extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;
	
		$this->load->model('admin/User_model', 'user', true);
		$this->load->model('admin/Company_model', 'user', true);
		$this->load->model('admin/Function_model', 'industry', true);
	}

	public function index(){
		$data = array();
		$data['js_module'] = $this->class;
		$data["users"] = $this->user->get("full_name", "array");
		$data["companies"] = $this->user->get("full_name", "array");

		$this->load->view('admin/job_access', $data);
	}
}