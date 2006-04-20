<?php

//    Fichier cr�� pour SPIP avec un bout de code emprunt� � celui ci.
//    Distribu� sans garantie sous licence GPL./
//    Copyright (C) 2006  Jean S�bastien Barboteu
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


define('_DIR_PLUGIN_CHERCHER_SQUELETTES',(_DIR_PLUGINS.end(explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__)))))));

function SquelettesNono_ajouter_onglets($flux) {
  if($flux['args']=='configuration')
	$flux['data']['config_squelettes_Nono']= new Bouton(
															 '../'._DIR_PLUGIN_CHERCHER_SQUELETTES.'/spip_nono.png', 'Configurer Squelettes Nono',
																 generer_url_ecrire("config_squelettes_nono"));
  return $flux;
}


?>
