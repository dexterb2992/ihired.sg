<?php $this->load->view('includes/navi_in'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css">

<div class="user-container">
    <div class="user-container-head">Qualifications Management</div>
    <div class="user-content">
        <h2 class="user-content-head">Manage Qualifications</h2>

        <script>
            var qualifications = <?= json_encode($_qualifications); ?>;
            var qualification_types = <?= json_encode($_qualification_types); ?>;
            var functions = <?= json_encode($_functions); ?>;
        </script>

        <table class="table borderless">
            <tr>
                <form id="frm_add_qualification" method="post">
                    <td>
                        <input type="hidden" name="qualification_name" id="qualification_name">
                        <input type="text" id="txt_qualification_name" class="form-control input-sm frm_add_element" placeholder="Qualification Name" />
                    </td>
                    <td>
                        <select id="sb_qualification_type" name="qt_id" class="form-control" data-text="------ Select Type ------"></select>
                    </td>
                    <td>
                       <select id="sb_function" name="function_id" class="form-control" data-text="------ Select Function ------"></select>
                    </td>
                    <td>
                        <input type="button" id="btn_add_qualification" class="btn btn-sm user-btn btn-noradius" value="Update">
                    </td>
                </form>
            </tr>
        </table>

        <table class="table table-striped margin-top display datatable" id="tbl_qualifications">
            <thead class="red-table-header">
                <tr>
                    <th>Qualification Name</th>
                    <th>Type</th>
                    <th>Function</th>
                    <th>Created On</th>
                    <th>Created By</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php
			foreach ($qualifications as $key => $qualification) :
			?>
				<tr>
                    <td class="vert-align">
                        <?= ucwords($qualification->qualifications_name); ?>
                    </td>
                    <td class="vert-align">
                        <?= ucwords($qualification->type); ?>
                    </td>
                    <td class="vert-align">
                        <?= ucwords($qualification->function_name); ?>
                    </td>
                    <td class="vert-align">
                        <?= ucwords($qualification->date_added); ?>
                    </td>
                    <td class="vert-align">
                        <?= ucwords($qualification->full_name); ?>
                    </td>
                    <td class="vert-align">
                        <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-qualification" data-id="<?= $qualification->qualifications_id; ?>" title="Delete">
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