<?php 

add_filter( 'ninja_forms_render_options', function( $options, $settings ) {
 
$years = get_terms( 'vehicle_category', array( 'hide_empty' => false, 'parent' => 0) );

  if ($settings['key'] == 'years' ) {

    foreach($years as $year) {

      $year_options = array(
        'label' => $year->name,
        'value' => $year->name,
        'calc' => 0,
        'selected' => true
      );

      array_push($options, $year_options);

    }

  }

  return $options;
}, 10, 2 );