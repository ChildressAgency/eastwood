/*!
 * theme custom scripts
*/

jQuery(document).ready(function($){
  $('.dropdown-menu.mega-menu .mega-top-nav .nav-link').on('click', function(e){
    e.preventDefault();
    
    $(this).tab('show');

    return false;
  });

  $('.mega-menu').on('mouseover', '.mega-sub-nav .nav-link', function(){
    var menuImgTargetID = $(this).data('menu_img_target');
    var menuImgSrc = $(this).data('menu_img');
    var menuImgAlt = $(this).data('menu_img_alt');

    var $menuImgTarget = $('#' + menuImgTargetID);

    $($menuImgTarget).attr('src', menuImgSrc);
    $($menuImgTarget).attr('alt', menuImgAlt);
  });

  $('#hero-carousel.carousel-heights .carousel-inner .carousel-item').carouselHeights();
  $('#testimonial-carousel.carousel-heights .carousel-inner .carousel-item').carouselHeights();

  var $animationElement = $('#planer-animation img');
  var $window = $(window);

  if($($animationElement).length){
    $window.on('scroll resize', isInViewport);
  }

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

  /**
   * WooCommerce Product Category Accordion jQuery Menu
   * @link https://wpbeaches.com/woocommerce-accordion-style-expand-collapse-product-category-menu/
   */

  if ($('ul.product-categories').length > 0) {

    // Set variables
    // pC = Parent Category 
    // fpC = First Parent Category
    // cC = Current Category
    // cCp = Currents Category's Parent

    var
      pC = $('.product-categories li.cat-parent'),
      fpC = $('.product-categories li.cat-parent:first-child'), // Start this one open
      cC = $('.product-categories li.current-cat'),
      cCp = $('.product-categories li.current-cat-parent');

    pC.prepend('<span class="toggle"><i class="far fa-minus-square fa-plus-square"></i></span>');
    pC.parent('ul').addClass('has-toggle'); pC.children('ul').hide();

    if (pC.hasClass("current-cat-parent")) {
      cCp.addClass('open'); cCp.children('ul').show(); cCp.children().children('i.far').removeClass('fa-plus-square');
    }
    else if (pC.hasClass("current-cat")) {
      cC.addClass('open'); cC.children('ul').show(); cC.children().children('i.far').removeClass('fa-plus-square');
    }
    else {
      fpC.addClass('open'); fpC.children('ul').show(); fpC.children().children('i.far').removeClass('fa-plus-square');
    }

    $('.has-toggle span.toggle').on('click', function () {
      $t = $(this);
      if ($t.parent().hasClass("open")) {
        $t.parent().removeClass('open'); $t.parent().children('ul').slideUp(); $t.children('i.far').addClass('fa-plus-square');
      }
      else {
        $t.parent().parent().find('ul.children').slideUp();
        $t.parent().parent().find('li.cat-parent').removeClass('open');
        $t.parent().parent().find('li.cat-parent').children().children('i.far').addClass('fa-plus-square');

        $t.parent().addClass('open');
        $t.parent().children('ul').slideDown();
        $t.children('i.far').removeClass('fa-plus-square');
      }

    });


    // Link the count number
    $('.count').css('cursor', 'pointer');
    $('.count').on('click', function (event) {
      $(this).prev('a')[0].click();
    });

  }

  $('#product-inquiry-modal').on('show.bs.modal', function(e){
    var button = $(e.relatedTarget);
    var productName = button.data('product_name');
    var productSku = button.data('product_sku');

    var modal = $(this);
    modalTitle = productName + '<small class="d-block">Product Sku: ' + productSku + '</small>';
    modal.find('.modal-title').html(modalTitle);
    modal.find('#product-name').val(productName);
    modal.find('#product-sku').val(productSku);
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

  $('.locations-map').each(function () {
    map = new_map($(this));
  });
};

/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function new_map($el) {

  // var
  var $markers = $el.find('.marker');


  // vars
  var args = {
    zoom: 16,
    center: new google.maps.LatLng(0, 0),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };


  // create map	        	
  var map = new google.maps.Map($el[0], args);


  // add a markers reference
  map.markers = [];


  // add markers
  $markers.each(function () {

    add_marker($(this), map);

  });


  // center map
  center_map(map);


  // return
  return map;

}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker($marker, map) {

  // var
  var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));

  // create marker
  var marker = new google.maps.Marker({
    position: latlng,
    map: map
  });

  // add to array
  map.markers.push(marker);

  // if marker contains HTML, add it to an infoWindow
  if ($marker.html()) {
    // create info window
    var infowindow = new google.maps.InfoWindow({
      content: $marker.html()
    });

    // show info window when marker is clicked
    google.maps.event.addListener(marker, 'click', function () {

      infowindow.open(map, marker);

    });
  }

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map(map) {

  // vars
  var bounds = new google.maps.LatLngBounds();

  // loop through all markers and create bounds
  $.each(map.markers, function (i, marker) {

    var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());

    bounds.extend(latlng);

  });

  // only 1 marker?
  if (map.markers.length == 1) {
    // set center of map
    map.setCenter(bounds.getCenter());
    map.setZoom(16);
  }
  else {
    // fit to bounds
    map.fitBounds(bounds);
  }

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/
// global var
var map = null;