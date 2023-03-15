(function($) {
  $.fn.LLCGslider = function(options) {
    // Set default options
    var settings = $.extend({
      nav: true,
      dots: true,
      centerMode: false,
      items: 1,
      loop: true,
      autoplay: true,
      autoplaySpeed: 3000,
      margin: 0,
      responsive: {}
    }, options);

    // Iterate over each element in the set
    return this.each(function() {
      var $this = $(this);

      // Create the slider structure
      $this.addClass('LLCGslider');
      $this.children('*').each(function(){
        $(this).addClass('LLCGslider-item');
      });
      $this.wrapInner('<div class="LLCGslider-container"></div>');
      $this.wrapInner('<div class="LLCGslider-wraper"></div>');
      $this.append(`<div class="LLCGslider-navs"><button class="LLCGslider-nav LLCGslider-prev"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg></button><button class="LLCGslider-nav LLCGslider-next"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg></button></div>`);
      $this.append('<div class="LLCGslider-dots"></div>');

      // Set the number of items to show
      function sizingCarouselItem(){
      	var itemWidthNoMargin = 100 / settings.items;
		var nonExMargin = settings.items - 1;
		var totalMargin = settings.margin * nonExMargin;
		var finalMarginVal = totalMargin / settings.items;
		$this.find('.LLCGslider-item').css('width', `calc(${itemWidthNoMargin}% - ${finalMarginVal}px)`);
		// Set the margin between items
		$this.find('.LLCGslider-item').css('margin-right', settings.margin + 'px');
      }
      sizingCarouselItem();

      // Set the responsive options
      if (Object.keys(settings.responsive).length > 0) {
        var breakpoint, item;
        for (breakpoint in settings.responsive) {
          item = settings.responsive[breakpoint];
          if ($(window).width() >= breakpoint) {
            settings.items = item.items;
            settings.margin = item.margin;
            settings.autoplay = item.autoplay;
            settings.nav = item.nav;
            settings.dots = item.dots;
            settings.loop = item.loop;
          }
        }
        sizingCarouselItem();
      }

      // Set the initial slide
      var activeIndex = 0;
      $this.find('.LLCGslider-item').eq(activeIndex).addClass('active');

      // Number Of item
      var numberOfItem = $this.find('.LLCGslider-item').length;

      // Center Carousel if Don't have enough items
      if(numberOfItem < settings.items){
        $this.children('.LLCGslider-container').addClass('LLCGslider-make-center');
      }

      // Add center class slides
      if (settings.centerMode) {
        var centerIndex = Math.round(settings.items / 2);
        $this.find('.LLCGslider-item:nth-child('+centerIndex+')').addClass('LLCGslider-center-item');
      }

      // Set the initial dots
      if (settings.dots) {
        $this.find('.LLCGslider-dots').append('<button class="LLCGslider-dot active"></button>');
        for (var i = 1; i < $this.find('.LLCGslider-item').length - settings.items + 1; i++) {
          $this.find('.LLCGslider-dots').append('<button class="LLCGslider-dot"></button>');
        }
      }

      // Set the initial nav state
      if (!settings.loop && activeIndex === 0) {
        $this.find('.LLCGslider-prev').attr('disabled', true);
      }
      if (!settings.loop && activeIndex === $this.find('.LLCGslider-item').length - 1) {
        $this.find('.LLCGslider-next').attr('disabled', true);
      }

      // Show/hide nav
      if (!settings.nav) {
        $this.find('.LLCGslider-nav').hide();
      }

      // Show/hide dots
      if (!settings.dots) {
        $this.find('.LLCGslider-dots').hide();
      }

      // Set the autoplay interval
      if (settings.autoplay) {
        var interval = setInterval(function() {
          if (activeIndex < $this.find('.LLCGslider-item').length - 1) {
            activeIndex++;
          } else {
            if (settings.loop) {
              activeIndex = 0;
            } else {
              clearInterval(interval);
            }
          }

          var whenChangeIndex = (numberOfItem - settings.items);
          if(whenChangeIndex < activeIndex){
            activeIndex = 0;
          }

          // Move the slides
          moveSlides(activeIndex);
        }, settings.autoplaySpeed);
      }

      // Function to move the slides
      function moveSlides(index) {
        // Update the active slide
        $this.find('.LLCGslider-item').removeClass('active').eq(index).addClass('active');

        // Update the active dot
        $this.find('.LLCGslider-dot').removeClass('active').eq(index).addClass('active');

        // Update center class
        if (settings.centerMode) {
          var centerIndex = Math.round(settings.items / 2);
          $this.find('.LLCGslider-item.center-item').removeClass('center-item');
          $this.find('.LLCGslider-item').eq(activeIndex + centerIndex - 1).addClass('center-item');
        }

        // Update the nav state
        if (!settings.loop && index === 0) {
          $this.find('.LLCGslider-prev').attr('disabled', true);
        } else {
          $this.find('.LLCGslider-prev').attr('disabled', false);
        }
        if (!settings.loop && index === $this.find('.LLCGslider-item').length - 1) {
          $this.find('.LLCGslider-next').attr('disabled', true);
        } else {
          $this.find('.LLCGslider-next').attr('disabled', false);
        }

        var gotoFirst = numberOfItem - settings.items + 1;
        if(gotoFirst === index){
          var width = $this.find('.LLCGslider-item').outerWidth() + settings.margin;
          $this.find('.LLCGslider-container').css('transform', 'translateX(-0px)');
        }else {
          var width = $this.find('.LLCGslider-item').outerWidth() + settings.margin;
          $this.find('.LLCGslider-container').css('transform', 'translateX(-' + (width * index) + 'px)');
        }
        
      }
      // Navigate to the previous slide
      $this.find('.LLCGslider-prev').click(function() {
        if (activeIndex > 0) {
          activeIndex--;
        } else {
          if (settings.loop) {
            activeIndex = $this.find('.LLCGslider-item').length - 1;
          }
        }
        var whenChangeIndex = numberOfItem - settings.items + 1;
        if(whenChangeIndex < activeIndex){
          activeIndex = whenChangeIndex - 1;
        }
        moveSlides(activeIndex);
      });

      // Navigate to the next slide
      $this.find('.LLCGslider-next').click(function() {
        if (activeIndex < $this.find('.LLCGslider-item').length - 1) {
          activeIndex++;
        } else {
          if (settings.loop) {
            activeIndex = 0;
          }
        }
        var whenChangeIndex = (numberOfItem - settings.items);
        if(whenChangeIndex < activeIndex){
          activeIndex = 0;
        }
        moveSlides(activeIndex);
      });

      // Navigate to a specific slide
      $this.find('.LLCGslider-dot').click(function() {
        activeIndex = $(this).index();
        moveSlides(activeIndex);
      });

      // End of plugin

    });
  };
}(jQuery));
