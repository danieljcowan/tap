<?php


// Let's delete Terms
$args = array(
    'taxonomy' => 'vehicle_category',
    'name__like' => array('gmc', 'international'),
);
$terms_to_delete = get_terms($args);

foreach($terms_to_delete as $t) {
    print_r($t);
    echo '<br><hr><br>';
}










// $numbers = range(1900,1905);
// $delete_post = array(
//     'numberposts' => -1,    // The number of posts to retrieve, otherwise 5
//     'post_type'   => 'vehicle',
//     'tax_query' => array(
//         array (
//             'taxonomy' => 'vehicle_category',
//             'field' => 'slug',
//             'terms' => '$numbers',
//             'operator' => 'OR',
//         )
//     ),
// );



// $posts = new WP_Query( $delete_post );

// if ( $posts->have_posts() ) {
//     while ( $posts->have_posts() ) {
//         $posts->the_post();
//          wp_delete_post( get_the_ID());
//     }
// }
?>