<?php
if (!function_exists('ihub_userCapture'))
{
    function ihub_userCapture($access_token)
	{
		try {
			if (config_item('is_launched'))
			{
				@file_get_contents('http://www.ihubanalytics.com/dna/rec.php?access_token=' . $access_token, 0, stream_context_create(array('http' => array('timeout' => 1))));
			}
		} catch (Exception $e) {
	
		}
    }
}

if (!function_exists('ihub_regCapture'))
{
    function ihub_regCapture($appid, $fbid)
	{
        try {
			if (config_item('is_launched'))
			{
				@file_get_contents('http://www.ihubanalytics.com/app_reg/api.php?appid=' . $appid . '&fbid=' . $fbid, 0, stream_context_create(array('http' => array('timeout' => 1))));
			}
        } catch (Exception $e) {

        }
    }
}

function get_appfooter($show_logo = 1) {
?>
<div style="text-align:justify;font-size:9px; color:#666; font-family:Arial,Tahoma, sans-serif;width: 100%;border-top: 1px solid #CCC;margin-top: 5px;">
	<style type="text/css">
		.poweredby_logo{float:right;height:60px;padding:15px 0;text-align:right; margin:0 0 0 30px; overflow:hidden;}
		.inst_info{ display:none;}
		@media only screen and (max-width: 767px){
			body{ width:100%;}.poweredby_logo{ float:none; margin:0; padding-top:10px; text-align:center;}.footerinfo{ width:95%;}.ch_ver{display:none;}.inst_info{ display:inline;}.pp_tc_link{ text-align:center;}.footerinfo{ width:95%;}
		}
	</style>
	<div class="footerinfo">
		<div class="poweredby_logo">
			<a href="http://www.ihdigital.com/" target="_blank"><img src="<?=config_item('url_protocol')?>apps5.ihubmedia.com/app_footer/images/ihdigital_footer.png" border="0" usemap="Map"/>
				<map name="Map" id="Map">
					<area shape="rect" coords="120,1,186,53" href="http://www.ihdigital.com/" target="_blank" />
				</map>
			</a>
		</div>
		<div class="pp_tc_link" style="width:100%;padding-top:5px;height:20px;">
			<a href="http://www.ihdigital.com/apps/privacypolicy.htm" target="_blank" style="color:#666;">Privacy Policy</a> | <a href="http://www.ihdigital.com/apps/termsofservice.htm" target="_blank" style="color:#666;">Terms of Service</a>
		</div>	
		<div style="margin: 0;padding: 0;">
		This promotion is in no way sponsored, endorsed or administered by, or associated with, Facebook. You understand that you are providing your information to <?=config_item('client_name')?> and not to Facebook. The information you provide will only be used for <?=config_item('client_name')?>'s marketing purposes.
		<?=config_item('is_instagram_app') ? '<span class="foot_inst_span">This application uses the Instagram(tm) API and is not endorsed or certified by Instagram or Instagram, Inc. All Instagram(tm) logos and trademarks displayed on this [application/website] are property of Instagram, Inc.</span>' : ''?>
		<span class="ch_ver">
		This application is optimised for the latest version of <a href="http://windows.microsoft.com/en-US/internet-explorer/downloads/ie" target="_blank" style="color:#428bca;">Internet Explorer</a> , <a href="http://www.getfirefox.net/" target="_blank" style="color:#428bca;">Mozilla Firefox</a> and <a href="http://support.google.com/chrome/bin/answer.py?hl=en&answer=95346" target="_blank" style="color:#428bca;">Google Chrome</a>. To check your system configuration, please click <a href="http://www.ihdigital.com/browser/" target="_blank" style="color:#428bca;">here</a>.</span>
		<span class="inst_info">Facebook&reg is a registered trademark of Facebook, Inc.</span>    
		</div>
 	</div>	
</div>
<?php
}

function get_fan_header($logo=false,$access_token=null) {

    if (!$logo) {
        $logo = 'https://graph.facebook.com/' . config_item('fanpage_id') . '/picture?type=square&access_token='.$access_token;
    }
?>
    <style type="text/css">

        #fan_container {border-bottom:1px solid #D8DFEA; margin:5px auto; padding:0; width:810px; background:white; height:40px; overflow:hidden;}
        #fan_container_left{float:left;width:32px; margin-right:4px;}
        #fan_container_right{float:left;padding-left:6px;width:680px;padding-top:5px}
        #fan_container_right a.btn{cursor:pointer;display:inline-block;font-size:14px;font-weight:700;line-height:20px;text-align:center;text-decoration:none;vertical-align:top;white-space:nowrap;background-image:url(https://apps2.ignitelab.com/public/images/dY1OX3Rg_lr.png);background-repeat:no-repeat;background-position:0 0;border:solid 1px #A6A6A6;padding:2px 8px}
        #fan_container_right .btn_border{-webkit-background-clip:padding-box;background-color:#FFF;border:1px solid #A5A5A5;-webkit-border-radius:3px;-webkit-box-shadow:0 1px 0 rgba(0,0,0,.1);display:inline-block;white-space:nowrap;border-color:rgba(0,0,0,.35);padding:0}
        #fan_container_right .btn_text{background:none;border:0;color:#333;cursor:pointer;display:inline-block;font-family:'Lucida Grande', Tahoma, Verdana, Arial, sans-serif;font-size:11px;font-weight:700;white-space:nowrap;margin:0;padding:1px 0 2px}
    </style>
    <div id="fan_container">
        <div id="fan_container_left">
            <div id="fan_logo"><a href="<?= config_item('fanpage_url'); ?>" target="_top"><img src="<?= $logo ?>" border="0" style="width:32px;height:32px;" /></a>
            </div>
        </div>
        <div id="fan_container_right"><?php $fanpage_tab = config_item('fanpage_tab'); ?>
            <a href="<?= config_item('fanpage_url'); ?>" target="_top"  class="btn btn_border  btn_text"  style="border-right: solid 1px #DBDBDB;" ><?= config_item('fanpage_name'); ?> </a>
            <a href="<?= $fanpage_tab['url']; ?>" target="_top" class="btn btn_border btn_text" style="margin-left: -5px;border-left: solid 1px #DBDBDB;" ><?= $fanpage_tab['name']; ?></a>
        </div>
        <div style="clear:both"></div>
    </div>
<?php
}
