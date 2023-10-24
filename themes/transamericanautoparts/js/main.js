// Toggle Mobile Menu

$(function() {                       
  $(".TAP-mobile-menu-toggle").click(function() { 
    $(this).toggleClass("active");
    $(this).attr('aria-expanded', 'true');
    $(".TAP-navigation__menu").toggleClass("active");     
  });

  $(".menu-item-has-children").click(function() {
  	$(".menu-item-has-children .sub-menu").toggleClass("active");
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


// SLICK INITIALIZATION FOR SINGLE PRODUCT PAGE SLIDER WITH SLIDER NAV
(function( $ ) {
	$('.slider-for').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  fade: true,
	  asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
	  slidesToShow: 3,
	  slidesToScroll: 1,
	  asNavFor: '.slider-for',
	  dots: true,
	  centerMode: false,
	  focusOnSelect: true
	});
})( jQuery );


//We're going to hack the Ajax Search plugin to change the close button html tag from Div to Button
(function($) {
    $.fn.changeElementType = function(newType) {
        var attrs = {};

        $.each(this[0].attributes, function(idx, attr) {
            attrs[attr.nodeName] = attr.nodeValue;
        });

        this.replaceWith(function() {
            return $("<" + newType + "/>", attrs).append($(this).contents());
        });
    }
})(jQuery);

$(".proclose").changeElementType("button");
$(".proclose").attr("type","button");


// Add role="button" and tabindex="0" to jquery modal close button
$('body').on('DOMNodeInserted', '.close-modal', function () {
      $('.close-modal').attr({ role:"button", tabindex:"0" });
});

// So, for some reason, aria-hidden="true" is getting added to the mobile menu icon. I'm removing it here, for accessibility purposes
$('body').on('DOMNodeInserted', '.fa-bars', function () {
      $('.fa-bars').removeAttr('aria-hidden');

});



  
  // Swapping out Image for Video Embed
  // Toggling a video placeholder
  $('[data-bg-video-url]').on('click',function(){

      // Set attribute name
      var atttribute_name = "data-bg-video-url";

      // Set "this"
      var current_block = $(this);

      // Get the URL
      var video_url = $(this).attr(atttribute_name);

      console.log("Video URL: "+video_url);

      // Is it Youtube?
      if(video_url.includes('youtube') || video_url.includes('you')) {

          console.log("Youtube");

          $.ajax({
              method: "GET",
              url: "https://www.youtube.com/oembed",
              data: {
                  url: video_url,
                  autoplay: 1
              }
          }).done(function(output) {

              // Make sure we have an iframe
              if(output.html) {
                  current_block.append(output.html);
                  current_block.removeAttr(atttribute_name);
              }

          });

      }

      // If it's a Vimeo video
      else if(video_url.includes('vimeo')) {

          console.log("Vimeo");

          $.ajax({
              method: "GET",
              url: "https://vimeo.com/api/oembed.json",
              data: {
                  url: video_url,
                  autoplay: true
              }
          }).done(function(output) {

              // Make sure we have an iframe
              if(output.html) {
                  current_block.append(output.html);
                  current_block.removeAttr(atttribute_name);
              }

          });

      }

      else {

          console.log("No video");

      }

  });


