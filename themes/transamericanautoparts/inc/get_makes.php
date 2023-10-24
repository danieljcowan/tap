<?php

  // $scriptPath = dirname(__FILE__);
  //  $path = realpath($scriptPath . '/./');
  //  $filepath = explode("wp-content",$path);
  // // print_r($filepath);
  // define('WP_USE_THEMES', false);
  // require(''.$filepath[0].'/wp-blog-header.php');

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
    
    // Return $makes_arr Array in JSON format.
    echo json_encode($makes_arr);