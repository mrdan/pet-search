
$(document).ready(function() { 
	var perma = $('div.main').attr('perma');
	$.ajax({
      	url: "filter.php",
      	type: "POST",
      	data: {'perma': perma },
    	success: display_perma_post
    });
});

function display_perma_post(data) {
  if(data == '[]' || data == "" || data == '[null]') {        // returns a string containing [] rather than just null or something else for some reason...
    $('div#main').html("<DIV><P>Post not found</P></DIV>");
    return;
  }

  var it = $.parseJSON(data);
  var html = "";

  $.each(it, function(i, posting){
    html = html +"<DIV class='perma_posting' id='"+posting.id+"'>";
    html = html + "<DIV id='content'><IMG src='uploads/" + posting.photo+ "'/>";
    html = html + "<DIV id='tags'>" + posting.tags + "</DIV></DIV>";
    html = html + "<DIV id='buttons'><A href='' class='button' id='message' post='" + posting.id + "'>Reply</A><A href='' class='button' id='refresh' post='" + posting.id + "'>Refresh</A><A href='' class='button' id='found' post='" + posting.id + "'>Delete</A><A href='' class='button' id='report' post='" + posting.id + "'>Flag</A></DIV>";
    html = html + "</DIV>";
  });
  $('div#main').html(html);
}