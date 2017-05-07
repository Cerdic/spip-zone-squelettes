<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilise dans les squelettes

$test_lang_personnalisation=array(
// A
	'acces_restreint' => 'Acceso limitado',
	'accueil' => 'Portada del sitio',
	'agenda' => 'Agenda',
	'aide' => 'Ayuda',
	'article_complet' => 'Artículo entero',
	'article_precedent' => 'Precedente',
	'article_precedent_premier' => 'Primero',
	'article_suivant' => 'Siguiente',
	'article_suivant_dernier' => 'Último artículo',
	'articles' => 'Artículos',
	'aucun_evenement' => 'No hay ningún acontecimiento previsto durante este mes en el orden del día',
	'aucun_resultat_pour' => 'Ningún resultado para',

	// B
	'breves' => 'Noticias cortas',
	'breves_rubrique' => 'Noticias cortas de la secció',

	// C
	'contact' => 'Contacto',
	'copyright_eva' => 'y utiliza el esqueleto',
	'copyright_spip' => 'Este sitio web está administrado con',

	// D
	'de_cet_auteur' => 'de este autor',
	'deconnecter' => 'Desconectarse',
	'derniere_mise_a_jour' => 'Últimas actualizaciones',
	'dernieres_breves' => 'Los últimos artículos cortos',
	'derniers_articles' => 'Los últimos artículos',
	'derniers_commentaires' => 'Los últimos comentarios',
	'derniers_podcasts' => 'Últimos podcasts',
	'derniers_sites' => 'Últimos sitios',
	'diaporama' => 'Diaporama',
	'dix_meilleurs_articles' => 'Los diez mejores artículos',
	'dix_meilleurs_breves' => 'Las diez mejores noticias cortas',
	'dix_meilleurs_commentaires' => 'Los diez mejores comentarios',
	'doc_redacteurs' => 'Documentación en línea para los redactores usando EVA-Red',
	'document' => 'Documento',
	'documents_joints' => 'Documentos adjuntos',

	// E
	'erreur_404' => 'Error 404',
	'evenement_aucun' => 'No hay ningún acontecimiento previsto durante este mes en el orden del día',
	'evenements_a_venir' => 'Los próximos acontecimientos',
	'evenements_du' => 'Los acontecimientos del',
	'evenements_passes' => 'Acontecimientos pasados',
	'evenements_passes_aucun' => 'No hay ningún acontecimiento pasados en este orden del día',

	// F
	'fermer_fenetre' => 'Cerrar la ventana',
	'feuilleter_livre' => 'hojear el libro',
	'form_pet_message_commentaire' => '¿un comentario?',

	// G
	'galaxie_spip' => 'La galaxia SPIP',
	'go' => 'ir',

	// I
	'icone_eva' => 'Icono EVA-red 4',
	'identifier' => 'Usted se ha autentificado',
	'il_y_a' => 'Hay',
	'il_y_a1' => 'firma(s) para esta petición',
	'il_y_a2' => 'Se encuentra en total',
	'il_y_a3' => 'artículo(s).<br /> Este bloque en cartel',
	'il_y_a4' => 'autor(es).<br /> Este bloque en cartel',
	'il_y_a5' => 'Noticia(s) cortas.<br /> Este bloque en cartel',
	'inscription' => 'inscripción',

	// J
	'j1' => 'lu',
	'j2' => 'ma',
	'j3' => 'miér',
	'j4' => 'ju',
	'j5' => 'vi',
	'j6' => 'sá',
	'j7' => 'do',
	'jo1' => 'Lunes',
	'jo2' => 'Martes',
	'jo3' => 'Miércoles',
	'jo4' => 'Jueves',
	'jo5' => 'Viernes',
	'jo6' => 'Sábado',
	'jo7' => 'Domingo',

	// L
	'lancer_diaporama' => 'Abrir el Diaporama',
	'lien_externe' => 'Enlace exterior al sitio, se abre en una nueva ventana',
	'lire_suite' => 'Leer más',

	// M
	'm1' => 'enero',
	'm10' => 'octubre',
	'm11' => 'noviembre',
	'm12' => 'diciembre',
	'm2' => 'febrero',
	'm3' => 'marzo',
	'm4' => 'abril',
	'm5' => 'mayo',
	'm6' => 'junio',
	'm7' => 'julio',
	'm8' => 'agosto',
	'm9' => 'septiembre',
	'meme_rubrique' => 'En la misma sección',
	'mentions' => 'Menciones',
	'mentions_adresse' => 'Dirección : ',
	'mentions_directeur_publication' => 'Director de la publicación :',
	'mentions_droit_auteur_texte' => '<p>este sitio está incluido en la legislación francesa e internacional sobre los derechos de autor y la propiedad intelectual </p>
 <p>Se reservan todos los derechos de reproducción.</p>',
	'mentions_droit_auteur_titre' => 'derechos de autores :',
	'mentions_legales' => 'Menciones legales',
	'mentions_liens_hypertexte_texte' => '<p>Este sitio contiene vínculos hipertextuales que dan paso a unos sitios que no son producidos por el responsable de este sitio.</p>
 <p>Por consiguiente el director de publicación no puede ser considerado como responsable del contenido de los sitios a los que el internauta podría acceder.</p>
 <p>Queda terminantemente prohibido recoger y utilizar las informaciones disponibles en el sitio con fines comerciales.</p>
 <p>Esta prohibición se refiere, sin que el listado siguiente sea limitativo, a todos los elementos de redacción que se encuentran en el sitio, la presentación de las pantallas, los programas informáticos necesarios a la explotación, los logotipos, las imágenes, las fotografías, los gráficos, cualquiera sea su forma.</p>',
	'mentions_liens_hypertexte_titre' => 'vínculos hipertexto :',
	'mentions_liens_texte' => '<p>A l\'exception de sites diffusant des informations et/ou contenus ayant un caractère illégal et/ou à caractère politique, religieux, pornographique, xénophobe, vous pouvez créer un lien hypertexte vers notre Site sur votre site.</p>
	<p>La mise en place de lien hypertexte n\'autorise en aucune façon la reproduction d\'éléments du Site ou la présentation sur des sites tiers d\'éléments du Site sous forme de Frame ou système apparenté.</p>
	<p>Enfin, la mise en place de lien hypertexte n\'autorise en aucune façon de proposer l\'envoi d\'un message pré-rédigé à une adresse mail liée au Site ou la mise en place d\'un système permettant l\'envoi massif de messages quelle qu\'en soit la nature.</p>
	<p>Tous les droits de reproduction sont réservés.</p>', # NEW
	'mentions_liens_titre' => 'Vínculos hipertexto hacia este sitio :',
	'mentions_logo_cddp74' => 'Sitio official del CDDP74',
	'mentions_logo_citic' => 'Centro de Informática y de las TIC de Haute-Savoie (ex CRI74)',
	'mentions_logo_edres' => 'Educación Red Haute-Savoie, proyecto departamental',
	'mentions_logo_eva' => 'Sitio oficial del proyecto eva-reb',
	'mentions_logo_spip' => 'Sitio oficial de SPIP',
	'mentions_logo_spipedu' => 'Spip-edu, sitio de la comunidad educativa ',
	'mentions_lois' => 'En virtud de la ley para la confianza en la economía numérica (LCEN) del 21 de junio de 2004, ahí tienen los datos del editor y el prestador de servicios que acoge el sitio :',
	'mentions_prestataire' => 'Prestador de servicios que garantiza el almacenamiento directo y permanente :',
	'mentions_qualite' => 'Calidad :',
	'mentions_qui_texte' => '<p>A l\'origine <a href="http://eva-web.edres74.net/eva/">EVA</a>
	correspond à un projet de portail d\'Intranet d\'Établissement, installé sur 
	les serveurs <a href="http://www.pingoo.org/">PingOO</a>.</p>
	<p>Cette version, légèrement adaptée, permet à une école ou à un établissement de mettre 
	en place un site web collaboratif, en proposant différents modèles de publication 
	(article, album photo, diaporama ...) </p>
	<p>Pour plus de renseignements sur le projet <a href="http://eva-web.edres74.net">EVA-web</a>, consultez le site 
  	<a href="http://eva-web.edres74.net">http://eva-web.edres74.net</a></p>
	<p><a href="http://eva-web.edres74.net">EVA-web</a> est un logiciel libre distribué sous Licence Publique Générale 
	<a rel="licence" target="_blank" href="http://www.april.org/gnu/gpl_french.html">GNU (GNU General Public License ou GPL)</a>
	conçu pour fonctionner à partir de l\'application <a href="https://www.spip.net/">SPIP</a>.</p>
	<div style="text-align:center;"><a rel="licence" target="_blank" href="http://www.april.org/gnu/gpl_french.html"><img alt="Licence GNU GPL" style="border-width:0" width="80" height="100" src="http://www.fsf.org/graphics/philosophical-gnu-sm.jpg"/></a></div>', # NEW
	'mentions_qui_titre' => '¿ EVA, por quién, par quién ?',
	'mentions_responsable_edition' => 'Director de la redacción :',
	'mentions_site' => 'Sitio Internet de : ',
	'mentions_webmestre' => 'Webmaster :',
	'meteo' => 'Meteo',
	'meteo_info' => 'Informaciones geográficas',
	'meteo_previsions' => 'predicciones meteológicas',
	'mis_a_jour' => 'Actualización :',
	'mot_cle' => 'Palabra clave',
	'multilinguisme' => '¿Indicar la carta de lengua de EVA-red en las páginas públicas?',
	'multilinguisme_article' => 'Este artículo en:',

	// N
	'notes' => 'Apuntes',

	// P
	'page_bas' => 'página abajo',
	'page_haut' => 'página arriba',
	'pages' => 'P&aacute:ginas',
	'par' => 'Por :',
	'partenaires' => 'Socios',
	'plan_du_site' => 'Mapa del sitio',
	'podcasts' => 'Podcasts',
	'podcasts_rss' => 'Podcast y RSS',
	'post_scriptum' => 'Postdata',
	'pour' => 'para',
	'publie' => 'Publicado :',

	// R
	'rechercher' => 'Buscar',
	'redaction' => 'Redacción',
	'replier' => 'Doblar',
	'resultats' => 'Resultados',

	// S
	'site' => 'sitio',
	'sites' => 'otros sitios :',
	'sites_references' => 'Sitios referenciados',
	'sites_rubrique' => 'Los sitios de la sección',
	'sites_syndic' => 'Sitios sindicados',
	'sous_rubrique' => 'subdivisión de sección',
	'statut_admin' => 'Estatuto : Administrador',
	'statut_redac' => 'Estatuto : Redactor',
	'statut_visit' => 'Estatuto : Visitante',
	'sur_le_web' => 'En la Web',
	'sur_un_total_de' => 'sobre un total de',
	'syndic_breves' => 'Sindicar las noticias breves del sitio',
	'syndic_site' => 'Sindicar todo el contenido del sitio',

	// T
	'texte_page_404' => '<em> ¡ l&aacutestima !</em><br />La página que Usted trata de leer ya no existe.',
	'tous_droits' => 'Todos derechos reservados',
	'tous_les_auteurs' => 'Todos los autores',

	// V
	'version_eva' => 'EVA-Web 4.1',
	'visites' => 'Visitas',
	'voir_en_ligne' => 'Ver en línea :',
	'voir_image' => 'Ver la imagen en modo normal',
	'vous_etes_ici' => 'Usted está aquí :',

	// Z
	'zone' => 'zona protegida'
);

$langue_fichier_initial=$test_lang_personnalisation;
$test=sql_showtable('spip_eva_habillage_images',true);
if ($test['field']) {
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
        "type = 'fichier_lang'",
        "nom_habillage = 'Defaut'",
	"attach = 'es'",
        "nom_image != ''"));
foreach ($surcharges as $s) {
        if (isset($test_lang_personnalisation[$s['cle']])) {
                $test_lang_personnalisation[$s['cle']] = $s['texte'];
        }
}
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>