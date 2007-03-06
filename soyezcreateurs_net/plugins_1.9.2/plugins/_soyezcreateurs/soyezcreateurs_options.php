<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_SOYEZCREATEURS',(_DIR_PLUGINS.end($p)));

$formats_logos =  array ('gif', 'jpg', 'png', 'swf');
$type_urls = 'propres2';

$GLOBALS['barre_typo_pas_de_fausses_puces'] = true;
$GLOBALS['BarreTypoEnrichie_Preserve_Header'] = true;

global $couleurs_spip;
$couleurs_spip[] = array(
// Bleu Pyrat.net
		"couleur_foncee" => "#0F7FB3",
		"couleur_claire" => "#0094d3",
		"couleur_lien" => "#fe7801",
		"couleur_lien_off" => "#0d6f99"
);

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

$_GET["set_options"] = $GLOBALS["set_options"] = 'avancees';

# si vous n'avez aucun fichier .php3, redefinissez a ""
# ca fera foncer find_in_path
define('_EXTENSION_PHP', '');

# La liste des webmestres n'ayant pas besoin d'autentification FTP pour les actions avancées de SPIP
# Séparer les id_auteurs par ':'
define('_ID_WEBMESTRES', '1');

# Envoi de mail aux contributeurs d'un forum si reponse a leur message
define('_SUIVI_FORUM_THREAD', true);

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