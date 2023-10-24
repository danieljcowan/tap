<?php get_header(); ?>

<?php
// Let's use a standardized prefix for this whole page
$archive_prefix = prefix() . '-archive-page';

// What is the ID of the current term?
$current_term = get_queried_object_id();

// Set up a prefix for ACF get_field's second argument
$acf_term_prefix = 'product_category_' . $current_term;


// If Parent Category, get Subcategories to display in pods; If not, get Product Groups to display in pods
$children = get_term_children($current_term, 'product_category');

if( !empty( $children ) ) {

	// Get the Subcategories, then use the Category Pod function from Class.UI
	$pods = get_terms(
				'product_category',
				array( 
					'hide_empty' => true,
					'parent' => $current_term,
	            ) 
			);
	foreach($pods as $pod) {
		$pod_acf_term_prefix = 'product_category_' . $pod->term_id;
		$pod->priority = get_field('priority', $pod_acf_term_prefix);
	}
	usort($pods, function($a, $b) {return strcmp($a->priority, $b->priority);});
	$pod_section_heading = 'All Subcategories';
	$pod_section_subheading_noun = 'subcategories';
	$has_children = true;

} else {

	// Get the Product Groups for this Subcategory, then use the Product Pod from Class.UI
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
	$pods = get_posts($args);
	wp_reset_postdata();
	$pod_section_heading = 'All Products';
	$pod_section_subheading_noun = 'products';
	$has_children = false;
}

// If there is only one POD (subcat or product group), redirect to that pod's page
// if(count($pods) === 1) {
// 	$redirect = 'Location: ' . get_permalink($pods[0]);
// 	header($redirect, TRUE, 301);
// 	exit();
// }


// Get the ACF Fields
$short_description = get_field('short_description', $acf_term_prefix);
$long_description = get_field('long_description', $acf_term_prefix);
$display_banner_ad = false;
$toggle_off_pods = get_field('turn_off_subcategories_products', $acf_term_prefix);
$manual_merchandising = get_field('manual_merchandising', $acf_term_prefix);
if ($manual_merchandising) {
	$mm_cards = get_field('cards', $manual_merchandising->ID);
	$mm_columns = 12 / count($mm_cards);
}
$vehicles = explode(',', get_field('vehicles'));




?>

<div class="<?=$archive_prefix?>">
	<div class="container">
		<?= UI::tap_yoast_breadcrumbs(); ?>
		<section class="<?=$archive_prefix?>__intro">
			<h1 class="<?=$archive_prefix?>__title"><?=single_term_title()?></h1>
			<div class="<?=$archive_prefix?>__short-description">
				<p><?=$short_description?></p>
			</div>
		</section>
		<?php if($display_banner_ad) { ?>
			<section class="<?=$archive_prefix?>__banner_ad">
				this would be the banner ad
			</section>
		<?php } ?>

		<?php if($manual_merchandising) { ?>
			<section class="<?=$archive_prefix?>__manual-merchandising alignfull" style="background-image:url(<?=get_field('manual_merchandising_section_background_image','option')?>)">
				<div class="container <?=$archive_prefix?>__manual-merchandising__inner">
					<h2>Featured Products</h2>

					<div class="<?=$archive_prefix?>__manual-merchandising__pods">
						<div class="group group-flex">
							<?php foreach($mm_cards as $card) {
							UI::tap_manual_merchandising_pod($card, $mm_columns);
							} ?>	
						</div>

					</div>
				</div>
			</section>
		<?php } ?>
	</div>
	<div class="container nopadding">
		<?php if(!$toggle_off_pods) { ?>
			<section class="<?=prefix()?>-categories-block">
				<h2 class="<?=prefix()?>-categories-block__title"><?=$pod_section_heading?></h2>
				<p class="center">Some <?=$pod_section_subheading_noun?> below may only contain universal fit parts that are not applicable to your vehicle.</p>
				<div class="group group-flex">
					<?php 
						if($pods) {
							foreach($pods as $pod) {
								if($has_children == true) {
									UI::tap_category_pod($pod);
								} else {
									UI::tap_product_pod($pod);
								}
							}
						} 
					?>
				</div>
			</section>
		<?php } ?>
	</div>
	<div class="container">
		<section class="<?=$archive_prefix?>__lower">
			<div class="<?=$archive_prefix?>__long_description">
				<p><?=$long_description?></p>
			</div>
		</section>
	</div>
</div>

<script>

	var myVehicle = localStorage.getItem("myVehicle");

	var universal = document.querySelectorAll('[fitment="universal-fit"]');
	var fits = document.querySelectorAll('[fits-my-vehicle="true"]');

	var noVehicles = document.createElement("div");
	noVehicles.innerHTML = '<p style="text-align: center; font-weight:600; font-style=italic;">Sorry - there are no products here that fit your vehicle.</p>';
	var section = document.querySelector('.TAP-categories-block');


	if (myVehicle !== null && fits.length <1 && universal.length <1 ) {
		console.log('no vehicle set, and there is no fit here');
		section.appendChild(noVehicles);
	}


</script>


<?php get_footer(); ?>