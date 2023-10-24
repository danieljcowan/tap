<?php 


function ccc_register_news_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'News Categories', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'News Category', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search News Categories', 'textdomain' ),
        'all_items'         => __( 'All News Categories', 'textdomain' ),
        'parent_item'       => __( 'Parent News Category', 'textdomain' ),
        'parent_item_colon' => __( 'Parent News Category:', 'textdomain' ),
        'edit_item'         => __( 'Edit News Category', 'textdomain' ),
        'update_item'       => __( 'Update News Category', 'textdomain' ),
        'add_new_item'      => __( 'Add New News Category', 'textdomain' ),
        'new_item_name'     => __( 'New News Category Name', 'textdomain' ),
        'menu_name'         => __( 'News Categories', 'textdomain' ),
    );
 
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
    );
 
    register_taxonomy( 'news_category', array( 'news' ), $args );
}


add_action( 'init', 'ccc_register_news_taxonomies', 0 );