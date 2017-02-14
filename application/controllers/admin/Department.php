<?php
require APPPATH."controllers/Base_Controller.php";

class Department extends Base_Controller {

	public function __construct()	{

		parent::__construct();
		$this->module 		= basename(dirname(__DIR__));
		$this->class 			= $this->router->class;
		$this->method 		= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Department_model', 'department', true);
	}

	public function index() {

		$data['headers']	= $this;
		$data['js_module'] = $this->class;

		$raw = $this->department->get_data();
		if($raw!=FALSE) {
			foreach ($raw as $key => $val) {
				$data['data'][] = array(
					'department_id' 	=> $val['department_id'], 
					'department_name' => strtolower($val['department_name']),
					'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 			=> strtolower($val['short_name'])
				);
			}
		}
		$this->load->view('desktop/admin/department_list', $data);
	}

	public function add_department() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('department_name', 'Department Name', 'xss_clean|required|trim|callback__unique_department');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'department_name' => $this->input->post('department_name'),
				'date_added' 			=> date('Y-m-d'),
				'user_id' 				=> $this->session->userdata('u_id')
			);

			$raw = $this->department->add_department($data);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'department_id' 	=> $val['department_id'], 
						'department_name' => $val['department_name'], 
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

	public function _unique_department($str) {

		$row_id = $this->input->post('de_id');
		$where = array('department_name' => '"'.$str.'"');

		if($this->common->tbl_unique('department_master', 'department_name', 'department_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_department", "The Department Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function delete_department() {

		$data['data'] = NULL;
		$deId = $this->input->post('deId');
		if($deId) {
			$raw = $this->department->delete_department($deId);
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
			$raw = $this->department->get_select_list_data($txtVal);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$row['id'] 		= $val['department_id'];
					$row['label'] = $val['department_name'];
					$row['value'] = $val['department_name'];
					$data[] = $row;
				}
			}
		}
		echo json_encode($data);
	}
}
