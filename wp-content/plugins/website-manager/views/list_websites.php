<div class="wrap wm-container list-websites">
   <h2>Websites	<a href="admin.php?page=wm-websites&action=edit" class="add-new-h2">Add New</a></h2>
   <div class="tablenav top">
      <div class="alignleft actions bulkactions">
         <select name="action">
            <option value="-1" selected="selected">Bulk Actions</option>
            <option value="delete">Delete</option>
         </select>
         <input type="submit" name="" id="doaction" class="button action" value="Apply">
      </div>
      <div class="tablenav-pages one-page">
         <span class="displaying-num"><?php echo count($website_ids); ?> websites</span>
      </div>
      <br class="clear">
   </div>
   <table class="wp-list-table widefat fixed posts">
      <thead>
         <tr>
            <th>Domain Name</th>
            <th>Expiration Date</th>
            <th>Registrar</th>
            <th>Login URL</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($website_ids as $id) { 
         $site = new Website( $id ); ?>
         <tr>
            <td><a href="admin.php?page=wm-websites&action=edit&id=<?php echo $id; ?>"><?php echo $site->domain_name; ?></a></td>
            <td><?php echo $site->expiration_date; ?></td>
            <td><?php echo $site->registrar; ?></td>
            <td><a href="<?php echo $site->login_url; ?>" target="_blank"><?php echo $site->login_url; ?></a></td>
            <td><a class="button" href="admin.php?page=wm-websites&action=edit&id=<?php echo $id; ?>">Edit</a></td>
         </tr>
         <?php } ?>
      </tbody>
      <tfoot>
         <tr>
            <th>Domain Name</th>
            <th>Expiration Date</th>
            <th>Registrar</th>
            <th>Login URL</th>
            <th>Actions</th>
         </tr>
      </tfoot>
   </table>
</div>