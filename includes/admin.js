$(document).ready(function() {
   $('.lightbox_trigger').click(lightbox);
   $('span.tag').toggle(selectTag, deselectTag);

   $("input.newText").focus(function(srcc)
    {
        if ($(this).val() == $(this)[0].title)
        {
            $(this).removeClass("newTextActive");
            $(this).val("");
        }
    });
    
    $("input.newText").blur(function()
    {
        if ($(this).val() == "")
        {
            $(this).addClass("newTextActive");
            $(this).val($(this)[0].title);
        }
    });
    
    $("input.newText").blur(); 
});

//display the correct lightbox depending on the button clicked
function lightbox() { 
	var $button = $(this).attr('name');
	//fill our lightbox with the text of each "hilite"d tag
	var $selected = [];
	$(".hilite").each(function() {
		$selected.push($(this).text());
	});
	console.log($selected);
	if ($selected.length > 0)
		$('span#tag_list').html('"' + $selected.join('", "') + '"');
	else
		$('span#tag_list').html('no tags selected!');
	$("input#chosen_tags").val($selected.join(' '));

	$('.lightbox').css("visibility", "visible");
	if($button == 'add')
		$('.lb_content#add').css("visibility", "visible");
	else if($button == 'recat')
		$('.lb_content#recat').css("visibility", "visible");
	else if($button == 'approve')
		$('.lb_content#approve').css("visibility", "visible");
	else if($button == 'delete')
		$('.lb_content#delete').css("visibility", "visible");
	else
		$('.lb_content#error').css("visibility", "visible");

	//user clicked cancel, so hide everything
	$('.lightbox_cancel').click(function(){
		$('.lightbox').css("visibility", "hidden");
		$('.lb_content').css("visibility","hidden");
	});
}

function selectTag() {
	$(this).addClass("hilite");
}

function deselectTag() {
	$(this).removeClass("hilite");
}