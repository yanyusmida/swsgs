﻿/**
	Javascript Utils 
	Author: Xerxis Anthony B. Alvar (Script Block)
	Dependencies : jQuery
*/if(!window.APP)var APP=function(d){return{module:function(a,b){if(typeof a=="string"&&typeof b=="object"){this[a]={};for(var c in b)this[a][c]=b[c]}else console&&(typeof a!="string"&&console.log("Module name is not a string"),typeof b!="object"&&console.log("Module property is not an object"))},attrib:function(a,b){if(typeof a=="string"&&typeof b=="object")for(var c in this)c==a&&d.extend(this[a],b)}}}(jQuery);