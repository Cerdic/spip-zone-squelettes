<?

//Variables Globales

$GLOBALS['debut_annee_scolaire']='2008-09-01';

//Fonctions

function redu_txt2($texte,$long='30',$ligne='12')
{
  $texte = substr($texte,0,$long);
  $texte1 = wordwrap($texte, $ligne, "<br />\n");
  $texte1.="...";
  return $texte1;

}


function limit_images_size($string, $largeur_maxi=0, $hauteur_maxi=0, $with_link=0, $border=0) {

//<img src='IMG/drop-zone_city2_450.jpg' border=0 width='450' height='261' align='center' hspace='5' vspace='3'>
//$reg = "/<img src='IMG\/([^']+)' ?([^ ]+) width=[^ ]+ ?([^ ]+) height=[^ ]+ ?([^ ]+)>/";
$reg = "/<img src='IMG\/([^']+)' (.*)width='(\d+)' (.*)height='(\d+)'([^>]*)>/";

	preg_match_all ($reg, $string, $matches);
	
	
	$to_return = $string;
	for ($i=0; $i< count($matches[0]); $i++) {
		$img = $matches[1][$i];
  		$option1= $matches[2][$i];
  		$width= $matches[3][$i];
  		$option2= $matches[4][$i];
  		$height= $matches[5][$i];
  		$option3= $matches[6][$i];
		$size =  redimlogo ($img, $largeur_maxi, $hauteur_maxi);

		$before = "";
		$after = "";

		if($with_link) {
			$before = "<a href='IMG/".$img."'>";
			$after = "</a>";
		}

		$to_return = preg_replace("<".$matches[0][$i].">",
				$before."<img src='IMG/".$img."' ".$size." Style='border: ".$border."px solid #000000;'>".$after,
				$to_return,1);
	
	}	

	return $to_return;
}


function pdf_first_clean($texte) {

        $trans = get_html_translation_table(HTML_ENTITIES);
        $trans = array_flip($trans);
        $trans["<br />\n"] = "<BR>";        
        $trans["'"] = "'";
        $trans["-"] = "-";
        $trans["'"] = "'";
        $trans["&ucirc;"] = "û";
        $trans['$'] = '\$';
        $trans['->'] = '-»';
        $trans['<-'] = '«-';
        $trans["&#339;"] = "oe";
    	$trans["&#8217;"] = "'";
    	$trans["&#8211;"] = "-";
    	$trans["&#8216;"] = "'";
    	$trans["&#8220;"] = "\"";
    	$trans["&#8221;"] = "\"";

	$texte = preg_replace("/(<a href=\"article)(.*)(<\/a>)/","<a href=\"http://reseau.erasme.org/article\$2</a>",$texte);                

        $texte = strtr($texte, $trans);
        $texte = ereg_replace("\"", "\\\"", $texte);
        $texte = ereg_replace("(&nbsp;| )+", " ", $texte);


        $trans=array("\n" => '<BR>');
        while (preg_match('/(.*<textarea[^>]*>)(.*\n.*)(<\/textarea>.*)/ims', $texte, $textarea)) {
                $rep=strtr($textarea[2], $trans);
                $texte=$textarea[1].$rep.$textarea[3];
        }


	$texte = utf8_decode ($texte);

        return $texte;
}

?>
