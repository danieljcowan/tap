<?php

function ccc_register_locations_cpt() {
    register_post_type('location',
        array(
            'labels'      => array(
                'name'          => __('Locations', 'textdomain'),
                'singular_name' => __('Location', 'textdomain'),
        ),
            'public'        => true,
            'has_archive'   => true,
            'supports'      => array( 'title', 'revisions', 'custom-fields', ),
            'menu_icon'     => 'dashicons-building'
        )
    );
}
add_action('init', 'ccc_register_locations_cpt');
