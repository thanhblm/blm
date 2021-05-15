
$(document).ready(function () {
    resizeBlocks(".achievements .block");
    resizeBlocks(".f-block");
    resizeBlocks(".q-block");
    resizeBlocks(".map .col-sm-6")
    
    $("#top_line").each(function () {
        var a = $(this),
            d = a.find(".bubble"),
            h = a.find(".slide"),
            g = null;
        a.on("click", ".bubble", function () {
            clearTimeout(g);
            var a = d.index(this);
            d.removeClass("sel").eq(a).addClass("sel");
            h.removeClass("active").eq(a).addClass("active");
            ++a >= d.length && (a = 0);
            g = setTimeout(function () {
                d.eq(a).click()
            }, 1E3 * (h.eq(a).data("delay") || 6));
            return !1
        });
        d.eq(0).click()
    });

    $(".bestsellers").slick({
        infinite: !0,
        slidesToShow: 4,
        slidesToScroll: 4,
        centerMode: !1,
        centerPadding: "0px",
        prevArrow: '<a href="javascript: void(0)" class="slick-prev"><span class="sprite carousel_prev"></span></a>',
        nextArrow: '<a href="javascript: void(0)" class="slick-next"><span class="sprite carousel_next"></span></a>',
        responsive: [{
            breakpoint: 1280,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }, {
            breakpoint: 1024,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }, {
            breakpoint: 768,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }, {
            breakpoint: 560,
            settings: {
                arrows: !0,
                centerMode: !1,
                centerPadding: "0px",
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });
    $("a.youtube-video").fancybox({
        padding: 0,
        autoScale: !1,
        transitionIn: "none",
        transitionOut: "none",
        width: 640,
        height: 385,
        type: "iframe",
        swf: {
            wmode: "transparent",
            allowfullscreen: "true"
        }
    });

    var a = !1;
    jQuery(".readMoreButton").click(function () {
        if (a) $(".readMoreBlocks").css("max-height", "402px"), $(".readMoreBlocks").css("margin-bottom", "20px"), a = !1, $(this).find("span.read-less").fadeOut("normal", function () {
            $(".readMoreButton span.read-more").fadeIn("normal")
        });
        else {
            var c = $(".readMoreBlocks .block").first().height() + 30;
            $(".readMoreBlocks").css("max-height", c);
            $(".readMoreBlocks").css("margin-bottom", "0");
            a = !0;
            $(this).find("span.read-more").fadeOut("normal", function () {
                $(".readMoreButton span.read-less").fadeIn("normal")
            })
        }
    });
});
$(window).resize(function () {
    resizeBlocks(".achievements .block");
    resizeBlocks(".f-block");
    resizeBlocks(".q-block");
    resizeBlocks(".map .col-sm-6")
});
function resizeBlocks(a) {
    var d = Math.max.apply(null, $(a).map(function () {
        return $(this).height()
    }).get());
    $(a).height(d)
};

$(".bestsellers").on("beforeChange", function (a, c, d, h) {
    a = h - 1;
    c = h - 2;
    d =
        $(window).width();
    $(".slick-slide .slick-inside .sep").hide();
    480 < d && ($('.slick-slide[data-slick-index="' + h + '"] .slick-inside .sep').show(), $('.slick-slide[data-slick-index="' + a + '"] .slick-inside .sep').show());
    768 < d && $('.slick-slide[data-slick-index="' + c + '"] .slick-inside .sep').show()
});
var a = "";
$(".slick-initialized .slick-slide .slick-inside ").each(function () {
    var c = $(this);
    $(this).find(".testimonial-carousel a");
    c.find(".title").height();
    a = a > $(this).find(".title").height() ? a : $(this).find(".title").height()
});
$(".slick-initialized .slick-slide .slick-inside .title").css("height", a);
var d = $(window).width();
$(".slick-slide .slick-inside .sep").hide();
480 < d && ($('.slick-slide[data-slick-index="0"] .slick-inside .sep').show(), $('.slick-slide[data-slick-index="-1"] .slick-inside .sep').show());
768 < d && $('.slick-slide[data-slick-index="-2"] .slick-inside .sep').show();
$(window).load(function () {
    var a = $(window).width(), c = 172 - (39 - parseInt($(".jas-navigation .jas-navigation-top img").height()));
    $(".navbar-nav .dropdown-menu").css("top",
        c + "px");
    1200 >= a && $(".navbar-nav .dropdown-menu").css("top", "100px")
});

var block_height;
function find_out_more(a) {
    var d = jQuery("#our_intro_categories");
    if (d.length) {
        var h = 300;
        $(document).scrollTop() + 92 == d.offset().top && (h = 1);
        jQuery("html, body").animate({scrollTop: d.offset().top - 92}, h, function () {
            $(".our_categories").css("overflow", "hidden");
            $("#intro_product_" + a).css("top", block_height + 40);
            $("#intro_product_" + a).show();
            $(".our_categories").animate({height: $("#intro_product_" + a).outerHeight(!0) - 10}, 300, function () {
                $("#intro_product_" + a).animate({top: -40}, 300, function () {
                })
            })
        })
    }
}
function close_more(a) {
    $(".our_categories").css("overflow", "hidden");
    $("#intro_product_" + a).css("top", -40);
    $("#intro_product_" + a).show();
    $(".our_categories").height("auto");
    $("#intro_product_" + a).animate({top: block_height + 40}, 500, function () {
        $(this).hide()
    })
}
jQuery(function () {
    cacheVariables();
    setDynamicVars();
    setSlidesWidth();
    _leftArrow.click(function () {
        leftArrowClick();
        return !1
    });
    _rightArrow.click(function () {
        rightArrowClick();
        return !1
    });
    jQuery(window).resize(function () {
        setDynamicVars();
        setSlidesWidth();
        leftSlideIndex = 0;
        changeLeftSlide(leftSlideIndex)
    })
});
var slidesCount = 9,
    slidesVisible = 9,
    leftSlideIndex = 0,
    sliderWidth = 0,
    slideWidth = 0,
    actualVisibleSlidesWidth = 0,
    minSlideWidth = 220,
    _historySlider, _historySliderInner, _historySlides, _leftArrow, _rightArrow, _historySlide;

function cacheVariables() {
    _historySlider = jQuery(".historySlider");
    _historySliderInner = jQuery(".historySliderInner");
    _historySlides = jQuery(".historySlides");
    _leftArrow = _historySlider.find(".arrowLeft");
    _rightArrow = _historySlider.find(".arrowRight");
    _historySlide = jQuery(".historySlide")
}

function setDynamicVars() {
    sliderWidth = jQuery(".historySlider").outerWidth();
    slidesVisible = Math.floor(sliderWidth / minSlideWidth);
    slideWidth = Math.floor(sliderWidth / slidesVisible);
    actualVisibleSlidesWidth = slideWidth * slidesVisible;
    _historySliderInner.width(actualVisibleSlidesWidth - 1);
    _historySlider.find(".arrowLeft").css("visibility", "hidden")
}

function setSlidesWidth() {
    _historySlide.width(slideWidth)
}

function changeLeftSlide(a) {
    setTranslate3d(_historySlides, -1 * a * slideWidth, 0, 0)
}
function setTranslate3d(a, d, h, c) {
    a.css("transform", "translate3d(" + d + "px," + h + "px," + c + "px)");
    a.css("-ms-transform", "translate3d(" + d + "px," + h + "px," + c + "px)");
    a.css("-webkit-transform", "translate3d(" + d + "px," + h + "px," + c + "px)");
    a.css("-moz-transform", "translate3d(" + d + "px," + h + "px," + c + "px)")
}

jQuery(function () {
    cacheVariables();
    setDynamicVars();
    setSlidesWidth();
    _leftArrow.click(function () {
        leftArrowClick();
        return !1
    });
    _rightArrow.click(function () {
        rightArrowClick();
        return !1
    });
    jQuery(window).resize(function () {
        setDynamicVars();
        setSlidesWidth();
        leftSlideIndex = 0;
        changeLeftSlide(leftSlideIndex)
    })
});