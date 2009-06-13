<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilisÃ© dans les squelettes

$GLOBALS[$GLOBALS['idx_lang']]=array(
// A <:form_pet_message_commentaire:>
'accueil' => 'Portada del sitio',
'acces_restreint' => 'Acceso limitado',
'agenda' => 'Agenda',
'aide' => 'Ayuda',
'articles' => 'Articulos',
'article_complet' => 'Articulo entero',
'aucun_resultat_pour' => 'Ning&uacute;n resultado para',
'article_precedent' => 'Precedente',
'article_precedent_premier' => 'Primero',
'article_suivant' => 'Siguiente',
'article_suivant_dernier' => 'Ultimo',
'aucun_evenement' => 'No hay ning&uacute;n acontecimiento previsto durante este mes en el orden del d&iacute;a',

// B
'breves' => 'Noticias cortas',
'breves_rubrique' => 'Noticias cortas de la r&uacute;brica',

// C
'contact' => 'Contacto',
'copyright_spip' => 'Este sitio web esta administrado por',
'copyright_eva' => 'y utiliza el esqueleto',

// D
'doc_redacteurs' => 'Documentaci&oacute;n en l&iacute;nea para los redactores usando EVA-Red',
'documents_joints' => 'Documentos adjuntos',
'document' => 'Documento',
'deconnecter' => 'Desconectarse',
'derniers_articles' => 'Los ultimos articulos',
'dernieres_breves' => 'Los &uacute;ltimos articulos cortos',
'derniers_commentaires' => 'Los &uacute;ltimos comentarios',
'derniers_podcasts' => '&Uacute;ltimos podcasts',
'derniers_sites' => '&Uacute;ltimos sitios',
'de_cet_auteur' => 'de este autor',
'derniere_mise_a_jour' => '&Uacute;ltimas actualizaciones',
'diaporama' => 'Diaporama',
'dix_meilleurs_articles' => 'Los diez mejores articulos',
'dix_meilleurs_commentaires' => 'Los diez mejores comentarios',
'dix_meilleurs_breves' => 'Las diez mejores noticias cortas',

// E
'erreur_404' => 'Error 404',
'evenements_du' => 'Los acontecimientos del',
'evenements_a_venir' => 'Los acontecimientos a venir',
'evenement_aucun' => 'No hay ning&uacute;n acontecimiento previsto durante este mes en el orden del d&iacute;a',
'evenements_passes' => 'Ev&egrave;nements pass&eacute;s',
'evenements_passes_aucun' => 'No hay ning&uacute;n acontecimiento previsto  en este orden del d&iacute;a',

// F
'fermer_fenetre' => 'Cerrar la ventana',
'form_pet_message_commentaire' => 'Àun comentario?',
'feuilleter_livre' => 'hojear el libro',

// G
'go' => 'ir',
'galaxie_spip' => 'La galaxia SPIP',

// H

// I
'identifier' => 'Usted es autentificado',
'il_y_a' => 'Hay',
'il_y_a1' => 'firma (s) para esta petici&oacute;n',
'il_y_a2' => 'Se encuentra en total',
'il_y_a3' => 'articulo(s).<br /> Este bloque en cartel',
'il_y_a4' => 'autor(es).<br /> Este bloque en cartel',
'il_y_a5' => 'Noticia(s) cortas.<br /> Este bloque en cartel',

// J
'j1' => 'lu',
'j2' => 'ma',
'j3' => 'mier',
'j4' => 'ju',
'j5' => 'vi',
'j6' => 'sa',
'j7' => 'do',
'jo1' => 'Lunes',
'jo2' => 'Martes',
'jo3' => 'Mi&eacute;rcoles',
'jo4' => 'Jueves',
'jo5' => 'Viernes',
'jo6' => 'Sabado',
'jo7' => 'Domingo',

// L
'lire_suite' => 'Leer la concecuencia',
'lancer_diaporama' => 'Abri el Diaporama',
'lien_externe'=>"V&iacute;nculo exterior al sitio, se abre en una nueva ventana",

// M
'meme_rubrique' => 'En la misma r&uacute;brica',
'mot_cle' => 'Palabras Llaves',
'mis_a_jour' => 'Actualisaci&oacute;n; :',
'mentions' => 'Mentions',
'mentions_legales' => 'menciones legales',
'm1' => 'enero',
'm2' => 'fevrero',
'm3' => 'marzo',
'm4' => 'avril',
'm5' => 'mayo',
'm6' => 'junio',
'm7' => 'julio',
'm8' => 'agosto',
'm9' => 'septiembre',
'm10' => 'octubre',
'm11' => 'noviembre',
'm12' => 'diciembre',

// N
'notes' => 'Notas',

// P
'plan_du_site' => 'Mapa del sitio',
'post_scriptum' => 'Post-scriptum',
'par' => 'Por :',
'publie' => 'Publicado :',
'rechercher' => 'Buscar a',
'resultats' => 'Resultados',
'pour' => 'para',
'pages' => 'hojas',
'partenaires' => 'Socios',
'podcasts' =>'Podcasts',
'podcasts_rss' => 'Podcast y RSS',

// R
'redaction' => 'Redacci&oacute;n',
'rechercher' => 'Buscar',
'replier' => 'Doblar',

// S
'sites' => 'otros sitios :',
'sites_references' => 'Sitio hechos r&eacutef&acute;rencia',
'sites_rubrique' => 'Los sitios de la r&uacute;brica',
'sites_syndic' => 'Sitios ref&eacute;renciados que pr&eacutesentan trabajos ',
'sur_le_web' => 'Sur le web',
'sur_un_total_de' => 'sur un total de',
'sous_rubrique' => 'Sous-rubrique',
'statut_admin' => 'Statut : Administrateur<br />',
'statut_redac' => 'Statut : R&eacute;dacteur',
'statut_visit' => 'Statut : Visiteur',

// T
'texte_page_404' => '<em>Ál&aacutestima !</em><br />La pgina que Usted trata de leer no existe mas. ',
'tous_les_auteurs' => 'Todos los autores',
'tous_droits' => 'Todos los derechos',

// V
'version_eva' => 'EVA-Web 4.0 estable',
'visites' => 'Visitores',
'voir_en_ligne' => 'Ver sobre el Web :',
'voir_image' => 'Ver la imagen en modo normal',
'vous_etes_ici' => 'Esta usted aqu&iacute).fr :',

//Z

'zone' => 'zona protegida',
);
?>