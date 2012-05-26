<?php
// Supprimer systematiquement les numeros des titres et noms
$GLOBALS['table_des_traitements']['TITRE'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)';
$GLOBALS['table_des_traitements']['NOM'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)';

// Liste des rubriques specialisees standard du squelette
// Pour ajouter des rubriques perso, definir de la meme facon les constantes _PERSO_XXX
// dans le fichier mes_options.php
define('_SARKASPIP_MOT_SECTEURS_SPECIALISES', 'agenda:galerie:squelette:forum');
define('_SARKASPIP_TYPE_SECTEURS_SPECIALISES', 'config:config:config:config');
define('_SARKASPIP_FOND_SECTEURS_SPECIALISES', 'sarkaspip_agenda:sarkaspip_galerie:sarkaspip_accueil:sarkaspip_forum');

// Modes de debug du squelette
define('_SARKASPIP_DEBUG_CSS', 'non');
define('_SARKASPIP_DEBUG_CFG_ARBO', 'non');
define('_SARKASPIP_DEBUG_CFG_BOUTON', 'non');
define('_SARKASPIP_DEBUG_CFG_FONDS', 'non');

// Liste des donnees de configuration du squelette non CFG
// -- Pour les meta
define('_SARKASPIP_CONFIG_INTRO_META', 150);
// -- Pour les documents joints et portfolio d'images
define('_SARKASPIP_CONFIG_LARGEUR_DOCUMENT', 115);
define('_SARKASPIP_CONFIG_LARGEUR_IMAGE', 115);
define('_SARKASPIP_CONFIG_TAILLE_TITRE_DOCUMENT', 50);
define('_SARKASPIP_CONFIG_TAILLE_TITRE_IMAGE', 50);
define('_SARKASPIP_CONFIG_TAILLE_DESCR_DOCUMENT', 100);
define('_SARKASPIP_CONFIG_TAILLE_DESCR_IMAGE', 100);
// -- Pour les modeles d'inscrustation de documents et d'images
define('_SARKASPIP_CONFIG_IMG_TAILLE_MAX_EMBED', 500);
define('_SARKASPIP_CONFIG_DOC_LARGEUR_MIN', 120);
define('_SARKASPIP_CONFIG_DOC_LARGEUR_MAX', 350);
// -- Pour les vignettes de la galerie et des albums
define('_SARKASPIP_CONFIG_LARGEUR_GALERIE', 80);
define('_SARKASPIP_CONFIG_TAILLE_MAX_VIGNETTE_1', 80);
define('_SARKASPIP_CONFIG_TAILLE_MAX_VIGNETTE_2', 40);
define('_SARKASPIP_CONFIG_TAILLE_MAX_VIGNETTE_3', 100);
define('_SARKASPIP_CONFIG_TAILLE_MAX_VIGNETTE_4', 120);
define('_SARKASPIP_CONFIG_TAILLE_MAX_PHOTO', 400);
// -- Pour les icones de rainette
define('_SARKASPIP_CONFIG_LARGEUR_ICONE_METEO', 80);
// -- Pour le contact du site
define('_SARKASPIP_CONFIG_AUTORISATION_CONTACT', '0minirezo');
// -- Pour la fenetre de dialgue utilisant le plugin SHOUTBOX
define('_SARKASPIP_CONFIG_SHOUTBOX_PAGE', 'dialogue');
define('_SARKASPIP_CONFIG_SHOUTBOX_TAILLE', 50);
// -- Pour le chemin du bandeau
define('_SARKASPIP_CONFIG_SYMBOLE_CHEMIN', '&gt;');
// -- Pour la pagination
define('_SARKASPIP_CONFIG_SYMBOLE_PAGINATION', '&nbsp;|&nbsp;');
// -- Pour l'agenda
define('_SARKASPIP_CONFIG_AGENDA_ANCRE_PAGINATION', 'evenement');
define('_SARKASPIP_CONFIG_AGENDA_SYMBOLE_SUIVANT', '&gt;&gt;');
define('_SARKASPIP_CONFIG_AGENDA_SYMBOLE_PRECEDENT', '&lt;&lt;');
// -- Pour la page afaire (plugin Tickets)
define('_SARKASPIP_AFAIRE_JALONS_AFFICHES', '');
define('_SARKASPIP_AFAIRE_ID_ARTICLE', '0');
define('_SARKASPIP_AFAIRE_TAILLE_LOGO', '150');
// Configuration minimale des plugins utilises par le squelette
// -- Plugin BOUTONS TEXTE
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_SELECTOR', '#wrapper');
// -- Plugin FANCYBOX
define('_SARKASPIP_CONFIG_FANCYBOX_IMAGE', '.fancybox');
define('_SARKASPIP_CONFIG_FANCYBOX_GALERIE', '.galerie .fancybox');
// -- Plugin NYROCEROS
define('_SARKASPIP_CONFIG_NYROCEROS_TOUT', 'non');
define('_SARKASPIP_CONFIG_NYROCEROS_IMAGE', '.nyroceros');
define('_SARKASPIP_CONFIG_NYROCEROS_GALERIE', '.galerie .nyroceros');
define('_SARKASPIP_CONFIG_NYROCEROS_DIAPORAMA', 'non');
// -- Plugin SOCIALTAGS
define('_SARKASPIP_CONFIG_SOCIALTAGS_SELECTOR', '#socialtags');
define('_SARKASPIP_CONFIG_SOCIALTAGS_TAGS', 'delicious:facebook:google:netvibes');

// Pipelines specifiques a Sarka-SPIP
// -- Declaration
define('_SARKASPIP_PIPELINES', 'colonne_extra_debut:colonne_extra_fin:colonne_navigation_debut:colonne_navigation_fin:menu_pages_speciales_fin:bandeau_haut_debut:bandeau_haut_fin:bandeau_bas_debut:bandeau_bas_fin:pied_debut:pied_fin');
$pipelines = explode(':', _SARKASPIP_PIPELINES);
foreach ($pipelines as $_pipe) {
	if (!isset($GLOBALS['spip_pipeline'][$_pipe]))
		$GLOBALS['spip_pipeline'][$_pipe] = "|personnaliser_$_pipe";
}
// -- Fonction d'affichage des noisettes
function afficher_noisettes($define, $flux, $ajax=true){
	$noisettes = explode(':', $define);
	foreach ($noisettes as $_fond) {
		if (find_in_path($_fond.'.html')) {
			$contexte = $ajax ? array_merge($flux['args'], array('ajax' => true)) : $flux['args'];
			$html = recuperer_fond($_fond, $contexte);
			$flux['data'] .= $html;
		}
		else 
			$flux['data'] .= '<div class="noisette avertissement" style="margin-top: 0; font-size: 0.95em">' . _T('sarkaspip:msg_fichier_introuvable', array('fichier' => $_fond . '.html')) . '</div>';
	}
	return $flux;
}
// -- Fonction d'insertion en debut de colonne extra
function personnaliser_colonne_extra_debut($flux){
	if (defined('_PERSO_COLONNE_EXTRA_DEBUT'))
		return afficher_noisettes(_PERSO_COLONNE_EXTRA_DEBUT, $flux, true);
}
// -- Fonction d'insertion en fin de colonne extra
function personnaliser_colonne_extra_fin($flux){
	if (defined('_PERSO_COLONNE_EXTRA_FIN')) 
		return afficher_noisettes(_PERSO_COLONNE_EXTRA_FIN, $flux, true);
}
// -- Fonction d'insertion en debut de colonne navigation
function personnaliser_colonne_navigation_debut($flux){
	if (defined('_PERSO_COLONNE_NAVIGATION_DEBUT'))
		return afficher_noisettes(_PERSO_COLONNE_NAVIGATION_DEBUT, $flux, true);
}
// -- Fonction d'insertion en fin de colonne navigation
function personnaliser_colonne_navigation_fin($flux){
	if (defined('_PERSO_COLONNE_NAVIGATION_FIN'))
		return afficher_noisettes(_PERSO_COLONNE_NAVIGATION_FIN, $flux, true);
}
// -- Fonction d'insertion en fin de menu des pages speciales
function personnaliser_menu_pages_speciales_fin($flux){
	if (defined('_PERSO_MENU_PAGES_SPECIALES_FIN'))
		return afficher_noisettes(_PERSO_MENU_PAGES_SPECIALES_FIN, $flux, false);
}
// -- Fonction d'insertion en debut de bandeau haut
function personnaliser_bandeau_haut_debut($flux){
	if (defined('_PERSO_BANDEAU_HAUT_DEBUT'))
		return afficher_noisettes(_PERSO_BANDEAU_HAUT_DEBUT, $flux, false);
}
// -- Fonction d'insertion en fin de bandeau haut
function personnaliser_bandeau_haut_fin($flux){
	if (defined('_PERSO_BANDEAU_HAUT_FIN'))
		return afficher_noisettes(_PERSO_BANDEAU_HAUT_FIN, $flux, false);
}
// -- Fonction d'insertion en debut de bandeau bas
function personnaliser_bandeau_bas_debut($flux){
	if (defined('_PERSO_BANDEAU_BAS_DEBUT'))
		return afficher_noisettes(_PERSO_BANDEAU_BAS_DEBUT, $flux, false);
}
// -- Fonction d'insertion en fin de bandeau bas
function personnaliser_bandeau_bas_fin($flux){
	if (defined('_PERSO_BANDEAU_BAS_FIN'))
		return afficher_noisettes(_PERSO_BANDEAU_BAS_FIN, $flux, false);
}
// -- Fonction d'insertion en debut de pied
function personnaliser_pied_debut($flux){
	if (defined('_PERSO_PIED_DEBUT'))
		return afficher_noisettes(_PERSO_PIED_DEBUT, $flux, false);
}
// -- Fonction d'insertion en fin de pied
function personnaliser_pied_fin($flux){
	if (defined('_PERSO_PIED_FIN'))
		return afficher_noisettes(_PERSO_PIED_FIN, $flux, false);
}

?>
