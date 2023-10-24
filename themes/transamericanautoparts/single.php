<?php get_header();


// We need the Permalink, as well as parse that into Host (domain) and Path
$parsedUrl = parse_url(get_permalink());
$domain = str_replace('www.','',$parsedUrl['host']);
$path = $parsedUrl['path'];


$part_number = get_field('part_number');
$features_list = get_field('long_description');
$features_array = explode(";",$features_list);

$price = get_field('display_price');
$description = get_field('sales_description');
$warranty_blurb = get_field('sku_page_warranty_blurb', 'option');

/*
 * Let's setup all the Fitment Check info
 */

// They come in as a comma separated string.
$fitment = get_field('vehicle_ids');

// Make them an array, then lowercase them for checking Universal Fit later
$fitment = explode('|', $fitment);
$fitment = (array_map('strtolower', $fitment));

// If Product has Universal Fit, then add Universal Fit message to Features
if(in_array('uni', $fitment ) ) {
    array_unshift($features_array, 'Not Vehicle Specific');
} else {
    array_unshift($features_array, 'Direct Fit');
}

/*
 * Let's also get the Vehicle/Engine Fitments for this product
 */
$sku_engines_field = get_field('vehicle_qualifiers_engine');
$sku_engines = explode('|', $sku_engines_field);
$engines = array();
foreach($sku_engines as $sku_engine) {
    $engine_arr = explode(':', $sku_engine);
    $vehicle_id = $engine_arr[0];
    if (!empty($engine_arr[1])) {
        $engine_data = $engine_arr[1];
    } else {
        $engine_data = 'null';
    }
    array_push($engines, array('vehicle_id' => $vehicle_id, 'engine' => $engine_data));
}




/*
 * Let's get all these images ready
 */

//What's the main image? (This is a full URL)
$main_image = get_field('main_image_link');

//What are the extra images? (They are imported as a comma separated string of just slugs/IDs)
$additional_images = get_field('additional_images');

//Create an array from the string of additional image IDs
if($additional_images) {
    $all_image_ids = explode(",",$additional_images);
} else {
    $all_image_ids = array();
}

//Turn the main image URl into just a slug/ID
$main_image_id = substr($main_image, strrpos($main_image, '/') + 1);

//Insert the main image ID into the array of Image IDs, at the beginning
array_unshift($all_image_ids,$main_image_id);

//Get the root url for all these images
$images_root_url = substr($main_image, 0,strrpos($main_image, '/'));


//Let's process the installation instructions pdf link as well. It comes in as just a slug. We need to add '/standard/' before the slug, and then it can be added to the root URL
$installation_instructions_slug = get_field('installation_instructions');
$installation_instructions_url = substr($images_root_url, 0,strrpos($images_root_url, '/')) . '/standard/' . $installation_instructions_slug;





?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <main class="<?=prefix()?>-single-product">
    	<div class="container">
    		<div class="<?=prefix()?>-single-product-breadcrumbs">
                <?php
                if ( function_exists('yoast_breadcrumb') ) {
                  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                }
                ?>
    		</div>

    		<!-- SUMMARY SECTION (Includes Images on the Left and Product Info on Right) -->
    		<div class="<?=prefix()?>-single-product-summary">
    			<div class="group group-flex">
    				<div class="c c-6 c-md-12">
    					<div role="region" class="<?=prefix()?>-single-product-summary__images">
                            <?php if($additional_images) { ?>
                                <div class="slider-for">
                                    <?php foreach($all_image_ids as $image) {
                                        $image_url = $images_root_url . '/' . $image;
                                    ?>
                                        <div>
                                            <img src="<?=$image_url?>">
                                        </div>
                                    <?php } ?>
                                </div>
                                <div role="region" class="slider-nav">
                                    <?php 
                                    $count = 1;
                                    foreach($all_image_ids as $image) {
                                        $image_url = $images_root_url . '/' . $image;
                                    ?>
                                        <button style="border:none;">
                                            <img src="<?=$image_url?>" alt="<?=get_the_title();?> view <?=$count?>">
                                        </button>
                                    <?php 
                                        $count++;
                                    } ?>
                                </div>
                            <?php } else { ?>
                                <img src="<?=$main_image?>" alt="">
                            <?php } ?>
	    				</div>
    				</div>
    				<div class="c c-6 c-md-12">
    					<div class="<?=prefix()?>-single-product-summary__meta">
    						<div id="<?=prefix()?>-single-product-summary__meta-vehicle-fit" class="<?=prefix()?>-single-product-summary__meta-vehicle-fit">
    						</div>
    						<div class="<?=prefix()?>-single-product-summary__meta-content">
	    						<h1 class="<?=prefix()?>-single-product-summary__meta-title"><?=get_the_title();?></h1>
	    						<p class="<?=prefix()?>-single-product-summary__meta-part-number">Part # <?=$part_number?></p>
	    						<div class="<?=prefix()?>-single-product-summary__meta-stars">
	    						</div>
	    						<div class="<?=prefix()?>-single-product-summary__meta-features">
	    							<h2>Primary Features</h2>
									<ul>
										<?php foreach($features_array as $feature) { ?>
											<li><?=$feature?></li>
										<?php } ?>
									</ul>
	    						</div>
	    						<div class="<?=prefix()?>-single-product-summary__meta-cart">
	    							<div class="group">
	    								<div class="c c-6 c-sm-12">
	    									<span class="<?=prefix()?>-single-product-summary__meta-cart__price">$<?=$price?></span>
	    								</div>
	    								<div class="c c-6 c-sm-12">
	    									<a class="<?=prefix()?>-single-product-summary__meta-cart__button" href="javascript:void(0)" onclick="window.open('https://www.4wheelparts.com/cart/shoppingCart.jsp?partNumber=<?=$part_number?>&utm_medium=Referral&source=<?=$domain?>&campaign=<?=$path?>');">Buy on 4wp.com</a>
	    									<!-- <p>or <a href="#">Find an Authorized Dealer</a></p> -->
	    								</div>
	    							</div>
	    						</div>
	    					</div>
    					</div>
    				</div>
    			</div>
    		</div>

    		<!-- RELATED PRODUCTS SECTION -->
    		<!-- <div class="<?=prefix()?>-single-product-related-products">
    			<h2 class="<?=prefix()?>-single-product-related-products__title">Related Products</h2>
    			<div class="<?=prefix()?>-single-product-related-products__products">
    				<div class="group group-flex">
    					<div class="c c-3 c-md-6 c-xs-12">
    						<a href="#">
    							<img src="https://www.4wheelparts.com/sku/4Wheel%20Drive%20Hardware/400x400/CB19UNVPKG.jpg">
    							<h3>Product 1</h3>
    						</a>
    					</div>
    					<div class="c c-3 c-md-6 c-xs-12">
    						<a href="#">
    							<img src="https://www.4wheelparts.com/sku/AirLift/400x400/74000_v1.jpg">
    							<h3>Product 2</h3>
    						</a>
    					</div>
    					<div class="c c-3 c-md-6 c-xs-12">
    						<a href="#">
    							<img src="https://www.4wheelparts.com/sku/American%20Force%20Wheels/400x400/TORQUE-SS.jpg">
    							<h3>Product 3</h3>
    						</a>
    					</div>
    					<div class="c c-3 c-md-6 c-xs-12">
    						<a href="#">
    							<img src="https://www.4wheelparts.com/sku/Anzo/400x400/111320.jpg">
    							<h3>Product 4</h3>
    						</a>
    					</div>
    				</div>
    			</div>
    			<div class="<?=prefix()?>-single-product-related-products__more">
    				<a href="#">View More Products</a>
    			</div>
    		</div> -->

    		<!-- DETAILS SECTION (Everything below Related Products) -->
    		<div class="<?=prefix()?>-single-product-details">
    			<div class="<?=prefix()?>-single-product-details__navigation alignfull">
    				<div class="container">
    					<ul>
	    					<li><a href="#description">Description</a></li>
                            <?php if($installation_instructions_slug) { ?>
                               <li><a href="#installation">Installation</a></li>
                            <?php } ?>
	    					<li><a href="#warranty">Warranty</a></li>
	    					<li><a href="#fitment">Fitment</a></li>
	    					<!-- <li><a href="#reviews">Reviews</a></li> -->
	    				</ul>
	    			</div>
    			</div>
    			<div class="<?=prefix()?>-single-product-details__content">
                    <a id="description"></a>
    				<div class="<?=prefix()?>-single-product-details__content__section description">
                        <h2>Description</h2>
    					<p><?=$description?></p>
    				</div>

                    <?php if($installation_instructions_slug) { ?>
                        <a id="installation"></a>
        				<div class="<?=prefix()?>-single-product-details__content__section">
        					<h2>Installation</h2>
        					<div class="<?=prefix()?>-single-product-details__content__installation-box">
        						<h3>Installation Instructions</h3>
        						<div class="<?=prefix()?>-single-product-details__content__installation-box__link">
        							<a target="_blank" href="<?=$installation_instructions_url?>">Read Instructions<i class="fas fa-chevron-right"></i></a>
        							<i class="icon fal fa-tools"></i>
        						</div>
        					</div>
        				</div>
                    <?php } ?>

                    <a id="warranty"></a>
    				<div class="<?=prefix()?>-single-product-details__content__section warranty">
                        <h2>Warranty</h2>
    					<?php if($warranty_blurb) {
                            echo $warranty_blurb;
                        } else { ?>
                            <p>At Pro Comp, we know you have many choices when selecting products to personalize your vehicle. You should demand nothing but the highest quality available and have total confidence that the products you selected are the best in the industry. It is for these reasons that Pro Comp Suspension products are backed by the best warranty in the industry...the Pro Comp Promise!</p>
                        <?php } ?>
                        <a href="<?=get_site_url()?>/warranty/" class="<?=prefix()?>-button classic-button">Read More</a>
    				</div>

    				<a id="fitment"></a>
                    <div class="<?=prefix()?>-single-product-details__content__section fitment">
                        <h2>Fitment</h2>
                        <?php
                            if($fitment) {

                                if(in_array('uni', $fitment ) ) { ?>
                                    <img class="universal-fit-logo" src="<?=get_template_directory_uri()?>/images/universal-fit-logo.webp" alt="Universal Fit Icon">
                                <?php } else { 
                                    echo '<ul>';

                                    $args = array(
                                            'numberposts'   => -1,
                                            'post_type'     => 'vehicle',
                                            'meta_key'      => 'vehicle_id',
                                            'meta_value'    => $fitment,
                                            'order'         => 'DESC',
                                            'orderby'   => 'order_clause',
                                            'meta_query' => array(
                                                'order_clause' => array(
                                                    'key' => 'year_id',
                                                )
                                            )
                                        );

                                        // query
                                        $fit_vehicles = get_posts( $args );
                                        sort($fit_vehicles,);

                                        foreach($fit_vehicles as $fit_vehicle) {
                                            echo '<li>' . $fit_vehicle->post_title . '</li>';
                                        }

                                    echo '</ul>';
                                }
                            }

                        ?>
    				</div>
    				<!-- <div class="<?=prefix()?>-single-product-details__content__section reviews">
    					<h2><a id="reviews">Reviews</a></h2>
    					<div class="group group-flex">
                            <div class="c c-6 c-sm-12 review">
                                <div class="reviewer">
                                    <div class="title">
                                        <h3>This is the Title of the Review</h3>
                                    </div>
                                </div>
                                <div class="group group-flex meta">
                                    <div class="c c-4 stars">
                                        <img src="<?=get_bloginfo('url')?>/wp-content/uploads/2021/05/Screen-Shot-2021-05-28-at-11.40.42-AM.png">
                                    </div>
                                    <div class="c c-8 info">
                                        <span>Reviewed in Atlanta, GA 2020<span>
                                    </div>
                                </div>
                                <div class="c c-12 review">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At quis risus sed vulputate. Consectetur l.</p>
                                    <p class="name">Truly D.</p>
                                </div>
                            </div>
                            <div class="c c-6 c-sm-12 review">
                                <div class="reviewer">
                                    <div class="title">
                                        <h3>This is the Title of the Review</h3>
                                    </div>
                                </div>
                                <div class="group group-flex meta">
                                    <div class="c c-4 stars">
                                        <img src="<?=get_bloginfo('url')?>/wp-content/uploads/2021/05/Screen-Shot-2021-05-28-at-11.40.42-AM.png">
                                    </div>
                                    <div class="c c-8 info">
                                        <span>Reviewed in Atlanta, GA 2020<span>
                                    </div>
                                </div>
                                <div class="c c-12 review">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At quis risus sed vulputate. Consectetur l.</p>
                                    <p class="name">Truly D.</p>
                                </div>
                            </div>
                            <div class="c c-6 c-sm-12 review">
                                <div class="reviewer">
                                    <div class="title">
                                        <h3>This is the Title of the Review</h3>
                                    </div>
                                </div>
                                <div class="group group-flex meta">
                                    <div class="c c-4 stars">
                                        <img src="<?=get_bloginfo('url')?>/wp-content/uploads/2021/05/Screen-Shot-2021-05-28-at-11.40.42-AM.png">
                                    </div>
                                    <div class="c c-8 info">
                                        <span>Reviewed in Atlanta, GA 2020<span>
                                    </div>
                                </div>
                                <div class="c c-12 review">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At quis risus sed vulputate. Consectetur l.</p>
                                    <p class="name">Truly D.</p>
                                </div>
                            </div>
                            <div class="c c-6 c-sm-12 review">
                                <div class="reviewer">
                                    <div class="title">
                                        <h3>This is the Title of the Review</h3>
                                    </div>
                                </div>
                                <div class="group group-flex meta">
                                    <div class="c c-4 stars">
                                        <img src="<?=get_bloginfo('url')?>/wp-content/uploads/2021/05/Screen-Shot-2021-05-28-at-11.40.42-AM.png">
                                    </div>
                                    <div class="c c-8 info">
                                        <span>Reviewed in Atlanta, GA 2020<span>
                                    </div>
                                </div>
                                <div class="c c-12 review">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At quis risus sed vulputate. Consectetur l.</p>
                                    <p class="name">Truly D.</p>
                                </div>
                            </div>
    					</div>
    				</div> -->
    			</div>
    		</div>
    	</div>
    </main>
<?php endwhile; endif; ?>

<script>




    var myVehicle = localStorage.getItem("myVehicle");
    var myEngine = localStorage.getItem("myVehicleEngine");
    var myVehicleName = localStorage.getItem("myVehicleName");
    var myVehicleSubName = localStorage.getItem("myVehicleSubmodel");
    var VehicleFit = <?php echo json_encode($fitment) ?>;
    var EnginesFit = <?php echo json_encode($engines) ?>;
    var FitsVehicle = '<div class="group group-flex"><div class="c c-2 <?=prefix()?>-single-product-summary__meta-vehicle-fit__icon"><i class="fas fa-check"></i></div><div class="c c-10 <?=prefix()?>-single-product-summary__meta-vehicle-fit__info"><div class="c c-9 <?=prefix()?>-single-product-summary__meta-vehicle-fit__message">This item fits your <span>' + myVehicleName + '</span> ' + '</div> <div class="c c-3 <?=prefix()?>-single-product-summary__meta-vehicle-fit__action"><a href="#vehicle-select-modal" rel="modal:open"><span>Change<br>Vehicle</span></a></div></div></div>';
    var NotFitVehicle = '<div class="group group-flex"><div class="c c-2 <?=prefix()?>-single-product-summary__meta-vehicle-fit__icon"><i class="fas fa-times"></i></div><div class="c c-10 <?=prefix()?>-single-product-summary__meta-vehicle-fit__info"><div class="c c-9 <?=prefix()?>-single-product-summary__meta-vehicle-fit__message">This item <em>does not fit</em> your <span>' + myVehicleName + '</span> </div> <div class="c c-3 <?=prefix()?>-single-product-summary__meta-vehicle-fit__action"><a href="#vehicle-select-modal" rel="modal:open"><span>Change<br>Vehicle</span></a></div></div></div>';

    var fitsMyVehicleAndEngine = false;
    var fitsMyVehicleAndEngineNull = false;
    var engineFitCount = EnginesFit.length;
    console.log(EnginesFit);
    console.log(engineFitCount);
    if(EnginesFit[0].engine == 'null') {
        console.log('enginesfit is null');
    }
    for( var i = 0; i<engineFitCount; i++ ) {
        var loopVehicleID = parseInt(EnginesFit[i].vehicle_id);
        var loopEngine = EnginesFit[i].engine.toLowerCase();
        var engineLength = EnginesFit[i].engine.length;
        var engineEmpty = 'null';

        if ( loopVehicleID === parseInt(myVehicle) ) {
            var fitsMyVehicle = true;
        }

        if ( loopEngine === myEngine.toLowerCase() ) {
            var fitsMyEngine = true;
        }

        if ( loopEngine === engineEmpty.toLowerCase() ) {
            var engineNull = true;
        }

        if ( fitsMyVehicle === true && fitsMyEngine === true ) {
            fitsMyVehicleAndEngine = true;
        }

        if ( fitsMyVehicle === true && engineNull === true ) {
            fitsMyVehicleAndEngineNull = true;
        }
    }



    if (localStorage.getItem("myVehicle") === null) {
      document.getElementById("<?=prefix()?>-single-product-summary__meta-vehicle-fit").innerHTML = '<a id="single-product-no-vehicle-button" href="#vehicle-select-modal" rel="modal:open">Set your vehicle to see if this item fits.<span>Click Here</span></a>';
      $( ".<?=prefix()?>-single-product-summary__meta-vehicle-fit" ).addClass( "no-vehicle" );

      if ( VehicleFit.includes('uni') ) {

        // document.getElementById("<?=prefix()?>-single-product-summary__meta-vehicle-fit").innerHTML = FitsVehicle;
        $( ".<?=prefix()?>-single-product-summary__meta-vehicle-fit" ).addClass( "universal-fit" );
        $( ".<?=prefix()?>-single-product-summary__meta-vehicle-fit" ).removeClass( "no-vehicle" );
        document.getElementById("<?=prefix()?>-single-product-summary__meta-vehicle-fit").innerHTML = '';


      }


    } else if ( VehicleFit.includes('uni') ) {
        console.log('This item is Not Vehicle Specific');
        // document.getElementById("<?=prefix()?>-single-product-summary__meta-vehicle-fit").innerHTML = FitsVehicle;
        $( ".<?=prefix()?>-single-product-summary__meta-vehicle-fit" ).addClass( "universal-fit" );
        $( ".<?=prefix()?>-single-product-summary__meta-vehicle-fit" ).removeClass( "no-vehicle" );


    } else if ( fitsMyVehicleAndEngine === true  || fitsMyVehicleAndEngineNull === true ) {

        document.getElementById("<?=prefix()?>-single-product-summary__meta-vehicle-fit").innerHTML = FitsVehicle;
        $( ".<?=prefix()?>-single-product-summary__meta-vehicle-fit" ).addClass( "fits-vehicle" );
        console.log('this item fits my vehicle and engine');

    } else {

        console.log('this item does not fit my vehicle and engine');
        document.getElementById("<?=prefix()?>-single-product-summary__meta-vehicle-fit").innerHTML = NotFitVehicle;
        $( ".<?=prefix()?>-single-product-summary__meta-vehicle-fit" ).addClass( "no-fit-vehicle" );
    }


</script>


<?php get_footer(); ?>