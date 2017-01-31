<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller{

	public function __construct(){
		parent::__construct();

		if( $this->session->userdata('user_id') == null ){
			redirect( base_url('dashboard/index') );
		}

		$this->class = $this->router->class;
		$this->load->model('User_master_model', 'user', true);
	}


	public function password_change_by_user()	{

		$this->form_validation->set_rules('mynewpassword', 'New Password', 'trim|xss_clean|min_length[6]|required|trim');
		$this->form_validation->set_rules('myconpassword', 'Password confirmation', 'trim|xss_clean|required|trim|matches[mynewpassword]');
		
		$user_id = $this->session->userdata('user_id');
		$new_password = $this->input->post('myconpassword');
		
		$response['success'] = null;
		$response['msg'] = null;
		if($this->form_validation->run() == TRUE) {
			$res = $this->user->password_change($user_id, $new_password);
			$res2 = $this->user->change_request($user_id, 'N');
			$this->session->set_userdata( array('request' => 'N') );
			if( $res ){
				$response['success'] = true;
				$response['msg'] = "Password has been changed successfully.";

				$subject = 'New Password Changed';
				$title = "Password Changed";
				$msg = "<p>This email is to confirm that you have recently changed your password.</p>
						<p>Should you happen to forget it again then please use the forgot password link on your login screen to request for a new password to your email.</p>";

				$email = array( $this->session->userdata('email_id') );
				$full_name = $this->session->userdata('full_name');

				$email_response = sendNotification($this->email, $subject, $title, $msg,  $email, $full_name);
				if( $email_response !== true ){
					$response['success'] = false;
					$response['msg'] = "Your password has been changed. However email client failed to notify.";
					$response['error'] = $email_response;
				}
			}else{
				$response['msg'] = "<p>Unable to update your password right now. Please contact admin support.</p>";
				$response['success'] = false;
			}
		}else {
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}
		echo json_encode($response);
	}

	public function password_change() {

		$this->form_validation->set_rules('mynewpassword', 'New Password', 'trim|xss_clean|min_length[6]|required|trim');
		$this->form_validation->set_rules('myconpassword', 'Password confirmation', 'trim|xss_clean|required|trim|matches[mynewpassword]');
		
		$email = $this->input->post('email');
		$new_password = generate_random_string();
		$user = $this->user->find($email);

		$response['msg'] = null;

		if($this->form_validation->run() == true) {
			$response['msg'] = true;
			$this->user->password_change($user->user_id, $new_password);

			$subject = 'New Password Request';
			$title = "Password Changed";
			$msg = "<p>You have requested for a new password. Below is your new login details.</p>
					<p style='padding-top:20px;'>Login  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  :&nbsp;&nbsp;&nbsp;$email
					</p>
					<p>Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;$new_password</p><br>";

			
			$email_response = sendNotification($this->email, $subject, $title, $msg,  $email, $full_name);
			if( $email_response !== true ){
				$response['success'] = false;
				$response['msg'] = "Your password has been changed. However email client failed to notify.";
				$response['error'] = $email_response;
			}
		}else {

			$response['msg'] = false;
			// $response['errors'] = validation_errors();
			$response['error'] = $email_response;
		}
		echo json_encode($response);
	}

	public function listing(){
		$data = array();
		// $data['js_module'] = "";
		$data['js_module'] = $this->class;

		$data['data'] = $this->user->get_list(); 
		// $this->parser->parse("desktop/admin/user_list", $data);
		$this->parser->parse("user_list", $data);
	}

	public function delete(){
		$id = $this->input->post('id');

		if( $id == $this->session->userdata('user_id') ){
			echo json_encode(
				array('success' => false, 'msg' => 'Sorry, you can\'t delete yourself.')
			);
		}else{
			if( $this->user->delete($id) ){
				echo json_encode( array( 'success' => true, 'msg' => 'User successfully deleted.' ) );
			}else{
				echo json_encode( 
					array( 
						'success' => true, 
						'msg' => "Sorry, but we can't process your request right now. Please try again later." 
					) 
				);
			}
		}

		
	}

	public function create(){
		$this->form_validation->set_rules('full_name', 'Full name', 'xss_clean|required|trim');
		$this->form_validation->set_rules('short_name', 'Short Name', 'xss_clean|required|trim');
	  	$this->form_validation->set_rules('email_id', 'Email address', 'xss_clean|required|trim|valid_email');

	  	if ($this->form_validation->run() === TRUE)	{
	  		$full_name = $this->input->post('full_name');
	  		$short_name = $this->input->post('short_name');
	  		$email_id = $this->input->post('email_id');

	  		$new_user = $this->user->create($full_name, $short_name, $email_id);
	  		
	  		if($new_user !== false) {

	  			if( isset($new_user['success']) && $new_user['success'] == false ){
	  				$res = $new_user;
	  			}else{
	  				$new_user['created_on'] = '';
		  			if($new_user['created_on'] != null) {
			  			$new_user['created_on'] = date('d/m/Y', strtotime($new_user['created_on']));
			  		}
			  		$new_user['last_login'] = '';
		  			if($new_user['last_login'] != null) {
			  			$new_user['last_login'] = date('d/m/Y', strtotime($new_user['last_login']));
			  		}

		  			$res['success'] = true;
					$res['data'] = $new_user;
	  			}
			}
	  	}else {
	  		$res['data'] = validation_errors();
	  	}
	  	echo json_encode($res);
	}

	public function delete_dashimage() {

	  	$image_file = $this->input->post('imgd');
		unlink($image_file);	

		$u_id = $this->session->userdata('user_id');
		$this->user->remove_image($u_id);
	}

}