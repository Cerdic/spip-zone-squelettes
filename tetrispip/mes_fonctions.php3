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

function tetris_x($texte,$xmax,$xsize,$xmarg){
	return $xmax*($xsize+2*$xmarg);
}
function tetris_y($texte,$ymax,$ysize,$ymarg){
	return $ymax*($ysize+2*$ymarg);
}

function tetris_style($texte,$xmax,$xsize,$xmarg,$ymax,$ysize,$ymarg){
//return $texte.','.$xmax.','.$xsize.','.$xmarg.','.$ymax.','.$ysize.','.$ymarg;
	$returned='';
	for ($i=1;$i<=$xmax;$i++){
		$returned.=".size_".$i."_full{
	width: ".(($i*$xsize)+($i-1)*2*$xmarg)."px;
	position: relative;
	margin: 0px;
}
";
		for ($j=1;$j<=$ymax;$j++){
			$returned.=".size_".$i."_".$j."{
	width: ".(($i*$xsize)+($i-1)*2*$xmarg)."px;
	height: ".(($j*$ysize)+($j-1)*2*$ymarg)."px;
	position: relative;
	margin: 0px;
}
";
			$returned.="#pos_".$i."_".$j."{
	left: ".(($i-1)*($xsize+2*$xmarg))."px;
	top: ".(($j-1)*($ysize+2*$ymarg))."px;
	position: absolute;
	margin: 0px
}
";
		}
		$returned.="#pos_right_".$i."{
	position: absolute;
	right:".$ymarg."px;
	top: ".(($i-1)*($ysize+2*$ymarg))."px;
	margin: 0px;
}
";
		$returned.=".marg_".$i."_full{
	margin-right:".(($i*$ysize)+($i-1)*2*$ymarg)."px;
	position: relative;
	padding: ".$ymarg."px ".$xmarg."px;
}
";
		$returned.=".margl_".$i."_full{
	margin-left:".(($i*$ysize)+($i-1)*2*$ymarg)."px;
	position: relative;
	padding: ".$ymarg."px ".$xmarg."px;
}
";
	}
	for ($j=1;$j<=$ymax;$j++){
		$returned.=".size_full_".$j."{
	height: ".(($j*$ysize)+($j-1)*2*$ymarg)."px;
	position: relative;
	margin: 0px;
	padding: ".$ymarg."px ".$xmarg."px;
}
";
	}
	return $returned;
}


function somme($texte,$add){
	return ($texte+$add);
}
function choixsiinferieur($a1,$a2,$v,$f) {
	return ($a1 < $a2) ? $v : $f;
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