<?php 


function ccc_register_taxonomies_vehicles() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Vehicle Categories', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Vehicle Category', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Vehicle Categories', 'textdomain' ),
        'all_items'         => __( 'All Vehicle Categories', 'textdomain' ),
        'parent_item'       => __( 'Parent Vehicle Category', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Vehicle Category:', 'textdomain' ),
        'edit_item'         => __( 'Edit Vehicle Category', 'textdomain' ),
        'update_item'       => __( 'Update Vehicle Category', 'textdomain' ),
        'add_new_item'      => __( 'Add New Vehicle Category', 'textdomain' ),
        'new_item_name'     => __( 'New Vehicle Category Name', 'textdomain' ),
        'menu_name'         => __( 'Vehicle Categories', 'textdomain' ),
    );
 
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'vehicle_category' ),
    );
 
    register_taxonomy( 'vehicle_category', array( 'vehicle' ), $args );
}


add_action( 'init', 'ccc_register_taxonomies_vehicles', 0 );