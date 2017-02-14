<?php $this->load->view('includes/navi_in'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css">

<div class="user-container">
    <div class="user-container-head">Qualifications/Specialised Skills</div>
    <div class="user-content">
        <ul class="nav nav-tabs country-nav" data-tabs="tabs">
            <li class="active">
                <a href="#m_skill" data-toggle="tab">
                    <h2 class="country-nav-tabs">Manage Skills</h2>
                </a>
            </li>
            <li>
                <a href="#q_skills" data-toggle="tab">
                    <h2 class="country-nav-tabs">Qualifications for  Skills</h2>
                </a>
            </li>
        </ul>

        <script>
            var functions = <?= json_encode($functions); ?>;
            var skills = <?= json_encode($_skills); ?>;
            var qualifications = <?= json_encode($qualifications); ?>;
            var skills_qualifications = <?= json_encode($skills_qualifications); ?>;
        </script>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="m_skill">
                <table class="table borderless">
                    <tr>
                        <form id="frm_add_skill" method="post">
                            <td>
                                <input type="hidden" name="skills_name" id="skills_name">
                                <input type="text" id="txt_skills_name" class="form-control input-sm frm_add_element" placeholder="Skill Name" />
                            </td>
                            <td>
                                <select id="function_id" name="function_id" class="form-control" data-text="------ Select Function ------"></select>
                            </td>
                            <td>
                                <input type="checkbox" name="specialised" id="is_specialised" value="Y">
                                <label for="is_specialised">Specialised Skill</label>
                            </td>
                            <td>
                                <input type="button" id="btn_add_skill" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </form>
                    </tr>
                </table>

                <table class="table table-striped margin-top display datatable" id="tbl_skills">
                    <thead class="red-table-header">
                        <tr>
                            <th>Skills Name</th>
                            <th>Function</th>
                            <th>Specialised Skill</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
    				foreach ($skills as $key => $skill) :
    				?>
    					<tr data-id="<?= $skill->skills_id; ?>">
                            <td class="vert-align">
                                <?= ucwords($skill->skills_name); ?>
                            </td>
                            <td class="vert-align">
                                <?= $skill->function_name; ?>
                            </td>
                            <td class="vert-align">
                                <?= $skill->specialised == 'Y' ? "Yes" : "No"; ?>
                            </td>
                            <td class="vert-align">
                                <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-skill" data-id="<?= $skill->skills_id; ?>" id="btn_delete_skill" title="Delete">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
    				endforeach;
    				?>
                    </tbody>
                </table>
            </div><!-- tab-pane -->

            <div role="tabpanel" class="tab-pane" id="q_skills">
                <table class="table borderless">
                    <tr>
                        <form id="frm_add_skills_qualifications" method="post">
                            <td>
                                <select id="sb_skills" name="skills_id" class="form-control" data-text="------ Select Skills ------" data-allow-clear="true"></select>
                            </td>
                            <td>
                                <select id="sb_qualifications" name="qualifications_id" class="form-control" data-text="------ Select Qualifications ------" data-allow-clear="true"></select>
                            </td>
                            <td>
                                <input type="button" id="btn_add_skills_qualifications" class="btn btn-sm user-btn btn-noradius" value="Update">
                            </td>
                        </form>
                    </tr>
                </table>

                <table class="table table-striped margin-top display" id="tbl_skills_qualifications">
                    <thead class="red-table-header">
                        <tr>
                            <th>Skills Name</th>
                            <th>Qualifications</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($skills_qualifications as $key => $sq) :
                    ?>
                        <tr data-id="<?= $sq->sq_id; ?>">
                            <td class="vert-align">
                                <?= ucwords($sq->skills_name); ?>
                            </td>
                            <td class="vert-align">
                                <?= $sq->qualifications_name; ?>
                            </td>
                            <td class="vert-align">
                                <button type="button" class="btn btn-primary btn-xs btn-noradius btn-delete-skills-qualifications" id="btn_delete_sq" data-id="<?= $sq->sq_id; ?>" title="Delete">
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
        <!-- END Company -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<?php $this->load->view('includes/footer'); ?>