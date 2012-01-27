$(document).ready(function() {
   $('.lightbox_trigger').click(lightbox);
   $('span.tag').click(tagClick);
});

function lightbox() { 
	//fill our lightbox with the text of each "hilite"d tag
	var $selected = [];
	$(".hilite").each(function() {
		$selected.push($(this).text());
	});
	$("#tag_list").html('"' + $selected.join('", "') + '"');
	$("#chosen_tags").val($selected.join(' '));
	//display lightbox
	$('.lightbox').css("visibility", "visible");

	//disappear when the user clicks cancel
    $('.lightbox_cancel').click(function(){
    	$('.lightbox').css("visibility","hidden");
    });
}

//rewrites the url properly when a tag is clicked
function tagClick() {
	$(this).addClass("hilite");
    return false;																			//this stops the rest of the click event happening (i.e. the url ressetting to the actual href (just the one tag) of the link)
}