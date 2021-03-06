<?php





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
 * https://contrib.spip.net/article.php3?id_article=261
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
$fichier = '';

if ($infos['statut']=="0minirezo" OR $infos[statut]=="1comite") {
  $racine="auton$infos[id_auteur]";
	if (file_exists("IMG/$racine.png")) {
		$fichier = "$racine.png";
		}
		else if (file_exists("IMG/$racine.png")) {
				 $fichier = "$racine.png";
				 }
		else if (file_exists("IMG/$racine.png")) {
				 $fichier = "$racine.png";
		}
          if($fichier!= '' ){
          $retour="<img".$insert." src=\"IMG/$fichier\" alt=\"avatar de $nom\">";
          }
	}
	else {
	if ($infos['statut']=="6forum") {
	$infos=unserialize(get_auteur_infos('', $nom));
$source=unserialize($infos[extra]);
$source_extra=$source[avatar];
if(isset($source_extra))
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
 *   !! Adaptez les numéros (10 et 11) à vos numeros de groupe de mots clés !!
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * https://contrib.spip.net/article.php3?id_article=421
*/
function afficher_mots_clefs($texte) {
// 3 à changer par le num du Groupe "Type de sujets"
// 4 à changer par le num du Groupe de mot clé "Modération"
if (($GLOBALS['auteur_session']['statut']=='0minirezo') OR ($GLOBALS['auteur_session']['statut']=='1comite'))
{
$GLOBALS['afficher_groupe'][]=3;
$GLOBALS['afficher_groupe'][]=4;
}
else {
$GLOBALS['afficher_groupe'][]=0; 
}
}

// 4 à changer par le num du Groupe de mot clé "Modération"
function pas_afficher_mots_clefs($texte) {
if (($GLOBALS['auteur_session']['statut']=='0minirezo'))
{
$GLOBALS['afficher_groupe'][]=4;
}
else{
$GLOBALS['afficher_groupe'][]=0;
}
}



/*
 *   +---------------------------------------------+
 *    Nom du Filtre : Nombre de messages 
 *   +---------------------------------------------+
 *    Date : mercredi 09 avril 2003
 *    Auteur : BoOz Email:booz@bloog.net
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
 *   +----------------------------------+
 *    Nom du Filtre :    citation                                            
 *   +----------------------------------+
 *    Date : vendredi 11 novembre 2006
 *    Auteur :  BoOz
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *     affiche le texte à citer    
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
*/

function barre_forum_citer($texte, $lan)
{
	include_ecrire('inc/layer');

if (!$premiere_passe = rawurldecode(_request('retour_forum'))) {
	if($GLOBALS['citer']){

	$id_citation = $GLOBALS['id_forum'] ;
	$query = "SELECT * FROM spip_forum WHERE id_forum=$id_citation";
    $result = spip_query($query);
    $row = spip_fetch_array($result);
//ajout de la citation

$texte="\{\{$row[auteur] $lan:}}\n\n<quote>\n$row[texte]\n</quote>\n";

	}
	
}

	
	if (!$GLOBALS['browser_barre'])
		return "<textarea name='texte' rows='12' class='forml' cols='40'>$texte</textarea>";
	static $num_formulaire = 0;
	$num_formulaire++;
	include_spip('inc/barre');
	return afficher_barre("document.getElementById('formulaire_$num_formulaire')", true) .
	  "
<textarea name='texte' rows='12' class='forml' cols='40'
id='formulaire_$num_formulaire'
onselect='storeCaret(this);'
onclick='storeCaret(this);'
onkeyup='storeCaret(this);'
ondbclick='storeCaret(this);'>$texte</textarea>";
}

?>
