function hide_popup(){
	$("#popup_mask").hide();
    $("#fb_like_popup").hide();
}

function go_invite(url) {
    hide_popup();
    top.location.href = url;
    //window.open(url);
}

function show_popup(obj){
        if(obj.invite=='none' || obj.invite=='' || obj.invite==null){
            $("#popup_invite").hide();
        } else {
            $("#popup_invite").html('<input type="button" name="button1" value="Invite Friends" onclick="go_invite(\''+obj.invite+'\');"/>').show();
        }
	$("#popup_title").html(obj.title);
	$("#popup_message").html(obj.message);
	
	if(obj.confirm=='none' || obj.confirm=='' || obj.confirm==null){
            $("#popup_close").hide();
	} else {
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
	
	if(popup_left < 0){
		popup_left = 0;
	}
	
	if(popup_top < 0){
		popup_top = 0;
	}
	
	var sumHeight = Number(popup_top.replace("px",""))+popupHeight;
	if(windowHeight < sumHeight){
		popup_top = windowHeight - popupHeight;
	}
	
	$("#fb_like_popup").css({
		"left" : popup_left,
		"top"  : popup_top
	})
	
	if(popupWidth > windowWidth){
		$('#fb_like_popup').css('width',windowWidth);
		$('.pop_container_advanced').css('width',windowWidth);
		$('.pop_content').css('width',windowWidth-40);
	}

	$("#popup_mask").show();
	$("#fb_like_popup").show();
	
	//$('body').animate({scrollTop : popup_top},'slow');
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