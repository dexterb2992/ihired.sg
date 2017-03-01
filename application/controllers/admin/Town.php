<?php
/**
 * A resource Controller for Town
 */
require APPPATH."controllers/Base_Controller.php";

class Town extends Base_Controller {

	public function __construct(){

		parent::__construct();
		$this->module	= basename(dirname(__DIR__));
		$this->class	= $this->router->class;
		$this->method	= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Town_model', 'town', true);
	}

	public function create(){

		$this->form_validation->set_rules('town_name', 'Town Name', 'xss_clean|required|trim');
		$this->form_validation->set_rules('city_id', 'City', 'xss_clean|required|trim');
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
				'town_name' => $data['town_name'],
				'city_id' => $data['city_id'],
				'country_id' => $data['country_id'],
				'date_added' => date('Y-m-d'),
				'user_id' => $this->session->userdata('user_id')
			);

			if( $this->town->exists($record) == false ){
				$result = $this->town->create($record);

				if( $result == false ){
					$response['success'] = false;
					$response['msg'] = 'Unable to save a record right now. Please try again later.';
				}else{
					$response['details'] = array(
						"town" => $this->town->find($result)
					);
				}
			}else{
				$response = array(
					'success' => false, 
					'msg' => "This town already exists." 
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

		if( $this->town->delete($id) ){
			$response['msg'] = 'Successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}
	
}