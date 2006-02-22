<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

include_ecrire ("inc_date.php3");

// Le contexte indique dans quelle rubrique le visiteur peut proposer l article
global $balise_FORMULAIRE_ARTICLE_collecte;
$balise_FORMULAIRE_ARTICLE_collecte = array('id_rubrique');

function balise_FORMULAIRE_ARTICLE_stat($args, $filtres) {

	// Pas d'id_rubrique ? Erreur de squelette
	if (!$args[0] && !$args[1])
		return erreur_squelette(
			_T('zbug_champ_hors_motif',
				array ('champ' => '#FORMULAIRE_ARTICLE',
					'motif' => 'RUBRIQUES')), '');

	// Verifier que les visisteurs sont autorises a proposer un article
	return ($args);
}

function balise_FORMULAIRE_ARTICLE_dyn($surtitre=' ', $titre=' ', $soustitre=' ',  $descriptif=' ', $chapeau=' ', $texte=' ', $ps=' ', $id_rubrique=1, $lien_titre=' ', $lien_url=' ', $var_lang='fr', $id_auteur_session = 0, $nom_auteur_session =' ', $email_auteur_session=' ') {
	global $REMOTE_ADDR, $afficher_texte, $_COOKIE, $_POST;

	$auteur_statut=$GLOBALS["auteur_session"]["statut"];

	$articles_publics = $GLOBALS['articles_publics'];
	
	// url de reference
	if (!$url) {
		$url = new Link();
		$url = $url->getUrl();
		}
	
	
	$surtitre= stripslashes(_request('surtitre'));	
	$titre= stripslashes(_request('titre'));
	$soustitre= stripslashes(_request('soustitre'));	$descriptif= stripslashes(_request('descriptif'));	$chapo= stripslashes(_request('chapo'));	$texte= stripslashes(_request('texte'));	$ps= stripslashes(_request('ps'));
	$lien_titre= stripslashes(_request('lien_titre'));	$lien_url= stripslashes(_request('lien_url'));

	if ($GLOBALS["auteur_session"]) {
		$id_auteur_session = $GLOBALS['auteur_session']['id_auteur'];
		$nom_auteur_session = $GLOBALS['auteur_session']['nom'];
		$email_auteur_session = $GLOBALS['auteur_session']['email'];
	} else {
		$nom_auteur_session= _request('nom_auteur_session');		$email_auteur_session= _request('email_auteur_session');
	}
	
	$id_rubrique= _request('id_rubrique');
	
	$lang = _request('var_lang');	
	$nom = 'changer_lang';
	lang_dselect();
	$langues = liste_options_langues($nom, $lang);
	
	// retourver le secteur et la langue de la rubrique
	$s = spip_query("SELECT id_secteur, lang FROM spip_rubriques WHERE id_rubrique = '$id_rubrique' ");
	if ($r = spip_fetch_array($s)) {
		$id_secteur = $r["id_secteur"];
		$lang = $r["lang"];
		}
	
	$previsualiser= _request('previsualiser');
	$valider= _request('valider');
	
	$previsu = '';
	$bouton= '';

	// statut de l'article, et formulaire de login en fonction de la configuration choisie
	if (($articles_publics == "abo") && (!$GLOBALS["auteur_session"])) {
		return array('formulaire_login_article', 0, array());
	}
	elseif ($articles_publics == "pos") {
		$statut= "publie";
	}
	else{
		$statut= "prop";
	}

	
	
	if($valider)
		{
		// intégrer à la base de données
		$time=time();
		$date_redac=date('Y-m-d H:i:s',$time);
		
		$surtitre= addslashes($surtitre);	
		$titre= addslashes($titre);
		$soustitre= addslashes($soustitre);		$descriptif= addslashes($descriptif);		$chapo= addslashes($chapo);		$texte= addslashes($texte);		$ps= addslashes($ps);
		$lien_titre= addslashes($lien_titre);		$lien_url= addslashes($lien_url);
		
		
		// ajouter l'article (sans auteur) dans la base: statut: 'prop' ou 'publie'
		spip_query("INSERT INTO spip_articles (surtitre, titre, soustitre, id_rubrique, descriptif, chapo, texte, ps, statut, id_secteur, accepter_forum, auteur_modif, date_modif, lang, date, id_version, nom_site, url_site) VALUES ('$surtitre', '$titre', '$soustitre', '$id_rubrique', '$descriptif', '$chapo', '$texte', '$ps', '$statut', '$id_secteur', 'pos', '$id_auteur_session', '$date_redac', '$lang', '$date_redac', '1', '$lien_titre', '$lien_url')");
		// aller chercher l'identifiant de l'article créé
		$s = spip_query("SELECT id_article FROM spip_articles WHERE date = '$date_redac' ");
		if ($r = spip_fetch_array($s)){
			$id_article = $r["id_article"];
		}
		// ajouter l'auteur
		if($id_auteur_session != 0){
		spip_query("INSERT INTO spip_auteurs_articles (id_auteur, id_article) VALUES ($id_auteur_session, $id_article)");
		}
		include_ecrire("inc_mail.php3");
		envoyer_mail_proposition($id_article);
		return  _T('form_prop_enregistre');
		}
		
	else{
		if($previsualiser)
		{

		if (strlen($titre) < 3){$erreur .= _T('forum_attention_trois_caracteres');}
		if(!$erreur){$bouton= _T('form_prop_confirmer_envoi');}

		$previsu = inclure_balise_dynamique(
			array(
				'formulaire_article_previsu',
				0,
				array(
					'surtitre' => interdire_scripts(typo($surtitre)),
					'titre' => interdire_scripts(typo($titre)),
					'soustitre' => interdire_scripts(typo($soustitre)),
					'descriptif' => propre($descriptif),
					'chapo' => propre($chapo),
					'texte' => propre($texte),
					'ps' => propre($ps),
					'lien_titre' => $lien_titre,
					'lien_url' => $lien_url,
					'erreur' => $erreur,
					'bouton' => $bouton
				)
			), false);
				$previsu = preg_replace("@<(/?)f(orm[>[:space:]])@ism",
				"<\\1no-f\\2", $previsu);
		}

		return array('formulaire_article', 0,
		array(
					'formulaire_date' => $formulaire_date,
					'url' =>  $url,
					'langues' => $langues,
					'previsu' => $previsu,
					'surtitre' => $surtitre,
					'titre' => interdire_scripts(typo($titre)),
					'soustitre' => $soustitre,
					'descriptif' => $descriptif,
					'chapo' => $chapo,
					'texte' => $texte,
					'ps' => $ps,
					'lien_titre' => $lien_titre,
					'lien_url' => $lien_url,
					'id_rubrique' => $id_rubrique,
					'id_secteur' => $id_secteur,
					'id_auteur_session' => $id_auteur_session,
					'nom_auteur_session' => $nom_auteur_session,
					'email_auteur_session' => $email_auteur_session
			));
	}

}

function barre_article($texte)
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

function logoauteur($id_auteur, $formats = array ('gif', 'jpg', 'png')) {
	reset($formats);
	while (list(, $format) = each($formats)) {
		$d = _DIR_IMG . "auton$id_auteur.$format";
		if (@file_exists($d)) return $d;
	}
	return  '';
}

?>
