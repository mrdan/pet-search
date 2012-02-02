$(document).ready(function() {
  //select tags
  $('a.tag').click(tagClick);

  //add a pet form
  $('div#newpostbutton').toggle(function () {
    $("div#newpostform").slideDown();
  },function () {
    $("div#newpostform").slideUp();
  });

  //form email
  $("input.newText").focus(function(srcc) {
    if ($(this).val() == $(this)[0].title)
    {
      $(this).removeClass("newTextActive");
      $(this).val("");
    }
  });
    
  $("input.newText").blur(function() {
    if ($(this).val() == "")
    {
      $(this).addClass("newTextActive");
      $(this).val($(this)[0].title);
    }
  });
    
  $("input.newText").blur();

  var thumb = $('img#thumb'); 

  new AjaxUpload('imageUpload', {
    action: 'uploadimage.php',
    name: 'photo',
    onSubmit: function(file, extension) {
      $('div#photobox').addClass('loading');
      $("div#photobox").slideDown();
    },
    onComplete: function(file, response) {
      thumb.load(function(){
        $('div#photobox').removeClass('loading');
        thumb.unbind();
      });
      thumb.attr('src', response);
    }
  });

  //photobox selection
  /*
  $('<div><img src="puppy1.jpg" style="position: relative;" /><div>')
        .css({
            float: 'right',
            position: 'relative',
            overflow: 'hidden',
            width: '100px',
            height: '100px'
        })
        .insertAfter($('#photobox_photo'));

  $('#photobox_photo').imgAreaSelect({
    aspectRatio: '1:1',
    handles: true,
    onSelectEnd: thumb_preview
  });
  */

});
/*
function thumb_preview(img, selection) {
    var scaleX = 100 / (selection.width || 1);
    var scaleY = 100 / (selection.height || 1);
  
    $('#photobox_photo + div > img').css({
        width: Math.round(scaleX * 150) + 'px', //needs to match any specified heigh of image in index.php
        height: Math.round(scaleY * 150) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
}*/

function display_postings(data) {
  if(data == '[]') {          // returns a string containing [] rather than just null or something else for some reason...
    var html = "<DIV class='posting'><P>No pets matching those tags found</P></DIV>";
    $('div#main').html(html);
  } else {
    var it = $.parseJSON(data);
    var html = "";
    $.each(it, function(i, posting){
      html = html +"<DIV class='posting'><IMG />";
      html = html + "<P><A href=''>" + posting.email + "</A></P>";
      html = html + "<P>" + posting.tags + "</P></DIV>";
    });
    $('div#main').html(html);
  }
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
      success: display_postings
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