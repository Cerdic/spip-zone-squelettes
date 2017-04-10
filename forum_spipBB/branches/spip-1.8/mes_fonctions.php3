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
	if (file_exists("IMG/$racine.gif")) {
		$fichier = "$racine.gif";
		}
		else if (file_exists("IMG/$racine.jpg")) {
				 $fichier = "$racine.jpg";
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
 *    Nom du Filtre :    smileys II
 *   +----------------------------------+
 *    Date : mercredi 14 octobre 2003
 *    Auteur :  BoOz (booz@bloog.net)
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
 * https://contrib.spip.net/article.php3?id_article=261
*/

function smileys($chaine) {

$listimag=array();
$rep1="smileys/";

$listfich=@opendir($rep1);

if ($listfich != false){



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

}
       
	   return $chaine;
		
		
}

/*
 *   +----------------------------------+
 *    Nom du Filtre :    pagination                                               
 *   +----------------------------------+
 *    Date : dimanche 22 août 2004
 *    Auteur :  James (james<at>rezo.net)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *     affiche la liste des pages d'une boucle contenant
 *     un critère de limite du type {debut_xxx, yyy}
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * https://contrib.spip.net/Pagination,663
*/

	function pagination($total, $position=0, $pas=1, $fonction='') {
		global $clean_link;
		global $pagination_item_avant, $pagination_item_apres, $pagination_separateur;
		tester_variable('pagination_separateur', '&nbsp;| ');
		if (ereg('^debut([-_a-zA-Z0-9]+)$', $position, $match)) {
			$debut_lim = "debut".$match[1];
			$position = intval($GLOBALS['HTTP_GET_VARS'][$debut_lim]);
		}
		$nombre_pages = floor(($total-1)/$pas)+1;
		$texte = '';
		if($nombre_pages>1) {
			$i = 0;
			while($i<$nombre_pages) {
				$url = parametre_url($clean_link->getUrl(), $debut_lim, strval($i*$pas));
				if(function_exists($fonction)) $item = call_user_func($fonction, $i+1);
				else $item = strval($i+1);
				if(($i*$pas) != $position) {
					if(function_exists('lien_pagination')) $item = lien_pagination($url, $item, $i+1);
					else $item = "<a href=\"".$url."\">".$item."</a>";
				}
				$texte .= $pagination_item_avant.$item.$pagination_item_apres;
				if($i<($nombre_pages-1)) $texte .= $pagination_separateur;
				$i++;
			}
			//Correction bug: $clean_link doit revenir à son état initial
			$clean_link->delVar($debut_lim);
			if($position) $clean_link->addVar($debut_lim, $position);
			return $texte;
		}
		return '';
	}

	/*petit additif (Page x sur y)*/
	function pagination_nbpages($total, $position=0, $pas=1, $texte="/") {
		if (ereg('^debut([-_a-zA-Z0-9]+)$', $position, $match)) {
			$debut_lim = "debut".$match[1];
			$position = intval($GLOBALS['HTTP_GET_VARS'][$debut_lim]);
		}
		$nombre_pages = floor(($total-1)/$pas)+1;
		$position = floor($position/$pas)+1;
		return ($nombre_pages>1) ? $position.$texte.$nombre_pages : '';
	}
// FIN du Filtre pagination


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
 * https://contrib.spip.net/Pagination,663
*/

function barre_forum_citer($texte, $lan)
{
	include_ecrire('inc_layer.php3');

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
	include_ecrire('inc_barre.php3');
	return afficher_barre("document.getElementById('formulaire_$num_formulaire')", true) .
	  "
<textarea name='texte' rows='12' class='forml' cols='40'
id='formulaire_$num_formulaire'
onselect='storeCaret(this);'
onclick='storeCaret(this);'
onkeyup='storeCaret(this);'
ondbclick='storeCaret(this);'>$texte</textarea>";
}

/* surcharge du critere par pour ajouter le tri par date de thread
   {par date_thread} introduit dans SPIP1.9.
   Si vous utilisez SPIP1.9, utilisez la version adaptee de SpipBB
 */
function critere_par($idb, &$boucles, $crit) {
	
	$boucle = &$boucles[$idb];
	if ($crit->not) $sens = $sens ? "" : " . ' DESC'";

	foreach ($crit->param as $tri) {

	// tris specifies dynamiquement
	  if ($tri[0]->type != 'texte') {
	      $order = 
		calculer_liste($tri, array(), $boucles, $boucles[$idb]->id_parent);
	      $order =
		"((\$x = preg_replace(\"/\\W/\",'',$order)) ? ('$boucle->id_table.' . \$x$sens) : '')";
	  }
	    else {
	      $par = array_shift($tri);
	      $par = $par->texte;
	// par hasard
		if ($par == 'hasard') {
		// tester si cette version de MySQL accepte la commande RAND()
		// sinon faire un gloubi-boulga maison avec de la mayonnaise.
		  if (spip_query("SELECT RAND()"))
			$par = "RAND()";
		  else
			$par = "MOD(".$boucle->id_table.'.'.$boucle->primary
			  ." * UNIX_TIMESTAMP(),32767) & UNIX_TIMESTAMP()";
		  $boucle->select[]= $par . " AS alea";
		  $order = "'alea'";
		}

	// par date_thread
	else if ($par == 'date_thread' && $boucle->type_requete == 'forums') {
		$boucle->select[] = "MAX(".$boucle->id_table.".".
			$GLOBALS['table_date'][$boucle->type_requete]
			.") AS date_thread";
		$boucle->group = $boucle->id_table.".id_thread";
		$order = "'date_thread'";
	}

	// par titre_mot
		else if ($par == 'titre_mot') {
		  $order= "'mots.titre'";
		}

	// par type_mot
		else if ($par == 'type_mot'){
		  $order= "'mots.type'";
		}
    // par multi champ
    else if (ereg("^multi[[:space:]]*(.*)$",$par, $m)) {
        $texte = $boucle->id_table . '.' . trim($m[1]);
        $boucle->select[] =  " \".creer_objet_multi('".$texte."', \$GLOBALS['spip_lang']).\"" ;
        $order = "multi";
    }
	
	// par num champ(, suite)
		else if (ereg("^num[[:space:]]*(.*)$",$par, $m)) {
		  $texte = '0+' . $boucle->id_table . '.' . trim($m[1]);
		  $suite = calculer_liste($tri, array(), $boucles, $boucle->id_parent);
		  if ($suite !== "''")
		    $texte = "\" . ((\$x = $suite) ? ('$texte' . \$x) : '0')" . " . \"";
		  $as = 'num' .($boucle->order ? count($boucle->order) : "");
		  $boucle->select[] = $texte . " AS $as";
		  $order = "'$as'";
	}
	// par champ. Verifier qu'ils sont presents.
		elseif (ereg("^[a-z][a-z0-9_]*$", $par)) {
		    if ($par == 'date')
		      $order = "'".$boucle->id_table.".".
			$GLOBALS['table_date'][$boucle->type_requete]
			."'";
		    else {
			global $table_des_tables, $tables_des_serveurs_sql;
			$r = $boucle->type_requete;
			$s = $boucles[$idb]->sql_serveur;
			if (!$s) $s = 'localhost';
			$t = $table_des_tables[$r];
			// pour les tables non Spip
			if (!$t) $t = $r; else $t = "spip_$t";
			$desc = $tables_des_serveurs_sql[$s][$t];
			if ($desc['field'][$par])
				$order = "'".$boucle->id_table.".".$par."'";
			else {
			  // tri sur les champs synthetises (cf points)
				$order = "'".$par."'";
			}
		    }
		} else
		    erreur_squelette(_T('zbug_info_erreur_squelette'), "{par $par} BOUCLE$idb");
	    }

	    if ($order)
	      $boucle->order[] = $order . (($order[0]=="'") ? $sens : "");
	  }
}

?>
