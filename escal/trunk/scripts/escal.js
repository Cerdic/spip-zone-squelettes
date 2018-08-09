// flèche de retour-haut 

jQuery(function(){
	$(function () {
		$(window).scroll(function () { //Fonction appelée quand on descend la page
			if ($(this).scrollTop() > 200 ) {  // Quand on est à 200pixels du haut de page,
				$('#scrollHaut').css('right','10px'); // Replace à 10pixels de la droite l'image
			} else { 
				$('#scrollHaut').removeAttr( 'style' ); // Enlève les attributs CSS affectés par javascript
			}
		});
	});
});