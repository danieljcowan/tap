<?php

    add_action( 'wp_enqueue_scripts', 'ccc_enqueue' );
    function ccc_enqueue() {
	    wp_enqueue_style( prefix().'-web', get_template_directory_uri().'/css/web.css', false, filemtime( get_template_directory() . '/css/web.css' ) );
	    //wp_enqueue_script( 'ccc-common', get_template_directory_uri().'/src/js/common.js', array('jquery'),false,false );

        //Add Theme Fonts
        wp_enqueue_style( prefix().'-google-fonts', "https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap", false);

        // FontAwesome
	    wp_enqueue_script( prefix().'-fontawesome', 'https://kit.fontawesome.com/a01141edf2.js', array() );
	    
        // Main JS
        wp_enqueue_script( prefix().'-main', get_template_directory_uri().'/js/main.js', array('jquery'), filemtime(get_theme_file_path().'/js/main.js'), true  );

        // jQuery Modal Plugin
        wp_enqueue_script( 'ccc-jquery-modal', "https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.js", array('jquery'), false );
        wp_enqueue_style( 'ccc-jquery-modal-styles', "https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css", false );

        //Add Slick.JS
        wp_enqueue_style( prefix().'-slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', array(), false);
        wp_enqueue_style( prefix().'-slick-css-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', array(), false);
        wp_enqueue_script( prefix().'-slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), true);
        wp_enqueue_script( prefix().'-slick-js-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array(), true);
    }

    // Remove Atomic Blocks Font Awesome
    add_action( 'wp_enqueue_scripts', 'remove_atomic_block_fontawesome', 100 );

    function remove_atomic_block_fontawesome(){
        wp_dequeue_style( 'atomic-blocks-fontawesome' );
    }

    // Add in our styles to Gutenberg
    add_action( 'after_setup_theme', 'add_custom_theme_styles_to_gutenberg' );

    function add_custom_theme_styles_to_gutenberg(){

        add_theme_support( 'editor-styles' ); // if you don't add this line, your stylesheet won't be added
        add_editor_style( get_template_directory_uri().'/css/web.css' ); // tries to include style-editor.css directly from your theme folder
    }
?>