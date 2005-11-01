<?php
  /*
  Copyright (C) 2005  Pierre ANDREWS

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
@header('Content-type:text/xml');
echo '<?xml version="1.0" ?>'."\n";
echo '<moduleslist>'." \n";
$dirpath = "./squelettes";
$dh = opendir($dirpath);
$lang = 'fr';
if(isset($_GET['lang'])) $lang = $_GET['lang'];
while (false !== ($file = readdir($dh))) {
  //Don't list subdirectories
  if (is_dir("$dirpath/$file") && preg_match('/^noisette_/i',$file)) {
	echo file_get_contents("$dirpath/$file/info_$lang.xml");
  }	  
}
closedir($dh);  
echo '</moduleslist>'." \n";
?>
