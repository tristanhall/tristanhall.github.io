<h3><?php _e( 'SSL Certificate Settings', 'th' ); ?></h3>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="ssl_reminders"><?php _e( 'Send expiration emails for SSL Certificates?', 'th' ); ?></label>
         </th>
         <td>
            <input type="checkbox" <?php echo $ssl_reminders === true ? 'checked="checked"' : ''; ?> value="1" name="sb_ssl_reminders" id="ssl_reminders">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ssl_reminder_distance"><?php _e( 'Remind me:', 'th' ); ?></label>
         </th>
         <td>
            <input type="number" step="1" min="1" value="<?php echo $reminder_distance; ?>" name="sb_ssl_reminder_distance" id="ssl_reminder_distance">&nbsp;<?php _e( 'week(s) in advance', 'th' ); ?>
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="ssl_reminder_recipient"><?php _e( 'Send reminders to:', 'th' ); ?><br><small><?php _e( 'Defaults to admin email.', 'th' ); ?></small></label>
         </th>
         <td>
            <input type="text" value="<?php echo $reminder_recipient; ?>" name="sb_ssl_reminder_recipient" id="ssl_reminder_recipient">
            &nbsp;<button type="button" class="button-primary" id="test-ssl-reminder-email"><?php _e( 'Send Test Email', 'th' ); ?></button>
         </td>
      </tr>
   </tbody>
</table>