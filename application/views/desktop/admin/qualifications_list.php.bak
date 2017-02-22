<?php $this->load->view('includes/navi_in'); ?>
<div class="user-container">
	<div class="user-container-head">Qualifications Management</div>
	<div class="user-content">
		<h2 class="user-content-head">Manage Qualifications</h2>

		<form id="frm_qualifications" method="post" class="margin-top col-lg-4">
		<table class="table borderless">
			<tr>
				<td>Qualifications Name</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><input type="text" name="qualifications_name" id="qualifications_name" class="form-control input-sm frm_add_element"></td>
				<td><input type="button" id="btn_add_qualifications" class="btn btn-sm user-btn btn-noradius" value="Update"></td>
			</tr>
		</table>
		</form>

    <table id="tbl_dt_qualifications" class="table table-striped margin-top">
	    <thead class="red-table-header">
	      <tr>
	        <th width="20%">Qualifications Name</th>
	        <th width="15%">Created On</th>
	        <th width="15%">Created By</th>
	        <th width="10%">&nbsp;</th>
	      </tr>
	    </thead>
	    <tbody id="tb_qu">
			<?php
			if(isset($data) && ! empty($data)) :
				foreach ($data as $key => $val) :
					$ctr = $val['qualifications_id'];
			?>
	      <tr id="<?php echo 'tr_qu_'.$ctr ?>">
	        <td id="<?php echo 'td_qu_name_'.$ctr?>" class="vert-align"><?php echo ucwords($val['qualifications_name']); ?></td>
	        <td id="<?php echo 'td_qu_name_'.$ctr?>" class="vert-align"><?php echo $val['date_added']; ?></td>
	        <td id="<?php echo 'td_qu_name_'.$ctr?>" class="vert-align"><?php echo ucwords($val['added_by']); ?></td>
	        <td id="<?php echo 'td_qu_name_'.$ctr?>" class="vert-align">
        		<button type="button" class="btn btn-primary btn-xs btn-noradius">Edit</button>
        		<button type="button" class="btn btn-primary btn-xs btn-noradius rm_qu" id="<?php echo 'rm_qu_'.$ctr?>">Delete</button>
	        </td>
	      </tr>
			<?php
				endforeach;
			endif;
			?>
      </tbody>
    </table>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>