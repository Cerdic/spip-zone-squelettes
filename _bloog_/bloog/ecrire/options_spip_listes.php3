<?php

/******************************************************************************************/
/* SPIP-listes est un système de gestion de listes d'information par email pour SPIP      */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique Générale GNU publiée par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU  */
/* pour plus de détails.                                                                  */
/*                                                                                        */
/* Vous devez avoir reçu une copie de la Licence Publique Générale GNU                    */
/* en même temps que ce programme ; si ce n'est pas le cas, écrivez à la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, États-Unis.                   */
/******************************************************************************************/


//
// Definition des fonctions extra
//



// Récupération des extra dans la base
// Retourne un tableau associatif.
// NB on retourne extra
// sous forme de tableau associatif
// Merci à Beatnick de www.spip_contrib.net

function get_extra ($id, $objet) {
	if(!$id) return false;
	// On construit qqch qui ressemble à "SELECT extra FROM spip_articles WHERE id_article=$id_article"
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
	// On construit qqch qui ressemble à "UPDATE spip_articles SET extra='$extra' WHERE id_article=$id_article"
	$query = "UPDATE spip_".$objet."s";
	$query .= " SET extra='$extra' ";
	$query .= " WHERE id_".$objet."=".$id;
	return spip_query($query);
}



// a partir de la liste des champs, generer la liste des input
function bloog_extra_saisie($extra, $type, $ensemble='',$no_echo='') {
	//get localized string for extra
	if($type=="auteurs" && $ensemble=="inscription") 	
		$GLOBALS['champs_extra']["auteurs"]["abo"]=_T("spiplistes:options");

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
		$affiche .= "<strong>$prettyname</strong><br />";

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

					$affiche .= " value='$val' />$choix_<br />";
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
				$affiche .= " value=\"".entites_html($extra[$champ])."\" size='40' />\n";
				break;
		}

		$affiche .= "\n";
	}

	if ($affiche) {
		if(!$no_echo) {
	    echo" <div style='text-align:left'>";
			echo $affiche;
			echo"</div>";
		} else 
			return $affiche;
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

 
 
function spip_listes_onglets($rubrique, $onglet){
	global $id_auteur, $connect_id_auteur, $connect_statut, $statut_auteur, $options;

	debut_onglet();


		if ($rubrique == "messagerie"){
		onglet(_T('spiplistes:Historique_des_envois'), "spip_listes.php3?mode=historique", "messagerie", $onglet, "stock_hyperlink-mail-and-news-24.gif");
		onglet(_T('spiplistes:Listes_de_diffusion'), "spip_listes.php3?mode=listes", "messagerie", $onglet, "reply-to-all-24.gif");
		onglet(_T('spiplistes:Suivi_des_abonnements'), "spip_listes.php3?mode=statut", "messagerie", $onglet, "addressbook-24.gif");
		}

	
	

	fin_onglet();
}


// Bloogletter


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

//portabilité inter versions de spip

function bloog_afficher_messages($titre_table, $query_message, $afficher_auteurs = true, $important = false, $boite_importante = true, $obligatoire = false, $logo = '') {
	global $messages_vus;
	global $connect_id_auteur;
	global $couleur_claire;
	global $spip_lang_rtl;

	// Interdire l'affichage de message en double
	if ($messages_vus) {
		$query_message .= ' AND messages.id_message NOT IN ('.join(',', $messages_vus).')';
	}


	$cols = 2;
	$query_message .= ' ORDER BY date_heure DESC';
	$tranches = afficher_tranches_requete($query_message, $cols);

	if ($tranches OR $obligatoire) {
		if ($important) debut_cadre_relief($logo);

		
		echo "<table width=100% cellpadding=0 cellspacing=0 border=0><tr><td width=100% background=''>";
		echo "<table width=100% cellpadding=3 cellspacing=0 border=0>";

		bandeau_titre_boite($titre_table, $afficher_auteurs, $boite_importante);

		echo $tranches;

		$result_message = spip_query($query_message);
		$num_rows = spip_num_rows($result_message);

		while($row = spip_fetch_array($result_message)) {
			$vals = '';

			$id_message = $row['id_message'];
			$date = $row["date_heure"];
			$titre = $row["titre"];
			$type = $row["type"];
			$statut = $row["statut"];
			$page = $row["page"];
			$rv = $row["rv"];
			$vu = $row["vu"];
			$messages_vus[$id_message] = $id_message;

			//
			// Titre
			//

			$s = "<a href='?mode=courrier&id_message=$id_message'>";

			
				$puce = "m_envoi$spip_lang_rtl.gif";
			
				
			$s .= "<img src='img_pack/$puce' width='14' height='7' border='0' />";
			$s .= "&nbsp;&nbsp;".typo($titre)."</a>";
			$vals[] = $s;

			
			
			//
			// Date
			//
			
			$s = affdate($date);
			
				$s = "<font color='#999999'>$s</font>";
			
			
			$vals[] = $s;

			$table[] = $vals;
		}

		
			$largeurs = array('', 90);
			$styles = array('arial2', 'arial1');
		
		afficher_liste($largeurs, $table, $styles);

		echo "</table></td></tr></table>";
		spip_free_result($result_message);
		if ($important) fin_cadre_relief();
	}
}



//
// Afficher tableau de listes
//

function bandeau_titre_bloog_boite2($titre, $logo="", $fond="white", $texte="black") {
	global $spip_lang_left, $spip_display;
	
	if (strlen($logo) > 0 AND $spip_display != 1 AND $spip_display != 4) {
		echo "<div style='position: relative;'>";
		echo "<div style='position: absolute; top: -12px; $spip_lang_left: 3px;'><img src='img_pack/$logo' /></div>";
		echo "<div style='background-color: $fond; color: $texte; padding: 3px; padding-$spip_lang_left: 30px; border-bottom: 1px solid #444444;' class='verdana2'><b>$titre</b></div>";
	
		echo "</div>";
	} else {
		echo "<div style='background-color: $fond; color: $texte; padding: 3px; border-bottom: 1px solid #444444;' class='verdana2'><b>$titre</b></div>";
	}

}

function afficher_articles_listes($titre_table, $requete, $afficher_desabo = false, $id_aut = '',
		$toujours_afficher = false, $afficher_cadre = true, $afficher_descriptif = true, $pub = false) {

if($pub) include('ecrire/inc_presentation.php3') ;

	global $connect_id_auteur, $connect_statut, $dir_lang;
	global $options;
	global $spip_lang_left;

	$activer_messagerie = lire_meta("activer_messagerie");
	$activer_statistiques = lire_meta("activer_statistiques");
	$afficher_visites = ($afficher_visites AND $connect_statut == "0minirezo" AND $activer_statistiques != "non");

	if (!ereg("^SELECT", $requete)) {
		$select = "SELECT articles.id_article, articles.titre, articles.id_rubrique, articles.statut, articles.date";

		if ((lire_meta('multi_rubriques') == 'oui' AND $GLOBALS['coll'] == 0) OR lire_meta('multi_articles') == 'oui') {
			$afficher_langue = true;
			if ($GLOBALS['langue_rubrique']) $langue_defaut = $GLOBALS['langue_rubrique'];
			else $langue_defaut = lire_meta('langue_site');
			$select .= ", articles.lang";
		}
		if ($afficher_visites)
			$select .= ", articles.visites, articles.popularite";
		if ($afficher_descriptif)
			$select .= ", articles.descriptif";
		$select .= ", petitions.id_article AS petition ";
		$requete = $select . "FROM spip_articles AS articles " . $requete;
	}

	if ($options == "avancees")  $ajout_col = 1;
	else $ajout_col = 0;

	$tranches = afficher_tranches_requete($requete, $afficher_auteurs ? 3 + $ajout_col : 2 + $ajout_col);

	$requete = str_replace("FROM spip_articles AS articles ", "FROM spip_articles AS articles LEFT JOIN spip_petitions AS petitions USING (id_article)", $requete);

	if (strlen($tranches) OR $toujours_afficher) {
	 	
                 $result = spip_query($requete);

		debut_cadre_relief("reply-to-all-24.gif");


		echo "<div style='height: 12px;'></div>";
		echo "<div class='liste'>";
		bandeau_titre_bloog_boite2($titre_table, "");

		echo "<table width='100%' cellpadding='2' cellspacing='0' border='0'>";


		echo $tranches;

		while ($row = spip_fetch_array($result)) {
			$vals = '';

			$id_article = $row['id_article'];
			$tous_id[] = $id_article;
			$titre = $row['titre'];
			$id_rubrique = $row['id_rubrique'];
			$date = $row['date'];
			$statut = $row['statut'];
			$visites = $row['visites'];
			if ($lang = $row['lang']) changer_typo($lang);
			$popularite = ceil(min(100,100 * $row['popularite'] / max(1, 0 + lire_meta('popularite_max'))));
			$descriptif = $row['descriptif'];
			if ($descriptif) $descriptif = ' title="'.attribut_html(typo($descriptif)).'"';
			$petition = $row['petition'];

			if ($afficher_auteurs) {
				$les_auteurs = "";
			 	$query2 = "SELECT auteurs.id_auteur, nom, messagerie, login, en_ligne ".
			 		"FROM spip_auteurs AS auteurs, spip_auteurs_articles AS lien ".
			 		"WHERE lien.id_article=$id_article AND auteurs.id_auteur=lien.id_auteur";
				$result_auteurs = spip_query($query2);

				while ($row = spip_fetch_array($result_auteurs)) {
					$id_auteur = $row['id_auteur'];
					$nom_auteur = typo($row['nom']);
					$auteur_messagerie = $row['messagerie'];

					$les_auteurs .= ", <a href='auteurs_edit.php3?id_auteur=$id_auteur'>$nom_auteur</a>";
					if ($id_auteur != $connect_id_auteur AND $auteur_messagerie != "non" AND $activer_messagerie != "non") {
						$les_auteurs .= "&nbsp;".bouton_imessage($id_auteur, $row);
					}
				}
				$les_auteurs = substr($les_auteurs, 2);
			}
			
			


			switch ($statut) {
			case 'liste':
				$puce = 'verte';
				$title = "Vos lettres d'information";
				break;

			case 'inact':
				$puce = 'blanche';
				$title = "Vos lettres d'information internes";
				break;

			case 'poublist':
				$puce = 'poubelle';
				$title = _T('info_article_supprime');
				break;
			}
			$puce = "puce-$puce.gif";


			$query3 = "SELECT auteurs.id_auteur, nom, messagerie, login, en_ligne ".
			 		"FROM spip_auteurs AS auteurs, spip_auteurs_articles AS lien ".
			 		"WHERE lien.id_article=$id_article AND auteurs.id_auteur=lien.id_auteur";
				$result_aut = spip_query($query3);
				$nb_inscr = spip_num_rows($result_aut);

                        $s = "<div style='background: url(img_pack/$puce) $spip_lang_left center no-repeat; margin-$spip_lang_left: 3px; padding-$spip_lang_left: 14px;'>";

			//$s. = "<a href=\"articles.php3?id_article=$id_article\" title=\"$title\">";

			//$s .= "<img src=\"img_pack/$puce\" alt='' width=\"13\" height=\"14\" border=\"0\"></a>&nbsp;&nbsp;";
			

                        if ($afficher_desabo){
			$s .= "<a href=?mode=liste_edit&id_article=$id_article>".typo($titre)."</a>&nbsp;<a href='spip_listes.php3?mode=abonne&id_auteur=$id_aut&suppr_auteur=$id_aut&id_article=$id_article'><tt>("._T('spiplistes:desabonnement').")</tt></a></div>";
                        }else{
                        $nb_inscr_nb = (($nb_inscr == 0) OR ($nb_inscr == 1)) ? "abonn&eacute;" : "abonn&eacute;s" ;
			$auto = get_extra($row["id_article"],article);
                        $s .= "&nbsp;<a href=?mode=liste_edit&id_article=$id_article>".typo($titre)."</a>&nbsp;<tt>($nb_inscr $nb_inscr_nb)</tt>";
			($auto["auto"] == "oui") ? $s .= "<img vspace='5' hspace='5' src='./img_pack/stock_timer-16.png' /></div>" : $s .= "</div>" ;
                        }



			echo $s;



		}
		spip_free_result($result);


		afficher_liste($largeurs, $table, $styles);

		echo "</table>";
		echo "</div>";
		echo "<p>";
		fin_cadre_relief();

	}
	return $tous_id;
}

/****
 * titre : propre_bloog
 * Enleve les enluminures Spip pour la bloogletter
 Vincent CARON
****/

function propre_bloog($texte) {

        $texte = ereg_replace("<p class=\"spip\">(\r\n|\n|\r)?</p>",'',$texte);
        $texte = eregi_replace("\n{3}", "\n", $texte);
       
      
      // div imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<div([^>]*)>" , "<div\\2>" , $texte);
        $texte = eregi_replace( "<\/div>(\r\n|\n|\r| )*<\/p>" , "</div>" , $texte);
        
        // style imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<style([^>]*)>" , "<style>" , $texte);
        $texte = eregi_replace( "<\/style>(\r\n|\n|\r| )*<\/p>" , "</style>" , $texte);
      
      
        // h3 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h3 class=\"spip\">" , "<h3>" , $texte);
        $texte = eregi_replace( "<\/h3>(\r\n|\n|\r| )*<\/p>" , "</h3>" , $texte);

	// h2 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h2>" , "<h2>" , $texte);
        $texte = eregi_replace( "<\/h2>(\r\n|\n|\r| )*<\/p>" , "</h2>" , $texte);
        
    // h1 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h1>" , "<h1>" , $texte);
        $texte = eregi_replace( "<\/h1>(\r\n|\n|\r| )*<\/p>" , "</h1>" , $texte);
        

	// tableaux imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(table|TABLE)" , "<table" , $texte);
       $texte = eregi_replace( "<\/(table|TABLE)>(\r\n|\n|\r| )*<\/p>" , "</table>" , $texte);

	// TD imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(\/td|\/TD)" , "</td" , $texte);
       //$texte = eregi_replace( "<\/(td|TD)>(\r\n|\n|\r| )*<\/p>" , "</td>" , $texte);

	// p imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(p|P)" , "<p" , $texte);
       //$texte = eregi_replace( "<\/(td|TD)>(\r\n|\n|\r| )*<\/p>" , "</td>" , $texte);

         // DIV imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(div|DIV)" , "<div" , $texte);
       $texte = eregi_replace( "<\/(DIV|div)>(\r\n|\n|\r| )*<\/p>" , "</div>" , $texte);

 //$texte = PtoBR($texte);
  $texte = ereg_replace ("\.php3&nbsp;\?",".php3?", $texte);
  $texte = ereg_replace ("\.php&nbsp;\?",".php?", $texte);

  return $texte;
}
/****
 * titre : absolute_url
 * d'apres Clever Mail (-> NHoizey)
****/

function absolute_url ($chaine) {
    // TBI : quid si le href n'est pas en premier ?     
    $URL_SITE_SPIP = lire_meta ('adresse_site');

    // rajout d'un / éventuellement 
    if (substr ($URL_SITE_SPIP, strlen($URL_SITE_SPIP)-1, 1) != '/') $URL_SITE_SPIP .= '/';

    $chaine = eregi_replace ('<a href="' , '<a href="'.$URL_SITE_SPIP, $chaine); 
    $chaine = eregi_replace ('<a href="'.$URL_SITE_SPIP.'http://([^"]*)"', "<a href=\"http://\\1\"", $chaine);
    $chaine = eregi_replace ('<a href="'.$URL_SITE_SPIP.'mailto:([^"]*)"', "<a href=\"mailto:\\1\"", $chaine);
    $chaine = eregi_replace ('<a href="'.$URL_SITE_SPIP.'#([^"]*)"', "<a href=\"#\\1\"", $chaine);

    $chaine = eregi_replace ('<img src="' , '<img src="'.$URL_SITE_SPIP, $chaine); 
    $chaine = eregi_replace ('<img src="'.$URL_SITE_SPIP.'http://([^"]*)"', "<img src=\"http://\\1\"", $chaine);
    $chaine = eregi_replace ('<img src=\'' , '<img src=\''.$URL_SITE_SPIP, $chaine);  
    $chaine = eregi_replace ('<img src=\''.$URL_SITE_SPIP.'http://([^"]*)\'', "<img src=\'http://\\1\'", $chaine);

    return $chaine;
}


/****
 * titre : version_texte
 * d'après Clever Mail (-> NHoizey)
****/

function version_texte ($in) {
// Nettoyage des liens des notes de bas de page
$out = ereg_replace("<a href=\"#n(b|h)[0-9]+-[0-9]+\" name=\"n(b|h)[0-9]+-[0-9]+\" class=\"spip_note\">([0-9]+)</a>", "\\3", $in);

// Supprimer tous les liens internes
$patterns = array("/\<a href=['\"]#(.*?)['\"][^>]*>(.*?)<\/a>/");
$replacements = array("\\2");
$out = preg_replace($patterns,$replacements, $out);

// Supprime feuille style
$out = ereg_replace("<style[^>]*>[^<]*</style>", "", $out);

// les puces
$out = str_replace($GLOBALS['puce'], "\n".'-', $out);

// Remplace tous les liens	
$patterns = array(
           "/\<a href=['\"](.*?)['\"][^>]*>(.*?)<\/a>/"
       );
       $replacements = array(
           "\\2 (\\1)"
       );
$out = preg_replace($patterns,$replacements, $out);

$out = ereg_replace("<h1[^>]*>", "\n--------------------------------------------------------\n", $out);
$out = str_replace("</h1>", "\n--------------------------------------------------------\n", $out);
$out = ereg_replace("<h2[^>]*>", "\n............... ", $out);
$out = str_replace("</h2>", " ...............\n", $out);
$out = ereg_replace("<h3[^>]*>", "\n + ", $out);
$out = str_replace("</h3>", "\n", $out);
$out = str_replace("<p class=\"spip\"[^>]*>", "\n", $out);

// Les notes de bas de page
    $out = str_replace("<p class=\"spip_note\">", "\n", $out);
    $out = ereg_replace("<sup>([0-9]+)</sup>", "[\\1]", $out);

    //$out = str_replace('<br /><img class=\'spip_puce\' src=\'puce.gif\' alt=\'-\' border=\'0\'>', "\n".'-', $out);
$out = ereg_replace ('<li[^>]>', "\n".'-', $out);
    //$out = str_replace('<li>', "\n".'-', $out);


    // accentuation du gras -
    // <b>texte</b> -> *texte*
    $out = ereg_replace ('<b[^>|r]*>','*' ,$out);
    $out = str_replace ('</b>','*' ,$out);

    // accentuation de l'italique
    // <i>texte</i> -> *texte*
    $out = ereg_replace ('<i[^>|mg]*>','*' ,$out);
    $out = str_replace ('</i>','*' ,$out);

	$out = str_replace('&oelig;', 'oe', $out);
	$out = str_replace("&nbsp;", " ", $out);
	$out = filtrer_entites($out);

	$out = supprimer_tags($out);

        //$out = ereg_replace("^(\n|\r|\r\n| )+", "", $out);
		 //$out = ereg_replace("^( )", "", $out);
		 //$out = ereg_replace("(\n\n\n)+", "", $out) ;
		 //$out = ereg_replace("(\n\n)+", "", $out) ;
		 $out = str_replace(chr(160), "", $out); 
		 $out = str_replace("\x0B", "", $out); 
		 $out = ereg_replace("\t", "", $out) ;
		 //$out = ereg_replace("[\n]{3,}", "\n\n", $out);
		 $out = ereg_replace("[ ]{3,}", "", $out);
		  // Bring down number of empty lines to 2 max
        $out = preg_replace("/\n\s+\n/", "\n\n", $out);
        $out = preg_replace("/[\n]{3,}/", "\n\n", $out);
		
		//$out = trim($out) ;
		
    return $out;

}


//Balises Spip-listes

function calcul_MELEUSE_CRON() {
  global $include_ok;
   if(!$include_ok) {
include("spip-listes/meleuse-cron.php3");
$include_ok = true;
}
   return '';
}

function balise_MELEUSE_CRON($p) {
   $p->code = "calcul_MELEUSE_CRON()";
   $p->statut = 'php';
   return $p;
}


function calcul_DATE_MODIF_SITE() {
   $date_art=spip_query("SELECT date,titre FROM spip_articles WHERE statut='publie' ORDER BY date DESC LIMIT 0,1");
   $date_art=spip_fetch_array($date_art);
   $date_art= $date_art['date'];
   
   $date_bre=spip_query("SELECT date_heure,titre FROM spip_breves WHERE statut='publie' ORDER BY date_heure DESC LIMIT 0,1");
   $date_bre=spip_fetch_array($date_bre);
   $date_bre= $date_bre['date_heure'];
   
   $date_modif= ($date_bre>$date_art)? $date_bre : $date_art ;   
   return  $date_modif;
}

function balise_DATE_MODIF_SITE($p) {
   $p->code = "calcul_DATE_MODIF_SITE()";
   $p->statut = 'php';
   return $p;
}

function calcul_DATE_MODIF_FORUM() {
   $date_f=spip_query("SELECT date_heure,titre FROM spip_forum WHERE statut='publie' ORDER BY date DESC LIMIT 0,1");
   $date_f=spip_fetch_array($date_art);
   $date_f= $date_f['date_heure'];
   
   return  $date_f;
}

function balise_DATE_MODIF_FORUM($p) {
   $p->code = "calcul_DATE_MODIF_FORUM()";
   $p->statut = 'php';
   return $p;
}

/******************************************************************************************/
/* SPIP-listes est un système de gestion de listes d'information par email pour SPIP      */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique Générale GNU publiée par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU  */
/* pour plus de détails.                                                                  */
/*                                                                                        */
/* Vous devez avoir reçu une copie de la Licence Publique Générale GNU                    */
/* en même temps que ce programme ; si ce n'est pas le cas, écrivez à la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, États-Unis.                   */
/******************************************************************************************/
?>
