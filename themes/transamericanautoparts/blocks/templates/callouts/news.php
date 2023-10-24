<?php include(get_theme_file_path().'/blocks/blocks.settings.php'); ?>

<?php

$prefix = prefix() . '-news';


// Get NEWS categories
$args = array(
            'taxonomy' => 'news_category',
            'hide_empty' => true,
            'post_type' => 'news'

        );
        
$categories =   get_terms($args);

?>

<div class="<?=$prefix?> <?=$all_classes?>">
	<?php foreach ($categories as $category ) { ?>
		<div class="<?=$prefix?>__category">
			<h2 class="<?=$prefix?>__category-title"><?=$category->name?></h2>
			<ul class="<?=$prefix?>__items-list group group-flex">
				<?php 
				$args = array(
				    'numberposts'   => -1,
				    'post_type'     => 'news',
				    'tax_query' =>  array(
			                array(
			                    'taxonomy' => 'news_category',
			                    'field'    => 'id',
			                    'terms'    => $category->term_id
			                )
			            )
				);
				$news_items = get_posts($args);
				
				foreach($news_items as $news_item) { 
					$fields = get_fields($news_item);
					$image = $fields['image'];
					$download = $fields['download'];
					?>

					<li class="<?=$prefix?>__item c c-3">
						<a target="_blank" class="<?=$prefix?>__item-link" href="<?=$download?>">
							<h3 class="<?=$prefix?>__item-title"><?=$news_item->post_title?></h3>
							<img class="<?=$prefix?>__item-image" src="<?=$image?>">
						</a>
					</li>

				<?php } ?>

			</ul>
		</div>
	    
	<?php } ?>
</div>