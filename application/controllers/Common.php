<?php
require APPPATH."controllers/Base_Controller.php";

class Common extends Base_Controller {


	public function get_countries(){
		$this->load->model('admin/Country_model', 'country', true);
		$data = $this->input->get();
		
		$results = $this->country->paginate($data['page'], $data['term']);

	    echo json_encode($results);
	}

	public function get_cities($country_id){
		$this->load->model('admin/City_model', 'city', true);

		$page = $this->input->get('page', true);
		$term = $this->input->get('term', true);
		$page = $page == "" ? 1 : $page;
		$results = $this->city->getByCountry($page, $term, $country_id);

	    echo json_encode($results);
	}

	public function get_states($country_id){
		$this->load->model('admin/State_model', 'state', true);

		$page = $this->input->get('page', true);
		$term = $this->input->get('term', true);
		$page = $page == "" ? 1 : $page;
		$results = $this->state->getByCountry($page, $term, $country_id);

	    echo json_encode($results);
	}


	public function get_towns($country_id){
		$this->load->model('admin/Town_model', 'state', true);

		$page = $this->input->get('page', true);
		$term = $this->input->get('term', true);
		$page = $page == "" ? 1 : $page;
		$results = $this->state->getByCountry($page, $term, $country_id);

	    echo json_encode($results);
	}

	public function get_train_stations($country_id){
		$this->load->model('admin/TrainStation_model', 'state', true);

		$page = $this->input->get('page', true);
		$term = $this->input->get('term', true);
		$page = $page == "" ? 1 : $page;
		$results = $this->state->getByCountry($page, $term, $country_id);

	    echo json_encode($results);
	}

	public function get_zones($country_id){
		$this->load->model('admin/Zone_model', 'state', true);

		$page = $this->input->get('page', true);
		$term = $this->input->get('term', true);
		$page = $page == "" ? 1 : $page;
		$results = $this->state->getByCountry($page, $term, $country_id);

	    echo json_encode($results);
	}

	/** 
	 * @return boolean true\false
	 */
	public function check_country_states($country_id){
		$this->load->model('admin/Country_model', 'country', true);
		$res = array('response' => false);
		
		if( $this->country->has_states($country_id) ){
			$res['response'] = true;
		}

		echo json_encode($res);
	}
}