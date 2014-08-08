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

class aj_search {

	private $output;
	private $options;

	private function _get_todo(){
		if( isset($_REQUEST['todo']) )
			return esc_html($_REQUEST['todo']);
	}

	private function _get_s_query(){
		if( isset($_REQUEST['s_query']) )
			return esc_html($_REQUEST['s_query']);
	}

	private function _get_json_format(){
		if( isset($_REQUEST['json_format']) && $_REQUEST['json_format'] == "true" ){
			return true;
		}
		else{
			return false;	
		}
	}

	private function _get_s_taxonomy(){
		if( isset($_REQUEST['s_taxonomy']) )
			return esc_html($_REQUEST['s_taxonomy']);
	}

	private function _get_post_event(){
		if( isset($_REQUEST['post_event']) )
			return esc_html($_REQUEST['post_event']);
	}

	private function _get_post_type(){
		if( isset($_REQUEST['post_type']) && post_type_exists($_REQUEST['post_type']) ){
			return esc_html($_REQUEST['post_type']); }
		else return 'any';
	}

	private function _get_post_taxonomy(){
		if( isset($_REQUEST['post_taxonomy']) )
			return esc_html( $_REQUEST['post_taxonomy'] );
	}

	private function _get_post_thumbnail(){
		if( isset($_REQUEST['post_thumbnail']) )
			return esc_html( $_REQUEST['post_thumnail'] );
	}

	private function _get_date_format(){
		if( isset($_REQUEST['date_format']) )
			return esc_html($_REQUEST['date_format']);
	}

	private function _get_time_format(){
		if( isset($_REQUEST['time_format']) )
			return esc_html($_REQUEST['date_format']);
	}

	private function _get_paged(){
		if( isset($_REQUEST['paged']) )
			return esc_html($_REQUEST['paged']);
	}

	private function _get_posts_per_page(){
		if( isset($_REQUEST['posts_per_page']) )
			return (int)esc_html($_REQUEST['posts_per_page']);
	}

	private function _get_post_thumbnail_size(){
		if( isset($_REQUEST['post_thumbnail_size']) )
			return esc_html((int)$_REQUEST['post_thumbnail_size']);	
	}

	public function the_output(){
		return $this->output;
	}

	function __construct(){

		$this->options = array(
			'todo' 					=> $this->_get_todo(),
			'json_format' 			=> $this->_get_json_format(),
			's_query' 				=> $this->_get_s_query(),
			's_taxonomy' 			=> $this->_get_s_taxonomy(),
			'post_event' 			=> $this->_get_post_event(),
			'post_type' 			=> $this->_get_post_type(),
			'post_taxonomy' 		=> $this->_get_post_taxonomy(),
			'post_thumbnail' 		=> $this->_get_post_thumbnail(),
		    'post_thumbnail_size'	=> $this->_get_post_thumbnail_size(),

			'date_format' 			=> $this->_get_date_format(),
			'time_format' 			=> $this->_get_time_format(),
			'paged' 				=> $this->_get_paged(),
			'posts_per_page' 		=> $this->_get_posts_per_page()
		);

		switch( $this->options['todo'] ):
		
			case 'search-event': 
				$list = new customSearchEvent( $this->options ); 
				$this->output = $list->get_vars();
				break;

			case 'datepicker-event':
				$list = new customSearchDatepicker( $this->options );
				$this->output = $list->get_vars();
				break;
			
			default:
				$list = new customSearch( $this->options );
				$this->output = $list->get_vars();
		endswitch;

	}

}


function aotearoa_aj_search(){

	/** 
	*	Getting post and meta
	*	@var search 				string to search
	*	@var post_type 				post_type posts to retrieve
	*	@var post_taxonomy 			taxonomies related to the post_type
	*	@var post_thumbnail_size 	thumbnail size for post to retrieve
	*/

	$output_query = new aj_search();
	$output = $output_query->the_output();

	// Delivering
	print_r($output);
	die;
	
}


add_action('wp_footer','show_ajaxurl');

function show_ajaxurl() { ?>
<script type="text/javascript">
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	var ajaxsearch = { date_format:'<?php echo get_option("date_format"); ?>', time_format:'<?php echo get_option("time_format"); ?>' };
</script>
<?php }