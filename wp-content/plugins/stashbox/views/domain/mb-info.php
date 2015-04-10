<?php wp_nonce_field( 'domain', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="registrar"><?php _e( 'Registrar', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="registrar" id="registrar" value="<?php echo $registrar; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="expiration"><?php _e( 'Expiration Date', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="expiration" id="expiration" value="<?php echo $expiration; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="username"><?php _e( 'Username', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="username" id="username" value="<?php echo $username; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="password"><?php _e( 'Password', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="password" id="password" value="<?php echo $password; ?>">
         </td>
      </tr>
   </tbody>
</table>