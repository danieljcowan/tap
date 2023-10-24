<?php
/**
 * @wordpress-plugin
 * Plugin Name:       CCC Local ACF
 * Plugin URI:        https://classiccity.com
 * Description:       Local repository for all ACF JSON files
 * Version:           1.0.0
 * Author:            Classic City Consulting
 * Author URI:        https://classiccity.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ccc-acf-local
 * Domain Path:       /languages
 */


function folder_name() {
	return 'acf-json';
}


add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point( $path ) {

	// update path
	$path = plugin_dir_path(__FILE__) . '/' . folder_name();


	// return
	return $path;

}



add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {

	// remove original path (optional)
	unset($paths[0]);


	// append path
	$paths[] = plugin_dir_path(__FILE__) . '/' . folder_name();


	// return
	return $paths;

}
