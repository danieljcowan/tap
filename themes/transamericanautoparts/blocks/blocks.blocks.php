<?php

// THE BLOCKS
add_action('acf/init', 'ccc_acf_blocks');
function ccc_acf_blocks() {
	if( function_exists('acf_register_block') ) {

        // Testimonials
        acf_register_block_type(array(
            'name'              => 'testimonials',
            'title'             => 'Testimonials',
            'description'       => 'Shows a list of Testimonials',
            'render_template'   => 'blocks/templates/callouts/testimonials.php',
            'category'          => prefix().'-callouts',
            'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="quote-left" class="svg-inline--fa fa-quote-left fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M448 224h-64v-24c0-30.9 25.1-56 56-56h16c22.1 0 40-17.9 40-40V72c0-22.1-17.9-40-40-40h-16c-92.6 0-168 75.4-168 168v216c0 35.3 28.7 64 64 64h112c35.3 0 64-28.7 64-64V288c0-35.3-28.7-64-64-64zm32 192c0 17.7-14.3 32-32 32H336c-17.7 0-32-14.3-32-32V200c0-75.1 60.9-136 136-136h16c4.4 0 8 3.6 8 8v32c0 4.4-3.6 8-8 8h-16c-48.6 0-88 39.4-88 88v56h96c17.7 0 32 14.3 32 32v128zM176 224h-64v-24c0-30.9 25.1-56 56-56h16c22.1 0 40-17.9 40-40V72c0-22.1-17.9-40-40-40h-16C75.4 32 0 107.4 0 200v216c0 35.3 28.7 64 64 64h112c35.3 0 64-28.7 64-64V288c0-35.3-28.7-64-64-64zm32 192c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32V200c0-75.1 60.9-136 136-136h16c4.4 0 8 3.6 8 8v32c0 4.4-3.6 8-8 8h-16c-48.6 0-88 39.4-88 88v56h96c17.7 0 32 14.3 32 32v128z"></path></svg>',
            'keywords'          => array( 'testimonials', 'quote', 'client','customer' ),
        ));

        // News
        acf_register_block_type(array(
            'name'              => 'news',
            'title'             => 'News',
            'description'       => 'Shows a list of News Items, separated by category',
            'render_template'   => 'blocks/templates/callouts/news.php',
            'category'          => prefix().'-callouts',
            'icon'              => '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="newspaper" class="svg-inline--fa fa-newspaper fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M552 64H88c-13.234 0-24 10.767-24 24v8H24c-13.255 0-24 10.745-24 24v280c0 26.51 21.49 48 48 48h504c13.233 0 24-10.767 24-24V88c0-13.233-10.767-24-24-24zM32 400V128h32v272c0 8.822-7.178 16-16 16s-16-7.178-16-16zm512 16H93.258A47.897 47.897 0 0 0 96 400V96h448v320zm-404-96h168c6.627 0 12-5.373 12-12V140c0-6.627-5.373-12-12-12H140c-6.627 0-12 5.373-12 12v168c0 6.627 5.373 12 12 12zm20-160h128v128H160V160zm-32 212v-8c0-6.627 5.373-12 12-12h168c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H140c-6.627 0-12-5.373-12-12zm224 0v-8c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0-64v-8c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0-128v-8c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0 64v-8c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12z"></path></svg>',
            'keywords'          => array( 'news', 'news item', 'category','jobbers' ),
        ));

        
        // Video With Image Block
        acf_register_block_type(array(
            'name'              => 'video-with-image',
            'title'             => 'Video With Image',
            'description'       => 'Displays HTML for Video embed, with Image as thumbnail.',
            'render_template'   => 'blocks/templates/callouts/video-with-image.php',
            'category'          => prefix().'-callouts',
            'icon'              => '',
            'keywords'          => array( 'video', 'embed', 'youtube', 'vimeo', 'play', 'image'),
            'mode'          => 'preview',
            'supports'      => [
                'align'                 => false,
                'anchor'                => true,
                'customClassName'       => true,
                'jsx'                   => true,
            ]
        ));

        
        // Video With Image Block
        acf_register_block_type(array(
            'name'              => 'explorer-selector',
            'title'             => 'Explorer Selector',
            'description'       => 'Displays HTML for Explorer Series Kit Selector, with Vehicle, Kit, UCA Upgrade, Wheels, Tires, and Summary slides.',
            'render_template'   => 'blocks/templates/callouts/explorer-selector.php',
            'category'          => prefix().'-callouts',
            'icon'              => '',
            'keywords'          => array( 'explorer', 'series', 'suspension', 'selector', 'select', 'lift', 'slider', 'slides'),
            'mode'          => 'preview',
            'supports'      => [
                'align'                 => false,
                'anchor'                => true,
                'customClassName'       => true,
                'jsx'                   => true,
            ]
        ));

	}
}