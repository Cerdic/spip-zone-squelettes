<?php

/// ---------------------------------------
// Pagination
// https://zone.spip.org/trac/spip-zone/browser/_contribs_/_filtres_/pagination
// ---------------------------------------
function recuperer_variables_pagination($total, $debut, $pas, $texte) {
	return array(
		'lien_base' => self(),
		'total' => $total,
		'position' => $GLOBALS['contexte'][$debut],
		'pas' => $pas,
		'nombre_pages' => floor(($total-1)/$pas)+1,
		'page_courante' => floor($GLOBALS['contexte'][$debut]/$pas)+1,
		'lien_pagination' => function_exists('lien_pagination') ?
			lien_pagination($texte) :
			'<a href="@url@">@item@</a>'
	);
}


/*
 *   +----------------------------------+
 *    Nom du Filtre :    pagination                                               
 *   +----------------------------------+
 *    Date : dimanche 22 aout 2004
 *    Modifiee : mercredi 23 novembre 2005
 *    Auteur :  James (james<at>rezo.net)
 *    Licence : GNU/GPL
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *     affiche la liste des pages d'une boucle contenant
 *     un critère de limite du type {debut_xxx, yyy} et depuis la 1.8.2e
 *     du type {debut, #ENV{pas,10}}
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * inscrivez-vous et ecrivez a la liste de discussion : spip-zone<at>rezo.net
 * Pour les explications sur l'utilisation de ce filtre,
 * reportez-vous a l'article :
 * https://contrib.spip.net/Pagination,1212
*/

function pagination($total, $debut='debut_page', $pas=10, $fonction='') {
	global $pagination_item_avant, $pagination_item_apres, $pagination_separateur;
	global $pagination_max, $pagination_max_texte;
	tester_variable('pagination_separateur', '&nbsp;| ');
	tester_variable('pagination_max_texte', '...');
	if(!$fonction) $fonction = 'strval';

	$pagination = recuperer_variables_pagination($total, $debut, $pas, 'pagination');

	if($pagination_max == 0 OR $pagination_max>=$pagination['nombre_pages']) {
		$premiere = 1;
		$derniere = $pagination['nombre_pages'];
		$texte_avant = '';
		$texte_apres = '';
	}
	else {
		$premiere = max(1, $pagination['page_courante']-floor($pagination_max/2));
		$derniere = min($pagination['nombre_pages'], $premiere+$pagination_max-1);
		$premiere = $derniere == $pagination['nombre_pages'] ? $derniere-$pagination_max+1 : $premiere;
		$texte_avant = $premiere>1 ? $pagination_max_texte.' ' : '';
		$texte_apres = $derniere<$pagination['nombre_pages'] ? ' '.$pagination_max_texte : '';
	}

	$texte = '';
	if($pagination['nombre_pages']>1) {
		$i = $premiere;
		while($i<=$derniere) {
			$url = parametre_url($pagination['lien_base'], $debut, strval(($i-1)*$pas));
			$_item = function_exists($f='pagination_'.$fonction)  ?
				$f($i, $pagination) :
				$fonction($i);
			$item = ($i != $pagination['page_courante']) ?
				preg_replace(array(',@url@,', ',@item@,'), array($url, $_item), $pagination['lien_pagination']) :
				$_item;
			$texte .= $pagination_item_avant.$item.$pagination_item_apres;
			if($i<$pagination['nombre_pages']) $texte .= $pagination_separateur;
			$i++;
		}
		return $texte_avant.$texte.$texte_apres;
	}
	return '';
}
// FIN du Filtre pagination

/* affichage par etendue */
function pagination_etendue($i, $pagination, $texte='-') {
	return strval(($i-1)*$pagination['pas']+1) .
		$texte .
		strval(min($pagination['total'], $i*$pagination['pas']));
}

/* Indicateurs de position */
function pagination_sur_pages($total, $debut='debut_page', $pas=10, $texte="/") {
	$pagination = recuperer_variables_pagination($total, $debut, $pas, 'sur_page');	
	return ($pagination['nombre_pages']>1) ?
		$pagination['page_courante'].$texte.$pagination['nombre_pages'] :
		'';
}

function pagination_sur_total($total, $debut='debut_page', $pas=10, $texte='-', $sur="/") {
	$pagination = recuperer_variables_pagination($total, $debut, $pas, 'sur_total');
	return ($pagination['nombre_pages']>1) ?
		($pagination['position']+1).$texte.min($total, $pagination['position']+$pas).$sur.$total :
		'';
}
	
function pagination_tout_voir($total, $debut='debut_page', $pas=10, $texte="|&lt;&nbsp;&gt;|", $texte_retour="&gt;|&lt;", $var_pas='pas') {
	$pagination = recuperer_variables_pagination($total, $debut, $pas, 'tout_voir');
	$url = parametre_url($pagination['lien_base'], $debut, strval(0));
	$url = parametre_url($url, $var_pas, $total);
	$url_retour = parametre_url($pagination['lien_base'], $var_pas, '');
	return ($pagination['nombre_pages']>1) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, $texte), $pagination['lien_pagination']) :
		($texte_retour ?
			preg_replace(array(',@url@,', ',@item@,'), array($url_retour, $texte_retour), $pagination['lien_pagination']) :
			'');
}

/* liens particuliers */
function premiere_page($total, $debut='debut_page', $pas=10, $texte="|&lt;&lt;") {
	$pagination = recuperer_variables_pagination($total, $debut, $pas, 'premiere');
	$url = parametre_url($pagination['lien_base'], $debut, strval(0));
	return ($pagination['nombre_pages']>1 && $pagination['page_courante']>1) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, $texte), $pagination['lien_pagination']) :
		'';
}

function page_precedente($total, $debut='debut_page', $pas=10, $texte="&lt;") {
	$pagination = recuperer_variables_pagination($total, $debut, $pas, 'precedente');
	$precedent = $pagination['position']-$pas;
	$url = parametre_url($pagination['lien_base'], $debut, strval($precedent));
	return ($pagination['nombre_pages']>1 && $pagination['page_courante']>1) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, $texte), $pagination['lien_pagination']) :
		'';
}

function page_suivante($total, $debut='debut_page', $pas=10, $texte="&gt;") {
	$pagination = recuperer_variables_pagination($total, $debut, $pas, 'suivante');
	$suivant = $pagination['position']+$pas;
	$url = parametre_url($pagination['lien_base'], $debut, strval($suivant));
	return ($pagination['nombre_pages']>1 && $pagination['page_courante']<$pagination['nombre_pages']) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, $texte), $pagination['lien_pagination']) :
		'';
}

function derniere_page($total, $debut='debut_page', $pas=10, $texte="&gt;&gt;|") {
	$pagination = recuperer_variables_pagination($total, $debut, $pas, 'derniere');
	$dernier = ($pagination['nombre_pages']-1)*$pas;
	$url = parametre_url($pagination['lien_base'], $debut, strval($dernier));
	return ($pagination['nombre_pages']>1 && $pagination['page_courante']<$pagination['nombre_pages']) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, $texte), $pagination['lien_pagination']) :
		'';
}

/*
 * balise #PAGINATION{page,#ENV{pas,10}}
 */
function balise_PAGINATION_dist ($p) {
	$b = $p->nom_boucle ? $p->nom_boucle : $p->descr['id_mere'];
	if ($b === '') {
		erreur_squelette(
			_T('zbug_champ_hors_boucle',
				array('champ' => '#PAGINATION')
			), $p->id_boucle);
		$p->code = "''";
	}
	elseif (!$p->param || $p->param[0][0]) {
		erreur_squelette(
			/*_T('zbug_champ_manquant',
				array('champ' => '#PAGINATION')*/
			_L('param&eacute;tre manquant pour #PAGINATION')
			, $p->id_boucle);
		$p->code = "''";
	}
	else {
		$position =  calculer_liste($p->param[0][1],
					$p->descr,
					$p->boucles,
					$p->id_boucle);

		$pas =  calculer_liste($p->param[0][2],
					$p->descr,
					$p->boucles,
					$p->id_boucle);

		$fonction =  calculer_liste($p->param[0][3],
					$p->descr,
					$p->boucles,
					$p->id_boucle);

		// autres filtres
		array_shift($p->param);
		
		$p->boucles[$b]->numrows = true;
		$p->code = "pagination(\$Numrows['$b']['total'],".$position.",".$pas.",".$fonction.")";
	}

	$p->interdire_scripts = true; //SVN
	return $p;
}


?>
