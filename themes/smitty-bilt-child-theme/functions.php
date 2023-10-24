<?php 
	add_action( 'wp_enqueue_scripts', 'smitty_bilt_child_theme_enqueue_styles' );
	function smitty_bilt_child_theme_enqueue_styles() {

	// Parent Theme Styles, then Child Theme Styles
	wp_enqueue_style( prefix().'-web', get_template_directory_uri().'/css/web.css', false, filemtime( get_template_directory() . '/css/web.css' ) );
	 	wp_enqueue_style( 'sb-child-styles', get_stylesheet_directory_uri() . '/css/web.css',filemtime(get_stylesheet_directory_uri() . '/css/web.css'));
	// Child Theme Fonts
	wp_enqueue_style( prefix().'-google-fonts', "https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=IBM+Plex+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap", false);
	 }
