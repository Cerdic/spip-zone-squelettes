<?php
$GLOBALS['type_urls'] = 'propres2';
$GLOBALS['toujours_paragrapher'] = true;
$GLOBALS['barre_typo_pas_de_fork_typo'] = false; // Pour tenir compte de http://zone.spip.org/trac/spip-zone/changeset/22723 et disposer des raccourcis typo supplémentaires !

// Recalculer le cache si la config du site change
$GLOBALS['marqueur'] .= ":".md5($GLOBALS['meta']['boutonstexte'].$GLOBALS['meta']['btv2'].$GLOBALS['meta']['soyezcreateurs_couleurs'].$GLOBALS['meta']['soyezcreateurs_layout'].$GLOBALS['meta']['soyezcreateurs'].$GLOBALS['meta']['soyezcreateurs_google'].$GLOBALS['meta']['bte']); // Sur un conseil de Cedric : http://permalink.gmane.org/gmane.comp.web.spip.zone/6258

define('_DUREE_CACHE_DEFAUT', 30*24*3600); // pris en compte à partir de http://trac.rezo.net/trac/spip/changeset/10121
define('_URLS_PROPRES_MAX', 60); // pris en compte à partire de http://trac.rezo.net/trac/spip/changeset/10346 
define('_TRI_ARTICLES_RUBRIQUE', 'date DESC'); // cf http://trac.rezo.net/trac/spip/changeset/11492

global $couleurs_spip;
$couleurs_spip[] = array(
// Bleu Pyrat.net
		"couleur_foncee" => "#0F7FB3",
		"couleur_claire" => "#0094d3",
		"couleur_lien" => "#fe7801",
		"couleur_lien_off" => "#0d6f99"
);

// Compatibilite 1.9.3
if ($GLOBALS['spip_version_code']>='1.9250') {
	$couleurs = charger_fonction('couleurs', 'inc');
	$couleurs( array(
		// Vert
		1 => array (
				"couleur_foncee" => "#9DBA00",
				"couleur_claire" => "#C5E41C",
				),
		// Violet clair
		2 => array (
				"couleur_foncee" => "#eb68b3",
				"couleur_claire" => "#ffa9e6",
				),
		// Orange
		3 => array (
				"couleur_foncee" => "#fa9a00",
				"couleur_claire" => "#ffc000",
				),
		// Saumon
		4 => array (
				"couleur_foncee" => "#CDA261",
				"couleur_claire" => "#FFDDAA",
				),
		//  Bleu pastel
		5 => array (
				"couleur_foncee" => "#5da7c5",
				"couleur_claire" => "#97d2e1",
				),
		//  Gris
		6 => array (
				"couleur_foncee" => "#85909A",
				"couleur_claire" => "#C0CAD4",
				),
		7 => array ("couleur_foncee" => "#0F7FB3",
			"couleur_claire" => "#0094d3",
				),
	));
}

// Tous ces parametres sont inutiles et non pris en compte si le plugin cfg est installe
$GLOBALS['barre_typo_pas_de_fausses_puces'] = true;
$GLOBALS['BarreTypoEnrichie_Preserve_Header'] = true;
$GLOBALS['debut_intertitre'] = '<h2 class="spip">';
$GLOBALS['fin_intertitre'] = '</h2>';
$GLOBALS['debut_intertitre_2'] = '<h3 class="spip">';
$GLOBALS['fin_intertitre_2'] = '</h3>';
$GLOBALS['debut_intertitre_3'] = '<h4 class="spip">';
$GLOBALS['fin_intertitre_3'] = '</h4>';
$GLOBALS['debut_intertitre_4'] = '<h5 class="spip">';
$GLOBALS['fin_intertitre_4'] = '</h5>';
$GLOBALS['debut_intertitre_5'] = '<h6 class="spip">';
$GLOBALS['fin_intertitre_5'] = '</h6>';

// Pour suivre les recommandations du RGAA :
$GLOBALS['debut_italique'] = "<em$class_spip>";
$GLOBALS['fin_italique'] = '</em>';

// Pour pouvoir styler en appliquant : http://www.sovavsiti.cz/css/hr.html
$GLOBALS['ligne_horizontale'] = "\n<div class='hrspip'><hr class='spip' /></div>\n";

# La liste des webmestres n'ayant pas besoin d'autentification FTP pour les actions avancées de SPIP
# Séparer les id_auteurs par ':'
define('_ID_WEBMESTRES', '1');

# Envoi de mail aux contributeurs d'un forum si reponse a leur message
define('_SUIVI_FORUM_THREAD', true);

// Se passer de |supprimer_numero partout
$table_des_traitements['TITRE'][]= 'typo(trim(supprimer_numero(%s)))';


######## PACK ACTUEL DE CONFIGURATION DU COUTEAU SUISSE #########
// Attention, les surcharges sur les define() ou les globales ne sont pas specifiees ici
$GLOBALS['cs_installer']['SoyezCreateurs'] = array(

	// Installation des outils par defaut
	'outils' =>
		'typo_exposants|guillemets|smileys|mailcrypt',

	// Installation des variables par defaut
	'variables' => array(
	
	)
);

function balise_SECTEUR_PDF_dist($p) {
	if (!is_array($p->param))
		$p->param=array();
	
	// Produire le premier argument {secteur_pdf}
	$texte = new Texte;
	$texte->type='texte';
	$texte->texte='secteur_pdf';
	$param = array(0=>NULL, 1=>array(0=>$texte));
	array_unshift($p->param, $param);
	
	// Transformer les filtres en arguments
	for ($i=1; $i<count($p->param); $i++) {
		if ($p->param[$i][0]) {
			if (!strstr($p->param[$i][0], '='))
				break;# on a rencontre un vrai filtre, c'est fini
			$texte = new Texte;
			$texte->type='texte';
			$texte->texte=$p->param[$i][0];
			$param = array(0=>$texte);
			$p->param[$i][1] = $param;
			$p->param[$i][0] = NULL;
		}
	}
	
	// Appeler la balise #MODELE{secteur_pdf}{arguments}
	if (!function_exists($f = 'balise_modele'))
		$f = 'balise_modele_dist';
	return $f($p);
}
?>