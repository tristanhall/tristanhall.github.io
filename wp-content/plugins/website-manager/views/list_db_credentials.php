<div class="wrap wm-container db-credentials">
   <h2><?php _e( 'Database Credentials'."\t", 'website-manager' ); ?>
      <a href="<?php echo admin_url( 'admin.php?page=wm-db-credentials&action=edit' ); ?>" class="add-new-h2">
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
         <span class="displaying-num"><?php echo count( $db_credentials ); ?> <?php _e( 'credentials', 'website-manager' ); ?></span>
      </div>
      <br class="clear">
   </div>
   <table class="wp-list-table widefat fixed posts">
      <thead>
         <tr>
            <th><?php echo __( 'Website', 'website-manager' ); ?></th>
            <th><?php echo __( 'Host', 'website-manager' ); ?></th>
            <th><?php echo __( 'Database Name', 'website-manager' ); ?></th>
            <th><?php echo __( 'Username', 'website-manager' ); ?></th>
            <th><?php echo __( 'Password', 'website-manager' ); ?></th>
            <th><?php echo __( 'PhpMyAdmin', 'website-manager' ); ?></th>
            <th><?php echo __( 'Actions', 'website-manager' ); ?></th>
         </tr>
      </thead>
      <tfoot>
         <tr>
            <th><?php echo __( 'Website', 'website-manager' ); ?></th>
            <th><?php echo __( 'Host', 'website-manager' ); ?></th>
            <th><?php echo __( 'Database Name', 'website-manager' ); ?></th>
            <th><?php echo __( 'Username', 'website-manager' ); ?></th>
            <th><?php echo __( 'Password', 'website-manager' ); ?></th>
            <th><?php echo __( 'PhpMyAdmin', 'website-manager' ); ?></th>
            <th><?php echo __( 'Actions', 'website-manager' ); ?></th>
         </tr>
      </tfoot>
      <tbody>
         <?php foreach( $db_credentials as $obj ) { 
         $credential = new WebsiteManager\Db_Credential( $obj->id ); ?>
         <tr>
            <td><?php echo $credential->associated_domain_name; ?></td>
            <td><?php echo $credential->host; ?></td>
            <td><?php echo $credential->db_name; ?></td>
            <td><?php echo $credential->username; ?></td>
            <td><?php echo $credential->password; ?></td>
            <td><?php echo !empty( $credential->phpmyadmin_url ) ? '<a href="'.$credential->phpmyadmin_url.'" target="_blank" class="wm-pma-link"></a>' : ''; ?></td>
            <td>
               <a class="button" href="<?php echo admin_url( 'admin.php?page=wm-db-credentials&action=edit&id='.$credential->id ); ?>"><?php echo __( 'View', 'website-manager' ); ?></a>
            </td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
</div>