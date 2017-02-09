<?php $this->load->view('includes/navi_in'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css">

<script>
	var industries = <?= json_encode($industries); ?>;
	var countries = <?= json_encode($countries); ?>;
</script>
<div class="user-container">
    <div class="user-container-head">
	    Company Management
	    <span class="pull-right">Update</span>
    </div>
    <div class="user-content">
    	<h2 class="user-content-head">
    		<a href="<?= base_url('admin/company'); ?>">Manage Company</a>
    	</h2>
        <div id="m_company">        
        	<div class="row">
        		<?= form_open( base_url("company/update"), array('class' => 'form') ); ?>
	        		<div class="col-md-3">
	        			<div class="photo">
							<div id="img_ctrl_cont">
								<div class="img_ctrl hide" id="uploadBtn">Upload</div>
								<div class="img_ctrl hide" id="deleteBtn">Delete</div>
							</div>
							<a href="javascript:void(0)">
								<img src="<?= $company->logo; ?>" id="picBox" style="width:160px;height:160px;" />
								<input type="hidden" id="hasImg" value="<?= $company->hasImg; ?>" />
								<input type="hidden" id="readableImg" value="<?= $company->logo_dir; ?>">
							</a>
						</div>
	        		</div>
	        		<div class="col-md-6">
	        			<div class="form-group">
	        				<label for="company_name">Company Name</label>
	        				<input id="company_name" class="form-control" type="text" value="<?= $company->company_name; ?>" name="company_name" placeholder="Company Name" />
	        			</div>
	        			<div class="row">
	        				<div class="col-md-6">
	        					<div class="form-group">
	        						<label for="telephone_no">Telephone No.</label>
			        				<input id="telephone_no" class="form-control" type="text" value="<?= $company->telephone_no; ?>" name="telephone_no" placeholder="Telephone No." />
			        			</div>
	        				</div>
	        				<div class="col-md-6">
	        					<div class="form-group">
	        						<label for="fax_no">Fax No.</label>
			        				<input id="fax_no" class="form-control" type="text" value="<?= $company->fax_no; ?>" name="fax_no" placeholder="Fax No." />
			        			</div>
	        				</div>
	        			</div>
	        			<div class="form-group">
	        				<label for="website">Website</label>
	        				<input id="website" class="form-control" type="text" value="<?= $company->website; ?>" name="website" placeholder="Website" />
	        			</div>
	        			<div class="form-group">
	        				<label for="career_site">Career Site</label>
	        				<input id="career_site" class="form-control" type="text" value="<?= $company->career_site; ?>" name="career_site" placeholder="Career Site" />
	        			</div>
	        			<div class="row">
	        				<div class="col-md-6">
	        					<div class="form-group">
	        						<label for="industry_id">Industry</label>
			        				<select name="industry_id" id="industry_id" class="form-control" data-text="Industry">
			        					<option value="<?= $company->industry_id; ?>" selected>
			        						<?= $company->industry_name; ?>
			        					</option>
			        				</select>
			        			</div>
	        				</div>
	        				<div class="col-md-6">
	        					<div class="form-group">
	        						<label for="currency_id">Currency</label>
			        				<input id="currency_id" class="form-control" type="text" value="<?= $company->currency_id; ?>" name="currency_id" placeholder="Currency" />
			        			</div>
	        				</div>
	        			</div>
	        		</div>
	        		<div class="col-md-3">
	        			<div class="form-group">
	        				<label for="country_id">Country</label>
	        				<select name="country_id" id="country_id" class="form-control" data-text="Country">
	        					<option value="<?= $company->country_id; ?>" selected>
	        						<?= $company->country_name; ?>
	        					</option>
	        				</select>
	        			</div>
	        			<div class="form-group">
	        				<label for="business_registration_no">Business Registration #</label>
	        				<input id="business_registration_no" class="form-control" type="text" value="<?= $company->business_registration_no; ?>" name="business_registration_no" placeholder="Business Registration #" />
	        			</div>
	        			<div class="form-group">
	        				<label for="business_address">Business Address</label>
	        				<textarea class="form-control" name="business_address" id="business_address"><?= $company->business_address; ?></textarea>
	        			</div>
	        			<div class="form-group">
	        				<button type="submit" class="btn btn-primary">
		        				<i class="glyphicon glyphicon-floppy-disk"></i> Save changes
	        				</button>
	        			</div>
	        		</div>
	        	<?= form_close(); ?>
        	</div>
        </div>
        <!-- END Company -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<?php $this->load->view('includes/footer'); ?>