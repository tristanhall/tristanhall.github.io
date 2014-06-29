<div class="wrap wm-container edit-db">
   <h2><?php echo $db->new === true ? 'Add' : 'Edit'; ?> <?php _e( 'Database Credentials', 'website-manager' ); ?></h2>
   <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
         <div id="post-body-content">
            <form action="#" class="mimic" method="post" id="db-details" class="<?php echo $db->new === true ? 'add' : 'update'; ?>">
               <?php wp_nonce_field( 'db', 'wm_nonce' ); ?>
               <input type="hidden" value='wm_db_credentials' name='action'>
               <input type="hidden" value="<?php echo $db->new === true ? 'yes' : 'no'; ?>" name="new_db">
               <input type='hidden' name='id' value='<?php echo $db->id; ?>'>
               <!--DB Credential Details-->
               <div id="postbox-container-3" class="postbox-container">
                  <div class="meta-box">
                     <div id="db_details_meta" class="postbox ">
                        <h3>
                           <span><?php _e( 'Database Details', 'website-manager' ); ?></span>
                           <a href="#" rel='website-details-fieldset' class="toggleEdit add-new-h2 alignright"><?php echo $db->new === true ? __( 'Done', 'website-manager' ) : __( 'Edit', 'website-manager' ); ?></a>
                        </h3>
                        <div class="inside">
                           <p class="no_auth"><?php _e( 'Could not save credentials.', 'website-manager' ); ?></p>
                           <fieldset id='db-details-fieldset' class="<?php echo $db->new === true ? 'input' : 'display'; ?>">
                              <p class="display">
                                 <strong><?php _e( 'Host:', 'website-manager' ); ?></strong> <span data-role="host"><?php echo $db->host; ?></span>
                              </p>
                              <p class="input">
                                 <label for="host"><?php _e( 'Host: ', 'website-manager' ); ?></label><input type="text" value="<?php echo $db->host; ?>" name="host" id="host">
                              </p>
                              <p class="display">
                                 <strong><?php _e( 'Database Name:', 'website-manager' ); ?></strong> <span data-role="db_name"><?php echo $db->db_name; ?></span>
                              </p>
                              <p class="input">
                                 <label for="db_name"><?php _e( 'Database Name: ', 'website-manager' ); ?></label><input type="text" value="<?php echo $db->db_name; ?>" name="db_name" id="db_name">
                              </p>
                              <p class="display">
                                 <strong><?php _e( 'PhpMyAdmin URL:', 'website-manager' ); ?></strong> <a data-role="phpmyadmin_url" href="<?php echo $db->phpmyadmin_url; ?>" target="_blank"><?php echo $db->phpmyadmin_url; ?></a>
                              </p>
                              <p class="input">
                                 <label for="phpmyadmin_url"><?php _e( 'PhpMyAdmin URL: ', 'website-manager' ); ?></label><input type="text" value="<?php echo $db->phpmyadmin_url; ?>" name="phpmyadmin_url" id="phpmyadmin_url">
                              </p>
                              <p class="display">
                                 <strong><?php _e( 'Username:', 'website-manager' ); ?></strong> <span data-role="username" ><?php echo $db->username; ?></span>
                              </p>
                              <p class="input">
                                 <label for="username"><?php _e( 'Username: ', 'website-manager' ); ?></label><input type="text" value="<?php echo $db->username; ?>" name="username" id="username">
                              </p>
                              <p class="display">
                                 <strong><?php _e( 'Password:', 'website-manager' ); ?></strong> <span data-role="password" ><?php echo $db->password; ?></span>
                              </p>
                              <p class="input">
                                 <label for="password"><?php _e( 'Password: ', 'website-manager' ); ?></label><input type="text" value="<?php echo $db->password; ?>" name="password" id="password">
                              </p>
                           </fieldset>
                        </div>
                     </div>
                  </div>
               </div>
               <!--/DB Credential Details-->
            </form>
         </div>
      </div>
   </div>
</div>