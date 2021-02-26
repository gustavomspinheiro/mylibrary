$(function () {
    var timeEffect = 1000;

    //FORM SEND VIA AJAX
    $("form").on("submit", function (e) {
        e.preventDefault();
        var form = $(this);
        var formData = $(this).serialize();
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            dataType: "json",
            beforeSend: function () {
                $("form").find("button").after("<span class='load' style='font-weight: bold'>Carregando...</span>");
                $("form").find(".message").remove();
            },
            success: function (response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                }

                if (response.message) {
                    $(form).prepend(response.message);
                }

                if (response.reload) {
                    location.reload();
                }
            },
            complete: function () {
                $("form").find(".load").fadeOut(function () {
                    $(this).remove();
                });
                setInterval(function () {
                    $("form").find(".message").fadeOut(function () {
                        $(this).remove();
                    });
                }, 4000);
            }
        });
    });

    //MOBILE MENU
    var windowWidth = $(window).width();
    let headerNav = $(".main_header_nav");

    function closeMobile() {
        $(".main_header_nav_links").css("display", "none");
        $(".main_header_nav_mobile_menu").fadeIn("slow");
    }

    if (windowWidth <= 667) {
        //display mobile menu
        $(".main_header_nav_mobile_menu").on("click", function (e) {
            console.log("Click");
            e.preventDefault();
            $(".main_header_nav_links").css({
                "display": "block",
                "right": "auto"
            }).fadeIn(timeEffect / 10).animate({"left": "0"}, 200);
            $(this).fadeOut("fast");
        });

        //hide mobile menu
        $(".main_header_nav_list_close").on("click", function (e) {
            e.preventDefault();
            closeMobile();
        });

        $(document).on("click", function (e) {
            e.preventDefault();
            var clicked = e.target;
            if ($(clicked).parents(".main_header").length === 0) {
                closeMobile();
            }
        });
    }
});


