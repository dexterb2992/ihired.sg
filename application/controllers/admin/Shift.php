<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shift extends CI_Controller {

	public function __construct()	{

		parent::__construct();
		$this->module 		= basename(dirname(__DIR__));
		$this->class 			= $this->router->class;
		$this->method 		= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Shift_model', 'shift', true);
	}

	public function index() {

		$data['headers']	= $this;
		$data['js_module'] = $this->class;

		$raw = $this->shift->get_data();
		if($raw!=FALSE) {
			foreach ($raw as $key => $val) {
				$data['data'][] = array(
					'shift_id' 		=> $val['shift_id'], 
					'shift_name' 	=> strtolower($val['shift_name']),
					'date_added' 	=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 		=> strtolower($val['short_name'])
				);
			}
		}

		$this->load->view('desktop/admin/shift_list', $data);
	}

	public function add_shift() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('shift_name', 'Shift Name', 'xss_clean|required|trim|callback__unique_shift');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'shift_name' => $this->input->post('shift_name'),
				'date_added' 		=> date('Y-m-d'),
				'user_id' 			=> $this->session->userdata('u_id')
			);

			$raw = $this->shift->add_shift($data);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'shift_id' 	=> $val['shift_id'], 
						'shift_name' => $val['shift_name'], 
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

	public function _unique_shift($str) {

		$row_id = $this->input->post('sh_id');
		$where = array('shift_name' => '"'.$str.'"');

		if($this->common->tbl_unique('shift_master', 'shift_name', 'shift_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_shift", "The Shift Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function delete_shift() {

		$data['data'] = NULL;
		$shId = $this->input->post('shId');
		if($shId) {
			$raw = $this->shift->delete_shift($shId);
			if($raw!=FALSE) {
				$data['data'] = true;
			}
		}
		echo json_encode($data);
	}
}
