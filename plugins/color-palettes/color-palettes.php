<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Color Palettes
 * Description:       Managing color palettes on Gutenberg
 * Version:           1.0
 * Author:            Classic City Consulting
 * Text Domain:       cp-color-palettes
 */

// Definitions
define('CP_PLUGIN_PATH',plugin_dir_path(__FILE__));
define('CP_PLUGIN_URL',plugin_dir_url(__FILE__));
define('CP_PLUGIN_VERSION','1.0');

// Colors class
include('inc/class.colorPalettes.php');

// Options page
include('inc/options.php');

// Gutenberg swatches
include('inc/gutenberg-swatches.php');

// CSS classes in head
include('inc/css-classes.php');