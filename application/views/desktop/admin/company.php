<?php $this->load->view('includes/navi_in'); ?>
<div class="user-container">
    <div class="user-container-head">Company Management</div>
    <h2 class="Company-nav-tabs">Manage Company</h2>
    <div class="user-content">
        <div id="m_company">
	        <script>
	        	var industries = '<?= json_encode($industries); ?>';
	        	var companies = '<?= json_encode($companies); ?>';
	        </script>
            <form class="margin-top col-lg-10" id="frm_company" method="post">
                <table class="table borderless">
                    <tr>
                        <th width="30%">Company Name</th>
                        <th width="25%">Industry</th>
                        <th width="10%">&nbsp;</th>
                    </tr>
                    <tr>
                        <input type="hidden" name="co_id" value="-1">
                        <td>
                        	<input type="text" name="company_name" id="txt_company" class="form-control input-sm frm_add_element">
                        </td>
                        <td>
                            <input type="text" name="industry" id="txt_industry" class="form-control input-sm frm_add_element">
                        </td>
                        <td>
                        	<input type="button" id="btn_add_company" class="btn btn-sm user-btn btn-noradius" value="Update">
                        </td>
                    </tr>
                </table>
            </form>

            <table class="table table-striped margin-top display datatable">
                <thead class="red-table-header">
                    <tr>
                        <th width="20%">Company Name</th>
                        <th width="15%">Industry</th>
                        <th width="10%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody id="tb_co">
                <?php
				foreach ($companies as $key => $company) :
				?>
					<tr data-id="<?= $company['company_id']; ?>">
                        <td class="vert-align">
                            <?= ucwords($company['company_name']); ?>
                        </td>
                        <td class="vert-align">
                            <?= $company['industry_name']; ?>
                        </td>
                        <td class="vert-align">
                            <button type="button" class="btn btn-primary btn-xs btn-noradius btn-edit-company">Edit</button>
                            <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-company">Delete</button>
                        </td>
                    </tr>
                <?php
				endforeach;
				?>
                </tbody>
            </table>
        </div>
        <!-- END Company -->
    </div>
</div>

<?php $this->load->view('includes/footer'); ?>