<h3><?php _e( 'General Settings', 'th' ); ?></h3>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="enckeypath"><?php _e( 'Absolute Path to Encryption Key', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" placeholder="<?php echo $default_path; ?>" value="<?php esc_attr_e( $key_path ); ?>" name="sb_enckeypath" class="widefat" id="enckeypath">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="force_https"><?php _e( 'Force HTTPS on Stashbox admin pages?', 'th' ); ?></label>
         </th>
         <td>
            <input type="checkbox" <?php echo $force_https === true ? 'checked="checked"' : ''; ?> value="1" name="sb_force_https" id="force_https">
         </td>
      </tr>
   </tbody>
</table>