<?php


function recuperer_variables_pagination($total, $debut, $pas, $texte) {
	return array(
		'lien_base' => $GLOBALS['clean_link']->getUrl(),
		'total' => $total,
		'position' => $GLOBALS['contexte'][$debut],
		'pas' => $pas,
		'nombre_pages' => floor(($total-1)/$pas)+1,
		'page_courante' => 
floor($GLOBALS['contexte'][$debut]/$pas)+1,
		'lien_pagination' => function_exists('lien_pagination') 
?
			lien_pagination($texte) :
			'<a href="@url@">@item@</a>'
	);
}

/*
 *   +----------------------------------+
 *    Nom du Filtre :    pagination                                               
 *   +----------------------------------+
 *    Date : dimanche 22 aout 2004
 *    Modifiee : mercredi 23 novembre 2005
 *    Auteur :  James (james<at>rezo.net)
 *    Licence : GNU/GPL
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *     affiche la liste des pages d'une boucle contenant
 *     un critÃ¨re de limite du type {debut_xxx, yyy} et depuis la 
1.8.2e
 *     du type {debut, #ENV{pas,10}}
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * inscrivez-vous et ecrivez a la liste de discussion : 
spip-zone<at>rezo.net
 * Pour les explications sur l'utilisation de ce filtre,
 * reportez-vous a l'article :
 * http://www.spip-contrib.net/Pagination,1212
*/

function pagination($total, $debut='page', $pas=10, $fonction='') {
	global $pagination_item_avant, $pagination_item_apres, 
$pagination_separateur;
	global $pagination_max, $pagination_max_texte;
	tester_variable('pagination_separateur', '&nbsp;| ');
	tester_variable('pagination_max_texte', '...');
	if(!$fonction) $fonction = 'strval';

	$pagination = recuperer_variables_pagination($total, $debut, 
$pas, 'pagination');

	if($pagination_max == 0 OR 
$pagination_max>=$pagination['nombre_pages']) {
		$premiere = 1;
		$derniere = $pagination['nombre_pages'];
		$texte_avant = '';
		$texte_apres = '';
	}
	else {
		$premiere = max(1, 
$pagination['page_courante']-floor($pagination_max/2));
		$derniere = min($pagination['nombre_pages'], 
$premiere+$pagination_max-1);
		$premiere = $derniere == $pagination['nombre_pages'] ? 
$derniere-$pagination_max+1 : $premiere;
		$texte_avant = $premiere>1 ? $pagination_max_texte.' ' : 
'';
		$texte_apres = $derniere<$pagination['nombre_pages'] ? ' 
'.$pagination_max_texte : '';
	}

	$texte = '';
	if($pagination['nombre_pages']>1) {
		$i = $premiere;
		while($i<=$derniere) {
			$url = parametre_url($pagination['lien_base'], 
$debut, strval(($i-1)*$pas));
			$_item = 
function_exists($f='pagination_'.$fonction)  ?
				$f($i, $pagination) :
				$fonction($i);
			$item = ($i != $pagination['page_courante']) ?
				preg_replace(array(',@url@,', 
',@item@,'), array($url, $_item), $pagination['lien_pagination']) :
				$_item;
			$texte .= 
$pagination_item_avant.$item.$pagination_item_apres;
			if($i<$pagination['nombre_pages']) $texte .= 
$pagination_separateur;
			$i++;
		}
		return $texte_avant.$texte.$texte_apres;
	}
	return '';
}
// FIN du Filtre pagination

/* affichage par etendue */
function pagination_etendue($i, $pagination, $texte='-') {
	return strval(($i-1)*$pagination['pas']+1) .
		$texte .
		strval(min($pagination['total'], 
$i*$pagination['pas']));
}

/* Indicateurs de position */
function pagination_sur_pages($total, $debut='page', $pas=10, 
$texte="/") {
	$pagination = recuperer_variables_pagination($total, $debut, 
$pas, 'sur_page');	
	return ($pagination['nombre_pages']>1) ?
		
$pagination['page_courante'].$texte.$pagination['nombre_pages'] :
		'';
}

function pagination_sur_total($total, $debut='page', $pas=10, 
$texte='-', $sur="/") {
	$pagination = recuperer_variables_pagination($total, $debut, 
$pas, 'sur_total');
	return ($pagination['nombre_pages']>1) ?
		($pagination['position']+1).$texte.min($total, 
$pagination['position']+$pas).$sur.$total :
		'';
}
	
function pagination_tout_voir($total, $debut='page', $pas=10, 
$texte="|&lt;&nbsp;&gt;|", $texte_retour="&gt;|&lt;", $var_pas='pas') {
	$pagination = recuperer_variables_pagination($total, $debut, 
$pas, 'tout_voir');
	$url = parametre_url($pagination['lien_base'], $debut, 
strval(0));
	$url = parametre_url($url, $var_pas, $total);
	$url_retour = parametre_url($pagination['lien_base'], $var_pas, 
'');
	return ($pagination['nombre_pages']>1) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, 
$texte), $pagination['lien_pagination']) :
		($texte_retour ?
			preg_replace(array(',@url@,', ',@item@,'), 
array($url_retour, $texte_retour), $pagination['lien_pagination']) :
			'');
}

/* liens particuliers */
function premiere_page($total, $debut='page', $pas=10, 
$texte="|&lt;&lt;") {
	$pagination = recuperer_variables_pagination($total, $debut, 
$pas, 'premiere');
	$url = parametre_url($pagination['lien_base'], $debut, 
strval(0));
	return ($pagination['nombre_pages']>1 && 
$pagination['page_courante']>1) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, 
$texte), $pagination['lien_pagination']) :
		'';
}

function page_precedente($total, $debut='page', $pas=10, $texte="&lt;") 
{
	$pagination = recuperer_variables_pagination($total, $debut, 
$pas, 'precedente');
	$precedent = $pagination['position']-$pas;
	$url = parametre_url($pagination['lien_base'], $debut, 
strval($precedent));
	return ($pagination['nombre_pages']>1 && 
$pagination['page_courante']>1) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, 
$texte), $pagination['lien_pagination']) :
		'';
}

function page_suivante($total, $debut='page', $pas=10, $texte="&gt;") {
	$pagination = recuperer_variables_pagination($total, $debut, 
$pas, 'suivante');
	$suivant = $pagination['position']+$pas;
	$url = parametre_url($pagination['lien_base'], $debut, 
strval($suivant));
	return ($pagination['nombre_pages']>1 && 
$pagination['page_courante']<$pagination['nombre_pages']) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, 
$texte), $pagination['lien_pagination']) :
		'';
}

function derniere_page($total, $debut='page', $pas=10, 
$texte="&gt;&gt;|") {
	$pagination = recuperer_variables_pagination($total, $debut, 
$pas, 'derniere');
	$dernier = ($pagination['nombre_pages']-1)*$pas;
	$url = parametre_url($pagination['lien_base'], $debut, 
strval($dernier));
	return ($pagination['nombre_pages']>1 && 
$pagination['page_courante']<$pagination['nombre_pages']) ?
		preg_replace(array(',@url@,', ',@item@,'), array($url, 
$texte), $pagination['lien_pagination']) :
		'';
}

/*
 * balise #PAGINATION{page,#ENV{pas,10}}
 */
function balise_PAGINATION_dist ($p) {
	$b = $p->nom_boucle ? $p->nom_boucle : $p->descr['id_mere'];
	if ($b === '') {
		erreur_squelette(
			_T('zbug_champ_hors_boucle',
				array('champ' => '#PAGINATION')
			), $p->id_boucle);
		$p->code = "''";
	}
	elseif (!$p->param || $p->param[0][0]) {
		erreur_squelette(
			/*_T('zbug_champ_manquant',
				array('champ' => '#PAGINATION')*/
			_L('param&eacute;tre manquant pour #PAGINATION')
			, $p->id_boucle);
		$p->code = "''";
	}
	else {
		$position =  calculer_liste($p->param[0][1],
					$p->descr,
					$p->boucles,
					$p->id_boucle);

		$pas =  calculer_liste($p->param[0][2],
					$p->descr,
					$p->boucles,
					$p->id_boucle);

		$fonction =  calculer_liste($p->param[0][3],
					$p->descr,
					$p->boucles,
					$p->id_boucle);

		// autres filtres
		array_shift($p->param);
		
		$p->boucles[$b]->numrows = true;
		$p->code = 
"pagination(\$Numrows['$b']['total'],".$position.",".$pas.",".$fonction.")";
	}

	$p->statut = 'html';
	#$p->interdire_scripts = true; //SVN
	return $p;
}



/*
 *   +----------------------------------+
 *    Nom du Filtre :    pagination                                               
 *   +----------------------------------+
 *    Date : dimanche 22 août 2004
 *    Auteur :  James (klike<at>free.fr)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *     affiche la liste des pages d'une boucle contenant
 *     un critère de limite du type {debut_xxx, yyy}
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=663
*/


function reduire_all_images($texte, $taille = 120,$axes="both") {
  //a week in seconds
  $maint_delay = 3600*24*7; 
  //retrieve last mainteinance time
  $last_maint_date=@filemtime("IMG/last_maint.txt");
  //never done mainteinance. Create last_maint file
  if (!$last_maint_date) {
    $handle=fopen("IMG/last_maint.txt","w");
    fclose($handle);
    $last_maint_date=@filemtime("IMG/last_maint.txt");
  }
  //create resized images
  //Process images with descriptions
  $texte=preg_replace("!(<table .*<div class='spip_documents'>.*)?<img [^>]*src='[^>]*IMG/[^>]*>(?(1).*</table>)!eisU","reduire_image_check('$0',$taille,$axes,$last_maint_date,$maint_delay)",$texte);
  //check last mainteinance+delay<now
  if (($last_maint_date+$maint_delay)<time()) {
    //do maint
    //clear file cache to avoid deleting just touched files
    clearstatcache();
    do_maint("IMG/gif/resized",$last_maint_date);
    do_maint("IMG/jpg/resized",$last_maint_date);
    do_maint("IMG/png/resized",$last_maint_date);
    @touch("IMG/last_maint.txt");
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
    @reset($file_array);
    while (list(,$filename)=@each($file_array)) {
      //check file time
      if (filemtime($maint_folder."/".$filename)<$last_maint_date) @unlink($maint_folder."/".$filename);
    }
  }
}

function reduire_image_check($img_code, $taille = 120,$axes="both",$last_maint_date,$maint_delay) {
  global $new_image_width;
  if (strlen($img_code) > 0) {
		if (substr($img_code,0,6)=="<table") {
      $img_code=preg_replace("!<img [^>]*src='[^>]*IMG/[^>]*>!ei","reduire_image_ex('$0',$taille,$axes,$last_maint_date,$maint_delay)",$img_code);
		  //Change table cell width value
      if ($new_image_width!=0) {
        $img_code=preg_replace("!(<td [^>]*)(width[^>]*)(>\n<div class='spip_documents'>.*</td>)!is","\\1width='$new_image_width'\\3",$img_code);  
      }
      return $img_code;
    } else return reduire_image_ex($img_code,$taille,$axes,$last_maint_date,$maint_delay);    
  }  
}

function reduire_image_ex($img, $taille = 120,$axes="both",$last_maint_date,$maint_delay) {
  global $new_image_width;
  $new_image_width=0;
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
          //store image width
          list($new_image_width)=getimagesize($imagefile);
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
					$new_image_width=$destWidth;
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
						$new_image_width=$destWidth;
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


function smileys($chaine) {

$listimag=array();
$rep1="maiis/images/smileys/";
$listfich=opendir($rep1);
while ($fich=readdir($listfich))
{ 	if(($fich !='..') and ($fich !='.') and ($fich !='.test'))
	{ 
$nomfich=substr($fich,0,strrpos($fich, "."));
$listimag[$nomfich]="<img class=\"smiley\" ALT=\"smiley\" src=\"maiis/images/smileys/".$fich."\">";
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


function paginacion($total, $position=0, $pas=1, $fonction='') {
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

// FIN du Filtre pagination
?>
