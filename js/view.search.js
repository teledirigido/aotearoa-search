/* * * * * * * * * * * * * * * * * * * * * * * * * * 
 *

 * 1) This is how your HTML should look
 *
 *

<form action="" id="search-form">
    <input type="text" value="" id="search-form-text" data-post-type="[your-post-type]" />
</form>


 * Because this is with git and still under development. 
 * You can add your own no core functions and files on your theme
 * Thanks :) 


* * * * * * * * * * * * * * * * * * * * * * * * * */


/* 2) This is how your JS file should look
 *
 */

jQuery(document).ready(function(){

	jQuery('#search-form').submit(function(event){
					
		event.preventDefault();

		var search = new searchPostByQuery({
			
			// if you want to debug and see how everything works
			_debug: true,			

			// or whenever is your input text
			s_query: jQuery('#search-form-text').val(),

			// true or false, simple as
			json_format: false,
			
			// if you want to add a special date format for your search
			date_format: 'd.m',

			// if you want to search by post_type
			// if post_type is not defined, will find in ANY post_type
			post_type: jQuery('#event-search-form').data('post-type'),
			
			// will search in any post_taxonomy
			post_taxonomy:'category_event',

		});

		search.the_search_posts();

	});

});


/* 3) Use the following prototupe function to build your html
 *
 *
 */
 
searchPostByQuery.prototype.build_html = function(data){

	console.log(data);

};