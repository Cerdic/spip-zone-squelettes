<?php

//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Copyright (C) 2006  Pierre ANDREWS, modified by jsb
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA


$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(dirname(__FILE__)))));
define('_DIR_PLUGIN_SQUELETTES_SCOLA',(_DIR_PLUGINS.end($p)));

function exec_config_squelettes_scola() {
  global $connect_statut, $connect_toutes_rubriques,$changer_config,$id_parent,$id_rubrique,$id_meslogos;

	include_spip("inc/presentation");
	include_spip("base/abstract_sql");
	include_spip('inc/logos');
	include_spip('inc/rubriques');
	include_spip('inc/documents');
	include_spip('inc/presentation');
	include_spip('inc/rubriques');
	include_spip('inc/logos');
	include_spip('inc/mots');
	include_spip('inc/documents');

	
  debut_page('&laquo; '._T('squelettesscola:titre_page').' &raquo;', 'configurations', 'mots_partout','',_DIR_PLUGIN_SQUELETTES_SCOLA.'/squelettesscola.css');

  if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
	echo _T('avis_non_acces_page');
	exit;
  }

	/* initialisation des meta de scola */
		
	// valider les changements
	
	include_spip('inc/configscola'); // declaration des fonctions propres aux méta de scola
	
	if ($changer_config == 'oui') {	appliquer_modifs_scola(); }

	lire_metas();// lecture des meta scola

	//les meta scola âssage dans des variables
	$scola_base_version=$GLOBALS['meta']['scola_base_version'];
	
	$keywords_scola=$GLOBALS['meta']['keywords_scola'];
	$copyright_scola=$GLOBALS['meta']['copyright_scola'];
	$directeur_scola=$GLOBALS['meta']['directeur_scola'];
	$redacteur_scola=$GLOBALS['meta']['redacteur_scola'];
	$contact_scola=$GLOBALS['meta']['contact_scola'];

	
	$nb_evens_scola=$GLOBALS['meta']['nb_evens_scola'];
	$voir_une_scola=$GLOBALS['meta']['voir_une_scola'];
	$nb_articles_scola=$GLOBALS['meta']['nb_articles_scola'];
	$nb_breves_scola=$GLOBALS['meta']['nb_breves_scola'];
	$nb_sites_scola=$GLOBALS['meta']['nb_sites_scola'];
	$nb_syndic_scola=$GLOBALS['meta']['nb_syndic_scola'];
	$nb_messages_scola=$GLOBALS['meta']['nb_messages_scola'];
	
	// menu programmable
	$voir_menu_scola=$GLOBALS['meta']['voir_menu_scola'];
	$nom_menu1_scola=$GLOBALS['meta']['nom_menu1_scola'];
	$url_menu1_scola=$GLOBALS['meta']['url_menu1_scola'];
	$nom_menu2_scola=$GLOBALS['meta']['nom_menu2_scola'];
	$url_menu2_scola=$GLOBALS['meta']['url_menu2_scola'];
	$nom_menu3_scola=$GLOBALS['meta']['nom_menu3_scola'];
	$url_menu3_scola=$GLOBALS['meta']['url_menu3_scola'];
	$nom_menu4_scola=$GLOBALS['meta']['nom_menu4_scola'];
	$url_menu4_scola=$GLOBALS['meta']['url_menu4_scola'];

	//fonction edito
		
	$activer_edito=$GLOBALS['meta']['activer_edito'];
	$id_edito=$GLOBALS['meta']['id_edito'];
	
	//fonction agenda
		
	$activer_agenda=$GLOBALS['meta']['activer_agenda'];
	$id_agenda=$GLOBALS['meta']['id_agenda'];

	
	// fonction meslogos
	$activer_meslogos=$GLOBALS['meta']['activer_meslogos'];
	$id_meslogos=$GLOBALS['meta']['id_meslogos'];
	
	if ($connect_statut == '0minirezo' AND $connect_toutes_rubriques ) {

	echo '<br><br><br>';

	gros_titre(_T('squelettesscola:gros_titre'));

	barre_onglets("configuration", "config_squelettes_scola");

	/*debut du contenu de la page de configuration*/
	
	/* partie gauche de la page */
	debut_gauche();	
	
	debut_boite_info();
	echo propre(_T('squelettesscola:help'))."<br><br><strong>version de scola SPIP : ".$scola_base_version."</strong>";
	fin_boite_info();
	

	/*partie droite de la page ... la config !*/
	debut_droite();
	
	include_ecrire('inc_config');
	avertissement_config();
	echo '<form action="'.generer_url_ecrire('config_squelettes_scola').'" method="post">';

	// ici on met le code de la page

	echo "<input type='hidden' name='changer_config' value='oui'>";
	
	/* interface de saisie des meta */
	
		debut_cadre_couleur("racine-site-24.gif", false, "", _T('squelettesscola:titre_meta_scola'));
	
		echo _T('squelettesscola:entetes_scola')."<br><br>";

		debut_cadre_relief("", false, "", _T('squelettesscola:keywords_scola'));
			echo "<input type='text' name='keywords_scola' value=\"$keywords_scola\" size='40' CLASS='forml'>";
		fin_cadre_relief();
		
		debut_cadre_relief("", false, "", _T('squelettesscola:copyright_scola'));
			echo "<input type='text' name='copyright_scola' value=\"$copyright_scola\" size='40' CLASS='forml'>";
		fin_cadre_relief();

		echo "<br>"._T('squelettesscola:legal_scola')."<br><br>";
		
		debut_cadre_relief("", false, "", _T('squelettesscola:directeur_scola'));
			echo "<input type='text' name='directeur_scola' value=\"$directeur_scola\" size='40' CLASS='forml'>";
		fin_cadre_relief();
		
		debut_cadre_relief("", false, "", _T('squelettesscola:redacteur_scola'));
			echo "<input type='text' name='redacteur_scola' value=\"$redacteur_scola\" size='40' CLASS='forml'>";
		fin_cadre_relief();

		debut_cadre_relief("", false, "", _T('squelettesscola:contact_scola'));
			echo "<input type='text' name='contact_scola' value=\"$contact_scola\" size='40' CLASS='forml'>";
		fin_cadre_relief();
	
		echo"<br>";

		// *Champs optionnels de la page sommaire
	
		echo _T('squelettesscola:texte_options_sommaire')."<br><br>";
		
		debut_cadre_relief("", false, "", _T('squelettesscola:info_options_sommaire'));
	
	
		echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=3 WIDTH=\"100%\">";
	
		echo "<TR><TD BACKGROUND='" . _DIR_IMG_PACK . "mot-cle-24.gif' COLSPAN='2' class='verdana2'>";
		
		echo "</TD></TR>";
	
			
		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesscola:info_une_scola');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
			echo afficher_choix('voir_une_scola', $voir_une_scola,array('oui' => _T('item_oui'),'non' => _T('item_non')), ' &nbsp; ');
		echo "</TD></TR>\n";

		echo "<TR><TD ALIGN='$spip_lang_left' class='verdana2'></TD><TD ALIGN='$spip_lang_left' class='verdana2'></TD></TR>";

		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesscola:info_agenda_scola');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_evens_scola' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_evens_scola).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_evens_scola).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_evens_scola).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_evens_scola).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_evens_scola).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_evens_scola).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";

		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesscola:info_articles_scola');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_articles_scola' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_articles_scola).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_articles_scola).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_articles_scola).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_articles_scola).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_articles_scola).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_articles_scola).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";

		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesscola:info_breves_scola');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_breves_scola' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_breves_scola).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_breves_scola).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_breves_scola).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_breves_scola).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_breves_scola).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_breves_scola).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";
	
		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesscola:info_sites_scola');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_sites_scola' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_sites_scola).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_sites_scola).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_sites_scola).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_sites_scola).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_sites_scola).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_sites_scola).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";

		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesscola:info_syndic_scola');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_syndic_scola' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_syndic_scola).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_syndic_scola).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_syndic_scola).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_syndic_scola).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_syndic_scola).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_syndic_scola).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";
	
		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesscola:info_messages_scola');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_messages_scola' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_messages_scola).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_messages_scola).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_messages_scola).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_messages_scola).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_messages_scola).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_messages_scola).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";
	
		echo "</TABLE>";
	
		fin_cadre_relief();


	echo "<div style='text-align:right;'><input type='submit' name='Enregistrer' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";

	fin_cadre_couleur();

	/* interface de modification de la CSS */
	
	//debut_cadre_trait_couleur("tout-site.png", false, "", _T('squelettesscola:css_nono'));
	
		//echo "<div style='text-align:right;'><input type='submit' name='Enregistrer' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";
			
	//fin_cadre_trait_couleur();

	
	
	/* interface de saisie des menus Programmables 
	
	debut_cadre_couleur("site-24.gif", false, "", _T('squelettesscola:menus_titre_scola'));
		
		echo _T('squelettesscola:menus_texte_scola')."<br><br>";
		
		echo bouton_radio("voir_menu_scola", "oui", _T('squelettesscola:item_utiliser_menu'), $voir_menu_scola == "oui", "changeVisible(this.checked, 'config-menu', 'block', 'none');");
		echo " &nbsp;";
		echo bouton_radio("voir_menu_scola", "non", _T('squelettesscola:item_non_utiliser_menu'), $voir_menu_scola == "non", "changeVisible(this.checked, 'config-menu', 'none', 'block');");
		
		echo "<br><br>";
		// affichage optionnel	
		if ($voir_menu_scola != 'non') $style = "display: block;";
		else $style = "display: none;";
		
		echo "<div id='config-menu' style='$style'>";
		
		debut_cadre_relief("", false, "", _T('squelettesscola:menu1_scola'));
			echo _T('squelettesscola:menu1_info_titre_scola')," ";
			echo "<input type='text' name='nom_menu1_scola' class='forml' width='40' value=\"$nom_menu1_scola\"/><br />\n";
			echo _T('squelettesscola:menu1_info_url_scola')," ";
			echo "<input type='text' name='url_menu1_scola' class='forml' width='40' value=\"$url_menu1_scola\"/>";
		fin_cadre_relief();
		
		debut_cadre_relief("", false, "", _T('squelettesscola:menu2_scola'));
			echo _T('squelettesscola:menu2_info_titre_scola')," ";
			echo "<input type='text' name='nom_menu2_scola' class='forml' width='40' value=\"$nom_menu2_scola\"/><br />\n";
			echo _T('squelettesscola:menu2_info_url_scola')," ";
			echo "<input type='text' name='url_menu2_scola' class='forml' width='40' value=\"$url_menu2_scola\"/>";
		fin_cadre_relief();

		debut_cadre_relief("", false, "", _T('squelettesscola:menu3_scola'));
			echo _T('squelettesscola:menu3_info_titre_scola')," ";
			echo "<input type='text' name='nom_menu3_scola' class='forml' width='40' value=\"$nom_menu3_scola\"/><br />\n";
			echo _T('squelettesscola:menu3_info_url_scola')," ";
			echo "<input type='text' name='url_menu3_scola' class='forml' width='40' value=\"$url_menu3_scola\"/>";
		fin_cadre_relief();

		debut_cadre_relief("", false, "", _T('squelettesscola:menu4_scola'));
			echo _T('squelettesscola:menu4_info_titre_scola')," ";
			echo "<input type='text' name='nom_menu4_scola' class='forml' width='40' value=\"$nom_menu4_scola\"/><br />\n";
			echo _T('squelettesscola:menu4_info_url_scola')," ";
			echo "<input type='text' name='url_menu4_scola' class='forml' width='40' value=\"$url_menu4_scola\"/>";
		fin_cadre_relief();

		debut_cadre_relief("", false, "", _T('squelettesscola:menu5_scola'));
			echo _T('squelettesscola:menu5_info_titre_scola')," ";
			echo "<input type='text' name='nom_menu5_scola' class='forml' width='40' value=\"$nom_menu5_scola\"/><br />\n";
			echo _T('squelettesscola:menu5_info_url_scola')," ";
			echo "<input type='text' name='url_menu5_scola' class='forml' width='40' value=\"$url_menu5_scola\"/>";
		fin_cadre_relief();

		echo "</div>"; //fin affichage conditionnel
				
		echo "<div style='text-align:right;'><input type='submit' name='Enregistrer' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";
			
	fin_cadre_couleur();

	*/
	
	/* interface d'activation de l'edito */

		debut_cadre_trait_couleur("rubrique-24.gif", false, "", _T('squelettesscola:titre_edito'));
		
		echo _T('squelettesscola:texte_edito')."<br><br>";
		
		echo bouton_radio("activer_edito", "oui", _T('squelettesscola:item_utiliser_edito'), $activer_edito == "oui", "changeVisible(this.checked, 'config-edito', 'block', 'none');");
		echo " &nbsp;";
		echo bouton_radio("activer_edito", "non", _T('squelettesscola:item_non_utiliser_edito'), $activer_edito == "non", "changeVisible(this.checked, 'config-edito', 'none', 'block');");
		
		echo "<br><br>";
		
		// affichage optionnel	
		if ($activer_edito != 'non') $style = "display: block;";
		else $style = "display: none;";
		
		echo "<div id='config-edito' style='$style'>";
		
		// Choix de la rubrique
		$selecteur_rubrique = charger_fonction('chercher_rubrique', 'inc');

		echo _T('squelettesscola:info_edito')."<br/><br/>";

		echo $selecteur_rubrique($id_edito, 'rubrique', ($GLOBALS['statut'] == 'publie'));

		echo "</div>";
		
		echo "<div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_valider')."' CLASS='fondo'></div>";

	
	fin_cadre_trait_couleur();
	
		/* interface d'activation de l'agenda */

		debut_cadre_trait_couleur("rubrique-24.gif", false, "", _T('squelettesscola:titre_agenda'));
		
		echo _T('squelettesscola:texte_agenda')."<br><br>";
		
		echo bouton_radio("activer_agenda", "oui", _T('squelettesscola:item_utiliser_agenda'), $activer_agenda == "oui", "changeVisible(this.checked, 'config-agenda', 'block', 'none');");
		echo " &nbsp;";
		echo bouton_radio("activer_agenda", "non", _T('squelettesscola:item_non_utiliser_agenda'), $activer_agenda == "non", "changeVisible(this.checked, 'config-agenda', 'none', 'block');");
		
		echo "<br><br>";
		
		// affichage optionnel	
		if ($activer_agenda != 'non') $style = "display: block;";
		else $style = "display: none;";
		
		echo "<div id='config-agenda' style='$style'>";
		
		// Choix de la rubrique
		
		echo _T('squelettesscola:info_agenda')."<br/><br/>";
		
		$selecteur_rubrique = charger_fonction('chercher_rubrique', 'inc');

		echo $selecteur_rubrique($id_agenda, 'rubrique', ($GLOBALS['statut'] == 'publie'));

		echo "</div>";
		
		echo "<div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_valider')."' CLASS='fondo'></div>";

	
	fin_cadre_trait_couleur();


	/* interface d'activation de la fonction meslogos 
	
	debut_cadre_trait_couleur("groupe-mot-24.gif", false, "", _T('squelettesscola:titre_meslogos'));

	
	echo _T('squelettesscola:texte_meslogos')."<br><br>";
	
	echo bouton_radio("activer_meslogos", "oui", _T('squelettesscola:item_utiliser_meslogos'), $activer_meslogos == "oui", "changeVisible(this.checked, 'config-meslogos', 'block', 'none');");
	echo " &nbsp;";
	echo bouton_radio("activer_meslogos", "non", _T('squelettesscola:item_non_utiliser_meslogos'), $activer_meslogos == "non", "changeVisible(this.checked, 'config-meslogos', 'none', 'block');");

	
	// affichage optionnel	
	if ($activer_meslogos != 'non') $style = "display: block;";
	else $style = "display: none;";
	
	echo "<div id='config-meslogos' style='$style'>";
	
	// Choix du groupe de mots clés affecté

	echo selecteur_groupe_html($id_meslogos);
	
	echo "</div>";
	
	echo "<br><div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_valider')."' CLASS='fondo'></div>";

	echo "</form>";
	
	fin_cadre_trait_couleur();

*/

  } 
  
  echo "</form>";
  
  fin_page();
  
}

?>