<?php $this->load->view('includes/navi_in'); ?>
<div class="user-container">
    <div class="user-container-head">Country Management</div>
    <div class="user-content">
        <ul class="nav nav-tabs country-nav" data-tabs="tabs">
            <li class="active">
            	<a href="#m_country" data-toggle="tab">
            		<h2 class="country-nav-tabs">Manage Country</h2>
            	</a>
            </li>
            <li>
	            <a href="#m_city" data-toggle="tab">
	            	<h2 class="country-nav-tabs">Manage City</h2>
	            </a>
            </li>
            <li>
	            <a href="#m_town" data-toggle="tab">
	            	<h2 class="country-nav-tabs">Manage Town</h2>
	            </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="m_country">
                <form class="margin-top col-lg-10" id="frm_country" method="post">
                    <table class="table borderless">
                        <tr>
                            <th width="30%">Country</th>
                            <th width="25%">Nationality</th>
                            <th width="25%">Currency Name</th>
                            <th width="10%">Symbol</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                        <tr>
                            <input type="hidden" name="co_id" value="-1">
                            <td>
                                <input type="text" name="country_name" id="co_input_country" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="text" name="nationality" id="co_input_nationality" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="text" name="currency_name" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="text" name="currency_symbol" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="button" id="btn_add_country" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </tr>
                    </table>
                </form>

                <table id="tbl_dt_country" class="table table-striped margin-top display">
                    <thead class="red-table-header">
                        <tr>
                            <th width="20%">Country</th>
                            <th width="15%">Nationality</th>
                            <th width="15%">Currency Name</th>
                            <th width="10%">Symbol</th>
                            <th width="15%">Created On</th>
                            <th width="15%">Created By</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="tb_co">
                        <?php if(isset($data) && ! empty($data)) : foreach ($data as $key=> $val) : $ctr = $val['country_id']; ?>
                        <tr id="<?= 'tr_co_'.$ctr ?>">
                            <td id="<?= 'td_co_name_'.$ctr?>" class="vert-align">
                                <?= ucwords($val[ 'country_name']); ?>
                            </td>
                            <td id="<?= 'td_co_nationality_'.$ctr?>" class="vert-align">
                                <?= ucwords($val[ 'nationality']); ?>
                            </td>
                            <td id="<?= 'td_co_currency_'.$ctr?>" class="vert-align">
                                <?= ucwords($val[ 'currency_name']); ?>
                            </td>
                            <td id="<?= 'td_co_symbol_'.$ctr?>" class="vert-align">
                                <?= $val[ 'currency_symbol']; ?>
                            </td>
                            <td id="<?= 'td_co_date_'.$ctr?>" class="vert-align">
                                <?= $val[ 'date_added']; ?>
                            </td>
                            <td id="<?= 'td_co_added_'.$ctr?>" class="vert-align">
                                <?= isset($val[ 'added_by']) ? ucwords($val[ 'added_by']) : ''; ?>
                            </td>
                            <td id="<?= 'td_co_btn_'.$ctr?>" class="vert-align">
                                <button type="button" id="<?= 'rm_co_'.$ctr ?>" class="btn btn-primary btn-xs btn-noradius rm_co">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- END Country -->

            <div class="tab-pane" id="m_state">
            	<form class="margin-top col-lg-7" id="frm_state" method="post">
                    <table class="table borderless">
                        <tr>
                            <td>State Name</td>
                            <td>Country</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="state_name" id="state_name" class="form-control input-sm">
                            </td>
                            <td>
                                <select class="form-control" name="country_id" id="sb_country"></select>
                            </td>
                            <td>
                                <input type="button" id="btn_add_state" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </tr>
                    </table>
                </form>

                <table id="tbl_states" class="table table-striped margin-top display">
                    <thead class="red-table-header">
                        <tr>
                            <th width="45%">State</th>
                            <th width="45%">Country</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php foreach($states as $state): ?>
                    		<tr>
                    			<td>
                    				<?= $state->state_name; ?>
                    			</td>
                    			<td>
                    				<?= $state->country_name; ?>
                    			</td>
                    			<td>
                    				<button type="button" class="btn-delete-state btn btn-primary btn-xs btn-noradius" data-id="<?= $state->state_id; ?>">
                    					Delete
                    				</button>
                    			</td>
                    		</tr>
                    	<?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="m_city">

                <form class="margin-top col-lg-7" id="frm_city" method="post">
                    <table class="table borderless">
                        <tr>
                            <td>City Name</td>
                            <td>Country</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <input type="hidden" name="h_ci_country_id" id="h_ci_country_id">
                            <input type="hidden" name="ci_id" value="-1">
                            <td>
                                <input type="text" name="city_name" id="ci_input_city" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="text" name="country_name" id="ci_input_country" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="button" id="btn_add_city" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </tr>
                    </table>
                </form>

                <table id="tbl_dt_city" class="table table-striped margin-top display">
                    <thead class="red-table-header">
                        <tr>
                            <th width="25%">City Name</th>
                            <th width="25%">Country</th>
                            <th width="20%">Created On</th>
                            <th width="25%">Created By</th>
                            <th width="5%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="tb_ci">
                        <?php 
                        	if(isset($data_city) && ! empty($data_city)): 
                        		foreach ($data_city as $key=> $val) : $ctr = $val['city_id']; 
                        	?>
		                        <tr id="<?= 'tr_ci_'.$ctr ?>">
		                            <td id="<?= 'td_ci_name_'.$ctr?>" class="vert-align">
		                                <?= ucwords($val[ 'city_name']); ?>
		                            </td>
		                            <td id="<?= 'td_ci_country_'.$ctr?>" class="vert-align">
		                                <?= ucwords($val[ 'country_name']); ?>
		                            </td>
		                            <td id="<?= 'td_ci_date_'.$ctr?>" class="vert-align">
		                                <?= $val[ 'date_added']; ?>
		                            </td>
		                            <td id="<?= 'td_ci_added_'.$ctr?>" class="vert-align">
		                                <?= isset($val[ 'added_by']) ? ucwords($val[ 'added_by']) : ''; ?>
		                            </td>
		                            <td id="<?= 'td_ci_btn_'.$ctr?>" class="vert-align">
		                                <button type="button" class="btn btn-primary btn-xs btn-noradius rm_ci" id="<?= 'rm_ci_'.$ctr?>">Delete</button>
		                            </td>
		                        </tr>
                        <?php   endforeach;
                        	endif;
                        ?>
                    </tbody>
                </table>

            </div>
            <!-- END City -->
            <div class="tab-pane" id="m_town">

                <form class="margin-top col-lg-7" id="frm_town" method="post">
                    <table class="table borderless">
                        <tr>
                            <td>Town/Neighbourhood Name</td>
                            <td>City Name</td>
                            <td>Country</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <input type="hidden" name="h_to_city_id" id="h_to_city_id" value="-1">
                            <input type="hidden" name="h_to_country_id" id="h_to_country_id" value="-1">
                            <input type="hidden" name="to_id" value="-1">
                            <td>
                                <input type="text" name="town_name" id="to_input_town" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="text" name="city_name" id="to_input_city" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="text" name="country_name" id="to_input_country" class="form-control input-sm frm_add_element">
                            </td>
                            <td>
                                <input type="button" id="btn_add_town" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </tr>
                    </table>
                </form>

                <table class="table table-striped margin-top" id="tbl_dt_town">
                    <thead class="red-table-header">
                        <tr>
                            <th width="20%">Town/Neighbourhood Name</th>
                            <th width="15%">City Name</th>
                            <th width="15%">Country</th>
                            <th width="15%">Created On</th>
                            <th width="15%">Created By</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="tb_to">
                        <?php if(isset($data_town) && ! empty($data_town)) : foreach ($data_town as $key=> $val) : $ctr = $val['town_id']; ?>
                        <tr id="<?= 'tr_to_'.$ctr ?>">
                            <td id="<?= 'td_to_name_'.$ctr ?>" class="vert-align">
                                <?= ucwords($val[ 'town_name']); ?>
                            </td>
                            <td id="<?= 'td_to_city_'.$ctr ?>" class="vert-align">
                                <?= ucwords($val[ 'city_name']); ?>
                            </td>
                            <td id="<?= 'td_to_country_'.$ctr ?>" class="vert-align">
                                <?= ucwords($val[ 'country_name']); ?>
                            </td>
                            <td id="<?= 'td_to_date_'.$ctr ?>" class="vert-align">
                                <?= $val[ 'date_added']; ?>
                            </td>
                            <td id="<?= 'td_to_added_'.$ctr ?>" class="vert-align">
                                <?= isset($val[ 'added_by']) ? ucwords($val[ 'added_by']) : ''; ?>
                            </td>
                            <td id="<?= 'td_to_btn_'.$ctr ?>" class="vert-align">
                                <button type="button" class="btn btn-primary btn-xs btn-noradius rm_to" id="<?= 'rm_to_'.$ctr ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>

            </div>
            <!-- END Town -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="deleteCountryModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="background: #FFF !important">
            <center>
                <br />
                <br />
                <div style="color: #333; font-size: 18px;">Delete Country?</div>
                <br />
                <br />
                <button type="button" class="btn btn-primary" id="deleteCountry">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </center>
                <br />
                <br />
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="deleteCityModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="background: #FFF !important">
            <center>
                <br />
                <br />
                <div style="color: #333; font-size: 18px;">Delete City?</div>
                <br />
                <br />
                <button type="button" class="btn btn-primary" id="deleteCity">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </center>
            <br />
            <br />
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="deleteTownModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="background: #FFF !important">
            <center>
                <br />
                <br />
                <div style="color: #333; font-size: 18px;">Delete Town?</div>
                <br />
                <br />
                <button type="button" class="btn btn-primary" id="deleteTown">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
           	</center>
            <br />
            <br />
        </div>
    </div>
</div>

<script src="<?= base_url();?>assets/js/modules/manage_state.js"></script>
<?php $this->load->view('includes/footer'); ?>