<?php
// ==================================================== AFFICHAGE DES AGENDAS : FONCTIONS GENERIQUES ====================================================

// ===================================================
// Auteur: Smellup
// Fonction : definition du contexte d'affichage de l'agenda
// Utilisation : tous les agendas. Doit etre appelee au debut
//                      de l'affichage, avant le recensement
// ===================================================
//
function agenda_definir_contexte($id_agenda=0, $type_agenda='listing_annuel', $debut_saison=1, $type_saison='annee', $url_page='') {
	static $contexte = array();

	if ($id_agenda == 0)
		return $contexte;

	$contexte['type_agenda'] = $type_agenda;
	$contexte['debut_saison'] = $debut_saison;
	$contexte['type_saison'] = $type_saison;
	$contexte['id_rubrique'] = $id_agenda;

	if (strpos($url_page, 'calendrier_mois') !== FALSE) {
		preg_match('/calendrier_mois=([0-9]{1,2})/', $url_page, $match);
		$contexte['mois_base'] = intval($match[1]);
		preg_match('/calendrier_annee=([0-9]{1,4})/', $url_page, $match);
		$contexte['annee_base'] = intval($match[1]);
		$contexte['url_base'] = substr($url_page, 0, strpos($url_page, 'calendrier_mois'));
	}
	else {
		$contexte['mois_base'] = intval(affdate(date("Y-m-d H:i"), 'mois'));
		$contexte['annee_base'] = intval(affdate(date("Y-m-d H:i"), 'annee'));
		$contexte['url_base'] = (strpos($url_page, '?') !== FALSE) ? $url_page.'&amp;' : $url_page.'?';
	}
	return;
}

// ===================================================
// Auteur: Smellup
// Fonction : recensement de tous les evenements
// Utilisation : tous les agendas. Doit etre appelee au debut
//                      de l'affichage, apres etablissement du contexte
//                      La liste doit etre triee en ordre chrono par la 
//                      boucle via le critere {par date_redac}
// ===================================================
//
function agenda_recenser_evenement($id_agenda=0, $id=0, $date_redac=0, $titre='') {
	static $type_agenda, $count_evt = 0, $liste_evt = array(), $mini_evt = array();

	if ($id_agenda == 0)
		return $liste_evt;

	if ($id_agenda == -1)
		return $mini_evt;

	$contexte_aff = agenda_definir_contexte(0);
	$debut_saison = $contexte_aff['debut_saison'];
	$type_saison = $contexte_aff['type_saison'];

	if ($type_agenda != $contexte_aff['type_agenda']) {
		$count_evt = 0;
		$liste_evt = array();
		$mini_evt = array();
		$type_agenda = $contexte_aff['type_agenda'];
	}

	if (intval($date_redac) > 1) {
		$count_evt += 1;

		// Liste ordonnees des evenements (tableau[1..n] d'evenements)
		$jour = affdate_base($date_redac, 'jour');
		$mois = affdate_base($date_redac, 'mois');
		$annee = affdate_base($date_redac, 'annee');

		$liste_evt[$count_evt]['id'] = $id;
		$liste_evt[$count_evt]['date_redac'] = $date_redac;
		$liste_evt[$count_evt]['date'] = affdate_base($date_redac, 'd-m-Y H:i');
		$liste_evt[$count_evt]['heure'] = affdate_base($date_redac, 'H:i');
		$liste_evt[$count_evt]['jour'] = $jour;
		$liste_evt[$count_evt]['mois'] = $mois;
		$liste_evt[$count_evt]['annee'] = $annee;
		$liste_evt[$count_evt]['nom_mois'] = affdate_base($date_redac, 'nom_mois');
		$liste_evt[$count_evt]['titre'] = $titre;

		if (intval($debut_saison) == 1) {
			$liste_evt[$count_evt]['saison'] = $annee;
			$liste_evt[$count_evt]['lien_page'] = $liste_evt[$count_evt]['saison'];
		}
		else {
			$liste_evt[$count_evt]['saison'] = (intval($mois) < intval($debut_saison)) ? $annee : strval(intval($annee)+1);
			if ($type_saison == 'annee')
				$liste_evt[$count_evt]['lien_page'] = $liste_evt[$count_evt]['saison'];
			elseif ($type_saison == 'periode')
				$liste_evt[$count_evt]['lien_page'] = (intval($mois) < intval($debut_saison))	? strval(intval($annee)-1).'-'.$annee 
																							: $annee.'-'.strval(intval($annee)+1);
			else // $type_saison == 'periode_abregee'
				$liste_evt[$count_evt]['lien_page'] = (intval($mois) < intval($debut_saison))	? substr(strval(intval($annee)-1),2,2).'-'.substr($annee,2,2) 
																							: substr($annee,2,2).'-'.substr(strval(intval($annee)+1),2,2);
		}

		$id_article = intval($id);
		$select = array('t2.id_mot AS id_mot');
		$from = array('spip_mots_articles AS t1', 'spip_mots AS t2');
		$where = array('t1.id_article='.sql_quote($id_article),
					   't2.id_mot=t1.id_mot');
		$result = sql_select($select, $from, $where);
		$cat = NULL;
		while ($row = sql_fetch($result))
			$cat .= '|'.$row['id_mot'];
		$liste_evt[$count_evt]['categorie'] = $cat;

		// Liste indexee par jour des evenements
		$jour_redac = affdate_base($date_redac, 'd-m-Y');
		$mini_evt[$jour_redac][] = $count_evt;
	}
	return;
}


// ===================================================
// Auteur: Smellup
// Fonction : affichage debug du tableau des evenements
// Utilisation : tous les agendas.
// ===================================================
//
function agenda_debug_evenement($id_agenda=0, $liste_choisie='liste_evt') {

	if ($liste_choisie == 'liste_evt') {
		$evenements = agenda_recenser_evenement(0);
		$count_evt = count($evenements);

		for ($i=1;$i<=$count_evt;$i++) {
			echo '<br /><strong>EVT N∞'.$i.'</strong><br />';
			echo '<strong>Titre</strong>: '.$evenements[$i]['titre'].'<br />';
			echo '<strong>Id</strong>: '.$evenements[$i]['id'].'<br />';
			echo '<strong>Date Redac</strong>: '.$evenements[$i]['date_redac'].'<br />';
			echo '<strong>Date</strong>: '.$evenements[$i]['date'].'<br />';
			echo '<strong>Heure</strong>: '.$evenements[$i]['heure'].'<br />';
			echo '<strong>Jour</strong>: '.$evenements[$i]['jour'].'<br />';
			echo '<strong>Mois</strong>: '.$evenements[$i]['mois'].' | '.$evenements[$i]['nom_mois'].'<br />';
			echo '<strong>Annee</strong>: '.$evenements[$i]['annee'].'<br />';
			echo '<strong>Saison</strong>: '.$evenements[$i]['saison'].'<br />';
			echo '<strong>Lien page</strong>: '.$evenements[$i]['lien_page'].'<br />';
			echo '<strong>Categorie</strong>: '.$evenements[$i]['categorie'].'<br />';
		}
	}
	else {
		$evenements = agenda_recenser_evenement(-1);

		foreach ($evenements as $jour => $liste) {
			echo '<br /><strong>JOUR: </strong>'.$jour.' ('.count($liste).')<br />';
			foreach ($liste as $num_evt)
				echo $num_evt.', ';
			echo '<br />';
		}
	}
}

// ===================================================
// Auteur: Smellup
// Fonction : affichage debug du tableau du contexte
// Utilisation : tous les agendas.
// ===================================================
//
function agenda_debug_contexte($id_agenda=0) {

	$contexte_aff = agenda_definir_contexte(0);

	echo '<br /><strong>CONTEXTE AGENDA</strong><br />';
	echo '<strong>ID Rubrique</strong>: '.$contexte_aff['id_rubrique'].'<br />';
	echo '<strong>Type</strong>: '.$contexte_aff['type_agenda'].'<br />';
	echo '<strong>Debut saison</strong>: '.$contexte_aff['debut_saison'].'<br />';
	echo '<strong>Type affichage saison</strong>: '.$contexte_aff['type_saison'].'<br />';
	echo '<strong>Mois en cours</strong>: '.$contexte_aff['mois_base'].'<br />';
	echo '<strong>Ann&eacute;e en cours</strong>: '.$contexte_aff['annee_base'].'<br />';
	echo '<strong>URL page de base</strong>: '.$contexte_aff['url_base'].'<br />';
}

// ==================================================== AGENDA LISTING ANNUEL OU SAISONNIER ====================================================

// ===================================================
// Auteur: Smellup
// Fonction : Insertion d'une bande de pagination annuelle ou
//                   saisonniere 
// Utilisation : uniquement agenda annuel. Choix possible du
//                      filtre, tri, et format (via le contexte)
// ===================================================
//
function agenda_liste_paginer($id_agenda=0, $annee_choisie=0, $mois_choisi=0, $filtre='-1', $separateur='&nbsp;|&nbsp;', $ancre=NULL, $tri='normal') {
	static $count_page = 0;

	if ($id_agenda == 0)
		return $count_page;

	$evenements = agenda_recenser_evenement(0);
	$count_evt = count($evenements);

	$pagination = NULL;
	if ($count_evt == 0)
		return $pagination;

	if ($ancre)
		$pagination .= '<a class="ancre" name="pagination_'.$ancre.'" id="pagination_'.$ancre.'"></a>';
		
	// Determination de l'annee choisie si l'agenda est saisonnier	
	$contexte_aff = agenda_definir_contexte(0);
	$debut_saison = $contexte_aff['debut_saison'];
	if (intval($debut_saison) != 1) {
		$annee_choisie = (intval($mois_choisi) < intval($debut_saison)) ? $annee_choisie : strval(intval($annee_choisie)+1);
	}


	$annee_courante = 0;
	$nouvelle_annee = FALSE;
	$count_page = 0;

	for ($i=1;$i<=$count_evt;$i++) {
		$j = ($tri == 'inverse') ? $count_evt - $i + 1 : $i;
		if (($filtre == '-1') || 
			(($filtre == '0') && (!$evenements[$j]['categorie'])) ||
			(($filtre != '-1') && ($filtre != '0') && (strpos($evenements[$j]['categorie'],$filtre) !== FALSE))) {

			$annee_redac = $evenements[$j]['saison'];
			$annee_evt = $evenements[$j]['annee'];
			$mois_evt = $evenements[$j]['mois'];
			if ($annee_redac != $annee_courante)  {
				$nouvelle_annee = TRUE;
				$count_page += 1;
			}
			else {
				$nouvelle_annee = FALSE;
			}

			if ($nouvelle_annee) {
				if ($annee_courante != 0) {
					$pagination .= $separateur;
				}
				if ($annee_redac == $annee_choisie) {
					$pagination .= '<span class="on">'.$evenements[$j]['lien_page'].'</span>';
				}
				else {
					$arg_option = NULL;
					if ($filtre != '-1') $arg_option = '&amp;categorie='.$filtre;
					if ($ancre) $arg_option .= '#pagination_'.$ancre;
					if (intval($debut_saison) != 1) $annee_evt = (intval($mois_evt) < intval($debut_saison)) ? strval(intval($annee_evt)-1) : $annee_evt;
					$pagination .= '<a class="ajax" href="spip.php?page=agenda&amp;id_rubrique='.$contexte_aff['id_rubrique'].'&amp;annee='.$annee_evt.'&amp;mois='.$debut_saison.$arg_option.'">'.$evenements[$j]['lien_page'].'</a>';
				}
			$annee_courante = $annee_redac;
			}
		}
	}
	return $pagination;
}

// ===================================================
// Auteur: Smellup
// Fonction : Affichage de l'agenda sous forme de listing des
//                   evenements de l'annee choisie
// Utilisation : uniquement agenda annuel. Choix possible du
//                      filtre et du tri
// ===================================================
//
function agenda_liste_afficher($id_agenda=0, $annee_choisie=0, $mois_choisi=0, $filtre='-1', $tri='normal') {
	static $count_evt_filtre = 0;

	if ($id_agenda == 0)
		return $count_evt_filtre;

	$evenements = agenda_recenser_evenement(0);
	$count_evt = count($evenements);
	$count_page = agenda_liste_paginer(0);

	$liste = NULL;
	if (($count_evt == 0) || ($count_page == 0))
		return $liste;
		
	// Determination de l'annee choisie si l'agenda est saisonnier	
	$contexte_aff = agenda_definir_contexte(0);
	$debut_saison = $contexte_aff['debut_saison'];
	if (intval($debut_saison) != 1) 
		$annee_choisie = (intval($mois_choisi) < intval($debut_saison)) ? $annee_choisie : strval(intval($annee_choisie)+1);

	$mois_courant = NULL;
	$nouveau_mois = FALSE;
	$count_evt_filtre = 0;

	for ($i=1;$i<=$count_evt;$i++) {
		$j = ($tri == 'inverse') ? $count_evt - $i + 1 : $i;
		if ($evenements[$j]['saison'] == $annee_choisie) {
			if (($filtre == '-1') || 
				(($filtre == '0') && (!$evenements[$j]['categorie'])) ||
				(($filtre != '-1') && ($filtre != 0) && (strpos($evenements[$j]['categorie'],$filtre) !== FALSE))) {

				$count_evt_filtre += 1;
				$mois_redac = $evenements[$j]['nom_mois'];
				if ($mois_redac != $mois_courant)  {
					$nouveau_mois = TRUE;
				}
				else {
					$nouveau_mois = FALSE;
				}

				if ($nouveau_mois) {
					if ($mois_courant) {
						$liste .= '</ul><br />';
					}
					$liste .= '<h2><a>'.ucfirst($evenements[$j]['nom_mois']).'&nbsp;'.$evenements[$j]['annee'].'</a></h2>';
					$liste .= '<ul>';
				}
				$mois_courant = $mois_redac;
				$liste .= '<li><a class="objet_titre" href="spip.php?page=evenement&amp;id_article='.$evenements[$j]['id'].'">
				<span class="objet_date">['.$evenements[$j]['date'].']&nbsp;</span>&nbsp;'.$evenements[$j]['titre'].'</a></li>';
			}
		}
	}

	if ($count_evt_filtre > 0)
		$liste .= '</ul><br />';

	return $liste;
}

// ===================================================
// Auteur: Smellup
// Fonction : Affichage des messages d'avertissement
// Utilisation : uniquement agenda annuel. Cas aucune page ou
//                      aucun evenement. Critere filtre et saison
// ===================================================
//
function agenda_liste_avertir($id_agenda, $annee_choisie, $mois_choisi) {

	$message = NULL;

	$contexte_aff = agenda_definir_contexte(0);
	$debut_saison = $contexte_aff['debut_saison'];
	$type_saison = $contexte_aff['type_saison'];		

	if (intval($debut_saison) != 1) 
		$annee_choisie = (intval($mois_choisi) < intval($debut_saison)) ? $annee_choisie : strval(intval($annee_choisie)+1);

	$count_evt = count(agenda_recenser_evenement(0));
	$count_evt_filtre = agenda_liste_afficher(0);

	if ($count_evt == 0)
		$message = _T('sarkaspip:msg_0_evt_agenda');
	else
		if ($count_evt_filtre == 0)
			if (intval($debut_saison) == 1)
				$message = _T('sarkaspip:msg_0_evt_annee').'&nbsp;'.$annee_choisie;
			else
				if ($type_saison == 'annee')
					$message = _T('sarkaspip:msg_0_evt_saison').'&nbsp;'.$annee_choisie;
				elseif ($type_saison == 'periode')
					$message = _T('sarkaspip:msg_0_evt_saison').'&nbsp;'.strval(intval($annee_choisie)-1).'-'.$annee_choisie;
				else // $type_saison == 'periode_abregee'
					$message = _T('sarkaspip:msg_0_evt_saison').'&nbsp;'.substr(strval(intval($annee_choisie)-1),2,2).'-'.substr($annee_choisie,2,2);

	return $message;
}

// ==================================================== AGENDA MINI ====================================================


// ===================================================
// Auteur: Smellup
// Fonction : Retourne le nom du jour en fonction de
//            son index. Le nom des jours est un item
//            de langue SPIP
// Utilisation : 
// ===================================================
//
function agenda_nom_jour($id_jour=0) {
	$nom_jour = array();
	
	array_push($nom_jour, _T('date_jour_1'), _T('date_jour_2'), _T('date_jour_3'), _T('date_jour_4'), 
						  _T('date_jour_5'), _T('date_jour_6'), _T('date_jour_7'));

	$jour = NULL;
	if (($id_jour >= 0) && ($id_jour < 7))
		$jour = $nom_jour[$id_jour];
	
	return $jour;
}


// ===================================================
// Auteur: Smellup
// Fonction : Insertion d'une bande de navigation dans
//            les mois precedents et suivants 
// Utilisation : Choix possible des icones suivant et 
//               precedent
// ===================================================
//
function agenda_mini_afficher($id_agenda=0, $icone_prec='&lt;&lt;', $icone_suiv='&gt;&gt;', 
											$jour_debut=0, $affichage_hors_mois='oui',
											$critere='oui', $max_mois=6, $taille=5) {

	if ($id_agenda == 0)
		return;
		
	$agenda = NULL;

	// Creation du header compose des items de navigation annee et mois
	$agenda .= agenda_mini_header($id_agenda, $icone_prec, $icone_suiv);
	
	// Creation du body compose du calendrier mensuel
	$agenda .= agenda_mini_body($id_agenda, $jour_debut, $affichage_hors_mois);
	
	// Creation du footer compose des items de navigation aujourd'hui et du resume des evenements du mois
	$agenda .= agenda_mini_footer($id_agenda, $critere, $max_mois, $taille);

	return $agenda;
}


function agenda_mini_header($id_agenda=0, $icone_prec='&lt;&lt;', $icone_suiv='&gt;&gt;') {

	$nom_mois = array(1 => _T('sarkaspip:janvier'), 2 => _T('sarkaspip:fevrier'), 3 => _T('sarkaspip:mars'), 4 => _T('sarkaspip:avril'), 
					5 => _T('sarkaspip:mai'), 6 => _T('sarkaspip:juin'), 7 => _T('sarkaspip:juillet'), 8 => _T('sarkaspip:aout'),
					9 => _T('sarkaspip:septembre'), 10 => _T('sarkaspip:octobre'), 11 => _T('sarkaspip:novembre'), 12 => _T('sarkaspip:decembre'));

	if ($id_agenda == 0)
		return;

	// Init du contexte
	$contexte_aff = agenda_definir_contexte(0);
	$mois_choisi = $contexte_aff['mois_base'];
	$annee_choisie = $contexte_aff['annee_base'];
	$url_base = $contexte_aff['url_base'];
	// Init de l'annee et du mois courant
	$mois_courant = affdate_base(date('Y-m-d'), 'mois');
	$annee_courante = affdate_base(date('Y-m-d'), 'annee');

	// Calcul des mois precedent et suivant
	$mois = $mois_choisi-1;
	if ($mois < 1) {
		$mois_prec = '12';
		$annee_prec = strval($annee_choisie-1);
	}	
	else {
		$mois_prec = strval($mois);
		$annee_prec = strval($annee_choisie);
	}	

	$mois = $mois_choisi+1;
	if ($mois > 12) {
		$mois_suiv = '1';
		$annee_suiv = strval($annee_choisie+1);
	}	
	else {
		$mois_suiv = strval($mois);
		$annee_suiv = strval($annee_choisie);
	}	
	// Calcul des annees precedente et suivante
	$annee_choisie_prec = strval($annee_choisie-1);
	$annee_choisie_suiv = strval($annee_choisie+1);
	// Calcul des mois et annees courants

	// Init de la chaine
	$header = NULL;
	// Debut de l'en-tete
	// Ligne 1 : pagination par annee
	$header .= '<h2><a class="titre_bloc bord ajax" href="'.$url_base.'calendrier_mois='.$mois_choisi.'&amp;calendrier_annee='.$annee_choisie_prec.'" title="'.$nom_mois[$mois_choisi].'&nbsp;'.$annee_choisie_prec.'">'.$icone_prec.'</a></h2>';
	$header .= '<h2 class="titre_bloc centre">'.$annee_choisie.'</h2>';   
	$header .= '<h2><a class="titre_bloc bord ajax" href="'.$url_base.'calendrier_mois='.$mois_choisi.'&amp;calendrier_annee='.$annee_choisie_suiv.'" title="'.$nom_mois[$mois_choisi].'&nbsp;'.$annee_choisie_suiv.'">'.$icone_suiv.'</a></h2>';
	// Ligne 2 : pagination par mois
	$header .= '<h2><a class="titre_bloc bord ajax" href="'.$url_base.'calendrier_mois='.$mois_prec.'&amp;calendrier_annee='.$annee_prec.'" title="'.$nom_mois[$mois_prec].'&nbsp;'.$annee_prec.'">'.$icone_prec.'</a></h2>';
	$header .= '<h2 class="titre_bloc centre">'.$nom_mois[$mois_choisi].'</h2>';   
	$header .= '<h2><a class="titre_bloc bord ajax" href="'.$url_base.'calendrier_mois='.$mois_suiv.'&amp;calendrier_annee='.$annee_suiv.'" title="'.$nom_mois[$mois_suiv].'&nbsp;'.$annee_suiv.'">'.$icone_suiv.'</a></h2>';
	// Ligne 3 : retour au mois du jour courant
	$header .= '<h2><a id="auj" class="titre_bloc ajax" href="'.$url_base.'calendrier_mois='.$mois_courant.'&amp;calendrier_annee='.$annee_courante.'" title="'.$nom_mois[intval($mois_courant)].'&nbsp;'.$annee_courante.'">'.ucfirst(_T('sarkaspip:aujourdhui')).'</a></h2>';
	// Fin de l'en-tete
	
	return $header;
}

// ===================================================
// Auteur: Smellup
// Fonction : Insertion du mini-calendrier du mois choisi
// Utilisation : Choix possible du jour de debut de la
//               semaine et de l'affichage des jours 
//               contigus hors mois choisi
// ===================================================
//
function agenda_mini_body($id_agenda=0, $jour_debut=0, $affichage_hors_mois='oui') {

	$nom_jour_abrege = array(	0 => _T('sarkaspip:dimanche_abrege'), 1 => _T('sarkaspip:lundi_abrege'), 2 => _T('sarkaspip:mardi_abrege'), 3 => _T('sarkaspip:mercredi_abrege'), 
						4 => _T('sarkaspip:jeudi_abrege'), 5 => _T('sarkaspip:vendredi_abrege'), 6 => _T('sarkaspip:samedi_abrege'));
	$nom_jour = array(	0 => _T('sarkaspip:dimanche'), 1 => _T('sarkaspip:lundi'), 2 => _T('sarkaspip:mardi'), 3 => _T('sarkaspip:mercredi'), 
						4 => _T('sarkaspip:jeudi'), 5 => _T('sarkaspip:vendredi'), 6 => _T('sarkaspip:samedi'));

	if ($id_agenda == 0)
		return;

	// Init du contexte
	$contexte_aff = agenda_definir_contexte(0);
	$mois_choisi = $contexte_aff['mois_base'];
	$annee_choisie = $contexte_aff['annee_base'];
	$url_base = $contexte_aff['url_base'];
	// Init des listes d'evenements
	$evenements = agenda_recenser_evenement(0);
	$mini_evenements = agenda_recenser_evenement(-1);

	$body = NULL;
	// Début du tableau
	$body .= '<table summary="'._T('sarkaspip:resume_mini_agenda_body').'">';
	
	// 1ere ligne : nom abrege des jours de dimanche a samedi
	$body .= '<thead>'; 
	$body .= '<tr>';
	for($i = 0; $i <= 6; $i++) {
		$j = ($jour_debut+$i)%7;
		$body .= '<th title="'.$nom_jour[$j].'">'.$nom_jour_abrege[$j].'</th>';
	}
	$body .= '</tr>';
	$body .= '</thead>';

	// Cellules des jours : de 4 a 5 lignes de 7 jours. Debut de la 2eme ligne
	$body .= '<tbody>'; 
	$body .= '<tr>';

	// Cellules des jours visibles precedant le mois courant (toujours inclus strictement dans la 2eme ligne)
	$cellules_mois_prec = NULL;
	$jour = 1;
	$date = mktime(0,0,0,$mois_choisi, $jour, $annee_choisie);
	while (date('w', $date) != $jour_debut) {
		$jour = $jour - 1;
		$date = mktime(0,0,0,$mois_choisi, $jour, $annee_choisie);

		$cellule = '<td class="horsperiode">';
		$cellule .= ($affichage_hors_mois == 'oui') ? strval(date('j', $date)) : '&nbsp;';
		$cellule .= '</td>';

		$cellules_mois_prec = $cellule.$cellules_mois_prec;
	}
	$body .= $cellules_mois_prec;

	// Remplissage des cellules du mois
	$jour = 1;
	$date = mktime(0,0,0,$mois_choisi, $jour, $annee_choisie);
	while (date('m', $date) == $mois_choisi) {
		if ((date('w', $date) == $jour_debut) && ($jour != 1))
			$body .= '</tr><tr>';

		$cellule = '<td class="';
		$cellule .= (date('d-m-Y', $date) == date('d-m-Y')) ? 'today">' : 'libre">';
		if (!isset($mini_evenements[date('d-m-Y', $date)])) {
			// Il n'y pas d'evenement pour ce jour, on affiche la date
			$cellule .= strval(date('j', $date));
		}
		else {
			// Il y a un ou plusieurs evenements, on construit le lien et la bulle d'info
			$index_evt1 = $mini_evenements[date('d-m-Y', $date)][0];
			$lien = 'spip.php?page=evenement&amp;id_article='.$evenements[$index_evt1]['id'];
			$bulle = $evenements[$index_evt1]['heure'].'&nbsp;-&nbsp;'.$evenements[$index_evt1]['titre'];
			if (count($mini_evenements[date('d-m-Y', $date)]) > 1)
				$bulle .= '...('.strval(count($mini_evenements[date('d-m-Y', $date)])).'&nbsp;'._T('sarkaspip:plusieurs_evenements_jour').')';
			$cellule .= '<a href="'.$lien.'" title="'.$bulle.'">'.strval(date('j', $date)).'</a>';		
		}
		$cellule .= '</td>';
		$body .= $cellule;

		$jour += 1;
		$date = mktime(0,0,0,$mois_choisi, $jour, $annee_choisie);
	}

	// Cellules des jours visibles suivant le mois courant (toujours inclus strictement dans la derniere ligne)
	while (date('w', $date) != $jour_debut) {
		$cellule = '<td class="horsperiode">';   //width="14%" valign="top"
		$cellule .= ($affichage_hors_mois == 'oui') ? strval(date('j', $date)) : '&nbsp;';
		$cellule .= '</td>';

		$body .= $cellule;
		$jour += 1;
		$date = mktime(0,0,0,$mois_choisi, $jour, $annee_choisie);
	}
	$body .= '</tr>';

	// Fin du tableau
	$body .= '</tbody>';
	$body .= '</table>';

	return $body;
}

// ===================================================
// Auteur: Smellup
// Fonction : Insertion du resume des evenements du mois
// Utilisation : Choix possible de la taille masx de la
//               liste et du critere de selection des 
//               evenements (tous le mois ou juste la  
//               fin du mois % date du jour)
// ===================================================
//
function agenda_mini_footer($id_agenda=0, $critere='oui', $max_mois=6, $taille=5) {

	$nom_mois = array(1 => _T('sarkaspip:janvier'), 2 => _T('sarkaspip:fevrier'), 3 => _T('sarkaspip:mars'), 4 => _T('sarkaspip:avril'), 
					5 => _T('sarkaspip:mai'), 6 => _T('sarkaspip:juin'), 7 => _T('sarkaspip:juillet'), 8 => _T('sarkaspip:aout'),
					9 => _T('sarkaspip:septembre'), 10 => _T('sarkaspip:octobre'), 11 => _T('sarkaspip:novembre'), 12 => _T('sarkaspip:decembre'));

	if ($id_agenda == 0)
		return;

	if ($taille == 0)
		return;

	// Init du contexte
	$contexte_aff = agenda_definir_contexte(0);
	$mois_choisi = $contexte_aff['mois_base'];
	$annee_choisie = $contexte_aff['annee_base'];
	$url_base = $contexte_aff['url_base'];
	// Init de l'annee et du mois courant
	$mois_courant = affdate_base(date('Y-m-d'), 'mois');
	$annee_courante = affdate_base(date('Y-m-d'), 'annee');
	// Init des listes d'evenements
	$evenements = agenda_recenser_evenement(0);
	$count_evt = count($evenements);

	// Init de la date de base pour calculer le nombre d'evenements du resume a afficher
	// - si le mois choisi est le mois courant, la date de base est la date courante, on affichera donc les evenements posterieurs
	// - si le mois choisi est antérieur ou posterieur au mois courant, la date de base est le 1er jour du mois
	if (($annee_choisie==$annee_courante) && ($mois_choisi==$mois_courant)) 
		$date_base = date('Y-m-d');
	else
		$date_base = date('Y-m-d', mktime(0,0,0,$mois_choisi,1,$annee_choisie));

	// Init de la chaine
	$footer = NULL;

	// Extraction des evenements du résumé si demande
	if ($critere == 'oui') {
		$i = 1;
		$liste_complete = FALSE;
		$cellule = NULL;
		$count_liste = 0;
		while ((!$liste_complete) && ($i <= $count_evt)) {
			$annee = $evenements[$i]['annee'];
			$mois = $evenements[$i]['mois'];
			$jour = $evenements[$i]['jour'];
			$date = mktime(0,0,0,$mois, $jour, $annee);
			if ((date('Y-m-d',$date) >= $date_base) && ($count_liste < $taille)) {
				if ($count_liste == 0) $cellule .= '<table id="footer_evenements" summary="'._T('sarkaspip:resume_mini_agenda_footer').'">';
				$cellule .= '<tr><td class="footer_colg">'.affdate_base($evenements[$i]['date_redac'], 'd-m H:i').':&nbsp;</td>';
				$cellule .= '<td class="footer_cold"><a href="spip.php?page=evenement&amp;id_article='.$evenements[$i]['id'].'">'.$evenements[$i]['titre'].'</a></td></tr>';
				$count_liste += 1;
			}
			$liste_complete = ($count_liste == $taille);
			$i += 1;
		}
		if ($count_liste == 0) {
			if ($max_mois == 1)
				$msg_erreur = _T('sarkaspip:agenda_1_mois_vide');
			else {
				$msg_erreur = _T('sarkaspip:agenda_n_mois_vides', array('mois'=>$max_mois));
			}
			$cellule .= '<div class="texte">'.$msg_erreur.'</div>';
		}
		else
			$cellule .= '</table>';

		$footer .= $cellule;
	}
	return $footer;
}
?>
