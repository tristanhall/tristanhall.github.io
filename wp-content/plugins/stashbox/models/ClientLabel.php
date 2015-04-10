<?php
namespace TH\Stashbox;

class ClientLabel extends \TH\WPAtomic\Taxonomy {
   
   protected static $_taxonomy_type = 'th_client_label';
   
   protected static $_post_types = array( 'th_client' );
   
   protected static $_taxonomy_labels = array(
		'name'                       => 'Client Labels',
		'singular_name'              => 'Client Label',
		'search_items'               => 'Search Labels',
		'popular_items'              => 'Popular Labels',
		'all_items'                  => 'All Client Labels',
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => 'Edit Label',
		'update_item'                => 'Update Label',
		'add_new_item'               => 'Add New Client Label',
		'new_item_name'              => 'New Label Name',
		'separate_items_with_commas' => 'Separate labels with commas',
		'add_or_remove_items'        => 'Add or remove labels',
		'choose_from_most_used'      => 'Choose from the most used labels',
		'not_found'                  => 'No labels found.',
		'menu_name'                  => 'Client Labels',
	);
   
   protected static $_taxonomy_args = array(
		'hierarchical'          => false,
		'labels'                => array(),
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
		   'slug' => 'client-label'
      ),
	);
   
}