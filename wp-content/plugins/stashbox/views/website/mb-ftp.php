<?php wp_nonce_field( 'website', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="ftp_user"><?php _e( 'FTP Username', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="ftp_user" id="ftp_user" value="<?php echo $ftp_user; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ftp_pass"><?php _e( 'FTP Password', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="ftp_pass" id="ftp_pass" value="<?php echo $ftp_pass; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ftp_port"><?php _e( 'FTP Port', 'th' ); ?></label>
         </th>
         <td>
            <input type="number" min="1" max="<?php echo STASHBOX_MAX_PORT_NUMBER; ?>" step="1" name="ftp_port" id="ftp_port" value="<?php echo $ftp_port; ?>">
         </td>
      </tr>
   </tbody>
</table>