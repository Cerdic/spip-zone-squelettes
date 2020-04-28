

$(function() {
        
        // liens externes : dans une nouvelle fenetre 
        $('a.spip_out,.articles-virtuels a').attr("target", "_blank");
        
        // articles virtuels consideres comme liens externes
        $('.articles-virtuels a').addClass("spip_out");
        
        // accessibilité (validité html) : ces attributs ne sont plus présents dans le code des pages mais on les ajoute en js
        $('#recherche').attr('autocapitalize','off').attr('autocorrect','off');

        // bouton impression
        $('.bouton_print').on("click",function(){ window.print();});
        
        // Bouton backtotop : on l'ajoute au dom + comportement d'apparition et de clic
        $( "body" ).append( "<div id='backtotop' title='Haut de page'><span><i class='fa fa-long-arrow-up'></i></span></div>" );
        $(window).scroll(function() {
                if($('html').scrollTop() > 300 || $('body').scrollTop() > 300) { $('#backtotop').fadeIn();}
                else { $('#backtotop').fadeOut(); }
        });
        $('#backtotop').on('click',function() {
            $('html,body').animate({ scrollTop: 0 }, 900, function() {
                $("html, body").off("scroll mousedown DOMMouseScroll mousewheel keyup");
            });
            return false;
        });
                
        // carousel
        if (!$.cookie('stop-carousel')) {
            $('#carousel').carousel({interval:8000});
            $('#carousel-pause-cancel').hide();
        }
        else{
            $('#carousel-pause').hide();
        }
        //bouton arret temporaire du carousel
        $('#carousel-pause').on('click',function(){
            $('#carousel').carousel('pause');
            $.cookie('stop-carousel', true, { expires: 365 });
            $(this).hide();
            $('#carousel-pause-cancel').show();
            return false;
        });
        //bouton arret/reprise definitive du carousel
        $('#carousel-pause-cancel').on('click',function() {
            $.removeCookie('stop-carousel');
            $('#carousel').carousel('next');
            $('#carousel').carousel({interval:8000});
            $(this).hide();
            $('#carousel-pause').show();
            return false;
        });
        // menu XL
        if($('.menu-xl').length){
            var style='';
            $('.menu-xl').each( function(index) {
                $(this).children('ul').addClass('row-fluid xl-'+index).find('li').children('ul').show().removeClass('nav');
                var x=$(this).position();x=x.left+10;x=parseInt(x);var xb=parseInt(x-1);
                style +=".navbar .nav > li.menu-xl > .xl-"+index+".dropdown-menu::before{left:" + xb + "px;} .navbar .nav > li.menu-xl > .xl-"+index+".dropdown-menu::after{left:" + x + "px;}";
            });
             $("<style>"+style+"</style>").appendTo('head');
        }
        //
        $(".menu_ouvrant").on('mouseover',function(){$(this).addClass('pseudo_link');})
                          .on('mouseout',function(){$(this).removeClass('pseudo_link');})
                          .on('click',function(){$(this).next().toggle("slow");});
        callbackToggleBreves(true);
        if (typeof onAjaxLoad == 'function') onAjaxLoad(callbackToggleBreves); // callback pour les breves lors de pagination ajax (merci astuces spip)
});

$.removeCookie = function (key, options) {
	if ($.cookie(key) === undefined) {
		return false;
	}
	// Must not alter options, thus extending a fresh object...
	$.cookie(key, '', $.extend({}, options, { expires: -1 }));
	return !$.cookie(key);
};

function callbackToggleBreves(chargement) {
        if(chargement || $(this).parents().hasClass("breves")){
                $(".liste.breves li.item div.breve_content").css({display:'none'});
                $(".liste.breves li.item .h3-like a").toggleClass('ouvrable');
                $(".liste.breves li.item .h3-like").off("click");
                $(".liste.breves li.item .h3-like").on("click",function(){ // Affichage des breves
                        $(this).next().slideToggle();
                        $(this).children().toggleClass("ouvrable");
                        return false;
                });
        }
}