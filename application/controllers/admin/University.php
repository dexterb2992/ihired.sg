<?php
require APPPATH."controllers/Base_Controller.php";

class University extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/University_model', 'university', true);
	}

	public function index(){
		$data = array();
		$data['js_module'] = $this->class;
		$data['universities'] = $this->university->all();
		$data['_universities'] = array();

		foreach ($data['universities'] as $university) {
			$data['_universities'][] = array(
				'label' => $university->university_name,
				'value' => $university->university_id
			);
		}

		$this->load->view('desktop/admin/university', $data);

	}


	public function create(){
		
		$this->form_validation->set_rules('country_id', 'Country', 'xss_clean|required|trim');
		$this->form_validation->set_rules('city_id', 'City', 'xss_clean|required|trim');
		$this->form_validation->set_rules('university_name', 'University', 'xss_clean|required|trim');

		$response = array(
			'success' => true, 
			'msg' => "New University has been added." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();

			if( $this->university->check($data['university_name'], $data['country_id'], $data['city_id']) ){
				$response['msg'] = "This University already exists.";
				$response['success'] = false;
			}else{
				$university = array(
					'university_name' => $data['university_name'],
					'country_id' => $data['country_id'],
					'city_id' => $data['city_id']
				);


				$result = $this->university->create($university);

				if( $result == false ){
					$response['success'] = false;
					$response['msg'] = 'Unable to save a record right now. Please try again later.';
				}else{
					$university['university_id'] = $result;
					$response['details'] = array(
						"university" => $university
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

		if( $this->university->delete($id) ){
			$response['msg'] = 'Successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}

	public function get_countries(){
		$this->load->model('admin/Country_model', 'country', true);
		$data = $this->input->get();
		
		$results = $this->country->paginate($data['page'], $data['term']);

	    echo json_encode($results);
	}

	public function get_cities($country_id){
		$this->load->model('admin/City_model', 'city', true);

		$data = $this->input->get();
		
		$results = $this->city->getByCountry($country_id);

	    echo json_encode($results);
	}

}