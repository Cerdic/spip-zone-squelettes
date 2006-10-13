<?php

//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Copyright (C) 2006  Jean Sébastien Barboteu
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

function ajoute_evt ($date_redac, $soustitre, $titre, $url_article, $logo) {
  global $events, $genre;
  if ($date_redac == '') return;
  ereg("([0-9]+) +jour", $soustitre, $nb_jour);
  if ($nb_jour[1]=="") $nb_jour[1]=1;
  if ($nb_jour[1]>20) $nb_jour[1]=1;
  for ($i=0; $i < intval($nb_jour[1]); ++$i) {
     $ymd = date("Ymd", strtotime($date_redac) + 24*3600*$i);
     if (!isset($events[$ymd])) $events[$ymd] = array();
     $events[$ymd][] = array('link' => $url_article, 'title' => $titre, 'logo' => $logo);
  }
}
  

?>
