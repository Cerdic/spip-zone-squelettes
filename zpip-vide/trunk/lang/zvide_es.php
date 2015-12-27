<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/zvide?lang_cible=es
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// C
	'configurer_zvide' => 'Cabecera y pie de página', # he traducido en-tête por cabecera, si alguno tiene una idea mejor...

	// D
	'description_bloc_post_contenu' => 'Las noisettes de este bloque serán insertadas en todas las páginas después del bloque  <i>Contenu</i>.',
	'description_bloc_post_extra' => 'Las noisettes de este bloque serán insertadas  en todas las páginas después del bloque <i>Extra</i>.',
	'description_bloc_post_navigation' => 'Las noisettes de este bloque  serán insertadas en todas las páginas después del bloque  <i>Navigation</i>.',
	'description_bloc_pre_contenu' => 'Las noisettes de este bloque  serán insertadas en todas las páginas después del bloque <i>Contenu</i>.',
	'description_bloc_pre_extra' => 'Las noisettes de este bloque  serán insertadas en todas las páginas después del bloque <i>Extra</i>.',
	'description_bloc_pre_navigation' => 'Las noisettes de este bloque  serán insertadas en todas las páginas después del bloque <i>Navigation</i>.',
	'description_page-401' => 'ESta página se muestra cuando un visitante pide à ver una página para la cual no está autorizado.',
	'description_page-404' => 'Esta página se muestra cuando un visitante pide a ver una página que  no existe o que ya no existe.',
	'description_page-agenda' => 'Página destinada a presentar los acontecimientos  / agenda de su Web ',
	'description_page-auteurs' => 'Page optionnelle permettant de lister tous les auteurs du site.', # Página opcional que permite de listar todos los autores del sitio.
	'description_page-forum' => 'Esta ágina es llamada cuando un visitante quiere enviar un mensaje en un foro.',
	'description_page-jour' => 'Página a utilizar en asociación  con un mini-calendario. Y listear los objetos sobre los cuales se aplica el mini-calendario.',
	'description_page-login' => 'Esta página es necesaria para conectarse al espacio privado. Por seguridad, si la noisette  <i>Formulaire d’identification</i> específica a esta página no es insertada en el bloque<i>Contenu</i>, será insertada de oficio.',
	'description_page-mots' => 'Página opcional que permite de listear todas las palabras clave del sitio. ',
	'description_page-plan' => 'Esta página es llamada para mostrar el plan del sitio.',
	'description_page-recherche' => 'Esta página es mostrada cuando una busqueda es efectuada en el sitio. ',
	'description_page-spip_pass' => 'Esta página es mostrada cuando un visitante a olvidado su contraseña y desea cambiarla',
	'description_page_article' => 'Página por defecto para los artículos.',
	'description_page_auteur' => 'Página por defecto para los autores.',
	'description_page_breve' => 'Página por defecto para las breves.',
	'description_page_evenement' => 'Página por defecto para los acontecimientos.',
	'description_page_groupe_mots' => 'Página facultativa para los grupos de palabras clave.',
	'description_page_mot' => 'Página por defecto para las palabras-claves',
	'description_page_rubrique' => 'Página por defecto para las rúbricas.',
	'description_page_site' => 'Página por defecto para los sitios web referenciados.',
	'description_pagedefaut' => 'Los blocs de esta página serán añadidos a todas las páginas del sitio.',

	// E
	'explication_liens_add' => 'Usted puede  insertar aquí  uno o varios vínculos adicionales a poner en el pié de la página. Si usted añade varios vínculos, piense a separarlos con un |. Puede utilizar los atajos spip. Por ejemplo :<code>[Contact->12] | [Mentions légales->art13]</code>


',
	'explication_masquer_connexion' => 'Ocultar los vínculos  que permiten conectarse / desconectarse ?',
	'explication_masquer_logo' => 'Ocultar el logo del sitio ?',
	'explication_masquer_plan' => 'Ocultar el vínculo de acceso al pla del sitio ?l',
	'explication_masquer_rss' => 'Ocultar el vínculo que apunta al flujo RSS del sitio ? ',
	'explication_masquer_slogan' => 'Ocultar el eslogan del sitio web ? ',
	'explication_menu_lang' => 'Esta opción solo afecta los sitios webs multilingüísticos.<br />La opción<em>Defecto</em> reproduce la funcción de Zpip-dist : un formulario de elección de lengua es mostrado en todas las páginas. Cuando una lengua es seleccionada por el usuario, la página es recargada  pasándole un parámetro <code>lang</code>. Este funcionamiento se adapta al funcionamiento de los sitios que utilizan blocs multilingüísticos  (<code><multi></code>) en los objetos editoriales y que tengan definida  la variable global  <code>forcer_lang</code> a <code>true</code>.<br />La opción<em>Páginade inicsolamente</em> mostrará el formulario de selección de lengua unicamente en la página de inicio .<br />La opción<em>volver a la página de inicio</em> mostrará el formulario en todas las páginas, pero la elección de una lengua   implicará  el retorno  a la página de inicio en la lengua elegida.<br />Enfin, la opción <em>Vínculos de traducción</em> corresponde a los  sitios utilizando vínculos de traducción entre artículos.  El formulario de elección de la lengua  solo  será mostrado en las páginas que no correspondan a un objeto editorial (inicio, plan del sitio, etc.). En las páginas de los artículos, el formulario será mostrado si hay traducciones disponibles y apuntará a dichas traducciones.   El funcionamiento  será equivalente en  las páginas de rúbricas si el plugin <em>trad_rub</em> está instalado.',

	// L
	'label_choix_menu_lang_defaut' => 'Defecto',
	'label_choix_menu_lang_liens_trad' => 'vínculos de traducción',
	'label_choix_menu_lang_masquer' => 'Ocultar en todas las páginas',
	'label_choix_menu_lang_retour_sommaire' => 'Volver a la página de  inicio',
	'label_choix_menu_lang_sommaire' => 'Página de inicio  solamente',
	'label_liens_add' => 'Vínculos adicionales',
	'label_masquer_connexion' => 'Vínculo de conexión ',
	'label_masquer_logo' => 'Logo del  sitio',
	'label_masquer_plan' => 'Plan del  sitio',
	'label_masquer_rss' => 'Flujo RSS',
	'label_masquer_slogan' => 'Slogan del sitio',
	'label_menu_lang' => 'Menu de lenguas',
	'label_options_en_tete' => 'Opciones de la cabecera de página',
	'label_options_pied' => 'Opciones del  pie de página',
	'label_taille_logo' => 'Tamaño  máximo del logo en pixels',

	// N
	'nom_bloc_post_contenu' => 'Post-Contenido',
	'nom_bloc_post_extra' => 'Post-Extra',
	'nom_bloc_post_navigation' => 'Post-Navegación',
	'nom_bloc_pre_contenu' => 'Pre-Contenido',
	'nom_bloc_pre_extra' => 'Pre-Extra',
	'nom_bloc_pre_navigation' => 'Pre-Navegación',
	'nom_page-401' => 'Error 401',
	'nom_page-404' => 'Error 404',
	'nom_page-agenda' => 'Agenda',
	'nom_page-auteurs' => 'Autores',
	'nom_page-forum' => 'Foro',
	'nom_page-jour' => 'Día',
	'nom_page-login' => 'Conectarse',
	'nom_page-mots' => 'Palabras-claves',
	'nom_page-plan' => 'Plan del sitio',
	'nom_page-recherche' => 'Buscar en el sitio ',
	'nom_page-sommaire' => 'Página de inico del sitio',
	'nom_page-spip_pass' => 'Contraseña olvidada',
	'nom_page_article' => 'Artículo',
	'nom_page_auteur' => 'Autor',
	'nom_page_breve' => 'Breve',
	'nom_page_evenement' => 'Acontecimiento',
	'nom_page_groupe_mots' => 'Grupo de palabras-clave',
	'nom_page_mot' => 'Palabra-clave',
	'nom_page_rubrique' => 'Rúbrica',
	'nom_page_site' => 'Sitio referenciado',
	'nom_pagedefaut' => 'Página por defecto',

	// Z
	'zvide' => 'Zpip-vide'
);

?>
