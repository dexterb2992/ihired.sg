
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div> <!--end of quickcontent-->
<?php error_reporting(0); ?>
<div class="clearfix"></div>

<div id="left-box" class="box boxleft">
   <div class="extendedarrow-top">  </div>
   <div class="extendedarrow-bottom">  </div>
	<article>
		<p class="<?php echo $active ?>">
            <a href="#" data-toggle="modal" data-target="#change_password"> <!-- class="popupBox"  -->
                <span style='color:black'>Change Password</span>
            </a>
        </p>
        <?php foreach($this->quick_modules as $module): ?>
            <a href="<?php echo !empty($module['uri']) ? base_url($module['uri']) : "#"; ?>">								<p><span><?php echo $module['label']; ?></span></p>
            </a>					
        <?php endforeach; ?>
    
		<p class="<?php echo $active ?>">
            <a href="<?php echo base_url("admin/job_management"); ?>"> <!-- class="popupBox"  -->
                <span style='color:black'>Job Posting Management</span>
            </a>
        </p>	
    
    </article>
    <div class="clearfix"></div>
</div>