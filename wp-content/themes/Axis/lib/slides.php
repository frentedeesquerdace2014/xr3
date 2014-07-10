<?php 	
	add_action('init', 'project_slides_init');  

	/*-- Custom Post Init Begin --*/
	function project_slides_init()
	{
	  $labels = array(
		'name' => _x('Slide', 'post type general name'),
		'singular_name' => _x('Slide', 'post type singular name'),
		'add_new' => _x('Add New', 'slide'),
		'add_new_item' => __('Add New Slide'),
		'edit_item' => __('Edit Slide'),
		'new_item' => __('New Slide'),
		'view_item' => __('View Slide'),
		'search_items' => __('Search Slide'),
		'not_found' =>  __('No slides found'),
		'not_found_in_trash' => __('No slides found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Slides'

	  );

	 $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','custom-fields')
	  );
	  // The following is the main step where we register the post.
	  register_post_type('slides',$args);

	  
	  
	  
	  // Initialize New Taxonomy Labels
	  $labels = array(
		'name' => _x( 'Category', 'taxonomy general name' ),
		'singular_name' => _x( 'Category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Category' ),
		'all_items' => __( 'All Category' ),
		'parent_item' => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item' => __( 'Edit Category' ),
		'update_item' => __( 'Update Category' ),
		'add_new_item' => __( 'Add New Category' ),
		'new_item_name' => __( 'New Category Name' ),
	  );
	  
	// Custom taxonomy for Project Tags
	register_taxonomy('genre',array('slides'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'genre' ),
	  ));

	}
	/*-- Custom Post Init Ends --*/
?>