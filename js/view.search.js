/* * * * * * * * * * * * * * * * * * * * * * * * * * 
 * 
 * This is how your JS file should look
 *
 *

jQuery('#search-form').submit(function(event){
				
	event.preventDefault();

	var search = new searchPostByQuery({
		
		# if you want to debug and see how everything works
		_debug: true,			

		# or whenever is your input text
		s_query: jQuery('#search-form-text').val(),

		# true or false, simple as
		json_format: false,
		
		# if you want to add a special format for your search
		date_format: 'd.m',

		# if you want to search by post_type
		# if post_type is not defined, will find in ANY post_type
		post_type: jQuery('#event-search-form').data('post-type'),
		
		# will search in any post_taxonomy
		post_taxonomy:'category_event',

	});

	search.the_search_posts();

});

* * * * * * * * * * * * * * * * * * * * * * * * * */

