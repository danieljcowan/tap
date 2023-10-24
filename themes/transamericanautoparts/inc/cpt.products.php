<?php

function ccc_register_products_cpt() {
    register_post_type('products',
        array(
            'labels'      => array(
                'name'          => __('SKUs', 'textdomain'),
                'singular_name' => __('SKU', 'textdomain'),
        ),
            'public'        => true,
            'has_archive'   => true,
            'supports'      => array( 'title', 'comments', 'revisions', 'custom-fields', ),
            'show_in_menu'  => 'edit.php?post_type=product-group',
            'rewrite' => array(
                'slug' => 'product-skus',
                'with_front' => false,
              )
        )
    );
}
add_action('init', 'ccc_register_products_cpt');


/*
 * Add Custom Status for "Hidden"
 */

function ccc_custom_sku_status(){
    register_post_status('Hidden', array(
        'label'                     => _x( 'Hidden', 'products' ),
        'public'                    => false,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Hidden <span class="count">(%s)</span>', 'Hidden <span class="count">(%s)</span>' ),
    ) );
}
add_action( 'init', 'ccc_custom_sku_status' );
 
// Using jQuery to add it to sku status dropdown
add_action('admin_footer-post.php', 'ccc_append_sku_status_list');
function ccc_append_sku_status_list(){
global $post;
$complete = '';
$label = '';
if($post->post_type == 'products'){
if($post->post_status == 'Hidden'){
$complete = ' selected="selected"';
$label = '<span id="post-status-display"> Hidden</span>';
}
echo '
<script>
jQuery(document).ready(function($){
$("select#post_status").append("<option value=\"Hidden\" '.$complete.'>Hidden</option>");
$(".misc-pub-section label").append("'.$label.'");
});
</script>
';
}
}




/*
 * Add Sortable columns for Product Group ID
 */

// // Set Up the Column
//  function ccc_add_acf_columns__products ( $columns ) {
//    return array_merge ( $columns, array ( 
//      'product_group_id' => __ ( 'Product Group ID' ),
//    ) );
//  }
//  add_filter ( 'manage_products_posts_columns', 'ccc_add_acf_columns__products' );

// // Echo the Product Group ID into the Column
//  function ccc_products_custom_column__product_group_id ( $column, $post_id ) {
//    switch ( $column ) {
//      case 'product_group_id':
//        echo get_post_meta ( $post_id, 'product_group_id', true );
//        break;
//    }
//  }
//  add_action ( 'manage_products_posts_custom_column', 'ccc_products_custom_column__product_group_id', 10, 2 );


// // Make Sortable
//  function ccc_product_sortable_column__product_group_id( $columns ) {
//     $columns['product_group_id'] = 'product_group_id';
//     return $columns;
// }
// add_filter('manage_edit-products_sortable_columns', 'ccc_product_sortable_column__product_group_id' );


// // Make Searchable
// function ccc_extend_admin_search__products( $query ) {

//     // use your post type
//     $post_type = 'products';
//     // Use your Custom fields/column name to search for
//     $custom_fields = array(
//         "product_group_id",
//     );

//     if( ! is_admin() )
//         return;

//     if ( $query->query['post_type'] != $post_type )
//         return;

//     $search_term = $query->query_vars['s'];

//     // Set to empty, otherwise it won't find anything
//     $query->query_vars['s'] = '';

//     if ( $search_term != '' ) {
//         $meta_query = array( 'relation' => 'OR' );

//         foreach( $custom_fields as $custom_field ) {
//             array_push( $meta_query, array(
//                 'key' => $custom_field,
//                 'value' => $search_term,
//                 'compare' => 'LIKE'
//             ));
//         }

//         $query->set( 'meta_query', $meta_query );
//     };
// }

// add_action( 'pre_get_posts', 'ccc_extend_admin_search__products' );
