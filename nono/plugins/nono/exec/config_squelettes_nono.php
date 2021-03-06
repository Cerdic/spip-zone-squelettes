<?php

//    Fichier cr�� pour SPIP avec un bout de code emprunt� � celui ci.
//    Distribu� sans garantie sous licence GPL./
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


define('_DIR_PLUGIN_SQUELETTES_NONO',(_DIR_PLUGINS.end(explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__).'/..'))))));

function exec_config_squelettes_nono() {
  global $connect_statut, $connect_toutes_rubriques,$changer_config,$id_parent,$id_rubrique,$voir_cal_nono,$id_meslogos;

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

	
  debut_page('&laquo; '._T('squelettesnono:titre_page').' &raquo;', 'configurations', 'mots_partout','',_DIR_PLUGIN_SQUELETTES_NONO.'/squelettesNono.css');

  if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
	echo _T('avis_non_acces_page');
	exit;
  }

	/* initialisation des meta de nono */
		
	// valider les changements
	
	include_spip('inc/confignono'); // declaration des fonctions propres aux m�ta de nono
	
	if ($changer_config == 'oui') {	appliquer_modifs_nono(); }

	lire_metas();// lecture des meta nono

	//les meta nono �ssage dans des variables
	$nono_base_version=$GLOBALS['meta']['nono_base_version'];
	
	$keywords_nono=$GLOBALS['meta']['keywords_nono'];
	$copyright_nono=$GLOBALS['meta']['copyright_nono'];
	$directeur_nono=$GLOBALS['meta']['directeur_nono'];
	$redacteur_nono=$GLOBALS['meta']['redacteur_nono'];
	
	$voir_cal_nono=$GLOBALS['meta']['voir_cal_nono'];
	$nb_evens_nono=$GLOBALS['meta']['nb_evens_nono'];
	$voir_une_nono=$GLOBALS['meta']['voir_une_nono'];
	$nb_articles_nono=$GLOBALS['meta']['nb_articles_nono'];
	$nb_breves_nono=$GLOBALS['meta']['nb_breves_nono'];
	$nb_sites_nono=$GLOBALS['meta']['nb_sites_nono'];
	$nb_syndic_nono=$GLOBALS['meta']['nb_syndic_nono'];
	$nb_messages_nono=$GLOBALS['meta']['nb_messages_nono'];
	
	// menu programmable
	$voir_menu_nono=$GLOBALS['meta']['voir_menu_nono'];
	$nom_menu1_nono=$GLOBALS['meta']['nom_menu1_nono'];
	$url_menu1_nono=$GLOBALS['meta']['url_menu1_nono'];
	$nom_menu2_nono=$GLOBALS['meta']['nom_menu2_nono'];
	$url_menu2_nono=$GLOBALS['meta']['url_menu2_nono'];
	$nom_menu3_nono=$GLOBALS['meta']['nom_menu3_nono'];
	$url_menu3_nono=$GLOBALS['meta']['url_menu3_nono'];
	$nom_menu4_nono=$GLOBALS['meta']['nom_menu4_nono'];
	$url_menu4_nono=$GLOBALS['meta']['url_menu4_nono'];

	//fonction edito
		
	$activer_edito=$GLOBALS['meta']['activer_edito'];
	$id_edito=$GLOBALS['meta']['id_edito'];
	
	// fonction meslogos
	$activer_meslogos=$GLOBALS['meta']['activer_meslogos'];
	$id_meslogos=$GLOBALS['meta']['id_meslogos'];
	
	if ($connect_statut == '0minirezo' AND $connect_toutes_rubriques ) {

	echo '<br><br><br>';

	gros_titre(_T('squelettesnono:gros_titre'));

	barre_onglets("configuration", "config_squelettes_Nono");

	/*debut du contenu de la page de configuration*/
	
	/* partie gauche de la page */
	debut_gauche();	
	
	debut_boite_info();
	echo propre(_T('squelettesnono:help'))."<br><br><strong>version de Nono : ".$nono_base_version."</strong>";
	fin_boite_info();
	

	/*partie droite de la page ... la config !*/
	debut_droite();
	
	include_ecrire('inc_config');
	avertissement_config();
	echo '<form action="'.generer_url_ecrire('config_squelettes_Nono').'" method="post">';

	// ici on met le code de la page

	echo "<input type='hidden' name='changer_config' value='oui'>";
	
	/* interface de saisie des meta de nono */
	
		debut_cadre_couleur("racine-site-24.gif", false, "", _T('squelettesnono:titre_meta_nono'));
	
		echo _T('squelettesnono:entetes_nono')."<br><br>";

		debut_cadre_relief("", false, "", _T('squelettesnono:keywords_nono'));
			echo "<input type='text' name='keywords_nono' value=\"$keywords_nono\" size='40' CLASS='forml'>";
		fin_cadre_relief();
		
		debut_cadre_relief("", false, "", _T('squelettesnono:copyright_nono'));
			echo "<input type='text' name='copyright_nono' value=\"$copyright_nono\" size='40' CLASS='forml'>";
		fin_cadre_relief();

		echo "<br>"._T('squelettesnono:legal_nono')."<br><br>";
		
		debut_cadre_relief("", false, "", _T('squelettesnono:directeur_nono'));
			echo "<input type='text' name='directeur_nono' value=\"$directeur_nono\" size='40' CLASS='forml'>";
		fin_cadre_relief();
		
		debut_cadre_relief("", false, "", _T('squelettesnono:redacteur_nono'));
			echo "<input type='text' name='redacteur_nono' value=\"$redacteur_nono\" size='40' CLASS='forml'>";
		fin_cadre_relief();

	
		echo"<br>";

		// *Champs optionnels de la page sommaire
	
		echo _T('squelettesnono:texte_options_sommaire')."<br><br>";
		
		debut_cadre_relief("", false, "", _T('squelettesnono:info_options_sommaire'));
	
	
		echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=3 WIDTH=\"100%\">";
	
		echo "<TR><TD BACKGROUND='" . _DIR_IMG_PACK . "rien.gif' COLSPAN='2' class='verdana2'>";
		
		echo "</TD></TR>";
	
		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesnono:info_calendrier_nono');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
			echo afficher_choix('voir_cal_nono', $voir_cal_nono,array('oui' => _T('item_oui'),'non' => _T('item_non')), ' &nbsp; ');
		echo "</TD></TR>\n";
		
		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesnono:info_une_nono');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
			echo afficher_choix('voir_une_nono', $voir_une_nono,array('oui' => _T('item_oui'),'non' => _T('item_non')), ' &nbsp; ');
		echo "</TD></TR>\n";

		echo "<TR><TD ALIGN='$spip_lang_left' class='verdana2'></TD><TD ALIGN='$spip_lang_left' class='verdana2'></TD></TR>";

		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesnono:info_agenda_nono');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_evens_nono' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_evens_nono).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_evens_nono).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_evens_nono).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_evens_nono).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_evens_nono).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_evens_nono).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";

		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesnono:info_articles_nono');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_articles_nono' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_articles_nono).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_articles_nono).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_articles_nono).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_articles_nono).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_articles_nono).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_articles_nono).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";

		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesnono:info_breves_nono');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_breves_nono' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_breves_nono).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_breves_nono).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_breves_nono).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_breves_nono).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_breves_nono).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_breves_nono).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";
	
		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesnono:info_sites_nono');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_sites_nono' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_sites_nono).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_sites_nono).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_sites_nono).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_sites_nono).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_sites_nono).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_sites_nono).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";

		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesnono:info_syndic_nono');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_syndic_nono' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_syndic_nono).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_syndic_nono).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_syndic_nono).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_syndic_nono).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_syndic_nono).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_syndic_nono).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";
	
		echo "<TR>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo _T('squelettesnono:info_messages_nono');
		echo "</TD>";
		echo "<TD ALIGN='$spip_lang_left' class='verdana2'>";
		echo"<CENTER><select name='nb_messages_nono' class='fondo' size='1'>\n";
			echo"<OPTION ".mySel('0',$nb_messages_nono).">0</OPTION>\n";
			echo"<OPTION ".mySel('1',$nb_messages_nono).">1</OPTION>\n";
			echo"<OPTION ".mySel('2',$nb_messages_nono).">2</OPTION>\n";
			echo"<OPTION ".mySel('3',$nb_messages_nono).">3</OPTION>\n";
			echo"<OPTION ".mySel('4',$nb_messages_nono).">4</OPTION>\n";
			echo"<OPTION ".mySel('5',$nb_messages_nono).">5</OPTION>\n";
		echo"</select></CENTER></TD></TR>\n";
	
		echo "</TABLE>";
	
		fin_cadre_relief();


	echo "<div style='text-align:right;'><input type='submit' name='Enregistrer' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";

	fin_cadre_couleur();

	/* interface de modification de la CSS */
	
	//debut_cadre_trait_couleur("tout-site.png", false, "", _T('squelettesnono:css_nono'));
	
		//echo "<div style='text-align:right;'><input type='submit' name='Enregistrer' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";
			
	//fin_cadre_trait_couleur();

	
	
	/* interface de saisie des menus Programmables */
	
	debut_cadre_couleur("site-24.gif", false, "", _T('squelettesnono:menus_titre_nono'));
		
		echo _T('squelettesnono:menus_texte_nono')."<br><br>";
		
		echo bouton_radio("voir_menu_nono", "oui", _T('squelettesnono:item_utiliser_menu'), $voir_menu_nono == "oui", "changeVisible(this.checked, 'config-menu', 'block', 'none');");
		echo " &nbsp;";
		echo bouton_radio("voir_menu_nono", "non", _T('squelettesnono:item_non_utiliser_menu'), $voir_menu_nono == "non", "changeVisible(this.checked, 'config-menu', 'none', 'block');");
		
		echo "<br><br>";
		// affichage optionnel	
		if ($voir_menu_nono != 'non') $style = "display: block;";
		else $style = "display: none;";
		
		echo "<div id='config-menu' style='$style'>";
		
		debut_cadre_relief("", false, "", _T('squelettesnono:menu1_nono'));
			echo _T('squelettesnono:menu1_info_titre_nono')," ";
			echo "<input type='text' name='nom_menu1_nono' class='forml' width='40' value=\"$nom_menu1_nono\"/><br />\n";
			echo _T('squelettesnono:menu1_info_url_nono')," ";
			echo "<input type='text' name='url_menu1_nono' class='forml' width='40' value=\"$url_menu1_nono\"/>";
		fin_cadre_relief();
		
		debut_cadre_relief("", false, "", _T('squelettesnono:menu2_nono'));
			echo _T('squelettesnono:menu2_info_titre_nono')," ";
			echo "<input type='text' name='nom_menu2_nono' class='forml' width='40' value=\"$nom_menu2_nono\"/><br />\n";
			echo _T('squelettesnono:menu2_info_url_nono')," ";
			echo "<input type='text' name='url_menu2_nono' class='forml' width='40' value=\"$url_menu2_nono\"/>";
		fin_cadre_relief();

		debut_cadre_relief("", false, "", _T('squelettesnono:menu3_nono'));
			echo _T('squelettesnono:menu3_info_titre_nono')," ";
			echo "<input type='text' name='nom_menu3_nono' class='forml' width='40' value=\"$nom_menu3_nono\"/><br />\n";
			echo _T('squelettesnono:menu3_info_url_nono')," ";
			echo "<input type='text' name='url_menu3_nono' class='forml' width='40' value=\"$url_menu3_nono\"/>";
		fin_cadre_relief();

		debut_cadre_relief("", false, "", _T('squelettesnono:menu4_nono'));
			echo _T('squelettesnono:menu4_info_titre_nono')," ";
			echo "<input type='text' name='nom_menu4_nono' class='forml' width='40' value=\"$nom_menu4_nono\"/><br />\n";
			echo _T('squelettesnono:menu4_info_url_nono')," ";
			echo "<input type='text' name='url_menu4_nono' class='forml' width='40' value=\"$url_menu4_nono\"/>";
		fin_cadre_relief();

		debut_cadre_relief("", false, "", _T('squelettesnono:menu5_nono'));
			echo _T('squelettesnono:menu5_info_titre_nono')," ";
			echo "<input type='text' name='nom_menu5_nono' class='forml' width='40' value=\"$nom_menu5_nono\"/><br />\n";
			echo _T('squelettesnono:menu5_info_url_nono')," ";
			echo "<input type='text' name='url_menu5_nono' class='forml' width='40' value=\"$url_menu5_nono\"/>";
		fin_cadre_relief();

		echo "</div>"; //fin affichage conditionnel
				
		echo "<div style='text-align:right;'><input type='submit' name='Enregistrer' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";
			
	fin_cadre_couleur();

	
	
	/* interface d'activation de l'edito */

		debut_cadre_trait_couleur("rubrique-24.gif", false, "", _T('squelettesnono:titre_edito'));
		
		echo _T('squelettesnono:texte_edito')."<br><br>";
		
		echo bouton_radio("activer_edito", "oui", _T('squelettesnono:item_utiliser_edito'), $activer_edito == "oui", "changeVisible(this.checked, 'config-edito', 'block', 'none');");
		echo " &nbsp;";
		echo bouton_radio("activer_edito", "non", _T('squelettesnono:item_non_utiliser_edito'), $activer_edito == "non", "changeVisible(this.checked, 'config-edito', 'none', 'block');");
		
		echo "<br><br>";
		
		// affichage optionnel	
		if ($activer_edito != 'non') $style = "display: block;";
		else $style = "display: none;";
		
		echo "<div id='config-edito' style='$style'>";
		
		// Choix de la rubrique
		include_spip('inc/rubriques');

		echo selecteur_rubrique($id_edito, 'rubrique', ($GLOBALS['statut'] == 'publie'));

		echo "</div>";
		
		echo "<div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_valider')."' CLASS='fondo'></div>";

	
	fin_cadre_trait_couleur();
	

	/* interface d'activation de la fonction meslogos */
	
	debut_cadre_trait_couleur("groupe-mot-24.gif", false, "", _T('squelettesnono:titre_meslogos'));

	
	echo _T('squelettesnono:texte_meslogos')."<br><br>";
	
	echo bouton_radio("activer_meslogos", "oui", _T('squelettesnono:item_utiliser_meslogos'), $activer_meslogos == "oui", "changeVisible(this.checked, 'config-meslogos', 'block', 'none');");
	echo " &nbsp;";
	echo bouton_radio("activer_meslogos", "non", _T('squelettesnono:item_non_utiliser_meslogos'), $activer_meslogos == "non", "changeVisible(this.checked, 'config-meslogos', 'none', 'block');");

	
	// affichage optionnel	
	if ($activer_meslogos != 'non') $style = "display: block;";
	else $style = "display: none;";
	
	echo "<div id='config-meslogos' style='$style'>";
	
	// Choix du groupe de mots cl�s affect�

	echo selecteur_groupe_html($id_meslogos);
	
	echo "</div>";
	
	echo "<br><div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_valider')."' CLASS='fondo'></div>";

	echo "</form>";
	
	fin_cadre_trait_couleur();



  } 
  
  echo "</form>";
  
  fin_page();
  
}

?>