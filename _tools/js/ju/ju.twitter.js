/**
	Javascript Utils for Facebook JS SDK
	Author: Xerxis Anthony B. Alvar
	
	Dependencies : jQuery, JU.js
*/

JU.module('TWITTER',{	

	/**
		PostToTweet
		@Params:
				_msg : Tweet message
				_url : Url to Tweet
			  ht   : optional height
				wt   : optional width 		  
	*/	

	/**
		Description : Facebook API (Feed) 		

	*/
	PostToTwitt :function(_msg,_url,ht,wt) {
							if(ht === undefined) { ht = 500; }
							if (wt === undefined) { wt = 500; }
							_msg = escape(_msg); _url = escape(_url);
							var boxWidth;
							var boxHeight;
							boxWidth = (window.screen.width/2) - (wt/2);
							boxHeight = (window.screen.height/2) - (ht/2);
								
							var winbox = window.open('https://twitter.com/share?text='+ _msg + '&url=' +_url,'popup','width='+wt+',height='+ht+',scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=' + boxWidth + ',top=' + boxHeight + ',screenX=' + boxWidth + ',screenY=' + boxHeight); 
							
							winbox.focus();
							return false;
	}


});