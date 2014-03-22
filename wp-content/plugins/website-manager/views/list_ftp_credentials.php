<div class="wrap wm-container ftp-credentials">
   <h2>FTP Credentials	<a href="admin.php?page=wm-ftp-credentials&action=edit" class="add-new-h2">Add New</a></h2>
   <div class="tablenav top">
      <div class="alignleft actions bulkactions">
         <select name="action">
            <option value="-1" selected="selected">Bulk Actions</option>
            <option value="delete">Delete</option>
         </select>
         <input type="submit" name="" id="doaction" class="button action" value="Apply">
      </div>
      <div class="tablenav-pages one-page">
         <span class="displaying-num"><?php echo count($ftp_credential_ids); ?> credentials</span>
      </div>
      <br class="clear">
   </div>
   <table class="wp-list-table widefat fixed posts">
      <thead>
         <tr>
            <th>Website</th>
            <th>Host</th>
            <th>Username</th>
            <th>Password</th>
            <th>Type</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($ftp_credential_ids as $id) { 
         $credential = new Ftp_Credential( $id ); ?>
         <tr>
            <td><?php echo $credential->associated_domain_name; ?></td>
            <td><?php echo $credential->host; ?></td>
            <td><?php echo $credential->db_name; ?></td>
            <td><?php echo $credential->username; ?></td>
            <td><?php echo $credential->password; ?></td>
            <td><?php echo !empty( $credential->phpmyadmin_url) ? '<a href="'.$credential->phpmyadmin_url.'" target="_blank" class="wm-pma-link"></a>' : ''; ?></td>
            <td></td>
         </tr>
         <?php } ?>
      </tbody>
      <tfoot>
         <tr>
            <th>Website</th>
            <th>Host</th>
            <th>Username</th>
            <th>Password</th>
            <th>Type</th>
            <th>Actions</th>
         </tr>
      </tfoot>
   </table>
</div>