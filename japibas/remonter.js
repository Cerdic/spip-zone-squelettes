$(function(){
  $('#remonter').click(function() {
    $('html,body').animate({scrollTop: 0}, 'slow');
  });

  $(window).scroll(function(){
     if($(window).scrollTop()<200){
        $('#remonter').fadeOut();
     }else{
        $('#remonter').fadeIn();
     }
  });
});