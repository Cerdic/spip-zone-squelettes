<?php

$GLOBALS[ 'dossier_squelettes' ] = "blip" ;



/*
 *   +----------------------------------+
 *    Nom du Filtre :    smileys II
 *   +----------------------------------+
 *    Date : mercredi 14 octobre 2003
 *    Auteur :  BoOz (booz.bloog@laposte.net)
 *    Modifié par Vincent ROBERT pour le squelette BLIP
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Dans un texte, genere automatiquement le smiley 
 *    approprie a la place d'une chaine :nom.
 *    Ce filtre utilise les smileys disponibles dans       
 *    le repertoire smileys/
 *    Exemple d'application :
 *    [(#TEXTE|smileys)]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=261
*/

function smileys($chaine) {
	$listimag = array() ;
	$repertoire = $GLOBALS[ 'dossier_squelettes' ] . "/smileys/" ;
	$listfich = opendir($repertoire) ;
	while ( $fich = readdir($listfich) ) {
		if( ( $fich != '..' ) and ( $fich != '.' ) and ( $fich != '.DS_Store' ) ) { 
			$nomfich = substr($fich,0,strrpos($fich, ".")) ;
			$listimag[$nomfich] = '<img class="smiley" alt="smiley" src="' . $repertoire . '' . $fich . '" />' ;
		}
	}
	ksort($listimag) ;
	reset($listimag) ;
	while ( list($nom,$chem) = each($listimag) ) { 
		$chaine = str_replace(":".$nom, $chem , $chaine) ;
	}
	return $chaine;
}

function google_like($string) {
	$query = rtrim(str_replace("+", " ", $_GET['recherche']));
	$qt = explode(" ", $query);
	$num = count ($qt);
	$cc = ceil(200 /$num);
	for ($i = 0; $i < $num; $i++) {
		$tab[$i] = preg_split("/($qt[$i])/i",$string,2, PREG_SPLIT_DELIM_CAPTURE);
		if(count($tab[$i])>1) {
			$avant[$i] = substr($tab[$i][0],-$cc,$cc);
			$apres[$i] = substr($tab[$i][2],0,$cc);
			$string_re .= "<i>[...]</i> $avant[$i]<b>".$tab[$i][1]."</b>$apres[$i] <i>[...]</i>  ";
		}
	}
	return $string_re;
}

function pagination($total, $position=0, $pas=10) {
	global $clean_link;

	if (ereg('^debut([-_a-zA-Z0-9]+)$', $position, $match)) {
		$debut_lim = "debut".$match[1];
		$position = intval($GLOBALS['HTTP_GET_VARS'][$debut_lim]);
	}

	$nombre_pages = floor(($total-1)/$pas)+1;
	$texte = '<div class="bouton">';
	if($nombre_pages>1) {
		$i = 0;
#		if ($position>1)
#			$texte .= '<a href=\"\"><:page_precedente:></a>&nbsp;' ;
		while($i<$nombre_pages) {
			$clean_link->delVar($debut_lim);
			$clean_link->addVar($debut_lim, strval($i*$pas));
			$url = $clean_link->getUrl();
			$item = strval($i+1);
			if(($i*$pas) != $position)
				$texte .= "<a href=\"".$url."\">".$item."</a>&nbsp;";
			else
				$texte .= "<span class=\"bouton_off\">".$item."</span>&nbsp;";
			$i++;
		}
		$clean_link->delVar($debut_lim);
		if($position)
			$clean_link->addVar($debut_lim, $position);
#		if($i==($nombre_pages-1))
#			$texte .= '<a href=\"\"><:page_suivante:></a>&nbsp;' ;
		$texte .= '</div>' ;
		return $texte;
	}
	return '';
}

function flashmp3($texte) {
$texte = preg_replace("'<flashmp3=([^\]>]+)>([^\[]+)<\/flashmp3>'Ui",'<br><br><object 
type="application/x-shockwave-flash" data="IMG/mp3/dewplayer.swf?son=IMG/mp3/\\1" width="200" 
height="20"><param name="movie" value="IMG/mp3/dewplayer.swf?son=IMG/mp3/\\1"></object><span 
valign="middle"><br>\\2</span>',$texte);
return $texte;
}
;

?>