<?php $this->load->view('includes/navi_in'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css">

<div class="user-container">
    <div class="user-container-head">Membership Master</div>
    <div class="user-content">
        <h2 class="user-content-head">Manage Memberships</h2>

        <script>
            var memberships = <?= json_encode($_memberships); ?>;
        </script>

        <table class="table borderless">
            <tr>
                <form id="frm_add_membership" method="post">
                    <td>
                        <input type="hidden" name="membership_name" id="membership_name">
                        <input type="text" id="txt_membership_name" class="form-control input-sm frm_add_element" placeholder="Membership Name" />
                    </td>
                    <td>
                        <select id="sb_country" name="country_id" class="form-control" data-text="------ Select Country ------"></select>
                    </td>
                    <td>
                       <select id="sb_city" name="city_id" class="form-control" data-text="------ Select City ------"></select>
                    </td>
                    <td>
                        <input type="button" id="btn_add_membership" class="btn btn-sm user-btn btn-noradius" value="Update">
                    </td>
                </form>
            </tr>
        </table>

        <table class="table table-striped margin-top display datatable" id="tbl_memberships">
            <thead class="red-table-header">
                <tr>
                    <th>Membership Name</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php
			foreach ($memberships as $key => $membership) :
			?>
				<tr>
                    <td class="vert-align">
                        <?= ucwords($membership->membership_name); ?>
                    </td>
                    <td class="vert-align">
                        <?= ucwords($membership->country_name); ?>
                    </td>
                    <td class="vert-align">
                        <?= ucwords($membership->city_name); ?>
                    </td>
                    <td class="vert-align">
                        <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-membership" data-id="<?= $membership->membership_id; ?>" title="Delete">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>
                    </td>
                </tr>
            <?php
			endforeach;
			?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<?php $this->load->view('includes/footer'); ?>