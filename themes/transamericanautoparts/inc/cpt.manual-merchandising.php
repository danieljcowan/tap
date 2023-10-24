<?php

function ccc_register_manual_merchandising_cpt() {
    register_post_type('manual-merchandising',
        array(
            'labels'      => array(
                'name'          => __('Manual Merchandising', 'textdomain'),
                'singular_name' => __('Manual Merchandising Section', 'textdomain'),
        ),
            'public'        => true,
            'has_archive'   => true,
            'supports'      => array( 'title', 'revisions', 'custom-fields', 'thumbnail'),
        )
    );
}
add_action('init', 'ccc_register_manual_merchandising_cpt');
