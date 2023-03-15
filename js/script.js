$(document).ready(function(){
    (function ($) {
    'use strict';
    var form = $('.ajax__form'),
        message = $('.ajax__msg'),
        form_data;
    // Success function
    function done_func(response) {
        message.fadeIn().removeClass('alert-danger').addClass('alert-success');
        if(response.quote){
          message.text(response.quote);
        }else {
            message.text(response);
        }
        form.find('input:not([type="submit"]), textarea').val('');
        if(response.location){
          window.location.href = response.location;
        }
        if(response.order == 'done'){
            // $('.popup').fadeIn();
            swal(
                'Success',
                'You clicked the <b style="color:green;">Success</b> button!',
                'success'
            );
        }
    }
    // fail function
    function fail_func(data) {
        message.fadeIn().removeClass('success').addClass('error');
        message.text(data.responseText);
    }
    form.submit(function (e) {
        e.preventDefault();
        message.text('Loading...');
        form_data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form_data
        })
        .done(done_func)
        .fail(fail_func);
    });
    })(jQuery);
    $('.customer-wrap').LLCGslider({
        responsive: {
          300: {
            items: 1,     
            nav: false,
            dots: true,
            centerMode: false,
            loop: true,
            autoplay: true,
            autoplaySpeed: 3000,
            margin: 0,
          },
          768: {
            items: 2,     
            nav: false,
            dots: true,
            centerMode: false,
            loop: true,
            autoplay: true,
            autoplaySpeed: 3000,
            margin: 25,
          },
          1200: {
            items: 3,     
            nav: false,
            dots: true,
            centerMode: false,
            loop: true,
            autoplay: true,
            autoplaySpeed: 3000,
            margin: 35,
          }
        }
      });
  $('#example').DataTable();


});






