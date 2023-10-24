<?php

function ccc_register_products_cpt() {
    register_post_type('lighting-products',
        array(
            'labels'      => array(
                'name'          => __('Products', 'textdomain'),
                'singular_name' => __('Product', 'textdomain'),
        ),
            'public'        => true,
            'has_archive'   => true,
            'supports'      => array( 'title', 'comments', 'revisions', 'custom-fields', 'thumbnail', 'editor' ),
            'menu_icon'     => 'dashicons-lightbulb',
            'show_in_menu'	=> true
        )
    );
}
add_action('init', 'ccc_register_products_cpt');