<?php


function extraire_numero($titre) {
	
	if (ereg("^([0-9]+)\.", $titre, $regs)) return $regs[1];
	
}


function image_titre_article ($titre, $couleur) {


	if (mb_strlen($titre) < 25) $police = "HelveNeuHeaConObl.ttf";
	else $police = "HelveNeuMedCon.ttf";
	
//	$police= "TheMixArab.ttf";
//	$police = "fedra.ttf";
//	$police = "vesta.ttf";
//	$police = "sadab.ttf";
//	$police = "fresco.ttf";
//	$police = "Homa.ttf";
//	$police = "Farnaz.ttf";
//	$police = "Sina.ttf";
//	$police = "Tabassom.ttf";
//	$police = "Traffic.ttf";
//	$police = "Sara.ttf";
//	$police = "MDaira.ttf";
//	$police = "Ptbldhad.ttf";

	$titre = mb_strtoupper($titre);
	$titre = str_replace("&NBSP;", "&nbsp;", $titre);
	
	$titre = image_typo($titre, "couleur=888888", "police=$police", "taille=54px", "largeur=1300", "padding=14");
	$titre = image_reduire_par($titre, 2);
	
	$titre2 = $titre;
	$titre2 = image_gamma($titre2, -125);
	$titre2 = image_flou($titre2, 4);
	$titre2 = image_alpha($titre2, 60);
	$titre2 = image_aplatir($titre2, "png", "666666");
	
//	$masque = image_sepia("squelettes/masques/masque-titre.png", $couleur);
	
	$titre = image_masque($titre, "squelettes/masques/masque-titre.png");
	
	$titre = image_masque($titre2, extraire_attribut($titre,"src"), "mode=normal", "top=1", "left=1");
	
	$titre = image_aplatir($titre, "gif", "ffffff");
	
	return $titre;

}

function image_petit_titre_article ($titre, $couleur) {

	$titre = mb_strtoupper($titre);
	$titre = str_replace("&NBSP;", "&nbsp;", $titre);
	
	$titre = image_typo($titre, "couleur=888888", "police=HelveNeuHeaConObl.ttf", "taille=54px", "largeur=2000", "padding=14");
	$titre = image_reduire_par($titre, 5);
	
	$titre2 = $titre;
	$titre2 = image_gamma($titre2, -125);
	$titre2 = image_flou($titre2, 4);
	$titre2 = image_alpha($titre2, 60);
	$titre2 = image_aplatir($titre2, "png", $couleur);
	
//	$masque = image_sepia("squelettes/masques/masque-titre.png", $couleur);
	
	$titre = image_masque($titre, "squelettes/masques/masque-titre.png");
	
	$titre = image_masque($titre2, extraire_attribut($titre,"src"), "mode=normal", "top=1", "left=1");
	
	$titre = image_aplatir($titre, "gif", $couleur);
	
	return $titre;

}




function plugin_extraire ($xml, $string) {

	if (ereg("<$string>(.*)</$string>", $xml, $regs)) {
		return $regs[1];
	}
}


function creer_petition ($id_article) {
	$query = sql_query("SELECT id_article FROM spip_petitions WHERE id_article=$id_article");
	if ($row = sql_fetch($query)) return ;
	else {
			sql_insertq("spip_petitions", array('id_article' => $id_article, 'email_unique'=>'non', 'site_obli'=>'oui', 'site_unique' => 'oui', 'message'=>'non'));

	}
}

function extraire_lien ($texte) {

	if (preg_match("/a href=&quot;(.*)&quot;/U", $texte, $regs)) {
		return $regs[1];
	} else if (preg_match("/a href=[\"\'](.*)[\"\']/U", $texte, $regs)) {
		return $regs[1];	
	} else {
		return $texte;
	}
}


function stocker_signature($id, $pr) {
	global $st_signatures;
	
	$pr = round($pr);
	
	$st_signatures["$pr"][] = $id;
	
	/*
	echo "<hr>";
	echo "<pre>";
	print_r ($st_signatures);
	
	echo "</pre>";
	*/

}

function liste_signatures ($rien = "") {
	global $st_signatures;
	
	for ($pr = 10; $pr >= 0; $pr--) {
		if (isset($st_signatures["$pr"])) {
			$ret [] = $st_signatures["$pr"];
		}
	}
	
	return $ret;
}


function calculer_animate ($num) {
	return ($num-1)*(-440);
}

?>