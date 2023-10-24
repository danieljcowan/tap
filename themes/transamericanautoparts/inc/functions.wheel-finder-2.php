<?php 

// THIS IS THE MAIN QUALIFER-BASED WHEEL FINDER

add_action( 'rest_api_init', function () {
    register_rest_route( 'tap/v1', '/wheel_finder_2', array(
        'methods' => 'POST',
        'callback' => 'api_wheel_finder_2',
    ) );
} );

function api_wheel_finder_2(WP_REST_Request $request) {

       // Fetching makes based on year selection
    $bolt_pattern = $_POST['bolt_pattern'];
    $diameter = $_POST['wheel_diameter'];
    $finish = $_POST['finish'];
    $series = $_POST['series'];

    $tax_query_args = array();

    if($series) {
        array_push($tax_query_args, array('taxonomy' => 'part_qualifier', 'field' => 'slug', 'terms' => array($series), 'operator' => 'IN',)
        );
    }
    if($bolt_pattern) {
        array_push($tax_query_args, array('taxonomy' => 'part_qualifier', 'field' => 'slug', 'terms' => array($bolt_pattern), 'operator' => 'IN',)
        );
    }
    if($diameter) {
        array_push($tax_query_args, array('taxonomy' => 'part_qualifier', 'field' => 'slug', 'terms' => array($diameter), 'operator' => 'IN',)
        );
    }
    if($finish) {
        array_push($tax_query_args, array('taxonomy' => 'part_qualifier', 'field' => 'slug', 'terms' => array($finish), 'operator' => 'IN',)
        );
    }



    $wheels_arr = array();
    $args = array(
            'post_type'        => 'products',
            'numberposts'      => -1,
            'post_status'      => 'publish',
            'tax_query'      => array( 
                'relation' => 'AND',
                $tax_query_args)
        );
    $wheels = get_posts( $args );


    // Let's get the inventory for each of these products from the text file
    $file = 'https://www.procompusa.com/tap-assets/inventory-sheet/inventory_procomp.txt';
    $cols = array();
    ini_set('auto_detect_line_endings', true);
    $fh = fopen($file, 'r');
    $i = 0;
    while (($line = fgetcsv($fh, 1000, "\t")) !== false) {
        $cols[] = $line;
        $i++;
      }


    foreach($wheels as $wheel) {

        $wheel_image = get_field('main_image_link', $wheel->ID);
        $wheel_part_number = get_field('part_number', $wheel->ID);
        $wheel_price = get_field('display_price', $wheel->ID);
        $features = get_field('long_description', $wheel->ID);

        $features_list = str_replace(';;', ';', $features);
        $features_list = str_replace('""', '', $features_list);
        $features_array = explode(";",$features_list);

        $inventory_array = array();
        $distribution_center_inventory = array(
            "Compton, CA"       =>  "Backordered",
            "Denver, CO"        =>  "Backordered",
            "Jacksonville, FL"  =>  "Backordered",
            "Carlisle, PA"      =>  "Backordered",
            "Coppell, TX"       =>  "Backordered"
        );

        foreach($cols as $col) {
            if($col[1] == $wheel_part_number) {
                $locations = get_posts(array(
                    'post_type'     => 'location',
                    'meta_key'      => 'location_id',
                    'meta_value'    => $col[2]
                ));
                $location = $locations[0];
                if($col[4] > 4) {
                    $more_than_5 = "Yes";
                } else {
                    $more_than_5 = "No";
                }
                $location_city_state = get_field('city', $location) . ', ' . get_field('state', $location);
                $distribution_center_inventory = array_replace($distribution_center_inventory, array($location_city_state => $more_than_5));
            } 
        }

        array_push($inventory_array, $distribution_center_inventory);
        array_push($wheels_arr,array($wheel->post_title,$wheel->ID,$wheel_image, $wheel_part_number, $wheel_price,get_permalink($wheel->ID), $features_array, $inventory_array, $distribution_center_inventory));
    }

    if(empty($wheels)) {
        $wheels_arr = 'Sorry, no wheels fit your criteria';
    }


    // Return $wheels_arr
    return new WP_REST_Response( $wheels_arr, 200 );
}
