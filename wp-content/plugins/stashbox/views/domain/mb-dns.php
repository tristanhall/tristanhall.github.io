<div id="stashbox-domain-dnstabs">
   <ul class="category-tabs">
      <?php if( count( $name_servers ) > 0 ) { ?>
      <li>
         <a href="#stashbox-domain-dns_ns"><?php _e( 'NS Records', 'th' ); ?></a>
      </li>
      <?php } ?>
      <?php if( count( $a_records ) > 0 ) { ?>
      <li>
         <a href="#stashbox-domain-dns_a"><?php _e( 'A Records', 'th' ); ?></a>
      </li>
      <?php } ?>
      <?php if( count( $cname_records ) > 0 ) { ?>
      <li>
         <a href="#stashbox-domain-dns_cname"><?php _e( 'CNAME Records', 'th' ); ?></a>
      </li>
      <?php } ?>
      <?php if( count( $mx_records ) > 0 ) { ?>
      <li>
         <a href="#stashbox-domain-dns_mx"><?php _e( 'MX Records', 'th' ); ?></a>
      </li>
      <?php } ?>
      <?php if( count( $txt_records ) > 0 ) { ?>
      <li>
         <a href="#stashbox-domain-dns_txt"><?php _e( 'TXT Records', 'th' ); ?></a>
      </li>
      <?php } ?>
      <?php if( count( $srv_records ) > 0 ) { ?>
      <li>
         <a href="#stashbox-domain-dns_srv"><?php _e( 'SRV Records', 'th' ); ?></a>
      </li>
      <?php } ?>
   </ul>
   <br class="clear">
   <?php if( count( $name_servers ) > 0 ) { ?>
   <div class="hidden" id="stashbox-domain-dns_ns">
      <table class="form-table">
         <thead>
            <tr>
               <th><?php _e( 'Host', 'th' ); ?></th>
               <th><?php _e( 'Target', 'th' ); ?></th>
               <th><?php _e( 'TTL', 'th' ); ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach( $name_servers as $rec ) { ?>
            <tr>
               <td><?php echo $rec['host']; ?></td>
               <td><?php echo $rec['target']; ?></td>
               <td><?php echo $rec['ttl']; ?></td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
   <?php } ?>
   <?php if( count( $a_records ) > 0 ) { ?>
   <div class="hidden" id="stashbox-domain-dns_a">
      <table class="form-table">
         <thead>
            <tr>
               <th><?php _e( 'Host', 'th' ); ?></th>
               <th><?php _e( 'Target', 'th' ); ?></th>
               <th><?php _e( 'TTL', 'th' ); ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach( $a_records as $rec ) { ?>
            <tr>
               <td><?php echo $rec['host']; ?></td>
               <td><?php echo isset( $rec['ipv6'] ) ? $rec['ipv6'] : $rec['ip']; ?></td>
               <td><?php echo $rec['ttl']; ?></td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
   <?php } ?>
   <?php if( count( $cname_records ) > 0 ) { ?>
   <div class="hidden" id="stashbox-domain-dns_cname">
      <table class="form-table">
         <thead>
            <tr>
               <th><?php _e( 'Host', 'th' ); ?></th>
               <th><?php _e( 'Target', 'th' ); ?></th>
               <th><?php _e( 'TTL', 'th' ); ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach( $cname_records as $rec ) { ?>
            <tr>
               <td><?php echo $rec['host']; ?></td>
               <td><?php echo $rec['target']; ?></td>
               <td><?php echo $rec['ttl']; ?></td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
   <?php } ?>
   <?php if( count( $mx_records ) > 0 ) { ?>
   <div class="hidden" id="stashbox-domain-dns_mx">
      <table class="form-table">
         <thead>
            <tr>
               <th><?php _e( 'Host', 'th' ); ?></th>
               <th><?php _e( 'Target', 'th' ); ?></th>
               <th><?php _e( 'Priority', 'th' ); ?></th>
               <th><?php _e( 'TTL', 'th' ); ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach( $mx_records as $rec ) { ?>
            <tr>
               <td><?php echo $rec['host']; ?></td>
               <td><?php echo $rec['target']; ?></td>
               <td><?php echo $rec['pri']; ?></td>
               <td><?php echo $rec['ttl']; ?></td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
   <?php } ?>
   <?php if( count( $txt_records ) > 0 ) { ?>
   <div class="hidden" id="stashbox-domain-dns_txt">
      <table class="form-table">
         <thead>
            <tr>
               <th><?php _e( 'Host', 'th' ); ?></th>
               <th><?php _e( 'Text', 'th' ); ?></th>
               <th><?php _e( 'TTL', 'th' ); ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach( $txt_records as $rec ) { ?>
            <tr>
               <td><?php echo $rec['host']; ?></td>
               <td><?php echo $rec['txt']; ?></td>
               <td><?php echo $rec['ttl']; ?></td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
   <?php } ?>
   <?php if( count( $srv_records ) > 0 ) { ?>
   <div class="hidden" id="stashbox-domain-dns_srv">
      <table class="form-table">
         <thead>
            <tr>
               <th><?php _e( 'Host', 'th' ); ?></th>
               <th><?php _e( 'Target:Port', 'th' ); ?></th>
               <th><?php _e( 'Weight', 'th' ); ?></th>
               <th><?php _e( 'Priority', 'th' ); ?></th>
               <th><?php _e( 'TTL', 'th' ); ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach( $srv_records as $rec ) { ?>
            <tr>
               <td><?php echo $rec['host']; ?></td>
               <td><?php echo sprintf( '%s:%s', $rec['target'], $rec['port'] ); ?></td>
               <td><?php echo $rec['weight']; ?></td>
               <td><?php echo $rec['pri']; ?></td>
               <td><?php echo $rec['ttl']; ?></td>
            </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
   <?php } ?>
</div>