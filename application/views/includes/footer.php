  </div>
          <div style="clear:both; height:100px;"></div>
          
      </section> <!--end of first section-->
  </div>
  <script src="<?= asset_url('js/jquery-ui.js'); ?>" ></script>
  <script src="<?= asset_url('jquery-plugin/bootstrap/js/bootstrap.min.js'); ?>" ></script>
  <script src="<?= asset_url("jquery-plugin/bootbox.min.js"); ?>" ></script>
  <script src="<?= asset_url('jquery-plugin/dataTables/js/jquery.dataTables.js'); ?>" ></script>
  <script src="<?= asset_url('jquery-plugin/dataTables/js/fnReloadAjax.js'); ?>" ></script>
  <script src="<?= asset_url('jquery-plugin/chosen/js/chosen.jquery.js'); ?>" ></script>
  <script src="<?= asset_url('js/SimpleAjaxUploader.js'); ?>"></script>

  <script>
    var base_url  = '<?= base_url(); ?>';
    var module    = '<?= $js_module; ?>';
  </script>

  <script src="<?= base_url();?>assets/js/common.js"></script>
  <?php if (!empty($js_module)): ?>
  <script src="<?= base_url();?>assets/js/modules/<?= $js_module; ?>.js"></script>
  <?php endif; ?>

  <script src="<?= base_url(); ?>assets/js/plugins.js"></script>

  <footer id="bottom" style="min-width:1040px; width:100%;">
  	<div style="height:80px; clear:both;"></div>
      <div class="clearfix"></div>
      <div class="sections clearfix">
      <div class="" style="width:200px">
        <br>
        <h4>Singapore</h4>
        <img style="width: 50px;border: 1px solid #DADADA;" src="<?= base_url();?>/assets/img/sgflag.png">
        <br>
        <br>
        <br>
        
      </div>
      <div class="" style="width:310px">        
        <div class="" style="border-left: 2px solid #9D9D9D;border-right: 2px solid #9D9D9D;padding:0 30%;">
          <br>
          <h4 style="">Get Connected</h4>
          <img src="<?= base_url();?>/assets/img/linkd.png">
          <img src="<?= base_url();?>/assets/img/twitter.png">
          <img src="<?= base_url();?>/assets/img/fb.png">
        <br>
        <br>
        <br>     
        </div>      
      </div>
      <div class="" style="width:200px;padding-left:80px;">
        <br>
        <h4>Get Connected</h4>
        <h5>info@ihired.sg</h5>
      </div>
      <div class=""><br>
        <a href="#" style=""><img src="<?= asset_url('images/logo.jpg'); ?>"></a><br><br>
        <a href="http://ihired.sg/" style="border:1px solid #000; border-radius:5px;padding:8px 10px;color:#000">Go to <span style="color:#44517e">ihired.sg</span></a>
        <br><br>
      </div>
    </div>
      <div class="copy">
          <div>
              <div>Copyright 2013 - 2014 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; iHired.sg</div>
      </div>
      </div>

  </footer>

  </body>
</html>