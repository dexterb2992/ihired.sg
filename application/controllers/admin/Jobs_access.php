<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH."controllers/Base_Controller.php";

class Jobs_access extends Base_Controller {
	
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
		$data["users"] = $this->user->get("user_id as value,full_name as label", "array");
		$data["companies"] = $this->company->get("company_id as id,company_name as text", "array");
		$data["functions"] = $this->function->get("function_id as id,function_name as text", "array");
		$data["jobs_access"] = $this->jobs_access->all('array');

		$this->load->view('desktop/admin/jobs_access', $data);
	}

	public function create(){
		$company_id = $this->input->post('company_id');
		$user_id = $this->input->post('user_id');
		$function_id = $this->input->post('function_id');

		$cname = $this->input->post("company_name");
		$uname = $this->input->post("user_name");
		$fn_name = $this->input->post("function_name");

		$jobs_access = array(
			"user_id" => $user_id,
			"company_id" => $company_id,
			"function_id" => $function_id,
			"date" => date('Y-m-d')
		);

		$res = array(
			'success' => true,
			'msg' => 'A job posting access has been granted.'
		);

		$result = $this->jobs_access->create($jobs_access);

		if( $result == false ){
			$res['success'] = false;
			$res['msg'] = 'Unable to process your request right now. Please try again later.';
		}else{
			$jobs_access['id'] = $result;
			$jobs_access['company_name'] = $cname;
			$jobs_access['full_name'] = $uname;
			$jobs_access['function_name'] = $fn_name;

			$res['details'] = array(
				"jobs_access" => $jobs_access
			);
		}

		echo json_encode($res);
	}

	public function delete(){
		$id = $this->input->post('id');

		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		if( $this->jobs_access->delete($id) ){
			$response['msg'] = 'A record has been successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}
}