<?php $this->load->view('includes/navi_in'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css">

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
                <a href="#m_state" data-toggle="tab">
                    <h2 class="country-nav-tabs">Manage State</h2>
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
                    <table class="table borderless table-responsive">
                        <tr>
                            <th>Country</th>
                            <th>Country Code</th>
                            <th>Nationality</th>
                            <th>Currency Name</th>
                            <th>Symbol</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="country_name" class="form-control input-sm">
                            </td>
                             <td>
                                <input type="text" name="country_code" class="form-control input-sm">
                            </td>
                            <td>
                                <input type="text" name="nationality" class="form-control input-sm">
                            </td>
                            <td>
                                <input type="text" name="currency_name" class="form-control input-sm">
                            </td>
                            <td>
                                <input type="text" name="currency_symbol" class="form-control input-sm">
                            </td>
                            <td>
                                <input type="button" id="btn_add_country" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </tr>
                    </table>
                </form>
                <table id="tbl_countries" class="table table-striped margin-top display">
                    <thead class="red-table-header">
                        <tr>
                            <th>Country</th>
                            <th>Country Code</th>
                            <th>Nationality</th>
                            <th>Currency Name</th>
                            <th>Symbol</th>
                            <th>Created On</th>
                            <th>Created By</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($countries as $country): ?>
                        <tr>
                            <td class="vert-align">
                                <?= ucfirst($country->country_name); ?>
                            </td>
                            <td>
                                <?= strtoupper($country->country_code); ?>
                            </td>
                            <td class="vert-align">
                                <?= ucfirst($country->nationality); ?>
                            </td>
                            <td class="vert-align">
                                <?= ucfirst($country->currency_name); ?>
                            </td>
                            <td class="vert-align">
                                <?= strtoupper($country->currency_symbol); ?>
                            </td>
                            <td class="vert-align">
                                <?= $country->date_added; ?>
                            </td>
                            <td class="vert-align">
                                <?= $country->full_name; ?>
                            </td>
                            <td class="vert-align">
                                <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-country" title="Delete this record" data-id="<?= $country->country_id; ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- end Manage Country tab-->

            <div class="tab-pane" id="m_state">
                <form class="margin-top col-lg-10" id="frm_state" method="post">
                    <table class="table borderless table-responsive">
                        <tr>
                            <th>State Name</th>
                            <th>Country</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="state_name" class="form-control input-sm">
                            </td>
                             <td>
                                <select class="form-control" id="sb_state_country" name="country_id" data-text="- Select Country -"></select>
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
                            <th>State</th>
                            <th>Country</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($states as $state): ?>
                        <tr>
                            <td class="vert-align">
                                <?= ucfirst($state->state_name); ?>
                            </td>
                            <td>
                                <?= ucfirst($state->country_name); ?>
                            </td>
                            <td class="vert-align">
                                <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-state" title="Delete this record" data-id="<?= $state->state_id; ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- end Manage State tab -->

            <div class="tab-pane" id="m_city">
                <form class="margin-top col-lg-10" id="frm_city" method="post">
                    <table class="table borderless table-responsive">
                        <tr>
                            <th>City Name</th>
                            <th>Country</th>
                            <th data-hide-when="country_has_no_state">State</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="state_name" class="form-control input-sm">
                            </td>
                            <td>
                                <select class="form-control" id="sb_city_country" name="country_id" data-text="- Select Country -"></select>
                            </td>
                            <td data-hide-when="country_has_no_state">
                                <select class="form-control" id="sb_city_state" name="state_id" data-text="- Select State -"></select>
                            </td>
                            <td>
                                <input type="button" id="btn_add_city" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </tr>
                    </table>
                </form>
                <table id="tbl_cities" class="table table-striped margin-top display">
                    <thead class="red-table-header">
                        <tr>
                            <th>City Name</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Created On</th>
                            <th>Created By</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cities as $city): ?>
                        <tr>
                            <td class="vert-align">
                                <?= ucfirst($city->city_name); ?>
                            </td>
                            <td data-hide-when="country_has_no_state">
                                <?= ucfirst($city->state_name); ?>
                            </td>
                            <td>
                                <?= ucfirst($city->country_name); ?>
                            </td>
                            <td>
                                <?= $city->date_added; ?>
                            </td>
                            <td>
                                <?= ucfirst($city->full_name); ?>
                            </td>
                            <td class="vert-align">
                                <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-city" title="Delete this record" data-id="<?= $city->city_id; ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- end Manage City tab-->

            <div class="tab-pane" id="m_town">
                <form class="margin-top col-lg-10" id="frm_town" method="post">
                    <table class="table borderless table-responsive">
                        <tr>
                            <th>Town/Neighbourhood Name</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="town_name" class="form-control input-sm">
                            </td>
                            <td>
                                <select class="form-control" id="sb_town_country" name="country_id" data-text="- Select Country -"></select>
                            </td>
                            <td>
                                <select class="form-control" id="sb_town_city" name="city_id" data-text="- Select City -"></select>
                            </td>
                            <td>
                                <input type="button" id="btn_add_town" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </tr>
                    </table>
                </form>
                <table id="tbl_towns" class="table table-striped margin-top display">
                    <thead class="red-table-header">
                        <tr>
                            <th>Town/Neighbourhood Name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Created On</th>
                            <th>Created By</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($towns as $town): ?>
                        <tr>
                            <td class="vert-align">
                                <?= ucfirst($town->town_name); ?>
                            </td>
                            <td>
                                <?= ucfirst($town->city_name); ?>
                            </td>
                            <td>
                                <?= strtoupper($town->country_name); ?>
                            </td>
                            <td>
                                <?= $town->date_added; ?>
                            </td>
                            <td>
                                <?= ucfirst($town->full_name); ?>
                            </td>
                            <td class="vert-align">
                                <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-town" title="Delete this record" data-id="<?= $town->town_id; ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- end Manage Town tab-->
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

<?php $this->load->view('includes/footer'); ?>