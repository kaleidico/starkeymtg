$(function(){
        // Check the initial Poistion of the Sticky Header
        var stickyHeaderTop = $('#fp-stickyheader').offset().top;
 
        $(window).scroll(function(){
                if( $(window).scrollTop() > stickyHeaderTop ) {
                        $('#fp-stickyheader').css({position: 'fixed', top: '0px'});
                        $('#stickyalias').css('display', 'block');
                } else {
                        $('#fp-stickyheader').css({position: 'fixed', top: '0px', display: 'none'});
                        $('#stickyalias').css('display', 'none');
                }
        });
  });