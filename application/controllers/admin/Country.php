<?php
require APPPATH."controllers/Base_Controller.php";

class Country extends Base_Controller {

	public function __construct(){

		parent::__construct();
		$this->module	= basename(dirname(__DIR__));
		$this->class	= $this->router->class;
		$this->method	= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Country_model', 'country', true);
	}

	public function index(){
		$this->load->model('admin/State_model', 'state', true);
		$this->load->model('admin/City_model', 'city', true);
		$this->load->model('admin/Town_model', 'town', true);

		$data = array();
		$data['headers'] = $this;
		$data['js_module'] = $this->class;

		$data['countries'] = $this->country->all();
		$data['states'] = $this->state->all();
		$data['cities'] = $this->city->all();
		$data['towns'] = $this->town->all();

		$this->load->view('desktop/admin/country', $data);
	}

	public function create(){

		$this->form_validation->set_rules('country_name', 'Country Name', 'xss_clean|required|trim');
		$this->form_validation->set_rules('country_code', 'Country Code', 'xss_clean|required|trim');
		$this->form_validation->set_rules('nationality', 'Nationality', 'xss_clean|trim');
		$this->form_validation->set_rules('currency_name', 'Currency Name', 'xss_clean|trim');
		$this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'xss_clean|trim');

		$response = array(
			'success' => true, 
			'msg' => "New skill has been added." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();
			$record = array(
				'country_name' => $data['country_name'],
				'country_code' => $data['country_code'],
				'nationality' => $data['nationality'],
				'currency_name' => $data['currency_name'],
				'currency_symbol' => $data['currency_symbol'],
				'date_added' => date('Y-m-d'),
				'user_id' => $this->session->userdata('user_id'),
				'favorite' => '',
				'active' => 'Y'
			);

			if( $this->country->exists($record) == false ){
				$result = $this->country->create($record);

				if( $result == false ){
					$response['success'] = false;
					$response['msg'] = 'Unable to save a country right now. Please try again later.';
				}else{
					$record['country_id'] = $result;
					$record['full_name'] = $this->session->userdata('full_name');
					$response['details'] = array(
						"country" => $record
					);
				}
			}else{
				$response = array(
					'success' => false, 
					'msg' => "This country already exists." 
				);
			}
		}

		echo json_encode($response);
	}

	public function delete($id){
		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		if( $this->country->delete($id) ){
			$response['msg'] = 'Successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}
	
}