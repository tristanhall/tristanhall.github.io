jQuery(function(){
   jQuery("#stashbox-domain-dnstabs .hidden").removeClass('hidden');
   jQuery("#stashbox-domain-dnstabs").tabs();
   jQuery('select#domain').chosen();
   jQuery('#test-domain-reminder-email').click(function() {
      var get_data = {
         'action': 'stashbox_domain_test_reminder'
      };
      jQuery.get(stashbox.ajax_url, get_data, function(r) {
         if( r.status === 'success' ) {
            alert( 'Successfully sent test message!' );
         } else {
            alert( 'Failed to send test message!' );
         }
      });
   });
});