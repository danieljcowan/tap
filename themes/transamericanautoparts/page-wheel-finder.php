<?php /* Template Name: Wheel Finder */ ?>

<?php 

get_header();
$prefix = prefix() . '-wheel-finder';
?>

<div class="<?=$prefix?> TAP-product-group">
	<div class="container">
		<div class="group group-flex <?=prefix()?>-wheel-finder-forms-container">
	        <div class="c c-5">
	            <form action="" id="<?=prefix()?>-wheel-finder-form" class="<?=prefix()?>-wheel-finder-form">

	                <select name="series" id="series">
                        <option value="0" disabled selected>--Series--</option>
	                    <option value="series_pq01-series">1 Series</option>
                        <option value="series_pq05-series">5 Series</option>
                        <option value="series_pq29-series-la-paz">29 Series</option>
                        <option value="series_pq31-series">31 Series</option>
                        <option value="series_pq32-series">32 Series</option>
                        <option value="series_pq33-series">33 Series</option>
                        <option value="series_pq34-series-rockwell">34 Series</option>
                        <option value="series_pq35-series-predator">35 Series</option>
                        <option value="series_pq36-series-helldorado">36 Series</option>
                        <option value="series_pq39-series-interia">39 Series</option>
                        <option value="series_pq40-series-vertigo">40 Series</option>
                        <option value="series_pq41-series-phaser">41 Series</option>
                        <option value="series_pq42-series-blockade">42 Series</option>
                        <option value="series_pq43-series-sledge">43 Series</option>
                        <option value="series_pq44-series-syndrome">44 Series</option>
                        <option value="series_pq45-series-proxy">45 Series</option>
                        <option value="series_pq46-series">46 Series</option>
                        <option value="series_pq48-series">48 Series</option>
                        <option value="series_pq50-series-gauge">50 Series</option>
                        <option value="series_pq51-series-district">51 Series</option>
                        <option value="series_pq60-series">60 Series</option>
                        <option value="series_pq61-series">61 Series</option>
                        <option value="series_pq62-series">62 Series</option>
                        <option value="series_pq63-series">63 Series</option>
                        <option value="series_pq64-series">64 Series</option>
                        <option value="series_pq69-series">69 Series</option>
                        <option value="series_pq72-series">72 Series</option>
                        <option value="series_pq73-series">73 Series</option>
                        <option value="series_pq74-series">74 Series</option>
                        <option value="series_pq75-series">75 Series</option>
                        <option value="series_pq82-series-phantom">82 Series</option>
                        <option value="series_pq89-series">89 Series</option>
                        <option value="series_pq97-series">97 Series</option>
                        <option value="series_pq252-series">252 Series</option>
	                </select>
	                <select name="bolt_pattern" id="bolt_pattern">
	                    <option value="0" disabled selected>--Bolt Pattern--</option>
	                    <option value="bolt-pattern_pq5-on-150">5 on 150</option>
	                    <option value="bolt-pattern_pq5-on-4-5">5 on 4.5</option>
	                    <option value="bolt-pattern_pq5-on-4-75">5 on 4.75</option>
	                    <option value="bolt-pattern_pq5-on-5">5 on 5</option>
	                    <option value="bolt-pattern_pq5-on-5-5">5 on 5.5</option>
	                    <option value="bolt-pattern_pq5-on-5-5-5-on-150">5 on 5/5 on 150</option>
	                    <option value="bolt-pattern_pq5-on-5-5-on-5-5">5 on 5/5 on 5.5</option>
	                    <option value="5 on 6.5">5 on 6.5</option>
	                    <option value="6 on 120">6 on 120</option>
	                    <option value="bolt-pattern_pq6-on-135">6 on 135</option>
	                    <option value="bolt-pattern_pq6-on-4-5">6 on 4.5</option>
	                    <option value="bolt-pattern_pq6-on-5-5">6 on 5.5</option>
	                    <option value="bolt-pattern_pq6-on-5-5-6-on-135">6 on 5.5/6 on 135</option>
	                    <option value="bolt-pattern_pq6-on-6-5">6 on 6.5</option>
	                    <option value="bolt-pattern_pq8-on-170">8 on 170</option>
	                    <option value="bolt-pattern_pq8-on-180">8 on 180</option>
	                    <option value="bolt-pattern_pq8-on-6-5">8 on 6.5</option>
	                </select>
	                <select name="wheel_diameter" id="wheel_diameter">
	                    <option value="0" selected disabled>--Wheel Diameter--</option>
	                    <option value="wheel-diameter_pq15-inches">15 inches</option>
	                    <option value="wheel-diameter_pq16-inches">16 inches</option>
	                    <option value="wheel-diameter_pq17-inches">17 inches</option>
	                    <option value="wheel-diameter_pq18-inches">18 inches</option>
	                    <option value="wheel-diameter_pq19-inches">19 inches</option>
	                    <option value="wheel-diameter_pq20-inches">20 inches</option>
	                </select>
	                <select name="finish" id="finish">
	                    <option value="0" selected disabled>--Finish--</option>
	                    <option value="finish_pqchrome">Chrome</option>
	                    <option value="finish_pqblack">Black</option>
	                    <option value="finish_PQ:satin-black-milled">Satin Black/Milled</option>
	                    <option value="finish_PQ:machined">Machined</option>
	                    <option value="finish_PQ:machined-black">Machined Black</option>
	                    <option value="finish_PQ:black-machined-lip">Black/Machined Lip</option>
	                    <option value="finish_pqwhite">White</option>
	                    <option value="finish_PQ:polished">Polished</option>
	                    <option value="finish_PQ:2-tone">2 Tone</option>
	                    <option value="finish_pqgraphite">Graphite</option>
	                    <option value="finish_pqmatte-bronze">Matte Bronze</option>

	                </select>

                    <div class="clear"></div>
	                <button id="wheel-finder__submit" class="<?=prefix()?>-button" onclick="" type="submit">Go</button>
                    <button id="wheel-finder__reset" class="reset" onclick="" type="reset">Reset</button>
	            </form>
	        </div>
	        <div class="c c-2 center">
	            OR
	        </div>
	        <div class="c c-5">           
	            <form action="" id="<?=prefix()?>-wheel-finder-part-number-form" class="<?=prefix()?>-wheel-finder-form">
	                <input id="part_number" type="text" id="name" name="part-number" size="18" placeholder="Part Number">
                    <div class="clear"></div>
	                <button type="submit" id="wheel-finder-part-number__submit" class="<?=prefix()?>-button" onclick="">Go</button>
                    <button id="wheel-finder-part-number__reset" class="reset" onclick="" type="reset">Reset</button>
	            </form>
	        </div>
	    </div>

		<div class="<?=prefix()?>-single-product">
		    <div class="<?=prefix()?>-single-product-details">
	            <div class="<?=prefix()?>-single-product-details__navigation alignfull" style="height: 68px;">
	            </div>

		        <div id="wheel-finder-results">
		        </div>
		    </div>
		</div>
	</div>
</div>


<script>

    $(document).ready(function() {

        $("#wheel-finder-part-number__submit").click(function() {

            $(this).html("Processing");
            $(this).prop('disabled', true);
            $(".input").val("");


            console.log('I clicked the button.');
            $("#wheel-finder-results").html("");

            var formPartNumber = $("#part_number").val();
            var getWheelFinderByPartNumberURL = '<?php echo get_site_url() . '/wp-json/tap/v1/wheel_finder_part_number' ?>';
            console.log(formPartNumber);
            console.log(getWheelFinderByPartNumberURL);


            $.ajax({
                url: getWheelFinderByPartNumberURL,
                type: 'post',
                data: {'part_number':formPartNumber},
                dataType: 'json',
                success:function(response){

                    //console.log(response);

                    if (response == 'Sorry, no wheels fit your criteria') {

                        let noWheels = document.createElement("div");
                        const innerHTMLNoWheels = response;
                        noWheels.innerHTML = innerHTMLNoWheels;
                        const element = document.getElementById("wheel-finder-results");
                        element.appendChild(noWheels);

                    } else {

                        var len = response.length;

                        for( var i = 0; i<len; i++){
                            
                            var wheelArr = response[i];

                            //console.log(wheelArr);
                            var ProductName = wheelArr[0];
                            var wheelID = wheelArr[1]
                            var ProductImage = wheelArr[2];
                            var ProductPartNumber = wheelArr[3];
                            var ProductPrice = '$' + wheelArr[4];
                            var ProductLink = wheelArr[5];
                            var wheelFeatures = wheelArr[6];
                            //var wheelInventory = wheelArr[7];
                            var dcInventory = wheelArr[7];

                            var rowPrefix = '<?=prefix()?>-product-row'


                            let newWheel = document.createElement("div");
                            newWheel.setAttribute("class", "container <?=prefix()?>-product-row");
                            const innerHTML1 = `
                                    <div class="group group-flex">
                                        <div class="c c-4">
                                            <img class="${rowPrefix}__image" src="${ProductImage}" alt="Image of ${ProductName}">
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
                                        <div class="${rowPrefix}__details">
                                            <div class="${rowPrefix}__price">
                                                <p class="TAP-single-product-summary__meta-cart__price">${ProductPrice}</p>
                                            </div>
                                            <div class="TAP-single-product-summary__meta-cart__button-container">
                                                <a class="TAP-single-product-summary__meta-cart__button" href="${ProductLink}">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            newWheel.innerHTML = innerHTML1 + innerHTML2
                            const element = document.getElementById("wheel-finder-results");
                            element.appendChild(newWheel);


                            for(let i=0; i < wheelFeatures.length; i++) {
                                    var ul = document.getElementById(ProductPartNumber + '-features');
                                    var li = document.createElement("li");
                                    li.innerHTML = wheelFeatures[i];
                                    ul.appendChild(li);
                                    
                            }


                            // for(let i=0; i < wheelInventory.length; i++) {
                            //         var trInventory = document.createElement("tr");
                            //         //console.log('Inventory: ' + wheelInventory[i]);
                            //         //console.log(wheelInventory[i].length);
                            //         trInventory.innerHTML = '<td class="inventory-td">' + wheelInventory[i][0] + '</td><td>' + wheelInventory[i][1] + '</td>';
                            //         ulInventory.appendChild(trInventory);
                                    
                            // }

                            //console.log(dcInventory[0]);
                            for (const [key, value] of Object.entries(dcInventory[0])) {
                              //console.log(key, value);
                                var trInventory = document.createElement("tr");
                                trInventory.innerHTML = '<td class="inventory-td">' + key + '</td><td>' + value + '</td>';
                                ulInventory.appendChild(trInventory);
                            }

                            var ulHasChild = ulInventory.querySelector(".inventory-td") != null;

                            if (!ulHasChild) {
                                //console.log('there is no td');
                                var trNoInventory = document.createElement("tr");
                                trNoInventory.innerHTML = '<td class="no-inventory-td">No wheels in stock.</td><td></td>';
                                ulInventory.appendChild(trNoInventory);
                            }
                        }
                    }
                }
            });
            setTimeout(function(){

                $("#part_number").val("");
                $("#wheel-finder-part-number__submit").html("Go");
                $("#wheel-finder-part-number__submit").prop('disabled', false);
            },2500);
            

        });
    });


    $(document).ready(function(){

        $("#wheel-finder__submit").click(function(){


            $(this).html("Processing");
            $(this).prop('disabled', true);

            $("#wheel-finder-results").html("");


            console.log('I clicked the button.');

            var boltPattern = $("#bolt_pattern").val();
            var wheelDiameter = $("#wheel_diameter").val();
            var wheelDiameterTo = $("#wheel_diameter_to").val();
            var wheelFinish = $("#finish").val();
            var wheelSeries = $("#series").val();
            var getWheelFinderURL = '<?php echo get_site_url() . '/wp-json/tap/v1/wheel_finder_2' ?>';

            // console.log(boltPattern);
            // console.log(wheelDiameterFrom);
            // console.log(wheelDiameterTo);
            // console.log(wheelFinish);
            // console.log(getWheelFinderURL);
            console.log(wheelSeries);

            $.ajax({
                url: getWheelFinderURL,
                type: 'post',
                data: {'series':wheelSeries,'bolt_pattern':boltPattern, 'wheel_diameter':wheelDiameter,'finish':wheelFinish},
                dataType: 'json',
                success:function(response){

                    // console.log("data = " + wheelSeries);
                    console.log(response);

                    if (response == 'Sorry, no wheels fit your criteria') {

                        let noWheels = document.createElement("div");
                        const innerHTMLNoWheels = response;
                        noWheels.innerHTML = innerHTMLNoWheels;
                        const element = document.getElementById("wheel-finder-results");
                        element.appendChild(noWheels);

                    } else {

                        var len = response.length;

                        for( var i = 0; i<len; i++){
                            
                            var wheelArr = response[i];

                            //console.log(wheelArr);
                            var ProductName = wheelArr[0];
                            var wheelID = wheelArr[1]
                            var ProductImage = wheelArr[2];
                            var ProductPartNumber = wheelArr[3];
                            var ProductPrice = '$' + wheelArr[4];
                            var ProductLink = wheelArr[5];
                            var wheelFeatures = wheelArr[6];
                            //var wheelInventory = wheelArr[7];
                            var dcInventory = wheelArr[7];

                            var rowPrefix = '<?=prefix()?>-product-row'


                            let newWheel = document.createElement("div");
                            newWheel.setAttribute("class", "container <?=prefix()?>-product-row");
                            const innerHTML1 = `
                                    <div class="group group-flex">
                                        <div class="c c-4">
                                            <img class="${rowPrefix}__image" src="${ProductImage}" alt="Image of ${ProductName}">
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
                                        <div class="${rowPrefix}__details">
                                            <div class="${rowPrefix}__price">
                                                <p class="TAP-single-product-summary__meta-cart__price">${ProductPrice}</p>
                                            </div>
                                            <div class="TAP-single-product-summary__meta-cart__button-container">
                                                <a class="TAP-single-product-summary__meta-cart__button" href="${ProductLink}">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            newWheel.innerHTML = innerHTML1 + innerHTML2
                            const element = document.getElementById("wheel-finder-results");
                            element.appendChild(newWheel);


                            for(let i=0; i < wheelFeatures.length; i++) {
                                    var ul = document.getElementById(ProductPartNumber + '-features');
                                    var li = document.createElement("li");
                                    li.innerHTML = wheelFeatures[i];
                                    ul.appendChild(li);
                                    
                            }


                            // for(let i=0; i < wheelInventory.length; i++) {
                            //         var trInventory = document.createElement("tr");
                            //         //console.log('Inventory: ' + wheelInventory[i]);
                            //         //console.log(wheelInventory[i].length);
                            //         trInventory.innerHTML = '<td class="inventory-td">' + wheelInventory[i][0] + '</td><td>' + wheelInventory[i][1] + '</td>';
                            //         ulInventory.appendChild(trInventory);
                                    
                            // }

                            console.log(dcInventory[0]);
                            for (const [key, value] of Object.entries(dcInventory[0])) {
                              //console.log(key, value);
                                var trInventory = document.createElement("tr");
                                trInventory.innerHTML = '<td class="inventory-td">' + key + '</td><td>' + value + '</td>';
                                ulInventory.appendChild(trInventory);
                            }

                            var ulHasChild = ulInventory.querySelector(".inventory-td") != null;

                            if (!ulHasChild) {
                                console.log('there is no td');
                                var trNoInventory = document.createElement("tr");
                                trNoInventory.innerHTML = '<td class="no-inventory-td">No wheels in stock.</td><td></td>';
                                ulInventory.appendChild(trNoInventory);
                            }
                        }
                    }
                }
            });
            setTimeout(function(){
                $("#wheel-finder__submit").html("Go");
                $("#wheel-finder__submit").prop('disabled', false);
            },1500);
        });
    });
</script>




<?php
get_footer();
