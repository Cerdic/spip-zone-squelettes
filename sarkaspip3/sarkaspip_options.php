<?php
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
// Configuration cfg des plugins utilises par le squelette
// -- Plugin BOUTONS TEXTE
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTONLY', 'boutonstexte:texte_seulement');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTBACKSPIP', 'boutonstexte:retour_a_spip');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTSIZEUP', 'boutonstexte:augmenter_police');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTSIZEDOWN', 'boutonstexte:diminuer_police');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_SELECTOR', '#wrapper');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_JSFILE', 'boutonstexte.js');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_CSSFILE', 'boutonstexte');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_IMGPATH', 'images/fontsizeup.png');
// -- Plugin FANCYBOX
define('_SARKASPIP_CONFIG_FANCYBOX_MARGE', '5');
define('_SARKASPIP_CONFIG_FANCYBOX_IMAGE', '.fancybox');
define('_SARKASPIP_CONFIG_FANCYBOX_GALERIE', '.galerie .fancybox');
define('_SARKASPIP_CONFIG_FANCYBOX_RETAILLE', 'true');
define('_SARKASPIP_CONFIG_FANCYBOX_ARRIERE_PLAN', 'true');
define('_SARKASPIP_CONFIG_FANCYBOX_OPACITE', '0.3');
define('_SARKASPIP_CONFIG_FANCYBOX_FERME_CLIC', 'true');
// -- Plugin NYROCEROS
define('_SARKASPIP_CONFIG_NYROCEROS_TOUT', 'non');
define('_SARKASPIP_CONFIG_NYROCEROS_IMAGE', '.nyroceros');
define('_SARKASPIP_CONFIG_NYROCEROS_GALERIE', '.galerie .nyroceros');
define('_SARKASPIP_CONFIG_NYROCEROS_DIAPORAMA', 'non');
define('_SARKASPIP_CONFIG_NYROCEROS_PRELOAD', 'oui');
define('_SARKASPIP_CONFIG_NYROCEROS_BGFOND', '#000000');
// -- Plugin SOCIALTAGS
define('_SARKASPIP_CONFIG_SOCIALTAGS_SELECTOR', '#socialtags');

// Declaration des pipelines specifiques a Sarka-SPIP
define('_SARKASPIP_PIPELINES', 'colonne_extra_debut:colonne_extra_fin:colonne_navigation_debut:colonne_navigation_fin:menu_pages_speciales_fin:bandeau_haut_debut:bandeau_haut_fin:bandeau_bas_debut:bandeau_bas_fin:pied_debut:pied_fin');
$pipelines = explode(':', _SARKASPIP_PIPELINES);
foreach ($pipelines as $_pipe) {
	if (!isset($GLOBALS['spip_pipeline'][$_pipe]))
		$GLOBALS['spip_pipeline'][$_pipe] = '';
}
?>
