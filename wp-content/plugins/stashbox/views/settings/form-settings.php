<div class="wrap">
   <h2><?php _e( 'Stashbox Settings', 'th' ); ?></h2>
   <?php if( $settings_updated ) { ?>
   <div id="message" class="updated below-h2">
      <p><?php _e( 'Settings updated.', 'th' ); ?></p>
   </div>
   <?php } ?>
   <form method="post" action="options.php">
      <?php settings_fields( 'stashbox' ); ?>
      <?php do_settings_sections( 'stashbox' ); ?>
      <?php echo $settings_fields; ?>
      <?php submit_button( __( 'Save Settings', 'th' ) ); ?>
   </form>
</div>