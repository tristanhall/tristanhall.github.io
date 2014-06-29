<div class="wrap wm-container list-websites">
   <h2><?php _e( "Websites\t", 'website-manager' ); ?>
      <a href="<?php echo admin_url( 'admin.php?page=wm-websites&action=edit' ); ?>" class="add-new-h2">
         <?php _e( 'Add New', 'website-manager' ); ?>
      </a>
   </h2>
   <div class="tablenav top">
      <div class="alignleft actions bulkactions">
         <select name="action">
            <option value="-1" selected="selected"><?php _e( 'Bulk Actions', 'website-manager' ); ?></option>
            <option value="delete"><?php _e( 'Delete', 'website-manager' ); ?></option>
         </select>
         <input type="submit" name="" id="doaction" class="button action" value="Apply">
      </div>
      <div class="tablenav-pages one-page">
         <span class="displaying-num"><?php echo count( $website_ids ); ?> <?php _e( 'websites', 'website-manager' ); ?></span>
      </div>
      <br class="clear">
   </div>
   <table class="wp-list-table widefat fixed posts">
      <thead>
         <tr>
            <th><?php _e( 'Domain Name', 'website-manager' ); ?></th>
            <th><?php _e( 'Expiration Date', 'website-manager' ); ?></th>
            <th><?php _e( 'Registrar', 'website-manager' ); ?></th>
            <th><?php _e( 'Login URL', 'website-manager' ); ?></th>
            <th><?php _e( 'Actions', 'website-manager' ); ?></th>
         </tr>
      </thead>
      <tfoot>
         <tr>
            <th><?php _e( 'Domain Name', 'website-manager' ); ?></th>
            <th><?php _e( 'Expiration Date', 'website-manager' ); ?></th>
            <th><?php _e( 'Registrar', 'website-manager' ); ?></th>
            <th><?php _e( 'Login URL', 'website-manager' ); ?></th>
            <th><?php _e( 'Actions', 'website-manager' ); ?></th>
         </tr>
      </tfoot>
      <tbody>
         <?php foreach( $website_ids as $id ) { 
         $site = new WebsiteManager\Website( $id ); ?>
         <tr>
            <td>
               <a href="<?php echo admin_url( 'admin.php?page=wm-websites&action=edit&id='.$id ); ?>">
                  <?php echo $site->domain_name; ?>
               </a>
            </td>
            <td><?php echo $site->expiration_date; ?></td>
            <td><?php echo $site->registrar; ?></td>
            <td>
               <a href="<?php echo $site->login_url; ?>" target="_blank"><?php echo $site->login_url; ?></a>
            </td>
            <td>
               <a class="button" href="<?php echo admin_url( 'admin.php?page=wm-websites&action=edit&id='.$id ); ?>">
                  <?php _e( 'Edit', 'website-manager' ); ?>
               </a>
            </td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
</div>