// Toggle Mobile Menu

  $(function() {                       
    $(".TAP-mobile-menu-toggle").click(function() { 
      $(this).toggleClass("active");
      $("#bs-example-navbar-collapse-1").toggleClass("active");     
    });
  });



  // SLICK INITIALIZATION FOR HOMEPAGE HERO SLIDER
  (function( $ ) {

  $('.TAP-homepage-hero__slider').slick();
  })( jQuery );



  // SLICK INITIALIZATION FOR HOMEPAGE SHOP BY MAKE SLIDER
  (function( $ ) {

  $('.TAP-homepage-shop-by-make__slider').slick({
    infinite: false,
    slidesToShow: 2,
    slidesToScroll: 1,
    dots: true
  })

  .on('setPosition', function (event, slick) {
    slick.$slides.css('height', slick.$slideTrack.height() + 'px');
  });



})( jQuery );



