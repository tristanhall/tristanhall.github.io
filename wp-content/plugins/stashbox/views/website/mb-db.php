<?php wp_nonce_field( 'website', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="db_host"><?php _e( 'Database Host', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="db_host" id="db_host" value="<?php echo $db_host; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="db_user"><?php _e( 'Database Username', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="db_user" id="db_user" value="<?php echo $db_user; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="db_pass"><?php _e( 'Database Password', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="db_pass" id="db_pass" value="<?php echo $db_pass; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="db_name"><?php _e( 'Database Name', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="db_name" id="db_name" value="<?php echo $db_name; ?>">
         </td>
      </tr>
   </tbody>
</table>