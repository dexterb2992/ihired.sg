<?php $this->load->view('includes/navi_in'); ?>
<div class="user-container">
    <div class="user-container-head">Company Management <span class="pull-right">Update</span></div>
    <div class="user-content">
    	<h2 class="user-content-head">Manage Company</h2>
        <div id="m_company">        
        	<?php print_r($company); ?>
        </div>
        <!-- END Company -->
    </div>
</div>

<?php $this->load->view('includes/footer'); ?>