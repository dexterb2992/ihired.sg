<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH."controllers/Base_Controller.php";

class Company extends Base_Controller {

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
			$industry = array(
				"industry_name" => $industry_name,
				"user_id" => $this->session->userdata('user_id'),
				"date_added" => date('Y-m-d')
			);
			$res = $this->industry->create($industry);
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

		$company = array(
			"company_name" => $company_name,
			"industry_id" => $industry_id
		);

		$res = array(
			'success' => true,
			'msg' => 'A company has been added successfully.'
		);

		$result = $this->company->create($company);

		if( $result == false ){
			$res['success'] = false;
			$res['msg'] = 'Unable to create a Company right now. Please try again later.';
		}else{
			$company['company_id'] = $result;
			$company['industry_name'] = $industry_name;
			$res['details'] = array(
				"company" => $company
			);
		}

		echo json_encode($res);
	}

	/**
	 * Displays a view to edit a company
	 */
	public function edit($id){
		$this->load->model('admin/Country_model', 'country', true);

		$data = array();
		$data['js_module'] = 'edit_company';
		$data['company'] = $this->company->find($id);
		$data['industries'] = $this->industry->get("industry_id as id, industry_name as text");
		// $data['countries'] = $this->country->get("country_id as id, country_name as text");
		// $data['countries'] = $this->country->get();
		$countries = $this->country->get();
		$data['countries'] = array();
		$data['currencies'] = array();

		foreach ($data['industries'] as $industry) {
			if( $industry->id == $data['company']->industry_id ){
				$data['company']->industry_name = $industry->text;
			}
		}

		foreach ($countries as $country) {
			// if( $country->id == $data['company']->country_id ){
				// $data['company']->country_name = $country->text;
				if( $country->country_id == $data['company']->country_id ){
					$data['company']->country_name = $country->country_name;
					$data['company']->currency = "$country->currency_name ($country->currency_symbol)";
				}
				
				$currency = new stdClass();
				$currency->label = "$country->currency_name ($country->currency_symbol)";
				$currency->value = $country->country_id;
				$data['currencies'][] = $currency;

				$n_country = new stdClass();
				$n_country->id = $country->country_id;
				$n_country->text = $country->country_name;

				$data['countries'][] = $n_country;
			// }
		}



		// $data['currencies'] = $this->country->get("country_id as value, CONCAT(currency_name, ' (', currency_symbol, ')') as label");

		$target_dir = $_SERVER['DOCUMENT_ROOT'].'/assets/images/company_logos/';
		$imgd = base_url('assets/images/pix.jpg');
		$data['company']->hasImg = '';

		if($data['company']->logo != null) {
			$data['company']->hasImg = 'hasImg';
			$imgd  = base_url('assets/images/company_logos').'/'.$data['company']->logo;
		}

		$data['company']->logo_dir = $target_dir.$data['company']->logo;
		$data['company']->logo = $imgd;
		

		$this->load->view('desktop/admin/edit_company', $data);
	}

	/**
	 * Updates a company
	 */
	public function update(){
		echo '<pre>';
		print_r($this->input->post());
		echo '/<pre>';
	}

	public function delete(){
		$id = $this->input->post('id');

		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		if( $this->company->delete($id) ){
			$response['msg'] = 'Company successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}

}