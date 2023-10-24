<?php get_header(); ?>

<?php
// Let's use a standardized prefix for this whole page
$archive_prefix = prefix() . '-archive-page';

// What is the ID of the current term?
$current_term = get_queried_object_id();

// Get the ACF Fields
$short_description = get_field('short_description');
$long_description = get_field('long_description');
$display_banner_ad = false;
$display_manual_merchandising_section = true;
$toggle_off_pods = get_field('turn_off_subcategories_products');

// Get the Child Terms of this Term, if any.
$child_terms = get_terms( 'product_category', array( 'hide_empty' => false, 'parent' => $current_term ) );

?>

<div class="<?=$archive_prefix?>">
	<div class="container">
		<?= UI::tap_yoast_breadcrumbs(); ?>
		<section class="<?=$archive_prefix?>__intro?>">
			<h1 class="<?=$archive_prefix?>__title"><?=$current_term->name?></h1>
			<div class="<?=$archive_prefix?>__short-description">
				<?=$short_description?>
			</div>
		</section>
		<?php if($display_banner_ad) { ?>
			<section class="<?=$archive_prefix?>__banner_ad">
				this would be the banner ad
			</section>
		<?php } ?>

		<?php if($display_manual_merchandising_section) { ?>
			<section class="<?=$archive_prefix?>__manual-merchandising alignfull" style="background-image:url(http://transamericanautoparts.local/wp-content/uploads/2021/06/mm-bg-100.jpg)">
				<div class="container <?=$archive_prefix?>__manual-merchandising__inner">
					<h2>Featured Products</h2>
					<div class="<?=$archive_prefix?>__manual-merchandising__pods">
						<div class="group group-flex">
							<?php UI::tap_manual_merchandising_pod('foo','bar') ?>
							<?php UI::tap_manual_merchandising_pod('foo','bar') ?>
							<?php UI::tap_manual_merchandising_pod('foo','bar') ?>
						</div>

					</div>
				</div>
			</section>
		<?php } ?>
	</div>
	<div class="container nopadding">
		<?php if(!$toggle_off_pods) { ?>
			<section class="<?=prefix()?>-categories-block">
				<h2 class="<?=prefix()?>-categories-block__title">All Subcategories</h2>
				<div class="group group-flex">
					<?php 
						if($child_terms) {
							foreach($child_terms as $child_term) {
							UI::tap_product_pod($child_term);
						} 
					}?>
				</div>
			</section>
	</div>
	<div class="container">
			<section class="<?=$archive_prefix?>__lower">
				<div class="<?=$archive_prefix?>__long_description">
					<?=$long_description?>
				</div>
			</section>
		<?php } ?>
	</div>
</div>

<?php get_footer(); ?>