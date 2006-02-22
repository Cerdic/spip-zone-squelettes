<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite
include_ecrire("inc_filtres.php3");
// Contexte du formulaire
global $balise_FORMULAIRE_SUGGESTION_collecte;
$balise_FORMULAIRE_SUGGESTION_collecte = array();


// verification des droits a faire du forum
function balise_FORMULAIRE_SUGGESTION_stat($args, $filtres) {

	return
		array($filtres[0]);
}

function balise_FORMULAIRE_SUGGESTION_dyn($url) {
	global $REMOTE_ADDR, $afficher_texte, $_COOKIE, $_POST;


	// url de reference
	if (!$url) {
		$url = new Link();
		$url = $url->getUrl();
	}

	$titre = addslashes(_request('titre'));
	$texte = addslashes(_request('texte'));
	$auteur = addslashes(_request('auteur'));
	$email_auteur = addslashes(_request('email_auteur'));
	$nom_site_forum = addslashes(_request('nom_site_forum'));
	$url_site = addslashes(_request('url_site'));

	if (isset($_COOKIE['spip_forum_user'])
	AND is_array($cookie_user = unserialize($_COOKIE['spip_forum_user']))) {
		$auteur = $cookie_user['nom'];
		$email_auteur = $cookie_user['email'];
	} else {
		$auteur = $GLOBALS['auteur_session']['nom'];
		$email_auteur = $GLOBALS['auteur_session']['email'];
	}

	if ($titre){
			$table_pref = 'spip';
			if ($GLOBALS['table_prefix']) $table_pref = $GLOBALS['table_prefix'];
			$query="INSERT INTO ".$table_pref."_forum (titre, texte, nom_site, url_site, auteur, email_auteur, statut, date_heure, maj, ip) " .
								"VALUES ('$titre','$texte','$nom_site_forum','$url_site','$auteur','$email_auteur','privadm', NOW(), NOW(),'$REMOTE_ADDR')";
			spip_query($query);
			return 'Suggestion enregistrée';
	}
	else{
			
		return array('formulaire_suggestion', 0,
		array(
			'auteur' => $auteur,
			'disabled' => $email_auteur? " disabled='disabled'" : '',
			'email_auteur' => $email_auteur,
			'texte' => $texte,
			'titre' => extraire_multi($titre),
			'url' =>  $url,
			'url_site' => "http://"));
	}

	
}


function barre_forum($texte)
{
	include_ecrire('inc_layer.php3');

	if (!$GLOBALS['browser_barre'])
		return "<textarea name='texte' rows='12' class='forml' cols='40'>$texte</textarea>";
	static $num_formulaire = 0;
	$num_formulaire++;
	include_ecrire('inc_barre.php3');
	return afficher_barre("document.getElementById('formulaire_$num_formulaire')", true) .
	  "
<textarea name='texte' rows='12' class='forml' cols='40'
id='formulaire_$num_formulaire'
onselect='storeCaret(this);'
onclick='storeCaret(this);'
onkeyup='storeCaret(this);'
ondbclick='storeCaret(this);'>$texte</textarea>";
}

// Mots-cles dans les forums :
// Si la variable de personnalisation $afficher_groupe[] est definie
// dans le fichier d'appel, et si la table de reference est OK, proposer
// la liste des mots-cles
function table_des_mots($table, $les_mots) {
	global $afficher_groupe;

	if (!is_array($afficher_groupe)) return;

	$in_group = " AND id_groupe IN (" . join($afficher_groupe, ", ") .")";

	$result_groupe = spip_query("SELECT * FROM spip_groupes_mots
	WHERE forum = 'oui' AND $table = 'oui'". $in_group);

	$ret = '';
	while ($row_groupe = spip_fetch_array($result_groupe)) {
		$id_groupe = $row_groupe['id_groupe'];
		$titre_groupe = propre($row_groupe['titre']);
		$unseul = ($row_groupe['unseul']== 'oui') ? 'radio' : 'checkbox';
		$result =spip_query("SELECT * FROM spip_mots
		WHERE id_groupe='$id_groupe'");
		$total_rows = spip_num_rows($result);

		if ($total_rows > 0) {
			$ret .= "\n<p />"
			  . "<div class='spip_encadrer' style='font-size: 80%;'>"
			  . "<b>$titre_groupe&nbsp;:</b>"
			  . "<table cellpadding='0' cellspacing='0' border='0' width='100%'>\n"
			  ."<tr><td width='47%' valign='top'>";
			$i = 0;

		while ($row = spip_fetch_array($result)) {
			$id_mot = $row['id_mot'];
			$titre_mot = propre($row['titre']);
			$descriptif_mot = propre($row['descriptif']);

			if ($i >= ($total_rows/2) AND $i < $total_rows) {
				$i = $total_rows + 1;
				$ret .= "</td><td width='6%'>&nbsp;</td>
				<td width='47%' valign='top'>";
			}

			$ret .= boutonne($unseul, "ajouter_mot[]", $id_mot, "id='mot$id_mot' " . $les_mots[$id_mot]) .
			  afficher_petits_logos_mots($id_mot)
			. "<b><label for='mot$id_mot'>$titre_mot</label></b><br />";

			if ($descriptif_mot)
				$ret .= "$descriptif_mot<br />";
			$i++;
		}

		$ret .= "</td></tr></table>";
		$ret .= "</div>";
		}
	}

	return $ret;
}


function afficher_petits_logos_mots($id_mot) {
	include_ecrire('inc_logos.php3');
	$on = cherche_image_nommee("moton$id_mot");
	if ($on) {
	  $image = ("$on[0]$on[1].$on[2]");
		$taille = @getimagesize($image);
		$largeur = $taille[0];
		$hauteur = $taille[1];
		if ($largeur < 100 AND $hauteur < 100)
			return "<img src='$image' align='middle' width='$largeur'
			height='$hauteur' hspace='1' vspace='1' alt=' ' border='0'
			class='spip_image' /> ";
	}
}



/*******************************************************/
/* FONCTIONS DE CALCUL DES DONNEES DU FORMULAIRE FORUM */
/*******************************************************/

//
// Chercher le titre et la configuration du forum de l'element auquel on repond
//

function sql_recherche_donnees_forum ($idr, $idf, $ida, $idb, $ids) {

	// changer la table de reference s'il y a lieu (pour afficher_groupes[] !!)
	if ($ida) {
		$r = "SELECT titre FROM spip_articles WHERE id_article = $ida";
		$table = "articles";
	} else if ($idb) {
		$r = "SELECT titre FROM spip_breves WHERE id_breve = $idb";
		$table = "breves";
	} else if ($ids) {
		$r = "SELECT nom_site AS titre FROM spip_syndic WHERE id_syndic = $ids";
		$table = "syndic";
	} else if ($idr) {
		$r = "SELECT titre FROM spip_rubriques WHERE id_rubrique = $idr";
		$table = "rubriques";
	}

	if ($idf)
		$r = "SELECT titre FROM spip_forum WHERE id_forum = $idf";

	if ($r) {
		list($titre) = spip_fetch_array(spip_query($r));
		$titre = supprimer_numero($titre);
	} else {
		$titre = _T('forum_titre_erreur');
		$table = '';
	}

	// quelle est la configuration du forum ?
	if ($ida)
		list($accepter_forum) = spip_fetch_array(spip_query(
		"SELECT accepter_forum FROM spip_articles WHERE id_article=$ida"));
	if (!$accepter_forum)
		$accepter_forum = substr(lire_meta("forums_publics"),0,3);
	// valeurs possibles : 'pos'teriori, 'pri'ori, 'abo'nnement
	if ($accepter_forum == "non")
		return false;

	return array ($titre, $table, $accepter_forum);
}

?>
