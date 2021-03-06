<?php

/***************************************************************************\
 *                                                                         *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/config');
include_spip('inc/presentation');
include_spip('inc/layer');
include_spip('inc/meta');
include_spip('inc/config');
include_spip('inc/blip_actions');

function exec_blip_contenu() {
	global $connect_statut;
	global $connect_toutes_rubriques;
	global $spip_lang_right;
	global $options, $changer_config, $spip_display;
	global $liste_meta_navigation;
	$surligne = "";
  
	if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
		debut_page(_T('blipconfig:blip_config'), "administration", "BLiP");
		echo _T('avis_non_acces_page');
		fin_page();
		exit;
	}
	
	$liste_meta_navigation = array(			
		'blip_accueil',
		'blip_sommaire',
		'blip_sommaire_afficher',
		'blip_sommaire_articles',
		'blip_sommaire_commentaires',
		'blip_sommaire_documents',
		'blip_rubriques',
		'blip_articles',
		'blip_articles_trier',
		'blip_articles_datepub',
		'blip_articles_datemaj',
		'blip_articles_popularite',
		'blip_articles_visiteurs',
		'blip_mots',
		'blip_mots_afficher',
		'blip_mots_theme',
		'blip_mots_popularite',
		'blip_mots_alphabetique',
		'blip_auteur',
		'blip_rechercher',
		'blip_espaceprive',
		'blip_switch'
	);
	
	if ($changer_config == 'oui') {
		ecrire_meta("blip_prefixe", $_POST['blip_prefixe']);
		ecrire_meta("blip_couleur", $_POST['blip_couleur']);
		ecrire_metas();
		foreach($liste_meta_navigation as $i)
			if ($_POST[$i]!=NULL)
				ecrire_meta($i, $_POST[$i]);		
		ecrire_metas();	
	}
	
	lire_metas();
	
	
	
	debut_page(_T('blipconfig:blip_config'), "administration", "BLiP");
	echo "<br/>";
	
	gros_titre(_T('blipconfig:blip_config'));
	
	if (BliP_verifier_base())
	{
        barre_onglets("blip", "options");
    }
	
	debut_gauche();
	
	debut_boite_info();
	echo _T('blipconfig:blip_fonctions_info');
	fin_boite_info();
	
	debut_raccourcis();
	echo _T('blipconfig:blip_raccourcis_documentation');
	fin_raccourcis();

	debut_droite();

	//
	// Modifications
	//	
	
	echo generer_url_post_ecrire('blip_contenu');
	echo "<input type='hidden' name='changer_config' value='oui'>";
	
	debut_cadre_couleur();

	debut_cadre_relief("", false, "", _T('blipconfig:blip_couleur_du_site'));
	$blip_couleur = entites_html($GLOBALS['meta']["blip_couleur"]);
	echo "<input type='text' name='blip_couleur' value=\"$blip_couleur\" size='40' CLASS='forml'>";
	echo "<div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";
	echo "Saisir un num&eacute;ro entre 1 et 10.";
	fin_cadre_relief();	
	
	debut_cadre_relief("", false, "", _T('blipconfig:blip_theme_graphique'));
	$blip_prefixe = entites_html($GLOBALS['meta']["blip_prefixe"]);
	echo "<input type='text' name='blip_prefixe' value=\"$blip_prefixe\" size='40' CLASS='forml'>";
	echo "<div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";
	echo "<br />";
	echo "Dans votre dossier 'blip' vous trouverez des fichiers theme_XXXX.php. Saisir : XXXX";
	fin_cadre_relief();

	fin_cadre_couleur();	

	
	
	debut_cadre_trait_couleur("mot-cle-24.gif", false, "", _T('blipconfig:blip_options'));

	//
	// Activer ou d�sactiver les �l�ments du menu.
	//

	debut_cadre_relief("", false, "", _T('blipconfig:blip_menu_navigation'));

	echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=3 WIDTH=\"100%\">";
	echo "<TR><TD BACKGROUND='" . _DIR_IMG_PACK . "rien.gif' COLSPAN='2' class='verdana2'>";
	echo _T('blipconfig:blip_menu_navigation_aide');
	echo "</TD></TR>";

	// J'ai modifi� le formulaire ci-dessous et cela ne marche plus, les autres continues de marcher ... Je ne sais pas pourquoi.
	// Normalement, ces formulaires me permettent d'activer ou d�sactiver par oui - non les valeurs des metas, definies par BliP_installer_blip_meta
	
	foreach($liste_meta_navigation as $i)
		{
			echo "<TR>";
			echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
			echo _T('blipconfig:'.$i);
			echo "</TD>";
			echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
			afficher_choix($i, $GLOBALS['meta'][$i],
				array('oui' => _T('item_oui'), 'non' => _T('item_non')), " &nbsp; ");
			echo "</TD></TR>\n";		
		}	

	echo "<TR><TD style='text-align: $spip_lang_right;' COLSPAN=2>";
	echo "<INPUT TYPE='submit' NAME='Valider' VALUE='"._T('bouton_valider')."' CLASS='fondo'>";
	echo "</TD></TR>";
	echo "</TABLE>";

	fin_cadre_relief();

	fin_cadre_trait_couleur();
	
	echo "</form>";
	
	
	
 
	echo fin_page();

}
?>
