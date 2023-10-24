<?php

function ccc_register_product_group_cpt() {
    register_post_type('product-group',
        array(
            'labels'      => array(
                'name'          => __('Product Groups', 'textdomain'),
                'singular_name' => __('Product Group', 'textdomain'),
        ),
            'public'        => true,
            'has_archive'   => true,
            'supports'      => array( 'title', 'comments', 'revisions', 'custom-fields', ),
            'menu_icon'     => 'data:image/svg+xml;base64,' . base64_encode('<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="toolbox" class="svg-inline--fa fa-toolbox fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M502.63 214.63l-45.25-45.25c-6-6-14.14-9.37-22.63-9.37H384V80c0-26.51-21.49-48-48-48H176c-26.51 0-48 21.49-48 48v80H77.25c-8.49 0-16.62 3.37-22.63 9.37L9.37 214.63c-6 6-9.37 14.14-9.37 22.63V320h128v-16c0-8.84 7.16-16 16-16h32c8.84 0 16 7.16 16 16v16h128v-16c0-8.84 7.16-16 16-16h32c8.84 0 16 7.16 16 16v16h128v-82.75c0-8.48-3.37-16.62-9.37-22.62zM320 160H192V96h128v64zm64 208c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16v-16H192v16c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16v-16H0v96c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-96H384v16z"></path></svg>'),
            'rewrite' => array(
                'slug' => 'products',
                'with_front' => false,
              )
        )
    );
}
add_action('init', 'ccc_register_product_group_cpt');



/*
 * Add Custom Status for "Hidden"
 */

function ccc_custom_product_group_status(){
    register_post_status('Hidden', array(
        'label'                     => _x( 'Hidden', 'products' ),
        'public'                    => false,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Hidden <span class="count">(%s)</span>', 'Hidden <span class="count">(%s)</span>' ),
    ) );
}
add_action( 'init', 'ccc_custom_product_group_status' );
 
// Using jQuery to add it to sku status dropdown
add_action('admin_footer-post.php', 'ccc_append_product_group_status_list');
function ccc_append_product_group_status_list(){
global $post;
$complete = '';
$label = '';
if($post->post_type == 'product-group'){
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
//  function ccc_add_acf_columns__product_groups ( $columns ) {
//    return array_merge ( $columns, array ( 
//      'product_group_id' => __ ( 'Product Group ID' ),
//    ) );
//  }
//  add_filter ( 'manage_product-group_posts_columns', 'ccc_add_acf_columns__product_groups' );

// // Echo the Product Group ID into the Column
//  function ccc_product_groups_custom_column__product_group_id ( $column, $post_id ) {
//    switch ( $column ) {
//      case 'product_group_id':
//        echo get_post_meta ( $post_id, 'product_group_id', true );
//        break;
//    }
//  }
//  add_action ( 'manage_product-group_posts_custom_column', 'ccc_product_groups_custom_column__product_group_id', 10, 2 );


// // Make Sortable
//  function ccc_product_groups_sortable_column__product_group_id( $columns ) {
//     $columns['product_group_id'] = 'product_group_id';
//     return $columns;
// }
// add_filter('manage_edit-product-group_sortable_columns', 'ccc_product_groups_sortable_column__product_group_id' );


// // Make Searchable
// function ccc_extend_admin_search__product_groups( $query ) {

//     // use your post type
//     $post_type = 'product-group';
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

// add_action( 'pre_get_posts', 'ccc_extend_admin_search__product_groups' );