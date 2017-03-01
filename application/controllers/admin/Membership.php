<?php
require APPPATH."controllers/Base_Controller.php";

class Membership extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Membership_model', 'membership', true);
	}

	public function index(){
		$data = array();
		$data['js_module'] = $this->class;
		$data['memberships'] = $this->membership->all();
		$data['_memberships'] = array();

		foreach ($data['memberships'] as $membership) {
			$data['_memberships'][] = array(
				'label' => $membership->membership_name,
				'value' => $membership->membership_id
			);
		}

		$this->load->view('desktop/admin/membership', $data);

	}


	public function create(){
		
		$this->form_validation->set_rules('country_id', 'Country', 'xss_clean|required|trim');
		$this->form_validation->set_rules('city_id', 'City', 'xss_clean|required|trim');
		$this->form_validation->set_rules('membership_name', 'Membership', 'xss_clean|required|trim');

		$response = array(
			'success' => true, 
			'msg' => "New Membership has been added." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();

			if( $this->membership->check($data['membership_name'], $data['country_id'], $data['city_id']) ){
				$response['msg'] = "This Membership already exists.";
				$response['success'] = false;
			}else{
				$membership = array(
					'membership_name' => $data['membership_name'],
					'country_id' => $data['country_id'],
					'city_id' => $data['city_id']
				);


				$result = $this->membership->create($membership);

				if( $result == false ){
					$response['success'] = false;
					$response['msg'] = 'Unable to save a record right now. Please try again later.';
				}else{
					$membership['membership_id'] = $result;
					$response['details'] = array(
						"membership" => $membership
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

		if( $this->membership->delete($id) ){
			$response['msg'] = 'Successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}

}