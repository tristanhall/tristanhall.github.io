<?php wp_nonce_field( 'website', 'stashbox-nonce' ); ?>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="domain"><?php _e( 'Domain', 'th' ); ?></label>
         </th>
         <td>
            <select data-placeholder="Choose a Domain..." name="domain" id="domain">
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
            <label for="vcs_url">
               <a href="<?php echo $vcs_url; ?>" target="_blank"><?php _e( 'Version Control URL', 'th' ); ?>&nbsp;&#10138;</a>
            </label>
         </th>
         <td>
            <input type="text" class="widefat" name="vcs_url" id="vcs_url" value="<?php echo $vcs_url; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="login_url">
               <a href="<?php echo $login_url; ?>" target="_blank"><?php _e( 'Login URL', 'th' ); ?>&nbsp;&#10138;</a>
            </label>
         </th>
         <td>
            <input type="text" class="widefat" name="login_url" id="login_url" value="<?php echo $login_url; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="admin_user"><?php _e( 'Admin Username', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="admin_user" id="admin_user" value="<?php echo $admin_user; ?>">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="admin_pass"><?php _e( 'Admin Password', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="widefat" name="admin_pass" id="admin_pass" value="<?php echo $admin_pass; ?>">
         </td>
      </tr>
   </tbody>
</table>