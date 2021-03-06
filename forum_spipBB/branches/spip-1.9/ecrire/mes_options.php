<?php



	$GLOBALS['champs_extra'] = Array (
		'auteurs' => Array (
		
		'Avatar' =>'ligne|propre|Avatar',
		
		)
			

		);
		
		$GLOBALS['champs_extra_proposes'] = Array (
		'auteurs' => Array (
		'tous' => 'abo',
		'inscription' => 'avatar'
	     )				
        
		);



//
// Definition des fonctions extra
//



// R�cup�ration des extra dans la base
// Retourne un tableau associatif.
// NB on retourne extra
// sous forme de tableau associatif
// Merci � Beatnick de www.spip_contrib.net

function get_extra ($id, $objet) {
	if(!$id) return false;
	// On construit qqch qui ressemble � "SELECT extra FROM spip_articles WHERE id_article=$id_article"
	$query = "SELECT statut, extra FROM spip_".$objet."s";
	$query .= " WHERE id_".$objet."=".$id;
	$res = spip_query($query);
	$cells = spip_fetch_array($res);
	
	if(!$cells["extra"]) return false ;
	$extra = unserialize ($cells["extra"]);
	return $extra;
}

// Enregistrement des extras
// On testera avec bonheur la valeur de retour
// de cette fonction lors de son appel

function set_extra ($id, $extra, $objet) {
	if(!$id) return false;
	$extra = addslashes(serialize($extra));
	// On construit qqch qui ressemble � "UPDATE spip_articles SET extra='$extra' WHERE id_article=$id_article"
	$query = "UPDATE spip_".$objet."s";
	$query .= " SET extra='$extra' ";
	$query .= " WHERE id_".$objet."=".$id;
	return spip_query($query);
}

// a partir de la liste des champs, generer la liste des input
function bloog_extra_saisie($extra, $type, $ensemble='') {
	$extra = unserialize($extra);

	// quels sont les extras de ce type d'objet
	if (!$champs = $GLOBALS['champs_extra'][$type])
		$champs = Array();

	// prendre en compte, eventuellement, les champs presents dans la base
	// mais oublies dans mes_options.
	if (is_array($extra))
		while (list($key,) = each($extra))
			if (!$champs[$key])
				$champs[$key] = "masque||($key?)";

	// quels sont les extras proposes...
	// ... si l'ensemble est connu
	if ($ensemble && isset($GLOBALS['champs_extra_proposes'][$type][$ensemble]))
		$champs_proposes = explode('|', $GLOBALS['champs_extra_proposes'][$type][$ensemble]);
	// ... sinon, les champs proposes par defaut
	else if (isset($GLOBALS['champs_extra_proposes'][$type]['tous'])) {
		$champs_proposes = explode('|', $GLOBALS['champs_extra_proposes'][$type]['tous']);
	}

	// sinon tous les champs extra du type
	else {
		$champs_proposes =  Array();
		reset($champs);
		while (list($ch, ) = each($champs)) $champs_proposes[] = $ch;
	}

	// bug explode
	if($champs_proposes == explode('|', '')) $champs_proposes = Array();

	// maintenant, on affiche les formulaires pour les champs renseignes dans $extra
	// et pour les champs proposes
	reset($champs_proposes);
	while (list(, $champ) = each($champs_proposes)) {
		$desc = $champs[$champ];
		list($form, $filtre, $prettyname, $choix, $valeurs) = explode("|", $desc);

		if (!$prettyname) $prettyname = ucfirst($champ);
		$affiche .= "<b>$prettyname&nbsp;:</b><br />";

		switch($form) {

			case "case":
			case "checkbox":
				$affiche = ereg_replace("<br />$", "&nbsp;", $affiche);
				$affiche .= "<INPUT TYPE='checkbox' NAME='suppl_$champ'";
				if ($extra[$champ] == 'true')
					$affiche .= " CHECKED ";
				break;

			case "list":
			case "liste":
			case "select":
				$choix = explode(",",$choix);
				if (!is_array($choix)) {
					$affiche .= "Pas de choix d&eacute;finis.\n";
					break;
				}

				// prendre en compte les valeurs des champs
				// si elles sont renseignees
				$valeurs = explode(",",$valeurs);
				if($valeurs == explode(",",""))
					$valeurs = $choix ;

				$affiche .= "<select name='suppl_$champ' ";
				$affiche .= "class='forml'>\n";
				$i = 0 ;
				while (list(, $choix_) = each($choix)) {
					$val = $valeurs[$i] ;
					$affiche .= "<option value=\"$val\"";
					if ($val == entites_html($extra[$champ]))
						$affiche .= " selected='selected'";
					$affiche .= ">$choix_</option>\n";
					$i++;
				}
				$affiche .= "</select>";
				break;

			case "radio":
				$choix = explode(",",$choix);
				if (!is_array($choix)) {
					$affiche .= "Pas de choix d&eacute;finis.\n";
					break;
				}
				$valeurs = explode(",",$valeurs);
				if($valeurs == explode(",",""))
					$valeurs = $choix ;

				$i=0;
				while (list(, $choix_) = each($choix)) {
					$affiche .= "<input type='radio' name='suppl_$champ' ";
					$val = $valeurs[$i] ;
					if (entites_html($extra["$champ"])== $val)
						$affiche .= " checked='checked'";

					// premiere valeur par defaut
					if (!$extra["$champ"] AND $i == 0)
						$affiche .= " checked='checked'";

					$affiche .= " value='$val'>$choix_</input><br>";
					$i++;
				}
				break;

			// A refaire car on a pas besoin de renvoyer comme pour checkbox
			// les cases non cochees
			case "multiple":
				$choix = explode(",",$choix);
				if (!is_array($choix)) {
					$affiche .= "Pas de choix d&eacute;finis.\n";
					break; }
				for ($i=0; $i < count($choix); $i++) {
					$affiche .= "<input type='checkbox' name='suppl_$champ$i'";
					if (entites_html($extra["$champ"][$i])=="on")
						$affiche .= " checked='checked'";
					$affiche .= ">\n";
					$affiche .= $choix[$i];
					$affiche .= "</input>\n";
				}
				break;

			case "bloc":
			case "block":
				$affiche .= "<textarea name='suppl_$champ' class='forml' rows='5' cols='40'>".entites_html($extra[$champ])."</textarea>\n";
				break;

			case "masque":
				$affiche .= "<font color='#555555'>".interdire_scripts($extra[$champ])."</font>\n";
				break;

			case "ligne":
			case "line":
			default:
				$affiche .= "<input type='text' name='suppl_$champ' class='forml'\n";
				$affiche .= " value=\"".entites_html($extra[$champ])."\" SIZE='40' />\n";
				break;
		}

		$affiche .= "<p>\n";
	}

	if ($affiche) {
               	echo" <div align='left'>";
		echo $affiche;
		echo"</div>";

	}
}

// recupere les valeurs postees pour reconstituer l'extra
function bloog_extra_recup_saisie($type) {
	$champs = $GLOBALS['champs_extra'][$type];
	if (is_array($champs)) {
		$extra = Array();
		while(list($champ,)=each($champs)) {
			list($style, $filtre, , $choix,) = explode("|", $GLOBALS['champs_extra'][$type][$champ]);
			list(, $filtre) = explode(",", $filtre);
			switch ($style) {
			case "multiple":
				$choix =  explode(",", $choix);
				$extra["$champ"] = array();
				for ($i=0; $i < count($choix); $i++) {
					if ($filtre && function_exists($filtre))
						 $extra["$champ"][$i] =
						 	$filtre($GLOBALS["suppl_$champ$i"]);
					else
						$extra["$champ"][$i] = $GLOBALS["suppl_$champ$i"];
				}
				break;

			case 'case':
			case 'checkbox':
				if ($GLOBALS["suppl_$champ"] == 'on')
					$GLOBALS["suppl_$champ"] = 'true';
				else
					$GLOBALS["suppl_$champ"] = 'false';

			default:
				if ($filtre && function_exists($filtre))
				$extra["$champ"]=$filtre($GLOBALS["suppl_$champ"]);
				else $extra["$champ"]=$GLOBALS["suppl_$champ"];
				break;
			}
		}
		return serialize($extra);
	} else
		return '';
}

// Verifier la conformite d'une ou plusieurs adresses email
function email_valide_bloog($adresse) {
	$adresses = explode(',', $adresse);
	if (is_array($adresses)) {
		while (list(, $adresse) = each($adresses)) {
			// nettoyer certains formats
			// "Marie Toto <Marie@toto.com>"
			$adresse = eregi_replace("^[^<>\"]*<([^<>\"]+)>$", "\\1", $adresse);
			// pas RFC 822  mais un truc plus restrictif pour les bounces
			if (!eregi('^[_\.0-9a-z-]+@([0-9a-z-]+\.)+[a-z]{2,4}$', trim($adresse)))
				return false;
		}
		return true;
	}
	return false;
}

?>