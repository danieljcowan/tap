<?php

add_filter( 'block_categories', function( $categories, $post ) {

	$prefix = "{{CLIENT_NAME}}";

	return array_merge(
		$categories,
		array(
			array(
				'title' => __($prefix.' | Callouts'),
				'slug'  => prefix().'-callouts'
			),
		)
	);
}, 10, 2 );

