<?php include(get_theme_file_path().'/blocks/blocks.settings.php'); 

$prefix = prefix() . '-explorer-selector';

$uploads_dir = wp_get_upload_dir();
$primary_bg_image = $uploads_dir['baseurl'] . '/2022/07/Group-35614.jpg';
$secondary_bg_image = $uploads_dir['baseurl'] . '/2022/07/Group-35620.jpg';

// We need it here too, so this is the CSV of the explorer applications and skus, turned into an array.
$rows   = array_map('str_getcsv', file(get_theme_file_path().'/files/explorer-application-spreadsheet.csv'));
//Get the first row that is the HEADER row.
$header_row = array_shift($rows);
//This array holds the final response.
$explorer_csv    = array();
foreach($rows as $row) {
    if(!empty($row)){
        $explorer_csv[] = array_combine($header_row, $row);
    }
}

// And this holds just the vehicle IDs
$explorer_vehicle_ids = array();
foreach($explorer_csv as $ec_row) {
    $vid = explode(',',$ec_row['vehicle_id']);
    foreach($vid as $id) {
        $explorer_vehicle_ids[] = $id;
    }
}

// Now make the vehicle ID array unique
$explorer_vehicle_ids = array_unique($explorer_vehicle_ids);
$imploded = implode(',',$explorer_vehicle_ids);
$explorer_vehicle_ids = explode(',',$imploded);


// We need the vehicles from WP
$explorer_vehicles = get_posts(array(
    'numberposts'   => -1,
    'post_type'     => 'vehicle',
    'meta_query'    => array(
        array(
            'key'       => 'vehicle_id',
            'value'     => $explorer_vehicle_ids,
            'compare'   => 'IN',
        ),
    ),
));

// We need a list of years, makes, and models
$explorer_years = [];
$explorer_makes = [];
$explorer_models = [];
$explorer_submodels = [];

if($explorer_vehicles) {
    foreach($explorer_vehicles as $ev) {
        $fields = get_fields($ev);
        $ev_vehicle_id = $fields['vehicle_id'];
        $ev_year = $fields['year_id'];
        $ev_make = $fields['make_name'];
        $ev_model = $fields['model_name'];

        $explorer_years[] = $ev_year;
        $explorer_makes[] = $ev_make;
        $explorer_models[] = $ev_model;
        $explorer_submodels[] = $ev_submodel;
    }
}

$explorer_years = array_unique($explorer_years);
rsort($explorer_years);

$explorer_makes = array_unique($explorer_makes);

$explorer_models = array_unique($explorer_models);

$explorer_submodels = array_unique($explorer_submodels);


// We're gonna need product data for recommended wheels
$wheels_rows   = array_map('str_getcsv', file(get_theme_file_path().'/files/explorer-wheels.csv'));
//Get the first row that is the HEADER row.
$wheels_header_row = array_shift($wheels_rows);
//This array holds the final response.
$explorer_wheels    = array();
foreach($wheels_rows as $wheel) {
    if(!empty($wheel)){
        $explorer_wheels[] = array_combine($wheels_header_row, $wheel);
    }
}


// We're gonna need product data for recommended tires as well
$tires_rows   = array_map('str_getcsv', file(get_theme_file_path().'/files/explorer-tires.csv'));
//Get the first row that is the HEADER row.
$tires_header_row = array_shift($tires_rows);
//This array holds the final response.
$explorer_tires    = array();
foreach($tires_rows as $tire) {
    if(!empty($tire)){
        $explorer_tires[] = array_combine($tires_header_row, $tire);
    }
}

?>
<a name="explorer-start"></a>
<div class="<?=$prefix?> <?=$all_classes?> alignfull no-bottom-margin">
    <div class="<?=$prefix?>__slides">

        <div id="vehicle" data-title="Select Vehicle" class="<?=$prefix?>__slide" style="background-image:url(<?=$primary_bg_image?>)">
            <div id="<?=$prefix?>__vehicle-selector-wrapper" class="<?=$prefix?>__vehicle-selector-wrapper">
                <h2 id="<?=$prefix?>__vehicle-selector-heading" class="no-bottom-margin">Configure Your Truck/SUV</h2>
                <p id="<?=$prefix?>__vehicle-selector-description">Tell Us About Your Vehicle.</p>
                <div class="<?=$prefix?>__vehicle-selector">
                    <?php 
                    
                    ?>

                    <form id="<?=$prefix?>__vehicle-select-form" class="<?=prefix()?>-vehicle-select-form">
                        <select name="explorer_select_year" id="explorer_select_year" required>
                           <option value="0">Year</option>
                           <?php 
                                foreach($explorer_years as $year) {
                              // Option
                              echo "<option value='".$year."' >".$year."</option>";
                           } ?>
                        </select>
                        <select disabled id="explorer_select_make" required>
                           <option value="0">Make</option>
                        </select>
                        <select disabled id="explorer_select_model" required>
                           <option value="0">Model</option>
                        </select>
                        <select disabled id="explorer_select_vehicle" required>
                           <option value="0">Submodel</option>
                        </select>
                        <select disabled id="explorer_select_engine" required>
                           <option value="0">Engine</option>
                        </select>
                        <div class="clear"></div>
                        <button disabled class="<?=prefix()?>-button vehicle-form-button" onclick="explorerSetVehicle()" type="button">See Explorer Systems</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="kit" data-title="Select System" class="<?=$prefix?>__slide" style="background-image:url(<?=$secondary_bg_image?>)">
            <div class="<?=$prefix?>__vehicle-selector-wrapper">
                

                <div class="<?=$prefix?>__vehicle-selector__back-button-wrapper">
                    <button onclick="explorerPrevSlide()" class="<?=$prefix?>__vehicle-selector__back-button">Back to <em>Select Vehicle</em></button>
                </div>
            </div>
        </div>

        <div id="upgrade" data-title="UCA Upgrade" class="<?=$prefix?>__slide" style="background-image:url(<?=$secondary_bg_image?>)">
            <div class="<?=$prefix?>__vehicle-selector-wrapper">
                <div class="explorer-system-pod__header" style="background-image: url(<?=get_site_url()?>/wp-content/uploads/2022/07/500_5357-1-1.jpg)">
                    <h2 id="<?=$prefix?>__vehicle-selector-heading" class="no-bottom-margin">Upgrade to Pro Series High<br>Angle Upper Control Arms</h2>
                </div>
                <div class="explorer-upgrade-selector__content">
                    <div class="explorer-upgrade-selector__content-top explorer-system-pod__content-section">
                        <img src="<?=get_site_url()?>/wp-content/uploads/2022/07/51042B-01-copy.jpg" alt="Upper Control Arms">
                        <div class="explorer-upgrade-selector__content-details">
                            <ul>
                                <li>Strength of a race-style uni-ball arm</li>
                                <li>Increased strength and wheel travel</li>
                                <li>Optimized alignment and geometry for the lifted application</li>
                                <li>Low maintence</li>
                            </ul>
                            <h2 id="upgrade-price"></h2>
                        </div>
                    </div>
                    <div class="explorer-upgrade-selector__buttons">
                        <button class="TAP-button TAP-button--alt" upgrade="no" onclick="explorerUpgradeButton(this)">No Thanks, Continue Without UCA Upgrade</button>
                        <button class="TAP-button" upgrade="yes" onclick="explorerUpgradeButton(this)">Yes! Add UCA Upgrade</button>
                    </div>
                </div>
                <div class="<?=$prefix?>__vehicle-selector__back-button-wrapper">
                    <button onclick="explorerPrevSlide()" class="<?=$prefix?>__vehicle-selector__back-button">Back to <em>Select System</em></button>
                </div>
            </div>
        </div>

        <div id="wheels" data-title="Select Wheels" class="<?=$prefix?>__slide" style="background-image:url(<?=$secondary_bg_image?>)">
            <div class="<?=$prefix?>__vehicle-selector-wrapper">
                <div class="explorer-system-pod__header" style="background-image: url(<?=get_site_url()?>/wp-content/uploads/2022/07/500_5357-1-1-2.jpg)">
                    <h2 id="<?=$prefix?>__vehicle-selector-heading" class="no-bottom-margin">Your Wheel Specifications</h2>
                </div>
                <div class="explorer-upgrade-selector__content">
                    <div class="explorer-upgrade-selector__content-top explorer-system-pod__content-section explorer-wheels-selector__specifications">
                        <p>For Your <span class="model-name">{MODEL NAME}</span>, Pro Comp requires the following Wheel Specifications:</p>
                        <ul>
                            <li>Wheel Diameter: <span id="wheel-diameter">null</span></li>
                            <li>Wheel Width: <span id="wheel-width">null</span></li>
                            <li>Offset: <span id="offset">null</span></li>
                            <li>Bolt Pattern: <span id="bolt-pattern">null</span></li>
                        </ul>
                    </div>
                    <div id="wheels-options" class="explorer-upgrade-selector__content-top explorer-wheels-selector__options">
                        <p>Items available at 4wheelparts.com:</p>
                        <div class="options-list">
                        </div>
                    </div>
                    <div class="explorer-upgrade-selector__buttons">
                        <button id="wheel-no" class="TAP-button TAP-button--alt" onclick="explorerNextSlide()">No Thanks, I'll Choose My Own Wheels</button>
                        <button id="wheel-selected" disabled class="TAP-button" onclick="wheelSelected()">Continue With Selected Wheels</button>
                    </div>
                </div>

                <div class="<?=$prefix?>__vehicle-selector__back-button-wrapper">
                    <button onclick="explorerPrevSlide()" class="<?=$prefix?>__vehicle-selector__back-button">Back to <em>UCA Upgrade</em></button>
                </div>
            </div>
        </div>

        <div id="tires" data-title="Select Tires" class="<?=$prefix?>__slide" style="background-image:url(<?=$secondary_bg_image?>)">
            <div class="<?=$prefix?>__vehicle-selector-wrapper">
                <div class="explorer-system-pod__header" style="background-image: url(<?=get_site_url()?>/wp-content/uploads/2022/07/500_5357-1-2.jpg)">
                    <h2 id="<?=$prefix?>__vehicle-selector-heading" class="no-bottom-margin">Your Tire Specifications</h2>
                </div>
                <div class="explorer-upgrade-selector__content">
                    <div class="explorer-upgrade-selector__content-top explorer-system-pod__content-section explorer-wheels-selector__specifications">
                        <p>For Your <span class="model-name">{MODEL NAME}</span>, Pro Comp requires the following Tire Specifications:</p>
                        <ul>
                            <li>Tire Size: <span id="tire-size">null</span></li>
                            <li>Recommended Load Range: <span id="load-range">null</span></li>
                        </ul>
                    </div>
                    <div id="wheels-options" class="explorer-upgrade-selector__content-top explorer-wheels-selector__options">
                        <p>Items available at 4wheelparts.com:</p>
                        <div class="options-list">
                        </div>
                    </div>
                    <div class="explorer-upgrade-selector__buttons">
                        <button id="tire-no" class="TAP-button TAP-button--alt" onclick="explorerNextSlide()">No Thanks, I'll Choose My Own Tires</button>
                        <button id="tire-selected" disabled class="TAP-button" onclick="tireSelected()">Continue With Selected Tires</button>
                    </div>
                </div>

                <div class="<?=$prefix?>__vehicle-selector__back-button-wrapper">
                    <button onclick="explorerPrevSlide()" class="<?=$prefix?>__vehicle-selector__back-button">Back to <em>Select Wheels</em></button>
                </div>
            </div>
        </div>

        <div id="summary" data-title="Build Summary" class="<?=$prefix?>__slide" style="background-image:url(<?=$secondary_bg_image?>)">
            <div class="<?=$prefix?>__vehicle-selector-wrapper">
                <div class="explorer-system-pod__header" style="background-image: url(<?=get_site_url()?>/wp-content/uploads/2022/07/500_5357-1-3.jpg)">
                    <h2 id="<?=$prefix?>__vehicle-selector-heading" class="no-bottom-margin">Build Summary</h2>
                </div>
                <div class="explorer-upgrade-selector__content">
                    <div class="explorer-upgrade-selector__content-top explorer-system-pod__content-section explorer-wheels-selector__specifications">
                        <p>Congratulations! Your <span class="model-name">{MODEL NAME}</span> equipped with an Explorer Series Suspension system is READY!<br>Here are the details:</p>
                    </div>
                    <div class="explorer-upgrade-selector__content-middle explorer-system-pod__content-section explorer-summary-selector__details">
                        <ul class="explorer-summary-selector__details-list">
                            <li class="summary-item vehicle"><strong>Vehicle: </strong><span class="summary-vehicle-name">None Selected</span><li>
                            <li class="summary-item system"><strong>Selected System: </strong><span class="summary-system">None Selected</span><li>
                            <li class="summary-item price"><strong>System Price: </strong><span class="sku-price">None Selected</span><li>
                            <li class="summary-item wheel-specs"><strong>Wheel Specifications: </strong><span class="summary-wheel-specs">None Selected</span><li>
                            <li class="summary-item selected-wheels"><strong>Selected Wheels: </strong><span class="summary-selected-wheels">None Selected</span><li>
                            <li class="summary-item tire-specs"><strong>Tire Specifications: </strong><span class="summary-tire-specs">None Selected</span><li>
                            <li class="summary-item selected-tires"><strong>Selected Tires: </strong><span class="summary-selected-tires">None Selected</span><li>
                        </ul>
                        <div class="explorer-summary-selector__details-sku">
                        </div>
                    </div>
                    <div class="explorer-upgrade-selector__buttons">
                        <a class="TAP-button TAP-button--alt" href="https://www.4wheelparts.com/stores/find-a-store" target="_blank">Find a 4 Wheel Parts Store</a>
                        <a id="email-modal-button" href="#email-modal" rel="modal:open" class="TAP-button">Email Me My Build Summary</a>
                    </div>
                    <p class="explorer-summary-selector__bottom">Pro Comp recommends you have your parts installed by a certified installer at a 4 Wheel Parts store.
                </div>

                <div class="<?=$prefix?>__vehicle-selector__back-button-wrapper">
                    <button onclick="explorerPrevSlide()" class="<?=$prefix?>__vehicle-selector__back-button">Back to <em>Select Tires</em></button>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="explorer-selected" class="hidden" application-skus="" system-sku="" product-grade="" upgrade="" selected-sku="" wheel-specs="" selected-wheels="" tire-specs="" selected-tires="">
</div>
<div id="email-modal" class="modal">
    <h2>Email Your Explorer LCG Build Summary</h2>
  <form target="_blank" id="explorer-email-form" method="post" action="https://enews.procompusa.com/q/gpbRP4vH87noAhn7nJAbJ__r7y9Ly7w7ZVGnXvh0fbC0ydzKSTPcbJSuA" accept-charset="UTF-8">
  <input type="hidden" name="crvs" value="PX7jvFGNO43NPmdSU0Wrh7Gva0y5Wn8SD-GdGUAIarDET6qZH2-vxOdMxva5gHntc1fPv3m2CeM5jypuixtz-g"/>
    
      <!-- These next 3 fields are for system use, please do Not remove -->
      <input type="text" name="ABC" size="10" maxlength="10" value="" tabindex="-1" autocomplete="off" style="float: left !important; position:absolute !important; left:-9000px !important; top: -9000px !important;"/>
      <input type="text" name="XYZ" size="10" maxlength="10" value="" tabindex="-1" autocomplete="off" style="float: left !important; position:absolute !important; left:-9000px !important; top: -9000px !important;"/>
      <input type="text" name="AtZ" size="10" maxlength="10" value="" tabindex="-1" autocomplete="off" style="float: left !important; position:absolute !important; left:-9000px !important; top: -9000px !important;"/></td>
    
      <div class="explorer-form-name">
        <input type="text" name="Customer Demographics.First Name" placeholder="First Name" maxlength="50" size="40" value=""/>
        <input type="text" name="Customer Demographics.Last Name" placeholder="Last Name" maxlength="50" size="40" value=""/>
      </div>
      <input type="text" name="Customer Demographics.Postal Code" placeholder="Zip Code" maxlength="50" size="40" value=""/>
      <input type="text" name="email" size="40" placeholder="Email Address" maxlength="100" value=""/>
      <input hidden type="text" name="Vehicle Information.Year_1" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Make_1" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Model_1" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Submodel_1" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Engine" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Vehicle ID" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Engine ID" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Selected Kit SKU" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Sku_Image_URL" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Selected Kit Description" maxlength="50" size="40" value=""/>
      <input hidden type="checkbox" name="CheckBox.Vehicle Information.Includes UCA Upgrade" value="off"/>
      <input hidden type="text" name="Vehicle Information.Wheel Specifications" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Select Wheel SKU" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Tire Specifications" maxlength="50" size="40" value=""/>
      <input hidden type="text" name="Vehicle Information.Select Tire SKU" maxlength="50" size="40" value=""/>
      <td align="left"><a class="TAP-button" type="submit" onclick="emailFormSubmit()" id="email-form-close" href="#close" rel="modal:close">Submit</a>

        <!-- <input class="TAP-button" type="submit" id="submit" value="Submit"/> -->
    </td>
</form>


</div>



<script>
    // Here are some variables we'll need
    const explorerVehicleIDs = <?=json_encode($explorer_vehicle_ids)?>;
    const myVehicle = localStorage.getItem("myVehicle");
    const myVehicleName = localStorage.getItem("myVehicleName");
    const myVehicleModel = localStorage.getItem("myVehicleModel");
    const myVehicleYear = localStorage.getItem("myVehicleYear");
    const ExplorerNoFitHTML = `
        <div class="group group-flex <?= prefix() ?>-single-product">
            <div class="c c-2 TAP-single-product-summary__meta-vehicle-fit__icon no-fit">
                <i class="fas fa-times" aria-hidden="true"></i>
            </div>
            <div class="c c-10 TAP-single-product-summary__meta-vehicle-fit__info">
                <div class="TAP-single-product-summary__meta-vehicle-fit__message">Explorer LCG Systems <em>do not fit</em> your <span>${localStorage.getItem("myVehicleName")}</span>
                </div>
            </div>
        </div>
        <p class="align-center">Select a New Vehicle to Continue</p>
    `;


    // Save the Vehicle to Local Storage
        function explorerSetVehicle() {
            var myVehicle = document.getElementById("explorer_select_vehicle").value;
            var myYear = $("#explorer_select_year option:selected").html();
            var myMake = $("#explorer_select_make option:selected").html();
            var myModel = $("#explorer_select_model option:selected").html();
            var mySubmodel = $("#explorer_select_vehicle option:selected").html();
            var myEngine = $("#explorer_select_engine option:selected").html();
            var myVehicleName = myYear + ' ' + myMake + ' ' + myModel;
            localStorage.setItem("myVehicle", myVehicle);
            localStorage.setItem("myVehicleName", myVehicleName);
            localStorage.setItem("myVehicleYear", myYear);
            localStorage.setItem("myVehicleMake", myMake);
            localStorage.setItem("myVehicleModel", myModel);
            localStorage.setItem("myVehicleSubmodel", mySubmodel);
            localStorage.setItem("myVehicleEngine", myEngine);
            $("#header-current-vehicle").html(myVehicleName);
            $('span.model-name').html(localStorage.getItem('myVehicleModel'));
            putUCABack();
            explorerNextSlide();
            explorerSwapSelectorFit();
            explorerGetSkus();
            $('.explorer-system-pod').remove();
            $("#header-current-vehicle").html(myVehicleName);
            return false;
        }


        function explorerNextSlide() {
            $('.slick-active').next().removeClass('disabled');
            $(".TAP-explorer-selector__slides").slick('slickNext');
            const mq = window.matchMedia( "(min-width: 960px)" );
        }

        function explorerPrevSlide() {
            $(".TAP-explorer-selector__slides").slick('slickPrev');
        }


        function explorerSelectSystem(obj) {
            var productGrade = obj.getAttribute("product-grade");
            var systemSku = obj.getAttribute("data-attribute");
            var systemSkuPrice = obj.getAttribute("price");
            var explorerSelected = $("#explorer-selected");

            if (skuBaseUCA) {
                var baseUCAPrice = skuBaseUCA['price'];
            }

            if (skuProUCA) {
                var proUCAPrice = skuProUCA['price'];
            }

            if (skuProUCAPlus) {
                var proUCAPlusPrice = skuProUCAPlus['price'];
            }

            explorerSelected.attr('product-grade', productGrade);
            explorerSelected.attr('system-sku', systemSku);
            
            $('button[upgrade="no"]').attr('sku', systemSku);
            $('button[upgrade="yes"]').attr('sku', explorerSelected.attr(productGrade + "-uca"));

            if (skuBaseUCA || skuProUCA) {
                console.log('there is a UCA')
                if(productGrade == 'base' && skuBaseUCA) {
                    var ucaPrice = baseUCAPrice;
                } else if (productGrade == 'pro' && skuProUCA) {
                    var ucaPrice = proUCAPrice;
                } else if (productGrade == 'pro-plus' && skuProUCAPlus) {
                    var ucaPrice = proUCAPlusPrice;
                } 
                var upgradePriceDifference = '+ $755.99';
                $('#upgrade-price').html(upgradePriceDifference);
            } else {
                console.log('there is no uca');
                var selectedSku = skus.find(item => item.part_number === systemSku);
                explorerTireWheelsSummary(selectedSku, 'no')
                
                if($('#upgrade').length > 0) {
                    $('.TAP-explorer-selector__slides').slick('slickRemove',2);
                }
                $('ul.slider-dots li:not(.slick-active):nth-of-type(n+4)').addClass('disabled');
                $( "ul.slider-dots li span" ).on('click', function( e ) {
                if ($(this).parent().hasClass('disabled')) {
                        e.stopPropagation();
                    }
                });

            }

            // If Leaf selector exists, let's remove it because we may not need it on the next go round
            if($('#leaf').length > 0) {
                console.log('leaf exists');
                $('.TAP-explorer-selector__slides').slick('slickRemove',3);
            } else {
                console.log('leaf does not exist');
            }

            explorerNextSlide();


        }

        function explorerLeafButton(obj) {
            console.log(obj);
            var leafAttr = obj.getAttribute("leaf");
            console.log('Leaf: ' + leafAttr);
            var explorerSelected = $("#explorer-selected");
            if(leafAttr == 'yes') {
                var selectedSku = skus.find(item => item.part_number === explorerSelected.attr('selected-sku') + 'L');
            } else {
                selectedSku = skus.find(item => item.part_number === explorerSelected.attr('selected-sku'));

            }
            var upgradeAttr = explorerSelected.attr('leaf', leafAttr);




            explorerTireWheelsSummary(selectedSku, upgradeAttr)
            explorerNextSlide();
        }

        function explorerUpgradeButton(obj) {
            var upgradeAttr = obj.getAttribute("upgrade");
            var explorerSelected = $("#explorer-selected");

            explorerSelected.attr('upgrade', upgradeAttr);

            if (explorerSelected.attr('product-grade') == 'base') {
                if (upgradeAttr == 'yes') {
                    var selectedSku = skuBaseUCA;
                    explorerSelected.attr('selected-sku', selectedSku['part_number']);
                } else {
                    var selectedSku = skuBase;
                    explorerSelected.attr('selected-sku', selectedSku['part_number']);
                }

               


            } else if (explorerSelected.attr('product-grade') == 'pro') {
                if (upgradeAttr == 'yes') {
                    var selectedSku = skuProUCA;
                    explorerSelected.attr('selected-sku', selectedSku['part_number']);
                } else {
                    var selectedSku = skuPro;
                    explorerSelected.attr('selected-sku', selectedSku['part_number']);
                }

            }

            // Application Specific: Toyota 4Runner
            if (skus[0]['application'].includes('TOYOTA 4RUNNER')) { 
                if ($("#explorer-selected").attr('product-grade') == 'base') {
                    if (upgradeAttr == 'yes') {
                        var selectedSku = skuBaseUCA;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    } else {
                        var selectedSku = skuBase;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    }
                } else if ($("#explorer-selected").attr('product-grade') == 'pro') {
                    if (upgradeAttr == 'yes') {
                        var selectedSku = skuProUCA;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    } else {
                        var selectedSku = skuPro;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    }
                } else if ($("#explorer-selected").attr('product-grade') == 'pro-plus') {
                    var selectedSku = skuProPlus;
                    explorerSelected.attr('selected-sku', selectedSku['part_number']);

                    if (upgradeAttr == 'yes') {
                        var selectedSku = skuProUCAPlus;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    }
                }

            }


            // Application Specific: Toyota Tundra 07-21
            if (skus[0]['application'].includes('TOYOTA TUNDRA 07-21')) { 
                var showLeafSelector = true;
                if ($("#explorer-selected").attr('product-grade') == 'base') {
                    if (upgradeAttr == 'yes') {
                        var selectedSku = skuBaseUCA;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    } else {
                        var selectedSku = skuBase;
                        var showLeafSelector = false;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    }
                } else if ($("#explorer-selected").attr('product-grade') == 'pro') {
                    if (upgradeAttr == 'yes') {
                        var selectedSku = skuProUCA;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    } else {
                        var selectedSku = skuPro;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    }
                } else if ($("#explorer-selected").attr('product-grade') == 'pro-plus') {
                    var selectedSku = skuProPlus;
                    explorerSelected.attr('selected-sku', selectedSku['part_number']);

                    if (upgradeAttr == 'yes') {
                        var selectedSku = skuProUCAPlus;
                        explorerSelected.attr('selected-sku', selectedSku['part_number']);
                    }
                }

                if (showLeafSelector == true) {
                    var leafSelectorHTML = `
                    <div>
                        <div>
                            <div id="leaf" data-title="Add A Leaf Upgrade" class="<?=$prefix?>__slide" style="background-image:url(<?=$primary_bg_image?>)">
                                <div id="<?=$prefix?>__vehicle-selector-wrapper" class="<?=$prefix?>__vehicle-selector-wrapper">
                                    <div class="explorer-system-pod__header" style="background-image: url(<?=get_site_url()?>/wp-content/uploads/2022/07/500_5357-1-1.jpg)">
                                    <h2 id="<?=$prefix?>__vehicle-selector-heading" class="no-bottom-margin">Rear Add-A-Leafs Upgrade</h2>
                                    </div>
                                    <div class="explorer-upgrade-selector__content">
                                        <div class="explorer-upgrade-selector__content-top explorer-system-pod__content-section">
                                            <img src="https://images.procompusa.com/sku/Pro%20Comp%20Suspension/400x400/31223-01.jpg" alt="Rear Add-A-Leafs">
                                            <div class="explorer-upgrade-selector__content-details">
                                                <ul>
                                                    <li>Perfect solution for Pro Comp 2.5” Lifts</li>
                                                    <li>Constructed from carbon steel for maximum strength</li>
                                                    <li>Increases rear ground clearance</li>
                                                    <li>Strengthens existing leaf pack to support additional weight</li>
                                                </ul>
                                                <h2 id="upgrade-price">+ $227.97</h2>
                                            </div>
                                        </div>
                                        <div class="explorer-upgrade-selector__buttons">
                                            <button class="TAP-button TAP-button--alt" leaf="no" onclick="explorerLeafButton(this)">No Thanks, Continue Without Rear Add-A-Leafs Upgrade</button>
                                            <button class="TAP-button" leaf="yes" onclick="explorerLeafButton(this)">Yes! Add Add-A-Leafs Upgrade</button>
                                        </div>
                                    </div>
                                    <div class="<?=$prefix?>__vehicle-selector__back-button-wrapper">
                                        <button onclick="explorerPrevSlide()" class="<?=$prefix?>__vehicle-selector__back-button">Back to <em>UCA Upgrade</em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    var slideIndex = 2;

                    $('#wheels <?=$prefix?>__vehicle-selector__back-button em').html('Add-A-Leaf Upgrade');

                    if($('#leaf').length < 1) {
                        $(".TAP-explorer-selector__slides").slick('slickAdd', leafSelectorHTML, slideIndex);
                        $(".slider-dots li:nth-child(4) span").html('Add A Leaf Upgrade');
                        $('ul.slider-dots li:not(.slick-active):nth-of-type(n+5)').addClass('disabled');
                        $( "ul.slider-dots li span" ).on('click', function( e ) {
                        if ($(this).parent().hasClass('disabled')) {
                                e.stopPropagation();
                            }
                        });
                    }

                }
            }
            console.log('Selected Sku');
            console.log(selectedSku);

            
            explorerTireWheelsSummary(selectedSku, upgradeAttr)
            explorerNextSlide();
        }


        // Wheel, Tire and Summary stuff for either the upgrade button or if we skip upgrades
        function explorerTireWheelsSummary(selectedSku, upgradeAttr) {


            // Wheel Stuff
            $('span#bolt-pattern').html(selectedSku['bolt_pattern']);
            var wheelSizes = selectedSku['recommended_wheel_size'].split(/[Xx ]+/);
            $('span#wheel-diameter').html(wheelSizes[0] + '"');
            $('span#wheel-width').html(wheelSizes[1] + '"');
            $('span#offset').html(wheelSizes[2]);

            
            window.explorerAllWheels = <?= json_encode($explorer_wheels) ?>;
            let explorerWheelOptions = selectedSku['wheel_fitment_pn'].split(', ');
            var selectedSkuWheelOptions = explorerAllWheels.filter( obj => { return explorerWheelOptions.includes(obj.part_number) });


            if ($('#wheels .options-list').children().length < 1) {
                for( var i = 0; i<selectedSkuWheelOptions.length; i++){
                    let wheelOptionHTML = `
                        <div class="explorer-wt-option">
                            <div class="explorer-wt-option__top">
                                <img class="explorer-wt-option__image" src="${selectedSkuWheelOptions[i]['image']}">
                                <h3 class="explorer-wt-option__title">${selectedSkuWheelOptions[i]['display_name']}</h3>
                            </div>
                            <div class="explorer-wt-option__bottom">
                                <p class="explorer-wt-option__price">${selectedSkuWheelOptions[i]['price']}</p>
                                <button class="explorer-wt-option__button TAP-button" id="${selectedSkuWheelOptions[i]['part_number']}" class="radio-btn" type="button" onclick="wheelOptionButton(this)">Select</button>
                            </div>
                        </div>
                    `;
                    $('#wheels .options-list').append(wheelOptionHTML);
                }
            }

            console.log(selectedSkuWheelOptions.length);

            if (selectedSkuWheelOptions.length == 0) {
                $('#wheels .explorer-wheels-selector__options, #wheel-selected').remove();
                $('#wheel-no').removeClass('TAP-button--alt').html('Next: Tire Specifications').css({'width' : '50%', 'margin-top' : '3rem' });
            }



            // Tire Stuff
            tireSizes = selectedSku['recommended_tire_size'];
            const theTireSize = tireSizes.slice(0, tireSizes.indexOf(' '));
            const theLoadRange = tireSizes.slice(tireSizes.indexOf(' ') + 1);
            $('span#tire-size').html(theTireSize);
            $('span#load-range').html(theLoadRange);

            // Summary Stuff
            var summarySystemHTML = '#' + selectedSku['part_number'] + ' - ' + selectedSku['short_description'];
            $('span.summary-system').html(summarySystemHTML);
            $('span.sku-price').html(selectedSku['price']);
            $("#explorer-selected").attr('selected-sku', selectedSku['part_number']);
            $('span.summary-wheel-specs').html(selectedSku['recommended_wheel_size'] + ' with ' + selectedSku['bolt_pattern']);
            $('span.summary-tire-specs').html(selectedSku['recommended_tire_size']);

            var summarySkuRightImage = `
                <img src="https://images.procompusa.com/sku/Pro%20Comp%20Suspension/400x400/${selectedSku["part_number"]}-01.jpg" alt="${selectedSku['short_description']}">
            `;
            var summarySkuRightPar = `
                <p>${summarySystemHTML}</p>
            `;

            var summarySkuRightLink = `
                <a href="${selectedSku["product_url"]}" target="_blank">${summarySystemHTML}</a>
            `
            $('.explorer-summary-selector__details-sku').html(summarySkuRightImage);


            $('.explorer-summary-selector__details-sku').html(summarySkuRightImage);
            if(selectedSku["product_url"]) {
                $('.explorer-summary-selector__details-sku').append(summarySkuRightLink);
            } else {
                $('.explorer-summary-selector__details-sku').append(summarySkuRightPar);
            }


            window.explorerAllTires = <?= json_encode($explorer_tires) ?>;
            let explorerTireOptions = selectedSku['tire_fitment_pn'].split(', ');
            var selectedSkuTireOptions = explorerAllTires.filter( obj => { return explorerTireOptions.includes(obj.part_number) });


            if ($('#tires .options-list').children().length < 1) {
                for( var i = 0; i<selectedSkuTireOptions.length; i++){
                    let tireOptionHTML = `
                        <div class="explorer-wt-option">
                            <img class="explorer-wt-option__image" src="${selectedSkuTireOptions[i]['image']}">
                            <h3 class="explorer-wt-option__title">${selectedSkuTireOptions[i]['display_name']}</h3>
                            <p class="explorer-wt-option__price">${selectedSkuTireOptions[i]['price']}</p>
                            <button class="explorer-wt-option__button TAP-button" id="${selectedSkuTireOptions[i]['part_number']}" class="radio-btn" type="button" onclick="tireOptionButton(this)">Select</button>
                        </div>
                    `;
                    $('#tires .options-list').append(tireOptionHTML);
                }
            }

            if (selectedSkuTireOptions.length == 0) {
                $('#tires .explorer-wheels-selector__options, #tire-selected').remove();
                $('#tire-no').removeClass('TAP-button--alt').html('Next: Your Build Summary').css({'width' : '50%', 'margin-top' : '3rem' });
            }



            // Application Specific Stuff

                    // Ford Ranger
            if (skus[0]['application'] === 'FORD RANGER 19-22') {
                if(upgradeAttr === 'yes') {
                    var skuAlum = skus.find(item => item.product_modifier === 'aluminum-knuckles');
                    var skuSteel = skus.find(item => item.product_modifier === 'steel-knuckles');
                    var skuSummaryHTML = `<br>
                        <i>For Ford Rangers with Aluminum Knuckles:</i><br> #${skuAlum['part_number']} - ${skuAlum['short_description']}
                        <br><br>
                        <i>For Ford Rangers with Steel Knuckles:</i><br> #${skuSteel['part_number']} - ${skuSteel['short_description']}
                    `;
                    $('span.summary-system').html(skuSummaryHTML);
                    $('span.sku-price').html(skuAlum['price']);
                    var summarySkuRightImage = `
                        <img src="https://images.procompusa.com/sku/Pro%20Comp%20Suspension/400x400/${skuAlum["part_number"]}-01.jpg" alt="${skuAlum['short_description']}">
                    `;
                    var summarySkuRightPar = `
                        <p>${summarySystemHTML}</p>
                    `;
                    var summarySkuRightLink = `
                        <a href="${skuAlum["product_url"]}" target="_blank">${summarySystemHTML}</a>
                    `;
                    $('.explorer-summary-selector__details-sku').html(summarySkuRightImage);


                    $('.explorer-summary-selector__details-sku').html(summarySkuRightImage);
                    if(skuAlum["product_url"]) {
                        $('.explorer-summary-selector__details-sku').append(summarySkuRightLink);
                    } else {
                        $('.explorer-summary-selector__details-sku').append(summarySkuRightPar);
                    }
                }
                    // GM 1500
            } else if (skus[0]['application'].includes('GM 1500')) { 
                var vehicleYear = parseInt(localStorage.getItem('myVehicleYear'), 10);
                
                if ( vehicleYear >= 2014 && vehicleYear <= 2016 ) {
                    if ($("#explorer-selected").attr('product-grade') == 'base') {
                        if (upgradeAttr == 'yes') {
                            var skuGMSmall = skus.find(item => item.part_number === 'K1178MSU');
                            var skuGMLarge = skus.find(item => item.part_number === 'K1179MSU');
                        } else {
                            var skuGMSmall = skus.find(item => item.part_number === 'K1178MS');
                            var skuGMLarge = skus.find(item => item.part_number === 'K1179MS');
                        }
                    } else if ($("#explorer-selected").attr('product-grade') == 'pro') {
                        if (upgradeAttr == 'yes') {
                            var skuGMSmall = skus.find(item => item.part_number === 'K1178BXU');
                            var skuGMLarge = skus.find(item => item.part_number === 'K1179BXU');
                        } else {
                            var skuGMSmall = skus.find(item => item.part_number === 'K1178MSU');
                            var skuGMLarge = skus.find(item => item.part_number === 'K1177BX');
                            
                        }
                    }
                    var vehicleModel = localStorage.getItem('myVehicleMake') + ' ' + localStorage.getItem('myVehicleModel');
                    var skuSummaryHTML = `<br>
                        <i>For ${vehicleModel} with Small Taper Ball Joints:</i><br> #${skuGMSmall['part_number']} - ${skuGMSmall['short_description']}
                        <br><br>
                        <i>For ${myVehicleModel} with Large Taper Ball Joints:</i><br> #${skuGMLarge['part_number']} - ${skuGMLarge['short_description']}
                    `;

                    var gm1500SummaryNote = `<li clas="summary-item vehicle"><strong>Note: </strong><span class="summary-vehicle-name">${vehicleModel}s from 2014-2016 were built with either Small Taper Ball Joints or Large Taper Ball Joints. Before purchasing an Explorer LCG System, confirm the taper of your vehicle's ball joints.</span><li>
                    `;

                    // GM 1500 Summary Stuff
                     $('.explorer-summary-selector__details-list').prepend(gm1500SummaryNote);
                     $('span.summary-system').html(skuSummaryHTML);
                     $('span.sku-price').html(skuGMSmall['price']);
                     var summarySkuRightImage = `
                        <img src="https://images.procompusa.com/sku/Pro%20Comp%20Suspension/400x400/${skuGMSmall["part_number"]}-01.jpg" alt="${skuGMSmall['short_description']}">
                        `;
                     var summarySkuRightPar =  `
                        <p>${summarySystemHTML}</p>
                    `;
                     var summarySkuRightLink = `
                        <a href="${skuGMSmall["product_url"]}" target="_blank">${summarySystemHTML}</a>
                     `;

                    $('.explorer-summary-selector__details-sku').html(summarySkuRightImage);
                    if(skuGMSmall["product_url"]) {
                        $('.explorer-summary-selector__details-sku').append(summarySkuRightLink);
                    } else {
                        $('.explorer-summary-selector__details-sku').append(summarySkuRightPar);
                    }

                }
            }
        }


        // The function for the button if my vehicle already fits
        function explorerSeeSystems() {
            explorerGetSkus();
            putUCABack();
            explorerNextSlide();
        }


        function wheelOptionButton(obj) {
            $('#wheels .explorer-wt-option__button')
                .removeClass('radio-btn-selected TAP-button--alt')
                .addClass('radio-btn')
                .html('Select')
            ;
            $('#wheel-selected').removeAttr('disabled');



            $('#'+obj.id)
                .removeClass('radio-btn')
                .addClass('radio-btn-selected TAP-button--alt')
                .html('Selected')
            ;
        }


        function tireOptionButton(obj) {
            $('#tires .explorer-wt-option__button')
                .removeClass('radio-btn-selected TAP-button--alt')
                .addClass('radio-btn')
                .html('Select')
            ;
            $('#tire-selected').removeAttr('disabled');


            $('#'+obj.id)
                .removeClass('radio-btn')
                .addClass('radio-btn-selected TAP-button--alt')
                .html('Selected')
            ;
        }


        function wheelSelected() {
            let selectedWheelID = $('#wheels .radio-btn-selected').attr('id');
            let selectedWheel = explorerAllWheels.find(item => item.part_number === selectedWheelID);

            $('span.summary-selected-wheels').html(selectedWheel.display_name);

            explorerNextSlide();
        }

        function tireSelected() {
            let selectedTireID = $('#tires .radio-btn-selected').attr('id');
            let selectedTire = explorerAllTires.find(item => item.part_number === selectedTireID);

            $('span.summary-selected-tires').html(selectedTire.display_name);

            explorerNextSlide();
        }



        // Swap Vehicle Selector HTML if my vehicle Fits
        function explorerSwapSelectorFit() {
            let myFitVehicleName = localStorage.getItem("myVehicleName");

            let explorerFitHTML = `
                <div class="group group-flex <?= prefix() ?>-single-product">
                    <div class="c c-2 <?=prefix()?>-single-product-summary__meta-vehicle-fit__icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="c c-8 <?=prefix()?>-single-product-summary__meta-vehicle-fit__info">
                        <div class="<?=prefix()?>-single-product-summary__meta-vehicle-fit__message">Explorer LCG Systems fit your <span>${myFitVehicleName}</span>
                        </div>
                    </div>
                    
                </div>
                <button id="explorer-fit-button" class="<?=prefix()?>-button" type="button" onclick="explorerSeeSystems()">See Explorer Systems</button>
                <button class="<?=prefix()?>-button--none" onclick="explorerChangeVehicle()">Change Vehicle</button>
            `;
            console.log('your vehicle fits explorer');
            $('#<?=$prefix?>__vehicle-selector-description').html(explorerFitHTML);
            $('#<?=$prefix?>__vehicle-select-form').hide();
        }

        //Swap the Vehicle Selector HTML if my vehicle doesn't fit.
        function explorerSwapSelectorNoFit() {
            console.log('your vehicle does not fit explorer');
            $('#<?=$prefix?>__vehicle-selector-description').html(ExplorerNoFitHTML);
        }

        //Add Vehicle Selectr on button click
        function explorerChangeVehicle() {
            $('#<?=$prefix?>__vehicle-select-form')[0].reset();
            $("#explorer_select_engine, #explorer_select_vehicle,#explorer_select_model, #explorer_select_make, .vehicle-form-button").attr('disabled', true);
            $('#<?=$prefix?>__vehicle-select-form').show();
        }

        function explorerGetSkus() {

            var vehicleYear = localStorage.getItem('myVehicleYear');
            var vehicleID = localStorage.getItem('myVehicle');
            var vehicleName = localStorage.getItem('myVehicleName');
            var vehicleModel = localStorage.getItem('myVehicleModel');
            var getMakesURL = '<?= get_site_url() . '/wp-json/tap/v1/get_explorer_application_skus' ?>';
            var podsHTML = '';
            $.ajax({
                url: getMakesURL,
                type: 'post',
                data: {'vehicle_year':vehicleYear, 'vehicle_id':vehicleID, 'vehicle_name':vehicleName, 'model_name':vehicleModel},
                dataType: 'json',
                success:function(response){
                    
                    var pods = response[0];
                    window.skus = response[1];
                    console.log(response);
                    window.skuBase = skus.find(item => item.product_grade === 'base');
                    window.skuPro = skus.find(item => item.product_grade === 'pro');
                    window.skuBasePlus = skus.find(item => item.product_grade === 'base-plus')
                    window.skuProPlus = skus.find(item => item.product_grade === 'pro-plus')
                    window.skuBaseUCA = skus.find(item => item.product_grade === 'base-uca');
                    window.skuProUCA = skus.find(item => item.product_grade === 'pro-uca');
                    window.skuProUCAPlus = skus.find(item => item.product_grade === 'pro-uca-plus')
                    

                    var len = pods.length;
                    for( var i = 0; i<len; i++){
                        podsHTML += pods[i];
                    }

                    // This displays the Base and Pro options on the System Selector screen
                    if($('.explorer-system-pod').length < 1) {
                        $('#kit .<?=$prefix?>__vehicle-selector-wrapper').prepend(podsHTML);
                    }

                    // Display the Vehicle Model Name in a few different places
                    $('span.model-name').html(localStorage.getItem('myVehicleModel'));

                    // Display the Vehicle full name on the Summary screen
                    $('span.summary-vehicle-name').html(localStorage.getItem('myVehicleName'));

                    // For FORD RANGER Applications --
                    if (skus[0]['application'] === 'FORD RANGER 19-22') {
                        
                        var rangerUpgradeNote = '<p class="explorer-upgrade-selector__additional-content"><i>Note: When purchasing Upper Control Arms for this Explorer LCG System, you will need to confirm whether your Ford Ranger is equipped with Steel Knuckles or Aluminum Knuckles.</i></p>';

                        // Add a disclaimer to the Upgrade Page
                         $('#upgrade .explorer-upgrade-selector__content-top').after(rangerUpgradeNote);
                    }
                }
            });
        }

        function scrollToAnchor(aid){
            var aTag = $("a[name='"+ aid +"']");
            $('html,body').animate({scrollTop: aTag.offset().top},'slow');
        }

        function emailFormSubmit() {
            document.getElementById('explorer-email-form').submit();
            $('#explorer-email-form')[0].reset();
            aid = 'explorer-start';
            scrollToAnchor(aid);
        }


        function putUCABack() {
            var slideIndex = 1;
            var upgradeHTML = `
                <div class="slick-slide" data-slick-index="2" aria-hidden="true" style="width: 1440px;" tabindex="-1" role="tabpanel" id="slick-slide02"><div><div id="upgrade" data-title="UCA Upgrade" class="TAP-explorer-selector__slide" style="background-image: url(&quot;https://www.procompusa.com/wp-content/uploads/2022/07/Group-35620.jpg&quot;); width: 100%; display: inline-block;">
<div class="TAP-explorer-selector__vehicle-selector-wrapper">
<div class="explorer-system-pod__header" style="background-image: url(https://www.procompusa.com/wp-content/uploads/2022/07/500_5357-1-1.jpg)">
<h2 id="TAP-explorer-selector__vehicle-selector-heading" class="no-bottom-margin">Upgrade to Pro Series High<br>Angle Upper Control Arms</h2>
</div>
<div class="explorer-upgrade-selector__content">
<div class="explorer-upgrade-selector__content-top explorer-system-pod__content-section">
<img src="https://www.procompusa.com/wp-content/uploads/2022/07/51042B-01-copy.jpg" alt="Upper Control Arms">
<div class="explorer-upgrade-selector__content-details">
<ul>
<li>Strength of a race-style uni-ball arm</li>
<li>Increased strength and wheel travel</li>
<li>Optimized alignment and geometry for the lifted application</li>
<li>Low maintence</li>
</ul>
<h2 id="upgrade-price"></h2>
</div>
</div>
<div class="explorer-upgrade-selector__buttons">
<button class="TAP-button TAP-button--alt" upgrade="no" onclick="explorerUpgradeButton(this)" tabindex="-1">No Thanks, Continue Without UCA Upgrade</button>
<button class="TAP-button" upgrade="yes" onclick="explorerUpgradeButton(this)" tabindex="-1">Yes! Add UCA Upgrade</button>
</div>
</div>
<div class="TAP-explorer-selector__vehicle-selector__back-button-wrapper">
<button onclick="explorerPrevSlide()" class="TAP-explorer-selector__vehicle-selector__back-button" tabindex="-1">Back to <em>Select System</em></button>
</div>
</div>
</div></div></div>
            `;

            if( $('.TAP-explorer-selector__slides').find('#upgrade').length > 0 ) {
                console.log('slides has upgrade')
            } else {
                console.log('slides does not have upgrade');
                $(".TAP-explorer-selector__slides").slick('slickAdd', upgradeHTML, slideIndex);
                        $(".slider-dots li:nth-child(3) span").html('UCA Upgrade');
                        $('ul.slider-dots li:not(.slick-active):nth-of-type(n+5)').addClass('disabled');
                        $( "ul.slider-dots li span" ).on('click', function( e ) {
                        if ($(this).parent().hasClass('disabled')) {
                                e.stopPropagation();
                            }
                        });
            }
        }



    // I'm going to initialize Slick for Explorer here
    $(document).ready(function(){
        // Initialize Slick for Explorer
        $('.TAP-explorer-selector__slides').slick({
            swipe: false,
            dots: true,
            arrows: false,
            customPaging: function (slider, i) {
            var title = $(slider.$slides[i]).find('[data-title]').data('title');
            return '<span class="dots__item">' + title + ' </span>';
            },
            dotsClass: 'slider-dots'
        });

        // When the window finishes loading, add Disabled class to the System Selector Nav Item, except for the first one (which is active upon page load).
        $(window).on('load', function() {
            $('ul.slider-dots li:not(.slick-active)').addClass('disabled');
        });

        // When clicking a System Selector Nav item, only allow for clicking if the item has been enabled or activated
        $( "ul.slider-dots li span" ).on('click', function( e ) {
            if ($(this).parent().hasClass('disabled')) {
                e.stopPropagation();
            }
        });


        // Enable the submit button once all fields are selected
        $(document).ready(function(){

            $("#explorer_select_engine").change(function(){
                $('button.vehicle-form-button').attr('disabled', false);
            });
        });



        // Set the Vehicle Name in Header
        if (localStorage.getItem("myVehicle") !== null) {
            console.log('you have a vehicle set');
            if (explorerVehicleIDs.includes(localStorage.getItem('myVehicle'))) {
                explorerSwapSelectorFit();
                $('span.model-name').html(localStorage.getItem('myVehicleModel'));
            } else {
                explorerSwapSelectorNoFit();
            } 

        } else {
            console.log('you do not have a vehicle set');
        }



        // Populate the Makes dropdown with Makes by Year selected
        $("#explorer_select_year").change(function(){
            var year_id = $(this).val();
            var explorerMakes = <?=json_encode($explorer_makes)?>;

            var getMakesURL = '<?php echo get_site_url() . '/wp-json/tap/v1/get_vehicle_makes__explorer' ?>';

            $.ajax({
                url: getMakesURL,
                type: 'post',
                data: {'year':year_id, 'explorer_makes':explorerMakes},
                dataType: 'json',
                success:function(response){
                    var len = response.length;


                    $("#explorer_select_make").empty();
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];

                        
                        $("#explorer_select_make").append("<option value='"+id+"'>"+name+"</option>");
                        $("#explorer_select_make").attr( "disabled", false);

                    }
                }
            });
        });

        // Populate the Models dropdown with Models by Make selected
        $("#explorer_select_make").change(function(){
            var make_id = $(this).val();
            var explorerModels = <?=json_encode($explorer_models)?>;


            var getMakesURL = '<?= get_site_url() . '/wp-json/tap/v1/get_vehicle_models__explorer' ?>';

            $.ajax({
                url: getMakesURL,
                type: 'post',
                data: {'make':make_id, 'explorer_models':explorerModels},
                dataType: 'json',
                success:function(response){

                    var len = response.length;


                    $("#explorer_select_model").empty();
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];

                        $("#explorer_select_model").append("<option value='"+id+"'>"+name+"</option>");
                        $("#explorer_select_model").attr( "disabled", false);

                    }
                }
            });
        });

        // Populate the Vehicles dropdown with SubModels by Make selected
        $("#explorer_select_model").change(function(){
            var model_id = $(this).val();
            var explorerSubmodels = <?=json_encode($explorer_submodels)?>;


            var getMakesURL = '<?= get_site_url() . '/wp-json/tap/v1/get_vehicle_submodels__explorer' ?>';

            $.ajax({
                url: getMakesURL,
                type: 'post',
                data: {'model':model_id, 'explorer_submodels':explorerSubmodels},
                dataType: 'json',
                success:function(response){

                    var len = response.length;


                    $("#explorer_select_vehicle").empty();
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        var data = response[i]['data'];

                        
                        $("#explorer_select_vehicle").append("<option data='"+data+"' value='"+id+"'>"+name+"</option>");
                        $("#explorer_select_vehicle").attr( "disabled", false);

                    }
                }
            });
        });

        // Populate the Engine dropdown with Engine by Submodel selected
        $("#explorer_select_vehicle").change(function(){
            var submodel_id = $('option:selected', this).attr('data');
            var getMakesURL = '<?= get_site_url() . '/wp-json/tap/v1/get_vehicle_engines__explorer' ?>';

            $.ajax({
                url: getMakesURL,
                type: 'post',
                data: {'submodel':submodel_id},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#explorer_select_engine").empty();
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];

                        
                        $("#explorer_select_engine").append("<option value='"+id+"'>"+name+"</option>");
                        $("#explorer_select_engine").attr( "disabled", false);

                    }
                }
            });
        });

        $('#email-modal-button').click(function() {
            var upgradeAttr = $("#explorer-selected").attr('upgrade', upgradeAttr);
            var selectedSku = skus.find(item => item.part_number === $("#explorer-selected").attr('selected-sku'));
            $('input[name="Vehicle Information.Year_1"]').attr('value', localStorage.getItem('myVehicleYear'));
            $('input[name="Vehicle Information.Make_1"]').attr('value', localStorage.getItem('myVehicleMake'));
            $('input[name="Vehicle Information.Model_1"]').attr('value', localStorage.getItem('myVehicleModel'));
            $('input[name="Vehicle Information.Submodel_1"]').attr('value', localStorage.getItem('myVehicleSubmodel'));
            $('input[name="Vehicle Information.Engine"]').attr('value', localStorage.getItem('myVehicleEngine'));
            $('input[name="Vehicle Information.Vehicle ID"]').attr('value', localStorage.getItem('myVehicle'));

            $('input[name="Vehicle Information.Selected Kit SKU"]').attr('value', selectedSku['part_number']);
            $('input[name="Vehicle Information.Sku_Image_URL"]').attr('value', 'https://images.procompusa.com/sku/Pro%20Comp%20Suspension/400x400/' + selectedSku["part_number"] + '-01.jpg');
            $('input[name="Vehicle Information.Selected Kit Description"]').attr('value', selectedSku['short_description']);
            if(upgradeAttr == 'yes') {
                $('input[name="Vehicle Information.Includes UCA Upgrade"]').prop('checked', true);
            } else {
                $('input[name="Vehicle Information.Includes UCA Upgrade"]').prop('checked', false);
            }
            $('input[name="Vehicle Information.Wheel Specifications"]').attr('value', $('.summary-wheel-specs').html());
            $('input[name="Vehicle Information.Select Wheel SKU"]').attr('value', $('.summary-selected-wheels').html());
            $('input[name="Vehicle Information.Tire Specifications"]').attr('value', $('.summary-tire-specs').html());
            $('input[name="Vehicle Information.Select Tire SKU"]').attr('value', $('.summary-selected-tires').html());
        });



    });


</script>