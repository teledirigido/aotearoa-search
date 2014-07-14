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
		post_type: jQuery('#event-search-form').data('post-type'),
		
		# will search in any post_taxonomy
		post_taxonomy:'category_event',

	});

	search.the_search_posts();

});

* * * * * * * * * * * * * * * * * * * * * * * * * */

// THIS IS JUST AN EXAMPLE SEE ABOVE FOR OPTIONS I LIKE UPPERCASES
jQuery(document).ready(function(){

	jQuery('#search-form').submit(function(event){
				
		event.preventDefault();

		var search = new searchPostByQuery({
			// json_format: false,
			s_query: jQuery('#search-form-text').val(),
			date_format: 'd M, Y',
			_debug: true,
			post_taxonomy: 'category'
		});

		search.the_search_posts();

		// from here onwards you're free to do whatever you want.

	});

});