  $(document).ready(function() {

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
    },
    onComplete: function(file, response) {
      thumb.load(function(){
        $('div#photobox').removeClass('loading');
        thumb.unbind();
      });
      thumb.attr('src', 'tmp/'+response);
      $('input#photo_name').val(response);
      $('div#photobox').css({display: "block"});
      $('img#thumb').imgAreaSelect({aspectRatio: '5:3', handles: "corners"});
    }
  });

  //pet add
  $('button.pet_add_submit').click( function(){
    //get data from form
    //send to addpet.php
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
});