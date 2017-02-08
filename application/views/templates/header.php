<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>iHired Dashboard</title>

		<link rel="shortcut icon" href="<?= asset_url("images/favicons.png"); ?>" type="image/x-icon" />
		<!-- Bootstrap 3 -->
		<link rel="stylesheet" href="<?= asset_url("jquery-plugin/bootstrap/css/bootstrap.css"); ?>" />
		<link rel="stylesheet" href="<?= asset_url("jquery-plugin/chosen/css/bootstrap-chosen.css"); ?>">
		<link rel="stylesheet" href="<?= asset_url("css/jquery-ui.css"); ?>" />
		<link rel="stylesheet" href="<?= asset_url("css/menu.css") ?>" />
		<link rel="stylesheet" href="<?= asset_url("css/global.css"); ?>" />
		<link rel="stylesheet" href="<?= asset_url("css/normalize.css") ?>" />
	    <link rel="stylesheet" href="<?= asset_url("css/main.css") ?>" />
		<link rel="stylesheet" href="<?= asset_url("css/styles.css") ?>" />
		<link rel="stylesheet" href="<?= asset_url("css/dashboard_container.css") ?>" />
		<link rel="stylesheet" href="<?= asset_url("jquery-plugin/colorbox/css/colorbox.css"); ?>" />

		<script>
			var base_url  = '<?= base_url(); ?>';
		</script>

		<script src="<?= asset_url("js/jquery-3.1.1.min.js"); ?>"></script>
		<script src="<?= asset_url("js/jquery-migrate-3.0.0.js"); ?>"></script>
		<script src="<?= asset_url("jquery-plugin/jquery.validate.min.js"); ?>"></script>
		<script src="<?= asset_url("jquery-plugin/bootstrap/js/bootstrap.min.js"); ?>"></script>
		<script src="<?= asset_url("jquery-plugin/chosen/js/chosen.jquery.js"); ?>"></script>
		<script src="<?= asset_url("js/jquery-ui.js"); ?>"></script>
		<script src="<?= asset_url("jquery-plugin/bootbox.min.js"); ?>" ></script>
		<script src="<?= asset_url("js/common.js"); ?>"></script>
		<script src="<?= asset_url("js/menu.js"); ?>"></script>
		<script src="<?= asset_url("sitejs/global.js"); ?>"></script>
		<script src="<?= asset_url("sitejs/autosuggest.js"); ?>"></script>
		<script src="<?= asset_url("js/main.js"); ?>"></script>


		<link rel="stylesheet" href="<?= asset_url("jquery-plugin/dataTables/css/jquery.dataTables.css"); ?>" />
		<script src="<?= asset_url("jquery-plugin/dataTables/js/jquery.dataTables.js"); ?>"></script>

        <!-- <script src="<?= asset_url("js/jquery.jgrowl.js"); ?>"></script>
        <link rel="stylesheet" href="<?= asset_url("css/jquery.jgrowl.css"); ?>" /> -->
        
        <!-- <script src="<?= file_url("jquery/dropareaa.js"); ?>"></script> -->
        <script src="<?= asset_url('js/SimpleAjaxUploader.js'); ?>"></script>
		<style>
            .dropareaa {
                position:relative;
                text-align: center;
            }
            .multiple {
                position:relative;
                height: 20px;
            }
            .dropareaa div, .dropareaa input, .multiple div, .multiple input {
                position: absolute;
                top:0;
                width: 100%;
                height: 100%;
            }
            .dropareaa input, .multiple input {
                cursor: pointer; 
                opacity: 0; 
            }
            .dropareaa .instructionss, .multiple .instructionss {
                /*border: 2px dashed #ddd;
                opacity: .8;*/
                margin-top: 136px;
                height: 30px;
                background: #6A6A6A;
                width: 170px;
            }
            .dropareaa .instructionss, .multiple .instructionss label {
                color: #fff !important;
								opacity: 0.5;
								font-size: 16px !important;
            }
            .dropareaa .instructionss.over, .multiple .instructionss.over {
                border: 2px dashed #B43434;
                background: #ffa;
            }
            .dropareaa .progress, .multiple .progress {
                position:absolute;
                bottom: 0;
                width: 100%;
                height: 0;
                color: #B43434;
                /*background: #E26262;*/
            }
            .multiple .progress {
                width: 0;
                height: 100%;
            }

            #areas { float: left; width: 480px; }
            div.sspot {
                float: left;
                margin-left: 3px;
									margin-top: 2px;
                min-height: 166px;
                box-shadow: 1px 1px 8px 1px rgba(0, 0, 0, 0.3);
            }
              
        </style>

	</head>


	<body>
		<?php $this->load->view('shared/system'); ?>

			<div id="globalErrorMsg"></div>
	        <div id="top-wrapper" class="dashboard_wide">

	        	<section>

	            	<header>
	                	<?php 
	                		$u_img  = $this->session->userdata('user_image');
							$target_dir = $_SERVER['DOCUMENT_ROOT'].'/assets/images/user_images/';
							$url  = base_url('assets/images/user_images').'/'.$u_img;
							$imgd = base_url('assets/images/pix.jpg');
							$hasImg = '';

							// if ( is_readable($target_dir.$u_img) ) {
							if($u_img!=NULL) {
								$imgd = $url;
								$hasImg = 'hasImg';
							}
	                	?>
						<div class="photo">
					      <div id="img_ctrl_cont">
					        <div class="img_ctrl hide" id="uploadBtn">Upload</div>
					        <div class="img_ctrl hide" id="deleteBtn">Delete</div>
					      </div>
					      <a href="javascript:void(0)">
					        <img src="<?= $imgd ?>" id="picBox" style="width:160px;height:160px;" />
					        <input type="hidden" id="hasImg" value="<?= $hasImg; ?>" />
					        <input type="hidden" id="readableImg" value="<?= $target_dir.$u_img; ?>">
					      </a>
					    </div>


		                <div id="top_box">

		                	<div class="fbox b1">
		                        <h1> Welcome !!! </h1>
		                        <p> <?= $this->current_user['full_name']; ?></p>
		                    </div> <!--end of fbox-->


		                	<div class="fbox b1 leftdivider">

		                    	<h2 class="idlog">Login Id<span>: <?= $this->current_user['email_id']; ?> </span></h2>

		                    	<h2 class="lastlog">Last Log in<span> : <?= date("M d, Y - h:i:s", strtotime($this->current_user['last_login'])); ?></span></h2>

		                    </div><!--end of fbox-->

		                </div> <!--end of top_box-->


		                <div class="timeclock">

		                	<div id="sgc"> </div>

		                    <div class="text-icon">

		                    	<div class="label-text"></div>

		                        <div class="dateinsert">  <?=  date("d  F, Y");?> </div>
		                    </div>

		                </div>


		                <article>

	                		<h3>Getting Started</h3>

			                <p>Welcome to the Recruitment Portal , Your On-stop Dashboard solution to manage all your recruitment activities . In here you will be able to create a new applicant , a new client , a new employee , upload job orders online etc</p>

		                </article>

						<!--nav></nav>-->


						<div class="clearfix"></div>

	                </header> <!--end of first header-->

	                <div id="quickmenu">

		                <p>Quick Links</p>

		                <div class="logout2"></div>
						<a href="<?= base_url('logout'); //echo $this->current_user['logout_url']; ?>"><div class="logouttext">Logout</div></a>

	                </div> <!--end of quickmenu-->


	                <div id="quickcontent">

		                <div class="extendedarrow-topright"></div>

		                <div class="controlpanel"> <p>Control Panel</p> </div>


					<?php
						include('dashboard_menu.php');
						include('dashboard_left_menu.php');
					?>


					<div id="right-box" class="box boxright" style="width: 78%;">
					<aside>

					<script>
					    var $ = jQuery.noConflict();

					    function escapeTags(str) {
					        return String(str)
					            .replace(/&/g, '&amp;')
					            .replace(/"/g, '&quot;')
					            .replace(/\'/g, '&#39;')
					            .replace(/</g, '&lt;')
					            .replace(/\>/g, '&gt;');
					    }

					    window.onload = function() {

					        if ($("#hasImg").val() == 'hasImg') {
					            // $("#img_ctrl_cont").html($("#deleteBtn"));
					            $("#deleteBtn").removeClass('hide');
					            $("#uploadBtn").addClass('hide');
					        } else {
					            // $("#img_ctrl_cont").html($("#uploadBtn"));
					            $("#uploadBtn").removeClass('hide');
					            $("#deleteBtn").addClass('hide');
					        }

					        var picBox = document.getElementById('picBox');
					        var uploadBtn = document.getElementById('uploadBtn');

					        $("#deleteBtn").on('click', function() {
					            bootbox.confirm({
								    title: "Confirmation",
								    message: "Do you wish to remove this image?",
								    buttons: {
								        cancel: {
								            label: '<i class="fa fa-times"></i> No'
								        },
								        confirm: {
								            label: '<i class="fa fa-check"></i> Yes'
								        }
								    },
								    callback: function (ans) {
								        if (ans) {
							                var imgd = $("#readableImg").val();
							                $.ajax({
							                    url: base_url + 'user/delete_dashimage',
							                    type: 'post',
							                    data: {
							                        imgd: imgd
							                    },
							                    success: function() {
							                        picBox.src = base_url + 'assets/images/pix.jpg';
							                        // $("#img_ctrl_cont").html($("#uploadBtn"));
							                        $("#uploadBtn").removeClass('hide');
							                        $("#deleteBtn").addClass('hide');
							                    }
							                });
							            }
								    }
								});
					        });

					        var uploader = new ss.SimpleUpload({
					            button: uploadBtn,
					            url: base_url + 'upload_handler',
					            name: 'uploadfile',
					            responseType: 'json',
					            onSubmit: function() {
					                // $("#img_ctrl_cont").html($("#deleteBtn"));
					                $("#uploadBtn").addClass('hide');
					                $("#deleteBtn").removeClass('hide');
					            },
					            onComplete: function(filename, response) {
					                if (response.success === true) {
					                    picBox.src = response.newFile + "?foo=" + new Date().getTime();
					                }
					                
					            },
					            onError: function() {
					                // progressOuter.style.display = 'none';
					                // msgBox.innerHTML = 'Unable to upload file';
					            }
					        });
					    };
					</script>