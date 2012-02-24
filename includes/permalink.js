
$(document).ready(function() { 
	var perma = $('div.main').attr('perma');
	$.ajax({
      	url: "filter.php",
      	type: "POST",
      	data: {'perma': perma },
    	success: function(data) {
      		display_postings(data);
      		$("div.posting").hover(function(){
      			$("div#content", this).stop().fadeIn();
    		}, function() {
      			$("div#content", this).stop().fadeOut();
  			});
      	}
    });
});