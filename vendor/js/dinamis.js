$(document).ready(function(){

  // untuk menu jika di hamberger
  $(".icon").click(function(e) {
    e.preventDefault();
    $(".icon").toggleClass("active");
  });

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // bermain klik untuk scroll
  $('.js-scroll-trigger').click(function() {
    $("#sidebar-wrapper").removeClass("active");
  });

  //#to-top button appears after scrolling
  var fixed = false;
  $(document).scroll(function() {
    if ($(this).scrollTop() > 250) {
      if (!fixed) {
        fixed = true;
        $('#keatas').show("slow", function() {
          $('#keatas').css({
            position: 'fixed',
            display: 'block'
          });
        });
      }
    } else {
      if (fixed) {
        fixed = false;
        $('#keatas').hide("slow", function() {
          $('#keatas').css({
            display: 'none'
          });
        });
      }
    }
  });

  var animate = ScrollReveal();
  animate.reveal('#beranda', {
    delay: 500,
    duration: 2000,
    distance: '100px',
    origin: 'bottom',
    reset: true,
  });

  animate.reveal('#project', {
    delay: 500,
    duration: 2000,
    distance: '100px',
    origin: 'bottom',
    reset: true,
  });

  animate.reveal('#blog', {
    delay: 500,
    duration: 2000,
    distance: '100px',
    origin: 'bottom',
    reset: true,
  });

  animate.reveal('#footer', {
    delay: 500,
    duration: 2000,
    distance: '100px',
    origin: 'bottom',
    reset: true,
  });
  
});
