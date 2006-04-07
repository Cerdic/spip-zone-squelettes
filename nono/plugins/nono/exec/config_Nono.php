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

  debut_page('&laquo; '._T('squelettesnono:titre_page').' &raquo;', 'configurations', 'mots_partout','',_DIR_PLUGIN_CHERCHER_SQUELETTES.'/squelettes_Nono.css');

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

// ici on met le code de la page de configuration
	
	
	
  } 
  
  ecrire_meta('SquelettesNono:fond_pour_groupe',serialize($fonds));
  ecrire_metas();
  
  fin_page();
  
}

?>
