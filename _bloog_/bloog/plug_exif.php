<?php

function verifier_JPG_TIFF($id_document) {
  	if ($id_document > 0) {
		$query = "SELECT id_type FROM spip_documents WHERE id_document = $id_document";
		$result = spip_query($query);
		if ($row = spip_fetch_array($result)) {
			$id_type = $row['id_type'];
		}
	}
	return (($id_type==1) || ($id_type==6));
}

function tag_exif($url_document,$section='',$tag='') {
  $to_ret = '';
  static $last_url;
  static $last_exif;

  if($last_url == $url_document) {
	$exif = $last_exif;
  } else {
	$exif = $last_exif =  @exif_read_data($url_document, 0, true);
	$last_url = $url_document;
  }

  if($exif) {
	if(($section != '') && ($tag != '')) {
	  $to_ret = $exif[$section][$tag];
	} else if($section) {
	  if($exif[$section]) {
		foreach ($exif[$section] as $name => $val) {
		  $to_ret .= "<B>$section.$name</B>: $val<br />\n";
		}
	  }
	} else {
	  foreach ($exif as $key => $section) {
		foreach ($section as $name => $val) {
		  $to_ret .= "<B>$key.$name</B>: $val<br />\n";
		}
	  }
	}
  }
  return $to_ret;
}

function balise_EXIF($params) {

  if ($a = $params->param) {
	$sinon = array_shift($a);
	if  (!array_shift($sinon)) {
	  $params->fonctions = $a;
	  array_shift( $params->param );
	  $section = array_shift($sinon);
	  $section = ($section[0]->type=='texte') ? $section[0]->texte : '';
	  $tag = array_shift($sinon);
	  $tag = ($tag[0]->type=='texte') ? $tag[0]->texte : '';
	}
  }

  //  list($section,$tag) = split(',',param_balise($params));

  $section = addslashes($section);
  $tag = addslashes($tag);

  $id_doc = champ_sql('id_document', $params);

  $params->code = "(verifier_JPG_TIFF($id_doc))?(tag_exif(generer_url_document($id_doc),'$section','$tag')):''";
  $params->type = 'php';
  
  return $params;
}

function generer_url_logo_EXIF($filename) {

  $thumbname = substr($filename,0,-4).".exif.jpg";

  if(file_exists($thumbname)) {
	return $thumbname;
  }

  $image = exif_thumbnail($filename);
  if ($image!==false) {
	$handle = fopen ($thumbname, 'a');
	fwrite($handle, $image);
	fclose($handle);
	return $thumbname;
  }
  
  return '';

}

function generer_html_logo_EXIF($url_doc,$code_lien='',$align='') {

  if($code_lien) {
	$code = "<a href=\"$code_lien\">";
  }

  $code .= "<IMG src=\"$url_doc\"".(($align)?"align=$align":'').">";
  if($code_lien) {
	$code .= "</a>";
  }

  return $code;
}

function balise_LOGO_EXIF($p) {

  // analyser les filtres
  // analyser les faux filtres, 
  // supprimer ceux qui ont le tort d'etre vrais
  $flag_fichier = 0;
  $filtres = '';
  if (is_array($p->fonctions)) {
	foreach($p->fonctions as $couple) {
	  // eliminer les faux filtres
	  if (!$flag_stop) {
		array_shift($p->param);
		$nom = $couple[0];
		if (ereg('^(left|right|center|top|bottom)$', $nom))
		  $align = $nom;
		else if ($nom == 'lien') {
		  $flag_lien_auto = 'oui';
		  $flag_stop = true;
		}
		else if ($nom == 'fichier') {
		  $flag_fichier = 1;
					$flag_stop = true;
		}
		// double || signifie "on passe aux filtres"
		else if ($nom == '') {
		  if (!$params = $couple[1])
			$flag_stop = true;
		}
		else if ($nom) {
		  $lien = $nom;
		  $flag_stop = true;
		} else {
		  
		}
	  }
	  // apres un URL ou || ou |fichier ce sont
	  // des filtres (sauf left...lien...fichier)
	}
  }
  
  $id_doc = champ_sql('id_document', $p);
  $code_lien = '';

  $url_doc = "(verifier_JPG_TIFF($id_doc))?(generer_url_logo_EXIF(generer_url_document($id_doc))):''";


  //
  // Preparer le code du lien
  //
  // 1. filtre |lien
  if ($flag_lien_auto AND !$lien) {
	$code_lien = "$url_doc";
  } else if ($lien) {
	// 2. lien indique en clair (avec des balises : imprimer#ID_ARTICLE.html)
	$code_lien = "'".texte_script(trim($lien))."'";
		while (ereg("^([^#]*)#([A-Za-z_]+)(.*)$", $code_lien, $match)) {
			$c = new Champ();
			$c->nom_champ = $match[2];
			$c->id_boucle = $p->id_boucle;
			$c->boucles = &$p->boucles;
			$c->descr = $p->descr;
			$c = calculer_champ($c);
			$code_lien = str_replace('#'.$match[2], "'.".$c.".'", $code_lien);
		}
		// supprimer les '' disgracieux
		$code_lien = ereg_replace("^''\.|\.''$", "", $code_lien);
	  }
  
  if($flag_fichier) {
	$p->code = "ereg_replace(\"^IMG/\",\"\",$url_doc)";
	$p->type = 'php';
	return $p;
  }
  
  if(!$code_lien)
	$code_lien = "''";
  
  
  if(!$align)
	$align = "''";
  
  $p->code = "generer_html_logo_EXIF($url_doc,$code_lien,$align)";
  $p->type = 'php';
  return $p;
}
function date_EXIF2SPIP($date) {
  return preg_replace('/^([0-9]*):([0-9]*):([0-9]*) /','\1-\2-\3 ',$date);}
?>