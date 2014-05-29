$(function() {
   window.rewrites = new Array;
   
   $('textarea[name="sources"]').keyup(function() {
      var urls = $(this).val().split("\n");
      if( $(this).val() !== '' && $('textarea[name="destinations"]').val() !== '' ) {
         $('button[data-role="clear"]').fadeIn('slow');
      } else {
         $('button[data-role="clear"]').fadeOut('slow');
      }
      $('#sources').html('');
      for(i = 0; i < urls.length; i++) {
         $('#sources').append('<li data-url="' + urls[i] + '">' + urls[i] + '</li>');
      }
      $('#sources > li').draggable({ revert: true });
   });
   
   $('textarea[name="destinations"]').keyup(function() {
      var urls = $(this).val().split("\n");
      if( $(this).val() !== '' && $('textarea[name="sources"]').val() !== '' ) {
         $('button[data-role="clear"]').fadeIn('slow');
      } else {
         $('button[data-role="clear"]').fadeOut('slow');
      }
      $('#destinations').html('');
      for(i = 0; i < urls.length; i++) {
         $('#destinations').append('<li data-url="' + urls[i] + '">' + urls[i] + '</li>');
         $('#destinations li[data-url="' + urls[i] + '"]').droppable({
            drop: function( event, ui ) {
               var src_url = ui.draggable.attr('data-url');
               var dest_url = $(this).attr('data-url');
               window.rewrites.push('RewriteRule ^' + src_url + '$ ' + dest_url + ' [L,NC,R=301]');
               $('#rewrites').html('&lt;IfModule mod_rewrite.c&gt;<br>RewriteEngine On<br>RewriteBase /<br>');
               $('#rewrites').append(window.rewrites.join('<br>') + '<br>');
               $('#rewrites').append('&lt;IfModule&gt;');
               $('#redirects').append("Redirect 301 " + src_url + " " + dest_url + "<br>");
            }
         });
      }
   });
   
   $('button[data-role="clear"]').click(function() {
      $('#rewrites').html('&lt;IfModule mod_rewrite.c&gt;<br>RewriteEngine On<br>RewriteBase /<br>&lt;IfModule&gt;');
      $('#redirects').html('');
      window.rewrites = [];
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
   
});