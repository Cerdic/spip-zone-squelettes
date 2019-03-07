<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2012                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * chargement des valeurs par defaut des champs du #FORMULAIRE_RECHERCHE_MULTIMOTS
 * on peut lui passer l'url de destination en premier argument
 *
 * @param string $lien URL où amène le formulaire validé
 * @param string $class Une class différenciant le formulaire
 * @param array $groupes Les groupes de mots contenant les mots sur lesquels s'applique la recherche
 * @param string $champ Type de champ de saisie (cases à cocher ou liste déroulante)
 * @param integer $cols Le nombre de colonnes à afficher
 * @param booleen $afficher_recherche Afficher un champ de recherche libre
 * @param booleen $afficher_filtrer_par_age Filtrer les résultats par âge
 * @return array
 */
function formulaires_recherche_multimots_charger_dist($lien = '', $class='', $groupes='', $champ='input', $cols=4, $afficher_recherche='', $afficher_filtrer_par_age='', $size=5){
	if ($GLOBALS['spip_lang'] != $GLOBALS['meta']['langue_site'])
		$lang = $GLOBALS['spip_lang'];
	else
		$lang='';

	return 
		array(
			'action' =>  ($lien ? $lien : generer_url_public('recherche_multimots')), # action specifique, ne passe pas par Verifier, ni Traiter
			'mots' => _request('mots'),
			'filtrer_par_age' => _request('filtrer_par_age'),
		);
}

?>