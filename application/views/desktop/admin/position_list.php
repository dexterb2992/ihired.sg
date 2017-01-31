<?php $this->load->view('includes/navi_in'); ?>
<div class="user-container">
	<div class="user-container-head">Position Management</div>
	<div class="user-content">
		<h2 class="user-content-head">Manage Positions</h2>

		<form id="frm_position" method="post" class="margin-top col-lg-4">
		<table class="table borderless">
			<tr>
				<td>Position Name</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><input type="text" name="position_name" id="position_name" class="form-control input-sm frm_add_element"></td>
				<td><input type="button" id="btn_add_position" class="btn btn-sm user-btn btn-noradius" value="Update"></td>
			</tr>
		</table>
		</form>

    <table id="tbl_dt_position" class="table table-striped margin-top display">
	    <thead class="red-table-header">
	      <tr>
	        <th width="20%">Position</th>
	        <th width="15%">Created On</th>
	        <th width="15%">Created By</th>
	        <th width="10%">&nbsp;</th>
	      </tr>
	    </thead>
	    <tbody id="tb_po">
			<?php
			if(isset($data) && ! empty($data)) :
				foreach ($data as $key => $val) :
					$ctr = $val['position_id'];
			?>
	      <tr id="<?php echo 'tr_po_'.$ctr ?>">
	        <td id="<?php echo 'td_po_name_'.$ctr?>" class="vert-align"><?php echo ucwords($val['position_name']); ?></td>
	        <td id="<?php echo 'td_po_date_'.$ctr?>" class="vert-align"><?php echo $val['date_added']; ?></td>
	        <td id="<?php echo 'td_po_added_'.$ctr?>" class="vert-align"><?php echo ucwords($val['added_by']); ?></td>
	        <td id="<?php echo 'td_po_btn_'.$ctr?>" class="vert-align">
        		<button type="button" class="btn btn-primary btn-xs btn-noradius">Edit</button>
        		<button type="button" class="btn btn-primary btn-xs btn-noradius rm_po" id="<?php echo 'rm_po_'.$ctr?>">Delete</button>
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