$(function(){
  
  // Bind an event to window.onhashchange that, when the hash changes, activates
  $(window).hashchange( function() {
    var hash = location.hash;
    
    //need to parse the taglist from the anchor
    var query = match_anchor();

    if (query.length == 0) {
      $('span#tags_chosen').text('some');
      $('div#first').css('color', 'black');
      $('input#sub_tags').val('');
    } else {    
      $('span#tags_chosen').text('these');
      $('input#sub_tags').val(query.join(' '));
      $('div#first').css('color', 'grey');
    }

    $.ajax({
      url: "filter.php",
      type: "POST",
      data: {'tags': query },
      success: refresh_postings
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

$(document).ready(function() {

  // scroll detection for "infinite scroll"
  $(window).scroll(function(){
    var bufferzone = $(window).scrollTop() * 0.20;
    if  ( $(window).scrollTop() + bufferzone > ( $(document).height()- $(window).height() ) ) {
      loadMorePosts();
    }

    /* Back to top by http://agyuku.net/2009/05/back-to-top-link-using-jquery/ */
    if($(this).scrollTop() != 0) {
      $('.toTop').fadeIn(); 
    } else {
      $('.toTop').fadeOut();
    }
  });
 
  $('.toTop').click(function() {
    $('body,html').animate({scrollTop:0},800);
  }); 

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

  //photo upload
  var $randomnumber=Math.floor(Math.random()*1000000000000)
  var $perm_name = new Date().getTime() + "." + $randomnumber;  // middle "" just makes the date a string so we dont just add two numbers together
  var thumb = $('img#thumb'); 

  var ajax_up = new AjaxUpload('imageUpload', {
    action: 'uploadimage.php',
    name: 'photo',
    data: {
      pext: '',
      pname : $perm_name
    },
    onSubmit: function(file, extension) {
      this.setData({'pext': extension, 'pname': $perm_name});
      this.disable();
      $('div#photobox').addClass('loading');
      $("div#photobox").slideDown();
    },
    onComplete: function(file, response) {
      thumb.load(function(){
        $('div#photobox').removeClass('loading');
        thumb.unbind();
      });
      thumb.attr('src', 'tmp/'+response);
      $('input#photo_name').val(response);
      this.enable();
    }
  });

  //pet add
  $('button.pet_add_submit').click( function(){
    //get data from form
    //send to addpet.php
    console.log($('input[name=username]').val());
    $.ajax({
      url: "addpet.php",
      type: "POST",
      data: {
        'tags': $('input#sub_tags').val(),
        'photo': $('input#photo_name').val(),
        'email': $('input#email').val(),
        'username': $('input[name=username]').val()
      },
      //process response
      success: tmp_addpet,
      //change ui appropriately
      //if successful clear form
      //if not highlight problem if possible
    });
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

