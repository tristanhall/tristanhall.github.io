jQuery(function() {
   
   jQuery('form.mimic input').each(function() {
      var name = jQuery(this).attr('name');
      if(jQuery('[data-role="'+name+'"]').length > 0) {
         jQuery(this).on('keyup', function() {
            jQuery('[data-role="'+name+'"]').first().html( jQuery(this).val() );
            jQuery('[data-role="'+name+'"]').first().attr('href', jQuery(this).val());
         });
      }
   });
   
   jQuery('form.mimic select').each(function() {
      var name = jQuery(this).attr('name');
      if(jQuery('[data-role="'+name+'"]').length > 0) {
         jQuery(this).on('change', function() {
            jQuery('[data-role="'+name+'"]').first().val( jQuery(this).val() );
         });
      }
   });
   
   jQuery('#website_details_meta .toggleEdit').click(function(evt) {
      evt.preventDefault();
      var fieldset = jQuery(this).attr('rel');
      if(jQuery('fieldset#'+fieldset).hasClass('display')) {
         jQuery('fieldset#'+fieldset).removeClass('display').addClass('input');
         jQuery(this).text('Done');
      } else {
         if(jQuery('#title').val() === '') {
            alert('Please enter a domain name first.');
         } else {
            var post_data = jQuery('#website-details').serialize();
            jQuery(this).text('Saving...');
            var $button = jQuery(this);
            jQuery.post(ajaxurl, post_data, function(d) {
               if(d === 'success') {
                  if(jQuery('input[name="new_website"]').val() === 'yes') {
                     jQuery('input[name="new_website"]').val('no');
                  }
                  jQuery('#website-details p.no_auth').slideUp();
                  jQuery('fieldset#'+fieldset).removeClass('input').addClass('display');
                  $button.html('Edit');
               } else {
                  jQuery('#website-details p.no_auth').slideDown();
               }
            }).fail(function() {
               $button.html('Done');
               jQuery('#website-details p.no_auth').slideDown();
            });
         }
      }
   });
   
   jQuery('#new-db-credentials').submit(function(evt) {
      evt.preventDefault();
      var post_data = jQuery(this).serialize();
      var $button = jQuery('#new-db-credentials input[type="submit"]');
      $button.html('Saving...');
      jQuery.post(ajaxurl, post_data, function(r) {
         if(r.status === 'success') {
            jQuery('#wm_db_credentials_meta .no_auth').fadeOut('fast');
            jQuery('#related_db_credentials tbody').append('<tr>\n\
            <td>' + jQuery('#db_host').val() +'</td>\n\
            <td>' + jQuery('#db_name').val() +'</td>\n\
            <td>' + jQuery('#db_username').val() +'</td>\n\
            <td>' + jQuery('#db_password').val() +'</td>\n\
            <td><a href="' + jQuery('#phpmyadmin_url').val() +'" target="_blank">Open URL &#10138;</a></td>\n\
            </tr>');
            jQuery('#db_host, #db_name, #db_username, #db_password, #phpmyadmin_url').val('');
            $button.html('Save');
            jQuery('#new-db-credentials').slideUp('fast');
         } else {
            jQuery('#wm_db_credentials_meta .no_auth').fadeIn('fast');
            $button.html('Save');
         }
      });
   }); 
   
   jQuery('.toggleNewDb').click(function(evt) {
      evt.preventDefault();
      if(jQuery('form#new-db-credentials').is(':visible')) {
         jQuery('form#new-db-credentials').slideUp();
         jQuery(this).text('Add New');
      } else {
         jQuery('form#new-db-credentials').slideDown();
         jQuery(this).text('Cancel');
      }
   });
   
   jQuery('.toggleNewFtp').click(function(evt) {
      evt.preventDefault();
      if(jQuery('form#new-ftp-credentials').is(':visible')) {
         jQuery('form#new-ftp-credentials').slideUp();
         jQuery(this).text('Add New');
      } else {
         jQuery('form#new-ftp-credentials').slideDown();
         jQuery(this).text('Cancel');
      }
   });
   
   jQuery('.toggleNewNote').click(function(evt) {
      evt.preventDefault();
      if(jQuery('form#new-note').is(':visible')) {
         jQuery('form#new-note').slideUp();
         jQuery(this).text('Add New');
      } else {
         jQuery('form#new-note').slideDown();
         jQuery(this).text('Cancel');
      }
   });
   
   jQuery('#website_details_meta form').submit(function() {
      
   });
});