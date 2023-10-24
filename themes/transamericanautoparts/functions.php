<?php

include('inc/core.php');
include('inc/enqueue.php');
include('inc/class.ui.php');
include('inc/menus.php');
include('inc/custom-image-sizes.php');
include('inc/settings.gutenberg.php');
include('inc/cpt.products.php');
include('inc/taxonomies.products.php');
include('inc/cpt.vehicles.php');
include('inc/taxonomies.vehicles.php');
include('inc/cpt.product-group.php');
include('inc/cpt.manual-merchandising.php');
include('inc/taxonomies.skus.php');
include('inc/cpt.news.php');
include('inc/taxonomies.news.php');
include('inc/cpt.locations.php');
include('inc/functions.wheel-finder.php');
include('inc/functions.wheel-finder-2.php');

// ACF Field Type
include('inc/acf.field.color-dropdown.php');

// ACF Blocks
include('blocks/blocks.categories.php');
include('blocks/blocks.blocks.php');
include('blocks/acf.blocks.php');

// Ninja Forms Customization
include('inc/ninja-forms.vehicle-select.php');

// Insert Headers
include('inc/functions.insert-headers.php');

// Include Explorer version of Vehicle Selector AJAX endpoints
include('inc/functions.explorer.php');



add_action('password_protected_login_messages', function(){

	echo 'This is the Development Environment for ' . get_bloginfo() . ', intended for development use only. If you are looking for the ' . get_bloginfo() . ' staging site, please visit <a href="' . str_replace("dev", "stage", get_site_url()) . '">' . get_bloginfo() . ' STAGING</a>';
});