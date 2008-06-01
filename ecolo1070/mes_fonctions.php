<?php

/*
 *   +---------------------------------------------+
 *    Nom du Filtre : membres récemment connectés
 *   +---------------------------------------------+
 *    Date : mercredi 09 avril 2003
 *    Auteur : Txia Lyfoung Email:txia@lyfoung.com
 *    site : http://lyfoung.com
 *   +---------------------------------------------+
 *    Fonctions de ce filtre :
 *     Permet de voir les personnes qui se sont 
 *     connectés récemment
 *     Appelez le dans vos squellette tout simplement
 *     par : [(#URL_SITE|nb_connect)]
 *   +---------------------------------------------+
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=94
 *
 * ligne 2 de la fonction ajoutée par Suske pour màj de en_ligne avant affichage
 */

function nb_connect($resultat){

global $table_prefix;
global $auteur_session;

//SUSKE loguer les auteurs dans la table depuis l'espace public
include_spip('inc/auth');
inc_auth_dist();

$query = "SELECT nom, en_ligne FROM ".$table_prefix."_auteurs WHERE( (TO_DAYS(now())-TO_DAYS(en_ligne))<=15 ) AND statut<='6forum'  ORDER BY en_ligne DESC";
$resultat = "";

$result_auteurs = spip_query($query);
$nb_connectes = spip_num_rows($result_auteurs);
$flag_cadre = ($nb_connectes > 0);

if ($flag_cadre) {
	if ($nb_connectes == 0) $resultat.="Pas de connexion r&egrave;cente";
	if ($nb_connectes > 1) $resultat.="<h2>Derni&egrave;res connexions</h2><div class=\"menu\">";
	else $resultat.="<h2>Derni&egrave;re connexion</h2><div class=\"menu\">";
	while ($row = spip_fetch_array($result_auteurs)) {
		$nom_auteur = $row["nom"];
		$en_ligne = strftime("%d/%m/%y-%T",strtotime($row["en_ligne"]));
		$resultat.="<span class='notes'>$nom_auteur [$en_ligne]</span><br />";
        }
        $resultat.="</div>" ;
}
return $resultat;
}

// FIN du Filtre nb_connect

/*
 *   +---------------------------------------------+
 *    Nom du Filtre : loguer les connexions 6forum
 *   +---------------------------------------------+
 *    Date : jeudi 8 décembre 2005
 *    Auteur : François Rygaert Email:suske@be.tf
 *    site : http://lapsuske.brubel.net
 *   +---------------------------------------------+
 *    Fonction de ce filtre :
 *     Inscrit la date de connexion des visiteurs (6forum)
 *     dans le champs "en_ligne" de la table spip_auteurs
 *     Appelez le dans vos squellette tout simplement
 *     par : [(#URL_SITE|forum_connect)]
 *   +---------------------------------------------+
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.spip_contrib.net/...
 */

function forum_connect(){

if ($auteur_session['statut']!=="6forum")
  {
   return;
  }
else
  {
global $auteur_session;
global $table_prefix;


$no_auteur= $auteur_session["id_auteur"];
$query = "SELECT id_auteur, maj FROM ".$table_prefix."_auteurs WHERE id_auteur=".$no_auteur." LIMIT 1";
$result_maj = spip_query($query);

$row = spip_fetch_array($result_maj);
$update_enligne=$row["maj"];
$requete = "UPDATE ".$table_prefix."_auteurs SET en_ligne=".$update_enligne." WHERE id_auteur = ".$no_auteur." LIMIT 1";
$ecriture = spip_query($requete);

return;
}
}

// FIN du Filtre forum_connect


?>