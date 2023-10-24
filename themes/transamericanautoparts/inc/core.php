<?php

function prefix() {
    return "TAP";
}



add_theme_support( 'post-thumbnails' );



//Add Yoast Breadcrumb Support
add_theme_support( 'yoast-seo-breadcrumbs' );

//We're also going to remove the Home link from Yoast's breadcrumbs
function wpseo_remove_home_breadcrumb($links) {
    if ( $links[0]['url'] == home_url('/') ) { 
        array_shift($links); 
    } 
    return $links; 
} 
add_filter('wpseo_breadcrumb_links', 'wpseo_remove_home_breadcrumb');


// And we're going to remove the Products link from Yoast's breadcrumbs, and remove the SKUs link from Single SKU page
function wpseo_remove_breadcrumb_link( $link_output , $link ){
  
    if( $link['text'] == 'Products' ) {
        $link_output = '';
    }
    if( $link['text'] == 'Product Groups') {
        $link_output = '';
    }
    if( $link['text'] == 'SKUs') {
        $link_output = '';
    }
 
    return $link_output;
}
add_filter( 'wpseo_breadcrumb_single_link' ,'wpseo_remove_breadcrumb_link', 10 ,2);


// And we're going to hijack Yoast breadcrumb on the Single SKU page to remove "SKUS" from the breadcrumbs, and add a link to the product group it belongs to.

function ccc_yoast_single_sku_breadcrumb_links( $links ) {

    global $post;

    if ( is_singular('products') ) {

        $product_group_id = get_field('product_group_id');
        $args = array(
            'numberposts'   => 1,
            'post_type'     => 'product-group',
            'meta_key'      => 'product_group_id',
            'meta_value'    => $product_group_id
        );
        $product_groups = get_posts($args);
        $product_group = $product_groups[0];

        $breadcrumb1[] = array(
            'url' => get_permalink($product_group),
            'text' => $product_group->post_title,
        );

        array_splice( $links, 1, 0, $breadcrumb1 );

        $terms = get_the_terms($product_group, 'product_category');

        if(is_array($terms) && isset($terms[0])) {
            $single_term = $terms[0];

            $breadcrumb2[] = array(
                'url'   => get_term_link($single_term->term_id),
                'text'  => $single_term->name
            );

            array_splice( $links, 1, 0, $breadcrumb2 );


            $parent_term = get_term($single_term->parent, 'product_category');

            
            $breadcrumb3[] = array(
                'url'   => get_term_link($parent_term->term_id),
                'text'  => $parent_term->name
            );

            //array_splice( $links, 1, 0, $breadcrumb3 );

        }
    }

    return $links;

}
add_filter( 'wpseo_breadcrumb_links' ,'ccc_yoast_single_sku_breadcrumb_links', 10 ,2);




// Add ACF Options Page
if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'TAP Theme Settings',
        'menu_title'    => 'TAP Theme Settings',
        'menu_slug'     => 'tap-theme-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    
    acf_add_options_sub_page(array(
        'page_title'    => 'Header Settings',
        'menu_title'    => 'Header Settings',
        'parent_slug'   => 'tap-theme-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title'    => 'Footer Settings',
        'menu_title'    => 'Footer Settings',
        'parent_slug'   => 'tap-theme-settings',
    ));
    
}

/**
 * Get array of menu items
 */
function get_menu_items($menu_slug) {

    // Final output array
    $menu_items_organized = array();

    // Parent menu items counter
    $parent_counter = 0;

    // Get our nav locations (set in our theme, usually functions.php)
    $menu_locations = get_nav_menu_locations();

    // Get the *primary* menu ID
    $menu_id = $menu_locations[ $menu_slug ];

    // Get the array of wp objects, the nav items for our queried location.
    $menu_items = wp_get_nav_menu_items( $menu_id );

    // Make sure we have menu items
    if(is_array($menu_items) && !empty($menu_items)) {

        // Let's organize this into a menu / sub-menu array
        foreach ($menu_items as $menu_item_post) {

            // Does this item have a parent?
            if (is_numeric($menu_item_post->menu_item_parent) && $menu_item_post->menu_item_parent > 0) {

                // Set the parent ID
                $parent_id = $menu_item_post->menu_item_parent;

                // Loop through all the current posts in the menu
                foreach ($menu_items_organized as $count => $single_menu) {

                    // Is this the correct parent?
                    if ($single_menu->ID == $parent_id) {

                        // Add it to the submenu array
                        $menu_items_organized[$count]->submenu[] = $menu_item_post;
                    }

                }


            } // This is a high-level menu item, add it to the array
            else {

                // Initialize the menu object
                $menu_items_organized[$parent_counter] = new stdClass();

                // Create the object
                foreach ($menu_item_post as $key => $value) {
                    $menu_items_organized[$parent_counter]->$key = $value;
                }

                // Tack on the submenu
                $menu_items_organized[$parent_counter]->submenu = array();

                // Increase the parent counter
                $parent_counter++;

            }


        }

    }


    return $menu_items_organized;
}


/**
* Set up Vehicle Makes ajax path and get makes for select fields
*
*/

add_action( 'rest_api_init', function () {
    register_rest_route( 'tap/v1', '/get_vehicle_makes', array(
        'methods' => 'POST',
        'callback' => 'api_get_vehicle_makes',
    ) );
    register_rest_route( 'tap/v1', '/get_vehicle_models', array(
        'methods' => 'POST',
        'callback' => 'api_get_vehicle_models',
    ) );
    register_rest_route( 'tap/v1', '/get_vehicle_submodels', array(
        'methods' => 'POST',
        'callback' => 'api_get_vehicle_submodels',
    ) );
    register_rest_route( 'tap/v1', '/get_vehicle_engines', array(
        'methods' => 'POST',
        'callback' => 'api_get_vehicle_engines',
    ) );
} );

// First, get the Makes by the Year
function api_get_vehicle_makes(WP_REST_Request $request) {

       // Fetching makes based on year selection
    $year_id = 0;

    // if(isset($_POST['year'])){
    //    $year_id = mysqli_real_escape_string($con,$_POST['year']); // year id
    // }

    // Initialize $makes_arr Array with make id and name.
    $makes_arr = array();

    if(!empty( $_POST['year'] ) ) {
       
       $makes = get_terms( 'vehicle_category', array( 'hide_empty' => false, 'parent' => $_POST['year'] ) );

       foreach($makes as $make) {
          $make_id = $make->term_id;
          $make_name = $make->name;

          $makes_arr[] = array("id" => $make_id, "name" => $make_name);
       }
    }   

    //Add Select empty value to array
    array_unshift($makes_arr, array("id" => 0, "name" => 'Make'));


    // Return $makes_arr
    return new WP_REST_Response( $makes_arr, 200 );
}

// Second, get the Models by the Year
function api_get_vehicle_models(WP_REST_Request $request) {

       // Fetching Models based on Make selection
    $make_id = 0;

    // Initialize $models_arr Array with model id and name.
    $models_arr = array();

    if(!empty( $_POST['make'] ) ) {
       
       $models = get_terms( 'vehicle_category', array( 'hide_empty' => false, 'parent' => $_POST['make'] ) );

       foreach($models as $model) {
          $model_id = $model->term_id;
          $model_name = $model->name;

          $models_arr[] = array("id" => $model_id, "name" => $model_name);
       }
    }   

    array_unshift($models_arr, array("id" => 0, "name" => 'Model'));
    
    // Return $models_arr
    return new WP_REST_Response( $models_arr, 200 );
}

// Third, get the SubModels by the Model
function api_get_vehicle_submodels(WP_REST_Request $request) {

       // Fetching submodels based on model selection
    $model_id = 0;

    // Initialize $submodels_arr Array with make id and name.
    $submodels_arr = array();

    if(!empty( $_POST['model'] ) ) {

        $args = array(
                    'post_type' =>  'vehicle',
                    'numberposts' => -1,
                    'tax_query' =>  array(
                            array(
                                'taxonomy' => 'vehicle_category',
                                'field'    => 'id',
                                'terms'    => $_POST['model']
                            )
                        )
                    ); 

        $submodels = get_posts($args);

        foreach($submodels as $submodel) {

          $submodels_arr[] = array("id" => get_field('vehicle_id', $submodel), "name" => get_field('submodel_name', $submodel), "data" => $submodel->ID);
       }
    }   

    array_unshift($submodels_arr, array("id" => 0, "name" => 'Submodel', "data" => '0'));
    
    // Return $submodels_arr
    return new WP_REST_Response( $submodels_arr, 200 );
}

// Fourth, get the Engines by the Submodel
function api_get_vehicle_engines(WP_REST_Request $request) {

       // Fetching makes based on year selection
    $submodel_id = $_POST['submodel'];

    // Initialize $engines_arr Array with make id and name.
    $engines_arr = array();

    if(!empty( $_POST['submodel'] ) ) {

        $my_vehicle = get_post($submodel_id);

        $engines_field = get_field('engine', $my_vehicle->ID);
        $engines_array = explode(',', $engines_field);
        foreach($engines_array as $engine) {
            array_push($engines_arr, array('id' => str_replace(' ', '', $engine), 'name' => $engine));
        }


    }   

    array_unshift($engines_arr, array("id" => 0, "name" => 'Engine'));
    
    // Return $engines_arr
    return new WP_REST_Response( $engines_arr, 200 );
}


add_shortcode( 'tap-callout-banner', 'tap_callout_banner_shortcode' );
function tap_callout_banner_shortcode( $atts ) {
 $a = shortcode_atts( array(
 'text' => 'Find wheel options by lug pattern and more',
 'button_label' => 'Click Here',
 'button_link' => '#',
 ), $atts );
 return UI::tap_callout_banner($a['text'], $a['button_label'], $a['button_link']);
}


// Displays the current date in the given format
// Example: [current_date format="Y"] displays the current year
function current_date_init( $atts ){
  $a = shortcode_atts( [ 'format' => 'F j, Y'], $atts );
  ob_start();
  echo date($a['format']);
  return ob_get_clean();
}
add_shortcode( 'current_date', 'current_date_init' );