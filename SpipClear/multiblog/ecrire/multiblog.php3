<?php

/***************************************************************************\
*  SPIP, Systeme de publication pour l'internet                           *
*                                                                         *
*  Copyright (c) 2001-2005                                                *
*  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
*                                                                         *
*  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
*  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/


include ("inc.php3");
include_ecrire ("inc_acces.php3");
include_ecrire ("inc_logos.php3");
include_ecrire ("inc_session.php3");
include_ecrire ("inc_filtres.php3");
include_ecrire ("inc_abstract_sql.php3");




// securite
$id_auteur = floor($id_auteur);

// admin total     : connect statut : 0minirezo      connect_toutes_rubriques : 1 auteur[statut] :
// admin restreint : connect statut : 0minirezo      connect_toutes_rubriques :
// user normal     : connect statut : 1comite        connect_toutes_rubriques :

// securite
if ($connect_statut != "0minirezo" ) {
	gros_titre(_T('info_acces_interdit'));
	exit;
}

function multiBlogMenuDroite() {
	$chaine="";
	$chaine.="<a href=\"multiblog.php3?action=liste\">Liste</a><br>";
	$chaine.="<a href=\"multiblog.php3?action=nouveau\">"._T('multiblog_nouveau_blog')."</a><br>";
	$chaine.="<a href=\"multiblog.php3?action=aide\">"._T('multiblog_menu_aide')."</a><br>";
	return $chaine;
}

//
// Recuperer l'auteur (id_auteur) ... ou l'inventer
//
unset($auteur);

//action postée dans le formulaire
switch ($action) {

	case 'save':


	debut_page($auteur['nom'],"auteurs","redacteurs");
	echo "<br><br><br>";
	debut_gauche();
	debut_boite_info();
	echo multiBlogMenuDroite();
	fin_boite_info();
	debut_droite();



	//creation de l'auteur Nom
	$auteur['nom'] = corriger_caracteres($nom);

	//Email
	if ($email !='' AND !email_valide($email)) {
		$echec .= "<p>"._T('info_email_invalide');
		$auteur['email'] = $email;
	}
	else
	{
		$auteur['email'] = $email;
	}

	// login et mot de passe
	if ($new_login) {
		if (strlen($new_login) < 4)
		{
			$echec .= "<p>"._T('info_login_trop_court');
		}
		else if (spip_num_rows(spip_query("SELECT * FROM spip_auteurs WHERE login='".addslashes($new_login)."' AND id_auteur!=$id_auteur AND statut!='5poubelle'")))
		{
			$echec .= "<p>"._T('info_login_existant');
		}
		else
		{
			$auteur['login'] = $new_login;
		}
	}

	// variables sans probleme
	$auteur['bio'] = corriger_caracteres($bio);
	$auteur['pgp'] = corriger_caracteres($pgp);
	$auteur['nom_site'] = corriger_caracteres($nom_site_auteur); // attention mix avec $nom_site_spip ;(
	$auteur['url_site'] = vider_url($url_site);

	//password
	$htpass = generer_htpass($new_pass);
	$alea_actuel = creer_uniqid();
	$alea_futur = creer_uniqid();
	$pass = md5($alea_actuel.$new_pass);
	$query_pass = " pass='$pass', htpass='$htpass', alea_actuel='$alea_actuel', alea_futur='$alea_futur', ";
	if ($auteur['id_auteur'])
	effacer_low_sec($auteur['id_auteur']);


	// statut par defaut a la creation
	$auteur['statut'] = '0minirezo';
	$auteur['source'] = 'spip';

	// l'entrer dans la base
	if (!$echec) {

		// création de la rubrique
		$id_rubrique = spip_abstract_insert("spip_rubriques", "(titre, id_parent,descriptif)","('".addslashes($titre)."', '$id_parent','".addslashes($descriptif)."')");

		if (!$auteur['id_auteur']) {
			$auteur['id_auteur'] = spip_abstract_insert("spip_auteurs", "(nom)", "('temp')");
			$id_auteur = $auteur['id_auteur'];
		}

		$query = "UPDATE spip_auteurs SET $query_pass
		nom='".addslashes($auteur['nom'])."',
		login='".addslashes($auteur['login'])."',
		bio='".addslashes($auteur['bio'])."',
		email='".addslashes($auteur['email'])."',
		nom_site='".addslashes($auteur['nom_site'])."',
		url_site='".addslashes($auteur['url_site'])."',
		statut='".addslashes($auteur['statut'])."',
		pgp='".addslashes($auteur['pgp'])."'
		$add_extra
		WHERE id_auteur=".$auteur['id_auteur'];
		spip_query($query) OR die($query);

		// pour le blog, l'admin est admin restreint du secteur
		spip_query("INSERT INTO spip_auteurs_rubriques (id_auteur,id_rubrique) VALUES(".$auteur['id_auteur'].", $id_rubrique)");



	}


	if (!$echec) {
		echo _T('multiblog_info_creation_blog_ok');
		echo "<p><ul><li>$titre<li>".$auteur['nom']."<li>$descriptif<li>";
		fin_page();

	}
	else {
		debut_cadre_relief();
		echo http_img_pack("warning.gif", _T('info_avertissement'), "width='48' height='48' align='left'");
		echo "<font color='red'>$echec <p>"._T('info_recommencer')."</font>";
		fin_cadre_relief();
		echo "<p>";
	}


	// Si on modifie la fiche auteur, reindexer et modifier htpasswd
	if ($nom OR $statut) {
		if (lire_meta('activer_moteur') == 'oui') {
			include_ecrire ("inc_index.php3");
			indexer_auteur($id_auteur);
		}
		// Mettre a jour les fichiers .htpasswd et .htpasswd-admin
		ecrire_acces();
	}


	break;

	//switch action
	case 'saveTheme':


	// on est en train de modifier le theme  (et on a le droit ?! )
	if (acces_rubrique($id_rubrique)) {

		debut_page($auteur['nom'],"auteurs","redacteurs");
		echo "<br><br><br>";
		debut_gauche();

		debut_boite_info();
		echo multiBlogMenuDroite();
		fin_boite_info();

		debut_droite();

		$racine = (_DIR_RESTREINT ? '' : '../');
		$f = fopen($racine.$dossier_squelettes."/rubrique-$id_rubrique.html", "w");

		ereg("($dossier_squelettes)\/([a-z|A-Z]*)", $theme, $regs);
		$style= $regs[2];
		echo "<hr>style : $style ";


		$contenu="<INCLURE(rubrique-$style.php3){id_rubrique}{styleCss=\"$theme\"}>";
		fputs($f, $contenu);
		fclose($f);

		echo "Theme modifié  : $theme";
	}


	fin_page();
	break;



	//switch action
	case 'supprTheme':

	debut_page($auteur['nom'],"auteurs","redacteurs");
	echo "<br><br><br>";
	debut_gauche();

	debut_boite_info();
	echo multiBlogMenuDroite();
	fin_boite_info();

	debut_droite();


	$racine = (_DIR_RESTREINT ? '' : '../');
	echo "suppression de ".$racine.$dossier_squelettes."/rubrique-$id_rubrique.html";
	ereg("($dossier_squelettes)\/([a-z|A-Z]*)", $theme, $regs);
	$style= $regs[2];
	echo "<hr>style : $style ";

	fin_page();
	break;



	//switch action
	case 'modifTheme':

	// on est en train de modifier le theme  (et on a le droit ?! )
	if (acces_rubrique($id_rubrique)) {

		debut_page($auteur['nom'],"auteurs","redacteurs");
		echo "<br><br><br>";
		debut_gauche();

		debut_boite_info();
		echo multiBlogMenuDroite();
		fin_boite_info();

		debut_droite();


		debut_cadre_formulaire();
		echo "<FORM ACTION='multiblog.php3' METHOD='post'>";
		echo "<INPUT TYPE='Hidden' NAME='action' VALUE=\"saveTheme\">";
		echo "<INPUT TYPE='Hidden' NAME='id_rubrique' VALUE=\"$id_rubrique\">";

		$query2 = "SELECT a.* FROM spip_rubriques a WHERE ";
		$query2.=" a.id_rubrique=$id_rubrique ";
		$result2 = spip_query($query2);

		$les_enfants = "";
		while($row=spip_fetch_array($result2)){
			$id_rubrique=$row['id_rubrique'];
			$id_parent=$row['id_parent'];
			$titre=$row['titre'];
			changer_typo($row['lang']);
			$descriptif=propre($row['descriptif']);

			$les_enfants .= "<li>";
			$les_enfants.= "<div class='enfants'>";
			$les_enfants.= "<span dir='$lang_dir'><B><font color='$couleur_foncee'>".typo($titre)."</font></B>&nbsp;</span>";
			if (strlen($descriptif)) {
				$les_enfants .= "<div class='verdana1'>$descriptif</div>";
			}
			$les_enfants .= "<div style='clear:both;'></div>";
			$les_enfants .= "</div>";


			// on cherche tous les templates
			$racine = (_DIR_RESTREINT ? '' : '../');
			echo "<SELECT NAME='theme' SIZE='1' STYLE='width:250px;' CLASS='fondl' \">";
			if ($handle = opendir($racine.$dossier_squelettes)) {
				while (false !== ($filename = readdir($handle))) {
					//ne prenons que les répertoires qui commencent par mb histoire de cohabiter un peu avec les sites qui ont déjà de l'existant
					if (ereg("mb", $filename, $regs44)) {
						if (is_dir($racine.$dossier_squelettes."/".$filename) and $filename!='.' and $filename!='..') {
							if ($handle2 = opendir($racine.$dossier_squelettes."/".$filename)) {
								while (false !== ($filename2 = readdir($handle2))) {
									if (is_dir($racine.$dossier_squelettes."/".$filename."/".$filename2) and $filename2!='.' and $filename2!='..') {
										$toto="$dossier_squelettes/$filename/$filename2/style.css";
										if ($toto  == $theme ) {
											echo "\n<OPTION selected VALUE=\"$dossier_squelettes/$filename/$filename2/style.css\">$dossier_squelettes/$filename/$filename2";
										}
										else
										{
											echo "\n<OPTION VALUE=\"$dossier_squelettes/$filename/$filename2/style.css\">$dossier_squelettes/$filename/$filename2";
										}

									}
								}
								closedir($handle2);
							}
						}
					}
				}
				closedir($handle);
			}
			echo "</SELECT>";

		}
		$les_enfants .= "</ul>";
		changer_typo($spip_lang); # remettre la typo de l'interface pour la suite
		echo $les_enfants;
		echo "<DIV align='right'><INPUT TYPE='submit' CLASS='fondo' NAME='Valider' VALUE='"._T('bouton_valider')."'></DIV>";
		echo "</div>";
		echo "</FORM>";
		fin_page();
	}
	else {
		debut_page($auteur['nom'],"auteurs","redacteurs");
		echo "<br><br><br>";
		debut_gauche();

		debut_boite_info();
		echo multiBlogMenuDroite();
		fin_boite_info();

		debut_droite();
		die (_T('multiblog_info_pas_dacces_rubrique'));
	}

	break;


	//switch action
	case 'liste':




	debut_page($auteur['nom'],"auteurs","redacteurs");
	echo "<br><br><br>";
	debut_gauche();

	debut_boite_info();
	echo multiBlogMenuDroite();
	fin_boite_info();

	debut_droite();
	echo _T('multiblog_info_liste');

	// l'admin a toute la liste, l'admin restreint seulement les siennes
	if (!$connect_toutes_rubriques) {
		$query2 = "SELECT a.* FROM spip_rubriques a,spip_auteurs_rubriques b WHERE ";
		$query2.=" a.id_rubrique=b.id_rubrique ";
		$query2.=" and b.id_auteur=$connect_id_auteur ";
		$query2.=" and a.id_parent=0 ";
		$query2.=" ORDER BY 0+titre,titre";
	}
	else
	{
		$query2 = "SELECT * FROM spip_rubriques WHERE id_parent=0 ORDER BY 0+titre,titre";
	}
	$result2 = spip_query($query2);



	$les_enfants .= "<ul>";

	while($row=spip_fetch_array($result2)){
		$id_rubrique=$row['id_rubrique'];
		$id_parent=$row['id_parent'];
		$titre=$row['titre'];

		changer_typo($row['lang']);
		$descriptif=propre($row['descriptif']);

		$les_enfants .= "<li>";
		$les_enfants.= "<div class='enfants'>";



		// on cherche le template utilise
		if ($f = find_in_path("rubrique-$id_rubrique.html")) {
			$lines=file ($f) ;
			foreach ($lines as $line_num => $line) {



				ereg("(\<INCLURE\(rubrique\-)([a-z|A-Z]*)", $line, $regs);
				$style= $regs[2];
				ereg("(\styleCss=\")(.*)(\")", $line, $regs2);
				$styleCss= $regs2[2];
				$leTheme= "(Theme - $style : $styleCss )";
				$theme="&theme=$styleCss";


			}



		}
		else
		{
			$leTheme= "(Theme par défaut)";

		}

		$les_enfants.= "<span dir='$lang_dir'><b>";
		if (strlen($descriptif)) {
			$les_enfants.= "<a title='$descriptif' href='naviguer.php3?id_rubrique=$id_rubrique'>";
		}
		else
		{
			$les_enfants.= "<a href='naviguer.php3?id_rubrique=$id_rubrique'>";
		}
		$les_enfants .= "<font color='$couleur_foncee'>".typo($titre)."</font></A></B>&nbsp;";
		$les_enfants .= "<a href='multiblog.php3?id_rubrique=$id_rubrique&action=modifTheme$theme'>modifier Theme</A>&nbsp;";
		$les_enfants .= "<a href='multiblog.php3?id_rubrique=$id_rubrique&action=supprTheme$theme'>Supprimer Theme</A>&nbsp;";
		$les_enfants .= "</span>";
		$les_enfants .= "$leTheme<div style='clear:both;'></div>";
		$les_enfants .= "</div>";
		$les_enfants .= "</li>";

	}
	$les_enfants .= "</ul>";

	changer_typo($spip_lang); # remettre la typo de l'interface pour la suite

	echo $les_enfants;


	fin_page();


	break;


	//switch action
	case 'nouveau':





	debut_page($auteur['nom'],"auteurs","redacteurs");
	echo "<br><br><br>";
	debut_gauche();

	debut_boite_info();
	echo multiBlogMenuDroite();
	fin_boite_info();

	debut_droite();


	//
	// Formulaire d'edition de l'auteur
	//

	if ($echec){
		debut_cadre_relief();
		echo http_img_pack("warning.gif", _T('info_avertissement'), "width='48' height='48' align='left'");
		echo "<font color='red'>$echec <p>"._T('info_recommencer')."</font>";
		fin_cadre_relief();
		echo "<p>";
	}


	debut_cadre_formulaire();
	echo "<FORM ACTION='multiblog.php3' METHOD='post'>";
	echo "<INPUT TYPE='Hidden' NAME='id_auteur' VALUE=\"$id_auteur\">";
	echo "<INPUT TYPE='Hidden' NAME='action' VALUE=\"save\">";

	//
	// Infos personnelles
	//

	echo "<div class='serif'>";
	debut_cadre_relief("fiche-perso-24.gif", false, "", _T("multiblog_icone_information"));


	//Titre du blog
	echo "<B>"._T('multiblog_entree_titre_obligatoire')."</b>";
	echo "<INPUT TYPE='text' CLASS='formo' NAME='titre' VALUE=\"$titre\" SIZE='40' $onfocus><P>";

	//creation d'un secteur donc id_parent=0
	echo "<INPUT NAME='id_parent' VALUE=0 TYPE='hidden'>\n";

	//descriptif du blog
	echo "<P>";
	echo "<B>"._T('multiblog_texte_descriptif_rapide')."</B> &nbsp;";
	echo _T('multiblog_entree_contenu_rubrique')."<BR>";
	echo "<TEXTAREA NAME='descriptif' CLASS='forml' ROWS='4' COLS='40' wrap=soft>";
	echo $descriptif;
	echo "</TEXTAREA><P>\n";

	//nom de l'auteur
	echo _T('titre_cadre_signature_obligatoire');
	echo "("._T('entree_nom_pseudo').")<BR>";
	echo "<INPUT TYPE='text' NAME='nom' CLASS='formo' VALUE=\"".entites_html($auteur['nom'])."\" SIZE='40' $onfocus><P>";

	//email
	echo "<B>"._T('entree_adresse_email')."</B>";
	echo "<br><INPUT TYPE='text' NAME='email' CLASS='formo' VALUE=\"".entites_html($auteur['email'])."\" SIZE='40'><P>\n";
	echo "<p>";

	// Login et mot de passe :
	// accessibles seulement aux admins non restreints et l'auteur lui-meme

	// Login
	echo "<B>"._T('item_login')."</B> ";
	echo "<font color='red'>("._T('texte_plus_trois_car').")</font> :<BR>";
	echo "<INPUT TYPE='text' NAME='new_login' CLASS='formo' VALUE=\"".entites_html($auteur['login'])."\" SIZE='40'><P>\n";

	// Password
	echo "<B>"._T('multiblog_entree_nouveau_passe')."</B> ";
	echo "<font color='red'>("._T('info_plus_cinq_car').")</font> :<BR>";
	echo "<INPUT TYPE='password' NAME='new_pass' CLASS='formo' VALUE=\"\" SIZE='40'><BR>\n";

	echo "<INPUT NAME='redirect' VALUE='$redirect' TYPE='hidden'>\n";
	echo "<INPUT NAME='redirect_ok' VALUE='oui' TYPE='hidden'>\n";




	fin_cadre_relief();
	echo "<p />";
	echo "<DIV align='right'><INPUT TYPE='submit' CLASS='fondo' NAME='Valider' VALUE='"._T('bouton_valider')."'></DIV>";
	echo "</div>";
	echo "</FORM>";
	fin_cadre_formulaire();
	echo "&nbsp;<p>";

	fin_page();


	break;


	//switch action
	case 'aide':


	debut_page($auteur['nom'],"auteurs","redacteurs");
	echo "<br><br><br>";
	debut_gauche();

	debut_boite_info();
	echo multiBlogMenuDroite();
	fin_boite_info();

	debut_droite();

	echo propre(_T('multiblog_aide'));



	fin_page();

	break;


	//switch action
	default:

	debut_page($auteur['nom'],"auteurs","redacteurs");
	echo "<br><br><br>";
	debut_gauche();
	debut_boite_info();
	echo multiBlogMenuDroite();
	fin_boite_info();
	debut_droite();
	fin_page();
	break;



}


?>
