<?php

if( class_exists('customPost') ){ 
	return false; 

} else {

	class customPost {

		private $ID;
		private $post_taxonomy;

		private $post;
		private $post_content;
		private $permalink;
		private $custom_date;
		private $taxonomy;
		private $excerpt;
		private $thumbnail;

		function __construct ( $post , $date_format, $post_taxonomy , $post_thumbnail_size ){


			$this->ID = $post->ID;
			$this->post_taxonomy = $post_taxonomy;

			$this->post = $post;
			$this->post_content = apply_filters( 'the_content', $this->post->post_content );
			$this->permalink = get_permalink($post->ID );
			$this->custom_date = date( $date_format, strtotime($this->post->post_date) );
			$this->excerpt = apply_filters('the_content', get_the_excerpt() );
			$this->thumbnail = get_the_post_thumbnail($post->ID, $post_thumbnail_size );
			$this->taxonomy = $this->get_parsed_taxonomy( $this->ID , $this->post_taxonomy );

		}

		public function get_vars(){

			$this->post->permalink = $this->permalink;
			$this->post->custom_date	= $this->custom_date;
			$this->post->taxonomy = $this->taxonomy;
			$this->post->excerpt = $this->excerpt;
			$this->post->thumbnail = $this->thumbnail;
			$this->post->post_content = $this->post_content;

			return $this->post;
		}

		public function get_post_vars(){
			
			$content = array(
				'post'	=>	$this->get_vars()
			);

			return $content;
		}

		public function get_parsed_taxonomy($id,$taxonomy){
			/**
			* @var terms:           object array with a list of terms
			* @var terms_values:    object array with the name of all these terms
			* @var term_string:     string with all the terms within their links eg: <a href="{{taxonomy->permalink}}">{{taxonomy->name}}</a>
			**/

			$terms = get_the_terms( $id, $taxonomy );
			$term_string = '';

			if ( $terms && ! is_wp_error( $terms ) ) : 

				$terms_values = array();

				foreach ( $terms as $term ):
					
					$term_permalink = get_term_link( $term , $taxonomy );
					$temp = '<a href="'.$term_permalink.'">'.$term->name.'</a>';
					array_push( $terms_values , $temp );

				endforeach;

				$term_string = join(" ", $terms_values );

			endif;

			return $term_string;

		}

	}
	
}

