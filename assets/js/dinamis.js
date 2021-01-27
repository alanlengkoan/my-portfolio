jQuery(window).bind('scroll', function () {

    if ($(window).scrollTop() > 100) {
        $('.my-nav').addClass('my-nav-fixed');
    } else {
        $('.my-nav').removeClass('my-nav-fixed');
    }
});

// Smooth scrolling using jQuery easing
$('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname ==
        this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            $('.navbar-toggler').removeClass('active');
            $('.navbar-collapse').removeClass('show');
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000, "easeInOutExpo");
            return false;
        }
    }
});

// bermain klik untuk scroll
$('.js-scroll-trigger').click(function () {
    $("#sidebar-wrapper").removeClass("active");
});

$('.chart').easyPieChart({
    scaleColor: false,
    lineWidth: 4,
    lineCap: 'butt',
    barColor: '#001B64',
    trackColor: "#f5f5f5",
    size: 160,
    animate: 1000
});

// untuk menu jika di hamberger
$(".icon").click(function (e) {
    e.preventDefault();
    $(".icon").toggleClass("active");
});

var fixed = false;
$(document).scroll(function () {
    if ($(this).scrollTop() > 250) {
        if (!fixed) {
            fixed = true;
            $('#keatas').show("slow", function () {
                $('#keatas').css({
                    position: 'fixed',
                    display: 'block'
                });
            });
        }
    } else {
        if (fixed) {
            fixed = false;
            $('#keatas').hide("slow", function () {
                $('#keatas').css({
                    display: 'none'
                });
            });
        }
    }
});

var typed = new Typed('#typed', {
    stringsElement: '#typed-strings',
    typeSpeed: 20,
    backSpeed: 20,
    startDelay: 1000,
    loop: true,
    loopCount: Infinity
});