<?php

//critère {aff_even}
//affichage des événements


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

// critère {mes_logos}
// permet d'affecter un logo à un objet SPIP (rubrique, article, breve, site)
function critere_meslogos($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];

	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->where[]= array("'='", "'$boucle->id_table." . "id_groupe'", 0);
}

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