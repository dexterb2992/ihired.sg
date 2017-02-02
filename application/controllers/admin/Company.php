<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {

	public function __construct(){
	
		parent::__construct();
		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;
		
		$this->load->model('admin/Company_model', 'company', true);
		$this->load->model('admin/Industry_model', 'industry', true);
	}

	public function index(){
		$data = array();
		$data['headers']	= $this;
		$data['js_module'] = $this->class;
		$companies = array();
		$industries = array();

		$companies = $this->company->all('array');
		$industries = $this->industry->all('array');

		$data['companies'] = $companies;
		$data['industries'] = $industries;

		$this->load->view('desktop/admin/company', $data);
	}

	public function create(){
		$company_name = $this->input->post('company_name');
		$industry_name = $this->input->post('industry_name');
		$industry_id = $this->input->post('industry_id');

		if( $industry_id == 0 ){
			$values = array(
				"industry_name" => $industry_name,
				"user_id" => $this->session->userdata('user_id'),
				"date_added" => date('Y-m-d')
			);
			$res = $this->industry->create($values);
			if( $res !== false ){
				$industry_id = $res;
			}else{
				echo json_encode( array(
					'success' => false, 
					'msg' => 'Unable to create an Industry right now. Please try again later.'
					) 
				);
				exit;
			}
		}

		$values = array(
			"company_name" => $company_name,
			"industry_id" => $industry_id
		);

		$res = array(
			'success' => true,
			'msg' => 'A company has been added successfully.'
		);
		
		if( $this->company->create($values) == false ){
			$res['success'] = false;
			$res['msg'] = 'Unable to create a Company right now. Please try again later.';
		}

		echo json_encode($res);
	}

}