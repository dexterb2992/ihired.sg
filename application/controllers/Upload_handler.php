<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'libraries/Uploader.php';

class Upload_handler extends CI_Controller {

	public function __construct()	{

		parent::__construct();
		$this->module 		= basename(dirname(__DIR__));
		$this->class 			= $this->router->class;
		$this->method 		= $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('User_master_model', 'user', true);
	}

	public function index() {

		$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/assets/images/user_images/';
		$valid_extensions = array( 'png', 'jpeg', 'jpg');
		$uploader 	= new FileUpload('uploadfile');

		$u_id = $this->session->userdata('user_id');
		$ext 	= $uploader->getExtension();
		$uploader->newFileName = $u_id.'.'.$ext;

		// Handle the upload
		$result = $uploader->handleUpload($upload_dir, $valid_extensions);
		// $result = $this->uploader->handle_upload($upload_dir, $valid_extensions);

		if (!$result) {
		  exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));  
		}

		$this->user->set_image($u_id, $uploader->newFileName);
		$this->session->set_userdata('user_image', $uploader->newFileName);
		echo json_encode(
			array('success' => true,
				'newFile' => base_url('assets/images/user_images/'.$uploader->newFileName) 
			)
		);
	}

}