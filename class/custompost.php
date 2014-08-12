<?php

if( class_exists('customPost') ){ 
	return false; 

} else {

	class customPost {

		private $ID;
		private $post_taxonomy;
		private $cpost;
		private $post_content;
		private $permalink;
		private $custom_date;
		private $taxonomy;
		private $excerpt;
		private $thumbnail;

		function __construct ( $given_id , $date_format, $post_taxonomy , $post_thumbnail_size ){

			$this->ID = $given_id;
			$this->cpost = get_post($given_id);
			$this->cpost_taxonomy = $post_taxonomy;
			$this->permalink = get_permalink($this->ID );

			$this->custom_date = date( $date_format, strtotime($this->cpost->post_date) );
			$this->thumbnail = get_the_post_thumbnail($this->ID, $post_thumbnail_size );
			$this->taxonomy = $this->get_parsed_taxonomy( $this->ID , $this->cpost_taxonomy );
			
			$this->cpost_content = array(
				'the_content' => apply_filters( 'the_content', $this->cpost->post_content ),
				'the_content_raw' => $this->cpost->post_content,
				'the_excerpt' => apply_filters('the_content', get_the_excerpt() )
			);

		}

		public function get_vars(){

			$this->cpost->permalink = $this->permalink;
			$this->cpost->custom_date = $this->custom_date;
			$this->cpost->taxonomy = $this->taxonomy;
			$this->cpost->excerpt = $this->excerpt;
			$this->cpost->thumbnail = $this->thumbnail;
			$this->cpost->post_content = $this->cpost_content;

			return $this->cpost;
		}

		// public function get_post_vars(){
			
		// 	$content = array(
		// 		'post'	=>	$this->get_vars()
		// 	);

		// 	return $content;
		// }

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

		public static function _parse_value($value){
		    if( !isset($value) ){
		        return false;
		    } else if( is_array($value) ){
		        return implode($value);
		    } else if( is_string($value) ){
		        return $value;
		    }

		}

		public static function _parse_date($date_format,$value){
			return date( $date_format, strtotime($value) );
		}

		public static function _is_ef($id){
		   $categories = wp_get_post_categories( $id );
		    foreach( $categories as $cat ){
		        if( $cat == 5){ return true; }
		    }
		    return false;
		}

	}
	
}

