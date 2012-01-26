
// on load page...
$(document).ready(function() {
    
   // setInterval("checkAnchor()", 30);
   $('a.tag').click(tagClick);

   query = "";
   $.get("filter.php",query, function(data) {
            $("#main").html(data);
   });
});


function tagClick() {
    $(this).addClass("hilite");

    var re_this = new RegExp($(this).text());											//TODO: need to make the regex more specific to avoid false-positive substring matches (i.e. neutered being matched in non-neutered)
    var tagexistsalready = re_this.test(window.location.hash);

	if(window.location.hash) {
		if(tagexistsalready) {
			//remove the tag from window.location.hash
			var ourhash = window.location.hash;
			var reg_pattern = '([\/]' + $(this).text() + ')|(' + $(this).text() + '[\/]?)';
			var regexr = new RegExp(reg_pattern,'g');
			console.log(reg_pattern);
			window.location.hash = ourhash.replace(regexr, "");
			console.log(ourhash);
		} else
    		window.location.hash = window.location.hash + "/" + $(this).text();				//add this to it as #existing/this
	} else {
    	window.location.hash = window.location.hash + $(this).text();
    }
    //hashchange should notice and update then
    return false;																		//this stops the rest of the click event happening (i.e. the url getting set to just the anchor clicked)
}

$(function(){
  
  // Bind an event to window.onhashchange that, when the hash changes, gets the
  // hash and adds the class "selected" to any matching nav link.
  $(window).hashchange( function(){
    var hash = location.hash;
    
    // Set the page title based on the hash.
    //document.title = 'The hash is ' + ( hash.replace( /^#/, '' ) || 'blank' ) + '.';
    
    /*
    // Iterate over all nav links, setting the "selected" class as-appropriate.
    $('#nav a').each(function(){
      var that = $(this);
      that[ that.attr( 'href' ) === hash ? 'addClass' : 'removeClass' ]( 'selected' );
    });
    */

    //
    // on hash change we want to:
    	//call filter.php with the new taglist and repopulate the postings
    		//need to parse the taglist from the anchor
    		var matchtags = window.location.href.match(/^[^#]+#([a-z,-]+(?:\/[a-z,-]+)*)/);	//TODO: change this to use window.location.hash
    		if (matchtags != null) {
    			console.log(matchtags);
    			//pass it to filter.php, we split by / so we need to change them to + for php's sake
    			query = "tags=" + matchtags[1].replace(/\//g, '+');
    			console.log(query);
    			//display results
    			$.get("filter.php",query,function(data) {
    				$("#main").html(data);
    			});
    		} else {
    			//no tags so our query is nothing! take the rest of the day off!
    			query = "?";
    			console.log(query);
    			//display results
    			$.get("filter.php",query,function(data) {
    				$("#main").html(data);
    			});
    		};
    			
    		

    	//rewrite the urls on the existing tag links so they include the new addition to the anchor and so the selected ones are "hilite"d
    	$('.tag').each(function(){
    		var that = $(this);
      		that[ that.attr( 'href' ) === hash ? 'addClass' : 'removeClass' ]( 'hilite' );
    	});

    //
  });
  
  // Since the event is only triggered when the hash changes, we need to trigger
  // the event now, to handle the hash the page may have loaded with.
  $(window).hashchange();
  
});