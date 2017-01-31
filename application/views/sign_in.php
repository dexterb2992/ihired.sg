<html>
	<head>
		<title>iHired</title>
		<link rel="stylesheet" href="<?= asset_url('dashboard/bootstrap/css/bootstrap.css'); ?>" />
		<link rel="stylesheet" href="<?php asset_url("css/global.css"); ?>" />
		<link rel="stylesheet" href="<?php asset_url("css/normalize.css"); ?>" />
        <link rel="stylesheet" href="<?php asset_url("css/main.css"); ?>" />
		<link rel="stylesheet" href="<?php asset_url("css/styles.css"); ?>" />
		<link rel="stylesheet" href="<?php asset_url("css/main-symphinite.css"); ?>" />
        <link rel="stylesheet" href="<?php asset_url("css/menu.css"); ?>" />
        <link rel="stylesheet" href="<?php asset_url("css/site.css"); ?>" />
        
       	<link rel="stylesheet" href="<?php asset_url("jquery-plugin/colorbox/css/colorbox.css"); ?>" />

		<script type="text/javascript" src="<?php asset_url("_script/jquery-1.9.1.js"); ?>"></script>
		<script type="text/javascript" src="<?php asset_url("_script/jquery.validate.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php asset_url("_script/jquery-ui.js"); ?>"></script>
		<script src="<?= asset_url('dashboard/bootstrap/js/bootstrap.min.js'); ?>" ></script>
		<script src="<?= asset_url('dashboard/chosen/js/chosen.jquery.js'); ?>" ></script>
		<script src="<?= asset_url('js/common.js'); ?>" ></script>
		<script src="<?= asset_url('js/modules/index.js'); ?>" ></script>
		<script type="text/javascript">
			var base_url = '<?= base_url(); ?>';
		</script>
	</head>
</html>
<body>
	<div id="content">
		<div class="site edit" style="height: 380px; width: 950px;">
			<div id="f_msg"></div>
			<div class="float-l mt-40">
				<?php  $this->load->view('shared/welcome'); ?>
			</div>

			<div class="float-r w450 mt-40">
				<h3 class="popup_title">SIGN IN EMPLOYEE</h3>
				<hr/>
				<div class="error">
					<?= form_custom_error('signin'); ?>
					<span class="error">
						<strong>
							<?php 
								if($this->session->flashdata('msg')):
									echo $this->session->flashdata('msg');
								endif; 
							?>
						</strong>
					</span>
				</div>
				<?= form_open(base_url("home/login")); ?>
					<div class="element">
						<div class="label mr-20">
							<?= form_label("Email:", "email_id"); ?>
						</div>
						<div class="field">
							<div class="wforgot w300 ml-140">
								<?= form_input("email_id", field_value('email_id', null, (isset($email_id) ? $email_id : null)), "id='email_id' class='editor w100p'"); ?>
								<!-- <?= form_button("forgot_email", "Forgot?", "class='forgot popupBox'"); ?> -->
								<?php if(!isset($from_email) || !$from_email): ?>
									<?php //echo anchor(base_url('employee/forgot_email'), "Forgot?", array('class'=> "forgot popupBox")); ?>
								<?php endif; ?>
							</div>
							<?= form_custom_error('email_id', array('class' => "ml-140")); ?>
						</div>
					</div>
					<div class="element">
						<div class="label mr-20">
							<?= form_label("Password:", "password"); ?>
						</div>
						<div class="field">
							<div class="wforgot w300 ml-140">
								<?= form_password("password", "", "id='password' class='editor w100p'"); ?>
								<?php //echo anchor("employee/forgot_password", "Forgot?", array('class'=> "forgot popupBox")); ?>
								<a href="#!" class="forgot" data-toggle="modal" data-target="#modal_foget_password">Forgot?</a>
							</div>
							<?= form_custom_error('password', array('class' => "ml-140")); ?>
						</div>
					</div>
					<div class="element ml-140 mt-40">
						<?= form_submit("signin", "Sign In", "class='btn_get-started'"); ?>
					</div>
				<?= form_close(); ?>
			</div>
			<br class="clear-fix" />
		</div>
		<script>
			// assumes you're using jQuery
			
		</script>
	</div>
	<footer>
		<div class="copy mt-60">
			<div>
				<div>Copyright 2017 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  iHired Singapore Pte Ltd</div>
				<div>
					<ul>
						<li><a href="">Privacy & Security</a><span>|</span></li>
						<li><a href="">Terms of Use</a><span>|</span></li>
						<li><a href="">Patents & Trademarks</a><span>|</span></li>
						<li><a href="">Investor Relations</a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<!-- 
	*** Content 1 Log In MODAL 
	*-->
	    <div id="modal_foget_password" class="modal fade" tabindex="-1" role="dialog" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h5 class="modal-title">Forgot Password</h5>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-9">
								<form class="form-horizontal adjust-container" id="frm_sendEmail">
									<div class="margin-top--20 row">Please Enter your Email Address and we will send you a new password</div>
									<div class="form-group margin-top"> 
										<div class="inner-addon left-addon">      
											<input type="email" name="modalEmail1" class="form-control" id="modalEmail1" placeholder="Enter your Email" />
											<i class="glyphicon glyphicon-user"></i>
										</div>
									</div>
									<div class="row" id="forgot_password_error" style="color:#FF0000;display:none;margin-botton:10px;">
									</div>
									<div class="row">
										<button type="button" class="btn btn-small btn-default pull-right" data-dismiss="modal"> Go Back </button> 
										<button type="button" class="btn btn-small btn-primary pull-left" id="btn_sendEmail" onclick="send_email()" > Request Password </button>
									</div>
								</form>
							</div>
							<div class="col-md-2">
							<img src="<?= base_url('assets/images/default/forgot-man.png'); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- 
	*** END Content 1 Log In MODAL 
	*-->
</body>