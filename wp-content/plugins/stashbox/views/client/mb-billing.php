<?php wp_nonce_field( 'client', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="bill_address1"><?php _e( 'Billing Address 1', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="bill_address1" id="bill_address1" value="<?php echo $address1; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="bill_address2"><?php _e( 'Billing Address 2', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="bill_address2" id="bill_address2" value="<?php echo $address2; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="bill_city"><?php _e( 'Billing City', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="bill_city" id="bill_city" value="<?php echo $city; ?>" class="widefat">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="bill_state"><?php _e( 'Billing State', 'th' ); ?></label>
         </th>
         <td>
            <?php echo stashbox_state_dropdown( 'bill_state', 'bill_state', $state ); ?>
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="bill_zip"><?php _e( 'Billing ZIP Code', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" name="bill_zip" id="bill_zip" value="<?php echo $zip; ?>">
         </td>
      </tr>
   </tbody>
</table>