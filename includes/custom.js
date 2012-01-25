
// on load page...
$(document).ready(function() {
    
   // setInterval("checkAnchor()", 30);
   //$('a.tag').toggle(tagSelect,tagDeselect);

   query = "?";
   $.get("filter.php",query, function(data) {
            $("#main").html(data);
   });
});


function tagSelect() {
    $(this).addClass("hilite");
    //need to add addition of tag to anchor
}

function tagDeselect() {
	$(this).removeClass("hilite");
	//need to add removal of tag from anchor
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
    	query = "tags=" + hash.replace( /^#/, '' );
    	$.get("filter.php",query,function(data) {
    		$("#main").html(data);
    	});
    		//need to parse the taglist from the anchor
    		//pass it to filter.php
    		//display results
    	//rewrite the urls on the existing tag links so they include the new addition to the anchor and so the selected ones are "hilite"d
    	$('.tag').each(function(){
    		var that = $(this);
      		that[ that.attr( 'href' ) === hash ? 'addClass' : 'removeClass' ]( 'hilite' );
    	})

    //
  })
  
  // Since the event is only triggered when the hash changes, we need to trigger
  // the event now, to handle the hash the page may have loaded with.
  $(window).hashchange();
  
});



//




var currentAnchor = null;

function checkAnchor() {
	//Check if it has changes
	if(currentAnchor != document.location.hash) {
		currentAnchor = document.location.hash;
		//if there is not anchor, the loads the default section
		if(!currentAnchor)
			query = "g=1";
		else
		{
			//Creates the  string callback. This converts the url URL/#main&amp;amp;id=2 in URL/?section=main&amp;amp;id=2
			var splits = currentAnchor.substring(1).split('&amp;amp;');
			//Get the section
			var section = splits[0];
			delete splits[0];
			//Create the params string
			var params = splits.join('&amp;amp;');
			var query = "g=" + section + params;
		}
		//Send the petition
		$.get("filter.php",query, function(data) {
			$("#main").html(data);
		});
	}
}