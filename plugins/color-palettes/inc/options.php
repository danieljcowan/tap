<?php

// Add the options page
if( function_exists('acf_add_options_page') ) {

    $page = acf_add_options_sub_page(array(
        'page_title' 	=> __('Color Palettes', 'cp-color-palettes'),
        'menu_title' 	=> __('Color Palettes', 'cp-color-palettes'),
        'menu_slug' 	=> 'cp-color-palettes',
        'capability' 	=> 'edit_posts',
        'redirect' 	    => false,
        'parent_slug'   => 'options-general.php'
    ));

}


// Add the field group to the Options Page
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5f972700ba8b8',
        'title' => 'Color Palettes',
        'fields' => array(
            array(
                'key' => 'field_5f972c475d2e1',
                'label' => 'Palette Name',
                'name' => 'palette_name',
                'type' => 'text',
                'instructions' => 'All lowercase, no spaces',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'short-name-here',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5f972bcc5d2dc',
                'label' => 'Palettes',
                'name' => 'palettes',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'cp-color-palettes',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;