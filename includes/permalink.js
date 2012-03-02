
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
    html = html + "<DIV id='buttons'><A href='#' class='button' id='message' post='" + posting.id + "'>Reply</A><A href='#' class='button' id='refresh' post='" + posting.id + "'>Refresh</A><A href='#' class='button' id='found' post='" + posting.id + "'>Delete</A><A href='#' class='button' id='report' post='" + posting.id + "'>Flag</A></DIV>";
    html = html + "</DIV>";
  });
  $('div#main').html(html);
  // Need to lay all our hooks
  $("a#report").click(flagClick);
  $("a#refresh").click(refreshClick);
  $("a#message").click(messageClick);
  $("a#found").click(foundClick);
}

function flagClick() {

  var $post_id = 0;
  $post_id = $(this).attr('post');

  $.ajax({
    url: "flag.php",
    type: "POST",
    data: {'id': $post_id },
    success: function(data) {
      //hide button

    }
  });
  $(this).fadeOut('slow');
}

function refreshClick() {

  var $post_id = 0;
  $post_id = $(this).attr('post');

  $.ajax({
    url: "refresh.php",
    type: "POST",
    data: {'id': $post_id },
    success: function(data) {
      //hide button
    }
  });
  $(this).fadeOut('slow');
}

function messageClick() {
  $post_id = $(this).attr('post');
  var $submit_button = $(this);

  $('div#delmessagebox').hide(); // just in case
  $('div#sendmessagebox').fadeIn();

  $('.send_submit').click(function() {
/*    
    $from = 'daniel.doyle@gmail.com';
    $content = "hi";

    $from = $('input[name=from]').val();
    $content = $('textarea[name=content]').val();

    $.ajax({
      url: "message.php",
      type: "POST",
      data: {'id': $post_id,
            'from': $from,
            'content': $content },
      success: function(data) {
        //hide button
        // replace smb_content to show success message
        $('.smb_content').html('Message sent!<br /><BUTTON type="button" class="sendmessagebox_close">Close</BUTTON>');
        $('div.sendmessagebox p').html('Click "Close" to close');
        $('.sendmessagebox_close').click(function() {
          $('.sendmessagebox').css("visibility", "hidden"); 
          $submit_button.fadeOut('slow');                   // fade out the original reply button, shouldn't happen until submit is clicked
          $('.smb_content').load('index.php div.smb_content'); //rewrite the form back in
        });
      }
    });  */
  });

  return false;
}

function foundClick() {
  $post_id = $(this).attr('post');
  var $submit_button = $(this);

  $('div#sendmessagebox').hide(); // just in case
  $('div#delmessagebox').fadeIn();

  $('.delmessagebox_submit').click(function() {
    $user = $('input[name=user]').val();
    console.log($user)
    $.ajax({
      url: "delete.php",
      type: "POST",
      data: {'id': $post_id,
            'user': $user },
      success: function(data) { 
        console.log(data);
        //reload posts
        $(window).hashchange();
        //success message
        $('.dmb_content').html('Post deleted<br /><BUTTON type="button" class="delmessagebox_close">Close</BUTTON>');
        $('div.delmessagebox p').html('Click "Close" to close');
        $('.delmessagebox_close').click(function() {
          $('.delmessagebox').css("visibility", "hidden");
          $('.dmb_content').load('index.php div.dmb_content'); //rewrite the form back in
        });
      }
    });
  });
}