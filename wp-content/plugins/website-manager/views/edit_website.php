<div class="wrap wm-container edit-website">
   <h2><?php echo $site->new === true ? 'Add' : 'Edit'; ?> Website</h2>
   <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
         <div id="post-body-content">
            <form action="#" class="mimic" method="post" id="website-details" class="<?php echo $site->new === true ? 'add' : 'update'; ?>">
               <?php wp_nonce_field('website', 'wm_nonce'); ?>
               <input type="hidden" value='wm_websites' name='action'>
               <input type="hidden" value="<?php echo $site->new === true ? 'yes' : 'no'; ?>" name="new">
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
                     </h3>
                     <div class="inside">
                        <form action="#" method="post" id="new-db-credentials">
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
                                          <input type='text' id='db_host' name='host' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='db_name' name='db_name' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='db_username' name='username' value=''>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><label for='db_password'>Password</label></td>
                                       <td><label for='phpmyadmin_url'>PhpMyAdmin URL</label></td>
                                       <td></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='text' id='db_password' name='password' value=''>
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
                     </div>
                  </div>
               </div>
            </div>
            <!--/DB Credentials-->
            
            <!--FTP Credentials-->
            <div id="postbox-container-4" class="postbox-container">
               <div class="meta-box">
                  <div id="wm_ftp_credentials_meta" class="postbox ">
                     <h3><span>FTP Credentials</span> <a href='#' class="toggleNewFtp add-new-h2 alignright">Add New</a></h3>
                     <div class="inside">
                        <form action="#" method="post" id="new-ftp-credentials">
                           <input type="hidden" value="<?php echo $site->id; ?>" name="website_id">
                           <fieldset>
                              <table>
                                 <tbody>
                                    <tr>
                                       <td><label for='ftp_host'>Host</label></td>
                                       <td><label for='ftp_username'>Username</label></td>
                                       <td><label for='ftp_password'>Password</label></td>
                                       <td><label for='type'>Type</label></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input type='text' id='ftp_host' name='host' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='ftp_username' name='username' value=''>
                                       </td>
                                       <td>
                                          <input type='text' id='ftp_password' name='password' value=''>
                                       </td>
                                       <td>
                                          <select name='type' id='type'>
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