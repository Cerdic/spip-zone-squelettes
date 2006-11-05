<?php

/***************************************************************************\
 *                                                                         *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/config');
include_spip('inc/presentation');
include_spip('inc/layer');
include_spip('inc/meta');
include_spip('inc/blip_actions');

function exec_blip_contenu() {
	global $connect_statut;
	global $connect_toutes_rubriques;
	global $spip_lang_right;
	global $options, $changer_config, $spip_display;
	$surligne = "";
  
	if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
		debut_page(_T('blipconfig:blip_config'), "administration", "BLiP");
		echo _T('avis_non_acces_page');
		fin_page();
		exit;
	}
	
	init_config();
	if ($changer_config == 'oui') {
		appliquer_modifs_config();
	}
	else {
		$forums_publics = $GLOBALS['meta']["forums_publics"];
		if (!$forums_publics) {
			ecrire_meta("forums_publics", "posteriori");
			ecrire_metas();
		}
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


	// Je n'arrive pas à faire le scrip qui met à jour... Je crois que mon formulaire n'est pas correct, il manque l'entete qui va bien et le traitement php associé.	
	

	echo generer_url_post_ecrire('blip_contenu');
	echo "<input type='hidden' name='changer_config' value='oui'>";
	
	debut_cadre_couleur("racine-site-24.gif");
		
	debut_cadre_relief("", false, "", bouton_block_invisible('blip_prefixe_style')._T('blipconfig:blip_prefixe_style'));
	$blip_prefixe = entites_html($GLOBALS['meta']["blip_prefixe"]);
		
	echo "<input type='text' name='blip_prefixe' value=\"$blip_prefixe\" size='40' CLASS='forml'>";
	echo "<div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";
	
	echo debut_block_invisible('blip_prefixe_style');
	echo fin_block();
	fin_cadre_relief();
	echo "<br />";			
		
    echo "Prochainement ici, divers formulaires de configuration avancées";
 
	fin_cadre_couleur();	
	
	
	
	
	
	
	debut_cadre_trait_couleur("mot-cle-24.gif", false, "", _T('blipconfig:options'));

	//
	// Activer ou désactiver les élèments du menu.
	//

	debut_cadre_relief("", false, "", _T('blipconfig:menu_parametrage_'));

	$blip_accueil = $GLOBALS['meta']["blip_accueil"];
	$articles_soustitre = $GLOBALS['meta']["articles_soustitre"];
	$articles_descriptif = $GLOBALS['meta']["articles_descriptif"];
	$articles_chapeau = $GLOBALS['meta']["articles_chapeau"];
	$articles_ps = $GLOBALS['meta']["articles_ps"];
	$articles_redac = $GLOBALS['meta']["articles_redac"];
	$articles_urlref = $GLOBALS['meta']["articles_urlref"];

	echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=3 WIDTH=\"100%\">";

	echo "<TR><TD BACKGROUND='" . _DIR_IMG_PACK . "rien.gif' COLSPAN='2' class='verdana2'>";
	echo _T('texte_contenu_articles');
	echo "</TD></TR>";

	// J'ai modifié le formulaire ci-dessous et cela ne marche plus, les autres continues de marcher ... Je ne sais pas pourquoi.
	// Normalement, ces formulaires me permettent d'activer ou désactiver par oui - non les valeurs des metas, definies par BliP_installer_blip_meta
	
	echo "<TR>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	echo _T('blip_accueil');
	echo "</TD>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	afficher_choix('blip_accueil', $blip_accueil,
		array('oui' => _T('item_oui'), 'non' => _T('item_non')), " &nbsp; ");
	echo "</TD></TR>\n";

	// En dessous ça marche, se sont les valeurs de config de spip...
	
	echo "<TR>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	echo _T('info_sous_titre');
	echo "</TD>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	afficher_choix('articles_soustitre', $articles_soustitre,
		array('oui' => _T('item_oui'), 'non' => _T('item_non')), " &nbsp; ");
	echo "</TD></TR>\n";

	echo "<TR>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	echo _T('info_descriptif');
	echo "</TD>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	afficher_choix('articles_descriptif', $articles_descriptif,
		array('oui' => _T('item_oui'), 'non' => _T('item_non')), " &nbsp; ");
	echo "</TD></TR>\n";

	echo "<TR>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	echo _T('info_chapeau_2');
	echo "</TD>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	afficher_choix('articles_chapeau', $articles_chapeau,
		array('oui' => _T('item_oui'), 'non' => _T('item_non')), " &nbsp; ");
	echo "</TD></TR>\n";

	echo "<TR>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	echo _T('info_post_scriptum_2');
	echo "</TD>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	afficher_choix('articles_ps', $articles_ps,
		array('oui' => _T('item_oui'), 'non' => _T('item_non')), " &nbsp; ");
	echo "</TD></TR>\n";

	echo "<TR>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	echo _T('info_date_publication_anterieure');
	echo "</TD>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	afficher_choix('articles_redac', $articles_redac,
		array('oui' => _T('item_oui'), 'non' => _T('item_non')), " &nbsp; ");
	echo "</TD></TR>\n";

	echo "<TR>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	echo _T('info_urlref');
	echo "</TD>";
	echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
	afficher_choix('articles_urlref', $articles_urlref,
		array('oui' => _T('item_oui'), 'non' => _T('item_non')), " &nbsp; ");
	echo "</TD></TR>\n";

	echo "<TR><TD style='text-align: $spip_lang_right;' COLSPAN=2>";
	echo "<INPUT TYPE='submit' NAME='Valider' VALUE='"._T('bouton_valider')."' CLASS='fondo'>";
	echo "</TD></TR>";
	echo "</TABLE>";

	fin_cadre_relief();

	fin_cadre_trait_couleur();
	
 
	fin_page();

}
?>
