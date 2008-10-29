<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilisé dans les squelettes

$test_lang_personnalisation=array(
// A <:form_pet_message_commentaire:>
'accueil' => 'Accueil',
'acces_restreint' => 'Acc&egrave;s restreint',
'agenda' => 'Agenda',
'aide' => 'Aide',
'articles' => 'Articles',
'article_complet' => 'Article complet',
'aucun_resultat_pour' => 'Aucun r&eacute;sultat pour',
'article_precedent' => 'Pr&eacute;c&eacute;dent',
'article_precedent_premier' => 'Premier',
'article_suivant' => 'Suivant',
'article_suivant_dernier' => 'Dernier',
'aucun_evenement' => 'Il n\'y a aucun &eacute;v&egrave;nement &agrave; venir pour ce mois dans l\'agenda',

// B
'breves' => 'Br&egrave;ves',
'breves_rubrique' => 'Br&egrave;ves de la rubrique',

// C
'contact' => 'Contact',
'copyright_spip' => 'Ce site est g&eacute;r&eacute; sous',
'copyright_eva' => 'et utilise le squelette ',

// D
'doc_redacteurs' => 'Documentation en ligne pour les r&eacute;dacteurs pour EVA-Web',
'documents_joints' => 'Documents joints',
'document' => 'Document',
'deconnecter' => 'Se d&eacute;connecter',
'derniers_articles' => 'Derniers articles',
'dernieres_breves' => 'Derni&egrave;res br&egrave;ves',
'derniers_podcasts' => 'Derniers podcasts',
'derniers_sites' => 'Derniers sites',
'de_cet_auteur' => 'de cet auteur',
'derniere_mise_a_jour' => 'Derni&egrave;re mise &agrave; jour',
'diaporama' => 'Diaporama',

// E
'erreur_404' => 'Erreur 404',
'evenements_du' => 'Les &eacute;v&egrave;nements du',
'evenements_a_venir' => 'Ev&egrave;nements &agrave; venir',
'evenement_aucun' => 'Il n\'y a aucun &eacute;v&egrave;nement &agrave; venir dans cet agenda.',
'evenements_passes' => 'Ev&egrave;nements pass&eacute;s',
'evenements_passes_aucun' => 'Il n\'y a aucun &eacute;v&egrave;nement pass&eacute; dans cet agenda.',

// F
'fermer_fenetre' => 'Fermer la fen&ecirc;tre',
'form_pet_message_commentaire' => 'Un commentaire&nbsp;?',
'feuilleter_livre' => 'Feuilleter le livre',

// G
'go' => 'go',

// H

// I
'identifier' => 'Vous &ecirc;tes authentifi&eacute;',
'il_y_a' => 'Il y a',
'il_y_a1' => 'signature(s) &agrave; cette p&eacute;tition.',
'il_y_a2' => 'Il y a au total',
'il_y_a3' => 'article(s).<br /> Ce bloc en affiche',
'il_y_a4' => 'auteur(s).<br /> Ce bloc en affiche',
'il_y_a5' => 'br&egrave;ve(s).<br /> Ce bloc en affiche',

// J
'j1' => 'lu',
'j2' => 'ma',
'j3' => 'me',
'j4' => 'je',
'j5' => 've',
'j6' => 'sa',
'j7' => 'di',
'jo1' => 'Lundi',
'jo2' => 'Mardi',
'jo3' => 'Mercredi',
'jo4' => 'Jeudi',
'jo5' => 'Vendredi',
'jo6' => 'Samedi',
'jo7' => 'Dimanche',

// L
'lire_suite' => 'Lire la suite',
'lancer_diaporama' => 'Lancer le Diaporama',

// M
'meme_rubrique' => 'Dans cette rubrique',
'mot_cle' => 'Mots-cl&eacute;',
'mis_a_jour' => 'Modifi&eacute; :',
'mentions' => 'Mentions',
'mentions_legales' => 'Mentions l&eacute;gales',
'm1' => 'janvier',
'm2' => 'f&eacute;vrier',
'm3' => 'mars',
'm4' => 'avril',
'm5' => 'mai',
'm6' => 'juin',
'm7' => 'juillet',
'm8' => 'ao&ucirc;t',
'm9' => 'septembre',
'm10' => 'octobre',
'm11' => 'novembre',
'm12' => 'd&eacute;cembre',

// N
'notes' => 'Notes',

// P
'plan_du_site' => 'Plan du site',
'post_scriptum' => 'Post-scriptum',
'par' => 'Par :',
'publie' => 'Publi&eacute; :',
'rechercher' => 'Rechercher',
'resultats' => 'R&eacute;sultats',
'pour' => 'pour',
'pages' => 'Pages',
'partenaires' => 'Partenaires',
'podcasts' =>'Podcasts',
'podcasts_rss' => 'Podcast et RSS',

// R
'redaction' => 'R&eacute;daction',
'rechercher' => 'Rechercher',
'replier' => 'Replier',

// S
'sites' => 'Autres sites :',
'sites_references' => 'Sites r&eacute;f&eacute;renc&eacute;s',
'sites_rubrique' => 'Sites de la rubrique',
'sites_syndic' => 'Sites syndiqu&eacute;s de la rubrique',
'sur_le_web' => 'Sur le web',
'sur_un_total_de' => 'sur un total de',
'sous_rubrique' => 'Sous-rubrique',
'statut_admin' => 'Statut : Administrateur<br />',
'statut_redac' => 'Statut : R&eacute;dacteur',
'statut_visit' => 'Statut : Visiteur',

// T
'texte_page_404' => '<em>D&eacute;sol&eacute; !</em><br />La page que vous demandez n\'existe pas ou plus.',
'tous_les_auteurs' => 'Tous les auteurs',
'tous_droits' => 'Tous droits r&eacute;serv&eacute;s',

// V
'version_eva' => 'EVA-Web 4.0 beta 1',
'visites' => 'Visites',
'voir_en_ligne' => 'Voir en ligne :',
'voir_image' => 'Voir l\'image en grand',
'vous_etes_ici' => 'Vous &ecirc;tes ici :',

//Z

'zone' => 'zone prot&eacute;g&eacute;e',
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