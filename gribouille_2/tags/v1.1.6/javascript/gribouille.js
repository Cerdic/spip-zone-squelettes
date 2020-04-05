$(document).ready(function() {
    // scroll animé sur les ancres, les ancres de retour au sommaire remontent en haut de page
    $('a[href^="#"]').on('click', function(e) {
        var hash = this.hash;
        console.log(hash);
        var $target = $(this).hasClass('sommaire-back') ? $('html') : $(hash);
        var offset = $target.offset();
        if(offset) {
            e.preventDefault();
            var newPos = offset.top;
            $('html,body').stop().animate({'scrollTop': newPos}, 300, 'swing');
        }
    });    
});