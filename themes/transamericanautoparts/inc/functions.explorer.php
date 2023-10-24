<?php 


// I guess this would be the Explorer version of the Vehicle Selector

/**
* Set up Vehicle Makes ajax path and get makes for select fields
*
*/

add_action( 'rest_api_init', function () {
    register_rest_route( 'tap/v1', '/get_vehicle_makes__explorer', array(
        'methods' => 'POST',
        'callback' => 'api_get_vehicle_makes__explorer',
    ) );
    register_rest_route( 'tap/v1', '/get_vehicle_models__explorer', array(
        'methods' => 'POST',
        'callback' => 'api_get_vehicle_models__explorer',
    ) );
    register_rest_route( 'tap/v1', '/get_vehicle_submodels__explorer', array(
        'methods' => 'POST',
        'callback' => 'api_get_vehicle_submodels__explorer',
    ) );
    register_rest_route( 'tap/v1', '/get_vehicle_engines__explorer', array(
        'methods' => 'POST',
        'callback' => 'api_get_vehicle_engines__explorer',
    ) );
    register_rest_route( 'tap/v1', '/get_explorer_application_skus', array(
        'methods' => 'POST',
        'callback' => 'api_get_explorer_application_skus',
    ) );


} );

// First, get the Makes by the Year
function api_get_vehicle_makes__explorer(WP_REST_Request $request) {

       // Fetching makes based on year selection
    $year_id = 0;

    // if(isset($_POST['year'])){
    //    $year_id = mysqli_real_escape_string($con,$_POST['year']); // year id
    // }

    // Initialize $makes_arr Array with make id and name.
    $makes_arr = array();

    if(!empty( $_POST['year'] ) ) {
       
       $term = get_term_by('name', $_POST['year'], 'vehicle_category');

       $makes = get_terms( 'vehicle_category', array(
        	'hide_empty' => false,
            'parent' => $term->term_id,
            'name' => $_POST['explorer_makes']
        ) );

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
function api_get_vehicle_models__explorer(WP_REST_Request $request) {

       // Fetching Models based on Make selection
    $make_id = 0;
    $explorer_models = $_POST['explorer_models'];

    // Initialize $models_arr Array with model id and name.
    $models_arr = array();

    if(!empty( $_POST['make'] ) ) {
       
       $models = get_terms( 'vehicle_category', array( 'hide_empty' => false, 'parent' => $_POST['make'], 'name' => $explorer_models) );

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
function api_get_vehicle_submodels__explorer(WP_REST_Request $request) {

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
function api_get_vehicle_engines__explorer(WP_REST_Request $request) {

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



// Function to display HTML for single System SKU
function explorer_system_pod($application_row, $model_name) { 

$part_number = $application_row['part_number'];
$price = $application_row['price'];
$product_image = 'https://images.procompusa.com/sku/Pro%20Comp%20Suspension/400x400/' . $part_number . '-01.jpg';
$product_grade = $application_row['product_grade'];
$short_description = $application_row['short_description'];
preg_match('/(\d{1}\.*\d*")\//', $short_description, $match);
$lift_height = $match[1];

$rts = $application_row['recommended_tire_size'];
if( str_contains($rts, '275/70/17')) {
    $tire_size = '32"';
} elseif (str_contains($rts, '285/70/17')) {
    $tire_size = '33"';
} elseif (str_contains($rts, '315/70/17')) {
    $tire_size = '35"';
} elseif (str_contains($rts, '37x12.5x17')) {
    $tire_size = '37"';
} else {
    $tire_size = 'bigger';
}

if ( substr_compare($part_number, 'BX', -2) === 0 ) {
    $is_pro = true;
    $pod_image = get_site_url() . '/wp-content/uploads/2022/07/pro-landscape.jpg';
    $pod_title = 'Explorer Pro System';
    $button_label = 'Select Explorer Pro';

    // THE HTML FOR OUR PRO FEATURES LIs
    $features_html = '<li>The ' . $model_name . ' customer looking to upgrade to a ' . $tire_size . ' tire and maximize off-road performance.</li>';
    $features_html .= '<li>' . $lift_height . ' lift with stock towing capability.</li>';
    $features_html .= '<li>Pro off-road performance with massive 2.5" Shocks</li>';
    $features_html .= '<li>Excellent on-road feel and ride over stock.</li>';

    if( $application_row['product_modifier'] == 'plus' ) {
        $button_label = 'Select Explorer Pro Plus';
        $pod_title = 'Explorer Pro Plus System';
    }

} else {
    $is_pro = false;
    $pod_image = get_site_url() . '/wp-content/uploads/2022/07/base-landscape.jpg';
    $pod_title = 'Explorer System';
    $button_label = 'Select Explorer';

    // THE HTML FOR OUR BASE FEATURES LIs
    $features_html = '<li>The ' . $model_name . ' customer looking to upgrade to a ' . $tire_size . ' tire without breaking the bank.</li>';
    $features_html .= '<li>' . $lift_height . ' lift with stock towing capability.</li>';
    $features_html .= '<li>Improved performance off-road</li>';
    $features_html .= '<li>Excellent on-road feel and ride over stock.</li>';


    if( $application_row['product_modifier'] == 'plus' ) {
        $button_label = 'Select Explorer Plus';
        $pod_title = 'Explorer Plus System';
        $additional_includes = '<li>Rear Coils and Trackbar</li>';
    }
}

    ob_start(); ?>
        <article class="explorer-system-pod" id="<?=$part_number?>" product-grade="<?=$product_grade?>">
            <div class="explorer-system-pod__top">
                <div class="explorer-system-pod__header" style="background-image: url(<?=$pod_image?>)">
                    <h1 class="explorer_system-pod__title"><?=$pod_title?></h1>
                </div>
                <div class="explorer-system-pod__content">
                    <img class="explorer-system-pod__content-product-image" src="<?=$product_image?>">
                    <div class="explorer-system-pod__content-features explorer-system-pod__content-section">
                        <h2>Perfect For:</h2>
                        <ul>
                            <?=$features_html?>
                        </ul>
                    </div>
                    <div class="explorer-system-pod__content-includes explorer-system-pod__content-section">
                        <h2>Includes:</h2>
                        <ul>
                            <li><?=$short_description?></li>
                            <?= $additional_includes ?>
                        </ul>
                    </div>
                    <div class="explorer-system-pod__content-price explorer-system-pod__content-section">
                        <h2>Price: <?=$price?></h2>
                    </div>
                </div>
            </div>
            <div class="explorer-system-pod__button-container">
                <button data-attribute="<?=$part_number?>" product-grade="<?=$product_grade?>" price="<?=$price?>" class="TAP-button explorer-system-pod__button" onclick="explorerSelectSystem(this)"><?=$button_label?></button>
            </div>
        </article>
<?php $pod_html = ob_get_contents();
    ob_end_clean();

    return $pod_html;

}



// Function to get Explorer SKUS for the specific application/vehicle
function api_get_explorer_application_skus(WP_REST_Request $request) {
    $vehicle_id = $_POST['vehicle_id'];
    $vehicle_year = $_POST['vehicle_year'];
    $vehicle_name = $_POST['vehicle_name'];
    $model_name = $_POST['model_name'];

    //Order or operations:
    // 1. We need the System SKUS themselves
    // 2. We need the UCA Upgrade SKU, when applicable
    // 3. We need the Tire Specs and Recs
    // 4. We need the Wheel Specs and Recs
    // 5. We need the Summary


    // This is the Explorer Application Spreadsheet
    // We'll be using it to get the info we need for each application
    // We're just doing this in a csv to keep everything moving quickly.
    // I don't think we need to move it to the database at all, since the file is so small.
    // We're going to convert it to an multidimensional associative array,
    // so that we can use it for everything else later as well.
    $rows   = array_map('str_getcsv', file(get_theme_file_path().'/files/explorer-application-spreadsheet.csv'));
    //Get the first row that is the HEADER row.
    $header_row = array_shift($rows);
    //This array holds the final response.
    $explorer_csv    = array();
    foreach($rows as $row) {
        if(!empty($row)){
            $explorer_csv[] = array_combine($header_row, $row);
        }
    }
    $count = 0;
    foreach($explorer_csv as $ec_row) {
        $ec_row['vehicle_id'] = explode(',',$ec_row['vehicle_id']);
        $explorer_csv[$count] = $ec_row;
        $count ++;
    }

    // Here's where we get the SKUS themselves
    $application_skus = array();
    $application_rows = array();
    foreach($explorer_csv as $application) {
        if(in_array($vehicle_id, $application['vehicle_id'])) {
            $application_skus[] = $application;
        }
    }

    $pods_html = array();
    $gm_1500_small = array();
    $gm_1500_large = array();
    //Get the HTML for the Product Pods
    foreach($application_skus as $application_row) {
        if ( substr_compare($application_row['part_number'], 'U', -1)  ===0) {
            //send this for UCA HTML POD
        } elseif (str_contains($application_row['application'], 'GM 1500  14-16 (Small Taper Ball Joint)')) {
            $gm_1500_small[] = $application_row;
        } elseif (str_contains($application_row['application'], 'GM 1500  14-18 (Large Taper Ball Joint)')) {
            $gm_1500_large[] = $application_row;
        } else {
            if(!str_contains($application_row['product_grade'], 'leaf') ) {
                $pods_html[] = explorer_system_pod($application_row, $model_name);
            }
        }
    }

    $foo = $gm_1500_small;

    if (str_contains($application_skus[0]['application'], 'GM 1500') ) {
        if($vehicle_year > 2006 && $vehicle_year < 2014) {
            $pods_html = array();
            foreach($gm_1500_small as $application_row) {
                $pods_html[] = explorer_system_pod($application_row, $model_name);
            }
        } else {
        }
    }  else {

    }



    return new WP_REST_Response( array($pods_html, $application_skus, $foo), 200 );
}

?>
