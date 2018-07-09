$(function(){
    //backTop();
    navigation();
    backTop();
})

function navigation(){
    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            $(".navbar").addClass('fixed');
        } else {
            $(".navbar").removeClass('fixed');
        };
    });
}

function backTop(){
    /*$(window).scroll(function () {
        if ($(window).scrollTop() > 600) {
            $("#backtotop").fadeIn(300);
        } else {
            $("#backtotop").fadeOut(300);
        };
    });*/
    
    $("#backtotop").click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 300);
        return false;
    });
}