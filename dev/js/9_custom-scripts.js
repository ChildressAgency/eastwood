/*!
 * theme custom scripts
*/

jQuery(document).ready(function($){
  $('.dropdown-menu.mega-menu .mega-top-nav .nav-link').on('click', function(e){
    e.preventDefault();
    
    $(this).tab('show');

    return false;
  });

  $('.mega-sub-nav .nav-link').hover(function(){
    var menuImgTargetID = $(this).data('menu_img_target');
    var menuImgSrc = $(this).data('menu_img');
    var menuImgAlt = $(this).data('menu_img_alt');

    var $menuImgTarget = $('#' + menuImgTargetID);

    $($menuImgTarget).attr('src', menuImgSrc);
    $($menuImgTarget).attr('alt', menuImgAlt);
  });

  $('#hero-carousel.carousel-heights .carousel-inner .carousel-item').carouselHeights();

  var $animationElement = $('#planer-animation img');
  var $window = $(window);
  $window.on('scroll resize', isInViewport);

  function isInViewport(){
    var viewportHeight = $window.height();
    var viewportTopPosition = $window.scrollTop();
    var viewportBottomPosition = (viewportTopPosition + viewportHeight);

    var elementHeight = $animationElement.outerHeight();
    var elementTopPosition = $animationElement.offset().top;
    var elementBottomPosition = (elementTopPosition + elementHeight);

    if((elementBottomPosition >= viewportTopPosition) && (elementTopPosition <= viewportBottomPosition)){
      var scroll = (viewportTopPosition / viewportHeight) * 100;
      $animationElement.css('left', scroll + '%');
    }
  }

  $('#cat-list .nav-link').on('shown.bs.tab', function(e){
    $newImage = $(this).data('bg_image');

    $('#hp-explore').find('.image-side').css('background-image', 'url(' + $newImage + ')');
  });
}); //jQuery


/**
 * Normalize Carousel Heights
 */
$.fn.carouselHeights = function () {
  var items = $(this), //grab all slides
    heights = [], //create empty array to store height values
    tallest; //create variable to make note of the tallest slide

  var normalizeHeights = function () {
    items.each(function () { //add heights to array
      heights.push($(this).height());
    });
    tallest = Math.max.apply(null, heights); //cache largest value
    if(tallest < 300){ tallest = 300; }
    items.each(function () {
      $(this).css('min-height', tallest + 'px');
    });
  };

  normalizeHeights();

  $(window).on('resize orientationchange', function () {
    //reset vars
    tallest = 0;
    heights.length = 0;

    items.each(function () {
      $(this).css('min-height', '0'); //reset min-height
    });
    normalizeHeights(); //run it again 
  });
};
