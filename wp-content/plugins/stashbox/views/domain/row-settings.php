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
            <label for="domain_reminder_distance"><?php _e( 'Remind me:', 'th' ); ?></label>
         </th>
         <td>
            <input type="number" step="1" min="1" value="<?php echo $reminder_distance; ?>" name="sb_domain_reminder_distance" id="domain_reminder_distance">&nbsp;<?php _e( 'week(s) in advance', 'th' ); ?>
         </td>
      </tr>
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