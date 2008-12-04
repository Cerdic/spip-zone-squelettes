<?php
/*Adaptés de 
 *   +----------------------------------+
 *    Nom du Filtre :    smileys II
 *   +----------------------------------+
 *    Date : mercredi 14 octobre 2003
 *    Auteur :  BoOz (booz.bloog@laposte.net)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Dans un texte, génère automatiquement le smiley 
 *    approprié à la place d'une chaine :nom.
 *    Ce filtre utilise les icones disponibles dans       
 *    le répertoire icones/
 *    Exemple d'application :
 *    [(#TEXTE|binettes)]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=261
*/

function binettes($chaine, $arg1='') {



	$listimag=array();
	$rep1="binettes/";
	$listfich=opendir($rep1);
	while ($fich=readdir($listfich))
	{ 	if(($fich !='..') and ($fich !='.') and ($fich !='.test')
	AND preg_match(',\.(gif|jpg|png)$,', $fich))
		{ 
	$nomfich=substr($fich,0,strrpos($fich, "."));
	$listimag[$nomfich]="<img alt=\"binettes\" src=\"binettes/".$fich."\">";
		}
	}


	ksort($listimag);
	reset($listimag);

	while (list($nom,$chem) = each($listimag))
	{ 
		if ($arg1=='non')
	  $chaine = str_replace(":".$nom, $cheme , $chaine);
		else
	 $chaine = str_replace(":".$nom, $chem , $chaine);
	}

	        return $chaine;

}

?>
