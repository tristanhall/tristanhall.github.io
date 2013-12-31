<?php
/**
 * Adapted from:
 * @package   CleanerGallery
 * @version   1.0.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2013, Justin Tadlock
 * @link      http://justintadlock.com/archives/2008/04/13/cleaner-wordpress-gallery-plugin
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Filter the post gallery shortcode output. */
add_filter( 'post_gallery', 'clearing_gallery', 10, 2 );

/**
 * Overwrites the default WordPress [gallery] shortcode's output.  This function removes the invalid 
 * HTML and inline styles.  It adds the number of columns used as a class attribute, which allows 
 * developers to style the gallery more easily.
 *
 * @since  0.9.0
 * @access public
 * @global array  $_wp_additional_image_sizes
 * @param  string $output The output of the gallery shortcode.
 * @param  array  $attr   The arguments for displaying the gallery.
 * @return string
 */
function clearing_gallery( $output, $attr ) {
	global $_wp_additional_image_sizes;

	/* We're not worried about galleries in feeds, so just return the output here. */
	if ( is_feed() ) {
		return $output;
   }
	/* Orderby. */
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] ) {
			unset( $attr['orderby'] );
      }
	}

	/* Default gallery settings. */
	$defaults = array(
		'order'       => 'ASC',
		'orderby'     => 'menu_order ID',
		'id'          => get_the_ID(),
		'mime_type'   => 'image',
		'link'        => '',
		'itemtag'     => 'li',
		'icontag'     => 'div',
		'captiontag'  => 'figcaption',
		'columns'     => 3,
		'size'        => isset( $_wp_additional_image_sizes['post-thumbnail'] ) ? 'post-thumbnail' : 'thumbnail',
		'ids'         => '',
		'include'     => '',
		'exclude'     => '',
		'numberposts' => -1,
		'offset'      => ''
	);

	/* Merge the defaults with user input.  */
	$attr = shortcode_atts( $defaults, $attr );
	extract( $attr );
	$id = intval( $id );

	/* Arguments for get_children(). */
	$children = array(
		'post_status'      => 'inherit',
		'post_type'        => 'attachment',
		'post_mime_type'   => wp_parse_args( $mime_type ),
		'order'            => $order,
		'orderby'          => $orderby,
		'exclude'          => $exclude,
		'include'          => $include,
		'numberposts'      => $numberposts,
		'offset'           => $offset,
		'suppress_filters' => true
	);

	/* Get image attachments. If none, return. */
	if ( empty( $include ) ) {
		$attachments = get_children( array_merge( array( 'post_parent' => $id ), $children ) );
   } else {
		$attachments = get_posts( $children );
   }
	if ( empty( $attachments ) ) {
		return '';
   }
	/* Properly escape the gallery tags. */
	$itemtag    = tag_escape( $itemtag );
	$icontag    = tag_escape( $icontag );
	$captiontag = tag_escape( $captiontag );
	$i = 0;

	/* Open the gallery <div>. */
	$output = "<ul id='gallery-{$id}' class='clearing-thumbs gallery gallery-{$id}' data-clearing>";

	/* Loop through each attachment. */
	foreach ( $attachments as $attachment ) {

		/* Open each gallery item. */
		$output .= "<{$itemtag} class='gallery-item'>";

		/* Get the image attachment meta. */
		$image_meta  = wp_get_attachment_metadata( $id );

		/* Get the image orientation (portrait|landscape) based off the width and height. */
		$orientation = '';

		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

		/* Open the element to wrap the image. */
		//$output .= "\n\t\t\t\t\t\t<{$icontag} class='gallery-icon {$orientation}'>";
      $size = 'full';
		/* Get the image. */
		if ( isset( $attr['link'] ) && 'file' == $attr['link'] ) {
			$image = wp_get_attachment_link( $attachment->ID, $size, false, true );
      } elseif ( isset( $attr['link'] ) && 'none' == $attr['link'] ) {
			$image = wp_get_attachment_image( $attachment->ID, $size, false );
      } else {
			$image = wp_get_attachment_link( $attachment->ID, $size, true, true );
      }
		/* If image caption is set. */
		if ( !empty( $attachment->post_excerpt ) ) {
			$output .= str_replace('<img', '<img data-caption="'.htmlentities($attachment->post_excerpt).'"', $image);
      } else {
         $output .= $image;
      }

		/* Close individual gallery item. */
		$output .= "</{$itemtag}>";
	}

	/* Close gallery row. */
	if ( $columns > 0 && $i % $columns !== 0 ) {
		$output .= "</div>";
   }
	/* Close the gallery <div>. */
	$output .= "</ul><!-- .gallery -->";

	/* Return out very nice, valid HTML gallery. */
	return $output;
}