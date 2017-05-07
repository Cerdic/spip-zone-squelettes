<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2013 - Distribue sous licence GNU/GPL
 * 
 * Fichier des fonctions spécifiques du plugin (utilisées à chaque calcul de pages)
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Traduction des statuts d'auteurs en chaine lisible
 *
 * @param string $statut
 */
function ms_traduire_statut($statut){
	if ($t = array_search($statut, $GLOBALS['liste_des_statuts']))
		return _T('mediaspip_core:statut_'.$t);
	return;
}

/**
 * Définition du critère notation si le plugin notation n'est pas dispo
 */
if (!function_exists('critere_notation')){
	function critere_notation_dist($idb, &$boucles, $crit){}
}

/**
 * Définition du critère branche_complete si le plugin polyhierarchie n'est pas dispo
 */
if(!function_exists('critere_branche_complete_dist')){
	function critere_branche_complete_dist($idb, &$boucles, $crit){}
}

/**
 * Définition du critère mesfavoris si le plugin mes favoris n'est pas dispo
 */
if (!function_exists('critere_mesfavoris_dist')){
	function critere_mesfavoris_dist($idb, &$boucles, $crit){}
}

/**
 * Définition du critère id_licence si le plugin licences n'est pas dispo
 */
if (!defined('_DIR_PLUGIN_LICENCE') && !function_exists('critere_id_licence_dist') && !function_exists('critere_id_licence')){
	function critere_id_licence_dist($idb, &$boucles, $crit){}
}

/**
 * Définition du critère mots si le plugin critere_mots n'est pas dispo
 */
if (!function_exists('critere_mots_dist')){
	function critere_mots_dist($idb, &$boucles, $crit){}
}

/**
 * Ajout d'une fonctionnalité au critère {agenda} : le premier argument,
 * $date, peut maintenant venir d'un #SET, d'#ENV, etc.
 * cf. la limitation décrite dans www.spip.net/fr_article3182.html
 * La valeur peut être 'date' (défaut), 'date_redac' ou 'maj'
 */
if (!function_exists('critere_agenda') and $spip_version_branche < "3.1" ){
	function critere_agenda($idb, &$boucles, $crit){
		$params = $crit->param;

		if (count($params)>=1) {
			/* Code copié de https://core.spip.net/projects/spip/repository/revisions/21002 pour la branche spip 3.0 */
			$boucle = &$boucles[$idb];
			$parent = $boucle->id_parent;
			$fields = $boucle->show['field'];

			$date = array_shift($params);
			$type = array_shift($params);

			// la valeur $type doit etre connue a la compilation
			// donc etre forcement reduite a un litteral unique dans le source
			$type = is_object($type[0]) ? $type[0]->texte : NULL;
			
			// La valeur date doit designer un champ de la table SQL.
			// Si c'est un litteral unique dans le source, verifier a la compil,
			// sinon synthetiser le test de verif pour execution ulterieure
			// On prendra arbitrairement le premier champ si test negatif.
			if ((count($date) == 1)  AND ($date[0]->type == 'texte')) {
				$date = $date[0]->texte;
				if (!isset($fields[$date])) {
					return array('zbug_critere_inconnu', array('critere' => $crit->op . " " . $date));
				}
			} else {
				$a = calculer_liste($date, array(), $boucles, $parent);
				$noms = array_keys($fields);
				$defaut = $noms[0];
				$noms = join(" ", $noms);
				# bien laisser 2 espaces avant $nom pour que strpos<>0
				$cond = "(\$a=strval($a))AND\nstrpos(\"  $noms \",\" \$a \")";
				$date = "'.(($cond)\n?\$a:\"$defaut\").'";
			}
			
			$texte = new Texte;
			$texte->texte = $date;
			
			$crit->param[0][0] = $texte;
		}
		
		critere_agenda_dist($idb, $boucles, $crit);
	}
}

if (!function_exists('inc_vignette')){
	function inc_vignette($ext, $size=true, $loop = true) {
		if(test_espace_prive()){
			include_spip('inc/vignette');
			return inc_vignette_dist($ext, $size, $loop);
		}
		if (!$ext) $ext = 'txt';

		// Chercher la vignette correspondant a ce type de document
		// dans les vignettes persos, ou dans les vignettes standard
		if (
		# installation dans un dossier /vignettes personnel, par exemple /squelettes/vignettes
		!@file_exists($v = find_in_path("images/media_sans_logo_".$ext.".png"))
		AND !@file_exists($v = find_in_path("images/media_sans_logo_".$ext.".gif"))
		)
			if ($loop){
				$f = charger_fonction('vignette','inc');
				$v = $f('defaut', false, $loop=false);
			}
			else
				$v = false; # pas trouve l'icone de base

		if (!$size) return $v;

		if ($size = @getimagesize($v)) {
			$largeur = $size[0];
			$hauteur = $size[1];
		}

		return array($v, $largeur, $hauteur);
	}
}

function has_cookie_admin(){
	return isset($_COOKIE['spip_admin']) ? $_COOKIE['spip_admin'] : false;
}

/**
 * Converti une durée en secondes en une durée affichable et lisible 
 * hh:mm:ss ou mm:ss
 * 
 * @param int|float $temps_secondes 
 * 		Le nombre de secondes
 * @return string $str
 * 		Le temps sous forme de chaîne de caractère
 */
function mediaspip_duree($temps_secondes){
	$diff_hours = floor($temps_secondes/3600);
	$temps_secondes -= $diff_hours * 3600;
	$diff_hours = (($diff_hours >= 0) && ($diff_hours < 10)) ? '0'.$diff_hours : $diff_hours;

	$diff_minutes = floor($temps_secondes/60);
	$temps_secondes -= $diff_minutes * 60;
	$diff_minutes = (($diff_minutes >= 0) && ($diff_minutes < 10)) ? '0'.$diff_minutes : $diff_minutes;

	$temps_secondes = (($temps_secondes >= 0) && ($temps_secondes < 10)) ? '0'.floor($temps_secondes) : floor($temps_secondes);

	$str = (($diff_hours > 0) ? $diff_hours.':':'').(($diff_minutes > 0) ? $diff_minutes:'00').':'.$temps_secondes;

	return $str;
}

/**
 * Balise #SPIP_VERSION
 * 
 * On modifie le retour pour parler de MediaSPIP
 */
function balise_SPIP_VERSION($p) {
	$p->code = "mediaspip_version()";
	$p->interdire_scripts = false;
	return $p;
}

function mediaspip_version(){
	$version = defined('_MEDIASPIP_VERSION') ? " v"._MEDIASPIP_VERSION : '';
	if(!function_exists('spip_versions')) include_spip('inc/filtres');
	$spip_version = spip_version();
	return _T('mediaspip_core:info_mediaspip_version',array('version'=>$version,'spip_version'=>spip_version()));
}

function extraire_annee($str){
	$annee = '';
	if (preg_match('/\d{4}/', $str, $match) == 1 
			and $match[0] > 1970
			and $match[0] < 2038) {
		$annee = $match[0];
	}
	return $annee;
}

function supprimer_substr($str, $substr){
	return trim(preg_replace('/'.$substr.'/', '', $str, 1));
}

/**
 * Analyser une chaîne pour trouver des filtres de recherche
 * 
 * Typiquement, c'est pour analyser la chaîne de #RECHERCHE, et proposer
 * d'autres filtres de recherche.
 * 
 * Par exemple, si la chaîne de recherche est "pata 2013 test", on 
 * trouve l'année "2013", et le mot-clé 15 "patate".
 * 
 * Le tableau de retour sera:
 * array(
 *   0 => array(
 *       'filtre' => 'annee',
 *       'valeur' => '2013',
 *       'str' => 'pata  test',
 *     ),
 *   1 => array(
 *       'filtre' => 'id_mot',
 *       'valeur' => '15',
 *       'str' => ' 2013 test',
 *       'score' => '26.427160...',
 *     ),
 * )
 * 
 * @param string $str chaîne à analyser
 * 
 * @return array tableau des critères trouvés
 */
function proposer_filtres_recherche($str) {
	$res = array();
	// split the phrase by any number of commas or space characters,
	// which include " ", \r, \t, \n and \f
	$parts = preg_split("/[\s,]+/", $str);

	if ($annee = extraire_annee($str)) {
		$res[] = array('filtre'=>'annee', 'valeur'=>$annee, 'str'=>supprimer_substr($str,$annee));
	}

	/* Pour les mots-clés, on découpe d'abord la chaîne en "mots", pour
	 * pour voir ensuite retirer le "mot" (ex: "pata" dans le cas du 
	 * mot-clé "patate") */
	include_spip('inc/rechercher');
	foreach ($parts as $part) {
		if ($rech_part = recherche_en_base($part, 'mot') and isset($rech_part['mot'])) {
			foreach ($rech_part['mot'] as $k=>$v) {
				$res[] = array('filtre'=>'id_mot', 'valeur'=>$k, 'str'=>supprimer_substr($str,$part), 'score'=>$v['score']);
			}
		}
	}

	return $res;
}
?>
