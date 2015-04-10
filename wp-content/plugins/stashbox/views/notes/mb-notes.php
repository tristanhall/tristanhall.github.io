<button type="button" data-post-type="<?php echo $post_type; ?>" data-post-id="<?php echo $post_id; ?>" id="stashbox-note-create" class="button-primary alignright"><?php _e( 'Add Note', 'th' ); ?></button>
<table class="form-table" id="stashbox-note-table">
   <tbody>
      <?php foreach( $notes as $note ) {
         \TH\WPAtomic\Template::make( 'notes/row-note', $note );
      } ?>
   </tbody>
</table>
<div id="stashbox-note-lightbox" style="display: none;">
   <table class="form-table">
      <tbody>
         <tr>
            <td>
               <label for="stashbox-note-text"><?php _e( 'Enter Your Note:', 'th' ); ?></label>
            </td>
         </tr>
         <tr>
            <td>
               <textarea id="stashbox-note-text" class="widefat" rows="5"></textarea>
            </td>
         </tr>
         <tr>
            <td>
               <button id="stashbox-note-submit" data-post-type="<?php echo $post_type; ?>" data-post-id="<?php echo $post_id; ?>" type="button" class="alignright button-primary"><?php _e( 'Save Note', 'th' ); ?></button>
            </td>
         </tr>
      </tbody>
   </table>
</div>