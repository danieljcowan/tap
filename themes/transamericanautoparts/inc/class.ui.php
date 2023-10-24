<?php
Class UI {



    /**
     * Get a list of available colors
     * @return array - colors
     */
    public static function colors() {
        return array(
            'primary'                        => "Blue",
            'secondary'                      => "Green",
            'dark'                           => "Gray",

            'primary-opposite'               => "White (with Blue accent)",
            'secondary-opposite'             => "White (with Green accent)",
            'dark-opposite'                  => "White (with Gray accent)",
        );
    }






    /**
     * Echoes out a navigation menu
     * @param string $menu - slug for the menu
     * @param string $logo - Either SVG or an IMG tag
     */
    public static function grid_navigation_bar($menu,$logo) {

        // Main menu items
        $menu_items = get_menu_items($menu);

        // Get the current URL
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        ?>
        <div class="<?=prefix()?>-top-bar">
            <div class="container">
                <div class="group group-flex">
                    <div class="c c-4 c-sm-8 <?=prefix()?>-navigation__logo">
                        <a href="<?=get_bloginfo('url');?>"><img src="<?=$logo['url']?>" alt="<?=get_bloginfo()?> Logo"></a>
                    </div>
                    <a class="c c-sm-4 <?=prefix()?>-mobile-menu-toggle" data-toggle="<?=prefix()?>-active" data-target=".<?=prefix()?>-navigation__menu" aria-expanded="false" aria-controls="bs-example-navbar-collapse-1">
                        <i class="far fa-bars"></i>
                        <span class="sr-only">Show Navigation Menu</span>
                    </a>
                    <div class="c c-8 c-sm-12 <?=prefix()?>-header-search-bar">
                        <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>                 
                    </div>                
                </div>
            </div>
        </div>
        <nav class="<?=prefix()?>-navigation" data-nav-bar="top">
            <div class="container">
                <div class="group group-flex">
                    <div class="c c-7 c-xs-12">
                        
                        <?php
                        // Main menu
                        $menu_args = array(
                            //'menu'              => 'header-menu',
                            'theme_location'    => 'header-menu',
                            'menu_class'        => 'nav navbar-nav ml-auto '.prefix().'-navigation__menu',
                            'container'         => 'div',
                            'container_class'   => 'collapse navbar-collapse '.prefix().'-navbar-menu__container',
                            'container_id'      => 'bs-example-navbar-collapse-1',
                            //'container'         => false
                        );

                        wp_nav_menu($menu_args);


                        ?>

                      
                    </div>
                    <div class="c c-5 c-xs-12">
                        <div id="<?=prefix()?>-header-vehicle-fit" class="<?=prefix()?>-header-vehicle-fit">
                            <div class="group group-flex">
                                <div class="c c-9 alignright">
                                    <div id="header-current-vehicle" class="current-vehicle"></div>
                                </div>
                                <div class="c c-3 alignleft">
                                    <div class="action" onclick="clearVehicle()">Clear<i class="fas fa-times-circle"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    <?php }


    /**
     * Returns the HTML of a button
     * @param string $label - button label
     * @param string $url - link for button
     * @param array $features - array of extra data
     *
     * @return string - STRING of button or "" if nothing
     */
    public static function button($label,$url,$features = array()) {

        // Make sure we have a URL and Label
        if(strlen($label) > 1 && strlen($url) > 1) {

            // Button CSS clas prefix
            $prefix = prefix().'-button';


            // CSS classes
            $css_classes[] = $prefix;

            // Do we have a color?
            if(isset($features['color'])) {
                $css_classes[] = $prefix.'--'.$features['color'];
            }

            // Do we have a size?
            if(isset($features['size'])) {
                $css_classes[] = $prefix.'--'.$features['size'];
            }

            // Do we have a block?
            if(isset($features['display_block'])) {
                $css_classes[] = $prefix.'--block';
            }

            // Do we have uppercase?
            if(isset($features['uppercase'])) {
                $css_classes[] = $prefix.'--uppercase';
            }

            // Set the target
            if(isset($features['new_window']) && $features['new_window'] === true) {
                $target = 'target="_blank"';
            } else {
                $target = "";
            }

            ob_start();

            ?>

            <a class="<?=implode(' ',$css_classes)?>" <?=$target?> href="<?= $url ?>">
                <?= $label ?>
            </a>

            <?php
            $button_html = ob_get_contents();
            ob_end_clean();

            return $button_html;

        } else {
            return "";
        }

    }


    /**
     * Gets an image URL with a default of the Featured Image
     * @param array $acf_image - ACF image object
     * @param int $post_id - Post ID
     * @param array $sizes - a list of sizes to loop through
     *
     * @return string|bool - STRING for the URL or FALSE if nothing
     */
    public static function get_image_url($acf_image,$post_id,$sizes=array('medium')) {

        // Flag to just get the Featured Image
        $get_the_featured_image = false;

        // Do we have an image at all?
        if(isset($acf_image['sizes'])) {

            // What size do we want?
            foreach($sizes as $size) {

                // Do we have the size?
                if(isset($acf_image['sizes'][$size]) && strlen($acf_image['sizes'][$size]) > 1) {

                    // Return back the URL for that size
                    return $acf_image['sizes'][$size];

                }

            }

        }

        // We don't have data from an ACF image at all

        // Get the Featured Image Attachment ID
        $featured_image_id = get_post_thumbnail_id($post_id);


        // What size do we want?
        foreach($sizes as $size) {

            // Get the Featured Image source
            $featured_image_url = wp_get_attachment_image_src( $featured_image_id , $size );



            // Do we have an image this size?
            if(isset($featured_image_url[0]) && strlen($featured_image_url[0]) > 1) {
                return $featured_image_url[0];
            }

        }

        // We have zero images at all
        return false;

    }


    /**
     * Echoes the Main Image of the First Returned SKU, queried by the PRODUCT GROUP ID of the Current Product Group
     * @param string $product_group - Current Product Group
     *
     */

    public static function tap_child_product_main_image($product_group) {

        $pod_prefix = prefix() . '-product-pod';
        $product_group_id = get_field('product_group_id', $product_group);
        $sku_for_image = get_posts(array(
            'numberposts'   => 1,
            'post_type'     => 'products',
            'meta_key'      => 'product_group_id',
            'meta_value'    => $product_group_id,
        )); 
        foreach($sku_for_image as $sku) {
            $product_image = get_field('main_image_link', $sku); ?>
            <?php if($product_image) { ?>
                <img class="<?=$pod_prefix?>__image" src="<?=$product_image?>" alt="">
            <?php } else { ?>
                <div style="height:200px; width: 100%;"></div>
            <?php } ?>
        <?php } 

    }

    /**
     * Echoes out a Product style Pod
     * @param object $pod - the product pod that will be displayed
     */
    public static function tap_product_pod($pod) {

        $pod_prefix = prefix() . '-product-pod';
        $product_name = get_the_title($pod);
        $product_link = get_permalink($pod);
        $pg_vehicles = array_filter(explode('|', get_field('vehicles', $pod->ID)));
        $product_group_id = get_field('product_group_id', $pod->ID);
        ?>
        <div class="c c-4 c-sm-12"  id="product-group-<?=$product_group_id?>" role="group" aria-label="product">
            <a href="<?=$product_link?>" class="<?=$pod_prefix?>">
                <?php 
                    UI::tap_child_product_main_image($pod);
                ?>
                <div class="<?=$pod_prefix?>__content">
                    <h3 class="<?=$pod_prefix?>__title"><br><?=$product_name?></h3>
                    <div class="<?=prefix()?>-button">View Details</div>
                </div>
            </a>
        </div>

        <script>

            
            var myVehicle = localStorage.getItem("myVehicle");
            var myEngine = localStorage.getItem("myVehicleEngine");

            var fitsMyVehicleAndEngine = false;
            var fitsMyVehicleAndEngineNull = false;

            var pgVehicles = <?= json_encode($pg_vehicles) ?>;

            var el = document.getElementById('product-group-<?=$product_group_id?>');

            if ( pgVehicles[0].includes('uni') ) {
                var fitsMyVehicleAndEngine = true;
                el.setAttribute('fitment', 'universal-fit');
            } else {
                el.setAttribute('fitment', 'direct-fit');
            }

            console.log(myVehicle);
            console.log(pgVehicles);

            if ( myVehicle !== null ) {

                if ( pgVehicles.includes(myVehicle) ) {
                    el.setAttribute('fits-my-vehicle', true);
                } else {
                    el.setAttribute('fits-my-vehicle', false);
                }
            }

            
        </script>


    <?php }

    /**
     * Echoes out a Product ROW -- for Product Group Page
     * @param string $sku - the Product to be displayed
     */
    public static function tap_product_row($sku) {

        $row_prefix = prefix() . '-product-row';
        $product_name = get_the_title($sku);
        $product_link = get_permalink($sku);
        $product_image_link = get_field('main_image_link', $sku);
        $price = get_field('display_price', $sku);
        $part_number = get_field('part_number', $sku);
        $features_list = get_field('long_description', $sku);
        $features_list = str_replace('""', '', $features_list);
        $features_array = explode(";",$features_list);

        ?>
        <div class="<?=$row_prefix?>">
            <div class="group group-flex">
                <div class="c c-4">
                    <img class="<?=$row_prefix?>__image" src="<?=$product_image_link?>" alt="Image of <?=$product_name?>">
                </div>
                    <div class="c c-4">
                    <div class="<?=$row_prefix?>__content">
                        <h3 class="<?=$row_prefix?>__title"><br><?=$product_name?></h3>
                        <p class="<?=$row_prefix?>__part-number">Part #<?=$part_number?></p>
                        <h4>Primary Features</h4>
                        <ul>
                            <?php foreach($features_array as $feature) { ?>
                                <li><?=$feature?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="c c-4">
                    <div class="<?=$row_prefix?>__price">
                        <p class="<?=prefix()?>-single-product-summary__meta-cart__price">$<?=$price?></p>
                    </div>
                    <div class="<?=prefix()?>-single-product-summary__meta-cart__button-container">
                        <a class="<?=prefix()?>-single-product-summary__meta-cart__button" href="<?=$product_link?>">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    <?php }



    /**
     * Echoes out a Category style Pod
     * @param string $term - taxonomy term
     */
    public static function tap_category_pod($term) {

        $pod_prefix = prefix() . '-category-pod';
        $category_image_field = get_field('category_image', $term);
        if($category_image_field) {
            $category_image = $category_image_field;
        } else {
            $category_image = get_field('category_placeholder_image', 'option');
        }
        $category_name = $term->name;
        $category_link = get_term_link($term);
        $cat_vehicles = get_field('vehicles', $term->term_id);

        if(is_front_page()) {
            $c_width = '6';
        } else {
            $c_width = '4';
        }
        ?>
        <div class="c c-xs-12 c-<?=$c_width?> c-md-6" id="category-<?=$term->term_id?>" role="group" aria-label="product-category">
            <a href="<?=$category_link?>" class="<?=$pod_prefix?>">
                <img class="<?=$pod_prefix?>__image" src="<?=$category_image['url']?>" alt="<?=$category_image['alt']?>">
                <div class="<?=$pod_prefix?>__content">
                    <h3 class="<?=$pod_prefix?>__title"><?=$category_name?></h3>
                    <span class="<?=$pod_prefix?>__button">Shop Now<i class="fal fa-long-arrow-right"></i></span>
                </div>
            </a>
        </div>

        <script>

            console.log(<?=json_encode($cat_vehicles)?>);

            
            var myVehicle = localStorage.getItem("myVehicle");
            var myEngine = localStorage.getItem("myVehicleEngine");

            var fitsMyVehicleAndEngine = false;
            var fitsMyVehicleAndEngineNull = false;

            var catVehicles = <?= json_encode($cat_vehicles) ?>;

            var el = document.getElementById('category-<?=$term->term_id?>');

            if ( catVehicles.includes('uni') ) {
                var fitsMyVehicleAndEngine = true;
                el.setAttribute('fitment', 'universal-fit');
            } else {
                el.setAttribute('fitment', 'direct-fit');
            }

            console.log(myVehicle);
            console.log(catVehicles);

            if ( myVehicle !== null ) {

                if ( catVehicles.includes(myVehicle) ) {
                    el.setAttribute('fits-my-vehicle', true);
                } else {
                    el.setAttribute('fits-my-vehicle', false);
                }
            }

            
        </script>
    <?php 

    }


    /**
     * Echoes out a Manual Merchandising style Pod
     * @param string $mm_pod - taxonomy term
     * @param number $columns - number of columns (1-3)
     */
    public static function tap_manual_merchandising_pod($mm_pod, $columns) {

        $pod_prefix = prefix() . '-manual-merchandising-pod';
        $pod_image = $mm_pod['image'];
        $pod_name = $mm_pod['title'];
        $pod_badge = $mm_pod['badge_text'];
        $pod_description = $mm_pod['description'];
        $pod_features = $mm_pod['features'];
        $pod_features = explode (";", $pod_features);
        $pod_width = $columns;
        $pod_button_text = $mm_pod['button_text'];
        $pod_url = $mm_pod['button_url'];

        ?>
        <div class="c c-<?=$pod_width?> c-sm-12" role="group" aria-label="article">
            <div class="<?=$pod_prefix?>">
                <div class="<?=$pod_prefix?>__inner">
                    <div class="<?=$pod_prefix?>__top">
                        <div class="<?=$pod_prefix?>__image" style="background-image: url(<?=$pod_image['url']?>)">
                            <?php if($pod_badge) { ?>
                                <div class="<?=$pod_prefix?>__badge">
                                    <span><?=$pod_badge?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="<?=$pod_prefix?>__content">
                            <h3 class="<?=$pod_prefix?>__title?>"><?=$pod_name?></h3>
                            <p class="<?=$pod_prefix?>__description"><?=$pod_description?></p>
                            <?php if(!empty($mm_pod['features'])) { ?>
                                <h4>Specs/Features</h4>
                                <ul class="<?=$pod_prefix?>__features">
                                    <?php foreach($pod_features as $pod_feature) { ?>
                                        <li class="<?=$pod_prefix?>__features__item"><?=$pod_feature?></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="<?=$pod_prefix?>__bottom">
                        <a href="<?=$pod_url?>" class="<?=$pod_prefix?>__button"><?=$pod_button_text?></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- HERE'S THE HTML VERSION -->
        <!-- <div class="c c-4 c-md-6 c-xs-12">
            <div class="<?=$pod_prefix?>">
                <div class="<?=$pod_prefix?>__inner">
                    <div class="<?=$pod_prefix?>__image" style="background-image: url(http://transamericanautoparts.local/wp-content/uploads/2021/06/Asset-1-100.jpg)">
                        <div class="<?=$pod_prefix?>__badge">
                            <span>Level Up</span>
                        </div>
                    </div>
                    <div class="<?=$pod_prefix?>__content">
                        <h3 class="<?=$pod_prefix?>__title">Spacers & Shocks</h3>
                        <p class="<?=$pod_prefix?>__description">Give your truck an aggressive look with an increase in height and a large tire and wheel.</p>
                        <h4>Specs/Features</h4>
                        <ul class="<?=$pod_prefix?>__features">
                            <li class="<?=$pod_prefix?>__features__item">Lorem ipsum dolor</li>
                            <li class="<?=$pod_prefix?>__features__item">sit amet, consectetur </li>
                            <li class="<?=$pod_prefix?>__features__item">adipiscing elit, sed do eiusmod</li>
                        </ul>
                        <a href="#" class="<?=$pod_prefix?>__button">Shop Subcategory Now</a>
                    </div>
                </div>
            </div>
        </div> -->
    <?php }


    /**
    * Display the Yoast Breadcrumbs wherever you put this function
    */

    public static function tap_yoast_breadcrumbs() {
    ?>
        <div class="<?=prefix()?>-yoast-breadcrumbs">
            <?php
            if ( function_exists('yoast_breadcrumb') ) {
              yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            }
            ?>
        </div>
    <?php }



    /**
    * Display the Signup Form Section, using Ninja Forms
    */

    public static function tap_email_signup() { ?>
        <section class="<?=prefix()?>-optin alignfull" style="background-image: url(<?=get_site_url()?>/wp-content/uploads/2021/06/Asset-5.jpg), linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)); background-blend-mode: overlay;">
            <div class="container">
                <div class="group">
                    <div class="c c-6 c-xs-12">
                        <p>Join our mailing list to receive information on new products, special events, discounts and more!</p>
                    </div>
                    <div class="c c-6 c-xs-12">
                        <?= do_shortcode('[ninja_form id=1]'); ?>
                    </div>
                </div>
            </div>
        </section>
    <?php }


    /**
    * Display the Signup Form Section, using TAP's provided HTML Form
    */

    public static function tap_email_signup_HTML() { 

        $contact_callout_image = get_field('contact_callout_background_image', 'option');
        $email_signup_html = get_field('email_signup_html', 'option');
        $email_signup_heading = get_field('email_signup_heading', 'option')

        ?>
        <section class="<?=prefix()?>-optin alignfull" style="background-image: url(<?=$contact_callout_image['url']?>), linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)); background-blend-mode: overlay; background-position: center 60%;">
            <div class="container">
                <div class="group">
                    <div class="c c-6 c-xs-12">
                        <p><?=$email_signup_heading?></p>
                    </div>
                    <div class="c c-6 c-xs-12">
                        <?=$email_signup_html?>
                    </div>
                </div>
            </div>
        </section>
    <?php }



    /**
    * Display the Vehicle Select form
    * param $buton_label - Text for the button
    */

    public static function tap_vehicle_select_form($button_label) { 
       
        // Get the Years from custom taxonomy
        $years = get_terms( 'vehicle_category', array( 'hide_empty' => false, 'parent' => 0, 'order' => 'DESC') );
        
        ?>

        <div id="<?=prefix()?>-vehicle-select-form" class="<?=prefix()?>-vehicle-select-form">
            <select name="select_year" id="select_year" required>
               <option value="0">Year</option>
               <?php 
                    foreach($years as $year) {
                  // Option
                  echo "<option value='".$year->term_id."' >".$year->name."</option>";
               } ?>
            </select>
            <select disabled id="select_make" required>
               <option value="0">Make</option>
            </select>
            <select disabled id="select_model" required>
               <option value="0">Model</option>
            </select>
            <select disabled id="select_vehicle" required>
               <option value="0">Submodel</option>
            </select>
            <select disabled id="select_engine" required>
               <option value="0">Engine</option>
            </select>
            <div class="clear"></div>
            <button disabled class="<?=prefix()?>-button" onclick="setVehicle()" type="submit"><?=$button_label?></button>
        </div>


        <script>

        // Set the Vehicle Name in Header
        if (localStorage.getItem("myVehicle") === null) {
          document.getElementById("TAP-header-vehicle-fit").innerHTML = '<a class="add-vehicle" href="#vehicle-select-modal" rel="modal:open"><i class="fas fa-car"></i>Select Vehicle</a>';
        } else {
        document.getElementById("header-current-vehicle").innerHTML = localStorage.getItem("myVehicleName");
        }



        //Function to clear the vehicle and reload the page
        function clearVehicle() {
            localStorage.removeItem('myVehicle');
            localStorage.removeItem('myVehicleName');
            localStorage.removeItem('myVehicleYear');
            localStorage.removeItem('myVehicleMake');
            localStorage.removeItem('myVehicleModel');
            localStorage.removeItem('myVehicleSubmodel');
            localStorage.removeItem('myVehicleEngine');
            location.reload();
            return false;
        }



            // Populate the Makes dropdown with Makes by Year selected
        $(document).ready(function(){

            $("#select_year").change(function(){
                var year_id = $(this).val();
                console.log('Before post ' + $(this).val());

                var getMakesURL = '<?php echo get_site_url() . '/wp-json/tap/v1/get_vehicle_makes' ?>';

                $.ajax({
                    url: getMakesURL,
                    type: 'post',
                    data: {'year':year_id},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;


                        $("#select_make").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['name'];

                            
                            $("#select_make").append("<option value='"+id+"'>"+name+"</option>");
                            $("#select_make").attr( "disabled", false);

                        }
                    }
                });
            });
        });

        // Populate the Models dropdown with Models by Make selected
        $(document).ready(function(){

            $("#select_make").change(function(){
                var make_id = $(this).val();


                var getMakesURL = '<?= get_site_url() . '/wp-json/tap/v1/get_vehicle_models' ?>';

                $.ajax({
                    url: getMakesURL,
                    type: 'post',
                    data: {'make':make_id},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;


                        $("#select_model").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['name'];

                            
                            $("#select_model").append("<option value='"+id+"'>"+name+"</option>");
                            $("#select_model").attr( "disabled", false);

                        }
                    }
                });
            });
        });

        // Populate the Vehicles dropdown with SubModels by Make selected
        $(document).ready(function(){

            $("#select_model").change(function(){
                var model_id = $(this).val();


                var getMakesURL = '<?= get_site_url() . '/wp-json/tap/v1/get_vehicle_submodels' ?>';

                $.ajax({
                    url: getMakesURL,
                    type: 'post',
                    data: {'model':model_id},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;


                        $("#select_vehicle").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['name'];
                            var data = response[i]['data'];

                            
                            $("#select_vehicle").append("<option data='"+data+"' value='"+id+"'>"+name+"</option>");
                            $("#select_vehicle").attr( "disabled", false);

                        }
                    }
                });
            });
        });

        // Populate the Engine dropdown with Engine by Submodel selected
        $(document).ready(function(){

            $("#select_vehicle").change(function(){
                var submodel_id = $('option:selected', this).attr('data');
                var getMakesURL = '<?= get_site_url() . '/wp-json/tap/v1/get_vehicle_engines' ?>';

                $.ajax({
                    url: getMakesURL,
                    type: 'post',
                    data: {'submodel':submodel_id},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;
                        $("#select_engine").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['name'];

                            
                            $("#select_engine").append("<option value='"+id+"'>"+name+"</option>");
                            $("#select_engine").attr( "disabled", false);

                        }
                    }
                });
            });
        });

        // Enable the submit button once all fields are selected
        $(document).ready(function(){

            $("#select_engine").change(function(){
                $('button[type="submit"]').attr('disabled', false);
            });
        });

        // Now save the Vehicle to Local Storage
            function setVehicle() {
                var myVehicle = $("#select_vehicle").val();
                var myYear = $("#select_year option:selected").html();
                var myMake = $("#select_make option:selected").html();
                var myModel = $("#select_model option:selected").html();
                var mySubmodel = $("#select_vehicle option:selected").html();
                var myEngine = $("#select_engine option:selected").html();
                var myVehicleName = myYear + ' ' + myMake + ' ' + myModel;
                localStorage.setItem("myVehicle", myVehicle);
                localStorage.setItem("myVehicleName", myVehicleName);
                localStorage.setItem("myVehicleYear", myYear);
                localStorage.setItem("myVehicleMake", myMake);
                localStorage.setItem("myVehicleModel", myModel);
                localStorage.setItem("myVehicleSubmodel", mySubmodel);
                localStorage.setItem("myVehicleEngine", myEngine);
                location.reload();
                return false;
              }

        //Load the Name of MyVehicle in the header

        if (localStorage.getItem("myVehicle") === !null) {
        document.getElementById("header-current-vehicle").innerHTML = localStorage.getItem("myVehicleName");
        }


        </script>



   <?php }
   

    /**
     * Echoes out a callout banner with button
     * @param string $text - Paragraph Text for the left side of the banner
     * @param string $button_label - Text label for the button
     * @param string $button_link - URL for the button 
     */
    public static function tap_callout_banner($text, $button_label, $button_link) {



        ob_start(); ?>

        <div class="<?=prefix()?>-callout-banner">
            <p class="<?=prefix()?>-callout-banner__text"><?=$text?></p>
            <a class="<?=prefix()?>-button <?=prefix()?>-callout-banner__button" href="<?=$button_link?>"><?=$button_label?></a>
        </div>



        <?php
        $callout_banner_html = ob_get_contents();
        ob_end_clean();

        return $callout_banner_html;

    }

}
