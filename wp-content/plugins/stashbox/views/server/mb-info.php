<?php wp_nonce_field( 'server', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="vendor"><?php _e( 'Vendor', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="vendor" id="vendor" value="<?php echo $vendor; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="hostname"><?php _e( 'Hostname', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="hostname" id="hostname" value="<?php echo $hostname; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ip_pool"><?php _e( 'IP Addresses (One per Line)', 'th' ); ?></label>
         </th>
         <td>
            <textarea name="ip_pool" id="ip_pool" rows="5" class="widefat"><?php echo implode( "\n", $ip_pool ); ?></textarea>
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="root_pass"><?php _e( 'Root Password', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="root_pass" id="root_pass" value="<?php echo $root_pass; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="enable_ping"><?php _e( 'Enable PING Check?', 'th' ); ?></label>
         </th>
         <td>
            <input type="checkbox" name="enable_ping" id="enable_ping" value="1" <?php echo $enable_ping ? 'checked="checked"' : ''; ?>>
         </td>
      </tr>
   </tbody>
</table>