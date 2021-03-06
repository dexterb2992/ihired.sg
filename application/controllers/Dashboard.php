<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require "Base_Controller.php";

class Dashboard extends Base_Controller{
	public function __construct(){

		parent::__construct();
		if( $this->session->userdata('user_id') == null ){
			redirect( base_url('/') );
		}

		$this->load->model('User_model', 'user', true);

		$this->quick_modules = array(
			array(
				"uri" => "user/listing",
				"label" => "Create a New User"
			),
			array(
				"uri" => "admin/country",
				"label" => "Create a New Country"
			),
			array(
				"uri" => "admin/company",
				"label" => "Company Management"
			),
			array(
				"uri" => "admin/jobs_access",
				"label" => "Job Access"
			),
			array(
				"uri" => "admin/skills_master",
				"label" => "Skills Master"
			)
		);

		$this->top_modules = array(
			array(
				'uri' => '',
				'label' => 'More',
				'sub_modules' => array(
					array(
						'uri' => 'admin/position',
						'label' => 'Position Master',
					),
					array(
						'uri' => 'admin/industry',
						'label' => 'Industry Master',
					),
					array(
						'uri' => 'admin/shift',
						'label' => 'Shift Master',
					),
					array(
						'uri' => 'admin/qualification',
						'label' => 'Qualifications Master',
					),
					array(
						'uri' => 'admin/department',
						'label' => 'Department Master',
					),
					array(
						'uri' => 'admin/function_master',
						'label' => 'Function Master',
					),
					array(
						"uri" => "admin/university",
						"label" => "University Master"
					),
					array(
						"uri" => "admin/license",
						"label" => "License Master"
					),
					array(
						"uri" => "admin/membership",
						"label" => "Membership Master"
					),
				)
			)
		);
	}

	public function index(){
		$this->current_user = $this->session->userdata;
		$data = array();
		$this->parser->parse('templates/header.php', $data);
		$this->parser->parse("dashboard", $data);
		$this->parser->parse('templates/footer.php', $data);
	}

	public function logout(){
		$user_data = $this->session->all_userdata();

        foreach ($user_data as $key => $value) {
            $this->session->unset_userdata($key);
        }

	    $this->session->sess_destroy();
	    redirect( base_url('/') );
	}

	public function invite(){
		$email = strtolower($this->input->post('email_id'));
		$name = ucfirst($this->input->post('name'));
		$user_id = $this->input->post('u_id');
		$subject = "Dashboard Access for $name";
		$title = "Dashboard Access";
		// $emails = array($email);

		$newpassword = generate_random_string();
		// $user = $this->user->find($email);
		$this->user->password_change($user_id, $newpassword);
		$this->user->change_access($user_id, 'I'); // change dash_access to "Invited"

		$msg = "<p>Welcome to iHired!</p><p>You are now provided with access to your dashboard. Below is your login details.</p><br><p style='padding-top:20px;'>Login  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  :&nbsp;&nbsp;&nbsp;$email</p><p>Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;$newpassword</p><br><a style='font-size: 1.4em;max-width: 300px;background-color: #71c05b;color: #FFFFFF;display: inline-block;margin-bottom: 0;font-weight: normal;text-align: center;vertical-align: middle;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;background-image: none;border: 1px solid transparent;white-space: nowrap; padding: 8px 12px;line-height: 1.42857143;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;display:block;text-decoration:none;' href='".site_url("home/index")."'>Login</a>";

		$response = sendNotification($this->email, $subject, $title, $msg, $email, $name);

		if( $response === true ){
			echo json_encode( array("success" => true) );
		}else{
			$this->user->change_access($user_id, 'P'); // reset dash_access to "Pending"
			echo json_encode( array("success" => false, "error" => $response) );
		}
	}

}