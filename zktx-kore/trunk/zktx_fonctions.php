<?php
// Balise #LOGO
// http://romy.tetue.net/logos-automatiques-articles-SPIP#forum2039
	function balise_LOGO_dist($p) {
		$_id_article = champ_sql('id_article', $p);
		$_id_rubrique= champ_sql('id_rubrique', $p);

		$p->code = "recuperer_fond('balises/logo',array('id_article'=>$_id_article,'id_rubrique'=>$_id_rubrique))";
		$p->interdire_scripts = false;
		return $p;
	}