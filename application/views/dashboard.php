
<div style="margin-left: 11px">

	<div>
		<?php //echo $global_errors; ?>
        <script type="text/javascript">
            var forcePasswordChange = '<?= $this->session->userdata("request"); ?>';
        </script>
	</div>
	
	<div class="asidebox">  
        <!-- PASSWORD CONTENT-->
        <div class="asidecontent" onclick="javascript:pwWindow();" style="cursor: pointer;">
        	<div class="thumb"><img src="<?php echo base_url(); ?>assets/images/password-icon.png" /></div>
        	<div class="thumbcontent">
            <p class="title">My Password </p>
            <div class="contenttext">Manage your password and change it anytime.</div>
            </div> <!--end of thumbcontent-->
            <div class="clearfix"></div>
        </div>
        
        <!-- TIMESHEET CONTENT-->
        <div class="asidecontent">
        	<div class="thumb"><img src="<?php echo base_url(); ?>assets/images/timesheet-icon.png" /></div>
        	<div class="thumbcontent">
            <a href="#"><p class="title">Timesheet Management</p></a>
            <p class="contenttext">Manage and update your Timesheet on a daily basis.</p>
            </div> <!--end of thumbcontent-->
            <div class="clearfix"></div>
        </div>
        
         <!-- EMPLOYMENT CONTENT-->
        <div class="asidecontent">
        	<div class="thumb"><img src="<?php echo base_url(); ?>assets/images/employment-icon.png" /></div>
        	<div class="thumbcontent">
            <a href="#"><p class="title">Employment Pass Management</p></a>
            <p class="contenttext">Manage and view your Employment Pass details in here.</p>
            </div> <!--end of thumbcontent-->
            <div class="clearfix"></div>
        </div>
        
    </div> <!--end of asidebox-->
	
    
    
    <div class="asidebox"> 
    
     <!-- MY PERSONAL DATA CONTENT-->
       <div class="asidecontent">
        	<div class="thumb"><img src="<?php echo base_url(); ?>assets/images/personal-icon.png" /></div>
        	<div class="thumbcontent">
            <a href="#"><p class="title">Manage my profile</p></a>
            <p class="contenttext"> Manage your Personal Details & Contacts </p>
            </div> <!--end of thumbcontent-->
            <div class="clearfix"></div>
        </div>
        
         
        
        
        <!-- CLAIM MANAGEMENT CONTENT-->
        <div class="asidecontent" onclick="javascript:clWindow();" style="cursor: pointer;">
        	<div class="thumb"><img src="<?php echo base_url(); ?>assets/images/claim-icon.png" /></div>
        	<div class="thumbcontent">
            <p class="title">Claim Management </p>
            <p class="contenttext">Upload and Manage all your Medical , Transport and other claims.</p>
            </div> <!--end of thumbcontent-->
            <div class="clearfix"></div>
        </div>
      
         <!-- BANK DETAILS CONTENT-->
        <div class="asidecontent">
        	<div class="thumb"><img src="<?php echo base_url(); ?>assets/images/bank-icon.png" /></div>
        	<div class="thumbcontent">
            <a href="#"><p class="title">Income Tax Management</p></a>
            <p class="contenttext">Manage all your Taxation Matters here.</p>
            </div> <!--end of thumbcontent-->
            <div class="clearfix"></div>
        </div>
        
     
    </div> <!--end of asidebox-->
    
    
    
    
	<div class="asidebox">
    
        
   		<!-- LEAVE MANAGEMENT CONTENT-->
        <div class="asidecontent" onclick="javascript:lmWindow();" style="cursor: pointer;">
        	<div class="thumb"><img src="<?php echo base_url(); ?>assets/images/leave-icon.png" /></div>
        	<div class="thumbcontent">
            <p class="title">Leave Management</p>
            <p class="contenttext">Make New Leave application, view history of leave etc.</p>
            </div> <!--end of thumbcontent-->
            <div class="clearfix"></div>
        </div>
          
    <!-- PAYSLIP CONTENT-->
      <div class="asidecontent">
        	<div class="thumb"><img src="<?php echo base_url(); ?>assets/images/payslip-icon.png" /></div>
        	<div class="thumbcontent">
            <a href="#"><p class="title">Payslip Management</p></a>
            <p class="contenttext">Manage and view your Payslips online at anytime.</p>
            </div> <!--end of thumbcontent-->
            <div class="clearfix"></div>
        </div>
        
          
     
    </div> <!--end of asidebox-->
    
</aside>

</div>
<script type="text/javascript" src="<?= asset_url('js/dashboard.js'); ?>"></script>