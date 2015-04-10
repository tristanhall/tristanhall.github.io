<tr 
   data-comment-id="<?php echo $comment_ID; ?>" 
   data-comment-author="<?php echo $comment_author; ?>" 
   data-comment-date="<?php echo $comment_date->format(); ?>"
>
   <td>
      <blockquote class="dashicons-before">
         <p><?php echo $comment_content; ?></p>
         <cite title="<?php echo $comment_date->format( 'l, F j, Y g:i a' ); ?>">
            <span>&ndash; <?php echo sprintf( __( 'Posted %s by %s', 'th' ), $comment_date->fromNow()->getRelative(), $comment_author ); ?></span>
            <a class="alignright stashbox-note-delete" href="#" title="<?php _e( 'Delete this note?', 'th' ); ?>" data-comment-id="<?php echo $comment_ID; ?>"><?php _e( 'Delete?', 'th' ); ?></a>
         </cite>
      </blockquote>
   </td>
</tr>