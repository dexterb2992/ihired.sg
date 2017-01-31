<?php $this->load->view('includes/navi_in'); ?>
<div class="user-container">
	<div class="user-container-head">Industry Management</div>
	<div class="user-content">
		<h2 class="user-content-head">Manage Industry</h2>

		<form id="frm_industry" method="post" class="margin-top col-lg-4">
		<table class="table borderless">
			<tr>
				<td>Industry Name</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><input type="text" name="industry_name" id="industry_name" class="form-control input-sm frm_add_element"></td>
				<td><input type="button" id="btn_add_industry" class="btn btn-sm user-btn btn-noradius" value="Update"></td>
			</tr>
		</table>
		</form>

    <table id="tbl_dt_industry" class="table table-striped margin-top display">
	    <thead class="red-table-header">
	      <tr>
	        <th width="20%">Industry Name</th>
	        <th width="15%">Created On</th>
	        <th width="15%">Created By</th>
	        <th width="10%">&nbsp;</th>
	      </tr>
	    </thead>
	    <tbody id="tb_in">
			<?php
			if(isset($data) && ! empty($data)) :
				foreach ($data as $key => $val) :
					$ctr = $val['industry_id'];
			?>
	      <tr id="<?php echo 'tr_in_'.$ctr ?>">
	        <td id="<?php echo 'td_in_name_'.$ctr?>" class="vert-align"><?php echo ucwords($val['industry_name']); ?></td>
	        <td id="<?php echo 'td_in_date_'.$ctr?>" class="vert-align"><?php echo $val['date_added']; ?></td>
	        <td id="<?php echo 'td_in_added_'.$ctr?>" class="vert-align"><?php echo ucwords($val['added_by']); ?></td>
	        <td id="<?php echo 'td_in_btn_'.$ctr?>" class="vert-align">
        		<button type="button" class="btn btn-primary btn-xs btn-noradius">Edit</button>
        		<button type="button" class="btn btn-primary btn-xs btn-noradius rm_in" id="<?php echo 'rm_in_'.$ctr?>">Delete</button>
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