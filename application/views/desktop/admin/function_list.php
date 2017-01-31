<?php $this->load->view('includes/navi_in'); ?>
<div class="user-container">
	<div class="user-container-head">Function Management</div>
	<div class="user-content">
		<h2 class="user-content-head">Manage Functions</h2>

		<form id="frm_function" method="post" class="margin-top col-lg-4">
		<table class="table borderless">
			<tr>
				<td>Function Name</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><input type="text" name="function_name" id="function_name" class="form-control input-sm frm_add_element"></td>
				<td><input type="button" id="btn_add_function" class="btn btn-sm user-btn btn-noradius" value="Update"></td>
			</tr>
		</table>
		</form>

    <table id="tbl_dt_function" class="table table-striped margin-top display">
	    <thead class="red-table-header">
	      <tr>
	        <th width="20%">Function Name</th>
	        <th width="15%">Created On</th>
	        <th width="15%">Created By</th>
	        <th width="10%">&nbsp;</th>
	      </tr>
	    </thead>
	    <tbody id="tb_de">
			<?php
			if(isset($data) && ! empty($data)) :
				foreach ($data as $key => $val) :
					$ctr = $val['function_id'];
			?>
	      <tr id="<?php echo 'tr_de_'.$ctr ?>">
	        <td id="<?php echo 'td_de_name_'.$ctr?>" class="vert-align"><?php echo ucwords($val['function_name']); ?></td>
	        <td id="<?php echo 'td_de_date_'.$ctr?>" class="vert-align"><?php echo $val['date_added']; ?></td>
	        <td id="<?php echo 'td_de_added_'.$ctr?>" class="vert-align"><?php echo ucwords($val['added_by']); ?></td>
	        <td id="<?php echo 'td_de_btn_'.$ctr?>" class="vert-align">
        		<button type="button" class="btn btn-primary btn-xs btn-noradius">Edit</button>
        		<button type="button" class="btn btn-primary btn-xs btn-noradius rm_de" id="<?php echo 'rm_de_'.$ctr?>">Delete</button>
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