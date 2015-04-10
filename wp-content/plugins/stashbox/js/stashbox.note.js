stashbox.note.bind_delete_note = function() {
   jQuery('.stashbox-note-delete').off('click');
   jQuery('.stashbox-note-delete').on('click', function(e) {
      e.preventDefault();
      var really_delete = confirm( stashbox.note.lang.confirm_delete );
      if( !really_delete ) {
         return false;
      }
      var comment_id = jQuery(this).attr('data-comment-id');
      var post_data = {
         'comment_id'     : comment_id,
         'stashbox_nonce' : stashbox.note.security,
         'action'         : 'stashbox_delete_note'
      };
      jQuery.post(stashbox.ajax_url, post_data, function(r) {
         if( r.status === 'success' ) {
            jQuery('#stashbox-note-table tr[data-comment-id="' + r.comment_id + '"]').animate({
               'background-color' : '#FFAAAA',
               'opacity'          : 0
            }, 500, function() {
               jQuery(this).remove();
            });
         } else {
            
         }
      });
   });
};

jQuery(function() {
   //Bind deletion actions to current comments
   stashbox.note.bind_delete_note();
   //Open the Note form in a lightbox
   jQuery('#stashbox-note-create').click(function(e) {
      e.preventDefault();
      var url = '#TB_inline?width=600&height=300&inlineId=stashbox-note-lightbox';
      tb_show(stashbox.note.lang.create_note, url);
   });
   //Create a Note via AJAX
   jQuery('#stashbox-note-submit').click(function(e) {
      e.preventDefault();
      var post_data = {
         'text'           : jQuery('#stashbox-note-text').val(),
         'stashbox_nonce' : stashbox.note.security,
         'post_id'        : jQuery(this).attr('data-post-id'),
         'post_type'      : jQuery(this).attr('data-post-type'),
         'action'         : 'stashbox_create_note'
      };
      jQuery.post(stashbox.ajax_url, post_data, function(r) {
         if( r.status === 'success' ) {
            //Empty the textarea contents
            jQuery('#stashbox-note-text').val('');
            //Add the comment to the table
            jQuery('#stashbox-note-table tbody').prepend(r.comment_row);
            //Re-bind the deletion actions
            stashbox.note.bind_delete_note();
            //Close the lightbox
            tb_remove();
         } else {
            alert( stashbox.note.lang.create_error );
         }
      });
   });
});