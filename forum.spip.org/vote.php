<?php

	// Systeme de vote sur les forums

	// Installation :
	// EN l'absence de plugins, installer ce fichier vote.php dans ecrire/
	// et ajouter dans ecrire/mes_options.php3 la ligne suivante :
	//       include_ecrire('vote.php3');
	// Ensuite dans le squelette vise, ajouter :
	// - un bulletin de vote dans la boucle FORUMS
	//    [(#ID_FORUM|afficher_choix{bien, nul})]
	// - un assesseur :
	//    <?php a_vote(); ? >



	define('_VOTE_TABLE', 'spip_forum');
	define('_VOTE_ID', 'id_forum');
	define('_VOTE_VERSION', 0.1);

	// declarer la colonne spip_forum.score pour le compilateur (#SCORE)
### note : ne fonctionne pas car ces valeurs sont ecrasees par inc_serialbase
	global $tables_principales;
	$tables_principales['spip_forum']['field']['score'] = "DOUBLE DEFAULT '0' NOT NULL";
	$tables_principales['spip_forum']['field']['votes'] = "INT DEFAULT '0' NOT NULL";

	// Si ce n'est pas deja fait creer les champs score et vote dans la table
	function install_scores() {
		if (lire_meta('version_score') < _VOTE_VERSION) {
			include_ecrire('inc_meta.php3');
			ecrire_meta('version_score', _VOTE_VERSION);
			ecrire_metas();
			spip_query("ALTER TABLE "._VOTE_TABLE."
				ADD score DOUBLE DEFAULT 0");
			spip_query("ALTER TABLE "._VOTE_TABLE."
				ADD votes INTEGER DEFAULT 0");
		}
	}

	// AJouter un vote a un element
	// $combien on paie
	// $id identifiant de l'element
	// retour : le nouveau score
	function ajouter_vote ($combien, $id) {
		$s = spip_query ("SELECT score, votes FROM "._VOTE_TABLE."
		WHERE "._VOTE_ID."=$id");
		if (!$t = spip_fetch_array($s))
			return false;
		
		$score = $t['score'];
		$votes = $t['votes'];
		
		$score = $combien + ($score * $votes)/($votes + 1)*0.99;
		$votes ++;
		spip_query("UPDATE "._VOTE_TABLE." SET score=$score, votes=$votes
		WHERE "._VOTE_ID."=$id");

		spip_log("vote $combien sur id=$id ; score=$score ; votes=$votes");

		return $score;
	}

	// verifier que le posteur a le droit de vote, et prendre en compte son vote
	function vote_posteur($combien, $id) {
		install_scores();

		$dejavote = $_COOKIE['spip_votes'];
		if (!strstr("/$dejavote/", "/$id/")) {
			$dejavote = substr("$dejavote/$id", -150);
			include_ecrire('inc_cookie.php');
			spip_setcookie('spip_votes', $dejavote);
			return ajouter_vote ($combien, $id);
		} else {
			spip_log("ce visiteur a deja vote sur id=$id");
		}
	}

	// un filtre qui permet d'afficher les choix proposes
	// [(#ID_FORUM|afficher_vote{1,bien})]
	function afficher_vote($id, $score, $texte) {
		$ici = new Link();
		$r = "<form action=\"".  $ici->getUrl() .'#vote" method="POST">';
		$r .= "<input type='hidden' name='var_vote_id' value='$id' />\n";
		$r .= "<input type='hidden' name='var_vote' value='$score' />\n";
		$r .= '<input type="submit" class="spip_bouton" name="voter" value="'.attribut_html($texte)."\" />\n";
		$r .= "</form>\n";
		return $r;
	}

	// Prendre en compte un vote exprime (a ajouter dans le squelette
	// par exemple, ou apres inc-public.php3)
	function a_vote() {
		static $once;
		if ($once ++) return;

		if ($_POST['var_vote']) {
			$combien = $_POST['var_vote']>0 ? 1 : -1;
			vote_posteur($combien, $_POST['var_vote_id']);
		}
	}

?>
