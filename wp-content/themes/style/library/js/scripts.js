$(document).ready(function($) {
  if($("#index-slider-content").length){
    $indexSlider = $("#index-slider-content");
    $indexSlider.owlCarousel({
      items: "1",
      loop:  true,
      mouseDrag: false,
    });
    $('.index-slider__next-btn').click(function() {
        $indexSlider.trigger('next.owl.carousel');
    });
    // Go to the previous item
    $('.index-slider__prev-btn').click(function() {
        $indexSlider.trigger('prev.owl.carousel');
    });
  }

var offscreenAddresses = $('#offscreen-addresses').scotchPanel({
    containerSelector: 'body', // As a jQuery Selector
    direction: 'top', // Make it toggle in from the left
    duration: 300, // Speed in ms how fast you want it to be
    transition: 'ease', // CSS3 transition type: linear, ease, ease-in, ease-out, ease-in-out, cubic-bezier(P1x,P1y,P2x,P2y)
    distanceX: '70%', // Size fo the toggle
    enableEscapeKey: true, // Clicking Esc will close the panel
    beforePanelOpen: function() {
      $('#toggle-addresses').addClass("open");
    },
    beforePanelClose: function() {
      $('.toggle-offcanvas').removeClass("open");
    },
});
$('#toggle-addresses').click(function() {
    offscreenAddresses.toggle();
    $('.top-offscreen').removeClass('open');
    $('#offscreen-addresses').addClass('open');
    return false;
});
var offscreenPhones = $('#offscreen-phones').scotchPanel({
    containerSelector: 'body', // As a jQuery Selector
    direction: 'top', // Make it toggle in from the left
    duration: 300, // Speed in ms how fast you want it to be
    transition: 'ease', // CSS3 transition type: linear, ease, ease-in, ease-out, ease-in-out, cubic-bezier(P1x,P1y,P2x,P2y)
    distanceX: '70%', // Size fo the toggle
    enableEscapeKey: true, // Clicking Esc will close the panel
    beforePanelOpen: function() {
      $('#toggle-phones').addClass("open");
    },
    beforePanelClose: function() {
      $('.toggle-offcanvas').removeClass("open");
    },
});
$('#toggle-phones').click(function() {
    offscreenPhones.toggle();
    $('.top-offscreen').removeClass('open');
    $('#offscreen-phones').addClass('open');
    return false;
});

if($(".product-slider__slide").length > 1){
    $productSlider = $("#product-slider-content");
    $productSlider.owlCarousel({
      items: "1",
      loop:  true,
      mouseDrag: false,
    });
    $('#next-btn')
      .click(function() {
        $productSlider.trigger('next.owl.carousel');
      })
      .removeClass('hidden')

    // Go to the previous item
    $('#prev-btn')
      .click(function() {
        $productSlider.trigger('prev.owl.carousel');
      })
      .removeClass('hidden')
}

if($('.hardware')){
    $('.hardware__tab').click(function () {
      $dataPane = $(this).data('tab');
      $target = $('[data-pane='+ $dataPane +'] img');
      lazyImages($target);
    })
    $target = $('.hardware__pane.active img');

    lazyImages($target);

    function lazyImages($id) {
      $id.each(function(index, value){
        $(this).attr('src', $(this).data('image'));
      });
    }
}

})


