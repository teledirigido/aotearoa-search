<?php

class customSearch {

	protected $id_list;
	protected $post_list;
	protected $taxonomy_list;
	protected $status;
	protected $s_query;
	protected $output;
	protected $options;

	function __construct ( $options ){
		
		// get options
		$this->options = $options;
		
		// format the search query
		$this->__format_search();

		// get ID's post with the search_query
		$this->__get_id_all();

		// get list of posts
		$this->__get_post_list();

		// get list of taxonomies
		$this->__get_taxonomy_list();

		// get status query
		$this->__get_status();

	}

	public function get_vars(){

		$this->output = array(
			'post_list' => $this->post_list,
			'taxonomy_list' => $this->taxonomy_list,
			'status' => $this->status
		);

		if( $this->options['json_format'] == true )
			$this->output = json_encode($this->output);

		return $this->output;

	}

	protected function __get_status(){

		// if any either post or taxonomies where succefully retrieved
		if( !empty($this->post_list) || !empty($this->taxonomy_list) ){
			$this->status = '200';

		} else {
			$this->status = '404';
		}

	}


	protected function __get_output(){

		// preparing output
		$this->output = array();
		
		// if id_list get posts
		if( !empty($this->id_list['posts']) ){
			$this->post_list = $this->__get_custom_posts( 
				$this->id_list, 
				$this->options
			);

		}

		// if taxonomy has been defined to do a search query
		if( !empty($this->id_list['terms']) && !empty($this->options['post_taxonomy']) ){
			$this->taxonomy_list = $this->__get_custom_taxonomies( 
				$this->id_list, 
				$this->options['post_taxonomy'] 

			);

		}

		$this->output['search'] = $this->options['s_query'];
		$this->output['list'] = $this->post_list;
		$this->output['taxonomy_list'] = $this->taxonomy_list;

		return $this->output;

	}


	protected function __format_search(){


		$this->s_query = explode("-", $this->options['s_query']);
		$this->s_query = implode(" ", $this->s_query);
		$this->s_query = '%' . like_escape( $this->s_query ) . '%'; // Thanks Manny Fleurmond

	}


	protected function __get_id_all(){
		
		global $wpdb;


		// Search in all post_terms
		$post_ids_terms = $wpdb->get_col( $wpdb->prepare( "
			SELECT DISTINCT term_id FROM {$wpdb->terms}
			WHERE name LIKE '%s'
		", $this->s_query ) );

		// Search in all custom fields
		$post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
			SELECT DISTINCT post_id FROM {$wpdb->postmeta}
			WHERE meta_value LIKE '%s'
		", $this->s_query ) );

		// Search in post_title and post_content by post_type
		// $post_ids_post = $wpdb->get_col( $wpdb->prepare( "
		// 	SELECT DISTINCT ID FROM {$wpdb->posts}
		// 	WHERE $wpdb->posts.post_type = '%s'
		// 	AND post_title LIKE '%s'
		// 	OR post_content LIKE '%s'
		// ", $post_type, $search, $search ) );

		$post_ids_post = $wpdb->get_col( $wpdb->prepare( "
			SELECT DISTINCT ID FROM {$wpdb->posts}
			WHERE post_title LIKE '%s'
			OR post_content LIKE '%s'
		", $this->s_query, $this->s_query ) );


		$this->id_list = array( 
			
			'posts' => array_merge( 
				$post_ids_meta, 
				$post_ids_post
				) ,
			
			'terms' => ( $post_ids_terms ) 

		);

		// print (microtime(TRUE)-$time). ' seconds';

	}


	protected function __get_post_list(){

		// if no post were found just return false
		if( empty($this->id_list['posts']) ){ return false; }

		$this->post_list = array();

		$args = array(
			'post_type' => $this->options['post_type'],
			'post__in' => $this->id_list['posts'],
			'status' => 'published'
		);

		$posts = get_posts( $args );

		foreach($posts as $post) {
			
			setup_postdata($post);

			$post_data = new customPost($post, 
				$this->options['date_format'], 
				$this->options['post_taxonomy'],
				$this->options['post_thumbnail_size']
			);


			$post_data_vars = $post_data->get_vars();

			array_push($this->post_list, $post_data_vars );
		}

		wp_reset_postdata();

	}


	protected function __get_taxonomy_list(){

		if( empty( $this->id_list['terms']) || empty($this->options['post_taxonomy']) ){
			return false;
		}

		$this->taxonomy_list = array();

		foreach( $this->id_list['terms'] as $term_id ):

			$term = get_term( $term_id, $this->options['post_taxonomy'] );
			
			if( $term->count == 0 ):
				continue; // do nothing, term empty

			else:
				$term_permalink = get_term_link( $term , $this->options['post_taxonomy'] );
				$temp_term_data = array(
					'permalink' => $term_permalink,
					'name' => $term->name
				);
				array_push($this->taxonomy_list, $temp_term_data );
				
			endif;
			
		endforeach;

	}

}