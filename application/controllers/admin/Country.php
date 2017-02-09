<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH."controllers/Base_Controller.php";

class Country extends Base_Controller {

	public function __construct(){

		parent::__construct();
		$this->module 		= basename(dirname(__DIR__));
		$this->class 			= $this->router->class;
		$this->method 		= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Country_model', 'country', true);
	}

	public function index() {

		$data['headers']	= $this;
		$data['js_module'] = $this->class;

		$raw = $this->country->get_list();
		
		if($raw!=FALSE && is_array($raw)) {
			foreach ($raw as $key => $val) {
				$data['data'][] = array(
					'country_id' 			=> $val['country_id'], 
					'country_name' 		=> strtolower($val['country_name']),
					'nationality' 		=> strtolower($val['nationality']),
					'currency_name' 	=> strtolower($val['currency_name']),
					'currency_symbol' => strtoupper($val['currency_symbol']),
					'date_added' 			=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 				=> strtolower($val['short_name'])
				);
			}
		}
		$data['data_city'] 			= $this->country->get_city_data();
		$data['data_town'] 			= $this->country->get_town_data();
		$data['nationalities']	= 	$this->country->get_nationalities();

		$this->load->view('desktop/admin/country_list', $data);
	}

	public function get_nationalities() {

		$data = array();
		$raw_nationalities = $this->country->get_nationalities();
		if($raw_nationalities!=FALSE) {
			foreach ($raw_nationalities as $key => $val) {
				$data[$val['nationality']] = $val['nationality'];
			}
		}
		return $data;
	}

	public function get_city_data() {

		$data = array();
		$raw_city = $this->country->get_city_data();
		if($raw_city!=FALSE) {
			foreach ($raw_city as $key => $val) {
				$data[] = array(
					'city_id' 			=> $val['city_id'], 
					'city_name' 		=> strtolower($val['city_name']),
					'country_name' 	=> strtolower($val['country_name']),
					'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 			=> strtolower($val['short_name'])
				);
			}
		}
		return $data;
	}

	public function get_countries() {

		$data = array();
		$raw = $this->country->get_countries();
		if($raw!=FALSE && is_array($raw)) {
			foreach ($raw as $key => $val) {
				$data[$val['country_id']] = $val['country_name'];
			}
		}
		$data[0] = 'Select Country';
		return array_reverse($data, true);
	}

	public function get_town_data() {

		$data = array();
		$raw_town = $this->country->get_town_data();
		if($raw_town!=FALSE) {
			foreach ($raw_town as $key => $val) {
				$data[] = array(
					'town_id' 			=> $val['town_id'], 
					'town_name' 		=> strtolower($val['town_name']),
					'city_name' 		=> strtolower($val['city_name']),
					'country_name' 	=> strtolower($val['country_name']),
					'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 			=> strtolower($val['short_name'])
				);
			}
		}
		return $data;
	}

	public function add_country() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('country_name', 'Country Name', 'xss_clean|required|trim|callback__unique_country');
		$this->form_validation->set_rules('nationality', 'Nationality', 'xss_clean|required|trim');
		$this->form_validation->set_rules('currency_name', 'Currency Name', 'xss_clean|required|trim');
		$this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'xss_clean|required|trim');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'country_name' 		=> $this->input->post('country_name'),
				'nationality' 		=> $this->input->post('nationality'),
				'currency_name' 	=> $this->input->post('currency_name'),
				'currency_symbol' => $this->input->post('currency_symbol'),
				'date_added' 			=> date('Y-m-d'),
				'user_id' 				=> $this->session->userdata('u_id')
			);

			$raw = $this->country->add_country($data);
			if($raw!=FALSE && is_array($raw)) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'country_id' 			=> $val['country_id'], 
						'country_name' 		=> strtolower($val['country_name']),
						'nationality' 		=> strtolower($val['nationality']),
						'currency_name' 	=> strtolower($val['currency_name']),
						'currency_symbol' => strtoupper($val['currency_symbol']),
						'date_added' 			=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
						'added_by' 				=> strtolower($val['short_name'])
					);
				}
				$res['success'] = true; 
			}
		} else {
  		$res['data'] = validation_errors();
  	}
		echo json_encode($res);
	}

	public function _unique_country($str) {

		$row_id = $this->input->post('co_id');
		$where = array('country_name' => '"'.$str.'"');

		if($this->common->tbl_unique('country_master', 'country_name', 'country_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_country", "The Country Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function edit_country() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('co_name', 'Country Name', 'xss_clean|required|trim|callback__unique_country');
		$this->form_validation->set_rules('co_nationality', 'Nationality', 'xss_clean|trim');
		$this->form_validation->set_rules('co_currency', 'Currency Name', 'xss_clean|trim');
		$this->form_validation->set_rules('co_symbol', 'Currency Symbol', 'xss_clean|trim');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'country_name' 		=> $this->input->post('co_name'),
				'nationality' 		=> $this->input->post('co_nationality'),
				'currency_name' 	=> $this->input->post('co_currency'),
				'currency_symbol' => $this->input->post('co_symbol')
			);

			$raw = $this->country->edit_country($data);
			if($raw!=FALSE) {
				$res['data'] = $data;
				$res['success'] = true; 
			}
		} else {
  		$res['data'] = validation_errors();
  	}
		echo json_encode($res);
	}

	public function all_countries() {

		$data = array();
		$row 	= array();
		$txtVal = $this->input->post('txtVal');
		if($txtVal) {
			$raw = $this->country->all_countries($txtVal);
			if($raw!=FALSE && is_array($raw)) {
				foreach ($raw as $key => $val) {
					$row['id'] 		= $val['country_id'];
					$row['value'] = $val['country_name'];
					$row['label'] = $val['country_name'];
					$data[] = $row;
				}
			}
		}
		echo json_encode($data);
	}

	public function all_cities() {

		$data = array();
		$row 	= array();
		$txtVal = $this->input->post('txtVal');
		if($txtVal) {
			$raw = $this->country->all_cities($txtVal);
			if($raw!=FALSE && is_array($raw)) {
				foreach ($raw as $key => $val) {
					$row['id'] 		= $val['city_id'];
					$row['value'] = $val['city_name'];
					$row['label'] = $val['city_name'];
					$data[] = $row;
				}
			}
		}
		echo json_encode($data);
	}

	public function all_nationalities() {

		$data = array();
		$txtVal = $this->input->post('txtVal');
		if($txtVal) {
			$raw = $this->country->all_nationalities($txtVal);
			if($raw!=FALSE && is_array($raw)) {
				foreach ($raw as $key => $val) {
					$data[] = $val['nationality'];
				}
			}
			else{
				$data[] = '';
			}
		}
		echo json_encode($data);
	}

	public function delete_country() {

		$data['data'] = NULL;
		$coId = $this->input->post('coId');
		if($coId) {
			$raw = $this->country->delete_country($coId);
			if($raw!=FALSE) {
				$data['data'] = true;
			}
		}
		echo json_encode($data);
	}

	public function add_city() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('city_name', 'City Name', 'xss_clean|required|trim|callback__unique_city');
		$this->form_validation->set_rules('h_ci_country_id', 'Country Name', 'xss_clean|required|trim|callback__id_int');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'city_name' 	=> $this->input->post('city_name'),
				'country_id' 	=> $this->input->post('h_ci_country_id'),
				'date_added' 	=> date('Y-m-d'),
				'user_id' 		=> $this->session->userdata('u_id')
			);

			$raw = $this->country->add_city($data);
			if($raw!=false && is_array($raw)) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'city_id' 			=> $val['city_id'], 
						'city_name' 		=> strtolower($val['city_name']),
						'country_name' 	=> strtolower($val['country_name']),
						'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
						'added_by' 			=> strtolower($val['short_name'])
					);
				}
				$res['success'] = true; 
			}
		} else {
  		$res['data'] = validation_errors();
  	}
		echo json_encode($res);
	}

	public function _id_int($str) {

		if( $str<=0 ) {

			$this->form_validation->set_message("_id_int", "Country doesn't exist in the database." );
			return FALSE;
		}
		return TRUE;
	}

	public function _unique_city($str) {

		$row_id = $this->input->post('ci_id');
		$where = array('city_name' => '"'.$str.'"');

		if($this->common->tbl_unique('city_master', 'city_name', 'city_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_city", "The City Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function delete_city() {

		$data['data'] = NULL;
		$ciId = $this->input->post('ciId');
		if($ciId) {
			$raw = $this->country->delete_city($ciId);
			if($raw!=FALSE) {
				$data['data'] = true;
			}
		}
		echo json_encode($data);
	}

	public function add_town() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('town_name', 'Town Name', 'xss_clean|required|trim|callback__unique_town');
		$this->form_validation->set_rules('h_to_city_id', 'City Name', 'xss_clean|required|trim|callback__id_int');
		$this->form_validation->set_rules('h_to_country_id', 'Country Name', 'xss_clean|required|trim|callback__id_int');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'town_name' 	=> $this->input->post('town_name'),
				'city_id' 		=> $this->input->post('h_to_city_id'),
				'country_id' 	=> $this->input->post('h_to_country_id'),
				'date_added' 	=> date('Y-m-d'),
				'user_id' 		=> $this->session->userdata('u_id')
			);

			$raw = $this->country->add_town($data);
			if($raw!=FALSE && is_array($raw)) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'town_id' 			=> $val['town_id'], 
						'town_name' 		=> strtolower($val['town_name']),
						'city_name' 	=> strtolower($val['city_name']),
						'country_name' 	=> strtolower($val['country_name']),
						'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
						'added_by' 			=> strtolower($val['short_name'])
					);
				}
				$res['success'] = true; 
			}
		} else {
  		$res['data'] = validation_errors();
  	}
		echo json_encode($res);
	}

	public function _unique_town($str) {

		$row_id = $this->input->post('to_id');
		$where = array('town_name' => '"'.$str.'"');

		if($this->common->tbl_unique('town_master', 'town_name', 'town_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_town", "The Town Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function delete_town() {

		$data['data'] = NULL;
		$toId = $this->input->post('toId');
		if($toId) {
			$raw = $this->country->delete_town($toId);
			if($raw!=FALSE) {
				$data['data'] = true;
			}
		}
		echo json_encode($data);
	}

	//fetches records to be displayed by the autocomplete select
  	public function get_select_list_data() {

		$data = array();
		$row 	= array();
		$txtVal = $this->input->post('txtVal');
		$existing_ids = $this->input->post('existing_ids');
		if($txtVal) {
			$raw = $this->country->get_select_list_data($txtVal, $existing_ids);
			if($raw!=FALSE && is_array($raw)) {
				foreach ($raw as $key => $val) {
					$row['id'] 		= $val['country_id'];
					$row['label'] = $val['country_name'];
					$row['value'] = $val['country_name'];
					$data[] = $row;
				}
			}
		}
		echo json_encode($data);
	}
}