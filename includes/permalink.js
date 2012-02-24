
$(document).ready(function() { 
	var perma = $('div.main').attr('perma');
	console.log(perma);
	$.ajax({
      url: "filter.php",
      type: "POST",
      data: {'perma': perma },
      success: display_postings
    });
});