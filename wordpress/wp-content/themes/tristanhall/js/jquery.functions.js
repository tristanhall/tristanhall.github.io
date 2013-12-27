//Detect versions of IE
var IE = (function () {
   "use strict";
   
   var ret, isTheBrowser,
   actualVersion,
   jscriptMap, jscriptVersion;
   
   isTheBrowser = false;
   jscriptMap = {
      "5.5": "5.5",
      "5.6": "6",
      "5.7": "7",
      "5.8": "8",
      "9": "9",
      "10": "10"
   };
   jscriptVersion = new Function("/*@cc_on return @_jscript_version; @*/")();
   
   if (jscriptVersion !== undefined) {
      isTheBrowser = true;
      actualVersion = jscriptMap[jscriptVersion];
   }
   
   ret = {
      isTheBrowser: isTheBrowser,
      actualVersion: actualVersion
   };
   
   return ret;
}());
$.noConflict();
jQuery(document).ready(function($) {
   $(document).foundation();
   //External links open in a new window
   jQuery('a[rel*=external]').click(function() {
      this.target = "_blank";
   });
   //Remove noJS class
   jQuery('body').removeClass('noJS');
   //Test for Webkit
   Modernizr.addTest('webkit', function() {
      return !!navigator.userAgent.match(/webkit/i);
   });
   //Test for Firefox
   Modernizr.addTest('firefox', function() {
      return !!navigator.userAgent.match(/firefox/i);
   });
   //Return false for telephone links on desktops
   jQuery('a[href^="tel"]').click(function() {
      if(!jQuery('html').hasClass('touch')) {
         return false;
      }
   });
   //Add classes for IE
   if(IE.isTheBrowser) {
      jQuery('html').addClass('ie' + IE.actualVersion);
   }
});