var searchPostByQuery = function(options){

	this.options = options;

	if( typeof this.options._debug == 'undefined' )
		this.options._debug = false;

	if( typeof this.options._reload_same == 'undefined' )
		this.options._reload_same = false;

	if( typeof this.options.json_format == 'undefined' )
		this.options.json_format = true;

}


searchPostByQuery.prototype.__get_posts = function(options,callback){

	if( options.s_query == '' ){
		if( this.options._debug == true ){ console.log('Empty query');  }	
		return false;
		
	}

	// here is where we performance the request
	data = jQuery.ajax({

		url: ajaxurl,
		  
		data: {
			'action': 			'aotearoa_do_search_ajax',
			'fn': 				'aotearoa_aj_search',
			'json_format': 		options.json_format,
			's_query': 			options.s_query,
			'post_type': 		options.post_type,
			'post_taxonomy': 	options.post_taxonomy,
			'post_thumbnail': 	options.post_thumbnail,
			'date_format': 		options.date_format,
		},
		  
		dataType: ( options.json_format == true ? 'JSON' : '' ),

	 });

	callback(options,data,this);
 
}

searchPostByQuery.prototype.the_search_posts = function(){

	if( this.options._debug == true ){ 
		console.log("Searching: " + this.options.s_query );  
	}
	
	// if query was not empty		
	this.__get_posts( this.options, function(options,data,_this){

		data.done(function(data){

			if( options._debug == true ){
				console.log('Data succefully retrieved');
				console.log(data);
			}

			_this.build_html();

		});

		data.error(function(jqXHR, textStatus, errorThrown) {
	        
	        // If something crazy, options has no this as it's from the callback.
	        if( options._debug == true ){

	            console.log(jqXHR[0]);
	            console.log('error: '+textStatus);
	            console.log('error msg: '+errorThrown );
	        	
	        }

	    });


	});

};


