function hide_popup(){
	$("#popup_mask").hide();
    $("#fb_like_popup").hide();
}

function show_popup(obj){

	$("#popup_title").html(obj.title);
	$("#popup_message").html(obj.message);
	//$("#popup_close").html('<input type="button" name="button1" value="Close"/>');
	if(obj.confirm=='' || obj.confirm == undefined || obj.confirm==null){
		//$("#fb_popup_close").hide();
		$("#popup_close").hide();
	} else {
		//$("#fb_popup_close span").html(obj.confirm).show();
		$("#popup_close").html('<input type="button" name="button1" value="'+obj.confirm+'"/>').show();
	}

	var windowWidth = $(window).width();
	var windowHeight = $(window).height();

	popupWidth = $("#fb_like_popup").width();
	popupHeight = $("#fb_like_popup").height();

	var popup_left = (windowWidth - popupWidth) / 2;
	var popup_top = $(document).scrollTop() + (windowHeight - popupHeight ) / 2;

	if(obj.height){
		popup_top = obj.height;
	}
	
	$("#fb_like_popup").css({
		"left" : popup_left,
		"top"  : popup_top
	})

	$("#popup_mask").show();
	$("#fb_like_popup").show();
}

$(document).ready(function() {
    $("#popup_mask").css({
	"width" : $(document).width(),
	"height": $(document).height()
	}).hide();
	
    $("#popup_close").bind("click", function(evt){
	    evt.preventDefault();
	    hide_popup();
    });
});