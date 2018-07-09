/**
	Javascript Utils for Form Input Validation
	Author: Xerxis Anthony B. Alvar
	
	Dependencies : jQuery, JU.js
*/

JU.module('VALIDATE',{	

	/**
	*  Checks for Number only
	*/
	checkNumber : function (str) {
								var reg = new RegExp("^[0-9]+$");
								return (reg.test(str));
							},
	/** 
	*	Email Verification
	*/
	checkEmail : function(str) {  
								var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
								return emailPattern.test(str);  
							},
							
	/**
	*	Text Input Validation
	*/
	checkInput : function(str) {
								var _space  = /\S/;								
								return String (str).search (_space) != -1;
							},
    /**
     *  Mobile Number Check (Malaysia)
     */							
	checkMyMobile: function(str) {						
						  		var reg = new RegExp("[0-9]{10}");
						  		return (reg.test(str));		
							  },

    /**
     *  Mobile Number Check (Singapore)
     */							
   checkSgMobile : function(str) {
							var reg = new RegExp("[0-9]{8}");
							return (reg.test(str));		
   							},
   							
	/**
	 *  IC Number Check (Malaysia)
	 */							
   checkMyIc: function(str) {
							var reg = new RegExp("[0-9]{12}");
							return (reg.test(str));	
							},

	/**
	 *  IC Number Check (Malaysia)
	 */							
   checkSgIc: function(str) {
						  	var nric = /^[a-zA-Z]{1}[0-9]{7}[a-zA-Z]{1}$/;
						  	return (str.match(nric)) ? true : false;
							 }	

});