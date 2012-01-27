
// on load page...
$(document).ready(function() {
    
   $('a.tag').click(tagClick);

   //get the default postings (i.e. all of them)
   query = "";
   $.get("filter.php",query, function(data) {
            $("#main").html(data);
   });
});

//rewrites the url properly when a tag is clicked
function tagClick() {

  var reg_pattern = '((?:^#)' + $(this).text() + '$)|((?:^#)' + $(this).text() + '\/)|([\/]' + $(this).text() + '((?=\/)|$))';
  var re_this = new RegExp(reg_pattern,'g');
  var tagexistsalready = re_this.test(window.location.hash);

	if(window.location.hash) {
		if(tagexistsalready) {
			//remove the tag from window.location.hash
			var ourhash = window.location.hash;
			window.location.hash = ourhash.replace(re_this, "");
		} else
    		window.location.hash = window.location.hash + "/" + $(this).text();				//add this to it as #existing/this
	} else {
    	window.location.hash = window.location.hash + $(this).text();
    }

    return false;																			//this stops the rest of the click event happening (i.e. the url ressetting to the actual href (just the one tag) of the link)
}

$(function(){
  
	// Bind an event to window.onhashchange that, when the hash changes, activates
  	$(window).hashchange( function() {
		var hash = location.hash;
    
    	//need to parse the taglist from the anchor
    	var matchtags = window.location.href.match(/^[^#]+#([a-z,-]+(?:\/[a-z,-]+)*)/);
    	if (matchtags != null) {
    		query = "tags=" + matchtags[1].replace(/\//g, '+');								//we split tags by / so we need to change them to + for php's sake
    		$.get("filter.php",query,function(data) {
    			$("#main").html(data);
    		});
    	} else {
    		//no tags so our query is nothing! take the rest of the day off!
    		query = "";
    		$.get("filter.php",query,function(data) {
    			$("#main").html(data);
    		});
    	}

    	//change "a" elements of class ".tag" so the selected ones are "hilite"d
       	$('a.tag').each(function(){
    		var that = $(this);
        var reg_pattern = '((?:^#)' + $(this).text() + '$)|((?:^#)' + $(this).text() + '\/)|([\/]' + $(this).text() + '((?=\/)|$))';
    		var re_this = new RegExp(reg_pattern,'g');
    		var taginurl = re_this.test(window.location.hash);

      		that[ taginurl ? 'addClass' : 'removeClass' ]( 'hilite' );
    	});
	});
  
  	// Since the event is only triggered when the hash changes, we need to trigger
  	// the event now, to handle the hash the page may have loaded with.
  	$(window).hashchange();
});