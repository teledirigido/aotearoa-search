<?php
/**
 * Plugin Name: Aotearoa Search 
 * Description: Search plugin that return a JSON. There's no view interface provided just a simple JSON.
 * Version: 0.5
 * Author: Miguel Garrido at Blacksheepdesign
 * Author URI: http://www.blacksheepdesign.co.nz
 * License: GPL2
 *
 * The minimum required files here are:
 *
 * PHP FILES
 * ---------
 * class/custompost.php
 *
 *
 * JS FILES
 * --------
 * js/controller.search.js
 * js/view.search.js
 *
 * The rest it's just additional stuff
 *
 */

wp_enqueue_script( 'search-controller', 
	plugin_dir_url( __FILE__ ) . '/js/controller.search.js', 
	array('jquery') , 
	'1.0', 
	true 
);

wp_enqueue_script( 'search-view', 
	plugin_dir_url( __FILE__ ) . '/js/view.search.js', 
	array('jquery') , 
	'1.0', 
	true 
);

require_once('class/customsearch.php');
require_once('class/custompost.php');
require_once('search.php');