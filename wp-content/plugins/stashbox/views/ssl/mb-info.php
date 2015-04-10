<?php wp_nonce_field( 'ssl', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="domain"><?php _e( 'Domain', 'th' ); ?></label>
         </th>
         <td>
            <select name="domain" id="domain">
               <option value=""><?php _e( 'Choose a Domain', 'th' ); ?></option>
               <?php foreach( $domains as $dom ) { ?>
               <option value="<?php echo $dom->get_ID(); ?>" <?php echo $domain == $dom->get_ID() ? 'selected="selected"' : ''; ?>><?php echo $dom->get_title(); ?></option>
               <?php } ?>
            </select>
            &nbsp;<a href="<?php echo admin_url( 'post-new.php?post_type=th_domain' ); ?>" title="<?php _e( 'Create a Domain', 'th' ); ?>"><?php _e( 'Create a Domain', 'th' ); ?></a>
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
            <label for="csr"><?php _e( 'Certificate Signing Request', 'th' ); ?></label>
         </th>
         <td>
            <textarea rows="5" cols="30" class="widefat" name="csr" id="csr"><?php esc_attr_e( $csr ); ?></textarea>
         </td>
      </tr>
   </tbody>
</table>