<?php
require APPPATH."controllers/Base_Controller.php";

class License extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/License_model', 'license', true);
	}

	public function index(){
		$data = array();
		$data['js_module'] = $this->class;
		$data['licenses'] = $this->license->all();
		$data['_licenses'] = array();

		foreach ($data['licenses'] as $license) {
			$data['_licenses'][] = array(
				'label' => $license->License_name,
				'value' => $license->license_id
			);
		}

		$this->load->view('desktop/admin/license', $data);

	}


	public function create(){
		
		$this->form_validation->set_rules('country_id', 'Country', 'xss_clean|required|trim');
		$this->form_validation->set_rules('city_id', 'City', 'xss_clean|required|trim');
		$this->form_validation->set_rules('license_name', 'License/Board Name', 'xss_clean|required|trim');

		$response = array(
			'success' => true, 
			'msg' => "New License/Board has been added." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();

			if( $this->license->check($data['license_name'], $data['country_id'], $data['city_id']) ){
				$response['msg'] = "This License/Board already exists.";
				$response['success'] = false;
			}else{
				$license = array(
					'License_name' => $data['license_name'],
					'country_id' => $data['country_id'],
					'city_id' => $data['city_id']
				);


				$result = $this->license->create($license);

				if( $result == false ){
					$response['success'] = false;
					$response['msg'] = 'Unable to save a license right now. Please try again later.';
				}else{
					$license['license_id'] = $result;
					$response['details'] = array(
						"license" => $license
					);
				}
			}
			
		}

		echo json_encode($response);
		
	}

	public function delete($id){

		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		if( $this->license->delete($id) ){
			$response['msg'] = 'Successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}

}