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

  //add a pet form using http://jacklmoore.com/colorbox/
  $('.addpetbutton').colorbox({
    iframe: true,
    width: "700px", 
    height: "750px",
    returnFocus: false
  });




});