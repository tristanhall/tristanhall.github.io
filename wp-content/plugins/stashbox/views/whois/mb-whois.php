<pre>
   <?php print_r( $whois ); ?>
</pre>
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row"><?php _e( 'Registrar:', 'th' ); ?></th>
         <td><?php echo is_object( $whois['registrar'] ) ? sprintf( '%1$s (<a href="%2$s" target="_blank">%2$s</a>)', $whois['registrar']->name, $whois['registrar']->url ) : ''; ?></td>
      </tr>
      <tr>
         <th scope="row"><?php _e( 'Status:', 'th' ); ?></th>
         <td><?php echo ucwords( $whois['status'] ); ?></td>
      </tr>
      <tr>
         <th scope="row"><?php _e( 'Available?', 'th' ); ?></th>
         <td><?php echo $whois['available?'] ? __( 'Yes', 'th' ) : __( 'No', 'th' ); ?></td>
      </tr>
      <tr>
         <th scope="row"><?php _e( 'Registered?', 'th' ); ?></th>
         <td><?php echo $whois['registered?'] ? __( 'Yes', 'th' ) : __( 'No', 'th' ); ?></td>
      </tr>
   </tbody>
</table>