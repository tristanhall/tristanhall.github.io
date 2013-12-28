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
   //Parallax Scrolling
   // Cache the Window object
   $window = $(window);
   // Cache the Y offset and the speed of each sprite
   $('[data-type]').each(function() {	
      $(this).data('offsetY', parseInt($(this).attr('data-offsetY')));
      $(this).data('Xposition', $(this).attr('data-Xposition'));
      $(this).data('speed', $(this).attr('data-speed'));
   });
   // For each element that has a data-type attribute
   $('div[data-type="background"]').each(function(){
      // Store some variables based on where we are
      var $self = $(this),
      offsetCoords = $self.offset(),
      topOffset = offsetCoords.top;
      // When the window is scrolled...
      $(window).scroll(function() {
         // If this section is in view
         if ( ($window.scrollTop() + $window.height()) > (topOffset) &&
                 ( (topOffset + $self.height()) > $window.scrollTop() ) ) {
            // Scroll the background at var speed
            // the yPos is a negative value because we're scrolling it UP!								
            var yPos = -($window.scrollTop() / $self.data('speed'));
            // If this element has a Y offset then add it on
            if ($self.data('offsetY')) {
               yPos += $self.data('offsetY');
            }
            // Put together our final background position
            var coords = '0 '+ yPos + 'px';
            // Move the background
            $self.css({ backgroundPosition: coords });
            // Check for other sprites in this section	
            $('[data-type="background"]', $self).each(function() {
               // Cache the sprite
               var $sprite = $(this);
               // Use the same calculation to work out how far to scroll the sprite
               var yPos = -($window.scrollTop() / $sprite.data('speed'));					
               var coords = '0 ' + (yPos + $sprite.data('offsetY')) + 'px';
               $sprite.css({ backgroundPosition: coords });													
               
            }); // sprites
         }; // in view
      }); // window scroll
   });	// each data-type
   $('[data-type="sprite"]').each(function(){
      // Store some variables based on where we are
      var $self = $(this),
      offsetCoords = $self.offset(),
      topOffset = offsetCoords.top;
      // When the window is scrolled...
      $(window).scroll(function() {
         // If this section is in view
         if ( ($window.scrollTop() + $window.height()) > (topOffset) &&
                 ( (topOffset + $self.height()) > $window.scrollTop() ) ) {
            // Scroll the background at var speed
            // the yPos is a negative value because we're scrolling it UP!								
            var yPos = -($window.scrollTop() / $self.data('speed'));
            // If this element has a Y offset then add it on
            if ($self.data('offsetY')) {
               yPos += $self.data('offsetY');
            }
            // Put together our final background position
            var coords = yPos + 'px';
            // Move the background
            $self.css({ backgroundPosition: '0px' + coords });
         }; // in view
      }); // window scroll
   });	// each data-type
});