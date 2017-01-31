<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function jquery_asset_url($uri = "", $is_echo = true)
{
	$path = base_url("assets/jquery/".$uri);

	if($is_echo)
	{
		echo $path;
	}
	else
	{
		return $path;
	}
}

function admin_asset_url($uri = "", $is_echo = true){
	$path = base_url("assets/admin/".$uri);

	if($is_echo)
	{
		echo $path;
	}
	else
	{
		return $path;
	}
}


function asset_url($uri = "", $is_echo = true)
{
	$path = base_url("assets/".$uri);

	if($is_echo)
	{
		echo $path;
	}
	else
	{
		return $path;
	}
}

function file_url($uri = "")
{
	$path = base_url("assets/".$uri);

	return $path;
}



function form_custom_error($field = '', $attributes = null)
{
	$_attributes = "";

	if(isset($attributes) && is_array($attributes)){
		if(isset($attributes['class']))
		{
			$attributes['class'] = $attributes['class']." "."error";
		}
		foreach($attributes as $key => $value)
		{
			$_attributes = $key."='".$value."' ";
		}
	}
	else
	{
		$_attributes = "class='error'";
	}

	return form_error($field, '<span '.$_attributes.'>', '</span>');
}







function redirect_colorbox($uri)
{
	$script = "<script type='text/javascript' src='".asset_url("_script/jquery-1.9.1.js", false)."'></script>";
	$script .= "<script type='text/javascript' src='".asset_url("jquery-plugin/colorbox/js/jquery.colorbox.js", false)."'></script>";
	$script .= "<script type='text/javascript'>";
	$script .= "$(function(){
					parent.$.fn.colorbox.close();
		  		});
		  			window.parent.location.href = '".$uri."'
				";
	$script .= "</script>";

	echo $script;
}

function redirect_popup($uri)
{
	$script = "<script type='text/javascript' src='".asset_url("_script/jquery-1.9.1.js", false)."'></script>";
	$script .= "<script type='text/javascript' src='".asset_url("jquery-plugin/colorbox/js/jquery.colorbox.js", false)."'></script>";

	$script .= "<script type='text/javascript'>";
	$script .= "$(function(){
					window.location.href = '".$uri."'
				});";
	$script .= "</script>";

	echo $script;
}



function close_colorbox()
{
	$script = "<script type='text/javascript' src='".asset_url("js/jquery-1.9.1.js", false)."'></script>";
	$script .= "<script type='text/javascript' src='".asset_url("js/jquery-ui.js", false)."'></script>";
	$script .= "<script type='text/javascript' src='".admin_asset_url("colorbox/js/jquery.colorbox.js", false)."'></script>";
	$script .= "<script type='text/javascript' src='".admin_asset_url("datatable/js/jquery.dataTables.min.js", false)."'></script>";
	$script .= "<script type='text/javascript'>";
	$script .= "$(function(){
					var dataTable = $(window.parent.document).find('.dataTable');

					$(dataTable).dataTable().fnReloadAjax();
					//parent.$('.dataTable').dataTable().fnReloadAjax();
					parent.$.fn.colorbox.close();
				});";
	$script .= "</script>";

	echo $script;
}



function is_admin($role_id = 0)
{
	if(!empty($role_id) && get_role($role_id) == "Administrator")
	{
		return true;
	}
	else
	{
		return false;
	}
}

function is_super_admin($role_id = 0)
{
	if(!empty($role_id) && get_role($role_id) == "SuperAdmin")
	{
		return true;
	}
	else
	{
		return false;
	}
}



function generate_password(&$password)
{
	$CI = get_instance();

	$CI->load->helper('string');

	$password = random_string('alpha', 8);

	return md5($password);
}

function generate_activation_code(&$activation_code)
{
	$CI = get_instance();

	$CI->load->helper('string');

	$activation_code = md5(uniqid(rand(), true));

	return $activation_code;
}


function custom_anchor($uri = "", $title = "", $attributes = null)
{
	$_attributes = "";

	if(isset($attributes))
	{
		foreach($attributes as $key => $value)
		{
			$_attributes .= $key . "=\"" . $value . "\"";
		}
	}

	return "<a href='".$uri."' ".$_attributes.">".$title."</a>";
}

function previous_url($not_post = false)
{
	$CI = get_instance();

	if(!$not_post)
		return $CI->input->post('previous_url');
	else
		return $_SERVER['HTTP_REFERER'];
}


function form_previous_url()
{
	return form_hidden("previous_url", isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('admin/admin'));
}

function set_path($path)
{
	return getcwd().$path;
}

function field_value($field = null, $prefix = null, $if_null = "")
{
	$post = array();


	$CI = get_instance();

	if(!empty($prefix) && !empty($_POST[$prefix]))
	{
		$post = $_POST[$prefix];
	}
	else
	{
		$post = $_POST;
	}


	if(!empty($field) && isset($post[$field]))
	{
		return $post[$field];
	}
	else
	{
		return $if_null;
	}
}

function array_value($value = array(), $index = "")
{
	if(array_key_exists($index, $value)){
		return $value[$index];
	}
	else
	{
		return "";
	}
}

function addOrdinalNumberSuffix($num)
{
	if(!in_array(( $num % 100 ), array(11, 12, 13))){
		switch ( $num % 10 ) {
			// Handle 1st, 2nd, 3rd
			case 1: return $num."st";
			case 2:  return $num.'nd';
        	case 3:  return $num.'rd';
		}
	}

	if(empty($num))
	{
		return "";
	}
	else{
		return $num.'th';
	}

}

function age($date)
{
	
	$my_date = str_replace(":", "", $date);
	$my_date = str_replace("-", "", $date);
	
	$my_date = intval($my_date);
	
	if(!empty($my_date))
	{
		$dobObject = new DateTime($date);
	    $nowObject = new DateTime();

	    $diff = $dobObject->diff($nowObject);

	    return $diff->y;
	}
	else
	{
		return "";
	}
}






function show_message($title = "", $message = "")
{
	$data = array();

	$CI = get_instance();

	$data = array(
		'title'		=> $title,
		'message'	=> $message
	);

	$CI->load->view("shared/show_message", $data);
}


function has_right($name)
{
	$CI = get_instance();

	foreach($CI->current_rights as $right)
	{
		if($name == $right['name'])
		{
			return true;
		}
	}

	return false;
}

