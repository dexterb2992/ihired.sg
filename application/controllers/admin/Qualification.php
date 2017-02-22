<?php
require APPPATH."controllers/Base_Controller.php";

class Qualification extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Qualification_model', 'qualification', true);
	}

	public function index(){
		$this->load->model('admin/Function_model', 'function_master', true);
		$this->load->model('admin/QualificationType_model', 'qualification_type', true);

		$data = array();
		$data['js_module'] = $this->class;
		$data['qualifications'] = $this->qualification->all();
		$data['_qualifications'] = array();
		$data['_functions'] = $this->function_master->get('function_id as id, function_name as text');
		$data['_qualification_types'] = $this->qualification_type->get('qt_id as id, type as text');

		foreach ($data['qualifications'] as $qualification) {
			$data['_qualifications'][] = array(
				'label' => $qualification->qualifications_name,
				'value' => $qualification->qualifications_id
			);
		}

		$this->load->view('desktop/admin/qualification', $data);

	}


	public function create(){
		
		$this->form_validation->set_rules('function_id', 'Function', 'xss_clean|required|trim');
		$this->form_validation->set_rules('qt_id', 'Qualification Type', 'xss_clean|required|trim');
		$this->form_validation->set_rules('qualification_name', 'Qualification Name', 'xss_clean|required|trim');

		$response = array(
			'success' => true, 
			'msg' => "New Qualification has been added." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();

			if( $this->qualification->check($data['qualification_name'], $data['function_id'], $data['qt_id']) ){
				$response['msg'] = "This Qualification already exists.";
				$response['success'] = false;
			}else{
				$qualification = array(
					'qualifications_name' => $data['qualification_name'],
					'qt_id' => $data['qt_id'],
					'function_id' => $data['function_id'],
					'date_added' => date('Y-m-d'),
					'user_id' => $this->session->userdata('user_id'),
				);


				$result = $this->qualification->create($qualification);

				if( $result == false ){
					$response['success'] = false;
					$response['msg'] = 'Unable to save a qualification right now. Please try again later.';
				}else{
					$qualification['qualifications_id'] = $result;
					$qualification['full_name'] = $this->session->userdata('full_name');
					$response['details'] = array(
						"qualification" => $qualification
					);
				}
			}
			
		}

		echo json_encode($response);
		
	}

	public function delete(){
		$id = $this->input->post('id');

		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		if( $this->qualification->delete($id) ){
			$response['msg'] = 'Successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}

}