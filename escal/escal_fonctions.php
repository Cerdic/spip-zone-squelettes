<?php

// paramètres pour le plugin diapo

//nombre de vignettes par page
$GLOBALS['diapo_vignettes']=15;

//largeur de la grande image :
$GLOBALS['diapo_grand']=400;

//largeur maxi de la photo :
$GLOBALS['diapo_petit']=300;
//hauteur maxi de la photo :
$GLOBALS['diapo_petit_h']=300;

//largeur et hauteur maxi des vignettes :
$GLOBALS['diapo_vignette']=60;

//diaporama : temps de pause en millisecondes :
$GLOBALS['diapo_temps']=3000;




// pour mettre les bonnes classes aux différents liens dans les articles
// un grand merci à l'auteur : bobof
   
function inc_lien($lien, $texte='', $class='', $title='', $hlang='', $rel='', $connect='')
{
	$mode = ($texte AND $class) ? 'url' : 'tout';
	$lien = calculer_url($lien, $texte, $mode, $connect);
	if ($mode === 'tout') {
		$texte = $lien['titre'];
		if (!$class AND isset($lien['class'])) $class = $lien['class'];
		$lang = isset($lien['lang']) ?$lien['lang'] : '';
		$lien = $lien['url'];
	}
	if (substr($lien,0,1) == '#')  # liens vers ancres pures (internes a la page)
		$class = 'spip_ancre';
	elseif (preg_match('/^\s*spip.php\?page\=/', $lien))  # liens de type page=machin
		$class = "spip_in";
	elseif (preg_match('/^\s*mailto:/',$lien)) # liens vers mail
		$class = "spip_mail";
	elseif (preg_match(',s*('._SITE.'),Ui', $lien)) # liens internes pour les sites en local et ceux installés en sous domaine comme free orange sfr 
		$class = "spip_in";
	elseif (preg_match(',('._DOMAINE.'),Ui', $lien)) # liens internes pour les sites installés en www.domaine.ltd
		$class = "spip_in";
	elseif (!$class) $class = "spip_out"; # liens externes
return inc_lien_dist($lien, $texte, $class, $titre, $hlang, $rel, $connect);
}

?>