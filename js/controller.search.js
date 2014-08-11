var searchPostByQuery = function(options){

	this.options = options;


	if( typeof this.options._debug === 'undefined' )
		this.options._debug = false;

	if( typeof this.options._reload_same === 'undefined' )
		this.options._reload_same = false;

	if( typeof this.options.json_format === 'undefined' )
		this.options.json_format = true;

	if( typeof this.options.paged === 'undefined' )
		this.options.paged = 1;

	if( typeof this.options.date_format === 'undefined' )
		this.options.date_format = ajaxsearch.date_format;

	if( typeof this.options.time_format === 'undefined' )
		this.options.time_format = ajaxsearch.time_format;

	if( typeof this.options.post_type === 'undefined' )
		this.options.post_type = 'any';
	
	if( typeof this.options.fn === 'undefined' )
		this.options.fn = 'aotearoa_aj_search';

	if( typeof this.options.action === 'undefined' )
		this.options.action = 'aotearoa_do_search_ajax';

}


searchPostByQuery.prototype.__get_posts = function(options, callback ){

	if( options.s_query == '' ){
		_this.options._debug && console.log('Empty query');
		return false;
		
	}

	// here is where we performance the request
	ajax_call = jQuery.ajax({

		url: ajaxurl,
		  
		// fn: 		PHP function we will use, located on search.php
		// action: 	Wordpress action
		data: {
			'action': 			options.action,
			'fn': 				options.fn,
			'todo':				options.todo,
			'json_format': 		options.json_format,
			's_query': 			options.s_query,
			'paged': 			options.paged,
			'post_type': 		options.post_type,
			'post_taxonomy': 	options.post_taxonomy,
			'post_thumbnail': 	options.post_thumbnail,
			'posts_per_page': 	options.posts_per_page,
			'date_format': 		options.date_format,
			'time_format': 		options.time_format
		},
		  
		dataType: ( options.json_format == true ? 'JSON' : '' ),

	 });

	if( callback && typeof(callback) === "function" ) callback();
 
}

searchPostByQuery.prototype.the_search_posts = function(){


	var options = this.options,
		_this 	= this;

		_this.options._debug 
			&& console.log("Searching: " + this.options.s_query );  

	// if query was not empty		
	this.__get_posts( this.options, function(){

		ajax_call.success( function(data){

			
			_this.options._debug && console.log('Data succefully retrieved');
			_this.options._debug && console.log(data);

			// Defining current_page and max_num_pages 
			// after retrieve content
			_this.options.post_type = data.post_type;
			_this.current_page = data.current_page;
			_this.max_num_pages = data.max_num_pages;

			// Build HTML
			_this.build_html(data);

			ajax_call.abort();

		}).error( function(jqXHR, textStatus, errorThrown) {
		        
	        // If something crazy, options has no this as it's from the callback.
	        if( options._debug == true ){
	            console.log(jqXHR);
	            console.log('STATUS: '+textStatus);
	            console.log('error msg: '+errorThrown );
	        	
	        }

	        return textStatus;

		});

	});

	return false;

};
