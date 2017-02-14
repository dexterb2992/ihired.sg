<?php
require APPPATH."controllers/Base_Controller.php";

class Qualifications extends Base_Controller {

	public function __construct()	{

		parent::__construct();
		$this->module 		= basename(dirname(__DIR__));
		$this->class 			= $this->router->class;
		$this->method 		= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Qualifications_model', 'qualifications', true);
	}

	public function index() {

		$data['headers']	= $this;
		$data['js_module'] = $this->class;

		$raw = $this->qualifications->get_data();
		if($raw!=FALSE) {
			foreach ($raw as $key => $val) {
				$data['data'][] = array(
					'qualifications_id' 	=> $val['qualifications_id'], 
					'qualifications_name' => strtolower($val['qualifications_name']),
					'date_added' 		=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
					'added_by' 			=> strtolower($val['full_name'])
				);
			}
		}

		$this->load->view('desktop/admin/qualifications_list', $data);
	}

	public function add_qualifications() {

		$res['data'] = null; 
		$res['success'] = null; 

		$this->form_validation->set_rules('qualifications_name', 'Qualifications Name', 'xss_clean|required|trim|callback__unique_qualifications');

  	if ($this->form_validation->run() === TRUE)	{
			$data = array(
				'qualifications_name' => $this->input->post('qualifications_name'),
				'date_added' 		=> date('Y-m-d'),
				'user_id' 			=> $this->session->userdata('u_id')
			);

			$raw = $this->qualifications->add_qualifications($data);
			if($raw!=FALSE) {
				foreach ($raw as $key => $val) {
					$res['data'] = array(
						'qualifications_id' 		=> $val['qualifications_id'], 
						'qualifications_name' 	=> $val['qualifications_name'], 
						'date_added' 	=> ($val['date_added']=='0000-00-00')?'':date('d/m/Y', strtotime($val['date_added'])),
						'added_by' 		=> strtolower($val['short_name'])
					);
				}
				$res['success'] = true; 
			}
		} else {
  		$res['data'] = validation_errors();
  	}
		echo json_encode($res);
	}

	public function _unique_qualifications($str) {

		$row_id = $this->input->post('qu_id');
		$where = array('qualifications_name' => '"'.$str.'"');

		if($this->common->tbl_unique('qualifications_master', 'qualifications_name', 'qualifications_id', $row_id, $where)) {

			$this->form_validation->set_message("_unique_qualifications", "The Qualifications Name already exists." );
			return FALSE;
		}
		return TRUE;
	}

	public function delete_qualifications() {

		$data['data'] = NULL;
		$quId = $this->input->post('quId');
		if($quId) {
			$raw = $this->qualifications->delete_qualifications($quId);
			if($raw!=FALSE) {
				$data['data'] = true;
			}
		}
		echo json_encode($data);
	}
}
