$(function () {
    //Adjust height of sidebar and content to always be aligned independent of the page
    let contentHeight = $(".app_content").height();
    let sideBarHeight = $(".app_sidebar").height();
    if (contentHeight < $(window).height()) {
        $(".app_container").css("height", "100%");
    }

    if (contentHeight > sideBarHeight) {
        $(".app_sidebar").attr('style', function (i, style) {
            return style + 'height: 100% !important;';
        });
    }


});


