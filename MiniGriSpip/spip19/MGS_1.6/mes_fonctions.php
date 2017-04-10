<?php

// MiniGriSpip 1.6.0 - 2007 (c) FredoMkb


function nombre_articles_rubrique($id_rubrique) {
// Fonction pour retourner le nombre d'articles publies existants dans une rubrique ($id_rubrique)
	
	global $table_prefix; // Pour pouvoir utiliser des prefixes personnalises autres que "spip"
	$requete = mysql_query("SELECT id_article FROM ".$table_prefix."_articles WHERE id_rubrique=$id_rubrique AND statut='publie'");
	$nbr = mysql_num_rows($requete);
	mysql_free_result($requete);
	return $nbr;
}

function numero_message_forum_article($id_article,$id_forum) {
// Fonction pour retourner le numero incremental d'un message du forum ($id_forum) d'un article ($id_article) lors d'une reponse
	
	global $table_prefix; // Pour pouvoir utiliser des prefixes personnalises autres que "spip"
	$requete = mysql_query("SELECT id_forum FROM ".$table_prefix."_forum WHERE id_article=$id_article AND id_forum<=$id_forum AND statut='publie'");
	$nbr = mysql_num_rows($requete);
	mysql_free_result($requete);
	return $nbr;
}

function nombre_articles_auteur($id_auteur) {
// Fonction pour retourner le nombre d'articles rediges par un auteur ($id_auteur) 
	
	global $table_prefix; // Pour pouvoir utiliser des prefixes personnalises autres que "spip"
	$requete = mysql_query("SELECT id_article FROM ".$table_prefix."_auteurs_articles WHERE id_auteur=$id_auteur");
	$nbr = mysql_num_rows($requete);
	mysql_free_result($requete);
	return $nbr;
}

function statut_article($id_article) {
// Fonction pour retourner le "statut" d'un article ($id_article) soit ('prepa', 'prop', 'publie', 'refuse', 'poubelle')
	
	global $table_prefix; // Pour pouvoir utiliser des prefixes personnalises autres que "spip"
	$requete = mysql_query("SELECT statut FROM ".$table_prefix."_articles WHERE id_article=$id_article");
	$statuts = mysql_fetch_assoc($requete);
	mysql_free_result($requete);
	return $statuts[statut];
}

function nombre_articles_publies_auteur($id_auteur) {
// Fonction pour retourner le nombre d'articles publies par un auteur ($id_auteur) 
	
	global $table_prefix; // Pour pouvoir utiliser des prefixes personnalises autres que "spip"
	$articles = array();
	$requete = mysql_query("SELECT id_article FROM ".$table_prefix."_auteurs_articles WHERE id_auteur=$id_auteur");
	while ($ligne = mysql_fetch_assoc($requete)) array_push($articles,$ligne);
	mysql_free_result($requete);
	$nbr = 0;
	foreach ($articles as $val) {
		$statut = statut_article($val[id_article]);
		if ($statut == 'publie') {$nbr += 1;};
	}
	return $nbr;
}

function asciihtml($textHtml) {
// Fonction pour retourner le texte Html fourni ($textHtml) converti en codes Ascii Html ($asciiHtml).
// Exemple d'utilisation : [(#TEXT|asciihtml)]
// Petite adaptation d'un code issu d'une contribution sur Spip'Contrib proposee par Jean Luc Girard et Coyote, merci a eux.
// Voir : <https://contrib.spip.net/Crypter-une-adresse-email>

        $asciiHtml = '';
        for ($i = 0; $i < strlen($textHtml); $i++) {
          $asciiHtml .= '&#'.ord($textHtml[$i]).';';
        }
      return $asciiHtml;
}

function fileofurl($theUrl) {
// Fonction pour retourner le nom du document pointe par une adresse Url.
	$docNomList = explode("/", $theUrl);
	$docNom = $docNomList[sizeof($docNomList)-1];
	return $docNom;
}


function nombre_publications_date($dateStart,$dateEnd) {
// Fonction pour retourner le nombre d'articles, de breves et commentaires publies existants dans une date donnee ($date)
	
	global $table_prefix; // Pour pouvoir utiliser des prefixes personnalises autres que "spip"
	$requete = mysql_query("SELECT * FROM ".$table_prefix."_articles WHERE date>='$dateStart' AND date<'$dateEnd' AND statut='publie'");
	$nbr_articles = mysql_num_rows($requete);
	$requete = mysql_query("SELECT * FROM ".$table_prefix."_breves WHERE date_heure>='$dateStart' AND date_heure<'$dateEnd' AND statut='publie'");
	$nbr_breves = mysql_num_rows($requete);
	$requete = mysql_query("SELECT * FROM ".$table_prefix."_forum WHERE date_heure>='$dateStart' AND date_heure<'$dateEnd' AND statut='publie'");
	$nbr_forums = mysql_num_rows($requete);
	mysql_free_result($requete);
	
	$total = $nbr_articles + $nbr_breves + $nbr_forums;
	$resultat = '';
	if ($total > 0) {
		$resultat = $resultat.' title=" - Articles publies : '.$nbr_articles." \n".' - Breves publiees : '.$nbr_breves." \n".' - Commentaires publies : '.$nbr_forums.' "';
	}
	return $resultat;
}

function cal_site($theDate=null, $locale=null, $calPage=null, $calJour=null, $calMois=null) {
// Fonction pour generer un calendrier indiquant les articles, breves et commentaires publies

	// Si la date n'est pas fournie, alors on prend la date actuelle
	if (!isset($theDate)) { $theDate = date('Y-m-d'); }
	// Si une date est presente dans l'adresse Url, alors on prend celle-ci
	$laDate = $_GET['date'];
	if (isset($laDate)) { $theDate = $laDate; }

	// Si la localisation n'est pas fournie, alors on regle le francais par defaut
	if (!isset($locale)) { $locale = array('fr', 'fr_FR', 'fr_FR.UTF-8'); }
	// On regle la localisation selon la valeur obtenue
	setlocale (LC_TIME, $locale);

	// On defini les pages Html de construction des liens
	if (!isset($calPage)) { $calPage = 'calendrier'; }
	if (!isset($calJour)) { $calJour = 'inc/inc-cal-jour'; }
	if (!isset($calMois)) { $calMois = 'inc/inc-cal-mois'; }

	// On separe les differents elements de la date fournie
	$day = date('j', strtotime($theDate));
	$month = date('n', strtotime($theDate));
	$year = date('Y', strtotime($theDate));
	
	// On verifie la validite de la date avant de generer le calendrier
	// <http://www.php.net/manual/fr/function.setlocale.php>
	if (checkdate($month, 1, $year)) {
   		
		// Date actuelle
		$now = date('Y-m-d');
		$nowDay = date('j', strtotime($now));
		$nowMonth = date('n', strtotime($now));
		$nowYear = date('Y', strtotime($now));
		
		// Nettoyage de l'adresse Url pour construir les liens
		$requete = $_SERVER['argv'][0];
		$debut = '?'.$requete.'&';
		$debut = preg_replace('#var_mode=.*?([\&])#i','',$debut);
		$debut = preg_replace('#date=.*?([\&])#i','',$debut);
		$debut = rtrim($debut, '&');
		$debut = str_replace('?&','?',$debut);
		$debut = str_replace('&&','&',$debut);
		
		// On remplace l'affichage jour par l'affichage mois, et vise-versa
		$debutMois = str_replace($calJour,$calMois,$debut);
		$debutJour = str_replace($calMois,$calJour,$debut);

		// On defini les differentes dates a utiliser
		// <http://www.php.net/manual/fr/function.mktime.php>
		$dateNow = mktime(0, 0, 0, $nowMonth, $nowDay, $nowYear);
		$dateLien = mktime(0, 0, 0, $month, $day, $year);
		$dateLienJour1 = mktime(0, 0, 0, $month, 1, $year);
		$dateLienJourPlus1 = mktime(0, 0, 0, $month, $day + 1, $year);
		$dateLienJourMoins1 = mktime(0, 0, 0, $month, $day - 1, $year);
		$dateLienMoisPlus1 = mktime(0, 0, 0, $month + 1, 1, $year);
		$dateLienMoisMoins1 = mktime(0, 0, 0, $month - 1, 1, $year);
		
		// On definie le 'lundi' comme premier jour de la semaine et le 'dimanche' comme le dernier
		if (!$day = date("w", $dateLienJour1)) $day = 7; 
       	
		// Le Calendrier
		$cal = "";
		
		// Recuperation du nombre d'articles, breves et commentaires publies pendant le mois considere
		$dateMois = strftime("%G-%m-%d", $dateLienJour1);
		$dateMoisPlus1 = strftime("%G-%m-%d", $dateLienMoisPlus1);
		$titreMois = nombre_publications_date($dateMois, $dateMoisPlus1);
		
		// Construction des liens des mois precedent, actuel et suivant
		$lienMoisMoins = '<a href="'.$debutMois.'&date='.strftime("%G-%m-%d", $dateLienMoisMoins1).'" title="'.strftime("%B %G", $dateLienMoisMoins1).'">&laquo;</a>';
		$lienMoisLien = '<a href="?page='. $calPage.'&cal='.$calMois.'&date='.strftime("%G-%m-%d", $dateLienJour1).'"'.$titreMois.'>'.strftime("%B %G", $dateLien).'</a>';
		$lienMoisPlus = '<a href="'.$debutMois.'&date='.strftime("%G-%m-%d", $dateLienMoisPlus1).'" title="'.strftime("%B %G", $dateLienMoisPlus1).'">&raquo;</a>';
		
		// On affiche le nom entier du mois considere suivant la localisation, et les liens vers les mois precedent et suivant
		// <http://www.php.net/manual/fr/function.strftime.php>
		$cal = $cal.'<table border=0><tr class="cal_titre"><th>'.$lienMoisMoins.'</th><th colspan=5>'.$lienMoisLien.'</th><th>'.$lienMoisPlus.'</th></tr><tr>';
       
		// On affiche les abreviations des jours de la semaine suivant la localisation (Lun, Mar, Mer, Jeu, Ven, Sam, Dim)
		for ($i = 8; --$i;) {
			$cal = $cal.'<th>'. strftime("%a", mktime(0, 0, 0, $month, 16 - $i - $day, $year)).'</th>'; 
		}
           
		// On affiche les eventuelles cellules vides au debut du mois
		$cal = $cal.'</tr><tr>'.str_repeat('<td></td>', --$day); 
       
		// On genere les differents jours du calendrier du mois
		// <http://www.php.net/manual/fr/function.checkdate.php>
		while (checkdate($month, ++$i, $year)) { // $i==0 after for :-)
			// Recuperation du nombre d'articles, breves et commentaires publies pendant le jour considere
			$dateJour = strftime("%G-%m-%d", mktime(0, 0, 0, $month, $i, $year));
			$dateJourPlus1 = strftime("%G-%m-%d", mktime(0, 0, 0, $month, $i + 1, $year));
			$titreJour = nombre_publications_date($dateJour,$dateJourPlus1);
			
			// Pour le style de la cellule du calendrier contenant la date actuelle
			if ($dateJour == $now) { $sel = ' class="cal_sel"'; } else { $sel = ""; };
			
			// S'il y a des publications alors on construit le lien
			if ($titreJour == '') {
				$cal = $cal.'<td'.$sel.'>'.$i.'</td>';
			} else {
				$cal = $cal.'<td'.$sel.'><a href="?page='.$calPage.'&cal='.$calJour.'&date='.$dateJour.'"'.$titreJour.'>'.$i.'</a></td>';
			}
			
			// Nouvelle rangee du tableau au bout de 7 jours
			if (!(++$day % 7)) $cal = $cal.'</tr><tr>'; 
	
	}
		// Fin du tableau calendrier
		$cal = $cal.'</tr></table>';
		// Lien de la date actuelle
		$cal = $cal.'<p class="cal_now"><a href="'.$debutJour.'&date='.strftime("%G-%m-%d",$dateNow).'">'.strftime("Aujourd'hui %A %e %B %G",$dateNow).'</a></p>';
		
		// Retour du calendrier
		return $cal;
	} 
} 

function filets_sep($texte) {
// Fonction pour generer des filets de separation selon les balises presentes dans le texte fourni.
// Il y a par defaut 10 filets possibles, de 0 a 9, mais on peut en ajouter d'autres au besoin.
	
	// On memorise le modele d'expression rationnelle a utiliser pour chercher les balises.
	$modele = '#[\n\r]__(\d+)__[\n\r]#iU';
	
	// On verifie si des balises filets existent dans le texte fourni.
	preg_match_all($modele, $texte, $test);

	if ($test !== false) {
		// On isole les textes presents dans les balises "cadre" et "code".
		preg_match_all('#<cadre>(.*?)</cadre>#is', $texte, $listeCadre);
		preg_match_all('#<code>(.*?)</code>#is', $texte, $listeCode);
		$listeCadreTexte = $listeCadre[0];
		$listeCodeTexte = $listeCode[0];
		
		// On modifie le format des balises filets presents dans les balises "cadre" pour ne pas les traiter.
		foreach ($listeCadreTexte as $texteCadreOrig) {
			$texteCadreNew = preg_replace('#__(\d+)__#iU','__-$1-__',$texteCadreOrig);
			$texte = str_replace($texteCadreOrig,$texteCadreNew,$texte);
		};
	
		// On modifie le format des balises filets presents dans les balises "code" pour ne pas les traiter.
		foreach ($listeCodeTexte as $texteCodeOrig) {
			$texteCodeNew = preg_replace('#__(\d+)__#iU','__-$1-__',$texteCodeOrig);
			$texte = str_replace($texteCodeOrig,$texteCodeNew,$texte);
		};
	
		// On remplace les balises filets dans le texte par le code Html correspondant.
		$texte = preg_replace($modele,'<html><p class="filet_sep_$1"></p></html>',$texte); 
		
		// On remet les balises filets presents dans les balises "cadre" et "code" a leur format initial.
		$texte = preg_replace('#__-(\d+)-__#iU','__$1__',$texte); 
	};

	// Traitement des anciens filets, pour assurer une compatibilite descendente.
	$texte = str_replace('__l__','<html><p class="filet_sep_long"></p></html>',$texte);
	$texte = str_replace('__m__','<html><p class="filet_sep_moyen"></p></html>',$texte);
	$texte = str_replace('__c__','<html><p class="filet_sep_court"></p></html>',$texte);

	return $texte;
}


function chercher_remplacer($chercher,$remplacer,$texte) {
// Fonction pour faire des recherches-remplacements dans le texte fourni
	
	return str_replace($chercher,$remplacer,$texte);
}

function conversion_minuscules(&$value, $key) {
// Fonction pour convertir du texte en minuscules
	$value = strtolower($value);
	return $value;
}

function somm_table($texteOrig, $titreSommaire = '') {
// Fonction pour creer un sommaire sous forme d'une liste ou d'un tableau Spip.
// La fonction verifie l'existence d'un intertitre "Sommaire" par defaut, 
// ou le titre de sommaire fourni par l'tuilisateur (pour des articles multilingues).
// Si un intertitre sommaire existe, alors on analyse le texte fourni pour isoler
// tous les intertitres afin de pouvoir fabriquer le sommaire, avec des liens 
// internes vers tous les intertitres et de liens de retour vers le sommaire.
// Le sommaire ainsi cree sera place juste en dessous du titre "Sommaire".
	
	// Si l'utilisateur n'a pas fourni le titre sommaire a utiliser, 
	// alors on utilise le titre par defaut en francais.
	if (empty($titreSommaire)) {
		$titreSommMin = 'sommaire';
	} else {
		$titreSommMin = strtolower($titreSommaire);
	};
	
	// Test de l'existence d'un intertitre 'Sommaire' pour generer un tableau
	// ou 'Sommaire-' (avec un trait d'union a la fin) pour generer une liste. 
	$test = preg_match('#\{\{\{\[?\#?'.$titreSommMin.'-?\]?}\}\}#i', $texteOrig);

	// Si un des intertitres sommaire existe, alors on genere le sommaire.
	if ($test) {
	
		// On isole les textes presents dans les balises "cadre" et "code".
		preg_match_all('#<cadre>(.*?)</cadre>#is', $texteOrig, $listeCadre);
		preg_match_all('#<code>(.*?)</code>#is', $texteOrig, $listeCode);
		// On place les resultast, avec les balises, dans des variables.
		$listeCadreTexte = $listeCadre[0];
		$listeCodeTexte = $listeCode[0];
		
		// On modifie le format des balises intertitre dans les balises "cadre" pour ne pas les traiter.
		foreach ($listeCadreTexte as $texteCadreOrig) {
			$texteCadreNew = preg_replace('#(\{\{)(\{.*?\})(\}\})#i','$1-$2-$3',$texteCadreOrig);
			$texteOrig = str_replace($texteCadreOrig,$texteCadreNew,$texteOrig);
		};

		// On modifie le format des balises intertitre dans les balises "code" pour ne pas les traiter.
		foreach ($listeCodeTexte as $texteCodeOrig) {
			$texteCodeNew = preg_replace('#(\{\{)(\{.*?\})(\}\})#i','$1-$2-$3',$texteCodeOrig);
			$texteOrig = str_replace($texteCodeOrig,$texteCodeNew,$texteOrig);
		};

		// Recuperation des tous les intertitres presents dans le texte nettoye.
		preg_match_all('#\{\{\{(.*?)\}\}\}#i', $texteOrig, $listeOrig);
		
		// On place le resultat a utiliser dans une variable.
		$listeTitresOrig = $listeOrig[1];

		// On verifie qu'il y reste des intertitres a traiter.
		if (count($listeTitresOrig) > 0) {
		
			// On verifie si le sommaire demande est sous forme de liste ou tableau.	
			$testType = preg_match('#\{\{\{\[?\#?'.$titreSommMin.'-\]?\}\}\}#i', $texteOrig);
			
			// On verifie si la numerotation automatique est demandee.	
			$testNro = preg_match('#\{\{\{\[?\#'.$titreSommMin.'-?\]?\}\}\}#i', $texteOrig);
			
			// On initialise les autres variables.
			$newSomm = '';
			$esp = '&nbsp; &nbsp;';
			$nb = 1;
			
			// Boucle sur chaque element de la liste des intertitres originaux.
			foreach ($listeTitresOrig as $titreOrig) {
				$masquer = preg_match('#^\[(.*?)\]$#i', $titreOrig); // On test s'il faut masquer.
				$titreClean = rtrim(trim($titreOrig, '[#'),'-]'); // On supprime les eventuels indesirables.
				$titreClean = ucfirst($titreClean); // On met la premiere lettre en majuscule.
				$titreMin = strtolower($titreClean); // On converti en minuscules.

				if ($titreMin == $titreSommMin) {
					// Si le titre considere est 'sommaire', alors on fabrique le debut du sommaire.
					$titreSommOrig = '{{{'.$titreOrig.'}}}';
					// On insere l'ancre et l'intertitre, ou l'ancre seulement s'il faut masquer l'intertitre.
					if ($masquer) {
						$titreSommNew = '[somm<-]'."\n";
					} else {
						$titreSommNew = '[somm<-]'."\n".'{{{'.$titreClean.'}}}'."\n\n";
					}
				} else {
					// On insere la numerotation automatique si elle est demandee.
					if ($testNro) { $titreClean = $nb.'. '.$titreClean; };

					// On fabrique la liste ou le tableau et on place les ancres et liens des intertitres.
					if ($testType) {
						// On fabrique le sommaire sous forme de liste.
						$newSomm = $newSomm.'- [{{<html>'.$titreClean.'</html>}}->#inter'.$nb.']'."\n";
					} else {
						// On fabrique le sommaire sous forme de tableau.
						$newSomm = $newSomm.'|['.$esp.'{{<html>'.$titreClean.'</html>}}'.$esp.'->#inter'.$nb.']|'."\n";
					};
					// On insere l'ancre et l'intertitre, ou l'ancre seulement s'il faut masquer l'intertitre.
					if ($masquer) {
						$titreNew = '[inter'.$nb.'<-]'."\n";
					} else {
						$titreNew = '[inter'.$nb.'<-]'."\n".'{{{[<html>'.$titreClean.'</html>->#somm]}}}';
					}
					// On remplace les intertitres par d'autres avec une ancre et un lien vers le sommaire.
					$texteOrig = str_replace('{{{'.$titreOrig.'}}}', $titreNew, $texteOrig);
					$nb++;
				};
			};
			$newSomm = '<html><div class="somm_table"></html>'."\n".$newSomm."\n".'<html></div></html>';
			// On remplace l'intertitre "Sommaire" original par le nouveau sommaire.
			$texteOrig = str_replace($titreSommOrig, $titreSommNew.$newSomm, $texteOrig);
		};
		// On remet les balises intertitres dans les balises "cadre" et "code" a leur format initial.
		$texteOrig = preg_replace('#\{\{-\{(.*?)\}-\}\}#i','{{{$1}}}',$texteOrig); 
		
		// On efface tous les eventuels intertitres vides.
		$texteOrig = str_replace('{{{}}}', '', $texteOrig);
	};
	// Retour du texte avec le sommaire ou le texte original a defaut.
	return $texteOrig;
}


function visites_site($day) {
// Fonction pour afficher le nombre de visites enregistrees sur le site.
// Le parametre "today" retourne les visites du jour courant.
// Le parametre "all" retourne le total des visites depuis l'ouverture du site.
// Ce code est librement inspire du squelette Sarka-Spip <http://sarka-spip.com/>

	global $table_prefix; // Pour pouvoir utiliser des prefixes personnalises autres que "spip"
	$r = 0;
	if ( $day == 'today' ) {
		$today = date('Y-m-d',strtotime(date('Y-m-d')));
		$query = "SELECT visites AS visites FROM ".$table_prefix."_visites WHERE date='$today'";
		$result = spip_query($query);
		$visit_today = 0;
		if ($row = @spip_fetch_array($result)) {
			$visit_today = $row['visites'];
		}
		$r = $visit_today;
	}
	else if ( $day == 'all' ) {
		$query = "SELECT SUM(visites) AS total_absolu FROM ".$table_prefix."_visites";
		$result = spip_query($query);
		$visit_all = 0;
		if ($row = @spip_fetch_array($result)) {
			$visit_all = $row['total_absolu'];
		}
		$r = $visit_all;
	}
	return $r;
}



?>