<?
//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Jean Sébastien Barboteu
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


//critère {scolaspip_nb_articles}


	function critere_scolaspip_nb_articles_dist($idb, &$boucles, $crit) {
	    $boucle = &$boucles[$idb];
	    $var=lire_config('scolaspip_accueil/nb_articles');
	    $boucle->limit = '0, ' .$var ;

}
	function critere_scolaspip_nb_breves_dist($idb, &$boucles, $crit) {
	    $boucle = &$boucles[$idb];
	    $var=lire_config('scolaspip_accueil/nb_breves');
	    $boucle->limit = '0, ' .$var ;

}
	function critere_scolaspip_nb_forums_dist($idb, &$boucles, $crit) {
	    $boucle = &$boucles[$idb];
	    $var=lire_config('scolaspip_accueil/nb_forums');
	    $boucle->limit = '0, ' .$var ;

}

?>