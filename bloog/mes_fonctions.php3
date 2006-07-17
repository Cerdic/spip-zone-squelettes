<?php

/*
 *   +----------------------------------+
 *    Nom du Filtre :    titre_forum
 *   +----------------------------------+
 *    Date : lundi 11 mai 2005
 *    Auteur :  BoOz (booz@bloog.net)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Nettoie les titres des forums
 *    [(#ID_AUTEUR|messages_prives)]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au site bloog.net
*/

function titre_forum($titre=''){
$ze_titre = ereg_replace( "> ", "", $titre );
return $ze_titre;
}

/*
 *   +----------------------------------+
 *    Nom du Filtre :    messages_prives
 *   +----------------------------------+
 *    Date : lundi 23 février 2004
 *    Auteur :  BoOz (booz@bloog.net)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Permet d'afficher le nombre de message privés d'un auteur dans la partie publique
 *    [(#ID_AUTEUR|messages_prives)]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/
*/

function messages_prives($id_auteur=''){
global $table_prefix;
$query = "SELECT * FROM spip_messages AS messages, spip_auteurs_messages AS
lien
WHERE lien.id_auteur=$id_auteur AND vu='non'   AND statut='publie'
AND type='normal' AND lien.id_message=messages.id_message";
$nb_mess = "";

$result = spip_query($query);
$nb_mess = spip_num_rows($result);

If($id_auteur !=''){

IF ($nb_mess == 1) {
$resultat = "Vous avez <B>1</B> nouveau message <a
href=\"ecrire/messagerie.php3\">privé</a> !";
} ELSEIF ($nb_mess > 1) {
$resultat = "Vous avez <B>".$nb_mess."</B> nouveaux messages <a
href=\"ecrire/messagerie.php3\">privés</a> !";
}
ELSE $resultat = "Vous n\'avez pas de nouveau message <a href=\"ecrire/messagerie.php3\">privé</a> !";
} else $resultat = "ERREUR : Vous devez definir un id_auteur !!";

return $resultat;
}



/*
 *   +----------------------------------+
 *    Nom du Filtre :    get_auteur_infos
 *   +----------------------------------+
 *    Date : lundi 23 février 2004
 *    Auteur :  Nikau (luchier@nerim.fr)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Cette fonction permet d'obtenir toutes les infos 
 *    d'un auteur avec son nom ou son id_auteur
 *    ATTENTION !! cette fonction ne s'utilise pas de       
 *    façon classique !! voir explication dans la contrib'
 *    Fonction utilisée également dans la fonction
 *    'afficher_avatar'
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=261
*/
function get_auteur_infos($id='', $nom='') {
if ($id) $query = "SELECT * FROM spip_auteurs WHERE id_auteur=$id";
if ($nom) $query = "SELECT * FROM spip_auteurs WHERE nom='$nom'";
$result = spip_query($query);

if ($row = spip_fetch_array($result)) {
$row=serialize($row);
}
return $row;
}


/*
 *   +----------------------------------+
 *    Nom du Filtre :    afficher_avatar
 *   +----------------------------------+
 *    Date : lundi 23 février 2004
 *    Auteur :  Nikau (luchier@nerim.fr)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Cette fonction permet d'afficher 
 *    l'avatar d'un auteur.
 *    On peut passer une classe CSS pour régler        
 *    l'affichage
 *    EXEMPLE :
 *    [(#NOM|afficher_avatar{''})] ou
 *     [(#NOM|afficher_avatar{'nom_de_la_classe'})]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=261
*/
function afficher_avatar($nom, $classe='') {
if ($classe!='') $insert=" class=\"$classe\""; else $insert="";

$infos=unserialize(get_auteur_infos('', $nom));

if ($infos['statut']=="0minirezo" OR $infos[statut]=="1comite") {
  $racine="auton$infos[id_auteur]";
	if (file_exists("IMG/$racine.gif")) {
		$fichier = "$racine.gif";
		}
		else if (file_exists("IMG/$racine.jpg")) {
				 $fichier = "$racine.jpg";
				 }
		else if (file_exists("IMG/$racine.png")) {
				 $fichier = "$racine.png";
		}
	$retour="<img".$insert." src=\"IMG/$fichier\" alt=\"avatar de $nom\">";
	}
	else {
	if ($infos['statut']=="6forum") {
	$infos=unserialize(get_auteur_infos('', $nom));
$source=unserialize($infos[extra]);
$source_extra=$source[avatar];
$retour="<img".$insert."  src=\"".$source_extra."\" alt=\"Avatar de $nom\">";
}
}
return $retour;
}


/*
 *   +----------------------------------+
 *    Nom des Filtres :  afficher_mots_clefs et pas_afficher_mots_clefs
 *   +----------------------------------+
 *    Date : lundi 25 février 2004
 *    Auteur :  Nikau (luchier@nerim.fr)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Permet d'afficher ou non les mots clefs pour 
 *    les forums selon le statut de l'auteur du message
 *    EXEMPLE :
 *    [(#ID_FORUM|afficher_mots_clefs] ou
 *     [(#ID_FORUM|pas_afficher_mots_clefs]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=421
*/
function afficher_mots_clefs($texte) {

if (($GLOBALS['auteur_session']['statut']=='0minirezo') OR ($GLOBALS['auteur_session']['statut']=='1comite'))
{
$GLOBALS['afficher_groupe'][]=10;
$GLOBALS['afficher_groupe'][]=11;
}
else {
$GLOBALS['afficher_groupe'][]=0; 
}
}

function pas_afficher_mots_clefs($texte) {
if (($GLOBALS['auteur_session']['statut']=='0minirezo') OR ($GLOBALS['auteur_session']['statut']=='1comite'))
{
$GLOBALS['afficher_groupe'][]=11;
}
else{
$GLOBALS['afficher_groupe'][]=0;
}
}

/*
 *   +----------------------------------+
 *    Nom des Filtres :  citation
 *   +----------------------------------+
 *    Date : samedi 28 février 2004
 *    Auteur :  Nikau (luchier@nerim.fr)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Permet d'afficher un formulaire de  
 *    forum avec la citation du message
 *    auquel on répond
 *    EXEMPLE :
 *    [(#ID_FORUM|citation)] ou
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=425
*/
function citation($id_citation) {
//récupération des détails du forum
if ($id_citation) {
$query = "SELECT * FROM spip_forum WHERE id_forum=$id_citation";
}
$result = spip_query($query);

if ($row = spip_fetch_array($result)) {

}
$ajout="<quote>\n\{\{$row[auteur] a écrit :}}<br />\n$row[texte]</quote>";
//echo"id message = $GLOBALS[id_message]<br>";
if ($GLOBALS[id_message]=intval($GLOBALS[id_message])) {
$texte_retour=retour_forum($row[id_rubrique], $row[id_forum], $row[id_article], $row[id_breve], $row[id_syndic], $row[titre]);
} else {
$texte=explode("</textarea>",retour_forum($row[id_rubrique], $row[id_forum], $row[id_article], $row[id_breve], $row[id_syndic], $row[titre]));
$texte_retour=$texte[0].$ajout."</textarea>".$texte[1];
}
return $texte_retour;
}



/*
 *   +---------------------------------------------+
 *    Nom du Filtre : Nombre de messages 
 *   +---------------------------------------------+
 *    Date : mercredi 09 avril 2003
 *    Auteur : BoOz Email:booz.bloog@laposte.net
 *    site : http://bloog.net
 *   +---------------------------------------------+
 *    Fonctions de ce filtre :
 *    Compte le nombre de messages d'un auteur
 *     Appelez le dans vos squellette tout simplement
 *     par : [(#ID_AUTEUR|nb_messages)]
 *   +---------------------------------------------+
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/
 *
 */
function nb_messages($id_auteur){

global $table_prefix;
$query = "SELECT auteur FROM ".$table_prefix."_forum WHERE id_auteur=$id_auteur";
$nb_mess = "";

$result_auteurs = spip_query($query);
$nb_mess = spip_num_rows($result_auteurs);

		return $nb_mess;
		
		
}

// FIN du nb_message





/*
 *   +---------------------------------------------+
 *    Nom du Filtre : Filtre RETROLIENS 
 *   +---------------------------------------------+
 *    Date : 2003
 *    Auteur : BoOz d'après un code original de Fil
 *    
 *   +---------------------------------------------+
 *    Fonctions de ce filtre :
 *     Affiche les référents de l'article 
 *     Appelez le dans vos squellette tout simplement
 *     par : [(#URL_SITE|afficher_referers)]
 *   +---------------------------------------------+
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=XXX
 *
 */

// Afficher les referers
//

function affiche_referers ($query, $limit=10, $plus = true) {
	
// Charger les moteurs de recherche
	$arr_engines = stats_load_engines();

	$query .= " LIMIT 0,$limit";
	$result = spip_query($query);
	
	while ($row = spip_fetch_array($result)) {
		$referer = interdire_scripts($row['referer']);
		$visites = $row['vis'];
		$tmp = "";
		$aff = "";
		
		$buff = stats_show_keywords($referer, $referer);

		if ($buff["host"]) {
							
			$numero = substr(md5($buff["hostname"]),0,8);
	
			$nbvisites[$numero] = $nbvisites[$numero] + $visites;

			if (strlen($buff["keywords"]) > 0) {
				$criteres = substr(md5($buff["keywords"]),0,8);
				if (!$lescriteres[$numero][$criteres])
					$tmp = " &laquo;&nbsp;".$buff["keywords"]."&nbsp;&raquo;";
				$lescriteres[$numero][$criteres] = true;
				
			} else {
				$tmp = $buff["path"];
				if (strlen($buff["query"]) > 0) $tmp .= "?".$buff['query'];
		
				if (strlen($tmp) > 30)
					$tmp = "/".substr($tmp, 0, 27)."...";
				else if (strlen($tmp) > 0)
					$tmp = "/$tmp";
			}

			if ($tmp)
				$lesreferers[$numero][] = "<a href='$referer'> $tmp</a>" . (($visites > 1)?" ($visites)":"");
			
			else
			$lesliensracine[$numero] += $visites;
			$lesdomaines[$numero] = $buff["hostname"];
			$lesurls[$numero] = $buff["host"];
			$lesliens[$numero] = $referer;
		}
	}
	
	if (count($nbvisites) > 0) {
		arsort($nbvisites);

    //Que les pas moteurs

		$aff .= "<ul>";
		for (reset($nbvisites); $numero = key($nbvisites); next($nbvisites)) {
			if ($lesdomaines[$numero] == '') next;
            $visites = pos($nbvisites);
			$ret = "\n<li>";
		
			if ($visites > 5) $ret .= "<font color='red'>$visites "._T('info_visites')."</font> ";
			else if ($visites > 1) $ret .= "$visites "._T('info_visites')." ";
			else $ret .= "<font color='#999999'>$visites "._T('info_visite')."</font> ";
			
			if (count($lesreferers[$numero]) > 1) {
				$referers = join ($lesreferers[$numero],"</li><li>");
				$aff .= "<p /> ";
				$aff .= $ret;
				$aff .= "<a href='http://".$lesurls[$numero]."'><b><font color='$couleur_foncee'>".$lesdomaines[$numero]."</font></b></a>";
				if ($rac = $lesliensracine[$numero]) $aff .= " <font size='1'>($rac)</font>";
				$aff .= "<ul><font size='1'><li>$referers</li></font></ul>";
				$aff .= "</li><p />\n";
			} else {
				$aff .= $ret;
				$lien = $lesdomaines[$numero].ereg_replace(" \([0-9]+\)$", "",$lesreferers[$numero][0]);
				$aff .= "<a href='".$lesliens[$numero]."'><b>$lien</b></a>";
				$aff .= "</li>";
			}
		}
		$aff .= "</ul>";
		
		
		// Le lien pour en afficher "plus"
		if ($plus AND (spip_num_rows($result) == $limit)) {
			$lien = $GLOBALS['clean_link'];
			$lien->addVar('limit',$limit+200);
			$aff .= "<div style='text-align:right;'><b><a href='".$lien->getUrl()."'>+++</a></b></div>";
		}
	}


	return $aff;
}


function afficher_referers($id_article, $nb=50, $jour=false) {
   

include_ecrire('inc_statistiques.php3') ;

if (!$id_article = intval($id_article)) {
        $table_ref = "spip_referers";
	    $where = "1";
        if ($jour)
            $vis = "visites_jour";
        else
            $vis = "visites";
    } else {
        $table_ref = "spip_referers_articles";
        $vis = "visites";
		$where = "id_article=$id_article";
    }

    $query = "SELECT referer, $vis AS vis FROM $table_ref WHERE ($where) AND ($vis>0) ORDER
BY $vis DESC";
    return affiche_referers($query, $nb, false);
}








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
 */

function nb_connect($resultat){

global $table_prefix;
$query = "SELECT nom, en_ligne FROM ".$table_prefix."_auteurs WHERE (TO_DAYS(now())-TO_DAYS(en_ligne))<=7 ORDER BY en_ligne DESC";
$resultat = "";

$result_auteurs = spip_query($query);
$nb_connectes = spip_num_rows($result_auteurs);
$flag_cadre = ($nb_connectes > 0);

if ($flag_cadre) {
	$resultat.="<p>";
	if ($nb_connectes > 1) $resultat.="<h5>Ils sont venus ces derniers temps </h5>";
	else $resultat.="<h5>Il est venu ces derniers temps</h5>";
	while ($row = spip_fetch_array($result_auteurs)) {
		$nom_auteur = $row["nom"];
		$en_ligne = $row["en_ligne"];
		$resultat.="<br>$nom_auteur <span style='font-size:78%'> [ $en_ligne ]</span>";
	}
}
return $resultat;
}

// FIN du Filtre nb_connect



/*
 *   +---------------------------------------------+
 *    Nom du Filtre : membres nouveaux
 *   +---------------------------------------------+
 *        par : [(#URL_SITE|new_connect)]
 *   +---------------------------------------------+
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=94
 *
 */

function new_connect($resultat){

global $table_prefix;
$query = "SELECT nom, en_ligne FROM ".$table_prefix."_auteurs WHERE statut = 'nouveau' ORDER BY en_ligne DESC";
$resultat = "";

$result_auteurs = spip_query($query);
$new_connectes = spip_num_rows($result_auteurs);
$flag_cadre = ($new_connectes > 0);

if ($flag_cadre) {
	$resultat.="<p>";
	if ($new_connectes > 1) $resultat.="Vous etes inscrits mais vous ne vous etes jamais connectés au site:<br><br>";
	else $resultat.="Tu es inscrit mais tu ne t'es jamais connecté au site:<br><br>";
	while ($row = spip_fetch_array($result_auteurs)) {
		$nom_auteur = $row["nom"];
		$en_ligne = $row["en_ligne"];
		$resultat.="<div class=h5>$nom_auteur</div> ";
	}
}
return $resultat;
}

// FIN du Filtre new_connect






/*
 *   +----------------------------------+
 *    Nom du Filtre :    smileys II
 *   +----------------------------------+
 *    Date : mercredi 14 octobre 2003
 *    Auteur :  BoOz (booz.bloog@laposte.net)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Dans un texte, génère automatiquement le smiley 
 *    approprié à la place d'une chaine :nom.
 *    Ce filtre utilise les smileys disponibles dans       
 *    le répertoire smileys/
 *    Exemple d'application :
 *    [(#TEXTE|smileys)]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=261
*/

function smileys($chaine) {

$listimag=array();
$rep1="smileys/";
$listfich=opendir($rep1);
while ($fich=readdir($listfich))
{ 	if(($fich !='..') and ($fich !='.') and ($fich !='.test'))
	{ 
$nomfich=substr($fich,0,strrpos($fich, "."));
$listimag[$nomfich]="<img ALT=\"smiley\" src=\"smileys/".$fich."\">";
	}
}


ksort($listimag);
reset($listimag);

while (list($nom,$chem) = each($listimag))
{ 
  $chaine = str_replace(":".$nom, $chem , $chaine);
}

        return $chaine;
}


?>
