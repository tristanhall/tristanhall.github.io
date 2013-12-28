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
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'taxonomies' => array('category'),
            'rewrite' => array("slug" => "portfolio"),
            'supports' => array(
               'title',
               'editor',
               'excerpt',
               'custom-fields',
               'revisions',
               'thumbnail',
            )
			),
		'public' => true,
      'has_archive'   => true
		)
	);
   set_post_thumbnail_size( 270, 170, true );
   add_theme_support( 'post-thumbnails' );
   add_post_type_support( 'th-portfolio', 'thumbnail' );
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

/**
 * Maintain the permalink structure for custom taxonomy
 * Display custom taxonomy term name before post related to that term
 * @uses post_type_filter hook
 */
function filter_post_type_link( $link, $post) {
    if ( $post->post_type != 'themes' )
        return $link;

    if ( $cats = get_the_terms( $post->ID, 'portfolio-categories' ) )
        $link = str_replace( '%portfolio-categories%', array_pop($cats)->slug, $link );
    return $link;
}
add_filter('post_type_link', 'filter_post_type_link', 10, 2);

//Redirect portfolio queries to the right template
function portfolio_redirect() {
	global $wp;
	global $wp_query;
   if(!array_key_exists("post_type", $wp->query_vars)) {
      return;
   }
	if ($wp->query_vars["post_type"] == "portfolio")
	{
		// Let's look for the property.php template file in the current theme
		if (have_posts())
		{
			include(TEMPLATEPATH . '/single-portfolio.php');
			die();
		}
		else
		{
			$wp_query->is_404 = true;
		}
	}
}
add_action("template_redirect", 'portfolio_redirect');