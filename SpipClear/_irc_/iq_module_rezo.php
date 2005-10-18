<?php

// REZO module for IQ (http://f0rked.com/IQ)
// version: 2.0
// author: fil@rezo.net
// This script will take recent articles from a SPIP database and
// return the top results to #rezo every 90 seconds

$this->bind("pubm","","","",'rezo');


$this->functions["rezo"]=create_function('$args','
	global $bot;
	static $welcome;
	static $seen;

	chdir("/var/shim/rezo/Web");   ## Where is SPIP ?
	if(!function_exists("spip_query")){
		include("ecrire/inc_version.php3");
		include_ecrire("inc_connect.php3");
		include_ecrire("inc_texte.php3");
	}

	if (!$bot->replyto("rss_idle",90)) {
		# initialisation
		if (!$welcome) {
			$welcome = true;
			$bot->msg("#rezo","Salut, c\'est moi rez000 ! je reb00te...", 1, $buffering);
		}

		$s = mysql_query("SELECT * FROM spip_articles
		ORDER BY date DESC
		LIMIT 0,10");
		while ($t = spip_fetch_array($s)) {
			$watch =trim($t["url_site"]);
			$newseen[$watch] = true;
			if (
				!$seen[$watch]
				AND $l++<4
			) {
				$titre = filtrer_entites(supprimer_tags(texte_backend(typo($t["titre"]))));

				# aller chercher le titre de la rubrique
				list($rub) = spip_fetch_array(mysql_query("SELECT titre FROM spip_rubriques WHERE id_rubrique=".$t["id_rubrique"]));
				$rub = filtrer_entites(supprimer_tags(texte_backend(typo($rub.", ".heures($t["date"]).":".minutes($t["date"])))));

				$bot->msg("#rezo","$titre ($rub) $watch", 1, $buffering);
				sleep(1);
			}
		}

		$seen = $newseen; # ne garder que 10 resultats dans $seen (sinon explosion)
	} # reply-to

	chdir("/home/fil/IQ-0.9.3");  ## where is IQ ?
');

$this->infoLog("rezo module loaded");
?>
