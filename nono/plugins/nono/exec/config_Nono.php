<?php

//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Copyright (C) 2006  Pierre ANDREWS
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


define('_DIR_PLUGIN_CHERCHER_SQUELETTES',(_DIR_PLUGINS.end(explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__).'/..'))))));

function exec_config_Nono() {
  global $connect_statut, $connect_toutes_rubriques;

  include_spip("inc/presentation");
  include_spip ("base/abstract_sql");

  debut_page('&laquo; '._T('squelettesnono:titre_page').' &raquo;', 'configurations', 'mots_partout','',_DIR_PLUGIN_CHERCHER_SQUELETTES.'/squelettesNono.css');

  if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
	echo _T('avis_non_acces_page');
	exit;
  }

  if ($connect_statut == '0minirezo' AND $connect_toutes_rubriques ) {

	echo '<br><br><br>';

	gros_titre(_T('squelettesnono:gros_titre'));

	barre_onglets("configuration", "config_Nono");

	/*Affichage*/
	debut_gauche();	
	
	debut_boite_info();
	echo propre(_T('squelettesnono:help'));
	fin_boite_info();

	debut_droite();
	
	include_ecrire('inc_config');
	avertissement_config();

	echo '<form action="'.generer_url_ecrire('config_Nono').'" method="post">';

	// ici on met le code de la page

	//
	// Verifie que la table spip_conf_nono existe, sinon la creer
	//
	function Nono_verifier_table_conf() {
		if (!spip_query("SELECT id_syndic, id_syndic_article, id_document FROM spip_conf_nono")) {
			spip_log('creation de la table spip_conf_nono');
			include_spip('base/create');
			spip_create_table('spip_conf_nono',
				$GLOBALS['tables_auxiliaires']['spip_conf_nono']['edito'],
				false);
		}
	}	
	
	// configurer l'édito
	
	debut_cadre_trait_couleur("breve-24.gif", false, "", _T('squelettesnono:titre_edito').aide ("squelettesnono:confedito"));

	$activer_edito = $GLOBALS['meta']["activer_edito"];
	
	echo _T('squelettesnono:texte_edito')."<br><br>";
	echo bouton_radio("activer_edito", "oui", _T('squelettesnono:item_utiliser_edito'), $activer_edito == "oui", "changeVisible(this.checked, 'config-edito', 'block', 'none');");
	echo " &nbsp;";
	echo bouton_radio("activer_edito", "non", _T('squelettesnono:item_non_utiliser_edito'), $activer_edito == "non", "changeVisible(this.checked, 'config-edito', 'none', 'block');");
	
	if ($activer_edito = 'oui') $style = "display: none;";
	else $style = "display: block;";
	
	echo "<div id='config-edito' style='$style'>";
	
	// Choix de la rubrique
	//
	include_spip('inc/rubriques');

		echo "<p />";

		echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=3 WIDTH=\"100%\">";
		echo "<TR><TD BACKGROUND='" . _DIR_IMG_PACK . "rien.gif'>";
		echo "<FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=2 COLOR='#000000'>";
			
			// selection de la rubrique
			if ($id_rubrique == 0) $logo = "racine-site-24.gif";
			elseif ($id_secteur == $id_rubrique) $logo = "secteur-24.gif";
			else $logo = "rubrique-24.gif";

			debut_cadre_couleur($logo, false, "", _T('squelettesnono:info_edito'). aide("artrub"));
	 			echo selecteur_rubrique($id_edito, 'article', ($GLOBALS['statut'] == 'publie'));
			fin_cadre_couleur();

		echo "</FONT>";
		echo "</TD></TR></table>";


	echo "</div>";
	
	echo "<div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";

	echo "</form>";
	
	fin_cadre_trait_couleur();

  } 
  
  ecrire_meta('SquelettesNono:fond_pour_groupe',serialize($fonds));
  ecrire_metas();
  
  fin_page();
  
}

?>
