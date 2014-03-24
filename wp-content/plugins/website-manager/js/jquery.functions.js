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
   jQuery('.toggleEdit').click(function(evt) {
      var fieldset = jQuery(this).attr('rel');
      evt.preventDefault();
      if(jQuery('fieldset#'+fieldset).hasClass('display')) {
         jQuery('fieldset#'+fieldset).removeClass('display').addClass('input');
         jQuery(this).text('Done');
      } else {
         jQuery('fieldset#'+fieldset).addClass('display').removeClass('input');
         jQuery(this).text('Edit');
      }
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
});