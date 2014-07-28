<?php

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
		
		'todo'	=> esc_html( $_REQUEST['todo'] ),
		'json_format' => ( $_REQUEST['json_format'] == "true" ? true : false  ),
		
		's_query' 	=> esc_html( $_REQUEST['s_query'] ),
		's_taxonomy' => (int)esc_html( $_REQUEST['s_taxonomy'] ),
		
		'post_event' => esc_html( $_REQUEST['post_event'] ),
		'post_type' => esc_html( $_REQUEST['post_type'] ),
		'post_taxonomy' => esc_html( $_REQUEST['post_taxonomy'] ),
		'post_thumbnail' => esc_html( $_REQUEST['post_thumbnail'] ),
		'date_format' => esc_html( $_REQUEST['date_format'] ),
		
		'paged' => esc_html( $_REQUEST['paged'] ),
		'posts_per_page' => (int)esc_html( $_REQUEST['posts_per_page'] )

	);

	switch( $options['todo'] ):
		
		case 'search-event': 
			$list = new customSearchEvent( $options ); 
			$output = $list->get_vars();
			break;

		case 'datepicker-event':
			$list = new customSearchDatepicker( $options );
			$output = $list->get_vars();
			break;
		
		case 'search':
			$list = new customSearch( $options );
			$output = $list->get_vars();
			break;
			
		default:
			$output = 'Nobody told me what todo';

	endswitch;

	// Delivering
	print_r($output);
	die;

}


add_action('wp_footer','show_ajaxurl');

function show_ajaxurl() { ?>
<script type="text/javascript">var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
<?php }