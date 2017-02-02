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

}