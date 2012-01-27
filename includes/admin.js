$(document).ready(function() {
   $('.lightbox_trigger').click(lightbox);
   $('span.tag').click(tagClick);
});

function lightbox() { 
	var $button = $(this).attr('name');
	//fill our lightbox with the text of each "hilite"d tag
	var $selected = [];
	$(".hilite").each(function() {
		$selected.push($(this).text());
	});
	$("#tag_list").html('"' + $selected.join('", "') + '"');
	$("#chosen_tags").val($selected.join(' '));

	$('.lightbox').css("visibility", "visible");
	if($button == 'recat')
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

//rewrites the url properly when a tag is clicked
function tagClick() {
	$(this).addClass("hilite");
    return false;																			//this stops the rest of the click event happening (i.e. the url ressetting to the actual href (just the one tag) of the link)
}