<h3><?php _e( 'Server Settings', 'th' ); ?></h3>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row">
            <label for="sb_ping_method"><?php _e( 'PING Method', 'th' ); ?></label>
         </th>
         <td>
            <select name="sb_ping_method" id="sb_ping_method">
               <option value="exec"><?php _e( 'exec (Default)', 'th' ); ?></option>
               <option value="fsockopen" <?php echo $ping_method === 'fsockopen' ? 'selected="selected"' : ''; ?>><?php _e( 'fsockopen', 'th' ); ?></option>
               <option value="socket" <?php echo $ping_method === 'socket' ? 'selected="selected"' : ''; ?>><?php _e( 'socket', 'th' ); ?></option>
            </select>
         </td>
      </tr>
   </tbody>
</table>