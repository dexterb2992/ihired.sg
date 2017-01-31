<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Function_master extends CI_Controller {

	public function __construct()	{

		parent::__construct();
		$this->module 	  = basename(dirname(__DIR__));
		$this->class 	  = $this->router->class;
		$this->method 	  = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Function_model', 'function', true);
	}

	public function index() {

		$data['headers']	= $this;
		$data['js_module'] = $this->class;

		$raw = $this->function->get_data();
		if($raw!=FALSE) {
			foreach ($raw as $key => $val) {
				$data['data'][] = array(
					'function_id' 	=> $val['function_id'], 
					'function_name' => strtolower($val['function_name']),
					'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 			=> strtolower($val['short_name'])
				);
			}
		}
		$this->load->view('desktop/admin/function_list', $data);
	}

	public function add_function() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('function_name', 'function Name', 'xss_clean|required|trim|callback__unique_function');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'function_name' => $this->input->post('function_name'),
				'date_added' 			=> date('Y-m-d'),
				'user_id' 				=> $this->session->userdata('u_id')
			);

			$raw = $this->function->add_function($data);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'function_id' 	=> $val['function_id'], 
						'function_name' => $val['function_name'], 
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

	public function _unique_function($str) {

		$row_id = $this->input->post('de_id');
		$where = array('function_name' => '"'.$str.'"');

		if($this->common->tbl_unique('function_master', 'function_name', 'function_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_function", "The function Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function delete_function() {

		$data['data'] = NULL;
		$deId = $this->input->post('deId');
		if($deId) {
			$raw = $this->function->delete_function($deId);
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
		// $existing_ids = $this->input->post('existing_ids');
		if($txtVal) {
			$raw = $this->function->get_select_list_data($txtVal);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$row['id'] 		= $val['function_id'];
					$row['label'] = $val['function_name'];
					$row['value'] = $val['function_name'];
					$data[] = $row;
				}
			}
		}
		echo json_encode($data);
	}
}
