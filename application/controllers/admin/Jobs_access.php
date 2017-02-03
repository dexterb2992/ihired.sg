<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs_access extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;
	
		$this->load->model('User_model', 'user', true);
		$this->load->model('admin/Company_model', 'company', true);
		$this->load->model('admin/Function_model', 'function', true);
		$this->load->model('admin/JobsAccess_model', 'jobs_access', true);
	}

	public function index(){
		$data = array();
		$data['js_module'] = $this->class;
		$data["users"] = $this->user->get("user_id as id,full_name as text", "array");
		$data["companies"] = $this->company->get("company_id as id,company_name as text", "array");
		$data["functions"] = $this->function->get("function_id as id,function_name as text", "array");
		$data["jobs_access"] = $this->jobs_access->all('array');

		$this->load->view('desktop/admin/jobs_access', $data);
	}
}