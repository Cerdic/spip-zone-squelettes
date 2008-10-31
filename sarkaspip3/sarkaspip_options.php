<?php
// Liste des rubriques specialisees standard du squelette
// Pour ajouter des rubriques perso, definir de la meme facon les constantes _PERSO_XXX
// dans le fichier mes_options.php
define('_SARKASPIP_MOT_SECTEURS_SPECIALISES', 'agenda:galerie:annonce:herbier');
define('_SARKASPIP_TYPE_SECTEURS_SPECIALISES', 'config:config:config:config');
define('_SARKASPIP_FOND_SECTEURS_SPECIALISES', 'sarkaspip_agenda:sarkaspip_galerie:sarkaspip_noisettes:sarkaspip_herbier');

// Liste des donnees de configuration du squelette non CFG et utilisable via la balise #EVAL
// Pour les documents joints et portfolio d'images
define('_SARKASPIP_CONFIG_LARGEUR_DOCUMENT', 115);
define('_SARKASPIP_CONFIG_LARGEUR_IMAGE', 115);
define('_SARKASPIP_CONFIG_TAILLE_TITRE_DOCUMENT', 50);
define('_SARKASPIP_CONFIG_TAILLE_TITRE_IMAGE', 50);
define('_SARKASPIP_CONFIG_TAILLE_DESCR_DOCUMENT', 100);
define('_SARKASPIP_CONFIG_TAILLE_DESCR_IMAGE', 100);

// Pour les variables cfg des plugins utilises par le squelette
// Plugin BOUTONS TEXTE
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTONLY', 'boutonstexte:texte_seulement');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTBACKSPIP', 'boutonstexte:retour_a_spip');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTSIZEUP', 'boutonstexte:augmenter_police');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTSIZEDOWN', 'boutonstexte:diminuer_police');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_SELECTOR', '#wrapper');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_JSFILE', 'boutonstexte.js');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_CSSFILE', 'boutonstexte');
define('_SARKASPIP_CONFIG_BOUTONSTEXTE_IMGPATH', 'images/fontsizeup.png');
// Plugin NYROCEROS
define('_SARKASPIP_CONFIG_NYROCEROS_TOUT', 'non');
define('_SARKASPIP_CONFIG_NYROCEROS_IMAGE', '.nyroceros');
define('_SARKASPIP_CONFIG_NYROCEROS_GALERIE', '.galerie .nyroceros');
define('_SARKASPIP_CONFIG_NYROCEROS_PRELOAD', 'oui');
define('_SARKASPIP_CONFIG_NYROCEROS_BGFOND', '#000000');
?>