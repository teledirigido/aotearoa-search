<?php 


if( class_exists('customPostEvent') ):
	return false; 
else:

class customPostPeople extends customPost {
	
	private $ID;

	function __construct( $given_id, $date_format, $time_format ){
		$this->ID = $given_id;
		parent::__construct( $this->ID, $date_format, '' , '' );
		
	}

	private function __to_string($var){
		if( is_array($var) ){
			return implode( $var );
		} else if ( is_string($var) ){
			return $var; 
		} else {
			die('Error Parsing content');
		}
	}

	public function get_vars(){

		$content = array_merge( (array)parent::get_vars() );

		$content['permalink'] = 'mailto:'.$this->get_email();
		$content['post_content']['the_content_raw'] = $this->get_post_content();

		return $content;
	}

	private function get_post_content(){
		return $this->__to_string(get_post_meta($this->ID ,'role'));
	}

	private function get_email(){
		return $this->__to_string(get_post_meta($this->ID ,'email'));

	}

}



endif;