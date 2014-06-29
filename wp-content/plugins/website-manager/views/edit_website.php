<div class="wrap wm-container edit-website">
   <h2><?php echo $site->new === true ? 'Add' : 'Edit'; ?> <?php _e( 'Websites', 'website-manager' ); ?></h2>
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
                           <span><?php _e( 'Website Details', 'website-manager' ); ?></span>
                           <a href="#" rel='website-details-fieldset' class="toggleEdit add-new-h2 alignright"><?php echo $site->new === true ? __( 'Done', 'website-manager' ) : __( 'Edit', 'website-manager' ); ?></a>
                        </h3>
                        <div class="inside">
                           <p class="no_auth"><?php _e( 'Could not save website.', 'website-manager' ); ?></p>
                           <fieldset id='website-details-fieldset' class="<?php echo $site->new === true ? 'input' : 'display'; ?>">
                              <p class="display">
                                 <strong><?php _e( 'Registrar:', 'website-manager' ); ?></strong> <span data-role="registrar"><?php echo $site->registrar; ?></span>
                              </p>
                              <p class="input">
                                 <label for="registrar"><?php _e( 'Registrar: ', 'website-manager' ); ?></label>
                                 <input type="text" value="<?php echo $site->registrar; ?>" name="registrar" id="registrar">
                              </p>
                              <p class="display">
                                 <strong><?php _e( 'Expiration Date:', 'website-manager' ); ?></strong> <span data-role="expiration_date"><?php echo $site->expiration_date; ?></span>
                              </p>
                              <p class="input">
                                 <label for="expiration_date"><?php _e( 'Expiration Date: ', 'website-manager' ); ?></label>
                                 <input type="text" value="<?php echo $site->expiration_date; ?>" name="expiration_date" id="expiration_date">
                              </p>
                              <p class="display">
                                 <strong><?php _e( 'Login URL:', 'website-manager' ); ?></strong> <a data-role="login_url" href="<?php echo $site->login_url; ?>" target="_blank"><?php echo $site->login_url; ?></a>
                              </p>
                              <p class="input">
                                 <label for="login_url"><?php _e( 'Login URL: ', 'website-manager' ); ?></label>
                                 <input type="text" value="<?php echo $site->login_url; ?>" name="login_url" id="login_url">
                              </p>
                              <p class="display">
                                 <strong><?php _e( 'Username:', 'website-manager' ); ?></strong> <span data-role="username" ><?php echo $site->username; ?></span>
                              </p>
                              <p class="input">
                                 <label for="username"><?php _e( 'Username: ', 'website-manager' ); ?></label>
                                 <input type="text" value="<?php echo $site->username; ?>" name="username" id="username">
                              </p>
                              <p class="display">
                                 <strong><?php _e( 'Password:', 'website-manager' ); ?></strong> <span data-role="password" ><?php echo $site->password; ?></span>
                              </p>
                              <p class="input">
                                 <label for="password"><?php _e( 'Password: ', 'website-manager' ); ?></label>
                                 <input type="text" value="<?php echo $site->password; ?>" name="password" id="password">
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
                        <span><?php _e( 'Database Credentials', 'website-manager' ); ?></span>
                        <a href='#' class="toggleNewDb add-new-h2 alignright"><?php _e( 'Add New', 'website-manager' ); ?></a>
                        <small class="no_auth"><?php _e( 'Could not save DB credentials', 'website-manager' ); ?></small>
                        <small class="no_delete"><?php _e( 'Could not delete DB credentials.', 'website-manager' ); ?></small>
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
                                       <td>
                                          <label for='db_host'><?php _e( 'Host', 'website-manager' ); ?></label>
                                       </td>
                                       <td>
                                          <label for='db_name'><?php _e( 'Database Name', 'website-manager' ); ?></label>
                                       </td>
                                       <td>
                                          <label for='db_username'><?php _e( 'Username', 'website-manager' ); ?></label>
                                       </td>
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
                                       <td>
                                          <label for='db_password'><?php _e( 'Password', 'website-manager' ); ?></label>
                                       </td>
                                       <td>
                                          <label for='phpmyadmin_url'><?php _e( 'PhpMyAdmin URL', 'website-manager' ); ?></label>
                                       </td>
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
                                 <th><?php _e( 'Host', 'website-manager' ); ?></th>
                                 <th><?php _e( 'Database Name', 'website-manager' ); ?></th>
                                 <th><?php _e( 'Username', 'website-manager' ); ?></th>
                                 <th><?php _e( 'Password', 'website-manager' ); ?></th>
                                 <th><?php _e( 'PhpMyAdmin', 'website-manager' ); ?></th>
                                 <th><?php _e( 'Actions', 'website-manager' ); ?></th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php foreach( $db_credentials as $db_id ) {
                                 $db = new WebsiteManager\Db_Credential( $db_id ); ?>
                              <tr id="db-<?php echo $db->id; ?>">
                                 <td><?php echo $db->host; ?></td>
                                 <td><?php echo $db->db_name; ?></td>
                                 <td><?php echo $db->username; ?></td>
                                 <td><input type="text" readonly="readonly" value="<?php echo $db->password; ?>"></td>
                                 <td>
                                    <a target="_blank" class="button small" href="<?php echo $db->phpmyadmin_url; ?>" title="<?php echo $db->phpmyadmin_url; ?>"><?php _e( 'Open URL &#10138;' , 'website-manager' ); ?></a>
                                 </td>
                                 <td>
                                    <a href="<?php echo admin_url( 'admin.php?page=wm-db-credentials&action=edit&id='.$db->id ); ?>" class="button small"><?php _e( 'Edit' , 'website-manager' ); ?></a>
                                    <form action="#" method="post" data-role="delete-db" data-db_id="<?php echo $db->id; ?>">
                                       <input type="hidden" value="<?php echo $db->id; ?>" name="db_id">
                                       <input type="hidden" name="action" value="wm_db_delete">
                                       <input type="submit" class="button-primary small" value="<?php _e( 'Delete' , 'website-manager' ); ?>">
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
                        <span><?php _e( 'FTP Credentials', 'website-manager' ); ?></span>
                        <a href='#' class="toggleNewFtp add-new-h2 alignright">Add New</a>
                        <small class="no_auth"><?php _e( 'Could not save FTP credentials.', 'website-manager' ); ?></small>
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
                                       <td>
                                          <label for='ftp_host'><?php _e( 'Host', 'website-manager' ); ?></label>
                                       </td>
                                       <td>
                                          <label for='ftp_username'><?php _e( 'Username', 'website-manager' ); ?></label>
                                       </td>
                                       <td>
                                          <label for='ftp_password'><?php _e( 'Password', 'website-manager' ); ?></label>
                                       </td>
                                       <td>
                                          <label for='ftp_type'><?php _e( 'Type', 'website-manager' ); ?></label>
                                       </td>
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
                                             <option value='FTP'><?php _e( 'Plain FTP', 'website-manager' ); ?></option>
                                             <option value='FTP + SSL'><?php _e( 'FTP + SSL', 'website-manager' ); ?></option>
                                             <option value='SFTP'><?php _e( 'SFTP', 'website-manager' ); ?></option>
                                          </select>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='submit' value='<?php _e( 'Save' , 'website-manager' ); ?>' class='button-primary'>
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
                     <h3><span><?php _e( 'Notes', 'website-manager' ); ?></span> <a href='#' class="toggleNewNote add-new-h2 alignright"><?php _e( 'Add New', 'website-manager' ); ?></a></h3>
                     <div class="inside">
                        <form action="#" method="post" id="new-note">
                           <fieldset>
                              <table>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <label for='note_contents'><?php _e( 'Note', 'website-manager' ); ?></label>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <textarea name='note_contents' id='note_contents'></textarea>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='submit' value='<?php _e( 'Save' , 'website-manager' ); ?>' class='button-primary'>
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