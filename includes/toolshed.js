//return an array of tags from the anchors in the url
function match_anchor() {
  var hash = location.hash;
  var matchtags = window.location.href.match(/^[^#]+#([a-z,0-9,-]+(?:\/[a-z,0-9,-]+)*)/);
  var query = [];
  if (matchtags != null) {
    var query = matchtags[1].split('/');
  }
  return query;
}

function tmp_addpet(data) {
  //display "done" message
  $('div#newpostform').html(data);
  //refresh shown entries to show post was added (maybe highlight it?)
  var query = [];
  $.ajax({
    url: "filter.php",
    type: "POST",
    data: {'tags': query },
    success: refresh_postings
  });
}

function refresh_postings(data) {
  $('div#main').empty();
  display_postings(data);
}

function display_postings(data) {
  if(data == '[]' || data == "")         // returns a string containing [] rather than just null or something else for some reason...
    $('div#main').html("<DIV><P>No more entries found</P></DIV>");
  else {

    var it = $.parseJSON(data);
    var content = "";

    $.each(it, function(i, posting){
      content = content + create_post_html(posting);
    });

    if($(".posting:last").length == 0) //check if there're already posts
      $('div#main').html(content);
    else
      $(".posting:last").after(content);
  }
  $('div#lastPostsLoader').empty();
      // Need to lay all our hooks
    $("button.report").click(flagClick);
    $("button.refresh").click(refreshClick);
    $("button.message").click(messageClick);
    $("button.found").click(foundClick);

    $("div.posting").hover(function(){
        $("div#content", this).fadeIn();
      }, function() {
        $("div#content", this).fadeOut();
    });
}

function create_post_html(posting) {
  var html = "";
  html = html +"<A class='posting' href='?p="+posting.id+"'><DIV class='posting' id='"+posting.id+"'><IMG src='uploads/" + posting.photo+ "'/>";
  html = html + "<DIV id='content'>";
  html = html + "<DIV id='tags'>" + posting.tags + "</DIV>";
  html = html + "</DIV></DIV></A>";
  return html;
}

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

  // display lightbox menu
  $('.sendmessagebox').css("visibility", "visible");

  //user clicked cancel, so hide everything
  $('.sendmessagebox_cancel').click(function(){
    $('.sendmessagebox').css("visibility", "hidden");
  });

  $('.sendmessagebox_submit').click(function() {
    
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
    });  
  });
}

function foundClick() {
  $post_id = $(this).attr('post');
  var $submit_button = $(this);

  // display lightbox menu
  $('.delmessagebox').css("visibility", "visible");

  //user clicked cancel, so hide everything
  $('.delmessagebox_cancel').click(function(){
    $('.delmessagebox').css("visibility", "hidden");
  });

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

// get post data for "infinite scroll"
//TODO: don't show loader if there's no more posts
function loadMorePosts()
{
  $('div.lastPostLoader').html('<img src="includes/bigLoader.gif"/>');
  var query = match_anchor();
  var lastid = $(".posting:last").attr("id");
  $.ajax({
    url: "filter.php",
    type: "POST",
    data: {'tags': query,
            'id': lastid },
    success: display_postings
  });
};