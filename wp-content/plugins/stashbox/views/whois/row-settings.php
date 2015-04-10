<h3><?php _e( 'WHOIS API Settings', 'th' ); ?></h3>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="enable_whois"><?php _e( 'Enable WHOIS Reports for Domains?', 'th' ); ?></label>
         </th>
         <td>
            <input type="checkbox" <?php echo $enable_whois === true ? 'checked="checked"' : ''; ?> value="1" name="sb_enable_whois" id="enable_whois">
         </td>
      </tr>
      <tr>
         <th scope="row">
            <label for="whois_api_key"><?php _e( 'JsonWHOIS.com API Key', 'th' ); ?></label>
         </th>
         <td>
            <input type="text" class="full widefat" value="<?php echo $whois_api_key; ?>" name="sb_whois_api_key" id="whois_api_key">
         </td>
      </tr>
   </tbody>
</table>