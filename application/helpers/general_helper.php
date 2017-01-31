<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sends notification email
 *
 * @access public
 * @param	string	   the Subject of an email
 * @param	string	   the desired title
 * @param	html/text  an html message
 * @param 	string      email address
 * @param 	string     full name of the recepient
 * @return	boolean
 */
if( !function_exists('sendNotification') ){
	function sendNotification($emailObject, $subject, $title, $msg, $email, $user_fullname){
		$emailObject->clear();
		$config['mailtype'] = "html";
		$emailObject->initialize($config);
		$emailObject->set_newline("\r\n");
		$emailObject->from('noreply@ihired.sg', 'iHired');
		$emailObject->subject($subject);
		$emailObject->to($email);
		$htmlMessage = "<div style='border:1px solid #ccc;font-family:Arial'>";
		$htmlMessage .= "<div style='height:94px;color:#b00;background-color: white;border-bottom: 1px solid;'><div style='height:25px;'>.</div><div style='height:30px;text-align:left;color: #b00;font-size:20px;padding-right:20px;font-family: monospace;margin-left: 15px;font-weight: bold;text-shadow: 0px 1px 1px;'><span style='float:left;margin-top:-22px;'><img src='".base_url()."/assets/dashboard/images/logo.jpg'></span><span style='float:right;font-family: monospace;font-style: italic;padding-top: 22px;text-shadow: black 0px 1px 3px;'>$title</span></div></div> ";
		$htmlMessage .= "<div style='padding:20px;'>";
		$htmlMessage .= "<br><p>Dear <stron>".ucfirst($user_fullname)."</strong>,</p><br>";
		$htmlMessage .= $msg;
		
		$htmlMessage .= "<p>Thank you,</p>";
		$htmlMessage .= "<p>Administrator@iHired.sg</p>";
		$htmlMessage .= "</div>";
		$htmlMessage .= "<div style='background-color: #b00;height:30px;width:100%;'>.</div>";
		$htmlMessage .= "</div>";


		$emailObject->message($htmlMessage);
		if ($emailObject->send())
			return true;
		return $emailObject->print_debugger();
	}
}

/**
 * Generates a random string
 *
 * @access public
 * @param integer(optional) 	the length of desired string
 * @return string
 */
if( !function_exists('generate_random_string') ){
	function generate_random_string($l = 6) {
		$c = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
		
		return $s;
	}
}
