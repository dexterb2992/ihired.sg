<?php 
$this->load->view('includes/header'); 
?>

<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header" style="width:100%">
      <a href="./" class="navbar-brand">
      <img src="<?php echo base_url('assets/images/default/logo-syringe.png') ?>" />
      </a>
      <a href="javascript:void(0);" class="navbar-brand">
      <img src="<?php echo base_url('assets/images/default/nav-partition.png') ?>" style="margin:0 30px 0 50px" />
      </a>
      <span style="float:left;font-size:37px;width:450px;font-family:helvetica;text-transform:none;margin-top:28px;">
      <span style="color:#010008">Admin </span>
      <span style="color:#d5252f">Login</span>
      </span>
      <span style="float:left;width:380px;margin-top:10px;">
      <!-- Flashdata -->
      <div id="f_msg"></div>
    <!-- Flashdata -->
      </span>
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
  </div>
</div>
<div class="container">

  <?= form_open(base_url("home/login"), array('class' => 'form-horizontal', 'style' => 'margin-top:250px;')); ?>
    <div class="col-lg-6 adjust-container" style="background-color:rgba(255, 255, 255, 0.56);  border-radius: 6px;  -webkit-box-shadow: 0 0 10px 1px rgba(00,00,00,.05);   box-shadow: 0 0 10px 1px rgba(00,00,00,.05);padding:30px 35px 30px 30px;">
    <?php if( form_custom_error('signin') || $this->session->flashdata('msg') ): ?>
      <div class="alert alert-danger">
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
    <?php endif; ?>
    <div class="col-lg-9">
      <?php 
      $hasError = '';
      if( form_error('inputEmail') ) $hasError = 'has-error';
      ?>
      <div class="form-group"> 
        <div class="inner-addon left-addon">      
          <input type="email" name="email_id" value="<?php echo $this->input->post('inputEmail'); ?>" class="form-control login-element" id="inputEmail" placeholder="Enter your Email" />
          <i class="glyphicon glyphicon-user"></i>
          
        </div>
        <?= form_custom_error('email_id', array('class' => "ml-140")); ?>
      </div>
      <div class="form-group">
        <div class="inner-addon left-addon"> 
          <input type="password" name="password" class="form-control login-element" id="inputPassword" placeholder="Enter your Password" required="required" />
          <i class="glyphicon glyphicon-lock"></i>
          <a href="#modal_sendEmail" data-toggle="modal" class="pull-right" id="forgot_login" style="float:left">
            <img src="<?php echo base_url('assets/images/default/btn_forgot.png') ?>" />
          </a>
        </div>
        <?= form_custom_error('password', array('class' => "ml-140")); ?>
      </div>
      <div class="form-group">
        <input type="checkbox" id="ck_remember"> Remember me
      </div>
    </div>
    <div class="col-lg-offset-1 col-lg-2">
      <div class="form-group margin-top pull-right">
      <!-- 303d4e -->
        <button type="reset" id="clear-login-form" class="btn btn-md btn-default margin-top--20">Clear <span class="glyphicon glyphicon-remove" style="margin-left:13px;"></span></button>
        <button type="submit" class="btn btn-md btn-primary" style="margin-top:10px" name="signin">Sign In 
          <span class="glyphicon glyphicon-log-in"></span>
        </button>
      </div>
    </div>
    </div>
  <?= form_close(); ?>
</div>

<!-- Forgot Log In MODAL -->
<div class="modal fade"  id="modal_sendEmail">
  <div class="modal-dialog">
    <div class="modal-content" id="modal_container">
    <!-- Contents here -->
    </div>
  </div>
</div>
<!-- *END Forgot Log In MODAL -->


<!-- 
*** Content 1 Log In MODAL 
*-->
<div id="content1" style="display:none">
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
        <img src="<?php echo base_url('assets/images/default/forgot-man.png'); ?>">
      </div>
    </div>
  </div>
</div>
<!-- 
*** END Content 1 Log In MODAL 
*-->

<!-- 
*** Content 2 Log In MODAL 
*-->
<div id="content2" class="hide" style="display:none">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h5 class="modal-title">Now check your Email</h5>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-9">
        <form class="form-horizontal adjust-container" id="" >
     <!--  <div class="row margin-top- -20">
        <div id="modal_flash" class="alert hide"></div>
      </div> -->
      <div class="margin-top--20 row">An email address has been sent to the below email address which is registered email for your account</div>
      <div class="form-group margin-top"> 
        <div class="inner-addon left-addon">      
          <input type="email" name="modalEmail2" class="form-control" readonly="readonly" id="modalEmail2" style="background-color:#71c05b;color:#FFFFFF;" />
          <i class="glyphicon glyphicon-user"></i>
        </div>
      </div>
    </form>
      </div>
      <div class="col-md-2">
      <div class="row">
        <button type="button" class="btn btn-small btn-primary pull-left form-control" data-dismiss="modal"> OK </button>
      </div>
      </div>
    </div>
    <hr />
      <div style="color:blue;font-size:11px; margin-left:23px;"> Did you get the Email? Please check your Spam or Junk. Else click &nbsp;<a href="javascript:void(0);" style="color:red" onclick="openCont1()">Forgot Password</a> again. 
      </div>
  </div>
</div>
<!-- 
*** END Content 2 Log In MODAL 
*-->


<script type="text/javascript">
$(function() {

  if( $("#f_data").is(':visible') ) {
    $("#f_data").fadeOut(5000);
  }
});
</script>