<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilis&eacute; dans les squelettes

$test_lang_personnalisation=array(
// A <:form_pet_message_commentaire:>
'accueil' => 'P&aacute;gina inicial',
'acces_restreint' => 'Acesso restrito',
'agenda' => 'Agenda',
'aide' => 'Ajuda',
'articles' => 'Artigos',
'article_complet' => 'Artigo completo',
'aucun_resultat_pour' => 'Nenhum resultado para',
'article_precedent' => 'Anterior',
'article_precedent_premier' => 'Primeiro',
'article_suivant' => 'Seguinte',
'article_suivant_dernier' => '&Uacute;ltimo',
'aucun_evenement' => 'N&atil;o h&aacute; nenhum evento previsto para este m&ecirc;s na agenda',

// B
'breves' => 'Breves',
'breves_rubrique' => 'Breves da rubrica',

// C
'contact' => 'Contacto',
'copyright_spip' => 'S&iacute;tio desenvolvido com',
'copyright_eva' => 'e utiliza o esqueleto',

// D
'doc_redacteurs' => 'Documenta&ccedil;&atil;o em linha para os autores que usam EVA-Red',
'documents_joints' => 'Documentos juntos',
'document' => 'Documento',
'deconnecter' => 'Desligar-se',
'derniers_articles' => '&Uacute;ltimos artigos',
'dernieres_breves' => '&Uacute;ltimas breves',
'derniers_commentaires' => '&Uacute;ltimos coment&aacute;rios',
'derniers_podcasts' => '&Uacute;ltimos podcasts',
'derniers_sites' => '&Uacute;ltimos s&iacute;tios',
'de_cet_auteur' => 'deste autor',
'derniere_mise_a_jour' => '&Uacute;ltima actualiza&ccedil;&atil;o',
'diaporama' => 'Diaporama',
'dix_meilleurs_articles' => 'Dez melhores artigos',
'dix_meilleurs_commentaires' => 'Dez melhores coment&aacute;rios',
'dix_meilleurs_breves' => 'Dez melhores breves',

// E
'erreur_404' => 'Erro 404',
'evenements_du' => 'Eventos do',
'evenements_a_venir' => 'Pr&oacute;ximos eventos',
'evenement_aucun' => 'N&atil;o h&aacute; nenhum evento previsto para este m&ecirc;s na agenda',
'evenements_passes' => 'Eventos passados',
'evenements_passes_aucun' => 'N&atil;o h&aacute; nenhum evento passado na agenda',

// F
'fermer_fenetre' => 'Fechar a janela',
'form_pet_message_commentaire' => 'Algum coment&aacute;rio?',
'feuilleter_livre' => 'folhear o livro',

// G
'go' => 'ir',
'galaxie_spip' => 'A gal&aacute;xia SPIP',

// H

// I
'identifier' => 'Voc√™ j&aacute; est&aacute; autentificado',
'il_y_a' => 'H&aacute;',
'il_y_a1' => 'assinatura(s) para esta peti&ccedil;&atil;o',
'il_y_a2' => 'H&aacute; na totalidade',
'il_y_a3' => 'artigo(s).<br /> Este bloco em cartaz',
'il_y_a4' => 'autor(es).<br /> Este bloco em cartaz',
'il_y_a5' => 'Not&iacute;cia(s) curtas.<br /> Este bloco em cartaz',

// J
'j1' => 'seg',
'j2' => 'ter',
'j3' => 'qua',
'j4' => 'qui',
'j5' => 'sext',
'j6' => 's&aacute;b',
'j7' => 'dom',
'jo1' => 'Segunda-feira',
'jo2' => 'Ter&ccedil;a-feira',
'jo3' => 'Quarta-feira',
'jo4' => 'Quinta-feira',
'jo5' => 'Sexta-feira',
'jo6' => 'S&aacute;bado',
'jo7' => 'Domingo',

// L
'lire_suite' => 'Ler mais',
'lancer_diaporama' => 'Abrir o diaporama',
'lien_externe'=>"Hiperliga&ccedil;&atil;o externa ao s&iacute;tio, abre em nova janela",

// M
'meme_rubrique' => 'Nesta rubrica',
'mot_cle' => 'Palavras-chaves',
'mis_a_jour' => 'Actualiza&ccedil;&atil;o :',
'mentions' => 'Men&ccedil;&otil;es',
'mentions_legales' => 'Men&ccedil;&otil;es legais',
'm1' => 'janeiro',
'm2' => 'fevereiro',
'm3' => 'mar&ccedil;o',
'm4' => 'abril',
'm5' => 'maio',
'm6' => 'junho',
'm7' => 'julho',
'm8' => 'agosto',
'm9' => 'setembro',
'm10' => 'outubro',
'm11' => 'novembro',
'm12' => 'dezembro',

// N
'notes' => 'Notas',

// P
'plan_du_site' => 'Mapa do s&iacute;tio',
'post_scriptum' => 'Post-scriptum',
'par' => 'Por:',
'publie' => 'Publicado:',
'pour' => 'para',
'pages' => 'P&aacute;ginas',
'partenaires' => 'Parceiros',
'podcasts' =>'Podcasts',
'podcasts_rss' => 'Podcast e RSS',

// R
'redaction' => 'Redac&ccedil;&atil;o',
'rechercher' => 'Pesquisar',
'resultats' => 'Resultados',
'replier' => 'Dobrar',

// S
'sites' => 'outros s&iacute;tios:',
'sites_references' => 'S&iacute;tios referenciados',
'sites_rubrique' => 'S&iacute;tios da rubrica',
'sites_syndic' => 'S&iacute;tios sindicados',
'sur_le_web' => 'Liga&ccedil;&otil;es &uacute;teis',
'sur_un_total_de' => 'sobre um total de',
'sous_rubrique' => 'sub-rubrica',
'statut_admin' => 'Estatuto: Administrador',
'statut_redac' => 'Estatuto: Autor',
'statut_visit' => 'Estatuto: Visitante',

// T
'texte_page_404' => '<em> Desculpe!</em><br />A p&aacute;gina que procura n&atil;o foi encontrada. ',
'tous_les_auteurs' => 'Todos os autores',
'tous_droits' => 'Todos os direitos reservados',

// V
'version_eva' => 'EVA-Web 4.0 est&aacute;vel',
'visites' => 'Visitas',
'voir_en_ligne' => 'Ver em linha:',
'voir_image' => 'Ver a imagem ampliada',
'vous_etes_ici' => 'Voc√™ encontra-se aqui:',

//Z

'zone' => 'zona protegida',
);

$langue_fichier_initial=$test_lang_personnalisation;
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
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>