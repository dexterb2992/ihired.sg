<?php $this->load->view('includes/navi_in'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css">

<div class="user-container">
    <div class="user-container-head">Job Posting Access</div>
    <div class="user-content">
        <h2 class="user-content-head">Job Posting Access</h2>
        <div id="m_access">
            <script>
                var functions = <?= json_encode($functions); ?>;
                var companies = <?= json_encode($companies); ?>;
                var users = <?= json_encode($users); ?>;
                var jobs_access = <?= json_encode($jobs_access); ?>;
            </script>

            <table class="table borderless table-responsive">
                <tbody>
                    <tr>
                        <td>
                            <input type="text" id="select_user" placeholder="User Name" class="form-control input-sm frm_add_element"/>
                            <input type="hidden" id="selected_user_id">
                        </td>
                        <td>
                            <select class="form-control" id="select_company" data-text="------- Select Company -------"  data-allow-clear="true"></select>
                        </td>
                        <td>
                            <select class="form-control" id="select_function" data-text="Select Function"  data-allow-clear="true"></select>
                        </td>
                        <td>
                            <button id="btn_add_access" class="btn btn-sm user-btn">Update</button>
                        </td>
                    </tr>
                </tbody>
            </table>


            <table class="table table-striped margin-top table-responsive display" id="tbl_jobs_access">
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

<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

<?php $this->load->view('includes/footer'); ?>