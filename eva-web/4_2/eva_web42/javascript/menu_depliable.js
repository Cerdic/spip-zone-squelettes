$(document).ready(function () {
	//parcours une fois le document � la recherche des �lements noeud.
	var noeud = $("#sommaire li:has(ul)");

	var feuilleracine = $("#sommaire > li:not(:has(ul))");
	feuilleracine.addClass("feuilleracine");

	var feuille = $("#sommaire ul>li:not(:has(ul))");
	feuille.addClass("feuille");
	
	// ajout de la classe noeud � tous les noeuds pour afficher la fl�che
	noeud.addClass("noeud");

	/*
	// on masque toutes les sous-rubriques
	noeud.find(">ul").hide();
	// et on leur ajoute la classe plier pour avoir la fleche horizontale
	noeud.find(">span").addClass("plier");
	alert(noeud.filter(".on").find(">ul").length);
	// puis on affiche la rubrique affich�e
	noeud.filter(".on").find(">ul").show();
	// et on enleve la classe plier pour avoir la fleche veticale
	noeud.filter(".on").find(">span").toggleClass("plier");
	*/
	
	// on masque toutes les sous-rubriques qui ne font pas partie de la rubrique affich�e	
	noeud.filter(":not(.on)").find(">ul").hide();
	// et on leur ajoute la classe plier pour avoir la fl�che horizontale
	noeud.filter(":not(.on)").addClass("plier");
	
	//determine le comportement lors d'un click
	noeud.click(function (e) {
		// affiche ou cache la sous liste  sur click de l'�l�ment
		$(this).toggleClass("plier");
		$(this).find(">ul").toggle();
		//interdit la propagation sur les noeuds parents
		e.stopPropagation();		
	});
	//�viter un effet de bord (pliage) lors d'un click sur le lien
	$("#sommaire a").click(function (e) {
		e.stopPropagation();
	});
});
