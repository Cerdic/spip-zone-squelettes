<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilis&eacute; dans les squelettes

$test_lang_personnalisation=array(
// A
	'acces_restreint' => 'Acesso restrito',
	'accueil' => 'Página inicial',
	'agenda' => 'Agenda',
	'aide' => 'Ajuda',
	'article_complet' => 'Artigo completo',
	'article_precedent' => 'Anterior',
	'article_precedent_premier' => 'Primeiro',
	'article_suivant' => 'Seguinte',
	'article_suivant_dernier' => 'Último',
	'articles' => 'Artigos',
	'aucun_evenement' => 'N&amp;atilde;o há nenhum evento previsto para este mês na agenda',
	'aucun_resultat_pour' => 'Nenhum resultado para',

	// B
	'breves' => 'Breves',
	'breves_rubrique' => 'Breves da rubrica',

	// C
	'contact' => 'Contacto',
	'copyright_eva' => 'e utiliza o esqueleto',
	'copyright_spip' => 'Sítio desenvolvido com',

	// D
	'de_cet_auteur' => 'deste autor',
	'deconnecter' => 'Desligar-se',
	'derniere_mise_a_jour' => 'Última actualiza&amp;ccedil;&amp;atilde;o',
	'dernieres_breves' => 'Últimas breves',
	'derniers_articles' => 'Últimos artigos',
	'derniers_commentaires' => 'Últimos comentários',
	'derniers_podcasts' => 'Últimos podcasts',
	'derniers_sites' => 'Últimos sítios',
	'diaporama' => 'Diaporama',
	'dix_meilleurs_articles' => 'Dez melhores artigos',
	'dix_meilleurs_breves' => 'Dez melhores breves',
	'dix_meilleurs_commentaires' => 'Dez melhores comentários',
	'doc_redacteurs' => 'Documenta&amp;ccedil;&amp;atilde;o em linha para os autores que usam EVA-Red',
	'document' => 'Documento',
	'documents_joints' => 'Documentos juntos',

	// E
	'erreur_404' => 'Erro 404',
	'evenement_aucun' => 'N&amp;atilde;o há nenhum evento previsto para este mês na agenda',
	'evenements_a_venir' => 'Próximos eventos',
	'evenements_du' => 'Eventos do',
	'evenements_passes' => 'Eventos passados',
	'evenements_passes_aucun' => 'N&amp;atilde;o há nenhum evento passado na agenda',

	// F
	'fermer_fenetre' => 'Fechar a janela',
	'feuilleter_livre' => 'folhear o livro',
	'form_pet_message_commentaire' => 'Algum comentário?',

	// G
	'galaxie_spip' => 'A galáxia SPIP',
	'go' => 'ir',

	// I
	'icone_eva' => 'Icone EVA-web 4', # NEW
	'identifier' => 'Voc?™ j&aacute; est&aacute; autentificado',
	'il_y_a' => 'Há',
	'il_y_a1' => 'assinatura(s) para esta peti&amp;ccedil;&amp;atilde;o',
	'il_y_a2' => 'Há na totalidade',
	'il_y_a3' => 'artigo(s).<br /> Este bloco em cartaz',
	'il_y_a4' => 'autor(es).<br /> Este bloco em cartaz',
	'il_y_a5' => 'Notícia(s) curtas.<br /> Este bloco em cartaz',
	'inscription' => 'Inscription', # NEW

	// J
	'j1' => 'seg',
	'j2' => 'ter',
	'j3' => 'qua',
	'j4' => 'qui',
	'j5' => 'sext',
	'j6' => 'sáb',
	'j7' => 'dom',
	'jo1' => 'Segunda-feira',
	'jo2' => 'Ter&amp;ccedil;a-feira',
	'jo3' => 'Quarta-feira',
	'jo4' => 'Quinta-feira',
	'jo5' => 'Sexta-feira',
	'jo6' => 'Sábado',
	'jo7' => 'Domingo',

	// L
	'lancer_diaporama' => 'Abrir o diaporama',
	'lien_externe' => 'Hiperliga&amp;ccedil;&amp;atilde;o externa ao sítio, abre em nova janela',
	'lire_suite' => 'Ler mais',

	// M
	'm1' => 'janeiro',
	'm10' => 'outubro',
	'm11' => 'novembro',
	'm12' => 'dezembro',
	'm2' => 'fevereiro',
	'm3' => 'mar&amp;ccedil;o',
	'm4' => 'abril',
	'm5' => 'maio',
	'm6' => 'junho',
	'm7' => 'julho',
	'm8' => 'agosto',
	'm9' => 'setembro',
	'meme_rubrique' => 'Nesta rubrica',
	'mentions' => 'Men&amp;ccedil;&amp;otilde;es',
	'mentions_adresse' => 'Adresse :', # NEW
	'mentions_directeur_publication' => 'Directeur de la publication :', # NEW
	'mentions_droit_auteur_texte' => '<p>Ce site relève de la législation française et internationale sur le droit d\'auteur et la propriété intellectuelle.</p>
	<p>Tous les droits de reproduction sont réservés.</p>', # NEW
	'mentions_droit_auteur_titre' => 'Droits d\'auteurs :', # NEW
	'mentions_legales' => 'Men&amp;ccedil;&amp;otilde;es legais',
	'mentions_liens_hypertexte_texte' => '<p>Ce site contient des liens hypertextes permettant l\'accès à des sites qui ne sont pas édités par le responsable de ce site.</p>
	<p>En conséquence le directeur de publication ne saurait être tenu pour responsable du contenu des sites auxquels l\'internaute aurait ainsi accès.</p>
	<p>Il est formellement interdit de collecter et d\'utiliser les informations disponibles sur le site à des fins commerciales.</p>
	<p>Cette interdiction s\'étend notamment, sans que cette liste ne soit limitative, à tout élément rédactionnel figurant sur le site, à la présentation des écrans, aux logiciels nécessaires à l\'exploitation, aux logos, images, photos, graphiques, de quelque nature qu\'ils soient.</p>', # NEW
	'mentions_liens_hypertexte_titre' => 'Liens hypertextes :', # NEW
	'mentions_liens_texte' => '<p>A l\'exception de sites diffusant des informations et/ou contenus ayant un caractère illégal et/ou à caractère politique, religieux, pornographique, xénophobe, vous pouvez créer un lien hypertexte vers notre Site sur votre site.</p>
	<p>La mise en place de lien hypertexte n\'autorise en aucune façon la reproduction d\'éléments du Site ou la présentation sur des sites tiers d\'éléments du Site sous forme de Frame ou système apparenté.</p>
	<p>Enfin, la mise en place de lien hypertexte n\'autorise en aucune façon de proposer l\'envoi d\'un message pré-rédigé à une adresse mail liée au Site ou la mise en place d\'un système permettant l\'envoi massif de messages quelle qu\'en soit la nature.</p>
	<p>Tous les droits de reproduction sont réservés.</p>', # NEW
	'mentions_liens_titre' => 'Liens hypertextes vers ce site :', # NEW
	'mentions_logo_cddp74' => 'Site officiel du CDDP74', # NEW
	'mentions_logo_citic' => 'Centre de l\'Informatique et des TIC de Haute-Savoie (ex CRI74)', # NEW
	'mentions_logo_edres' => 'Éducation Réseau Haute-Savoie, projet départemental', # NEW
	'mentions_logo_eva' => 'Site officiel du projet eva-web', # NEW
	'mentions_logo_spip' => 'Site officiel de SPIP', # NEW
	'mentions_logo_spipedu' => 'Spip-edu, site de la communauté éducative', # NEW
	'mentions_lois' => 'En vertu de la loi pour la confiance dans l\'économie numérique (LCEN) du 21 juin 2004, voici les coordonnées de l\'éditeur et du prestataire qui accueille le site :', # NEW
	'mentions_prestataire' => 'Prestataire assurant le stockage direct et permanent :', # NEW
	'mentions_qualite' => 'Qualité :', # NEW
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
	'mentions_qui_titre' => 'EVA, par qui, pour qui ?', # NEW
	'mentions_responsable_edition' => 'Responsable d\'édition :', # NEW
	'mentions_site' => 'Site Internet de : ', # NEW
	'mentions_webmestre' => 'Webmestre :', # NEW
	'meteo' => 'Météo', # NEW
	'meteo_info' => 'Informations géographiques', # NEW
	'meteo_previsions' => 'Prévisions météo', # NEW
	'mis_a_jour' => 'Actualiza&amp;ccedil;&amp;atilde;o :',
	'mot_cle' => 'Palavras-chaves',
	'multilinguisme' => 'Afixar a ementa de língua EVA-web nas páginas públicas?',
	'multilinguisme_article' => 'Este artigo:',

	// N
	'notes' => 'Notas',

	// P
	'page_bas' => 'Bas de page', # NEW
	'page_haut' => 'Haut de page', # NEW
	'pages' => 'Páginas',
	'par' => 'Por:',
	'partenaires' => 'Parceiros',
	'plan_du_site' => 'Mapa do sítio',
	'podcasts' => 'Podcasts',
	'podcasts_rss' => 'Podcast e RSS',
	'post_scriptum' => 'Post-scriptum',
	'pour' => 'para',
	'publie' => 'Publicado:',

	// R
	'rechercher' => 'Pesquisar',
	'redaction' => 'Reda&amp;ccedil;&amp;atilde;o',
	'replier' => 'Dobrar',
	'resultats' => 'Resultados',

	// S
	'site' => 'site', # NEW
	'sites' => 'outros sítios:',
	'sites_references' => 'Sítios referenciados',
	'sites_rubrique' => 'Sítios da rubrica',
	'sites_syndic' => 'Sítios sindicados',
	'sous_rubrique' => 'sub-rubrica',
	'statut_admin' => 'Estatuto: Administrador',
	'statut_redac' => 'Estatuto: Autor',
	'statut_visit' => 'Estatuto: Visitante',
	'sur_le_web' => 'Liga&amp;ccedil;&amp;otilde;es úteis',
	'sur_un_total_de' => 'sobre um total de',
	'syndic_breves' => 'Syndiquer les brèves du site', # NEW
	'syndic_site' => 'Syndiquer tout le site', # NEW

	// T
	'texte_page_404' => 'Desculpe!</em><br />A página que procura n&amp;atilde;o foi encontrada. ', # em
	'tous_droits' => 'Todos os direitos reservados',
	'tous_les_auteurs' => 'Todos os autores',

	// V
	'version_eva' => 'EVA-Web 4.2',
	'visites' => 'Visitas',
	'voir_en_ligne' => 'Ver em linha:',
	'voir_image' => 'Ver a imagem ampliada',
	'vous_etes_ici' => 'Voc&amp;ecirc; encontra-se aqui:',

	// Z
	'zone' => 'zona protegida'
);

$langue_fichier_initial=$test_lang_personnalisation;
$test=sql_showtable('spip_eva_habillage_images',true);
if ($test['field']) {
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
		"type = 'fichier_lang'",
		"nom_habillage = 'Defaut'",
		"attach = 'pt'",
		"nom_image != ''"));
	foreach ($surcharges as $s) {
		if (isset($test_lang_personnalisation[$s['cle']])) {
			$test_lang_personnalisation[$s['cle']] = $s['texte'];
		}
	}
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>