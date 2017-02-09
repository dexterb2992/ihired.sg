<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH."controllers/Base_Controller.php";

class Position extends Base_Controller {

	public function __construct()	{

		parent::__construct();
		$this->module 		= basename(dirname(__DIR__));
		$this->class 			= $this->router->class;
		$this->method 		= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Position_model', 'position', true);
	}

	public function index() {

		$data['headers']	= $this;
		$data['js_module'] = $this->class;

		$raw = $this->position->get_data();
		if($raw!=FALSE) {
			foreach ($raw as $key => $val) {
				$data['data'][] = array(
					'position_id' 	=> $val['position_id'], 
					'position_name' => strtolower($val['position_name']),
					'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 			=> strtolower($val['short_name'])
				);
			}
		}

		$this->load->view('desktop/admin/position_list', $data);
	}

	public function add_position() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('position_name', 'Position Name', 'xss_clean|required|trim|callback__unique_position');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'position_name' => $this->input->post('position_name'),
				'date_added' 		=> date('Y-m-d'),
				'user_id' 			=> $this->session->userdata('u_id')
			);

			$raw = $this->position->add_position($data);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'position_id' 	=> $val['position_id'], 
						'position_name' => $val['position_name'], 
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

	public function _unique_position($str) {

		$row_id = $this->input->post('po_id');
		$where = array('position_name' => '"'.$str.'"');

		if($this->common->tbl_unique('position_master', 'position_name', 'position_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_position", "The Position Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function delete_position() {

		$data['data'] = NULL;
		$poId = $this->input->post('poId');
		if($poId) {
			$raw = $this->position->delete_position($poId);
			if($raw!=FALSE) {
				$data['data'] = true;
			}
		}
		echo json_encode($data);
	}
}
