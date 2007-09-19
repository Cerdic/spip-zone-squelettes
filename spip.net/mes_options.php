<?php
	# $mysql_profile = true;
	# $auto_compress = false;
	# $bouton_admin_debug = true;

	# les fichiers de langue sont ceux que gere trad-lang, ils
	# se trouvent dans /var/shim/spipnet/lang/ , on cherche donc
	# lang/local_fr dans ../
	$dossier_squelettes = 'squelettes:/var/shim/spipnet';
	
	# taille max du cache
	$quota_cache = 40;

	# moderation des petitions
	define('_SPIP_MODERATEURS_PETITION', 'scalepa@gmail.com,ben.spip@gmail.com');

	# pour la page www.spip.fr/download
	define('VERSION_STABLE', '1.9.2c');
	define('VERSION_STABLE_URL', 'spip-dev/DISTRIB/spip.zip');

	$type_urls = 'trad';

	$table_des_traitements['TITRE'][]= 'typo(supprimer_numero(%s))';

	# raccourcis [->spip19] etc
	function calculer_url_spip($id, $texte='', $ancre='') {
	$spip = array( 
		1 => 1309,
		10 => 1309,
		103 => 1309,
		104 => 1309,
		105 => 1309,
		12 => 1310,
		121 => 1310,
		13 => 1253,
		14 => 1832,
		15 => 1911,
		16 => 1965,
		17 => 2102,
		171 => 2102,
		172 => 2102,
		18 => 2991,
		181 => 2991,
		182 => 3173,
		183 => 3333,
		19 => 3368,
		191 => 3462,
		192 => 3567
	);

	if (isset($spip[$id])) {
		$calculer_url_article = function_exists('calculer_url_article') ? 'calculer_url_article' : 'calculer_url_article_dist';
		$p = $calculer_url_article($spip[$id], $texte, $ancre);
		$p[1] = 'spip'; # class
		return $p;
	} else {
		return array('/', 'spip', 'version inconnue');
	}
	}
	# indispensable ? ou pas ?
	function generer_url_spip($id) {
		$p= calculer_url_spip($id);
		return $p[0];
	}

	# mise à jour des squelettes par http://www.spip.net/ecrire/?exec=svn_update
	define('_SVN_UPDATE_AUTEURS', '1:180:9:3021');

	# des urls pourries gatent le systeme
	if (_DIR_RESTREINT AND count(explode('/', $_SERVER['REQUEST_URI'])) -count(explode('/', $_SERVER['QUERY_STRING'])) > 2)
		die(header('Location: /'));
	
?>
