jQuery(function() {
   jQuery('a.uploadImage').click(function() {
      //Cache the original functions
      window.original_send_to_editor = window.send_to_editor;
      //Set our input_id to return the image source to
      var input_id = jQuery(this).attr('id');
      //Open the media library
      tb_show('Upload an Image', 'media-upload.php?referer=tm-upload&type=image&TB_iframe=true&post_id=0&input_id='+input_id, false);
      //Change our send_to_editor function if the input_id is set
      window.send_to_editor = function(html) {
         var image_url = jQuery('img', html).attr('src');
         jQuery('input[name="'+input_id+'"]').val(image_url);
         tb_remove();
         //Trigger the event that resets the send_to_editor function
         jQuery(document).trigger('doneChoosingImage');
      };
      return false;
   });
   //Listen for the event to change the send_to_editor function back to 
   //the original WP function
   jQuery(document).on('doneChoosingImage', function() {
      window.send_to_editor = window.original_send_to_editor;
   });
});