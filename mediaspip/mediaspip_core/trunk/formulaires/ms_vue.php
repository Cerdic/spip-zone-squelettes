<?php
/**
 * Plugin Mediaspip Core
 * Formulaire de changement de vue des listes de medias
 * 
 * © 2010-2015 - Distribue sous licence GNU/GPL
 * @author kent1 <kent1@arscenic.info>
 * 
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Formulaire dynamique #FORMULAIRE_MS_VUE
 *
 * Passe au préalable par balises/formulaire_ms_vue
 */

/**
 * Chargement des valeurs par defaut des champs du formulaire
 * - On récupère le nom de la boucle parente
 * - On récupère lt type de liste actuel si présent dans l'environnement
 *
 * @param string $boucle
 * @param string $defaut : le critère par défaut si rien dans l'environnement
 * @param string $ancre : l'ancre sur laquelle on pointe ensuite
 */
function formulaires_ms_vue_charger_dist($boucle,$defaut='',$ancre='',$recharger=false){
	$vue_actuelle = _request('vue'.$boucle) ? _request('vue'.$boucle) : $defaut;
	$page = _request('page');
	return
		array(
			'action' => self(),
			'defaut' => $vue_actuelle,
			'nom' => 'champ_vue'.$boucle,
			'boucle' => $boucle,
			'page_en_cours' => $page
		);
}

function formulaires_ms_vue_traiter_dist($boucle,$defaut='',$ancre='',$recharger=false){
	$lien = self();
	$valeur = _request('champ_vue'.$boucle);
	$lien_retour = parametre_url($lien,'vue'.$boucle,$valeur);
	if($recharger){
		$res['message_ok'] = '<script type="text/javascript">if (window.jQuery) jQuery("'.$recharger.'").ajaxReload({args:{vue'.$boucle.':"'.$valeur.'"},history:true});</script>';
		set_request('vue'.$boucle,$valeur);
	}else{
		$res['redirect'] = $lien_retour.($ancre ? '#'.$ancre : '');
	}
	spip_log($res,'test.'._LOG_ERREUR);
	return $res;
}

?>
