<?php
/*
+-------------------------------------------+
| GAFoSPIP - les pages de gestion
+-------------------------------------------+
| Gestion Alternative des Forums SPIP
| v. 0.1 - 10/08/05
+-------------------------------------------+
| Hugues AROUX - SCOTY @ koakidi.com
+-------------------------------------------+
| Pour Forums sur structure type : SPIPForum
+-------------------------------------------+
*/


include ("inc.php3");
include_ecrire ("inc_index.php3");
include ("gaf_inc.php");


// Est-ce moi qui est posé le lock gafart ?
$auth_deplace = auth_deplace_connecte();


// prepa hierarchie .. si page hotel(default/2e), forums (case:forums), sujet(case:sujet)
if($rub_act)
	{
	// + prepa info rubrique(salon)
	$req_srg =	"SELECT id_rubrique, id_parent, titre, descriptif 
				FROM spip_rubriques 
				WHERE id_rubrique=$rub_act";
	$res_srg = spip_query($req_srg);
	$row=spip_fetch_array($res_srg);

	$id_salon = $row['id_rubrique'];
	$titre_salon = $row['titre'];
	$desc_salon = $row['descriptif'];
	$id_parent_salon = $row['id_parent'];
	}

if($id_article)
	{
	// +  prepa info forum(article)
	$req_af = 	"SELECT id_article, titre, descriptif, id_rubrique, accepter_forum 
				FROM spip_articles 
				WHERE id_article = $id_article";
	$res_af = spip_query($req_af);
	$row=spip_fetch_array($res_af);
		$id_forum = $row['id_article'];
		$titre_forum = $row['titre'];
		$desc_forum = $row['descriptif'];
		$rub_act=$row['id_rubrique'];
		$accepter_forum = $row['accepter_forum'];
	}

if($id_sujet)
	{
	$req_afs = "SELECT id_article, statut FROM spip_forum WHERE id_forum=$id_sujet";
	$res_afs = spip_query($req_afs);
	$row=spip_fetch_array($res_afs);
	$statut_sujet = $row['statut'];
	$art_act=$row['id_article'];
	}



debut_page("GAF", "suivi", "gafospip");
	echo "<a name='haut_page'></a>";
	echo "<br>";
gros_titre(_T('phpbb:gaf_titre'));


debut_gauche();


// bloc hierarchie
debut_cadre_enfonce("");
aff_parents($rub_act, $art_act);
fin_cadre_enfonce();


// Les posts ('prop') en attente de moderation
if ($connect_statut == '0minirezo' AND acces_rubrique($rub_act))
	{
	$result = spip_query ("SELECT SQL_CALC_FOUND_ROWS id_forum, titre, id_thread 
							FROM spip_forum WHERE statut='prop' 
							ORDER BY date_heure LIMIT 0,10");
	// récup nombre total d'entrées de $result (mysql 4.0.0 mini)
	$ttligne= spip_query("SELECT FOUND_ROWS()");
	list($nbrprop) = @spip_fetch_array($ttligne);
	if($nbrprop)
		{
		echo "<div>&nbsp;</div><div class='bandeau_rubriques' style='z-index: 1;'>";
		bandeau_titre_boite2(_T('phpbb:poste_valide'),"gaf_p_prop.gif");
		echo "<div class='plan-articles'>";
		while($row = spip_fetch_array($result))
			{
			$idprop=$row['id_forum'];
			$titreprop=$row['titre'];
			$idthread=$row['id_thread'];
			$urlprop = url_post_tranche($idprop, $idthread);
			$ico_prop = ($idprop==$idthread) ? "gaf_sujet-12.gif" : "gaf_post-12.gif" ;
			echo "<a href='".$urlprop."'>".couper($titreprop,30)."</a>\n";
			}
		if($nbrprop>10) { echo _T('phpbb:etplus'); }
		echo "</div></div><br>\n";
		}
	}


// alerte fermeture pour maintenance
alerte_maintenance();


// page 'effacer'
if ($connect_statut == '0minirezo' AND $connect_toutes_rubriques)
{
echo "<a href='gaf_admin.php?page=effacer'>";
echo "<div style='margin-top:2px;' class='bouton36blanc' onMouseOver=\"changeclass(this,'bouton36gris')\"
				onMouseOut=\"changeclass(this,'bouton36blanc')\">";
echo "<img src='"._DIR_IMG_PACK."poubelle.gif' border='0' align='absmiddle'>";
echo "<span class='verdana2'><b>&nbsp;"._T('phpbb:poste_efface')."</b></span>";
echo "</div></a>";
}


// signature
	signature_gaf();

// info-legende
	echo "<br>";
	debut_boite_info();
	$invisible = 1;
	if ($invisible)
		echo bouton_block_invisible("icones_gaf");
	else
		echo bouton_block_visible("icones_gaf");
	echo _T('phpbb:info_icones');
	if ($invisible)
		echo debut_block_invisible("icones_gaf");
	else
		echo debut_block_visible("icones_gaf");
	
		echo http_img_pack("gaf_hall.gif", "", "vspace='4' align='absmiddle' border='0'")._T('phpbb:rubrique_secteur');
		echo http_img_pack("gaf_salon.gif", "", "vspace='4' align='absmiddle' border='0'")._T('phpbb:sousrub_salon');
		echo http_img_pack("gaf_forum.gif", "", "vspace='4' align='absmiddle' border='0'")._T('phpbb:article_forum');
		echo http_img_pack("gaf_sujet.gif", "", "vspace='4' align='absmiddle' border='0'")._T('phpbb:fil_sujet');
		echo http_img_pack("gaf_post.gif", "", "vspace='4' align='absmiddle' border='0'")._T('phpbb:poste_reponse');
	
	echo fin_block();
	fin_boite_info();


debut_droite();


switch ($page)
{

default:

if($id_parent_salon==0)
{
// trouver rubrique secteur (hotel) des forums
$req_rg =	"SELECT smr.id_rubrique, sr.titre, sr.descriptif 
			FROM spip_mots_rubriques smr 
			LEFT JOIN spip_rubriques sr ON sr.id_rubrique = smr.id_rubrique
			WHERE smr.id_mot = $id_mot_rub_gaf";
$res_rg = spip_query($req_rg);
while ($row=spip_fetch_array($res_rg))
	{
	$id_hotel = $row['id_rubrique'];
	$titre_hotel = $row['titre'];
	$desc_hotel = $row['descriptif'];
	
	// entete
	debut_cadre_formulaire("");
	echo "\n<table cellpadding=0 cellspacing=0 border=0 width='600'>";
	echo "<tr width='100%'>\n";
	echo "<td valign='top'>";
	echo "<img src='"._DIR_IMG_PACK."gaf_hall.gif' border='0' align='absmiddle'>\n";
	echo "<span class='verdana2'>".$id_hotel."</span>";	
	echo "</td>\n";
	echo "<td>" . http_img_pack('rien.gif', " ", "width='10'") ."</td>\n";
	echo "<td width='100%' valing='top'>\n";
	echo "<span class='verdana2'>"._T('phpbb:secteur')."</span>";
	gros_titre($titre_hotel);
	echo "<span class='arial2'>".propre($desc_hotel)."</span>\n";
	echo "</td><td>";
	echo "</td></tr></table><br>";

	
// les salons
	$req_srg =	"SELECT id_rubrique, titre, descriptif 
				FROM spip_rubriques 
				WHERE id_parent=$id_hotel";
	$res_srg = spip_query($req_srg);
	while ($row=spip_fetch_array($res_srg))
		{
		$id_salon = $row['id_rubrique'];
		$titre_salon = $row['titre'];
		$desc_salon = $row['descriptif'];
		
		$ifond = $ifond ^ 1;
		$coul_salon = ($ifond) ? $couleur_claire : '#e3e3e3';
	
		debut_bloc_couleur($coul_salon);
		echo "\n<table cellpadding='3' cellspacing='0' border='0' width='100%'>";
		echo "<tr width='100%'>";
		echo "<td valign='top' rowspan='2'>";
		icone(_T('phpbb:salon_ouvrir'), "gaf_admin.php?rub_act=$id_salon", "gaf_salon.gif", "rien.gif");
		echo "<span class='verdana2'>".$id_salon."</span>";
		echo "</td>";
		echo "<td  width='100%' valign='top'>";
		echo "<span class='verdana3'><b>".propre($titre_salon)."</b></span><br>";
		echo "<span class='verdana2'>".propre($desc_salon)."<span>";
		echo "</td></tr><tr>";
		echo "<td valign='top'>";

		echo "</td></tr></table>";
		fin_bloc();

		}

	//
	// les 20 derniers sur tous salons
	//
	$req = "SELECT id_forum, id_thread, date_heure, auteur, titre FROM spip_forum
				WHERE statut IN ('publie', 'off', 'prop') 
				ORDER BY date_heure DESC LIMIT 0,20";
	$res = spip_query($req);

	// prepa tableau derniers posts gen ...
	echo "<br>\n<table cellpadding='3' cellspacing='0' border='0' width='100%'>\n";

	while ($row = spip_fetch_array($res))
		{
		$id_post = $row['id_forum'];
		$date_rel = date_relative($row['date_heure']);
		$aut_post = $row['auteur'];
		$id_sujet = $row['id_thread'];
		$titre_post = $row['titre'];
		$url_post = url_post_tranche($id_post, $id_sujet);
		
		$ifond = $ifond ^ 1;
		$coul_ligne = ($ifond) ? $couleur_claire : '#ffffff';
	
		echo "<tr width='100%' bgcolor='".$coul_ligne."'>\n";
		echo "<td class='verdana2' width='20%'>";
		echo "".$date_rel."</td>\n";
		echo "<td valign='middle' class='verdana2' width='20%'>";
		echo "".$aut_post."</td>\n";
		echo "<td class='verdana2'>";
		echo "<img src='"._DIR_IMG_PACK."gaf_post-12.gif' border='0' align='absmiddle'>&nbsp;";
		echo "<b><a href='".$url_post."'>".couper(propre($titre_post), "40")."</a></b></td>\n";
		echo "</tr>";

		}
	echo "</table>\n";
	//
	
	fin_cadre_formulaire();
	}		
}	
else
{
debut_cadre_formulaire("");
// présenter UN salon
// info salon dans prépa en tete de script		
	// créer un nouveau forum (nouvel article)
	if ($connect_statut == '0minirezo' AND acces_rubrique($id_salon))
		{
		echo "<div style='float:right; padding:2px;'>";
		icone(_T('phpbb:creer_forum'), "articles_edit.php3?id_rubrique=$rub_act&new=oui", "gaf_forum.gif","creer.gif");
		echo "</div>";
		}

	echo "\n<table cellpadding=0 cellspacing=0 border=0 width='600'>";
	echo "<tr width='100%'>";
	echo "<td valign='top'>";
	echo "<img src='"._DIR_IMG_PACK."gaf_salon.gif' border='0' valign='absmiddle'>";
	echo "<span class='verdana2'>".$id_salon."</span>";	
	echo "</td>";
	echo "<td>" . http_img_pack('rien.gif', " ", "width='10'") ."</td>\n";
	echo "<td width='100%' valing='top'>";
	echo "<span class='verdana2'>"._T('phpbb:salon')."</span>";
	gros_titre($titre_salon);
	echo "<span class='arial2'>".propre($desc_salon)."</span>";
	echo "</td><td>";
	echo "</td></tr></table><br>";
	

	// trouver les forums de ce salon
	$req_af = 	"SELECT id_article, titre, descriptif 
				FROM spip_articles 
				WHERE id_rubrique = $id_salon";
				
	$res_af = spip_query($req_af);
	
	$ifond=0;
	
	while ($row=spip_fetch_array($res_af))
		{
		$id_forum = $row['id_article'];
		$titre_forum = $row['titre'];
		$desc_forum = $row['descriptif'];
		
		// nbre total de sujets de ce $id_forum
		$req_sujet= "SELECT id_forum FROM spip_forum 
					WHERE id_article='$id_forum' 
					AND id_parent=0 AND statut IN ('publie', 'off', 'prop') 
					"; 
		$res_sujet = spip_query($req_sujet);
		$nbr_sujet=spip_num_rows($res_sujet);
		
		// nombre total de posts de ce $id_forum
		$req_post= "SELECT id_forum FROM spip_forum 
					WHERE id_article='$id_forum' AND statut IN ('publie', 'off', 'prop') 
					"; 
		$res_post = spip_query($req_post);
		$nbr_post=spip_num_rows($res_post);
		
		// dernier post
		$req_date = "SELECT id_forum, id_thread, DATE_FORMAT(date_heure, '%d/%m/%Y %H:%i') AS dateur 
					FROM spip_forum
					WHERE id_article=$id_forum AND statut IN ('publie', 'off', 'prop') 
					ORDER BY date_heure DESC LIMIT 0, 1";
		$res_date = spip_query($req_date);
		$row = spip_fetch_array($res_date);
		$id_post = $row['id_forum'];
		$id_sujet = $row['id_thread'];
		$der_date = $row['dateur'];
		
		$url_post = url_post_tranche($id_post, $id_sujet);
		
		$art_ferme = verif_article_ferme($id_forum);

		$ifond = $ifond ^ 1;
		$coul_sujet = ($ifond) ? $couleur_claire : '#e3e3e3';
	
		debut_bloc_couleur($coul_sujet);
		echo "\n<table cellpadding=3 cellspacing=0 border=0 width='100%'>";
		echo "<tr width='100%'>\n";
		echo "<td width='6%' valign='top' class='verdana2'>\n";
		icone(_T('phpbb:forum_ouvrir'), "gaf_admin.php?page=forum&id_article=$id_forum", "gaf_forum.gif", "rien.gif");
		echo $id_forum;
		echo "</td>\n";
		echo "<td valign='top' class='verdana2'>\n";
		echo bloc_art_ferme($art_ferme)."<span class='verdana3'><b>".propre($titre_forum)."</b></span><br>";
		echo propre($desc_forum);
		echo "</td>\n";
		echo "<td width='8%' valign='top' class='verdana2'>\n";
		debut_bloc_gricont();
		echo "<img src='"._DIR_IMG_PACK."gaf_sujet-12.gif' border='0' align='absmiddle' title='"._T('phpbb:sujet_nombre')."'><br>";		
		echo $nbr_sujet;
		fin_bloc();
		echo "</td>\n";
		echo "<td width='8%' valign='top' class='verdana2'>\n";
		debut_bloc_gricont();		
		echo "<img src='"._DIR_IMG_PACK."gaf_post-12.gif' border='0' align='absmiddle' title='"._T('phpbb:total_messages')."'><br>";		
		echo $nbr_post;
		fin_bloc();
		echo "</td>\n";
		echo "<td width='12%' valign='top' class='verdana2'><div align='center'>\n";
		if($id_sujet!='')
			{
			echo "<a href='".$url_post."' title='Voir ce message'>";
			echo "<img src='"._DIR_IMG_PACK."gaf_post-12.gif' border='0' align='absmiddle'>";
			echo _T('phpbb:dernier').$der_date."</a>";
			}
		echo "</div></td></tr></table>\n";
		fin_bloc();
		}
fin_cadre_formulaire();
}
break;



case"forum":
// Arrive avec $id_article (forum)
// info forum(article) en tete de script

// verifier si ce Forum (article) est fermé !
$art_ferme = verif_article_ferme($id_forum);

// Forum (article) d'origine ...
debut_cadre_formulaire("");

	echo "\n<table cellpadding=0 cellspacing=0 border=0 width='600'>";
	echo "<tr width='100%'>";
	echo "<td valign='top'>\n";
	echo "<img src='"._DIR_IMG_PACK."gaf_forum.gif' border='0' valign='absmiddle'>\n";
	echo "<span class='verdana2'>".$id_article."</span>";	
	echo "</td>";
	echo "<td>" . http_img_pack('rien.gif', " ", "width='10'") ."</td>\n";
	echo "<td width='80%' valing='top'>\n";
	echo "<span class='verdana2'>"._T('phpbb:forum')." .. </span>";
	bloc_art_ferme($art_ferme);
	gros_titre($titre_forum);
	echo "<span class='arial2'>".propre($desc_forum)."</span>";
	echo "</td>\n";
	echo "<td width='15%' valign='top'>\n";
	// bouton "ecrire un nouveau sujet
	if ($connect_statut == '0minirezo' AND $accepter_forum!='non')
		{ bouton_ecrire_post($id_forum,''); }
	
	// bouton de fermeture d'article
		if($connect_statut == '0minirezo' AND acces_rubrique($rub_act) AND !$art_ferme) {
			echo "<div style='float:right; padding:3px;'>";
			echo "<form action='gaf_admin.php?page=fermer' method='post'>";
			echo "<input type='hidden' name='id' value='".$id_forum."'>";
			echo "<input type='hidden' name='mode' value='ferme'>";
			echo "<input type='image' src='"._DIR_IMG_PACK."gaf_verrou1.gif'>";
			echo "</form></div>";
			}
		if($connect_statut == '0minirezo' AND $connect_toutes_rubriques AND $art_ferme!="mainten") {
			echo "<div style='float:right; padding:3px;'>";
			echo "<form action='gaf_admin.php?page=fermer' method='post'>";
			echo "<input type='hidden' name='id' value='".$id_forum."'>";
			echo "<input type='hidden' name='mode' value='mainten'>";
			echo "<input type='image' src='"._DIR_IMG_PACK."gaf_verrou2.gif'>";
			echo "</form></div>";
			}
		// boutons de réouverture d'article
		if($connect_statut == '0minirezo' AND acces_rubrique($rub_act) AND $art_ferme=="ferme") {
			echo "<div style='float:right; padding:3px;'>";
			echo "<form action='gaf_admin.php?page=fermer' method='post'>";
			echo "<input type='hidden' name='id' value='".$id_forum."'>";
			echo "<input type='hidden' name='mode' value='ouvre'>";
			echo "<input type='image' src='"._DIR_IMG_PACK."gaf_libere1.gif'>";
			echo "</form></div>";
			}
		if($connect_statut == '0minirezo' AND $connect_toutes_rubriques AND $auth_deplace AND $art_ferme=="mainten") {
			echo "<div style='float:right; padding:3px;'>";
			echo "<form action='gaf_admin.php?page=fermer' method='post'>";
			echo "<input type='hidden' name='id' value='".$id_forum."'>";
			echo "<input type='hidden' name='mode' value='ouvre_mainten'>";
			echo "<input type='image' src='"._DIR_IMG_PACK."gaf_libere2.gif'>";
			echo "</form></div>";
			}
	
	echo "</td></tr></table><br>";

// recup $vl (tranche) si dans l'URL ET passer la valeur de LIMIT : $dl et $fl
		$dl=($vl+0);

// afficher les sujets (classés par post plus recent) de ce forum
$req_sujet =	"SELECT SQL_CALC_FOUND_ROWS sujet.id_forum, sujet.*, 
				date_format(sujet.date_heure,'%d/%m/%Y %H:%i') AS date_sujet,
				max(post.date_heure) AS date_post 
				FROM spip_forum AS sujet, spip_forum AS post
				WHERE sujet.id_article='$id_article'
				AND sujet.id_parent=0
				AND sujet.statut IN ('publie', 'off', 'prop')
				AND post.id_thread=sujet.id_forum 
				GROUP BY id_thread
				ORDER BY date_post DESC 
				LIMIT $dl,$fixlimit";
$res_sujet = spip_query($req_sujet);


// récup nombre total d'entrée de $req_sujet (mysql 4.0.0 mini)
		$nl= spip_query("SELECT FOUND_ROWS()");
		list($nligne) = @spip_fetch_array($nl);
// valeur de tranche affichée	
		$tranche_encours = $dl+1;
// adresse retour des tranches
		$retour_gaf_local ="gaf_admin.php?page=forum&id_article=$id_article";		
// afficher les tranches
	if ($nligne>$fixlimit)
		{
		echo "<div align='center' class='iconeoff' style='margin:2px;'><span class='verdana2'><b>";
		tranches_liste_forum($tranche_encours, $retour_gaf_local);
		echo "</b></span></div>";
		}

$ifond=0;

while ($row=spip_fetch_array($res_sujet))
	{
	$id_sujet = $row['id_forum'];
	$titre_sujet = $row['titre'];
	$aut_sujet = $row['auteur'];
	$date_sujet = $row['date_sujet'];
	$statut_sujet = $row['statut'];
	
	// icone état du post
	$aff_statut = icone_statut_post($statut_sujet);

	// post de type "annonce" ?
	$aff_annonce = verif_sujet_annonce($id_sujet);
	
	// les posts reponses de ce sujet
	$req_post= "SELECT id_forum, titre, auteur, 
				date_format(date_heure,'%d/%m/%Y %H:%i') AS date_post
				FROM spip_forum 
				WHERE id_thread='$id_sujet' AND statut IN ('publie', 'off', 'prop') 
				AND id_parent!='0'"; 
	$res_post = spip_query($req_post);
	$nbr_post=spip_num_rows($res_post);
	
	// le dernier post de ce sujet
	$req_date = "SELECT id_forum, date_heure, auteur FROM spip_forum
				WHERE id_thread=$id_sujet AND statut IN ('publie', 'off', 'prop') 
				ORDER BY date_heure DESC LIMIT 0,1";
	$res_date = spip_query($req_date);
	$row = spip_fetch_array($res_date);
	$id_post_der = $row['id_forum'];
	$der_date = date_relative($row['date_heure']);
	$aut_post = $row['auteur'];
	$url_post_der = url_post_tranche($id_post_der, $id_sujet);
	
	$ifond = $ifond ^ 1;
	$coul_sujet = ($ifond) ? $couleur_claire : '#e3e3e3';
	$rowspan_p = $nbr_post + 1;

	// le tableau du sujet
		debut_bloc_couleur($coul_sujet);
		echo "\n<table cellpadding=1 cellspacing=2 border=0 width='100%'>";
		echo "<tr width='100%'>";
		echo "<td width='7%' valign='top' rowspan='".$rowspan_p."' class='verdana2'>";
		icone(_T('phpbb:sujet_ouvrir'), "gaf_admin.php?page=sujet&id_sujet=$id_sujet", "gaf_sujet.gif", "rien.gif");
		echo $id_sujet;
		
		// bouton de déplacement du thread
		if ($connect_statut == '0minirezo' AND $connect_toutes_rubriques AND $auth_deplace AND $art_ferme=="mainten")
			{ bouton_deplace_sujet($id_forum, $id_sujet); }

		echo "</td>\n";
		echo "<td width='' valign='top'>".$aff_statut.$aff_annonce;
		echo "<span class='verdana3'><b>".propre($titre_sujet)."</b></span><br>\n";
		echo "<span class='verdana2'>par <b>".$aut_sujet."</b> .. "._T('phpbb:le')." ".$date_sujet."<span></td>\n";
		echo "<td width='8%' valign='top' class='verdana2'>\n";
		debut_bloc_gricont();
			echo "<img src='"._DIR_IMG_PACK."gaf_post-12.gif' border='0' valign='absmiddle'><br>\n";
			echo $nbr_post;
		fin_bloc();
		echo "</td>";
		echo "<td width='20%' valign='top' class='verdana2'>\n";
		echo "<div align='right'><a href='".$url_post_der."' title='"._T('phpbb:voir_message')."'>\n";
		echo $aut_post."<br>".$der_date."</a></div>";
		echo "</td></tr>\n";

		$i=0;
		$compt_rang=1;
		// lignes ...
		while ($row=spip_fetch_array($res_post))
			{
			$retrait = $i*15;
			$url_post = url_post_tranche($row['id_forum'], $id_sujet, $compt_rang);
			echo "<tr><td valign='top' colspan='2' class='verdana2'>\n";
			echo "<div style='margin-left:".$retrait."px;'>\n";
			echo "<a href='".$url_post."' title='".$row['auteur']."'>";
			echo "<img src='"._DIR_IMG_PACK."gaf_post-12.gif' border='0' valign='absmiddle'> ".$row['titre'];
			echo "</a>\n";
			echo "</div></td><td>".$row['date_post']."</td></tr>\n";
			$compt_rang++;
			$i++;
			if($i==10)$i=0;
			}
				
		echo "</table>\n";
		fin_bloc();
	}
	
// afficher les tranches
	if ($nligne>$fixlimit)
		{
		echo "<div align='center' class='iconeoff' style='margin:2px;'><span class='verdana2'><b>\n";
		tranches_liste_forum($tranche_encours, $retour_gaf_local);
		echo "</b></span></div>\n";
		}

fin_cadre_formulaire();
break;



case"sujet":
// afficher le post/sujet et les posts/reponses

// recup de id_rubrique pour 'droits' sur bouton_ecrire_post.
	$resrub=spip_query("SELECT id_rubrique FROM spip_articles WHERE id_article=$art_act");
	$rowrub=spip_fetch_array($resrub);
	$id_rubrique=$rowrub['id_rubrique'];

// verif si Forum conteneur (article) est fermé ?
	$art_ferme = verif_article_ferme($art_act);

// post de type "annonce" ?
	$aff_annonce = verif_sujet_annonce($id_sujet);

// recup $vl (tranche) si dans l'URL ET passer la valeur de LIMIT : $dl et $fl
	$dl=($vl+0);


// requete du post
$req_post =	"SELECT SQL_CALC_FOUND_ROWS *, 
			DATE_FORMAT(date_heure, '%d/%m/%Y %H:%i') AS dateur_post 
			FROM spip_forum 
			WHERE id_thread=$id_sujet AND statut IN ('publie', 'off', 'prop') 
			ORDER BY date_heure LIMIT $dl,$fixlimit";
$res_post = spip_query($req_post);

// récup nombre total d'entrée de req_post (mysql 4.0.0 mini)
	$nl= spip_query("SELECT FOUND_ROWS()");
		list($nligne) = @spip_fetch_array($nl);
// valeur de tranche affichée	
	$tranche_encours = $dl+1;
// adresse retour des tranche
	$retour_gaf_local ="gaf_admin.php?page=sujet&id_sujet=$id_sujet";		
// afficher les tranches
	if ($nligne>$fixlimit)
		{
		echo "<div align='center' class='iconeoff' style='margin:2px;'><span class='verdana2'><b>";
		tranches_liste_forum($tranche_encours, $retour_gaf_local);
		echo "</b></span></div>";
		}


// tableau
debut_cadre_formulaire();
echo "\n<table cellpadding='3' cellspacing='1' border='0' width='600'>\n";
echo "<tr><td colspan='3'>";
	if ($connect_statut == '0minirezo' AND $accepter_forum!='non'
			AND $statut_sujet=='publie' AND $art_ferme!='mainten')
		{ bouton_ecrire_post($art_act, $id_sujet); }
bloc_art_ferme($art_ferme);
echo "</td></tr>\n";

$ifond= 0;
while($row=spip_fetch_array($res_post))
	{
	$id_post = $row['id_forum'];
	$id_parent = $row['id_parent'];
	$id_art_post = $row['id_article'];
	$titre_post = $row['titre'];
	$texte_post = $row['texte'];
	$aut_post = $row['auteur'];
	$mail_aut_post = $row['email_auteur'];
	$site_post = $row['nom_site'];
	$url_st_post = $row['url_site'];
	$date_post = $row['dateur_post'];
	$date_post_relative = $row['date_heure'];
	$statut_post = $row['statut'];
	$ip_post = $row['ip'];
	$id_aut_spip = $row['id_auteur'];

	$ifond = $ifond ^ 1;
	
	// couleur de fond du post selon "statut"
	$couleur = ($statut_post=='off') ? '#e8c8c8' : ( ($statut_post=='prop') ? '#d0d4b2' : (($ifond) ? '#c7c7c7' : '#e3e3e3') ) ;

	if($id_parent=='0') 
		{ $logo_post = "gaf_sujet.gif"; $couleur = $couleur_claire; }
	else
		{ $logo_post = "gaf_post.gif"; }

	// icone état du post
	$aff_statut = icone_statut_post($statut_post);
	

	// affichage ; ligne de post
	echo "<tr bgcolor='$couleur_foncee'><td colspan='3'><a id='".$id_post."'></a></td></tr>\n";
	echo "<tr width='100%' bgcolor='$couleur'>";
	echo "<td width='5%'valign='top'>\n";
	echo "<img src='"._DIR_IMG_PACK.$logo_post."' border='0'><br>\n";
	echo "<span class='verdana2'>".$id_post."</span>";
	echo "</td>\n";
	echo "<td width='75%' valign='top'>".$aff_statut.$aff_annonce;
	if ($id_aut_spip AND $spip_display !=1 AND $spip_display!=4 AND lire_meta('image_process') != "non")
		{
		include_ecrire("inc_logos.php3");
		$logo_auteur = decrire_logo("auton$id_aut_spip");
		if ($logo_auteur)
			{
			$fichier = $logo_auteur[0];
			$taille_x = $logo_auteur[3];
			$taille_y = $logo_auteur[4];
			$taille = image_ratio($taille_x, $taille_y, 48, 48);
			$w = $taille[0];
			$h = $taille[1];
			$fid = $logo_auteur[2];
			$hash = calculer_action_auteur ("reduire $w $h");
			echo "\n<div style='float:left; margin-right:3px;'>\n<img src='../spip_image_reduite.php3?img="._DIR_IMG."$fichier&taille_x=$w&taille_y=$h&hash=$hash&hash_id_auteur=$connect_id_auteur' width='$w' height='$h'></div>\n";
			}
		}
	echo "<span class='verdana3'><b>".propre($titre_post)."</b></span><br>\n";
	if ($mail_aut_post)
		{
		echo "<div style='float:left; margin:2px 3px 0px 0px;'>\n";
		echo "<a href='mailto:$mail_aut_post?SUBJECT=".rawurlencode($titre_post)."' title='"._T('phpbb:ecrirea')." ".entites_html($aut_post)."'>\n";
		echo "<img src='"._DIR_IMG_PACK."cal-messagerie.png' width='18' height='13' border='0'></a>\n";
		echo "</div>";
		}
	echo "<span class='verdana2'><b>".$aut_post."</b></span><br>\n";
	echo "<span class='verdana2'>"._T('phpbb:le')." ".$date_post."</span>\n";	
	echo "</td><td width='18%' valign='top'><div align='right'>\n";
	echo "<span class='arial2'>".date_relative($date_post_relative)."</span></div>\n";
	echo "</td></tr><tr bgcolor='$couleur'>";
	echo "<td colspan='3' valign='top' class='verdana2'>\n";

	echo propre(smileys_in_texte($texte_post))."\n";
	
	if ($site_post)
		{
		echo "<div class='verdana2'><br>--------<br>\n";
		echo "<img src='"._DIR_IMG_PACK."racine-site-12.gif' border='0' valign='absmiddle'>";
		echo " <b><a href='".$url_st_post."'>".$site_post."</a></b><br>--------</div>\n"; 
		}
	
	echo "</td></tr><tr bgcolor='$couleur'><td valign='top'>\n";
	if($connect_statut == '0minirezo' AND $connect_toutes_rubriques AND !$aff_annonce AND $id_parent==0)
		{
		echo "<div style='padding:3px;'>\n";
		echo "<form action='gaf_admin.php?page=annonce' method='post'>\n";
		echo "<input type='hidden' name='id' value='".$id_post."'>\n";
		echo "<input type='hidden' name='suj_anno' value='anno'>\n";
		echo "<input type='image' src='"._DIR_IMG_PACK."gaf_annonce.gif' title='"._T('phpbb:fil_annonce')."'>\n";
		echo "</form></div>\n";
		}
	echo "</td><td>\n";
	echo "<div align='right' class='arial2'>\n";
	echo boutons_controle_forum($id_post, $statut_post, $id_aut_spip, "id_article=$id_post", $ip_post);
	echo "</div>\n";
	echo "</td><td valign='bottom'>\n";
	echo "<div align='right' class='arial2'>\n";
	echo $ip_post."</div>\n";
	echo "</td></tr>\n";
	}

echo "<tr><td colspan='3'>\n";
	if ($connect_statut == '0minirezo' AND $accepter_forum!='non' 
			AND $statut_sujet=='publie' AND $art_ferme!='mainten')
		{ bouton_ecrire_post($art_act, $id_sujet); }
echo "</td></tr>\n";
echo "</table>\n";
fin_cadre_formulaire();

// afficher les tranches
	if ($nligne>$fixlimit)
		{
		echo "<div align='center' class='iconeoff' style='margin:2px;'><span class='verdana2'><b>";
		tranches_liste_forum($tranche_encours, $retour_gaf_local);
		echo "</b></span></div>";
		}
break;



case"annonce":
// lier le sujet au mot "annonce"
$id_anno = $GLOBALS['id_mot_annonce'];
if ($suj_anno==anno)
	{ spip_query("INSERT INTO spip_mots_forum (id_mot,id_forum) VALUES ('$id_anno','$id')"); }

echo "<script language=javascript>window.location=\"gaf_admin.php?page=sujet&id_sujet=$id\"</script>";
break;



case"fermer":
// traiter les fermeture ou 'ouverture' d'article
// faut-il faire apparaitre dans les logs (hash calculer action auteur) ?? ??

$id_mot_ferme = $GLOBALS['id_mot_art_ferme'];
$id_auteur = $GLOBALS['auteur_session']['id_auteur'];
$deja_ferme = verif_article_ferme($id);
$f_gafart = _DIR_SESSIONS."gafart_$id-$id_auteur.lck";

if($mode=="ferme" OR $deja_ferme=='')
	{ spip_query("INSERT INTO spip_mots_articles (id_mot,id_article) VALUES ('$id_mot_ferme','$id')"); }
if($mode=="mainten")
	// pose le verrou de maintenance
	{ spip_touch($f_gafart); }


if($mode=="ouvre")
	{ spip_query("DELETE FROM spip_mots_articles WHERE id_mot=$id_mot_ferme AND id_article=$id"); }
if($mode=="ouvre_mainten")
	// effacer le verrou de maintenance
	{
	if(file_exists($f_gafart))
		unlink($f_gafart);
	}

echo "<script language=javascript>window.location=\"gaf_admin.php?page=forum&id_article=$id\"</script>";
break;



case"affect":
// déplacer un sujet
	// au cas où ! Vérifier si Admin principal du site
	if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques)
		{
		debut_cadre_relief("");
		echo _T('avis_non_acces_page');
		fin_cadre_relief();
		fin_page();
		exit;
		}


// details du sujet à déplacer
$req = "SELECT *, DATE_FORMAT(date_heure, '%d/%m/%Y %H:%i') AS dateur_sujet 
		FROM spip_forum WHERE id_forum=$id_sujet";
$res = spip_query($req);
$row = spip_fetch_array($res);
$titre_sujet = $row['titre'];
$auteur_sujet = $row['auteur'];
$date_sujet = $row['dateur_sujet'];
$statut_sujet = $row['statut'];
	
	if ($statut_sujet=="off")
		{ $mis_a_off = "<div style='float:right;' title='Sujet rejeté'>
				<img src='"._DIR_IMG_PACK."supprimer.gif'></div>"; }


	// nbre de posts reponses de ce sujet
	$req_post= "SELECT COUNT(*) as cnt FROM spip_forum 
				WHERE id_thread='$id_sujet' AND statut IN ('publie', 'off', 'prop') 
				AND id_parent!='0'"; 
	$res_post = spip_query($req_post);
	$row = spip_fetch_array($res_post);
	$nbr_post = $row['cnt'];

	$coul_sujet = $couleur_claire;

		echo "<br>";
		gros_titre("Déplacer le Thread suivant ...");
		echo "<br>";

		debut_bloc_couleur($coul_sujet);
		echo "\n<table cellpadding=1 cellspacing=2 border=0 width='600'>";
		echo "<tr width='100%'>\n";
		echo "<td width='7%' valign='top' class='verdana2'>\n";
		echo "<img src='"._DIR_IMG_PACK."gaf_sujet.gif'><br>";
		echo $id_sujet."</td>\n";
		echo "<td width='' valign='top'>".$mis_a_off."";
		echo "<span class='verdana3'><b>".propre($titre_sujet)."</b></span><br>\n";
		echo "<span class='verdana2'>par <b>".$aut_sujet."</b> .. Le ".$date_sujet."<span></td>\n";
		echo "<td width='8%' valign='top' class='verdana2'>\n";
		debut_bloc_gricont();
		echo "<img src='"._DIR_IMG_PACK."gaf_post-12.gif' border='0' valign='absmiddle'><br>\n";
		echo $nbr_post;
		fin_bloc();
		echo "</td>\n";
		echo "<td width='20%' valign='top' class='verdana2'>\n";
		echo "</td></tr>\n";
		echo "</table>\n";
		fin_bloc();

// toute la hierarchie du(es) secteur(s)

// trouver rubrique secteur (hotel) des forums
$req_rs =	"SELECT smr.id_rubrique, sr.titre, sr.descriptif 
			FROM spip_mots_rubriques smr 
			LEFT JOIN spip_rubriques sr ON sr.id_rubrique = smr.id_rubrique
			WHERE smr.id_mot = $id_mot_rub_gaf";
$res_rs = spip_query($req_rs);

echo "<div class='verdana3' style='padding:4px;'><b>"._T('phpbb:forum_selection')."</b></div>";
echo "<form action='gaf_admin.php?page=valid_affect' method='post'>";

while ($row=spip_fetch_array($res_rs))
	{
	$id_hotel = $row['id_rubrique'];
	$titre_hotel = $row['titre'];
	$rang_rub=0;
	$retrait = 20*$rang_rub;
	debut_ligne_foncee($retrait);
	echo "<img src='"._DIR_IMG_PACK."gaf_hall.gif' align='absmiddle'> 
		<span class='verdana2'>".$id_hotel."</span> - <b>".propre($titre_hotel)."</b>\n";
	fin_bloc();

	grand_ma($id_hotel, $rang_rub);
	bb_article($id_hotel, $rang_rub);
	}

echo "<input type='hidden' name='titre_sujet' value='".typo($titre_sujet)."'>";	
echo "<input type='hidden' name='id_sujet' value='".$id_sujet."'>";
echo "<input type='hidden' name='id_art_orig' value='".$id_article."'>";
echo "</form>";
break;



case"valid_affect":
// cherche message du thread à déplacer
$req=spip_query("SELECT id_forum FROM spip_forum 
				WHERE id_thread=$id_sujet AND id_article=$id_art_orig");
while ($row=spip_fetch_array($req))
	{
	$idf = $row['id_forum'];
	spip_query("UPDATE spip_forum SET id_article = $id_art_new WHERE id_forum=$idf");
	}

// recupère info pour affichage
$req=spip_query("SELECT titre FROM spip_articles WHERE id_article=$id_art_orig");
$row=spip_fetch_array($req);
$titre_orig = $row['titre'];

debut_cadre_relief("");
	debut_ligne_foncee('0');
	echo "<img src='"._DIR_IMG_PACK."gaf_sujet.gif' align='absmiddle'>\n";
	echo "<b>".propre($titre_sujet)."</b>\n";
	fin_bloc();
	
	echo "<div class='verdana3' style='padding:3px;'>"._T('phpbb:forum_deplace')."</div>\n";
		
	debut_ligne_grise('30');
	echo "<div style='float:right; padding:3px; text-align:right; 
			border:2px solid ".$couleur_claire."; -moz-border-radius:5px;'>\n";
	echo " "._T('icone_retour')." <a href='gaf_admin.php?page=forum&id_article=$id_art_orig'>
			<img src='"._DIR_IMG_PACK."gaf_forum.gif' border='0' align='absmiddle'></a>";
	echo "</div>\n";
	echo propre($titre_orig);
	echo "<div style='clear:both;'></div>";
	fin_bloc();
	
	echo "<div class='verdana3' style='padding:3px;'>"._T('phpbb:forum_vers')."</div>\n";

	debut_ligne_grise('30');
	echo "<div style='float:right; padding:3px; text-align:right; 
			border:2px solid ".$couleur_claire."; -moz-border-radius:5px;'>\n";
	echo " "._T('icone_retour')." <a href='gaf_admin.php?page=forum&id_article=$id_art_new'>
			<img src='"._DIR_IMG_PACK."gaf_forum.gif' border='0' align='absmiddle'></a>";
	echo "</div>\n";
	echo propre($titre_new);
	echo "<div style='clear:both;'></div>";
	fin_bloc();

	echo "<br>";
	
	debut_bloc_gricont();
		echo "<span class='verdana3'>"._T('phpbb:maintenance')."</span>\n";
	fin_bloc();
	
fin_cadre_relief();
break;



case"effacer":
// réservé au Admins
if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques)
{
	echo _T('avis_non_acces_page');
	fin_page();
	exit;
}

// effacer définitivement les posts inscrit à "off"
if($action=='efface_select')
	{
	$tbl_eraze=$_POST['eraze'];
	//suppresion des posts selectionnés
	debut_cadre_relief("poubelle.gif");
	gros_titre(_T('phpbb:poste_effac'));
	
	$nbr_eraze = count($tbl_eraze);
	if ($nbr_eraze==0)
		{ echo "<div class='verdana3'><b>"._T('phpbb:aucun')."</b></div>"; }
	else
		{
		foreach($tbl_eraze as $id)
			{ $req = spip_query("DELETE FROM spip_forum WHERE id_forum=$id and statut='off'"); }
		echo "<div class='verdana3'>".$nbr_eraze._T('phpbb:poste_effac')."</div>";
		}
	fin_cadre_relief();
	}

$res=spip_query("SELECT id_forum, id_parent, titre, id_thread, COUNT(id_forum) as total_post 
				FROM spip_forum WHERE statut = 'off' GROUP BY id_thread ");

debut_cadre_relief("");
	echo "<form action='gaf_admin.php?page=effacer' method='post'>";
	echo "<input type='hidden' name='action' value='efface_select'>";
	echo "\n<table cellpadding='3' cellspacing='0' border=0 width='100%'>";
	echo "<tr width='100%'>\n";
	echo "<td height='35' valign='top' colspan='2'>\n";
	gros_titre(_T('phpbb:poste_refuse'));
	echo "</td></tr>";

$ifond=0;
while ($row=spip_fetch_array($res))
	{
	$id_post = $row['id_forum'];
	$id_parent = $row['id_parent'];
	$id_thread = $row['id_thread'];
	$titre = $row['titre'];
	$total_post = $row['total_post'];
	
	$ico_ligne = $id_parent=='0' ? "gaf_sujet-12.gif" : "gaf_post-12.gif";
	$retrait = $id_parent=='0' ? "5" : "20";
	
	$ifond = $ifond ^ 1;
	$couleur = ($ifond) ? $couleur_claire : '#e3e3e3';
	
	echo "<tr class='verdana2' bgcolor='".$couleur."'><td><div style='margin-left:".$retrait."px;'>";
	echo "<img src='"._DIR_IMG_PACK.$ico_ligne."'> ".$id_post." - ".propre($titre);
	echo "&nbsp;<a href='".url_post_tranche($id_post, $id_thread)."'><img src='"._DIR_IMG_PACK."plus.gif' align='absmiddle' border='0' title='"._T('phpbb:voir')."'></a>";
	echo "</div>";
	echo "</td><td valign='absmiddle'>";
	echo "<input type='checkbox' name='eraze[]' value='".$id_post."'>";
	echo "</td></tr>";
	if ($total_post>'1')
		{
		$res2=spip_query("SELECT id_forum, titre FROM spip_forum 
						WHERE id_thread=$id_thread AND statut='off' AND id_forum!=$id_post");
		
		if($id_parent=='0')
			{
			$nbr_post=$total_post-1;
			echo "<tr class='verdana2' bgcolor='".$couleur."'><td>";
			echo "<div class='verdana2' style='color:#ED4242; margin-left:30px; padding:2px;'>\n";
			echo "<img src='"._DIR_IMG_PACK."gaf_post-12.gif' align='absmiddle'>&nbsp;";
			echo _T('phpbb:poste_efface_lui');
			echo "<a href='gaf_admin.php?page=sujet&id_sujet=$id_post'>".
					"&nbsp;<img src='"._DIR_IMG_PACK."plus.gif' border='0' align='absmiddle' title='"._T('phpbb:sujet_verifie')."'>";
			echo "</a></div>";
			while ($row=spip_fetch_array($res2))
				{ echo "<input type='hidden' name='eraze[]' value='".$row['id_forum']."'>"; }
			echo "</td><td valign='absmiddle'></td></tr>";
			}
		else
			{
			while ($row=spip_fetch_array($res2))
				{			
				echo "<tr class='verdana2' bgcolor='".$couleur."'><td>";
				echo "<div class='verdana2' style='margin-left:25px; padding:2px;'>\n";
				echo "<img src='"._DIR_IMG_PACK."gaf_post-12.gif' align='absmiddle'>&nbsp; ".$row['id_forum']." - ".propre($row['titre']);
				echo "</div>";
				echo "</td><td valign='absmiddle'>";
				echo "<input type='checkbox' name='eraze[]' value='".$row['id_forum']."'>";
				echo "</td></tr>";
				}
			}
		}
	}
		
	echo "</table><br>";
	echo "<div align='right' class='verdana3'>".
			_T('phpbb:selection_efface')."<input type='submit' value='"._T('phpbb:effacer')."' class='fondo'></div></form>\n";
fin_cadre_relief();

break;



} // fin switch

// retour haut de page
	echo "<div style='float:right; margin-top:6px;' class='icone36' title='"._T('phpbb:haut_page')."'>\n";
	echo "<a href='#haut_page'>";
	echo "<img src='"._DIR_IMG_PACK."spip_out.gif' border='0' align='absmiddle'>\n";
	echo "</a></div>";
	echo "<div style='clear:both;'></div>\n";

fin_page();

?>