<?php
    global $post;
    $body_classes = array(prefix());

    // CSS classes for <body>
    if(is_single()) $body_classes[] = prefix()."-single";
    if(is_archive()) $body_classes[] = prefix()."-archive";
    if(is_category()) $body_classes[] = prefix()."-category";
    if(is_author()) $body_classes[] = prefix()."-author";
    if(is_page()) $body_classes[] = prefix()."-page";
    if(isset($post->ID)) $body_classes[] = prefix()."-post-".$post->ID;
    if(isset($post->post_name)) $body_classes[] = prefix()."-post-".$post->post_name;

    if(is_front_page()) $body_classes[] = prefix()."-front-page";
    else $body_classes[] = prefix()."-inside-page";
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title><?php wp_title(); ?></title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Google Search Console -->
        <meta name="google-site-verification" content="dh_YMNPtkhvPIhBFsL1oa_Hp4y1iy0_pnxVXfx_wBQ0" />
        <!-- End Google Search Console -->


        <?php wp_head(); ?>
    </head>
    <body <?php body_class( $body_classes ); ?>>
    <?php wp_body_open(); ?>
        <header>
            <?php UI::grid_navigation_bar('header-menu', get_field('header_logo', 'option')); ?>
            <div id="vehicle-select-modal" class="modal">
                <h2>Select Your Vehicle</h2>
                <p>Shop for your specific vehicle to find parts that fit.</p>
                <?php UI::tap_vehicle_select_form('Save Vehicle'); ?>
            </div>
        </header>