<div class="wrap wm-container log">
   <h2><?php _e( 'Access Log', 'website-manager' ); ?></h2>
   <form action="<?php echo admin_url( 'admin.php?page=wm-log' ); ?>" method="post" class="wm_form">
      <table>
         <tbody>
            <tr>
               <td>
                  <label for="year" style=""><?php _e( 'Year: ', 'website-manager' ); ?></label>
                  <select name="year" id="year">
                     <?php for( $i = 2013; $i <= (int) date( 'Y' ) + 1; $i++ ) { ?>
                     <option <?php echo $i == $year ? 'selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                     <?php } ?>
                  </select>
               </td>
               <td>
                  <label for="month"><?php _e( 'Month: ', 'website-manager' ); ?></label>
                  <select name="month" id="month">
                     <option <?php echo '01' == $month ? 'selected="selected"' : ''; ?> value="01">
                        <?php _e( 'January ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '02' == $month ? 'selected="selected"' : ''; ?> value="02">
                        <?php _e( 'February ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '03' == $month ? 'selected="selected"' : ''; ?> value="03">
                        <?php _e( 'March ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '04' == $month ? 'selected="selected"' : ''; ?> value="04">
                        <?php _e( 'April ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '05' == $month ? 'selected="selected"' : ''; ?> value="05">
                        <?php _e( 'May ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '06' == $month ? 'selected="selected"' : ''; ?> value="06">
                        <?php _e( 'June ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '07' == $month ? 'selected="selected"' : ''; ?> value="07">
                        <?php _e( 'July ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '08' == $month ? 'selected="selected"' : ''; ?> value="08">
                        <?php _e( 'August ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '09' == $month ? 'selected="selected"' : ''; ?> value="09">
                        <?php _e( 'September ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '10' == $month ? 'selected="selected"' : ''; ?> value="10">
                        <?php _e( 'October ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '11' == $month ? 'selected="selected"' : ''; ?> value="11">
                        <?php _e( 'November ', 'website-manager' ); ?>
                     </option>
                     <option <?php echo '12' == $month ? 'selected="selected"' : ''; ?> value="12">
                        <?php _e( 'December ', 'website-manager' ); ?>
                     </option>
                  </select>
               </td>
               <td>
                  <label for="date"><?php _e( 'Date: ', 'website-manager' ); ?></label>
                  <select name="date" id="date">
                     <?php for( $i = 1; $i <= 31; $i++ ) { ?>
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
            <th style='width: 60px;'><?php _e( 'Level', 'website-manager' ); ?></th>
            <th style='width: 150px;'><?php _e( 'User', 'website-manager' ); ?></th>
            <th><?php _e( 'Message', 'website-manager' ); ?></th>
            <th style='width: 170px;'><?php _e( 'Date/Time', 'website-manager' ); ?></th>
         </tr>
      </thead>
      <tfoot>
         <tr>
            <th style='width: 60px;'><?php _e( 'Level', 'website-manager' ); ?></th>
            <th style='width: 150px;'><?php _e( 'User', 'website-manager' ); ?></th>
            <th><?php _e( 'Message', 'website-manager' ); ?></th>
            <th style='width: 170px;'><?php _e( 'Date/Time', 'website-manager' ); ?></th>
         </tr>
      </tfoot>
      <tbody>
         <?php foreach( $log_contents as $log_entry ) { 
         $entry = explode( ' - ', $log_entry ); ?>
         <tr class="log-<?php echo strtolower( $entry[0] ); ?>">
            <td><?php echo ucfirst( strtolower( $entry[0] ) ); ?></td>
            <td><?php echo $entry[2]; ?></td>
            <td><?php echo $entry[3]; ?></td>
            <td><?php echo $entry[1]; ?></td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
</div>