<?php
include_ecrire("inc_extra.php3");
function sq_style($id,$le_dossier_squelettes,$param) {
	//spip_log($le_dossier_squelettes."-".$GLOBALS['dossier_template']."/conf/style_xxx.php3");
	include($le_dossier_squelettes."/conf/style_couleurs.php3");
	include($le_dossier_squelettes."/conf/style_taille_police.php3");
	$str="\$returned=\$".$param."['".$id."'];";
	//spip_log("!".$str);
	$returned="?";
	eval($str);
	//spip_log("!".$returned);
	return $returned;
}

function somme($texte,$add){
	return ($texte+$add);
}
function choixsiinferieur($a1,$a2,$v,$f) {
	return ($a1 < $a2) ? $v : $f;
}

function abonnement($texte){
	$tab=explode("_",$texte);
	return $tab[2];
}
function abonnement_debut($texte){
	$tab=explode("_",$texte);
	$returned=date('Y-m-d H:i:s',mktime(0,0,0,$tab[1],1,$tab[0]));
	return $returned;
}
function abonnement_fin($texte){
	$tab=explode("_",$texte);
	$returned=date('Y-m-d H:i:s',mktime(0,0,0,($tab[1]+1),1,$tab[0]));
	return $returned;
}

function ajoute($txt,$offset=1){
	global $mini_compteur;
	if (!isset($mini_compteur))$mini_compteur=0;
	$mini_compteur+=$offset;
	return $mini_compteur;
}

function plus($txt,$offset=1){
	global $mini_compteur;
	if (!isset($mini_compteur))return $offset;
	return ($mini_compteur+$offset);
}

function guiPos ($compteur, $offset){
	return $offset+$compteur*20;
}

function url ($url){
	list(,$url) = extraire_lien(array('','','',$url));
	return $url;
}
function nl($texte){
    $texte = eregi_replace("__bLg__[0-9@\.A-Z_-]+__bLg__","</head><body id=\"top\" dir=\"ltr\">",$texte);
	return $texte;
}
function current_date($texte){
	return date('Y-m-d');
}

/////////////////////////////////////////
/// Filtre reserve a la production de PDF
/////////////////////////////////////////
function pdf_first_clean($texte) {
		  
 	// $texte = ereg_replace("<p class[^>]*>", "<P>", $texte);

	//Translation des codes iso
	
	// PB avec l'utilisation de <code>
    // $trans = get_html_translation_table(HTML_ENTITIES);
    // $trans = array_flip($trans);
	$trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    $trans["<br />\n"] = "<BR>";
    $trans["&#339;"] = "oe";
    $trans["&#8230;"] = "...";
    $trans["&#8217;"] = "'";
    $trans["&#8211;"] = "-";
    $trans["&#8216;"] = "'";
    $trans["&#8220;"] = "\"";
    $trans["&#8221;"] = "\"";
	$trans["&ucirc;"] = "û";
	
    $texte = strtr($texte, $trans);
  		
	// Echappement des "
  	$texte = ereg_replace("\"", "\\\"", $texte);
 
  	// Traitement des Espaces
 	$texte = ereg_replace("(&nbsp;| )+", " ", $texte);
 
 	return $texte;
}
/////////////////////////////////////////
//////////////////////////
?>