<?php include(get_theme_file_path().'/blocks/blocks.settings.php'); ?>

<?php

// Get the image
$image = get_field('image');

// Get the embed URL
$embed_url = get_field('embed_url');

?>

<div class="bg-single-video-embed <?=$all_classes?>">
    <div class="bg-single-video-embed__container" data-bg-video-url="<?=$embed_url?>" style="background-image: url(<?=$image['sizes']['large']?>);">
    	<div class="play-button">
    		<i class="fas fa-play"></i>
    	</div>
    </div>
</div>