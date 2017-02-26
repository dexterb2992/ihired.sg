<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Expires" content="Tue, 01 Jan 1995 12:12:12 GMT">
    <meta http-equiv="Pragma" content="no-cache">
    <title>Applicants Management| iHired</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />    
    <link rel="stylesheet" href="<?= asset_url('jquery-plugin/bootstrap/css/bootstrap.css'); ?>" media="screen" />
    <link rel="stylesheet" href="<?= asset_url('jquery-plugin/dataTables/css/jquery.dataTables.css'); ?>" media="screen" />
    <link rel="stylesheet" href="<?= asset_url('css/jquery-ui.css'); ?>" media="screen" />
    <?php 
    $cenm = $this->router->fetch_class().'/'.$this->router->fetch_method();
    if($cenm == 'home/index' || $cenm == 'home/login'): 
    ?>
    <link rel="stylesheet" href="<?= asset_url('css/mystyle.css')?>" />
    <?php endif; ?> 

    <script>
     var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23019901-1']);
      _gaq.push(['_setDomainName', "bootswatch.com"]);
        _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);

     (function() {
       var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();
    </script>

    <script src="<?= asset_url('js/jquery-3.1.1.min.js'); ?>"></script>
    <script src="<?= asset_url("js/jquery-migrate-3.0.0.js"); ?>"></script>
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
    

      <link rel="stylesheet" href="<?= asset_url('css/normalize.css')?>">
      <link rel="stylesheet" href="<?= asset_url('css/main.css')?>">
      <link rel="stylesheet" href="<?= asset_url('css/styles.css')?>">
      <link rel="stylesheet" type="text/css" href="<?= asset_url('css/menu.css')?>"/>

      <script src="<?= base_url(); ?>assets/js/plugins.js"></script>


		<link href="<?= asset_url('images/icons/favicon.ico');?>" rel="shortcut icon" type="image/x-icon">
  </head>