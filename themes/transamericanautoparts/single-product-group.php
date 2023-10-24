<?php get_header();

// This page should have a prefix
$page_prefix = prefix() . '-product-group';

// Get the fields we need for the main Product Group summary section
$product_group_id = get_field('product_group_id');
$pg_features_list = get_field('long_description');
$pg_features_array = explode(";",$pg_features_list);
$description = get_field('sales_description');


// Get the SKUs that belong to this Product Group. We're ordering by Price, so that the first SKU is the lowest priced one. 
$skus = get_posts(array(
            'numberposts'   => -1,
            'post_type'     => 'products',
            'meta_key'      => 'product_group_id',
            'meta_value'    => $product_group_id,
            'orderby'       => 'order_clause',
            'order'         => 'ASC',
            'meta_query' => array(
                'order_clause' => array(
                    'key' => 'display_price',
                )
            )
        )); 


// If there is only one SKU, redirect to that SKU page
if(count($skus) === 1) {
    $redirect = 'Location: ' . get_permalink($skus[0]);
    header($redirect, TRUE, 301);
    exit();
}


// Because the first SKU is the lowest price, we can use its price as the "From" price in the Product Group summary section.
$first_sku = $skus[0];
$lowest_price = get_field('display_price', $first_sku);

// Let's get the main image from the first sku, so that we can use that in the main image space. Then allow for it to be overriden by a custom field
$first_image = get_field('main_image_link', $first_sku);
$lead_image_override = get_field('lead_image_override');

if($lead_image_override) {
    $lead_image = $lead_image_override['url'];
} else {
    $lead_image = $first_image;
}
//



//Let's prep the SKUs for Javascript. We're going to be displaying them below, filtered by whether there is a SKU that fits the user's current vehicle.

$skus_array = array();
foreach($skus as $sku) {

    // All the fields
    $sku_fields = get_fields($sku);

    // The other fields we need to display
    $main_image_link = $sku_fields['main_image_link'];
    $part_number = $sku_fields['part_number'];
    $price = $sku_fields['display_price'];
    $features_list = str_replace(';;', ';', $sku_fields['long_description']);
    $features_list = str_replace('""', '', $features_list);
    $features_array = explode(";",$features_list);

    // Fitment comes in as a string of comma separated vehicle IDs. We want them as an array, so they can be looked through to find if the users current vehicle matches one of the values.
    $fitment = $sku_fields['vehicle_ids'];
    $fitment = explode(',', $fitment);
    $fitment = (array_map('strtolower', $fitment));


    /*
     * Let's also get the Vehicle/Engine Fitments for this product
     */
    $sku_engines_field = $sku_fields['vehicle_qualifiers_engine'];
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

    // Add all the necessary fields to a single array for the SKU
    $sku_array = array($sku->ID, $sku->post_title, get_permalink($sku), $fitment, $part_number, $price, $features_array, $main_image_link, $engines );

    // Push it into the SKUs array
    array_push($skus_array, $sku_array);

    wp_reset_postdata();
}

?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <main class="<?=prefix()?>-single-product <?=$page_prefix?>">
        <div class="container">
            <div class="<?=prefix()?>-single-product-breadcrumbs">
                <?php
                if ( function_exists('yoast_breadcrumb') ) {
                  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                }
                ?>
            </div>

            <!-- SUMMARY SECTION (Includes Images on the Left and Product Info on Right) -->
            <div class="<?=prefix()?>-product-group-summary">
                <div class="group group-flex">
                    <div class="c c-6 c-md-12">
                        <div class="<?=prefix()?>-single-product-summary__images">
                            <?php if($lead_image) { ?>
                                <img class="<?=$pod_prefix?>__image" src="<?=$lead_image?>" alt="">
                            <?php } else { ?>
                                <div style="height:200px; width: 100%;"></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="c c-6 c-md-12">
                        <div class="<?=prefix()?>-single-product-summary__meta">
                            <div class="<?=prefix()?>-single-product-summary__meta-content">
                                <h1 class="<?=prefix()?>-single-product-summary__meta-title"><?=get_the_title();?></h1>
                                <div class="<?=prefix()?>-single-product-summary__meta-features">
                                    <?php if($pg_features_list) { ?>
                                        <h2>Primary Features</h2>
                                        <ul>
                                            <?php foreach($pg_features_array as $feature) { ?>
                                                <li><?=$feature?></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                                <div class="<?=prefix()?>-single-product-summary__meta-cart">
                                    <div class="group">
                                        <div class="c c-12">
                                            <p class="<?=prefix()?>-single-product-summary__meta-cart__price">from $<?=$lowest_price?></p>
                                        </div>
                                        <div class="c c-12">
                                            <div class="<?=prefix()?>-single-product-summary__meta-cart__button-container">
                                              <a class="<?=prefix()?>-single-product-summary__meta-cart__button" href="#products">Select Products Below</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- DETAILS SECTION -->
            <div class="<?=prefix()?>-single-product-details">
                <div class="<?=prefix()?>-single-product-details__navigation alignfull" style="height: 68px;">
                </div>
                <div class="<?=prefix()?>-single-product-details__content">
                    <a id="products"></a>
                    <?php if($description) { ?>
                        <div class="<?=prefix()?>-single-product-details__content__section description">
                            <h2>Description</h2>
                            <p><?=$description?></p>
                        </div>
                    <?php } ?>
                    <div class="<?=prefix()?>-single-product-details__content__section description">
                        <h2 id="<?=$page_prefix?>_products">Products</h2>
                        <div id="skus-that-fit" class="alignwide"></div>
                        <div id="skus-that-do-not-fit" class="skus-that-do-not-fit"></div>


                    <script>
                            let myVehicle = localStorage.getItem("myVehicle");
                            let myEngine = localStorage.getItem("myVehicleEngine");
                            let myVehicleName = localStorage.getItem('myVehicleName') + ' ' + localStorage.getItem('myVehicleSubmodel');
                            let skus = <?=json_encode($skus_array)?>;

                            if (localStorage.getItem("myVehicle") === null) {
                                myVehicle = 'null';
                                myEngine = 'null';
                                console.log('no vehicle selected');
                            } else if (localStorage.getItem("myVehicle") !== null) {
                                console.log('I have a vehicle selected');
                            }


                            for(let i=0; i < skus.length; i++) {
                                let VehicleFit = skus[i][3];
                                let ProductName = skus[i][1];
                                let ProductLink = skus[i][2];
                                let ProductPartNumber = skus[i][4];
                                let ProductPrice = '$' + skus[i][5];
                                let ProductFeatures = skus[i][6];
                                let ProductImage = skus[i][7];
                                let enginesFit = skus[i][8];
                                let rowPrefix = '<?=prefix()?>-product-row';

                                let fitsMyVehicleAndEngine = false;
                                let fitsMyVehicleAndEngineNull = false;
                                let engineFitCount = enginesFit.length;

                                for( let j = 0; j<engineFitCount; j++ ) {
                                    let loopVehicleID = parseInt(enginesFit[j].vehicle_id);
                                    let loopEngine = enginesFit[j].engine.toLowerCase();
                                    let engineLength = enginesFit[j].engine.length;
                                    let engineEmpty = 'null';

                                    var fitsMyVehicle = false;
                                    var fitsMyEngine = false;
                                    var engineNull = false;


                                    if ( loopVehicleID === parseInt(myVehicle) ) {
                                        var fitsMyVehicle = true;
                                    }

                                    if ( loopEngine === myEngine.toLowerCase() ) {
                                        var fitsMyEngine = true;
                                    }

                                    if ( loopEngine === engineEmpty.toLowerCase() ) {
                                        var engineNull = true;
                                    }

                                    if ( parseInt(myVehicle) === loopVehicleID && myEngine.toLowerCase() === loopEngine ) {
                                        fitsMyVehicleAndEngine = true;
                                    }

                                    if ( fitsMyVehicle === true && engineNull === true ) {
                                        fitsMyVehicleAndEngineNull = true;
                                    }

                                }


                                if ( VehicleFit.includes('uni') ) {
                                    ProductFeatures.unshift('Not Vehicle Specific');
                                } else {
                                    ProductFeatures.unshift('Direct Fit');
                                }

                                if ( fitsMyVehicleAndEngine == true ||  fitsMyVehicleAndEngineNull == true ) {

                                    console.log('this item fits my vehicle and engine');

                                    let FitDiv = document.createElement("div");
                                    FitDiv.setAttribute("class", "container <?=prefix()?>-product-row fits-my-vehicle");
                                    const innerHTML1 = `
                                            <div class="group group-flex">
                                                <div class="c c-4">
                                                    <img class="${rowPrefix}__image" src="${ProductImage}" alt="${ProductName}">
                                                </div>
                                                    <div class="c c-4">
                                                    <div class="${rowPrefix}__content">
                                                        <h3 class="${rowPrefix}__title"><br>${ProductName}</h3>
                                                        <p class="${rowPrefix}__part-number">Part #${ProductPartNumber}</p>
                                                        <h4>Primary Features</h4>
                                                        <ul id="${ProductPartNumber}-features">
                                    `;
                                    const innerHTML2 = `                    
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="c c-4">
                                                    <div class="${rowPrefix}__price">
                                                        <p class="TAP-single-product-summary__meta-cart__price">${ProductPrice}</p>
                                                    </div>
                                                    <div class="TAP-single-product-summary__meta-cart__button-container">
                                                        <a class="TAP-single-product-summary__meta-cart__button" href="${ProductLink}">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                    `;

                                    FitDiv.innerHTML = innerHTML1 + innerHTML2;
                                    const element = document.getElementById("skus-that-fit");
                                    element.classList.add("skus-that-fit");
                                    element.appendChild(FitDiv);

                                } else {

                                    console.log('this item does not fit my vehicle and engine');

                                    const NoFitDiv = document.createElement("div");
                                    NoFitDiv.setAttribute('class', '<?=prefix()?>-product-row' )
                                    const innerHTML1 = `
                                        <div class="group group-flex">
                                            <div class="c c-4">
                                                <img class="${rowPrefix}__image" src="${ProductImage}" alt="${ProductName}">
                                            </div>
                                                <div class="c c-4">
                                                <div class="${rowPrefix}__content">
                                                    <h3 class="${rowPrefix}__title"><br>${ProductName}</h3>
                                                    <p class="${rowPrefix}__part-number">Part #${ProductPartNumber}</p>
                                                    <h4>Primary Features</h4>
                                                    <ul id="${ProductPartNumber}-features">
                                    `;
                                    const innerHTML2 = `
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="c c-4">
                                                <div class="${rowPrefix}__price">
                                                    <p class="TAP-single-product-summary__meta-cart__price">${ProductPrice}</p>
                                                </div>
                                                <div class="TAP-single-product-summary__meta-cart__button-container">
                                                    <a class="TAP-single-product-summary__meta-cart__button" href="${ProductLink}">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    NoFitDiv.innerHTML = innerHTML1 + innerHTML2;
                                    const element = document.getElementById("skus-that-do-not-fit");
                                    element.appendChild(NoFitDiv);

                                }

                                for(let i=0; i < ProductFeatures.length; i++) {
                                        var ul = document.getElementById(ProductPartNumber + '-features');
                                        var li = document.createElement("li");
                                        li.innerHTML = ProductFeatures[i];
                                        ul.appendChild(li);
                                        
                                }

                            }


                            // Let's create the element for the Success Banner, to be added when applicable.
                            const FitVehiclesBanner = document.createElement("div");
                            const innerHTML = `
                                <div class="container">
                                    <div class="group">
                                        <div class="c c-7">
                                            <div class="group group-flex">
                                                <div class="c c-2 <?=prefix()?>-single-product-summary__meta-vehicle-fit__icon">
                                                        <i class="fas fa-check"></i>
                                                </div>
                                                <div class="c c-10 <?=prefix()?>-single-product-summary__meta-vehicle-fit__info">
                                                    <div class="<?=prefix()?>-single-product-summary__meta-vehicle-fit__message">The following items fit your <span>${myVehicleName}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            FitVehiclesBanner.innerHTML = innerHTML;

                            let FitDiv = document.getElementById("skus-that-fit");

                            // The div that has SKUS that fit will only have any Child Nodes if SKUs are dynamically added, meaning that some items will fit, so let's show the element we created for the banner.
                            if (FitDiv.hasChildNodes()) {
                                console.log('true');

                                const element = document.getElementById("skus-that-fit");
                                element.insertBefore(FitVehiclesBanner, element.firstChild);


                            } else {
                                console.log('false');
                            }



                            // If the first SKU has Universal Fit (which means that all SKUs will have Universal Fit), then do nothing (but maybe log in the console that the products are Universal)
                            if (skus[0][3].includes('uni')) {
                                console.log('universal products');

                                const UniversalFitIcon = document.createElement('div');
                                UniversalFitIcon.setAttribute('class', 'universal-fit-logo-wrapper TAP-single-product-summary__meta-vehicle-fit no-vehicle');
                                UniversalFitIcon.innerHTML = '<div>This item is Not Vehicle Specific<img class="universal-fit-logo" src="<?=get_template_directory_uri()?>/images/universal-fit-logo.webp" alt="Universal Fit Icon"></div>';
                                const element = document.getElementById('skus-that-do-not-fit');
                                element.insertBefore(UniversalFitIcon, element.firstChild);


                            

                            // If the user does not have a Vehicle Set in local storage, then we'll show the banner that encourages the user to set their vehicle to see what will fit.
                            } else if (localStorage.getItem("myVehicle") === null) {
                                const NoVehicleSelected = document.createElement('div');
                                NoVehicleSelected.setAttribute("class", "TAP-single-product-summary__meta-vehicle-fit no-vehicle");
                                NoVehicleSelected.setAttribute("id", "TAP-single-product-summary__meta-vehicle-fit");
                                NoVehicleSelected.innerHTML = '<a id="product-group-no-vehicle-button" href="#vehicle-select-modal" rel="modal:open">Set your vehicle to see items that fit.<span>Click Here</span></a>';
                                const element = document.getElementById('skus-that-do-not-fit');
                                element.insertBefore(NoVehicleSelected, element.firstChild);

                            // Otherwise (if a vehile is set, and if the SKUs are not Universal Fit), then we'll show the No Fit banner with option to change vehicle at the top of the section of SKUs that don' fit.
                            } else {
                                const NoFitButton = document.createElement('div');
                                NoFitButton.innerHTML = `
                                    <div class="group">
                                        <div class="c c-7">
                                            <div class="group group-flex">
                                                <div class="c c-2 <?=prefix()?>-single-product-summary__meta-vehicle-fit__icon">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                                <div class="c c-10 <?=prefix()?>-single-product-summary__meta-vehicle-fit__info">
                                                    <div class="c c-9 <?=prefix()?>-single-product-summary__meta-vehicle-fit__message">The following items <em>do not fit</em> your <span> ${myVehicleName}</span>
                                                    </div>
                                                    <div class="c c-3 <?=prefix()?>-single-product-summary__meta-vehicle-fit__action">
                                                    <a href="#vehicle-select-modal" rel="modal:open"><span>Change<br>Vehicle</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                const element = document.getElementById('skus-that-do-not-fit');
                                element.insertBefore(NoFitButton, element.firstChild);
                            }


                            if ($( ".skus-that-fit" ).children().length > 1 ) {
                                $(".skus-that-do-not-fit").css('display', 'none');
                            }

                    </script>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php endwhile; endif; ?>


<?php get_footer(); ?>