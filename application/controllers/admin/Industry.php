<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH."controllers/Base_Controller.php";

class Industry extends Base_Controller {

	public function __construct()	{

		parent::__construct();
		$this->module 		= basename(dirname(__DIR__));
		$this->class 			= $this->router->class;
		$this->method 		= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Industry_model', 'industry', true);
	}

	public function index() {

		$data['headers']	= $this;
		$data['js_module'] = $this->class;

		$raw = $this->industry->get_data();
		if($raw!=FALSE) {
			foreach ($raw as $key => $val) {
				$data['data'][] = array(
					'industry_id' 	=> $val['industry_id'], 
					'industry_name' => strtolower($val['industry_name']),
					'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 			=> strtolower($val['short_name'])
				);
			}
		}

		$this->load->view('desktop/admin/industry_list', $data);
	}

	public function add_industry() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('industry_name', 'Industry Name', 'xss_clean|required|trim|callback__unique_industry');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'industry_name' 	=> $this->input->post('industry_name'),
				'date_added' 			=> date('Y-m-d'),
				'user_id' 				=> $this->session->userdata('u_id')
			);

			$raw = $this->industry->add_industry($data);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'industry_id' 	=> $val['industry_id'], 
						'industry_name' => $val['industry_name'], 
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

	public function _unique_industry($str) {

		$row_id = $this->input->post('in_id');
		$where = array('industry_name' => '"'.$str.'"');

		if($this->common->tbl_unique('industry_master', 'industry_name', 'industry_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_industry", "The Industry Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function delete_industry() {

		$data['data'] = NULL;
		$inId = $this->input->post('inId');
		if($inId) {
			$raw = $this->industry->delete_industry($inId);
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

		if($txtVal) {
			$raw = $this->industry->get_select_list_data($txtVal);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$row['id'] 		= $val['industry_id'];
					$row['label'] = $val['industry_name'];
					$row['value'] = $val['industry_name'];
					$data[] = $row;
				}
			}
		}
		echo json_encode($data);
	}
}
