/*
 * jQuery.liveFilter
 *
 * Copyright (c) 2009 Mike Merritt
 *
 * Forked by Lim Chee Aun (cheeaun.com)
 * 
 */
(function($){
	$.fn.liveFilter = function(inputEl, filterEl, options){
		var defaults = {
			filterChildSelector: null,
			filter: function(el, val){
				return $(el).text().toUpperCase().indexOf(val.toUpperCase()) >= 0;
			},
			before: function(){},
			after: function(){}
		};
		var options = $.extend(defaults, options);
		
		var el = $(this).find(filterEl);
		if (options.filterChildSelector) el = el.find(options.filterChildSelector);
      
		var filter = options.filter;
		$(inputEl).keyup(function(){
			var val = $(this).val();
			var contains = el.filter(function(){
				return filter(this, val);
			});
			var containsNot = el.not(contains);
			if (options.filterChildSelector){
				contains = contains.parents(filterEl);
				containsNot = containsNot.parents(filterEl).hide();
			}
			
			options.before.call(this, contains, containsNot);
			
			contains.show();
			containsNot.hide();
			
			if (val === '') {
				contains.show();
				containsNot.show();
			}
			
			options.after.call(this, contains, containsNot);
		});
	}
})(jQuery);

$(function() {
   window.rewrites = [];
   window.redirect_clips = [];
   window.rewrite_clips = [];
   window.nth_clip = 0;
   //var copy_all_rewrites = new ZeroClipboard( document.getElementById( 'rewrites' ) );
   //var copy_all_redirects = new ZeroClipboard( document.getElementById( 'redirects' ) );
   
   $('textarea[name="sources"]').keyup(function() {
      var urls = $(this).val().split("\n");
      var used_urls = [];
      if( $(this).val() !== '' && $('textarea[name="destinations"]').val() !== '' ) {
         $('button[data-role="clear"]').fadeIn('slow');
      } else {
         $('button[data-role="clear"]').fadeOut('slow');
      }
      $('#sources').html('');
      for(i = 0; i < urls.length; i++) {
         if( ( used_urls.indexOf( urls[i] ) === -1 && $('#no_dupes').is(':checked') ) || !$('#no_dupes').is(':checked') ) {
            used_urls.push( urls[i] );
            $('#sources').append( '<li data-url="' + urls[i] + '">' + urls[i] + '</li>' );
         }
         $('#sources > li').draggable({ revert: true });
      }
      $('#sources').liveFilter('#source-filter', 'li');
   });
   
   $('textarea[name="destinations"]').keyup(function() {
      var urls = $(this).val().split("\n");
      var used_urls = [];
      if( $(this).val() !== '' && $('textarea[name="sources"]').val() !== '' ) {
         $('button[data-role="clear"]').fadeIn('slow');
      } else {
         $('button[data-role="clear"]').fadeOut('slow');
      }
      $('#destinations').html('');
      for(i = 0; i < urls.length; i++) {
         if( ( used_urls.indexOf( urls[i] ) === -1 && $('#no_dupes').is(':checked') ) || !$('#no_dupes').is(':checked') ) {
            used_urls.push( urls[i] );
            $('#destinations').append('<li data-url="' + urls[i] + '">' + urls[i] + '</li>');
            $('#destinations li[data-url="' + urls[i] + '"]').droppable({
               drop: function( event, ui ) {
                  var src_url = ui.draggable.attr('data-url');
                  var dest_url = $(this).attr('data-url');
                  var redirect = "Redirect 301 " + src_url + " " + dest_url;
                  var rewrite = 'RewriteRule ^' + src_url + '$ ' + dest_url + ' [L,NC,R=301]';
                  window.rewrites.push('<span id="copy-rewrite-' + window.nth_clip + '" data-clipboard-text="' + rewrite + '">' + rewrite + '</span>');
                  $('#rewrites').html('&lt;IfModule mod_rewrite.c&gt;<br>RewriteEngine On<br>RewriteBase /<br>');
                  $('#rewrites').append(window.rewrites.join('<br>') + '<br>');
                  $('#rewrites').append('&lt;/IfModule&gt;');
                  $('#redirects').append("<span id='copy-redirect-" + window.nth_clip + "' data-clipboard-text='" + redirect + "'>" + redirect + "</span><br>");
                  window.nth_clip++;
                  $(document).trigger('url-dropped');
               }
            });
         }
      }
      $('#destinations').liveFilter('#destination-filter', 'li');
   });
   
   $('button[data-role="clear"]').click(function() {
      $('#rewrites').html('&lt;IfModule mod_rewrite.c&gt;<br>RewriteEngine On<br>RewriteBase /<br>&lt;/IfModule&gt;');
      $('#redirects').html('');
      window.rewrites = [];
      window.rewrite_clips = [];
      window.redirect_clips = [];
   });
   
   $('input#use_modrewrite').change(function() {
      if( $(this).is(':checked') ) {
         $('#redirects').fadeOut('fast', function() {
            $('#rewrites').fadeIn('fast');
         });
      } else {
         $('#rewrites').fadeOut('fast', function() {
            $('#redirects').fadeIn('fast');
         });
      }
   });
   
   $(document).on('url-dropped', function() {
      var i = 0;
      window.rewrite_clips = [];
      window.redirect_clips = [];
      $('[data-clipboard-text]').each(function() {
         var id = $(this).attr('id');
         window.rewrite_clips[i] = new ZeroClipboard( document.getElementById( id ) );
         window.redirect_clips[i] = new ZeroClipboard( document.getElementById( id ) );
      });
   });
   
});