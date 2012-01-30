$(document).ready(function() {
    
  $('a.tag').click(tagClick);

  $.ajax({
    url: "filter.php",
    data: { },
    success: function(html){
      $('div#main').html(html);
    }
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
    var matchtags = window.location.href.match(/^[^#]+#([a-z,0-9,-]+(?:\/[a-z,0-9,-]+)*)/);
    var query = [];
    if (matchtags != null) {
      var query = matchtags[1].split('/');
    }

    $.ajax({
      url: "filter.php",
      type: "POST",
      data: {'tags': query },
      success: function(html) {
        $('div#main').html(html);
      }
    });
    

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