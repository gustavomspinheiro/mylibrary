$(function () {

    var timeEffect = 1000;

    //GENERAL
    $(window).on("load", function (e) {
        $(".main_banner_images img").show(2000);
    });

    //*** HOME PAGE ***

    

    //REFERENCE CID
    $(".main_highlights_list").css("display", "none");
    $(".main_highlight_button").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass("icon-plus icon-minus");
        $(this).next("ul").stop().slideToggle(timeEffect / 5);
    });

    //DISPLAY BUTTOM RETURN TO TOP
    $(window).on("scroll", function (e) {
        var positionTop = $(this).scrollTop();
        if (positionTop > 0) {
            //$(this).scrollTop(0);

            //utilizar efeito de show.
        }
    });

    //*** RESULT PAGE ***

    //DISPLAY RESULT TO USER
    $(".result_desc").fadeIn(timeEffect * 4);



});
