<?php

add_action('wp_head', 'cp_gutenberg_css_colors');
function cp_gutenberg_css_colors()
{

    // Get the colors
    $colors = new ColorPalettes('', 'regular');

    // Do we have palettes?
    if (isset($colors->palettes) && is_array($colors->palettes) && !empty($colors->palettes)) {

        echo '<style data>';

        // Loop through each master palette
        foreach ($colors->palettes as $palettes) {

            // Loop through each sub-palette
            foreach ($palettes as $palette) {

                echo '.has-text-color.has-' . $palette['slug'] . '-color,.has-text-color.has-' . $palette['slug'] . '-color a {color:' . $palette['color'] . ' !important;}'."\n";
                echo '.has-text-color.has-' . $palette['slug'] . '-opposite-color,.has-text-color.has-' . $palette['slug'] . '-opposite-color a {color:' . $palette['opposite'] . ' !important;}'."\n";
                echo '.has-text-color.has-' . $palette['slug'] . '-color:after {background-color:' . $palette['color'] . ' !important;}'."\n";
                echo '.has-' . $palette['slug'] . '-border-color {border-color:' . $palette['color'] . ' !important;}'."\n";
                echo '.has-' . $palette['slug'] . '-background-color {background-color:' . $palette['color'] . ' !important;}'."\n";

            }

        }

        echo ':root {';
        foreach ($colors->palettes as $palettes) {
            foreach ($palettes as $palette) {
                echo '--' . $palette['slug'] . ': ' . $palette['color'] . ';'."\n";

                // Make sure the OPPOSITE isset
                if(isset($palette['opposite'])) {
                    echo '--' . $palette['slug'] . '-opposite: ' . $palette['opposite'] . ';'."\n";
                }
            }
        }
        echo '}';

        echo '</style>';

    }


}