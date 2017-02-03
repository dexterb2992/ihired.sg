<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Expires" content="Tue, 01 Jan 1995 12:12:12 GMT">
    <meta http-equiv="Pragma" content="no-cache">
    <title>Applicants Management| iHired</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />    
    <link rel="stylesheet" href="<?= asset_url('dashboard/bootstrap/css/bootstrap.css'); ?>" media="screen" />
    <link rel="stylesheet" href="<?= asset_url('dashboard/dataTables/css/jquery.dataTables.css'); ?>" media="screen" />
    <link rel="stylesheet" href="<?= asset_url('dashboard/chosen/css/bootstrap-chosen.css'); ?>" media="screen" />
    <link rel="stylesheet" href="<?= asset_url('dashboard/css/jquery-ui.css'); ?>" media="screen" />
    <?php 
    $cenm = $this->router->fetch_class().'/'.$this->router->fetch_method();
    if($cenm == 'home/index' || $cenm == 'home/login'): 
    ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/mystyle.css')?>" />
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="<?= asset_url('dashboard/js/jquery-ui.js'); ?>" ></script>
    <script src="<?= asset_url('dashboard/bootstrap/js/bootstrap.min.js'); ?>" ></script>
    <script src="<?= asset_url('dashboard/bootswatch/js/bootswatch.js'); ?>" ></script>
    <script src="<?= asset_url("jquery-plugin/bootbox.min.js"); ?>" ></script>
    <script src="<?= asset_url('dashboard/dataTables/js/jquery.dataTables.js'); ?>" ></script>
    <script src="<?= asset_url('dashboard/dataTables/js/fnReloadAjax.js'); ?>" ></script>
    <script src="<?= asset_url('dashboard/chosen/js/chosen.jquery.js'); ?>" ></script>
  
    <script type="text/javascript">
      var base_url  = '<?= base_url(); ?>';
      var module    = '<?= $js_module; ?>';
    </script>

    <script type="text/javascript" src="<?= base_url();?>assets/js/common.js"></script>
    <?php if (!empty($js_module)) {?>
    <script type="text/javascript" src="<?= base_url();?>assets/js/modules/<?= $js_module; ?>.js"></script>
    <?php } ?>
    

      <link rel="stylesheet" href="<?= base_url('assets/css/normalize.css')?>">
      <link rel="stylesheet" href="<?= base_url('assets/css/main.css')?>">
      <link rel="stylesheet" href="<?= base_url('assets/css/styles.css')?>">
      <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/menu.css')?>"/>

      <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins.js"></script>
      <script type="text/javascript" src="<?= base_url(); ?>assets/js/menu.js"></script>


		<link href="<?= base_url('assets/images/icons/favicon.ico');?>" rel="shortcut icon" type="image/x-icon">
  </head>