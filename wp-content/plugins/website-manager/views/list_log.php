<div class="wrap wm-container log">
   <h2>Security Log</h2>
   <form action="admin.php?page=wm-log" method="post" class="wm_form">
      <table>
         <tbody>
            <tr>
               <td>
                  <label for="year" style="">Year:&nbsp;</label>
                  <select name="year" id="year">
                     <?php foreach($directories as $dir_name) { 
                     $formatted_dir = str_replace($dir, '', $dir_name); ?>
                     <option <?php echo $formatted_dir == $year ? 'selected="selected"' : ''; ?> value="<?php echo $formatted_dir; ?>"><?php echo $formatted_dir; ?></option>
                     <?php } ?>
                  </select>
               </td>
               <td>
                  <label for="month">Month:&nbsp;</label>
                  <select name="month" id="month">
                     <option <?php echo '01' == $month ? 'selected="selected"' : ''; ?> value="01">January</option>
                     <option <?php echo '02' == $month ? 'selected="selected"' : ''; ?> value="02">February</option>
                     <option <?php echo '03' == $month ? 'selected="selected"' : ''; ?> value="03">March</option>
                     <option <?php echo '04' == $month ? 'selected="selected"' : ''; ?> value="04">April</option>
                     <option <?php echo '05' == $month ? 'selected="selected"' : ''; ?> value="05">May</option>
                     <option <?php echo '06' == $month ? 'selected="selected"' : ''; ?> value="06">June</option>
                     <option <?php echo '07' == $month ? 'selected="selected"' : ''; ?> value="07">July</option>
                     <option <?php echo '08' == $month ? 'selected="selected"' : ''; ?> value="08">August</option>
                     <option <?php echo '09' == $month ? 'selected="selected"' : ''; ?> value="09">September</option>
                     <option <?php echo '10' == $month ? 'selected="selected"' : ''; ?> value="10">October</option>
                     <option <?php echo '11' == $month ? 'selected="selected"' : ''; ?> value="11">November</option>
                     <option <?php echo '12' == $month ? 'selected="selected"' : ''; ?> value="12">December</option>
                  </select>
               </td>
               <td>
                  <label for="date">Date:&nbsp;</label>
                  <select name="date" id="date">
                     <?php for($i = 1; $i <= 31; $i++) { ?>
                     <option <?php echo $i == $date ? 'selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                     <?php } ?>
                  </select>
               </td>
               <td>
                  <input type="submit" value="Filter Logs" class="button-primary">
               </td>
            </tr>
         </tbody>
      </table>
   </form>
   <table class="wp-list-table widefat fixed posts">
      <thead>
         <tr>
            <th style='width: 60px;'>Level</th>
            <th style='width: 150px;'>User</th>
            <th>Message</th>
            <th style='width: 170px;'>Date/Time</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($log_contents as $log_entry) { 
         $entry = explode( ' - ', $log_entry ); ?>
         <tr class="log-<?php echo strtolower( $entry[0] ); ?>">
            <td><?php echo ucfirst( strtolower( $entry[0] ) ); ?></td>
            <td><?php echo $entry[2]; ?></td>
            <td><?php echo $entry[3]; ?></td>
            <td><?php echo $entry[1]; ?></td>
         </tr>
         <?php } ?>
      </tbody>
      <tfoot>
         <tr>
            <th>Level</th>
            <th>User</th>
            <th>Message</th>
            <th>Date/Time</th>
         </tr>
      </tfoot>
   </table>
</div>