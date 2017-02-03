<?php $this->load->view('includes/navi_in'); ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

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
                            <a href="#!" id="btn_add_access" class="btn btn-primary">Update</a>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped margin-top display datatable" id="tbl_companies">
                <thead class="red-table-header">
                    <tr>
                        <th width="20%">Company Name</th>
                        <th width="15%">Industry</th>
                        <th width="10%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($job_access as $key => $access) :
                ?>
                    <tr data-id="<?= $access['job_access_id']; ?>">
                        <td class="vert-align">
                            <?= ucwords($access['full_name']); ?>
                        </td>
                        <td class="vert-align">
                            <?= $access['function_name']; ?>
                        </td>
                        <td class="vert-align">
                            <button type="button" class="btn btn-primary btn-xs btn-delete-access trash-ikon" data-id="<?= $access['job_access_id']; ?>"></button>
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