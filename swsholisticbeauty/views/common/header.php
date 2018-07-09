<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="shortcut icon" href="<?= $this->config->item('base_url') ?>images/favicon.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="email=no" name="format-detection" />
    <title><?= $this->config->item('site_name') ?></title>
    <?php $this->load->view('common/graph.php'); ?>
    <link href="//fonts.googleapis.com/css?family=Noto+Sans|Philosopher:400,700" rel="stylesheet">
    <link href="<?= $this->config->item('base_url') ?>styles/bootstrap.min.css?v=1" rel="stylesheet" type="text/css" />
    <link href="<?= $this->config->item('base_url') ?>scripts/slider/swiper.min.css?v=1" rel="stylesheet" type="text/css" />
    <link href="<?= $this->config->item('base_url') ?>scripts/animate/animate.min.css?v=1" rel="stylesheet" type="text/css" />
    <link href="<?= $this->config->item('base_url') ?>styles/main.css?v=3" rel="stylesheet" type="text/css" />
    <script src="<?= $this->config->item('base_url') ?>scripts/modernizr.custom.58219.js?v=1"></script>
    <script src="<?= $this->config->item('base_url') ?>scripts/animate/wow.min.js?v=1"></script>
    <script type="text/javascript" src="//www.youtube.com/iframe_api"></script>
    <script>
        new WOW().init();
    </script>
    <!--<script>
        var controller;
    </script>-->
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="<?= $this->config->item('base_url') ?>scripts/jquery.min.js?v=1"></script>
    <script src="<?= $this->config->item('base_url') ?>scripts/bootstrap.min.js?v=1"></script>
    <script src="<?= $this->config->item('base_url') ?>scripts/slider/swiper.jquery.min.js?v=1"></script>
    <script src="<?= $this->config->item('base_url') ?>scripts/main.js?v=1"></script>
    			
		<script src="<?= $this->config->item('base_url') ?>scripts/jquery.validationEngine.js?v=1"></script>
		<script src="<?= $this->config->item('base_url') ?>scripts/jquery.validationEngine-en.js?v=2"></script>
		<link rel="stylesheet" href="<?= $this->config->item('base_url') ?>styles/validationEngine.jquery.css?v=1">
		<!-- Facebook Pixel Code -->
		<script>
		  !function(f,b,e,v,n,t,s)
		  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		  n.queue=[];t=b.createElement(e);t.async=!0;
		  t.src=v;s=b.getElementsByTagName(e)[0];
		  s.parentNode.insertBefore(t,s)}(window, document,'script',
		  'https://connect.facebook.net/en_US/fbevents.js');
		  fbq('init', '1908034959519831');
		  fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none"
		  src="https://www.facebook.com/tr?id=1908034959519831&ev=PageView&noscript=1"
		/></noscript>
		<!-- End Facebook Pixel Code -->
</head>			
<body>