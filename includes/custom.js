
// on load page...
$(document).ready(function() {
    
   $('a.tag').click(tagClick);

   //get the default postings (i.e. all of them)
   query = "";
   $.get("filter.php",query, function(data) {
            $("#main").html(data);
   });
});


function tagClick() {

    var reg_pattern = '([\/]' + $(this).text() + ')|((?:^#)' + $(this).text() + '[\/]?)';
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

    //hashchange should notice and update now
    return false;																		//this stops the rest of the click event happening (i.e. the url getting set to just the anchor clicked)
}

$(function(){
  
	// Bind an event to window.onhashchange that, when the hash changes, activates
  	$(window).hashchange( function() {
		var hash = location.hash;
    
    	//need to parse the taglist from the anchor
    	var matchtags = window.location.href.match(/^[^#]+#([a-z,-]+(?:\/[a-z,-]+)*)/);	//TODO: change this to use window.location.hash
    	if (matchtags != null) {
    		//pass it to filter.php, we split by / so we need to change them to + for php's sake
    		query = "tags=" + matchtags[1].replace(/\//g, '+');
    		$.get("filter.php",query,function(data) {
    			$("#main").html(data);
    		});
    	} else {
    		//no tags so our query is nothing! take the rest of the day off!
    		query = "?";
    		$.get("filter.php",query,function(data) {
    			$("#main").html(data);
    		});
    	}

    	//TODO: we need to colour all the right tags
    	//change a.tag's so the selected ones are "hilite"d
       	$('a.tag').each(function(){
    		var that = $(this);
			var reg_pattern = '([\/]' + that.text() + ')|((?:^#)' + that.text() + '[\/]?)';
    		var re_this = new RegExp(reg_pattern,'g');
    		var taginurl = re_this.test(window.location.hash);

      		that[ taginurl ? 'addClass' : 'removeClass' ]( 'hilite' );
    	});
	});
  
  	// Since the event is only triggered when the hash changes, we need to trigger
  	// the event now, to handle the hash the page may have loaded with.
  	$(window).hashchange();
});