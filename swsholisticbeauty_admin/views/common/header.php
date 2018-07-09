<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$this->config->item('app_name');?></title>
	<link rel="stylesheet" href="<?=$this->config->item('server_root');?>_tools/jquery/jquery-ui.css" type="text/css" />	
	<link href="<?= base_url() ?>css/bootstrap.css" rel="stylesheet">
	<link href="<?= base_url() ?>css/style.css?v=<?=time()?>" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url() ?>font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>css/morris-0.4.3.min.css">
	<link href="<?= base_url() ?>css/validationEngine.jquery.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="<?=$this->config->item('server_root');?>_tools/jquery/jquery-1.8.2.min.js"></script>
	<script src="<?= base_url() ?>js/bootstrap.js"></script>
	<!-- Page Specific Plugins -->
	<script src="<?= base_url() ?>js/raphael-min.js"></script>
	<script src="<?= base_url() ?>js/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="<?= base_url() ?>js/jquery.placeholder.js"></script>
	<script src="<?= base_url() ?>js/jquery.validationEngine-en.js?v=5" type="text/javascript" charset="utf-8"></script>
	<script src="<?= base_url() ?>js/jquery.validationEngine.js?v=1" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="<?= base_url() ?>js/validationEngine.jquery.css">
	<script src="<?= base_url() ?>js/jquery-ui-timepicker-addon.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?= base_url() ?>js/jquery.pagination.js?v=3" type="text/javascript" charset="utf-8"></script>
	<script src="<?= base_url() ?>js/tinymce.min.js"></script>	
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/jquery.tagsinput.css" />
	<script src="<?= base_url() ?>js/jquery.tagsinput.min.js"></script>
</head>
<body>
<div id="mask_pop">
	<img src="<?= base_url() ?>images/loading.gif" />
</div>
<style>
#ui-datepicker-div, .colorpicker{ z-index: 10000 !important; }
.ui-datepicker .ui-datepicker-next .ui-icon, .ui-datepicker .ui-datepicker-prev .ui-icon{ text-indent: 0px !important; }
</style>
<?php	if(isset($message) && $message !=''){	?>
<script type="text/javascript">
	alert("<?=$message;?>");
</script>
<?php	}	?>
