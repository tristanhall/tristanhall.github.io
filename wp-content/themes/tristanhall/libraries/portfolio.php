<?php
/**
 * Defines a portfolio custom post type and sets up a page template and short codes for using portfolio items.
 * 
 */

/**
 * Define the custom post type
 */
function create_post_type() {
	register_post_type( 'th-portfolio',
		array(
			'labels' => array(
				'name' => __( 'Portfolio Items' ),
				'singular_name' => __( 'Portfolio Item' ),
            'add_new' => _x('Add New', 'th_portfolio'),
            'add_new_item' => __('Add New Portfolio Item'),
            'edit_item' => __('Edit Portfolio Item'),
            'new_item' => __('New Portfolio Item'),
            'view_item' => __('View Portfolio Item'),
            'search_items' => __('Search Portfolio Item'),
            'not_found' =>  __('Nothing found'),
            'not_found_in_trash' => __('Nothing found in Trash'),
			),
         'show_ui' => true,
         'capability_type' => 'post',
         'hierarchical' => false,
         'rewrite' => array("slug" => "portfolio"),
         'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'revisions',
            'thumbnail',
         ),
         'menu_icon' => 'dashicons-images-alt',
         'public' => true,
         'has_archive'   => false
      )
	);
   set_post_thumbnail_size( 270, 170, true );
   add_theme_support( 'post-thumbnails' );
   add_post_type_support( 'th-portfolio', 'thumbnail' );
   add_post_type_support( 'th-portfolio', 'excerpt' );
}
add_action( 'init', 'create_post_type' );

//Register Taxonomies for the portfolio
function portfolio_taxonomy() {
	register_taxonomy(
		'portfolio_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
		'th-portfolio',   		 //post type name
		array(
			'hierarchical' 		=> true,
			'label' 			=> 'Categories',  //Display name
			'query_var' 		=> true,
			'rewrite'			=> array(
            'slug' 			=> 'portfolio-category', // This controls the base slug that will display before each term
            'with_front' 	=> false // Don't display the category base before
            )
			)
		);
}
add_action( 'init', 'portfolio_taxonomy');

//Redirect portfolio queries to the right template
function portfolio_redirect( $template ) {
	global $wp;
   if( !array_key_exists( "post_type", $wp->query_vars ) ) {
      return $template;
   }
	if ( $wp->query_vars["post_type"] == "portfolio" ) {
		// Let's look for the single-th-portfolio.php template file in the current theme
		if ( have_posts() ) {
			$template = __DIR__ . '/../single-th-portfolio.php';
		}
	}
   return $template;
}
add_filter( 'template_include', 'portfolio_redirect' );

function filter_list_shortcode() {
   $taxonomy = 'portfolio_categories';
   $tax_terms = get_terms( $taxonomy );
   $html = '<ul id="portfolioFilter">';
   $html .= '<li class="filter active" data-filter="mix">All</li>';
   foreach( $tax_terms as $tax_term ) {
      $html .= '<li class="filter" data-filter="'.$tax_term->name.'">'.$tax_term->name.'</li>';
   }
   $html .= '</ul>';
   return $html;
}

add_shortcode( 'portfolio_filter', 'filter_list_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'wpseo_breadcrumb_links', 'portfolio_yoast_breadcrumbs' );

function portfolio_yoast_breadcrumbs( $links ) {
    global $post;
    if ( $post->post_type == 'th-portfolio' ) {
       $page = get_page_by_path( 'portfolio' );
        $breadcrumb[] = array(
            'url' => get_permalink( $page->ID ),
            'text' => 'Portfolio',
        );

        array_splice( $links, 1, -2, $breadcrumb );
    }

    return $links;
}