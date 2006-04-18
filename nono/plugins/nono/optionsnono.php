<?php

// crit�re {edito}
// permet d'affecter une rubrique sp�cifique pour les �ditos
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

// crit�re {mes_logos}
// permet d'affecter un logo � un objet SPIP (rubrique, article, breve, site)
function critere_meslogos($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];

	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->where[]= array("'='", "'$boucle->id_table." . "id_groupe'", 0);

}

// balise #DIRECTEUR

function balise_DIRECTEUR_NONO(a$) {
	

}
	

?>