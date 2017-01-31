<?php 
  $this->load->view('includes/header'); 
  $user_name = $this->session->userdata('user_name');
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style_in.css') ?>">

<header class="navbar navbar-fixed-top bs-docs-nav" role="banner">
  <div class="header_in  col-lg-12">
  <a href="<?php echo base_url('dashboard/index'); ?>" class="navi_in_logo"></a>
  <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation" style="padding-right:20px;padding-top: 20px;">
    <ul class="nav navbar-nav navbar-right col-lg-10 pull-right">
      <li class="col-lg-3 pull-right" style="float:left;padding-top:2px;z-index:1">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon glyphicon-user"></span>
        <?php echo ucwords($user_name); ?>
        <b class="caret"></b>
      </a>
      </li>
      <li class="pull-right" style="float:left;padding-top: 20px;color:#999">|</li>
      <li class="pull-right" style="z-index:1">
        <a href="<?php echo base_url('dashboard/index'); ?>" class="">
          <img src="<?php echo base_url('assets/images/home-btn.png') ?>" class="navi_homelink" /> 
        </a>
      </li>
      <li id="f_msg" class="col-lg-5 pull-right">
      </li>
    </ul>
  </nav>
  </div>
</header>

        

