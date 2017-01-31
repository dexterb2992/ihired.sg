</aside>
                </div>
<div style="clear:both; height:100px;"></div>
                
            </section> <!--end of first section-->
        </div>
		<footer id="bottom">
        	<div style="height:80px; clear:both;"></div>
            <div class="clearfix"></div>
			<div class="sections clearfix">
				<div class="box-1">
					<div class="imglogo"></div>
				</div>
				
                <div class="box-input">
					<h5 class="hs5"><div class="job">a</div><strong style="color:#dd2526">Claim </strong> <br /> <div style="margin-left:20px;">Management </div></h5>
					<ul>
						<li><a href="#">Manage Claims</a></li>
						<li><a href="#">Make a Claim</a></li>
						<li><a href="#">View Claim History</a></li>
					</ul>
				</div>
				
                <div class="box-input">
				  <h5 class="hs5"><div class="inter">a</div><strong style="color:#dd2526">Leave </strong> <br /> <div style="margin-left:20px;">Management </div></h5>
					<ul>
						<li><a href="../jobs.html">Manage Leave</a></li>
						<li><a href="../jobs.html">Make a leave application</a></li>
						<li><a href="../jobs.html">View Leave History</a></li>
					</ul>
				</div>
                
				<div class="box-input">
					<h5 class="hs5"><div class="time">a</div><strong style="color:#dd2526">Timesheet</strong><br /> <div style="margin-left:20px;">Management</div></h5>
					<ul>
						<li><a href="../location-2.html#singapore">Manage Timesheets</a></li>
						<li><a href="../location-2.html#malaysia">Update Timesheet</a></li>
						<li><a href="../location-2.html#india">View Timesheet History</a></li>
					</ul>
				</div>
                
                <div class="box-input">
					<h5 class="hs5"><div class="mail">a</div><strong style="color:#dd2526">Payslip </strong><br /> <div style="margin-left:20px;">Management</div></h5>
					<ul>
						<li><a href="../location-2.html#singapore">Manage Payslip</a></li>
						<li><a href="../location-2.html#malaysia">Print a Payslip</a></li>
						<li><a href="../location-2.html#india">View Payslip History</a></li>
					</ul>
				</div>


			</div>
			<div class="copy">
				<div>
					<div>Copyright 2013 - 2014 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Symphinite Solutions</div>
					<div>
						<ul>
							<li>Privacy & Security<span>|</span></li>
							<li>Terms of Use<span>|</span></li>
							<li>Patents & Trademarks<span>|</span></li>
							<li>Investor Relations</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
		<?php $this->load->view('shared/system'); ?>

		<!--  *** Change Pass  *-->
		<div class="modal fade"  id="change_password">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
						<h5 class="modal-title">Change your Password</h5>
					</div>
					<div class="modal-body">
						<form class="form-horizontal adjust-container" id="frm_changePass">
							<div class="margin-top--20 row hide" id="passchangeemail">You recently requested for a new password which was emailed to you. We would now request you to please change that password immediately. </div>
							<div class="margin-top--20 row" id="passchange">Please type in a new password up to 6 characters. </div>
							<div class="alert alert-danger hide custom-validation-errors"></div>
							<div class="row">
								<div class="form-group margin-top col-lg-6"> 
									<div class="inner-addon left-addon">  
										<input type="password" name="mynewpassword" class="form-control" id="mynewpassword" placeholder="Enter your Password">
										<i class="glyphicon glyphicon-lock"></i>
									</div>
								</div>

								<div class="form-group margin-top col-lg-6 pull-right"> 
									<div class="inner-addon left-addon">  
										<input type="password" name="myconpassword" class="form-control" id="myconpassword" placeholder="Re-enter your Password">
										<i class="glyphicon glyphicon-lock"></i>
									</div>
								</div>
							</div>
							<div style="color:maroon;font-weight:bold;">Min 6 characters </div>
							<div class="row margin-top">
								<button type="button" class="btn btn-small btn-default" style="margin-left:10px;" data-dismiss="modal"> Cancel </button> 
								<button type="button" class="btn btn-small btn-primary pull-left" id="btn_changePass" > Update Password </button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--  *** END Change Pass *-->
		<script type="text/javascript">
			$(function() {
				
			});
		</script>
	</body>
</html>
