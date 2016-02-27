$(document).ready(function($) {
  if($("#index-slider-content").length){
    $indexSlider = $("#index-slider-content");
    $indexSlider.owlCarousel({
      items: "1",
      loop:  true,
      mouseDrag: false,
      smartSpeed: 1000,
      fluidSpeed: 1000,

    });
    $('.index-slider__next-btn').click(function() {
        $indexSlider.trigger('next.owl.carousel');
    });
    // Go to the previous item
    $('.index-slider__prev-btn').click(function() {
        $indexSlider.trigger('prev.owl.carousel');
    });
  }
setTimeout(function () {
  var offscreenAddresses = $('#offscreen-addresses').scotchPanel({
      containerSelector: 'body', // As a jQuery Selector
      direction: 'top', // Make it toggle in from the left
      duration: 500, // Speed in ms how fast you want it to be
      transition: 'ease-in-out', // CSS3 transition type: linear, ease, ease-in, ease-out, ease-in-out, cubic-bezier(P1x,P1y,P2x,P2y)
      distanceX: '70%', // Size fo the toggle
      enableEscapeKey: true, // Clicking Esc will close the panel
      beforePanelOpen: function() {
        $('#toggle-addresses').addClass("open");
        $('#offscreen-phones').removeClass("open");

        // offscreenPhones.close()
        console.log('AdressesOpen');
        // $("#offscreen-addresses").css('z-index', '-1');
      },
      beforePanelClose: function() {
        $('#toggle-addresses').removeClass("open");
        $('#offscreen-addresses').removeClass("open");
        console.log('AdressesClose');
      },
  });
  $('#toggle-addresses').click(function() {
      if($("#toggle-phones").hasClass('open')){
        offscreenPhones.close();
        $('#offscreen-phones').removeClass('open');
        // setTimeout(function() {
          offscreenAddresses.open();
        // }, 0)
      } else{
        offscreenAddresses.toggle();
      }
      // $('.top-offscreen').removeClass('open');
      $('#offscreen-addresses').addClass('open');
      return false;
  });
  var offscreenPhones = $('#offscreen-phones').scotchPanel({
      containerSelector: 'body', // As a jQuery Selector
      direction: 'top', // Make it toggle in from the left
      duration: 500, // Speed in ms how fast you want it to be
      transition: 'ease-in-out', // CSS3 transition type: linear, ease, ease-in, ease-out, ease-in-out, cubic-bezier(P1x,P1y,P2x,P2y)
      distanceX: '70%', // Size fo the toggle
      enableEscapeKey: true, // Clicking Esc will close the panel
      beforePanelOpen: function() {
        $('#toggle-phones').addClass("open");
        $('#offscreen-phones').addClass('open');
        $('#offscreen-addresses').removeClass('open');
        // offscreenAddresses.close()
        console.log('phonesOpen');
        setTimeout(function() {
          $("#offscreen-addresses").css('z-index', '-1');
          $("#offscreen-phones").css('z-index', '10000');
        }, 300)
      },
      beforePanelClose: function() {
        $('#toggle-phones').removeClass("open");
        // $('#offscreen-phones').removeClass('open');
        setTimeout(function() {
          $("#offscreen-phones").css('z-index', '-1');
          $("#offscreen-addresses").css('z-index', '10000');
        }, 300)
        console.log('phonesClose');
        // $("#offscreen-addresses").css('z-index', '100');
      },
  });
  $('#toggle-phones').click(function() {
      if($("#toggle-addresses").hasClass('open')){
          offscreenAddresses.close();
        // setTimeout(function() {
          offscreenPhones.open();
        // }, 1000)
      } else{
        offscreenPhones.toggle();
      }

      return false;
  });
}, 1000)

if($(".product-slider__slide").length > 1){
    $productSlider = $("#product-slider-content");
    $productSlider.owlCarousel({
      items: "1",
      loop:  true,
      mouseDrag: false,
      smartSpeed: 1000,
      fluidSpeed: 1000,
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

if($('.hardware').length && $('.single-catalog').length ){
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
    $(".hardware__top-cat__content").slideUp();
    $('.hardware__top-cat__name a').click(function (e) {
      e.preventDefault();
      $root = $(this).data('parent');
      if($(this).closest('.hardware__top-cat').hasClass('active')){
        $(this).closest('.hardware__top-cat').removeClass('active');
        $($root + ' #' + $(this).attr('href')).slideUp();
      } else{
        $($root + ' .hardware__top-cat').removeClass('active');
        $(this).closest('.hardware__top-cat').addClass('active');
        $($root + ' .hardware__top-cat__content').slideUp();
        $($root + ' #' + $(this).attr('href')).slideDown();
      }
    })
}

  $('.feedback__label').click(function () {
    $(this).parent().toggleClass('open')
  })
  // $('.feedback__close').click(function () {
  //   $('.feedback').removeClass('open')
  // })

  if($(".cat-breadcrumb").length){
    var $catBc = $(".cat-breadcrumb");
    var $catBcUrl = $catBc.attr('href').replace('catalog/%catalog_term%/', '');
    $catBc.attr('href', $catBcUrl);
  }

  $('.footer__scroll-top').click(function(){
    $('.scotch-panel-wrapper').animate({scrollTop : 0},800);
    // return false;
  });

  $("#feedback").appendTo("body");
})


