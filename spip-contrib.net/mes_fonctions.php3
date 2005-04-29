<?php

   $GLOBALS['dossier_squelettes'] = '.';

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

 *   !! Adaptez les numéros (10 et 11) à vos numeros de groupe de mots clés !!

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

{ 	if(($fich !='..') and ($fich !='.') and ($fich !='.test') and (!is_dir($rep1 . $fich)) )

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























$GLOBALS['espace_logos'] = 0;

$GLOBALS['puce']='<img src="images/content/pucecontent.gif" alt="- " width="9" height="9">';



function paire($texte) {

if($texte%2==0) $texte="paire "; else $texte="";

return $texte;

}

function imgpaire($texte) {

if($texte%2==0) $texte="2"; else $texte="";

return $texte;

}



/*

 *   +----------------------------------+

 *    Nom du Filtre :    nb_spip2xhtml

 *                       nb_checkparas

 *   +----------------------------------+

 *    Date : jeudi 22 mai 2003

 *    Auteur :  stef      + nospam@notabene.f2o.org

 *              Aurélien

 *   +-------------------------------------+

 *    Fonctions de ces filtres :

 *     Ils rendent conforme à xhtml le contenu généré par spip

 *   +-------------------------------------+ 

 *  

 * Pour toute suggestion, remarque, proposition d'ajout

 * reportez-vous au forum de l'article :

 * http://www.uzine.net/spip_contrib/article.php3?id_article=164

*/



/*

* reformatage des intertitres

* */



$GLOBALS['debut_intertitre'] = "\n<h3 class=\"spip\">";

$GLOBALS['fin_intertitre'] = "</h3>\n";



/*

* formatage du contenu pour validation xhtml

* */



function nb_spip2xhtml($str) {

    if($str!="") {

        // suppresion des hspace, vspace

        $str = preg_replace( "/(h|v)space='.'|border=0/i" , "" , $str);

        

        // img xhtml <img> -> <img />

        $str = preg_replace( "/<img([^>]*)>/i" , "<img \\1 />" , $str);

        

        // h3 imbrique dans un p

        $str = preg_replace( "/<p class=\"spip\"> <h3  class=\"spip\">/i" , "<h3>" , $str);

        $str = preg_replace( "/<\/h3>( )*<\/p>/i" , "</h3>" , $str);



        // div imbriqué dans un p

        $str = preg_replace( "/<p class=\"spip\"><div/i" , "<div" , $str);

        $str = preg_replace( "/<\/div>( )*<\/p>/i" , "</div>" , $str);

        //$str = preg_replace( "/<\/p><\/div>/i" , "</div>" , $str);



        // blockquote imbrique dans un p

        $str = preg_replace( "/<p class=\"spip\"> <blockquote>/i" , "<blockquote>" , $str);

        $str = preg_replace( "/<\/blockquote>( )*<\/p>/i" , "</blockquote>" , $str);

        

        // tableaux imbriques dans p

        $str = preg_replace( "/<p class=\"spip\"><table class=\"spip\">/i" , "<table>" , $str);

        $str = preg_replace( "/<\/table>( )*<\/p>/i" , "</table>" , $str);

        

        // ol ou ul imbrique dans p

        $str = preg_replace( "/<p class=\"spip\"><(o|u)l class=\"spip\">/i" , "<\\1l class=\"spip\">" , $str);

        $str = preg_replace( "/<\/(o|u)l>( )*<\/p>/i" , "</\\1l>" , $str);

        

        // <br> -> <br />

        $str = preg_replace( "/<br>/i" , "<br />" , $str);

        

        // <b> -> <strong> et <i> -> <em>

        $str = preg_replace( "/(<b class=\"spip\">|<b>)/i" , "<strong>" , $str);

        $str = preg_replace( "/(<i class=\"spip\">|<i>)/i" , "<em>" , $str);

        $str = preg_replace( "/<\/b>/i" , "</strong>" , $str);

        $str = preg_replace( "/<\/i>/i" , "</em>" , $str);



        // FORMULAIRE

        // passage des balises en minucule

        $str = ereg_replace("<FORM", "<form", "$str");

        $str = ereg_replace("<INPUT", "<input", "$str");

        $str = ereg_replace("<TEXTAREA", "<textarea", "$str");

        $str = ereg_replace("</TEXTAREA>", "</textarea>", "$str");

        $str = preg_replace("/(<.*?)(TYPE=\')(.*?)(\')(.*?>)/", "\\1type=\"\\3\"\\5", "$str");

        $str = ereg_replace("VALUE=", "value=", "$str");

        // Pour le formulaire FORUM création des attributs id

        $str = preg_replace("/(<.*?)(NAME=')(.*?)(')(.*?>)/", "\\1id=\"\\3\" name=\"\\3\"\\5", "$str");		

        // On remplace name par id dans la balise form

        $str = preg_replace("/(<form.*?)(name=)(.*?>)/", "\\1id=\\3", "$str");

        // on ferme les balises input

        $str = preg_replace("/(<input.*?)(>)/", "\\1 />", "$str");

        // On supprime l'attribut WRAP des zones de texte qui n'est pas valide xhtml

        $str = preg_replace("/(<textarea.*?)( wrap=hard| wrap=soft| wrap=off)(.*?>)/", "\\1\\3", "$str");

        

    }

    

    // renvoyer la chaine corrigee

    return $str;

}

// FIN du filtre nb_spip2xhtml



/*

* les notes ont un petit bug :il manque parfois le <p> de debut

* cette fonction y remedie

* fonction utilisee aussi sur mon site pour la bio des auteurs notamment

* */



function nb_checkparas($str) {

    $str = trim($str);

    if($str!="") {

        if(substr($str, 0, 2)!="<p") {

            $str = "<p>" . $str;

        }

        if(substr($str, strlen($str)-4, 4)!="</p>") {

            $str .= "</p>";

        }

    }

    return $str;

}

// FIN du filtre nb_checkparas





/*

 *   +----------------------------------+

 *    Nom du Filtre :    pagination                                               

 *   +----------------------------------+

 *    Date : dimanche 22 aožt 2004

 *    Auteur :  James (klike<at>free.fr)

 *   +-------------------------------------+

 *    Fonctions de ce filtre :

 *     affiche la liste des pages d'une boucle contenant

 *     un critre de limite du type {debut_xxx, yyy}

 *   +-------------------------------------+ 

 *  

 * Pour toute suggestion, remarque, proposition d'ajout

 * reportez-vous au forum de l'article :

 * http://www.uzine.net/spip_contrib/article.php3?id_article=663

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

      $clean_link->delVar($debut_lim);

      $clean_link->addVar($debut_lim, strval($i*$pas));

      $url = $clean_link->getUrl();
      $url = ereg_replace("&", "&amp;", "$url");

      if(function_exists($fonction)) $item = call_user_func($fonction, $i+1);

      else $item = strval($i+1);

      if(($i*$pas) != $position) {

        if(function_exists('lien_pagination')) $item = lien_pagination($url, $item, $i+1);

        else $item = "<a href=\"".$url."\" class=\"spip_in\">".$item."</a>";

      }

      $texte .= $pagination_item_avant.$item.$pagination_item_apres;

      if($i<($nombre_pages-1)) $texte .= $pagination_separateur;

      $i++;

    }


    //Correction bug: $clean_link doit revenir ˆ son Žtat initial

    $clean_link->delVar($debut_lim);

    if($position) $clean_link->addVar($debut_lim, $position);

     return $texte;

  }

  return '';

}



// FIN du Filtre pagination





// tronque un liens à $limit caractères
function couper_liens($texte, $limit) {
  if (strlen($texte) <= $limit){
 return $texte;}
else return substr($texte, 0, $limit) . " (...)";
}



/*  

 *   +-------------------------------------+

 *    Fonctions :

 *    permet de mettre de rendre l'option selected du selecteur de langue
 *    dynamique en fonction de la langue choisi

 *   +-------------------------------------+ 

*/


function select_lang($texte,$langue) {
	if ($langue==$GLOBALS['spip_lang']) {
		$texte=' selected=\'selected\'';
	} else {
		$texte='';
	}
	return $texte;
}


function do_maint($maint_folder,$last_maint_date) {
  //open dir
  if ($handle=@opendir($maint_folder)) {
    //enumerate files in an array
    while (false !== ($file = readdir($handle))) {
      if ($file != "." && $file != "..") {
      $file_array[] = $file;
      }
    }
    closedir($handle);
    //process array of files
    reset($file_array);
    while (list(,$filename)=each($file_array)) {
      //check file time
      if (filemtime($maint_folder."/".$filename)<$last_maint_date) @unlink($maint_folder."/".$filename);
    }
  }
}

function reduire_image_ex($img, $taille = 120,$axes="both",$last_maint_date,$maint_delay) {
  if (strlen($img) > 0) {
		// recuperer le nom du fichier
		if (eregi("src=\'([^']+)\'", $img, $regs)) $logo = $regs[1];
		if (eregi("align=\'([^']+)\'", $img, $regs)) $align = $regs[1];
		if (eregi("name=\'([^']+)\'", $img, $regs)) $name = $regs[1];
		if (eregi("hspace=\'([^']+)\'", $img, $regs)) $espace = $regs[1];

		if (file_exists($logo)) {
			$logo = substr($logo, 4, strlen($logo));
			// recuperer nom de l'image et sa terminaison
			$path = dirname($logo);
			if ($path!="") $path=$path."/resized/";
			if (!is_dir("IMG/$path")) @mkdir("IMG/$path");
      $basename = basename($logo);
      $nom = substr($basename, 0, strpos($basename, "."));
			$format = substr($basename, strlen($basename)-3, strlen($basename));
		
		  $axes=strtolower($axes);
		  if ($axes!="both" && $axes!="x" && $axes!="y") $axes="both";
			// test de recalcul en fonction des dates des fichiers
			// pour verifier si mise a jour plus recente du logo
			$imagefile="IMG/$path$taille-$axes-$nom.$format";
      if (file_exists($imagefile)) {
				$imagetime=filemtime($imagefile);
        if ($imagetime > filemtime("IMG/$logo")) {
					//check filetime and touch if filetime>last maiteinance time + half delay
          if ($imagetime<($last_maint_date+$maint_delay/2) and time()>($last_maint_date+$maint_delay/2)) touch($imagefile);
          return "<img src='$imagefile' name='$name' border='0' align='$align' alt='' hspace='$espace' vspace='$espace' class='spip_logos' />";
					$recalculer = false;
				}
				else {
					$recalculer = true;
				}
			} else {
				$recalculer = true;
			}
		
			$gd_formats = lire_meta("gd_formats");
			if ($recalculer AND ereg($format, $gd_formats)) {
				// Recuperer l'image d'origine
				if ($format == "jpg") {
					$srcImage = ImageCreateFromJPEG("IMG/$logo");
				}
				else if ($format == "gif"){
					$srcImage = ImageCreateFromGIF("IMG/$logo");
				}
				else if ($format == "png"){
					$srcImage = ImageCreateFromPNG("IMG/$logo");
				}
				if (!$srcImage) return;

				// Calculer le ratio
				$srcWidth = ImageSX($srcImage);
				$srcHeight = ImageSY($srcImage);
			
				if (($srcWidth > $taille && ($axes=="both" OR $axes=="x")) OR ($srcHeight > $taille && ($axes=="both" OR $axes=="y"))) {
          $ratioWidth = $srcWidth/$taille;
					$ratioHeight = $srcHeight/$taille;
				
					//Ridimensiono da altezza (solo se axes!=x)
          if ($ratioWidth < $ratioHeight && $axes!="x") {
						$destWidth = floor($srcWidth/$ratioHeight);
						$destHeight = $taille;
					}
					else {
						$destWidth = $taille;
						$destHeight = floor($srcHeight/$ratioWidth);
					}
				} else {
					return $img;
				}
				
				// Initialisation de l'image destination
				if ($GLOBALS['flag_ImageCreateTrueColor'] AND $destFormat != "gif")
					$destImage = ImageCreateTrueColor($destWidth, $destHeight);
				if (!$destImage)
					$destImage = ImageCreate($destWidth, $destHeight);
				// Recopie de l'image d'origine avec adaptation de la taille
				$ok = false;
				if ($GLOBALS['flag_ImageCopyResampled'])
					$ok = ImageCopyResampled($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
				if (!$ok)
					$ok = ImageCopyResized($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
			
				// Sauvegarde de l'image destination
				$destination = $imagefile;
				if ($format == "jpg") {
					ImageJPEG($destImage, $destination, 70);
				}
				else if ($format == "gif") {
					ImageGIF($destImage, $destination);
				}
				else if ($format == "png") {
					ImagePNG($destImage, $destination);
				}
				ImageDestroy($srcImage);
				ImageDestroy($destImage);

				return "<img src='$destination' name='$name' border='0' align='$align' alt='' hspace='$espace' vspace='$espace' class='spip_logos' />";
			} else {
				$taille_origine = @getimagesize("IMG/$logo");
				if ($taille_origine) {
					// Calculer le ratio
					$srcWidth = $taille_origine[0];
					$srcHeight = $taille_origine[1];
				
					if (($srcWidth > $taille && ($axes=="both" OR $axes=="x")) OR ($srcHeight > $taille && ($axes=="both" OR $axes=="y"))) {
						$ratioWidth = $srcWidth/$taille;
						$ratioHeight = $srcHeight/$taille;
					
						if ($ratioWidth < $ratioHeight && $axes!="x") {
							$destWidth = floor($srcWidth/$ratioHeight);
							$destHeight = $taille;
						}
						else {
							$destWidth = $taille;
							$destHeight = floor($srcHeight/$ratioWidth);
						}
					} else {
						$destWidth = $srcWidth;
						$destHeight = $srcHeight;
					}
					return "<img src='IMG/$logo' name='$name' width='$destWidth' height='$destHeight' border='0' align='$align' alt='' hspace='$espace' vspace='$espace' class='spip_logos' />";
				}
			}
		}
	}
}

/***
 * renvoie vers les variantes du spikini
 ***/

function LienVariante($url) {
	return "/spikini/VarianteContrib".ucfirst($url);
}

?>
