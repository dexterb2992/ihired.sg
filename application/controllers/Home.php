<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if( $this->session->userdata('user_id') !== null ){
			redirect( base_url('dashboard/index') );
		}

		$this->load->model('User_master_model', 'user', TRUE);
	}

	public function index()
	{
		$data['js_module'] = 'index';
		$this->load->view('sign_in2', $data);
	}

	public function login()
	{
		
		$data = array();
		$data['js_module'] = 'index';

		$signin = $this->input->post('email_id');
		$is_ok = true;

		if (empty($signin)){
			$this->load->view('sign_in2', $data);
		}else{
			$email_id = $this->input->post('email_id');
			$password = $this->input->post('password');

			$this->form_validation->set_rules('email_id', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == FALSE){
				$is_ok = false;
			}
	
			if (!$is_ok){
				$data['has_error'] = !$is_ok;
				$data['email_id'] = $email_id;

				$this->parser->parse('sign_in2', $data);
			}else{
				// let's login
				$user =  $this->user->authenticate($email_id, $password);
				
				if( isset($user) && $user != null ){
					if( $user->dash_access == "I" ){
						// this means, the it's a user's first-time login
						$this->user->change_access($user->user_id, 'Y');
					}

					$this->session->set_userdata(array(
					    "user_id" => $user->user_id,
					    "u_id" => $user->user_id,
						"full_name" => $user->full_name,
						"short_name" => $user->short_name,
						"email_id" => $user->email_id,
						"user_type" => $user->user_type,
						"created_on" => $user->created_on,
						"active" => $user->active,
						"password" => $user->password,
						"session_id" => $this->session->userdata('session_id'),
						"confirmed" => $user->confirmed,
						"user_image" => $user->user_image,
						"last_login" => $user->last_login,
						"contact_no" => $user->contact_no,
						"status" => $user->status,
						"dash_access" => $user->dash_access,
						"request" => $user->request
					));
					
					redirect( base_url('dashboard/index') );
				}else{
					$this->session->set_flashdata('msg', 'Email or password does not match our records.');
					// $data = array();
					$this->parser->parse('sign_in2', $data);
				}
				
			}
		}
	}

	public function ck_ifEmail() {

		$res['msg'] = null; 
		$res['typ'] = null; 
		$res['mail'] = null;
		$email = $this->input->post('modalEmail1');	
		$this->form_validation->set_rules('modalEmail1', 'Email address', 'xss_clean|required|trim|valid_email');
		if ($this->form_validation->run() === TRUE)	{

			$user = $this->user->find($email, 'array');

			if($user !== false) {

				$new_password = generate_random_string();
				$full_name = $user['full_name'];

				$this->user->password_change($user['user_id'], $new_password);
				$this->user->change_request($user['user_id'], 'Y');


				// $emails = array($email);
				$subject = 'New Password Request';
				$title = "Password Changed";
				$msg = "<p>You have requested for a new password. Below is your new login details.</p>
						<p style='padding-top:20px;'>Login  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  :&nbsp;&nbsp;&nbsp;$email
						</p>
						<p>Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;$new_password</p><br>";

				
				$email_response = sendNotification($this->email, $subject, $title, $msg,  $email, $full_name);
				if( $email_response ){
					usleep(1000);
					$res['mail'] = $email;
					$res['msg'] = "Email sent! Please check your email for your new password.";
					$res['typ'] = 'success';
				} else {
					$res['mail'] = $email;
					$res['msg'] = "Something went wrong! Please try again.";
					$res['typ'] = 'danger';
					$res['error'] = $email_response;
				}
			} else {
				$res['mail'] = $email;
				$res['msg'] = "This Email doesn't exist.";
				$res['typ'] = 'danger';
			}
		}else {
			$res['mail'] = 'No Email Address.';
		    $res['msg'] = validation_errors();
		    $res['typ'] = 'danger';
		}
		echo json_encode($res);
	}

}
