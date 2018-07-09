/**
	Javascript Utils for Google Analytics
	Author: Xerxis Anthony B. Alvar
	Dependencies : jQuery, JU.js
*/
JU.module("GA",{addGoogleAnalytics:function(c){if("undefined"==typeof _qaq){var a=document.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"==document.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b);$("body").after('<script type="text/javascript">var _gaq = _gaq || [];<\/script>')}_gaq.push(["_setAccount",c]);_gaq.push(["_trackPageview"]);_gaq.push(["_setClientInfo",
!1]);_gaq.push(["_setAllowHash",!1]);_gaq.push(["_setDetectFlash",!1]);_gaq.push(["_setDetectTitle",!1]);_gaq.push(["_setCampaignCookieTimeout",31536E6]);_gaq.push(["_setCampaignTrack",!1])},addGoogleEventAnalytics:function(c,a,b){_gaq.push(["_trackEvent",c,a,b])},setGoogleEventTracker:function(c,a,b,d){"undefined"==typeof _gaq&&this.addGoogleAnalytics(c);this.addGoogleEventAnalytics(a,b,d)}});