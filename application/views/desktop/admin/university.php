<?php $this->load->view('includes/navi_in'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css">

<div class="user-container">
    <div class="user-container-head">University &amp; Schools Management</div>
    <div class="user-content">
        <h2 class="user-content-head">Manage Universities</h2>

        <script>
            var universities = <?= json_encode($_universities); ?>;
        </script>

        <table class="table borderless">
            <tr>
                <form id="frm_add_university" method="post">
                    <td>
                        <input type="hidden" name="university_name" id="university_name">
                        <input type="text" id="txt_university_name" class="form-control input-sm frm_add_element" placeholder="University Name" />
                    </td>
                    <td>
                        <select id="sb_country" name="country_id" class="form-control" data-text="------ Select Country ------"></select>
                    </td>
                    <td>
                       <select id="sb_city" name="city_id" class="form-control" data-text="------ Select City ------"></select>
                    </td>
                    <td>
                        <input type="button" id="btn_add_university" class="btn btn-sm user-btn btn-noradius" value="Update">
                    </td>
                </form>
            </tr>
        </table>

        <table class="table table-striped margin-top display datatable" id="tbl_universities">
            <thead class="red-table-header">
                <tr>
                    <th>University Name</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php
			foreach ($universities as $key => $university) :
			?>
				<tr>
                    <td class="vert-align">
                        <?= ucwords($university->university_name); ?>
                    </td>
                    <td class="vert-align">
                        <?= ucwords($university->country_name); ?>
                    </td>
                    <td class="vert-align">
                        <?= ucwords($university->city_name); ?>
                    </td>
                    <td class="vert-align">
                        <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-university" data-id="<?= $university->university_id; ?>" title="Delete">
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