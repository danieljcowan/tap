<?php include(get_theme_file_path().'/blocks/blocks.settings.php'); ?>

<?php

// Get all Testimonial Post Objects
$testimonials = get_field('testimonials');


// Make sure we have Testimonials selected
if(is_array($testimonials) && !empty($testimonials)) { ?>

<div class="<?=prefix()?>-testimonials <?=$all_classes?>">
    
    <?php foreach($testimonials as $testimonial) { ?>
        <div class="<?=prefix()?>-testimonial">
            <img src="<?=get_the_post_thumbnail_url($testimonial->ID,'medium')?>" alt="Photo of <?=$testimonial->post_title?>">
            <h1><?=$testimonial->post_title?></h1>
            <div><?=$testimonial->post_content?></div>
        </div>
    <?php } ?>
    
</div>

<?php } ?>