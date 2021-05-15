var top2BottomHeight;
$(document).ready(function () {
    $("#sticky-navbar").stick_in_parent({
        parent: "body"
    });
    $("#sticky-navbar-cat").stick_in_parent({
        parent: "body",
        offset_top: $("#sticky-navbar").outerHeight()
    });

    $("#cart-basket").mouseover(function () {
        $(".top-card-container").addClass("hover");
    });
    $("#cart-basket").mouseout(function (event) {
        $(".top-card-container").removeClass("hover");
    });

    stickFooter();

    $(".num").knob({
        min: 0,
        max: 100,
        step: 1,
        angleOffset: 0,
        angleArc: 360,
        stopper: !0,
        readOnly: !1,
        cursor: !1,
        lineCap: "butt",
        thickness: "0.05",
        width: 137,
        height: 137,
        displayInput: !0,
        displayPrevious: !0,
        fgColor: "#80AD00",
        inputColor: "#0E4145",
        font: "Arial",
        fontWeight: "normal",
        bgColor: "#80ad00",
        readOnly: !0,
        draw: function () {
            $(this.i).css({
                "font-size": "22px",
                "margin-top": "30px"
            });
            0 == $(this.i).val() && $(this.i).val(this.cv + "%")
        }
    });
    resizeFooterBar();
});
$(window).resize(function () {
    resizeFooterBar();
});
$(window).scroll(function () {
   stickFooter();
});

function stickFooter() {
    var top2BottomHeight = $(document).height() - $("#footer-bar").height();
    if ($(window).scrollTop() < top2BottomHeight) {
        $("#footer-bar").addClass("sticky-footer");
    } else {
        $("#footer-bar").removeClass("sticky-footer");
    }
}

function resizeFooterBar() {
    if ($(window).width() <= 768) {
        if ($("#footer-bar").hasClass("container-fluid")){
            $("#footer-bar").removeClass("container-fluid");
            $("#footer-bar").addClass("container");
        }
    } else {
        if ($("#footer-bar").hasClass("container")){
            $("#footer-bar").removeClass("container");
            $("#footer-bar").addClass("container-fluid")
        }
    }
}

