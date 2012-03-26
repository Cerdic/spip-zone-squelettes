jQuery(document).ready(function(){
		jQuery(".liste.breves li.item div.contenu_breve").css({display:'none'});
		jQuery(".liste.breves li.item h3.h3 a").removeClass("ouvert");
		jQuery(".liste.breves li.item h3.h3 a").addClass("ouvrable");
		
		jQuery(".liste.breves li.item h3").click(function(){
				jQuery(this).next().toggle();
				$(this).children().toggleClass("ouvrable");
				$(this).children().toggleClass("ouvert");
				return false;
		});
});