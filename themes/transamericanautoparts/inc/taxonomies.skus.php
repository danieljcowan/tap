<?php 


function ccc_register_skus_taxonomy__part_qualifiers() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Part Qualifiers', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Part Qualifier', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Part Qualifiers', 'textdomain' ),
        'all_items'         => __( 'All Part Qualifiers', 'textdomain' ),
        'edit_item'         => __( 'Edit Part Qualifier', 'textdomain' ),
        'update_item'       => __( 'Update Part Qualifier', 'textdomain' ),
        'add_new_item'      => __( 'Add New Part Qualifier', 'textdomain' ),
        'new_item_name'     => __( 'New Part Qualifier Name', 'textdomain' ),
        'menu_name'         => __( 'Part Qualifiers', 'textdomain' ),
    );
 
    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_menu'      => true
    );
 
    register_taxonomy( 'part_qualifier', array( 'products' ), $args );
}


add_action( 'init', 'ccc_register_skus_taxonomy__part_qualifiers', 0 );



add_action( 'admin_menu', 'ccc_move_taxonomy_menu__part_qualifiers' );
function ccc_move_taxonomy_menu__part_qualifiers() {
    add_submenu_page( 'edit.php?post_type=product-group', esc_html__( 'Part Qualifiers', 'part_qualifier' ), esc_html__( 'Part Qualifiers', 'part_qualifier' ), 'manage_categories', 'edit-tags.php?taxonomy=part_qualifier' );
}

add_action( 'parent_file', 'ccc_highlight_taxonomy_parent_menu__part_qualifier' );
function ccc_highlight_taxonomy_parent_menu__part_qualifier( $parent_file ) {
    if ( get_current_screen()->taxonomy == 'part_qualifier' ) {
        $parent_file = 'edit.php?post_type=product-group';
    }

    return $parent_file;
}