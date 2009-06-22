<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilise dans les squelettes

$test_lang_personnalisation=array(
// A <:form_pet_message_commentaire:>
'accueil' => 'Portada del sitio',
'acces_restreint' => 'Acceso limitado',
'agenda' => 'Agenda',
'aide' => 'Ayuda',
'articles' => 'Art&iacute;culos',
'article_complet' => 'Art&iacute;culo entero',
'aucun_resultat_pour' => 'Ning&uacute;n resultado para',
'article_precedent' => 'Precedente',
'article_precedent_premier' => 'Primero',
'article_suivant' => 'Siguiente',
'article_suivant_dernier' => '&Uacute;ltimo art&iacute;culo',
'aucun_evenement' => 'No hay ning&uacute;n acontecimiento previsto durante este mes en el orden del d&iacute;a',

// B
'breves' => 'Noticias cortas',
'breves_rubrique' => 'Noticias cortas de la secci&oacute;',

// C
'contact' => 'Contacto',
'copyright_spip' => 'Este sitio web est&aacute; administrado con',
'copyright_eva' => 'y utiliza el esqueleto',

// D
'doc_redacteurs' => 'Documentaci&oacute;n en l&iacute;nea para los redactores usando EVA-Red',
'documents_joints' => 'Documentos adjuntos',
'document' => 'Documento',
'deconnecter' => 'Desconectarse',
'derniers_articles' => 'Los &uacute;ltimos art&iacute;culos',
'dernieres_breves' => 'Los &uacute;ltimos art&iacute;culos cortos',
'derniers_commentaires' => 'Los &uacute;ltimos comentarios',
'derniers_podcasts' => '&Uacute;ltimos podcasts',
'derniers_sites' => '&Uacute;ltimos sitios',
'de_cet_auteur' => 'de este autor',
'derniere_mise_a_jour' => '&Uacute;ltimas actualizaciones',
'diaporama' => 'Diaporama',
'dix_meilleurs_articles' => 'Los diez mejores art&iacute;culos',
'dix_meilleurs_commentaires' => 'Los diez mejores comentarios',
'dix_meilleurs_breves' => 'Las diez mejores noticias cortas',

// E
'erreur_404' => 'Error 404',
'evenements_du' => 'Los acontecimientos del',
'evenements_a_venir' => 'Los pr&oacute;ximos acontecimientos',
'evenement_aucun' => 'No hay ning&uacute;n acontecimiento previsto durante este mes en el orden del d&iacute;a',
'evenements_passes' => 'Acontecimientos pasados',
'evenements_passes_aucun' => 'No hay ning&uacute;n acontecimiento pasados en este orden del d&iacute;a',

// F
'fermer_fenetre' => 'Cerrar la ventana',
'form_pet_message_commentaire' => '&iquest;un comentario?',
'feuilleter_livre' => 'hojear el libro',

// G
'go' => 'ir',
'galaxie_spip' => 'La galaxia SPIP',

// H

// I
'identifier' => 'Usted se ha autentificado',
'il_y_a' => 'Hay',
'il_y_a1' => 'firma(s) para esta petici&oacute;n',
'il_y_a2' => 'Se encuentra en total',
'il_y_a3' => 'art&iacute;culo(s).<br /> Este bloque en cartel',
'il_y_a4' => 'autor(es).<br /> Este bloque en cartel',
'il_y_a5' => 'Noticia(s) cortas.<br /> Este bloque en cartel',

// J
'j1' => 'lu',
'j2' => 'ma',
'j3' => 'mi&eacute;r',
'j4' => 'ju',
'j5' => 'vi',
'j6' => 's&aacute;',
'j7' => 'do',
'jo1' => 'Lunes',
'jo2' => 'Martes',
'jo3' => 'Mi&eacute;rcoles',
'jo4' => 'Jueves',
'jo5' => 'Viernes',
'jo6' => 'S&aacute;bado',
'jo7' => 'Domingo',

// L
'lire_suite' => 'Leer m&aacute;s',
'lancer_diaporama' => 'Abrir el Diaporama',
'lien_externe'=>"Enlace exterior al sitio, se abre en una nueva ventana",

// M
'meme_rubrique' => 'En la misma secci&oacute;n',
'mot_cle' => 'Palabra clave',
'mis_a_jour' => 'Actualizaci&oacute;n :',
'mentions' => 'Menciones',
'mentions_legales' => 'Menciones legales',
'm1' => 'enero',
'm2' => 'febrero',
'm3' => 'marzo',
'm4' => 'abril',
'm5' => 'mayo',
'm6' => 'junio',
'm7' => 'julio',
'm8' => 'agosto',
'm9' => 'septiembre',
'm10' => 'octubre',
'm11' => 'noviembre',
'm12' => 'diciembre',

// N
'notes' => 'Apuntes',

// P
'plan_du_site' => 'Mapa del sitio',
'post_scriptum' => 'Postdata',
'par' => 'Por :',
'publie' => 'Publicado :',
'pour' => 'para',
'pages' => 'P&aacute:ginas',
'partenaires' => 'Socios',
'podcasts' =>'Podcasts',
'podcasts_rss' => 'Podcast y RSS',

// R
'redaction' => 'Redacci&oacute;n',
'rechercher' => 'Buscar',
'resultats' => 'Resultados',
'replier' => 'Doblar',

// S
'sites' => 'otros sitios :',
'sites_references' => 'Sitios referenciados',
'sites_rubrique' => 'Los sitios de la secci&oacute;n',
'sites_syndic' => 'Sitios sindicados',
'sur_le_web' => 'En la Web',
'sur_un_total_de' => 'sobre un total de',
'sous_rubrique' => 'subdivisi&oacute;n de secci&oacute;n',
'statut_admin' => 'Estatuto : Administrador',
'statut_redac' => 'Estatuto : Redactor',
'statut_visit' => 'Estatuto : Visitante',

// T
'texte_page_404' => '<em> &iexcl; l&aacutestima !</em><br />La p&aacute;gina que Usted trata de leer ya no existe.',
'tous_les_auteurs' => 'Todos los autores',
'tous_droits' => 'Todos derechos reservados',

// V
'version_eva' => 'EVA-Web 4.0 estable',
'visites' => 'Visitas',
'voir_en_ligne' => 'Ver en l&iacute;nea :',
'voir_image' => 'Ver la imagen en modo normal',
'vous_etes_ici' => 'Usted est&aacute; aqu&iacute; :',

//Z

'zone' => 'zona protegida',
);
foreach ($test_lang_personnalisation as $cle=>$val) {
if ((isset($GLOBALS['meta']['eva_habillage_base_version'])) AND !($_GET['action']=='desinstaller_plugin')) {
	$test_lang=sql_select('nom_image','spip_eva_habillage_images',"type = 'fichier_lang' AND nom_habillage = 'Defaut' AND nom_div = '$cle'");
	$result_lang=sql_fetch($test_lang);
	$resultat=$result_lang['nom_image'];
	if ($resultat) {
		$GLOBALS[$GLOBALS['idx_lang']][$cle] = $resultat;
	}
	else {
		$GLOBALS[$GLOBALS['idx_lang']] [$cle] = $val;
	}
}
else {$GLOBALS[$GLOBALS['idx_lang']] [$cle] = $val;}
}
?>