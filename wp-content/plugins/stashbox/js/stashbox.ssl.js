jQuery(function() {
   jQuery('#test-ssl-reminder-email').click(function() {
      var get_data = {
         'action': 'stashbox_ssl_test_reminder'
      };
      jQuery.get(stashbox.ajax_url, get_data, function(r) {
         if( r.status === 'success' ) {
            alert( 'Successfully sent test message!' );
         } else {
            alert( 'Failed to send test message!' );
         }
      });
   });
})