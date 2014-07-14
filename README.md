aotearoa-search // wp_search_json
==============

This is a plugin for wordpress that allows you to get a json object when you do search. 
Nothing else, nothing less.

This plugin it's under development. 

I AM NOT RECOMMENDING ANYONE TO USE IT. 

You're  free to download it and have a look around.

There's no interface provided, just a json as result when you search for something on your wordpress.

Why I did this?

- Because I like and I use wordpress.
- Because I wanted to get parsed and formatted data using a simple search query.
- Because json is pretty.

To use this plugin you should

- Be courious as it's not a release or anything like that
- Know how json works
- Know how ajax works
- Want to create something nice with ajax

You should have a look on js/view.search.js to start looking for options and create your own functions to display the content.

This works in the following way:
- aotearoa_aj_search located on the index of this plugin is an ajax function that uses the class customSearch.
- aotearoa_aj_search uses a class called customSearch located on class/customsearch.php
- the file view.search.js uses an object called searchPostByQuery located on controller.search.js
- the class searchPostByQuery located on controller.search.js has a prototyped function where to perform an ajax call to using the aotearoa_aj_search function.
- The content has been displayed on view.search.js
- The content will show up on your console
