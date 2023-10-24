<?php 
/*
 * Template Name: Home Page
 * description: Homepage for Transamerican Auto Parts
 */

// Additional code goes here...

get_header(); ?>

<?php 
$hp = prefix() . '-homepage';


// SMITTYBILT CAT EXCLUDES
//Delta Accessories
$delta = get_term_by('slug', 'delta-series-recovery-accessories', 'product_category');



$args = array(
            'taxonomy' => 'product_category',
            'hide_empty' => false,
            'parent' => 0,
            'orderby' => 'meta_value',
            'meta_key'      => 'priority',
            'order' => 'ASC',
            'exclude' => array( $delta->term_id ),
        );
        
$categories =   get_terms($args);
                    

// Let's get the ACF Fields for the page
$sliders = get_field('hero_slider');
$shop_by_make = get_field('shop_by_make_section');
$procomp_promise = get_field('pro_comp_promise');
$category_heading = get_field('category_heading');
$gallery = get_field('gallery');


?>


    <main class="container <?=$hp?>">
        <?php if($sliders) { ?>
            <section class="<?=$hp?>-hero alignfull">
                <div class="<?=$hp?>-hero__slider">
                    <?php foreach($sliders as $slider) { ?>

                        <a href="<?= $slider['category_link'] ?>" class="<?=$hp?>-hero__slider__slide" style="background-image:url(<?=$slider['image']['url']?>)">
                            <div class="<?=$hp?>-hero__slider__slide-content">
                                <h2 class="<?=prefix()?>-united"><?=$slider['heading']?></h2>
                                <h3 class="<?=prefix()?>-united"><?=$slider['subheading']?></h3>
                            </div>
                        </a>
                <?php } ?>
                </div>
            </section>
        <?php } ?>
        <a id="homepage-products"></a>
        <section class="<?=prefix()?>-categories-block">
            <h2 class="<?=prefix()?>-categories-block__title textcenter "><?=$category_heading?></h2>
            <div class="group group-flex">
                <?php 
                    if($categories) {
                        foreach($categories as $category) {
                        UI::tap_category_pod($category);
                    } 
                }?>
            </div>
        </section>


        <?php if($gallery) { ?>

            <section class="<?=$hp?>-gallery alignfull">
                <div class="container">
                    <?=$gallery?>
                </div>
            </section>

        <?php } ?>
        <!-- This Shop By Make Section hasn't been used since Launch -- DISABLED on July 1, 2021 by Daniel Cowan -->
        <!-- <section class="<?=$hp?>-shop-by-make alignfull">
            <div class="container">
                <h2 class="<?=$hp?>-shop-by-make__title textcenter">Shop By Make</h2>
                <div class="<?=$hp?>-shop-by-make__slider">
                    <?php foreach($shop_by_make as $brand) { ?>
                        <div class="<?=$hp?>-shop-by-make__slider__slide" style="background-image: url(<?=$brand['image']['url']?>), linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)); background-blend-mode: overlay; min-height: 330px">
                            <div>
                                <h3><?=$brand['title']?></h3>
                                <?php if($brand['description']) { ?>
                                    <p><?=$brand['description']?></p>
                                <?php } ?>
                            </div>
                            <div>
                                <a class="<?=$hp?>-shop-by-make__slider__button button" href="<?=$brand['button_url']?>"><?=$brand['button_text']?></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section> -->

        <?php if($procomp_promise) { ?>
            <section class="<?=$hp?>-procomp-promise">
                <h2 class="<?=$hp?>-procomp-promise__title textcenter"><?=get_field('brand_promise_heading');?></h2>
                <div class="<?=$hp?>-procomp-promise__description">
                   <?=$procomp_promise?>
                </div>
            </section>
        <?php } ?>

    </main>


<?php get_footer(); ?>