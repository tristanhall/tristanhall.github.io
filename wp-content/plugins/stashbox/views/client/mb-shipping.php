<?php wp_nonce_field( 'client', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="ship_address1"><?php _e( 'Shipping Address 1', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="ship_address1" id="ship_address1" value="<?php echo $address1; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ship_address2"><?php _e( 'Shipping Address 2', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="ship_address2" id="ship_address2" value="<?php echo $address2; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ship_city"><?php _e( 'Shipping City', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="ship_city" id="ship_city" value="<?php echo $city; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ship_state"><?php _e( 'Shipping State', 'th' ); ?></label>
         </th>
         <td>
            <?php echo stashbox_state_dropdown( 'ship_state', 'ship_state', $state ); ?>
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ship_zip"><?php _e( 'Shipping ZIP Code', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="ship_zip" id="ship_zip" value="<?php echo $zip; ?>">
         </td>
      </tr>
   </tbody>
</table>