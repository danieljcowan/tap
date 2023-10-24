<?php

function ccc_register_vehicle_cpt() {
    register_post_type('vehicle',
        array(
            'labels'      => array(
                'name'          => __('Vehicles', 'textdomain'),
                'singular_name' => __('Vehicle', 'textdomain'),
        ),
            'public'        => true,
            'has_archive'   => true,
            'supports'      => array( 'title', 'revisions', 'custom-fields', ),
            'menu_icon'     => 'dashicons-car'
        )
    );
}
add_action('init', 'ccc_register_vehicle_cpt');
