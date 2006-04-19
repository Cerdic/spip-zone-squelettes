<?php


// critère {edito}
// permet d'affecter une rubrique spécifique pour les éditos
function critere_edito($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];
	
	// on va chercher la meta
	lire_metas();
	$var=$GLOBALS['meta']['id_edito'];
	if ($GLOBALS['meta']['activer_edito']='oui') {$id_edito=$var;} else {$id_edito=0;};
	
	
	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->where[]= array("'='", "'$boucle->id_table." . "id_rubrique'", $id_edito);
}

//critère {affiche_nb_articles}
//affichage des événements

function critere_affiche_nb_articles($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	if ($GLOBALS ['meta']['voir_articles_nono']=='oui') {$var=$GLOBALS['meta']['nb_articles_nono'];} else {$var='0';};
	$boucle->limit = '0, ' .$var. '' ;
}

//critère {affiche_nb_breves}
//affichage des événements

function critere_affiche_nb_breves($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	if ($GLOBALS ['meta']['voir_breves_nono']=='oui') {$var=$GLOBALS['meta']['nb_breves_nono'];} else {$var='0';};
	$boucle->limit = '0, ' .$var. '' ;
}

//critère {affiche_nb_sites}
//affichage des événements

function critere_affiche_nb_sites($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	if ($GLOBALS ['meta']['voir_sites_nono']=='oui') {$var=$GLOBALS['meta']['nb_sites_nono'];} else {$var='0';};
	$boucle->limit = '0, ' .$var. '' ;
}

//critère {affiche_nb_messages}
//affichage des événements

function critere_affiche_nb_messages($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
  	if ($GLOBALS ['meta']['voir_messages_nono']=='oui') {$var=$GLOBALS['meta']['nb_messages'];} else {$var='0';};
	$boucle->limit = '0, ' .$var. '' ;

}

//critère {affiche_nb_syndic}
//affichage des événements

function critere_affiche_nb_syndic($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
 	if ($GLOBALS ['meta']['voir_syndic_nono']=='oui') {$var=$GLOBALS['meta']['nb_syndic_nono'];} else {$var='0';};
	$boucle->limit = '0, ' .$var. '' ;

}

//critère {affiche_nb_syndic}
//affichage des événements

function critere_affiche_nb_evens($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
 	if ($GLOBALS ['meta']['voir_agenda_nono']=='oui') {$var=$GLOBALS['meta']['nb_evens_nono'];} else {$var='0';};
	$boucle->limit = '0, ' .$var. '' ;

}


// critère {mes_logos}
// permet d'affecter un logo à un objet SPIP (rubrique, article, breve, site)




// balise #DIRECTEUR

function balise_DIRECTEUR_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['directeur_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #REDACTEUR

function balise_REDACTEUR_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['redacteur_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #COPYRIGHT

function balise_COPYRIGHT_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['copyright_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #KEYWORDS

function balise_KEYWORDS_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['keywords_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	



?>