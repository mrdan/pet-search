$(document).ready(function() {
   $('.lightbox_trigger').click(lightbox);
   $('span.tag').toggle(selectTag, deselectTag);
});

//display the correct lightbox depending on the button clicked
function lightbox() { 
	var $button = $(this).attr('name');
	//fill our lightbox with the text of each "hilite"d tag
	var $selected = [];
	$(".hilite").each(function() {
		$selected.push($(this).text());
	});
	if ($selected.length > 0)
		$("#tag_list").html('"' + $selected.join('", "') + '"');
	else
		$("#tag_list").html('no tags selected!');
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

function selectTag() {
	$(this).addClass("hilite");
}

function deselectTag() {
	$(this).removeClass("hilite");
}