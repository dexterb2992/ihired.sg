<?php $this->load->view('includes/navi_in'); ?>
<div class="user-container">
	<div class="user-container-head">Users Management</div>
	<div class="user-content">
		<h2 class="user-content-head">Manage Users</h2>

		<form id="frm_add_user">
		<table class="table borderless">
			<tr>
				<td>User Name</td>
				<td>Short Name</td>
				<td>Email Address</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><input type="text" name="full_name" class="form-control input-sm frm_add_element"></td>
				<td><input type="text" name="short_name" class="form-control input-sm frm_add_element"></td>
				<td><input type="email" name="email_id" class="form-control input-sm frm_add_element"></td>
				<td><input type="button" id="btn_add_user" class="btn btn-sm user-btn" value="Update"></td>
			</tr>
		</table>
		</form>

		<table class="table table-striped">
	    <thead class="red-table-header">
	      <tr>
	        <th>User Name</th>
	        <th>Short Name</th>
	        <th>Email ID</th>
	        <th>Active</th>
	        <th>User Type</th>
	        <th>Date Added</th>
	        <th>Last Login</th>
	        <th>&nbsp;</th>
	      </tr>
	    </thead>
	    <tbody id="tbody">
			<?php
			// echo '<pre>',print_r($data,1),'</pre>';
			if(isset($data) && ! empty($data)) :
				$ctr = 1;
				foreach ($data as $key => $val) :

					$user_img = base_url('assets/images/pix.jpg');
					if($val['user_image']!=NULL) {
						$user_img = base_url('assets/images/user_images').'/'.$val['user_image'];
					}
					$created_on = '';
					if($val['created_on']!=NULL)
					$created_on = date('d/m/Y', strtotime($val['created_on']));
					$last_login = '';
					if($val['last_login']!=NULL)
					$last_login = date('d/m/Y', strtotime($val['last_login']));
			?>
	      <tr id="<?php echo 'tr_'.$ctr; ?>">
	        <td width="25%">
	        	<input type="hidden" id="<?php echo 'user_id_'.$ctr ?>" value="<?php echo $val['user_id'] ?>" />
	        	<input type="hidden" id="<?php echo 'full_name_'.$ctr ?>" value="<?php echo $val['full_name'] ?>" />
	        	<input type="hidden" id="<?php echo 'email_id_'.$ctr ?>" value="<?php echo $val['email_id'] ?>" />
	        	<img src="<?php echo $user_img ?>" class="list-thumb" />
        		<p class="rgb-blue">
        			<?php echo ucwords($val['full_name']); ?>
        		</p>
        		<p>
        			Dashboard Access : 
        		<?php if($val['dash_access']=='P'): ?>
        			<a href="#modal_dashInvite" data-toggle="modal" class="btn btn-primary btn-xs btn_modDashInvite" style="border-radius:0;color:white" id="<?php echo 'modDashInvite_'.$ctr; ?>" data-id="<?= $val['user_id']; ?>" data-email="<?= $val['email_id']; ?>" data-full-name="<?= $val['full_name']; ?>">	Invite </a>
        		<?php elseif($val['dash_access']=='Y') : ?>
							<span class="btn-group btn-tog-grp" data-toggle="buttons">
							    <label class="btn btn-xs radio-tog-btn active">
						        	<input type="radio" name="yes" value="Yes"> Yes 
							    </label>
							    <label class="btn btn-xs radio-tog-btn">
						        	<input type="radio" name="no" value="No"> No 
							    </label>
							</span>
    			<?php elseif($val['dash_access']=='I') : ?>
    					<button class="btn btn-primary btn-xs" style="border-radius:0;background-color:#71c05b;color:#FFFFFF;border-color:#71c05b">	Invited </button>
        		<?php endif; ?>
      			</p>
	        </td>
	        <td><p><?php echo ucwords($val['short_name']); ?></p></td>
	        <td><p><?php echo $val['email_id']; ?></p></td>
	        <td class="rgb-blue"><p><?php echo $val['active']; ?></p></td>
	        <td><p><?php echo $val['user_type']; ?></p></td>
	        <td><p><?php echo $created_on; ?></p></td>
	        <td><p><?php echo $last_login; ?></p></td>
	        <td style="color:#ac1421">
	        	<p><span class="glyphicon glyphicon-remove btn_rem" data-id="<?= $val['user_id']; ?>" id="<?php echo 'rem_'.$ctr; ?>" ></span></p>
	        </td>
	      </tr>
		<?php
			$ctr++;
			endforeach;
		endif;
		?>
      </tbody>
    </table>
    <input type="hidden" id="ctr" value="<?php echo $ctr; ?>">
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>

<!-- 
*** Dash Invite 
*-->
<div class="modal fade"  id="modal_dashInvite">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
        <h5 class="modal-title">Dashboard Access</h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal adjust-container margin-top--20" id="frm_dashInvite">
      <div class="row">Do you wish to Invite the following User to  access his Dash</div>
      <div class="form-group margin-top">
      	<label style="margin-right:10px;">User Name  </label> 
      	<span style="margin-right:10px;">:</span>
      	<span style="margin-right:10px;" id="mod_full_name">_full_name</span>
      </div>
      <div class="form-group">
      	<label style="margin-right:28px;">Email Id </label> 
      	<span style="margin-right:10px;">:</span>
      	<span style="margin-right:10px;" id="mod_email_id">_email_id</span>
      	<input type="hidden" id="mod_user_id">
      </div>
      <div class="row margin-top">
        <button type="button" class="btn btn-small btn-default" style="margin-left:10px;" data-dismiss="modal"> Cancel </button> 
        <button type="button" class="btn btn-small btn-primary pull-left" id="btn_dashInvite" > Send Invite </button>
      </div>
    </form>
      </div>
    </div>
  </div>
</div>
<!-- 
*** END Dash Invite
*-->

<!-- 
*** Dash Invite 
*-->
<div class="modal fade"  id="modal_dashInvite_success">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
        <h5 class="modal-title">Dashboard Access</h5>
      </div>
      <div class="modal-body">
    <div class="row">
      <div class="col-md-9">
        <form class="form-horizontal adjust-container margin-top--20">
      <div class="margin-top--20 row">An email address has been sent to the below email address with the login details.</div>
      <div class="form-group margin-top"> 
        <div class="inner-addon left-addon">      
          <input type="email" name="modalEmail2" class="form-control" readonly="readonly" id="input_dashemail" style="background-color:#71c05b;color:#FFFFFF;" />
          <i class="glyphicon glyphicon-user"></i>
        </div>
      </div>
    </form>
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-small btn-primary form-control" id="dashemail_sent"> OK </button> 
      </div>
    </div>
      </div>
    </div>
  </div>
</div>
<!-- 
*** END Dash Invite
*-->
