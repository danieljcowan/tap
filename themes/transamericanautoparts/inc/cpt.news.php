<?php

function ccc_register_news_cpt() {
    register_post_type('news',
        array(
            'labels'      => array(
                'name'          => __('News', 'textdomain'),
                'singular_name' => __('News Item', 'textdomain'),
        ),
            'public'        => true,
            'has_archive'   => true,
            'supports'      => array( 'title', 'revisions', 'custom-fields', ),
            'menu_icon'     => 'dashicons-text-page'
        )
    );
}
add_action('init', 'ccc_register_news_cpt');
