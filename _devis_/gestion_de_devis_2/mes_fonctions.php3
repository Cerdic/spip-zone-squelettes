<?
/***************************************************************************\
 * Pour tester la nouvelle fonction de champs homonymes                    *
 * Après avoir ajouté dans le fichier                                      *
 * la nouvelle fonction  extra_homonyme()                                  *
 * modifier la fonction  la fonction extra_homonyme()                      *
 * modifier le fichier mot_edit.php3                                       *
 * Il est possible de tester les champs homonymes.                         *
 *                                                                         *
 * Pour utiliser les fichier de test homonymes_plus.php3/html              *
 * et homonymes_test.php3/html                                             *
 * il faut ajouter dans mes_options.php3 les modifications proposées       *
 * ainsi que celles proposé à ajouter dans le fichier  mes_fonctions.php3  *
 *                                                                         *
 * Pour plus de détails voir:                                              *
 * https://contrib.spip.net/ecrire/articles.php3?id_article=1080        * 
 * ou communiquer avec                                                     *
 * francois.vachon@iago.ca                                                 *
\***************************************************************************/
include ('ecrire/inc_serialbase.php3');
global $tables_principales;
$tables_principales['spip_articles']['field']['unitaire']= "text NOT NULL DEFAULT ''";
$tables_principales['spip_articles']['field']['lot']= "text NOT NULL DEFAULT ''";

/*////// FONCTION DE CALCUL DU SEPARATEUR DES PRIX ////*/

function format_number($str,$decimal_places='2',$decimal_padding="0"){
       /* firstly format number and shorten any extra decimal places */
       /* Note this will round off the number pre-format $str if you dont want this fucntionality */
       $str          =  number_format($str,$decimal_places,'.','');    // will return 12345.67
       $number      = explode('.',$str);
       $number[1]    = (isset($number[1]))?$number[1]:''; // to fix the PHP Notice error if str does not contain a decimal placing.
       $decimal    = str_pad($number[1],$decimal_places,$decimal_padding);
       return (float) $number[0].'.'.$decimal;
}

/* examples
format_number('1234');      // -->  1234.00
format_number('1234.5');    //-->  1234.50
format_number('1234.567');  //-->  1234.57
*/

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



?>
