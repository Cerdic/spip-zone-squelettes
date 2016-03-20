$(document).ready(function () {
	//parcours une fois le document à la recherche des élements noeud.
	var noeud = $(".noeud"); 
	//cache toutes les sous liste
	noeud.addClass("plier");
	//determine le comportement lors d'un click
		noeud.click(function (e) {
			//affiche ou cache la sous liste  sur click de l'élément
			$(this).toggleClass("plier");
			//interdit la propagation sur les noeuds parents
			e.stopPropagation();		
		});
		//éviter un effet de bord (pliage) lors d'un click sur le lien
		$("#sommaire a").click(function (e) {
			e.stopPropagation();
		});
		//eviter un effet de bord (pliage) lors d'un click sur une feuille
		$(".feuille").click(function (e) {
			e.stopPropagation();
		});
});

$(document).ready(function() {
	$(".noeud").click(function () {
		//detecte le navigateur internet exploreur
		if($.browser.msie) {
			//sur le bloc fils ajoute la classe
			$(this).siblings("ul").toggleClass("pliermsie");
		}
	});
});