<?php

// Balise pour afficher la version de SPIP en cours sur votre site
// Contrib de Scoty : http://www.koakidi.com/
// voir : https://contrib.spip.net/Collection-de-Balises
function balise_VERSION_SPIP_AFFICHEE($p) {
        $p->code = "'".$GLOBALS['spip_version_affichee']."'";
        $p->statut = 'php';
        return $p;
}


/*
 *   +----------------------------------+
 *    Nom du Filtre : Sommaire de l'article                                               
 *   +----------------------------------+
 *    Date : Vendredi 6 juin 2003
 *    Auteur :  Noplay (noplay@altern.org) 
 *              Aurélien PIERARD : aurelien.pierard@sig.premier-ministre.gouv.fr                                     
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *      Cette modification permet d'afficher le sommaire de l'article 
 *      généré dynamiquement à partir des intertitres du texte de l'article. 
 *		Vous pouvez naviguer dans l'article en cliquant sur les intitres 
 *      du sommaire de l'article. 
 *
 *      Tout ce qui ce trouve entre {{{ et }}} est considéré comme un titre 
 *      à ajouter au sommaire de l'article.
 *   +-------------------------------------+ 
 *  
 * 		Pour toute suggestion, remarque, proposition d'ajout
 * 		reportez-vous au forum de l'article :
 * 		http://spip_contrib.net/article.php3?id_article=76
*/
//SOMMAIRE
function sommaire_article($texte)
{
		$artsuite = 0;
        $page = split('-----', $texte);
        $uri_art = generer_url_article($GLOBALS['id_article']);
        $uri_art .= strpos($uri_art, '?') ? '&' : '?';

	$i=0;
	$texte="";
	while($page[$i]){
		// On ajoute une ancre aux intertitres "{{{ }}}" que l'on utilise pour créer le sommaire
		preg_match_all("|\{\{\{(.*)\}\}\}|U",$page[$i], $regs);
	 	$nb=1;
		for($j=0;$j<count($regs[1]);$j++){
			$p=$i+1;
	    	$texte=$texte."<li><a href=\"". $uri_art . "artsuite=" .$i. "#sommaire_".$nb."\" title=\"".$regs[1][$j]."\">".$regs[1][$j]."</a>,&nbsp;p$p</li>\n";
			$nb++;
	    }
		$i++;
	}
		if (empty($texte)) $texte="";
		else $texte="<ul>\n".$texte."</ul>\n";
		return $texte;
}
// Fin du filtre sommaire

/*
 *   +----------------------------------+
 *    Nom du Filtre : decouper_en_page                                               
 *   +----------------------------------+
 *    Date : Vendredi 6 juin 2003
 *    Auteur :  "gpl"  : gpl@macplus.org  
 *              Aurélien PIERARD : aurelien.pierard@sig.premier-ministre.gouv.fr
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *		Il sert a présenter un article sur plusieurs pages  
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=62
*/


function decouper_en_page($texte,$id_article) {
        global $artsuite, $var_recherche, $num_pages;
		
        if (empty($artsuite)) $artsuite = 0;
	
		// on divise la page (séparateur : "-----")        
        $page = split('-----', $texte);
        // Nombre total de pages
        $num_pages = count($page);

        // Si une seule page ou numéro illégal, alors retourner tout le texte.
        // Cas spécial : si var_recherche positionné, tout renvoyer pour permettre à la surbrillance de fonctionner correctement.
        if ($num_pages == 1 || !empty($var_recherche) || $artsuite < 0 || $artsuite > $num_pages) {
			// On place les ancres sur les intertitres
			$texte = preg_replace("|\{\{\{(.*)\}\}\}|U","<a id=\"sommaire_#NB_TITRE_DE_MON_ARTICLE#\"></a>$0", $texte);
			$array = explode("#NB_TITRE_DE_MON_ARTICLE#" , $texte);
			$res =count($array);
			$i =1;
			$texte=$array[0];
			while($i<$res){
				$texte=$texte.$i.$array[$i];
				$i++;
			}
			return $texte;
        } 

        $p_prec = $artsuite - 1;
        $p_suiv = $artsuite + 1;
        $uri_art = generer_url_article($id_article);
        $uri_art .= strpos($uri_art, '?') ? '&' : '?';

		// On place les ancres sur les intertitres
		$page[$artsuite] = preg_replace("|\{\{\{(.*)\}\}\}|U","<a id=\"sommaire_#NB_TITRE_DE_MON_ARTICLE#\"></a>$0", $page[$artsuite]);
		$array = explode("#NB_TITRE_DE_MON_ARTICLE#" , $page[$artsuite]);
		$res =count($array);
		$i =1;
		$page[$artsuite]=$array[0];
		while($i<$res){
			$page[$artsuite]=$page[$artsuite].$i.$array[$i];
			$i++;
		}
		// Pagination
	    switch (TRUE) {
			case ($artsuite == 0):
				$precedent = "";
				$suivant = "<a href='" . $uri_art . "artsuite=" . $p_suiv . "'>&gt;&gt;</a>";
				break;
			case ($artsuite == ($num_pages-1)):
				$precedent = "<a href='" . $uri_art . "artsuite=" . $p_prec . "'>&lt;&lt;</a>";
				$suivant = "";
				break;
			default:
				$precedent = "<a href='" . $uri_art . "artsuite=" . $p_prec . "'>&lt;&lt;</a>";
				$suivant = "<a href='" . $uri_art . "artsuite=" . $p_suiv . "'>&gt;&gt;</a>";
				break;
        }
    
        for ($i = 0; $i < $num_pages; $i++) {
			$j = $i;
			if ($i == $artsuite) {
				$milieu .= " <strong>" . ++$j . "</strong> ";
            } 
			else {
				$milieu .= " <a href='" . $uri_art . "artsuite=$i'>" . ++$j . "</a> ";
			}
        }

        // Ici, on peut personnaliser la présentation
        $resultat .= $page[$artsuite];
        $resultat .= "<div class='pagination' style='text-align:center'>pages : $precedent $milieu $suivant</div>";
        return $resultat;
}
// FIN du Filtre decouper_en_page



?>