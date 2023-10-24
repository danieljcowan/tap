<?php /* Template Name: Run Product to Category Vehicle Attribution */ ?>


We're going to run the Product to Category Vehicle ID Attribution on this page.
The purpose of this page is to look at the Vehicle IDs that a SKU will fit directly, and compile a list of those Vehicle IDs, and save them away on the Product Group, Subcategory, and Category level, so that we can filter out categories and product groups that don't have SKUs that will fit the user's vehicle (If they have a vehicle set).


<?php 
// Let's start by getting all of the terms within the Product Category taxonomy for Product Groups post type.
$args = array(
            'taxonomy' => 'product_category',
            'hide_empty' => true,

        );
$categories =   get_terms($args);
?>

<!-- [DEBUG] --  Let's see what the categories look like -->
<!-- <script>console.log(<?=count($categories);?>)</script> -->


<?php

// We'll run through each category and pull out the term ID for each term, so that we can use it in a Product Group lookup, which will help us group Product Groups by their Product Category.
foreach ($categories as $category ) {

	$current_term = $category->term_id;

	?>


	<!-- [DEBUG] --  Let's see what the parent is of each category that we've brought back. -->
<!-- 	<script>console.log('Term ID: <?=$current_term?> | Parent: <?=$category->parent?>');</script>
 -->

	<!-- [DEBUG] --  Let's see what each $current_term looks like -->
	<!-- <script>console.log(<?=json_encode($current_term);?>)</script> -->

	<?php 

	// If this is a subcategory (does have a parent category)
	if ($category->parent != 0) { ?>

		<!-- [DEBUG] --  Let's see what each $product_group looks like -->
<!-- 		<script>console.log('the category does not have a parent of 0')</script>
 -->
		<?php 


		// Let's get the Product Groups that belong to this category.
		$args = array(
		    'numberposts'   => -1,
		    'post_type'     => 'product-group',
		    'tax_query' =>  array(
	                array(
	                    'taxonomy' => 'product_category',
	                    'field'    => 'id',
	                    'terms'    => $current_term
	                )
	            )
			);
		$product_groups = get_posts($args);

		// If there are product groups in this category
		if($product_groups) { ?>

		<!-- [DEBUG] --  Let's see what each $product_group looks like -->
		<!-- <script>console.log(<?=json_encode($product_groups);?>)</script> -->

		<?php 

		} else { ?>
			<!-- Log that there's no product group for this category, just so we know -->
			<script>console.log('no product groups');</script>

		<?php }
		?>


		<?php 
		wp_reset_postdata();


		// Set an empty string for Category Vehicles field. This will be added to later.
		$cat_vehicles_string = '';
		
		foreach ($product_groups as $product_group) {

			// We're using TAP's Product Group IDs, rather than WP IDs, so we have to look that up in the ACF field.
			$product_group_id = get_field('product_group_id', $product_group->ID);
			//array_push($cat_vehicles_arr, $product_group_id);

			// Set an empty string for the Product Group Vehicles Field. This will be added to later.
			$pg_vehicles_string = '';

			// Let's get the SKUs that are associated with this Product Group. There's an ACF field on each SKU that says which Product Group ID the SKU goes with. That's what we'll query by.
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


	          foreach ($skus as $sku) {
	          	// Ahhh...this is the good stuff. This is the field that contains the *STRING* of vehicle IDs that we got from TAP for each SKU. This tells us which vehicle IDs the SKU will fit.
			    $fitment = get_field('vehicle_ids', $sku->ID);
			    ?> <script>console.log('SKU #<?=get_field('part_number', $sku->ID)?> - <?=json_encode($fitment)?>');</script> <?

			    // Now, let's append the fields from each SKU into the Category Vehicle String and Product Group Vehicle String variables, to later be saved to the ACF field for each of those.
			    $cat_vehicles_string = $cat_vehicles_string . $fitment . ',';
			    $pg_vehicles_string = $pg_vehicles_string . $fitment . ',';

	        } // foreach ($skus as $sku)


	        // We're going to create an array from the string for this Product Group, then strip out non-unique elements, then convert the array back into a string.
			$pg_vehicles_arr = (explode(',', strtolower($pg_vehicles_string)));
			$pg_vehicles_unique = array_unique($pg_vehicles_arr);
			$pg_new_vehicles = implode(',', $pg_vehicles_unique);

			// For this Product Group, we're going to get the Vehicles field, then update it with the string that we finally set up.
	        get_field('vehicles', $product_group->ID);
	        update_field('vehicles', $pg_new_vehicles, $product_group->ID);
	        ?> <script>console.log('Product Group #<?=$product_group_id?> | Vehicles: <?=$pg_new_vehicles?>');</script>
	        <?php 

		} // foreach ($product_groups as $product_group)


		// We're going to do the same thing now, but for the Category, now that we've completed each of the Product Groups inside this Category.

		// Create an array out of the string. Remove un-unique elements. Convert back into a string.
		$cat_vehicles_arr = (explode(',', strtolower($cat_vehicles_string)));
		$cat_vehicles_unique = array_unique($cat_vehicles_arr);
		$cat_new_vehicles = implode(',', $cat_vehicles_unique);

		// We're echoing out this Category Name, the Category ID, the Vehicles Field before we update it (( then we're going to update that field )), and the Vehicles Field After we update it.
		echo '<hr>';
		echo '<br>';
		echo '<br>';
		echo $category->name;
		echo '<br>';
		get_field('vehicles', $current_term);
		update_field('vehicles', $cat_new_vehicles, $current_term);
		echo get_field('vehicles', $current_term);
		echo '<br>';
		echo '<br>';

		
	
	} // If (category->parent != 0)
		else { ?>
			<!-- [DEBUG] Something's wrong with Category Parents -->
			<script>console.log('something wrong with category parents');</script>
			<?php }
} // foreach ($categories as $category)

?>

<br>
We have updated the Categories and Product Groups with vehicle IDs. Thank you for coming. 