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
   
   //Enter key on input boxes automatically submits the form
   jQuery('input').keypress(function(evt) {
      var keycode = (evt.keyCode ? evt.keyCode : evt.which);
      if(keycode == '13'){
         jQuery(this).parents('form').first().trigger('click');
      }
   });
   
   //Ctrl+S Saves the website info
   jQuery(window).bind('keydown', function(event) {
      if ( event.ctrlKey || event.metaKey ) {
         switch (String.fromCharCode(event.which).toLowerCase()) {
         case 's':
            event.preventDefault();
            if( jQuery('#website-details-fieldset').hasClass('input') ) {
               jQuery('#website_details_meta .toggleEdit').trigger('click');
            }
            break;
         }
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
                  jQuery('#website-details p.no_auth').slideUp('fast');
                  jQuery('fieldset#'+fieldset).removeClass('input').addClass('display');
                  $button.html('Edit');
               } else {
                  jQuery('#website-details p.no_auth').slideDown('fast');
               }
            }).fail(function() {
               $button.html('Done');
               jQuery('#website-details p.no_auth').slideDown('fast');
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
            <td><input type="text" readonly="readonly" value="' + jQuery('#db_password').val() +'"></td>\n\
            <td><a class="button small" title="' + jQuery('#phpmyadmin_url').val() +'" href="' + jQuery('#phpmyadmin_url').val() +'" target="_blank">Open URL &#10138;</a></td>\n\
            <td><a href="?page=wm-db-credentials&action=edit&id='+r.id+'" class="button small">Edit</a>\n\
            <form action="#" data-role="delete-db" data-db_id="'+r.id+'">\n\
            <input type="hidden" name="action" value="wm_db_delete">\n\
            <input type="hidden" value="'+r.id+'" name="db_id">\n\
            <input type="submit" class="button-primary small" data-db_id="'+r.id+'" value="Delete">\n\
            </td>\n\
            </tr>');
            jQuery('#db_host, #db_name, #db_username, #db_password, #phpmyadmin_url').val('');
            $button.html('Save');
            jQuery('.toggleNewDb').html('Add New');
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
         jQuery('form#new-db-credentials').slideUp('fast');
         jQuery(this).text('Add New');
      } else {
         jQuery('form#new-db-credentials').slideDown('fast');
         jQuery(this).text('Cancel');
      }
   });
   
   jQuery('.toggleNewFtp').click(function(evt) {
      evt.preventDefault();
      if(jQuery('form#new-ftp-credentials').is(':visible')) {
         jQuery('form#new-ftp-credentials').slideUp('fast');
         jQuery(this).text('Add New');
      } else {
         jQuery('form#new-ftp-credentials').slideDown('fast');
         jQuery(this).text('Cancel');
      }
   });
   
   jQuery('.toggleNewNote').click(function(evt) {
      evt.preventDefault();
      if(jQuery('form#new-note').is(':visible')) {
         jQuery('form#new-note').slideUp('fast');
         jQuery(this).text('Add New');
      } else {
         jQuery('form#new-note').slideDown('fast');
         jQuery(this).text('Cancel');
      }
   });
   
   jQuery('form[data-role="delete-db"]').live('click', function(evt) {
      evt.preventDefault();
      var really = prompt("Please type DELETE to delete this database.");
      var post_data = jQuery(this).serialize();
      if(really === "DELETE") {
         jQuery.post(ajaxurl, post_data, function(r) {
            if(r.status == 'success') {
               jQuery('tr#db-' + r.id).slideUp('fast', function() {
                  jQuery(this).remove();
               });
            } else {
               jQuery('html').fadeOut('fast', function() {
                  jQuery('html').fadeIn('fast', function() {
                     jQuery('#wm_db_credentials_meta small.no_delete').fadeIn().delay(2500).fadeOut();
                  });
               });
            }
         });
      }
   });
});