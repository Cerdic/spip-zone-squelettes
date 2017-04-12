<?php

/**
 * Retirer les elements paragraphes d'un texte
 * @author Christian Paulus
 * @version 20120201
 */
function deparagrapher ($texte)
{
    $texte = trim ($texte);
    if (substr ($texte, 0, 3) == '<p>')
    {
        $texte = substr ($texte, 3);
        if (substr ($texte, -4) == '</p>')
        {
            $texte = substr ($texte, 0, strlen ($texte) - 4);
        }
    }
    return ($texte);
}


// #lesmots
// les mots d'un objet
// http://www.spip.net/fr_article902.html
// http://www.spip.net/fr_article911.html
// http://code.spip.net/@balise_lesmots_dist
function balise_lesmots_dist ($p) {
	// Cherche le champ 'lesmots' dans la pile
	$_lesmots = champ_sql('lesmots', $p, false);

	// Si le champ n'existe pas (cas de spip_articles), on applique
	// le modele lesmots.html en passant id_article dans le contexte;
	// dans le cas contraire on prend le champ 'lesmots'
	// (cf extension sites/)
	if ($_lesmots
	AND $_lesmots != '@$Pile[0][\'lesmots\']') {
		$p->code = "safehtml($_lesmots)";
		// $p->interdire_scripts = true;
	} else {
		if(!$p->id_boucle){
			$connect = '';
			$objet = 'article';
			$id_table_objet = 'id_article';
		}
		else{
			$b = $p->nom_boucle ? $p->nom_boucle : $p->id_boucle;
			$connect = $p->boucles[$b]->sql_serveur;
			$type_boucle = $p->boucles[$b]->type_requete;
			$objet = objet_type($type_boucle);
			$id_table_objet = id_table_objet($type_boucle);
		}
		$c = memoriser_contexte_compil($p);

		$p->code = sprintf(CODE_RECUPERER_FOND, "'modeles/lesmots'",
				   "array('objet'=>'".$objet.
					   "','id_objet' => ".champ_sql($id_table_objet, $p) .
					   ",'$id_table_objet' => ".champ_sql($id_table_objet, $p) .
					   ($objet=='article'?"":",'id_article' => ".champ_sql('id_article', $p)).
					   ")",
				   "'trim'=>true, 'compil'=>array($c)",
				   _q($connect));
		$p->interdire_scripts = false; // securite apposee par recuperer_fond()
	}
	return $p;
}

// #lescommunes
// les communes d'un objet
function balise_lescommunes_dist ($p) {
	// Cherche le champ 'lescommunes' dans la pile
	$_lescommunes = champ_sql('lescommunes', $p, false);

	// Si le champ n'existe pas (cas de spip_articles), on applique
	// le modele lescommunes.html en passant id_article dans le contexte;
	// dans le cas contraire on prend le champ 'lescommunes'
	// (cf extension sites/)
	if ($_lescommunes
	AND $_lescommunes != '@$Pile[0][\'lescommunes\']') {
		$p->code = "safehtml($_lescommunes)";
		// $p->interdire_scripts = true;
	} else {
		if(!$p->id_boucle){
			$connect = '';
			$objet = 'article';
			$id_table_objet = 'id_article';
		}
		else{
			$b = $p->nom_boucle ? $p->nom_boucle : $p->id_boucle;
			$connect = $p->boucles[$b]->sql_serveur;
			$type_boucle = $p->boucles[$b]->type_requete;
			$objet = objet_type($type_boucle);
			$id_table_objet = id_table_objet($type_boucle);
		}
		$c = memoriser_contexte_compil($p);

		$p->code = sprintf(CODE_RECUPERER_FOND, "'modeles/lescommunes'",
				   "array('objet'=>'".$objet.
					   "','id_objet' => ".champ_sql($id_table_objet, $p) .
					   ",'$id_table_objet' => ".champ_sql($id_table_objet, $p) .
					   ($objet=='article'?"":",'id_article' => ".champ_sql('id_article', $p)).
					   ")",
				   "'trim'=>true, 'compil'=>array($c)",
				   _q($connect));
		$p->interdire_scripts = false; // securite apposee par recuperer_fond()
	}
	return $p;
}

function mini_html($texte) {
   $texte = preg_replace("/\s{128,}/"," ", $texte);
   return $texte;
}

function minisauvage_html($texte) {
   $texte = preg_replace(",\s+,"," ", $texte);    
   $texte = preg_replace(",\n[\n\t\s]*,", "\n", $texte);
   return $texte;
}

?>