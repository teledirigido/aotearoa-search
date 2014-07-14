<?php
/**
 * Plugin Name: Aotearoa Search 
 * Description: Search plugin that return a JSON. There's no view interface provided just a simple JSON.
 * Version: 0.1
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
// require_once('customsearch.event.php');

/**
  * @param    wp_ajax_nopriv_(action) 
  *           executes for users that are not logged in.
  *
  * @param    wp_ajax_(action) 
  *           executes for users that are logged in.
  *
  * @see      http://codex.wordpress.org/AJAX_in_Plugins
  */

add_action('wp_ajax_nopriv_aotearoa_do_search_ajax', 'aotearoa_aj_search');
add_action('wp_ajax_aotearoa_do_search_ajax', 'aotearoa_aj_search');

function aotearoa_aj_search(){

	/** 
	*	Getting post and meta
	*	@var search 				string to search
	*	@var post_type 				post_type posts to retrieve
	*	@var post_taxonomy 			taxonomies related to the post_type
	*	@var post_thumbnail_size 	thumbnail size for post to retrieve
	*/

	// requested date
    $options = array(
    	's_query' 	=> esc_html( $_REQUEST['s_query'] ),
    	's_taxonomy' => (int)esc_html( $_REQUEST['s_taxonomy'] ),
    	'json_format' => ( $_REQUEST['json_format'] == "true" ? true : false  ),
    	'post_type' => esc_html( $_REQUEST['post_type'] ),
    	'post_taxonomy' => esc_html( $_REQUEST['post_taxonomy'] ),
    	'post_thumbnail' => esc_html( $_REQUEST['post_thumbnail'] ),
    	'date_format' => esc_html( $_REQUEST['date_format'] ),

    );

    $list = new customSearch( $options );
    
    $output = $list->get_vars();

	// Delivering
	print_r($output);
	die;

}

add_action('wp_footer','show_ajaxurl');

function show_ajaxurl() { ?>
<script type="text/javascript">var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
<?php }