<h3><?php _e( 'Domain Record Settings', 'th' ); ?></h3>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="domain_reminders"><?php _e( 'Send expiration reminders for domains?', 'th' ); ?></label>
         </th>
         <td>
            <input type="checkbox" <?php echo $domain_reminders === true ? 'checked="checked"' : ''; ?> value="1" name="sb_domain_reminders" id="domain_reminders">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="domain_reminder_count"><?php _e( '# of Reminders', 'th' ); ?></label>
         </th>
         <td>
            <input type="number" step="1" min="1" value="<?php echo $reminder_count; ?>" name="sb_domain_reminder_count" id="domain_reminder_count">
         </td>
      </tr>
      <?php for( $i = 0; $i < $reminder_count; $i++ ) { ?>
      <tr>
         <th scope="row">
            <label for="domain_reminder_distance_<?php echo $i; ?>"><?php echo sprintf( __( 'Reminder %d', 'th' ), ( $i + 1 ) ); ?></label>
         </th>
         <td>
            <input type="number" step="1" min="1" value="<?php echo isset( $reminder_distance[$i] ) ? $reminder_distance[$i] : 1; ?>" name="sb_domain_reminder_distance[<?php echo $i; ?>]" id="domain_reminder_distance_<?php echo $i; ?>">&nbsp;<?php _e( 'week(s) in advance', 'th' ); ?>
         </td>
      </tr>
      <?php } ?>
      <tr>
         <th scope="row">
            <label for="domain_reminder_recipient"><?php _e( 'Send reminders to:', 'th' ); ?><br><small><?php _e( 'Defaults to admin email.', 'th' ); ?></small></label>
         </th>
         <td>
            <input type="text" value="<?php echo $reminder_recipient; ?>" name="sb_domain_reminder_recipient" id="domain_reminder_recipient">
            &nbsp;<button type="button" class="button-primary" id="test-domain-reminder-email"><?php _e( 'Send Test Email', 'th' ); ?></button>
         </td>
      </tr>
   </tbody>
</table>