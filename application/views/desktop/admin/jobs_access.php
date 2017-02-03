<?php $this->load->view('includes/navi_in'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="<?= asset_url('css/select2-bootstrap.css'); ?>">

<div class="user-container">
    <div class="user-container-head">Job Posting Access</div>
    <div class="user-content">
        <h2 class="user-content-head"></h2>
        <div id="m_access">
            <script>
                var functions = <?= json_encode($functions); ?>;
                var companies = <?= json_encode($companies); ?>;
                var users = <?= json_encode($users); ?>;
            </script>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-inline">
                        <div class="form-group">
                            <select class="form-control" id="select_user" data-placeholder="User Name"></select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="select_company" data-placeholder="------- Select Company -------"></select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="select_function" data-placeholder="Select Function"></select>
                        </div>
                        <div class="form-group">
                            <button id="btn_add_access" class="btn btn-sm user-btn">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped margin-top table-responsive display datatable" id="tbl_companies">
                <thead class="red-table-header">
                    <tr>
                        <th>User Name</th>
                        <th>Company Name</th>
                        <th>Function Name</th>
                        <th>Date Added</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($jobs_access as $key => $access) :
                ?>
                    <tr data-id="<?= $access['jobs_access_id']; ?>">
                        <td class="vert-align">
                            <?= ucwords($access['full_name']); ?>
                        </td>
                        <td class="vert-align">
                            <?= $access['company_name']; ?>
                        </td>
                        <td class="vert-align">
                            <?= $access['function_name']; ?>
                        </td>
                        <td class="vert-align">
                            <?= $access['date']; ?>
                        </td>
                        <td class="vert-align">
                            <button type="button" class="btn btn-primary btn-xs btn-delete-access trash-ikon" data-id="<?= $access['jobs_access_id']; ?>"></button>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

<?php $this->load->view('includes/footer'); ?>