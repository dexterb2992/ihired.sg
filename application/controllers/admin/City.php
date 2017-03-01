<?php
/**
 * A resource Controller for City
 */
require APPPATH."controllers/Base_Controller.php";

class City extends Base_Controller {

	public function __construct(){

		parent::__construct();
		$this->module	= basename(dirname(__DIR__));
		$this->class	= $this->router->class;
		$this->method	= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/City_model', 'state', true);
	}

	public function create(){

		$this->form_validation->set_rules('city_name', 'City Name', 'xss_clean|required|trim');
		$this->form_validation->set_rules('state_id', 'City Name', 'xss_clean|trim');
		$this->form_validation->set_rules('country_id', 'Country', 'xss_clean|required|trim');

		$response = array(
			'success' => true, 
			'msg' => "New record has been added." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();
			$record = array(
				'city_name' => $data['city_name'],
				'state_id' => $data['state_id'],
				'country_id' => $data['country_id']
			);

			if( $this->state->exists($record) == false ){
				$result = $this->state->create($record);

				if( $result == false ){
					$response['success'] = false;
					$response['msg'] = 'Unable to save a record right now. Please try again later.';
				}else{
					$response['details'] = array(
						"state" => $this->state->find($result)
					);
				}
			}else{
				$response = array(
					'success' => false, 
					'msg' => "This city already exists." 
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

		if( $this->state->delete($id) ){
			$response['msg'] = 'Successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}
	
}