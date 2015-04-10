<?php wp_nonce_field( 'client', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="phone"><?php _e( 'Phone Number', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="website"><?php _e( 'Website', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="website" id="website" value="<?php echo $website; ?>" class="widefat">
         </td>
      </tr>
   </tbody>
</table>