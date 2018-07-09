<style>
#app_compatibility{
	background-color:#FFF; border:2px solid #3B5998; padding:10px; font-size:11px; color:#000;display:none; margin-bottom:10px;
}
#app_javascript{
	background-color:#FFF; border:2px solid #3B5998; padding:10px; font-size:11px; color:#000;display:block; margin-bottom:10px;
}
</style>
<div id="app_javascript">
    	Sorry, this application requires javascript.<br />
        Please ensure that javascript option is turn on in your browser or update to one of the following browsers: <br />
    <ul>
    <li><a href="http://www.getfirefox.com" style="color:#000" target="_blank"> Mozilla Firefox </a></li>    
    <li><a href="http://www.apple.com/safari" style="color:#000" target="_blank"> Safari </a></li>    
    <li><a href="http://www.microsoft.com/ie" style="color:#000" target="_blank"> Microsoft Internet Explorer </a></li>
    <li><a href="http://www.google.com/chrome" style="color:#000" target="_blank"> Google Chrome </a></li>    
    </ul>
</div>
<div id="app_compatibility">
    	Sorry, your current browser does not support this application.<br />
        This application is supported by <a href="http://www.getfirefox.com" style="color:#000" target="_blank">Mozilla Firefox</a>, <a href="http://www.apple.com/safari" style="color:#000" target="_blank">Safari</a>, <a href="http://www.microsoft.com/ie" style="color:#000" target="_blank">Microsoft Internet Explorer</a> and <a href="http://www.google.com/chrome" style="color:#000" target="_blank">Google Chrome</a>.<br />
	    If you are already using any of the browsers listed above, please upgrade your browser to the latest version.<br />   
    	<strong>If you are using Internet Explorer 8, please ensure that compatibility view is turned off.</strong>
</div>
<script>
//if javascript is available, turn off the error message
document.getElementById('app_javascript').style.display = 'none';

var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();
//turn on error block
document.getElementById('app_compatibility').style.display = 'block';
if(BrowserDetect.browser == "Safari"){
	if(BrowserDetect.version >= 5){
		document.getElementById('app_compatibility').style.display = 'none';
	}
}
if(BrowserDetect.browser == "Firefox"){
	if(BrowserDetect.version >= 3.5){
		document.getElementById('app_compatibility').style.display = 'none';
	}
}
if(BrowserDetect.browser == "Explorer"){
	if(BrowserDetect.version >= 8){
		document.getElementById('app_compatibility').style.display = 'none';
	}
}
if(BrowserDetect.browser == "Chrome"){
	if(BrowserDetect.version >= 8){	
		document.getElementById('app_compatibility').style.display = 'none';
	}
}
</script>