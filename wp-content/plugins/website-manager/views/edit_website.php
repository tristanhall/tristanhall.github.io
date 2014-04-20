<div class="wrap wm-container edit-website">
   <h2><?php echo $site->new === true ? 'Add' : 'Edit'; ?> Website</h2>
   <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
         <div id="post-body-content">
            <form action="#" class="mimic" method="post" id="website-details" class="<?php echo $site->new === true ? 'add' : 'update'; ?>">
               <?php wp_nonce_field('website', 'wm_nonce'); ?>
               <input type="hidden" value='wm_websites' name='action'>
               <input type="hidden" value="<?php echo $site->new === true ? 'yes' : 'no'; ?>" name="new_website">
               <div id="titlediv">
                  <div id="titlewrap">
                     <input type="text" name="domain_name" size="30" value="<?php echo $site->domain_name; ?>" id="title" autocomplete="off" placeholder="Enter domain name here">
                  </div>
               </div><!-- /titlediv -->
               <input type='hidden' name='id' value='<?php echo $site->id; ?>'>
               <!--Website Details-->
               <div id="postbox-container-3" class="postbox-container">
                  <div class="meta-box">
                     <div id="website_details_meta" class="postbox ">
                        <h3>
                           <span>Website Details</span>
                           <a href="#" rel='website-details-fieldset' class="toggleEdit add-new-h2 alignright"><?php echo $site->new === true ? 'Done' : 'Edit'; ?></a>
                        </h3>
                        <div class="inside">
                           <p class="no_auth">Could not save website.</p>
                           <fieldset id='website-details-fieldset' class="<?php echo $site->new === true ? 'input' : 'display'; ?>">
                              <p class="display">
                                 <strong>Registrar:</strong> <span data-role="registrar"><?php echo $site->registrar; ?></span>
                              </p>
                              <p class="input">
                                 <label for="registrar">Registrar: </label><input type="text" value="<?php echo $site->registrar; ?>" name="registrar" id="registrar">
                              </p>
                              <p class="display">
                                 <strong>Expiration Date:</strong> <span data-role="expiration_date"><?php echo $site->expiration_date; ?></span>
                              </p>
                              <p class="input">
                                 <label for="expiration_date">Expiration Date: </label><input type="text" value="<?php echo $site->expiration_date; ?>" name="expiration_date" id="expiration_date">
                              </p>
                              <p class="display">
                                 <strong>Login URL:</strong> <a data-role="login_url" href="<?php echo $site->login_url; ?>" target="_blank"><?php echo $site->login_url; ?></a>
                              </p>
                              <p class="input">
                                 <label for="login_url">Login URL: </label><input type="text" value="<?php echo $site->login_url; ?>" name="login_url" id="login_url">
                              </p>
                              <p class="display">
                                 <strong>Username:</strong> <span data-role="username" ><?php echo $site->username; ?></span>
                              </p>
                              <p class="input">
                                 <label for="username">Username: </label><input type="text" value="<?php echo $site->username; ?>" name="username" id="username">
                              </p>
                              <p class="display">
                                 <strong>Password:</strong> <span data-role="password" ><?php echo $site->password; ?></span>
                              </p>
                              <p class="input">
                                 <label for="password">Password: </label><input type="text" value="<?php echo $site->password; ?>" name="password" id="password">
                              </p>
                           </fieldset>
                        </div>
                     </div>
                  </div>
               </div>
               <!--/Website Details-->
            </form>
            
            <!--DB Credentials-->
            <div id="postbox-container-2" class="postbox-container">
               <div class="meta-box">
                  <div id="wm_db_credentials_meta" class="postbox ">
                     <h3>
                        <span>Database Credentials</span>
                        <a href='#' class="toggleNewDb add-new-h2 alignright">Add New</a>
                        <small class="no_auth">Could not save DB credentials.</small>
                        <small class="no_delete">Could not delete DB credentials.</small>
                     </h3>
                     <div class="inside">
                        <form action="#" method="post" id="new-db-credentials">
                           <?php wp_nonce_field('db', 'wm_nonce'); ?>
                           <input type="hidden" value='wm_db' name='action'>
                           <input type="hidden" value="<?php echo $site->id; ?>" name="website_id">
                           <fieldset>
                              <table>
                                 <tbody>
                                    <tr>
                                       <td><label for='db_host'>Host</label></td>
                                       <td><label for='db_name'>Database</label></td>
                                       <td><label for='db_username'>Username</label></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='text' id='db_host' name='db_host' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='db_name' name='db_name' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='db_username' name='db_username' value=''>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><label for='db_password'>Password</label></td>
                                       <td><label for='phpmyadmin_url'>PhpMyAdmin URL</label></td>
                                       <td></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='text' id='db_password' name='db_password' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='phpmyadmin_url' name='phpmyadmin_url' value=''>
                                       </td>
                                       <td>
                                          <input type='submit' value='Save' class='button-primary'>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </fieldset>
                           <hr>
                        </form>
                        <table id="related_db_credentials">
                           <thead>
                              <tr>
                                 <th>Host</th>
                                 <th>Database</th>
                                 <th>Username</th>
                                 <th>Password</th>
                                 <th>PhpMyAdmin</th>
                                 <th>Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php foreach($db_credentials as $db_id) { $db = new Db_Credential( $db_id ); ?>
                              <tr id="db-<?php echo $db->id; ?>">
                                 <td><?php echo $db->host; ?></td>
                                 <td><?php echo $db->db_name; ?></td>
                                 <td><?php echo $db->username; ?></td>
                                 <td><input type="text" readonly="readonly" value="<?php echo $db->password; ?>"></td>
                                 <td>
                                    <a target="_blank" class="button small" href="<?php echo $db->phpmyadmin_url; ?>" title="<?php echo $db->phpmyadmin_url; ?>">Open URL &#10138;</a>
                                 </td>
                                 <td>
                                    <a href="?page=wm-db-credentials&action=edit&id=<?php echo $db->id; ?>" class="button small">Edit</a>
                                    <form action="#" method="post" data-role="delete-db" data-db_id="<?php echo $db->id; ?>">
                                       <input type="hidden" value="<?php echo $db->id; ?>" name="db_id">
                                       <input type="hidden" name="action" value="wm_db_delete">
                                       <input type="submit" class="button-primary small"  value="Delete">
                                    </form>
                                 </td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <!--/DB Credentials-->
            
            <!--FTP Credentials-->
            <div id="postbox-container-4" class="postbox-container">
               <div class="meta-box">
                  <div id="wm_ftp_credentials_meta" class="postbox ">
                     <h3>
                        <span>FTP Credentials</span>
                        <a href='#' class="toggleNewFtp add-new-h2 alignright">Add New</a>
                        <small class="no_auth">Could not save FTP credentials.</small>
                     </h3>
                     <div class="inside">
                        <form action="#" method="post" id="new-ftp-credentials">
                           <?php wp_nonce_field('ftp', 'wm_nonce'); ?>
                           <input type="hidden" value='wm_ftp' name='action'>
                           <input type="hidden" value="<?php echo $site->id; ?>" name="website_id">
                           <fieldset>
                              <table>
                                 <tbody>
                                    <tr>
                                       <td><label for='ftp_host'>Host</label></td>
                                       <td><label for='ftp_username'>Username</label></td>
                                       <td><label for='ftp_password'>Password</label></td>
                                       <td><label for='ftp_type'>Type</label></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='text' id='ftp_host' name='ftp_host' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='ftp_username' name='ftp_username' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='ftp_password' name='ftp_password' value=''>
                                       </td>
                                       <td>
                                          <select name='ftp_type' id='ftp_type'>
                                             <option value='FTP'>Plain FTP</option>
                                             <option value='FTP + SSL'>FTP + SSL</option>
                                             <option value='SFTP'>SFTP</option>
                                          </select>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='submit' value='Save' class='button-primary'>
                                       </td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </fieldset>
                           <hr>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <!--/FTP Credentials-->
            
            <!--Notes-->
            <div id="postbox-container-5" class="postbox-container">
               <div class="meta-box">
                  <div id="wm_notes_meta" class="postbox ">
                     <h3><span>Notes</span> <a href='#' class="toggleNewNote add-new-h2 alignright">Add New</a></h3>
                     <div class="inside">
                        <form action="#" method="post" id="new-note">
                           <fieldset>
                              <table>
                                 <tbody>
                                    <tr>
                                       <td><label for='note_contents'>Note</label></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <textarea name='note_contents' id='note_contents'></textarea>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='submit' value='Save' class='button-primary'>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </fieldset>
                           <hr>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <!--/Notes-->
            
         </div>
      </div><!-- /post-body-content -->
   </div><!-- /post-body -->
   <br class="clear">
</div><!-- /poststuff -->
</div>