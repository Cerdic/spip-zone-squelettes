<?php
// ======================================================= AFFICHAGE DE LA GALERIE =======================================================

// =======================================================================================================================================
// Filtre : galerie_definir_contexte (balise #RUBRIQUE_GALERIE)
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : definition du contexte d'affichage de la galerie:
//            - listing annuel, avec choix du mois de debut de saison et du type d'affichage de la pagination
//            - planche contact
// Utilisation : Doit etre appelee au debut de l'affichage, avant le recensement
// Arguments :
//            - type_galerie : 'listing_annuel' ou  'planche_contact'
//            - debut_saison : [1..12] - inutile si type_galerie='planche_contact'
//            - type_saison : 'annee', 'periode' ou 'periode_abregee'
// =======================================================================================================================================
//
function galerie_definir_contexte($id_galerie=0, $type_galerie='listing_annuel', $debut_saison=1, $type_saison='annee') {
	static $contexte = array();

	if ($id_galerie == 0)
		return $contexte;
	
	$contexte['type_galerie'] = $type_galerie;
	$contexte['debut_saison'] = $debut_saison;
	$contexte['type_saison'] = $type_saison;

  //echo 'type_galerie = '.$type_galerie;
	return;
}

// =======================================================================================================================================
// Filtre : galerie_recencer_album (balise #RUBRIQUE_GALERIE)
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : recensement de tous les albums dans une liste
// Utilisation : Doit etre appelee au debut de l'affichage, apres etablissement du contexte
//               L'appel de ce filtre se fait ˆ l'interieur de la boucle ARTICLES de recensement des articles-albums.
//               La boucle doit etre triee en ordre chrono par via le critere {par date}
// Arguments :
//            - id : id de l'article ˆ recenser comme album
//            - date : date de publication de l'article ˆ recenser comme album
//            - titre : titre de l'article ˆ recenser comme album
//            - logo : logo du premier document rencontre ou logo de l'article si aucun document
//            - introduction : introduction de l'article
// =======================================================================================================================================
//
function galerie_recenser_album($id_galerie=0, $id=0, $date=0, $titre='', $logo='', $introduction='') {
	static $type_galerie, $count_album = 0, $liste_album = array();

	if ($id_galerie == 0)
		return $liste_album;
		
	if ($id_galerie == -1) {
		// Cas particulier d'une mise a jour de la planche d'un element de la liste demandee par la fonction de pagination
		// On utilise l'$id comme index dans la liste et $date comme numero de la planche
		$liste_album[$id]['planche'] = $date;
		return;
	}

	$contexte_aff = galerie_definir_contexte(0);
	$debut_saison = $contexte_aff['debut_saison'];
	$type_saison = $contexte_aff['type_saison'];

	if ($type_galerie != $contexte_aff['type_galerie']) {
		$count_album = 0;
		$liste_album = array();
		$type_galerie = $contexte_aff['type_galerie'];
	}

	// Liste ordonnee des albums (tableau[1..n] d'albums)
	$count_album += 1;

	$jour = affdate_base($date, 'jour');
	$mois = affdate_base($date, 'mois');
	$annee = affdate_base($date, 'annee');

	$liste_album[$count_album]['id'] = $id;
	$liste_album[$count_album]['date_article'] = $date;
	$liste_album[$count_album]['date'] = affdate_base($date, 'd-m-Y');
	$liste_album[$count_album]['jour'] = $jour;
	$liste_album[$count_album]['mois'] = $mois;
	$liste_album[$count_album]['annee'] = $annee;
	$liste_album[$count_album]['nom_mois'] = affdate_base($date, 'nom_mois');
	$liste_album[$count_album]['titre'] = $titre;
	$liste_album[$count_album]['planche'] = 0;

	if (intval($debut_saison) == 1) {
		$liste_album[$count_album]['saison'] = $annee;
		$liste_album[$count_album]['lien_page'] = $liste_album[$count_album]['saison'];
	}
	else {
		$liste_album[$count_album]['saison'] = (intval($mois) < intval($debut_saison)) ? $annee : strval(intval($annee)+1);
		if ($type_saison == 'annee')
			$liste_album[$count_album]['lien_page'] = $liste_album[$count_album]['saison'];
		elseif ($type_saison == 'periode')
			$liste_album[$count_album]['lien_page'] = (intval($mois) < intval($debut_saison)) ? strval(intval($annee)-1).'-'.$annee	: $annee.'-'.strval(intval($annee)+1);
		else // $type_saison == 'periode_abregee'
			$liste_album[$count_album]['lien_page'] = (intval($mois) < intval($debut_saison)) ? substr(strval(intval($annee)-1),2,2).'-'.substr($annee,2,2)	: substr($annee,2,2).'-'.substr(strval(intval($annee)+1),2,2);
	}
	
	$id_article = intval($id);
	$select = array('t2.id_mot AS id_mot');
	$from = array('spip_mots_articles AS t1', 'spip_mots AS t2');
	$where = array('t2.type='.sql_quote('squelette_galerie'),
				   't1.id_article='.sql_quote($id_article),
				   't2.id_mot=t1.id_mot');
	$result = sql_select($select, $from, $where);
	$cat = NULL;
	while ($row = sql_fetch($result))
		$cat .= '|'.$row['id_mot'];
	$liste_album[$count_album]['categorie'] = $cat;

	$liste_album[$count_album]['logo'] = $logo;
	$liste_album[$count_album]['auteurs'] = $auteurs;
	$liste_album[$count_album]['intro'] = $introduction;
        
	$id_article = intval($id);
	$select = array('t1.nom AS nom', 't1.id_auteur AS id_auteur');
	$from = array('spip_auteurs AS t1', 'spip_auteurs_articles AS t2');
	$where = array('t1.id_auteur=t2.id_auteur',
				   't2.id_article='.sql_quote($id_article));
	$result = sql_select($select, $from, $where);
	$auteurs = NULL;
	while ($row = sql_fetch($result)) {
		if ($auteurs) $auteurs .= ', ';
                $auteurs .= '<a href="spip.php?page=auteur&amp;id_auteur='.$row['id_auteur'].'">'.$row['nom'].'</a>';
        }
	$liste_album[$count_album]['auteurs'] = $auteurs;
	
	return;
}

// =======================================================================================================================================
// Filtre : galerie_paginer (balise #RUBRIQUE_GALERIE)
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Insertion d'une bande de pagination specifique au type de galerie choisi
// Utilisation : Doit etre appelee apres le recensement ˆ l'endroit ou aux endroits souhaites de la page
// Arguments :
//            - page_choisie : si type_galerie=listing_annuel correspond a une annee sinon correspond au numero de planche
//            - filtre : -1 pour aucun filtre, 0 pour sans categorie, valeur>1 correspondant ˆ l'id du mot-cle caracterisant la categorie
//            - separateur : chaine de seperation des items de pagination
//            - ancre : suffixe de nommage de l'ancre de pagination
//            - tri : 'normal' pour conserver le tri chronologique de la liste, 'inverse' pour un tri antichronologique
//
//            Pour une galerie de type 'planche_contact' uniquement:
//            - pas : valeur du pas de pagination
//            - type : 'page' pour un affichage des numeros de page, 'numero' pour un affichage des numeros d'albums
// =======================================================================================================================================
//
function galerie_paginer($id_galerie=0, $page_choisie=0, $mois_choisi=0, $filtre='-1', $separateur='&nbsp;|&nbsp;', $ancre=NULL, $tri='normal', $pas=5, $type='page') {

	$contexte_aff = galerie_definir_contexte(0);
	if ($contexte_aff['type_galerie'] == 'listing_annuel') {
		$annee_choisie = ($page_choisie == 0) ? affdate_base(date("Y-m-d H:i"), 'annee') : $page_choisie;
		return galerie_listing_paginer($id_galerie, $annee_choisie, $mois_choisi, $filtre, $separateur, $ancre, $tri);
	}
	else {
		// Test > 1900 temporaire tant que le parametrage CFG n'est pas effectif 
		$planche_choisie = (($page_choisie == 0) || ($page_choisie > 1900)) ? 1 : $page_choisie;
		return galerie_planche_paginer($id_galerie, $planche_choisie, $filtre, $separateur, $ancre, $tri, $pas, $type);
	}
}

function galerie_listing_paginer($id_galerie, $annee_choisie, $mois_choisi, $filtre, $separateur, $ancre, $tri) {
	static $count_page = 0;
	
	if ($id_galerie == 0)
		return $count_page;

	$albums = galerie_recenser_album(0);
	$count_album = count($albums);

	$pagination = NULL;
	if ($count_album == 0) 
		return $pagination;
		
	if ($ancre)
		echo '<a class="ancre" name="pagination_'.$ancre.'" id="pagination_'.$ancre.'"></a>';

	// Determination de l'annee choisie si l'agenda est saisonnier	
	$contexte_aff = galerie_definir_contexte(0);
	$debut_saison = $contexte_aff['debut_saison'];
	if (intval($debut_saison) != 1) {
		$annee_choisie = (intval($mois_choisi) < intval($debut_saison)) ? $annee_choisie : strval(intval($annee_choisie)+1);
	}

	$annee_courante = 0;
	$nouvelle_annee = FALSE;
	$count_page = 0;

	for ($i=1;$i<=$count_album;$i++) {
		$j = ($tri == 'inverse') ? $count_album - $i + 1 : $i;
		if (($filtre == '-1') || 
			(($filtre == '0') && (!$albums[$j]['categorie'])) ||
			(($filtre != '-1') && ($filtre != '0') && (strpos($albums[$j]['categorie'],$filtre) !== FALSE))) {

			$annee_album = $albums[$j]['saison'];
			$annee_alb = $albums[$j]['annee'];
			$mois_alb = $albums[$j]['mois'];
			if ($annee_album != $annee_courante)  {
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
				if ($annee_album == $annee_choisie) {
					$pagination .= '<span class="on">'.$albums[$j]['lien_page'].'</span>';
				}
				else {
					$arg_option = NULL;
					if ($filtre != '-1') $arg_option = '&amp;categorie='.$filtre;
					if ($ancre) $arg_option .= '#pagination_'.$ancre;
					if (intval($debut_saison) != 1) $annee_alb = (intval($mois_alb) < intval($debut_saison)) ? strval(intval($annee_alb)-1) : $annee_alb;
					$pagination .= '<a href="spip.php?page=galerie&amp;annee='.$annee_alb.'&amp;mois='.$debut_saison.$arg_option.'">'.$albums[$j]['lien_page'].'</a>';
				}
			$annee_courante = $annee_album;
			}
		}
	}
	return $pagination;
}

function galerie_planche_paginer($id_galerie, $planche_choisie, $filtre, $separateur, $ancre, $tri, $pas, $type) {
	static $count_page = 0;
	
	if ($id_galerie == 0)
		return $count_page;

	$albums = galerie_recenser_album(0);
	$count_album = count($albums);

	$pagination = NULL;
	if (($count_album == 0) || ($pas == 0)) 
		return $pagination;
		
	if ($ancre)
		echo '<a class="ancre" name="pagination_'.$ancre.'" id="pagination_'.$ancre.'"></a>';

	$count_alb_filtre = 0;
	$nouvelle_page = FALSE;
	for ($i=1;$i<=$count_album;$i++) {
		$j = ($tri == 'inverse') ? $count_album - $i + 1 : $i;
		if (($filtre == '-1') || 
			(($filtre == '0') && (!$albums[$j]['categorie'])) ||
			(($filtre != '-1') && ($filtre != '0') && (strpos($albums[$j]['categorie'],$filtre) !== FALSE))) {

			$count_alb_filtre += 1;
			$page_album = floor(($count_alb_filtre-1)/$pas) + 1;
			galerie_recenser_album(-1, $j, $page_album);
			if ($page_album != $count_page)  {
				$nouvelle_page = TRUE;
			}
			else {
				$nouvelle_page = FALSE;
			}
		
			if ($nouvelle_page) {
				if ($count_page != 0) {
					$pagination .= $separateur;
				}
				
				$item_pagination = ($type == 'page') ? $page_album : ($page_album-1)*$pas;
				if ($page_album == $planche_choisie) {
					$pagination .= '<span class="on">'.$item_pagination.'</span>';
				}
				else {
					$arg_option = NULL;
					if ($filtre != '-1') $arg_option = '&amp;categorie='.$filtre;
					if ($ancre) $arg_option .= '#pagination_'.$ancre;
					$pagination .= '<a href="spip.php?page=galerie&amp;planche='.$page_album.$arg_option.'">'.$item_pagination.'</a>';
				}
			$count_page = $page_album;
			}
		}
	}
	return $pagination;
}

// =======================================================================================================================================
// Filtre : galerie_afficher (balise #RUBRIQUE_GALERIE)
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Affichage des albums de la galerie sous forme de listing chronologique ou de planche contact
// Utilisation : Doit etre appelee apres le recensement et normalement apres l'affichage de la pagination
// Arguments :
//            - page_choisie : si type_galerie=listing_annuel correspond a une annee sinon correspond au numero de planche
//            - filtre : -1 pour aucun filtre, 0 pour sans categorie, valeur>1 correspondant ˆ l'id du mot-cle caracterisant la categorie
//            - tri : 'normal' pour conserver le tri chronologique de la liste, 'inverse' pour un tri antichronologique
// =======================================================================================================================================
//
function galerie_afficher($id_galerie=0, $page_choisie=0, $mois_choisi=0, $filtre='-1', $tri='normal') {

	$contexte_aff = galerie_definir_contexte(0);
	if ($contexte_aff['type_galerie'] == 'listing_annuel') {
		$annee_choisie = ($page_choisie == 0) ? affdate_base(date("Y-m-d H:i"), 'annee') : $page_choisie;
		return galerie_listing_afficher($id_galerie, $annee_choisie, $mois_choisi, $filtre, $tri);
	}
	else {
		// Test > 1900 temporaire tant que le parametrage CFG n'est pas effectif 
		$planche_choisie = (($page_choisie == 0) || ($page_choisie > 1900)) ? 1 : $page_choisie;
		return galerie_planche_afficher($id_galerie, $planche_choisie, $filtre, $tri);
	}
}

function galerie_listing_afficher($id_galerie, $annee_choisie, $mois_choisi, $filtre, $tri) {
	static $count_album_filtre = 0;
	
	if ($id_galerie == 0)
		return $count_album_filtre;

	$albums = galerie_recenser_album(0);
	$count_album = count($albums);
	$count_page = galerie_paginer(0);

	$liste = NULL;
	if (($count_album == 0) || ($count_page == 0))
		return $liste;

	// Determination de l'annee choisie si l'agenda est saisonnier	
	$contexte_aff = galerie_definir_contexte(0);
	$debut_saison = $contexte_aff['debut_saison'];
	if (intval($debut_saison) != 1) {
		$annee_choisie = (intval($mois_choisi) < intval($debut_saison)) ? $annee_choisie : strval(intval($annee_choisie)+1);
	}

	$mois_courant = NULL;
	$nouveau_mois = FALSE;
	$count_album_filtre = 0;
	
	$liste .= '<div class="plan">';
		
	for ($i=1;$i<=$count_album;$i++) {
		$j = ($tri == 'inverse') ? $count_album - $i + 1 : $i;
		if ($albums[$j]['saison'] == $annee_choisie) {
			if (($filtre == '-1') || 
				(($filtre == '0') && (!$albums[$j]['categorie'])) ||
				(($filtre != '-1') && ($filtre != 0) && (strpos($albums[$j]['categorie'],$filtre) !== FALSE))) {

				$count_album_filtre += 1;

				$mois_album = $albums[$j]['nom_mois'];
				if ($mois_album != $mois_courant)  {
					$nouveau_mois = TRUE;
				}
				else {
					$nouveau_mois = FALSE;
				}
			
				if ($nouveau_mois) {
					if ($mois_courant) {
						$liste .= '</ul><br />';
					}
					$liste .= '<h2><a>'.$albums[$j]['nom_mois'].'&nbsp;'.$albums[$j]['annee'].'</a></h2>';
					$liste .= '<ul>';
				}
				$mois_courant = $mois_album;
				$liste .= '<li><a class="objet_titre" href="spip.php?page=album&amp;id_article='.$albums[$j]['id'].'">
				<span class="objet_date">['.$albums[$j]['date'].']&nbsp;</span>&nbsp;'.$albums[$j]['titre'].'</a></li>';
			}
		}
	}
	if ($count_album_filtre > 0)
		$liste .= '</ul><br />';

	$liste .= '</div>';

	return $liste;
}

function galerie_planche_afficher($id_galerie, $planche_choisie, $filtre, $tri) {
	static $count_album_filtre = 0;
	
	if ($id_galerie == 0)
		return $count_album_filtre;

	$albums = galerie_recenser_album(0);
	$count_album = count($albums);
	$count_page = galerie_paginer(0);

	$liste = NULL;
	if (($count_album == 0) || ($count_page == 0))
		return $liste;
  
  $liste .= '<ul class="galerie">';
	for ($i=1;$i<=$count_album;$i++) {
		$j = ($tri == 'inverse') ? $count_album - $i + 1 : $i;
		if ($albums[$j]['planche'] == $planche_choisie) {
			$count_album_filtre += 1;

			//$liste .= '<div class="galerie-album" id="planche">';
			//$liste .= '<div class="vignette"><a href="spip.php?page=album&amp;id_article='.$albums[$j]['id'].'" title="'._T('sarkaspip:info_afficher_album').'">'.$albums[$j]['logo'].'</a></div>';
			//$liste .= '<div class="detail">'.nom_jour($albums[$j]['date_article']).'&nbsp;'.$albums[$j]['date'].'<br />'._T('sarkaspip:par_auteur').$albums[$j]['auteurs'].'</div>';
			//$liste .= '<a class="titre" href="spip.php?page=album&amp;id_article='.$albums[$j]['id'].'" title="'._T('sarkaspip:info_afficher_album').'">'.$albums[$j]['titre'].'</a>';
			//$liste .= '<div class="introduction">'.$albums[$j]['introduction'].'</div><br /><br />';
			//$liste .= '<a class="suite" href="spip.php?page=album&amp;id_article='.$albums[$j]['id'].'">'._T('sarkaspip:info_afficher_album').'</a>';
			//$liste .= '</div>';
			
			$liste .= '<li>';
			$liste .= '<h3>'.$albums[$j]['titre'].'</h3>';
			$liste .= '<a href="spip.php?page=album&amp;id_article='.$albums[$j]['id'].'" title="'._T('sarkaspip:info_afficher_album').'">'.$albums[$j]['logo'].'</a>';
			$liste .= '<div class="introduction">'.$albums[$j]['introduction'].'</div><br /><br />';
			$liste .= '</li>';
		}
	}
  $liste .= '</ul>';
	return $liste;
}

// =======================================================================================================================================
// Filtre : galerie_avertir (balise #RUBRIQUE_GALERIE)
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Affichage des messages d'avertissement
// Utilisation : Doit etre appelee apres l'affichage de la galerie si l'on veut afficher un message d'erreur dans le cas ou aucun album
//               n'est trouve
// Arguments :
//            - page_choisie : si type_galerie=listing_annuel correspond a une annee sinon correspond au numero de planche
// =======================================================================================================================================
//
function galerie_avertir($id_galerie=0, $page_choisie=0, $mois_choisi=0) {

	$message = NULL;

	$contexte_aff = galerie_definir_contexte(0);
	$type_galerie = $contexte_aff['type_galerie'];
	$debut_saison = $contexte_aff['debut_saison'];
	$type_saison = $contexte_aff['type_saison'];		

	if ($type_galerie == 'listing_annuel')
		$annee_choisie = ($page_choisie == 0) ? affdate_base(date("Y-m-d H:i"), 'annee') : $page_choisie;
		if (intval($debut_saison) != 1) 
			$annee_choisie = (intval($mois_choisi) < intval($debut_saison)) ? $annee_choisie : strval(intval($annee_choisie)+1);
	else 
		// Test > 1900 temporaire tant que le parametrage CFG n'est pas effectif 
		$planche_choisie = (($page_choisie == 0) || ($page_choisie > 1900)) ? 1 : $page_choisie;
	
	$count_alb = count(galerie_recenser_album(0));
	$count_alb_filtre = galerie_afficher(0);

	if ($count_alb == 0)
		$message = _T('sarkaspip:msg_0_album_galerie');
	else {
		if ($type_galerie == 'listing_annuel') {
			if ($count_alb_filtre == 0) {
				if (intval($debut_saison) == 1)
					$message = _T('sarkaspip:msg_0_album_filtre_annee').'&nbsp;'.$annee_choisie;
				else {
					if ($type_saison == 'annee')
						$message = _T('sarkaspip:msg_0_album_filtre_saison').'&nbsp;'.$annee_choisie;
					elseif ($type_saison == 'periode')
						$message = _T('sarkaspip:msg_0_album_filtre_saison').'&nbsp;'.strval(intval($annee_choisie)-1).'-'.$annee_choisie;
					else // $type_saison == 'periode_abregee'
						$message = _T('sarkaspip:msg_0_album_filtre_saison').'&nbsp;'.substr(strval(intval($annee_choisie)-1),2,2).'-'.substr($annee_choisie,2,2);
				}
			}
		}
		else {
			if ($count_alb_filtre == 0)
				$message = _T('sarkaspip:msg_0_album_filtre_planche');
		}
	}
	
	return $message;
}


// =======================================================================================================================================
// Filtre : galerie_debug_album (balise #RUBRIQUE_GALERIE)
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : affichage debug du tableau des albums
// Utilisation : A tout moment apres le recensement des albums
// Arguments : aucun
// =======================================================================================================================================
//
function galerie_debug_album($id_galerie=0) {

	$albums = galerie_recenser_album(0);
	$count_album = count($albums);

	for ($i=1;$i<=$count_album;$i++) {
		echo '<br /><strong>ALBUM N°'.$i.'</strong><br />';
		echo '<strong>Titre</strong>: '.$albums[$i]['titre'].'<br />';
		echo '<strong>Id</strong>: '.$albums[$i]['id'].'<br />';
		echo '<strong>Date Article</strong>: '.$albums[$i]['date_article'].'<br />';
		echo '<strong>Jour</strong>: '.$albums[$i]['jour'].'<br />';
		echo '<strong>Mois</strong>: '.$albums[$i]['mois'].'<br />';
		echo '<strong>Annee</strong>: '.$albums[$i]['annee'].'<br />';
		echo '<strong>Nom du mois</strong>: '.$albums[$i]['nom_mois'].'<br />';
		echo '<strong>Saison</strong>: '.$albums[$i]['saison'].'<br />';
		echo '<strong>Lien page</strong>: '.$albums[$i]['lien_page'].'<br />';
		echo '<strong>Planche</strong>: '.$albums[$i]['planche'].'<br />';
		echo '<strong>Categorie</strong>: '.$albums[$i]['categorie'].'<br />';
		echo '<strong>Logo</strong>: '.$albums[$i]['logo'].'<br />';
		echo '<strong>Auteurs</strong>: '.$albums[$i]['auteurs'].'<br />';
		echo '<strong>Introduction</strong>: '.$albums[$i]['intro'].'<br />';
	}
		
	return;
}

?>
