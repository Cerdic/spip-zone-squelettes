<?php
/*
+-----------------------------------------+
| Balises Statistiques/Visites . Spip 1.9.1
+-----------------------------------------+
| Frédéric Taraud et Scoty
+-----------------------------------------+
| nov. 2006 - www.koakidi.com
| Script certifié KOAK2.0 strict, mais si !
+-----------------------------------------+
*/

/*
| balise #TOTAL_VISITES
*/
function aff_total_visites() {
	$query = "SELECT SUM(visites) AS total_absolu FROM spip_visites";
	$result = spip_query($query);
	if ($row = sql_fetch($result))
		{ return $row['total_absolu']; }
	else { return "0";}
}

function balise_TOTAL_VISITES($p) {
	$p->code = "aff_total_visites()";
	$p->statut = 'php';
	return $p;
}



/*
| balise #VISITES_JOUR
*/
function visites_du_jour() {
	$q = spip_query("SELECT visites FROM spip_visites WHERE date=NOW()");
	if ($r = @sql_fetch($q))
		$g = $r['visites'];
	else
		$g = 0;
			
	return $g;
}
function balise_VISITES_JOUR($p) {
	$p->code = "visites_du_jour()";
	$p->interdire_scripts = false;
	return $p;
}


/*
| balises #JOUR_MAX_VISITES & #VAL_MAX_VISITES
*/
function generer_jour_val_max_visites($arg) {
	$qv = spip_query("SELECT MAX(visites) as maxvi FROM spip_visites");
	$rv = sql_fetch($qv);
	$valmaxi = $rv['maxvi'];

	if($arg=="date") {
		$qd = spip_query("SELECT date FROM spip_visites WHERE visites = $valmaxi");
		$rd = sql_fetch($qd);
		$jourmaxi = $rd['date'];
	}
	if($arg=="date") { $a = $jourmaxi; }
	if($arg=="val") { $a = $valmaxi; }
	return $a;
}
function balise_JOUR_MAX_VISITES($p) {
	$arg="date";
	$p->code = "generer_jour_val_max_visites($arg)";
	$p->interdire_scripts = false;
	return $p;
}
function balise_VAL_MAX_VISITES($p) {
	$arg="val";
	$p->code = "generer_jour_val_max_visites($arg)";
	$p->interdire_scripts = false;
	return $p;
}


/*
|  balise #MOYENNE_VISITES
*/
function aff_moyenne_visites() {
	$query="SELECT UNIX_TIMESTAMP(date) AS date_unix, visites FROM spip_visites ".
			"WHERE 1 AND date > DATE_SUB(NOW(),INTERVAL 420 DAY) ORDER BY date";
	$result=spip_query($query);

	while ($row = sql_fetch($result)) {
		$date = $row['date_unix'];
		$visites = $row['visites'];
 		$log[$date] = $visites;
	}

    if (count($log)>0){
		while (list($key, $value) = each($log)) {
			$n++;
			if ($decal == 30) $decal = 0;
			$decal ++;
			$tab_moyenne[$decal] = $value;
	
			$total_loc = $total_loc + $value;
			reset($tab_moyenne);
	
			$moyenne = 0;
			while (list(,$val_tab) = each($tab_moyenne))
				$moyenne += $val_tab;
				$moyenne = $moyenne / count($tab_moyenne);
	    }
    }
    else {
		$moyenne =0;
	}
    
	return round($moyenne);
}

function balise_MOYENNE_VISITES($p) {
	$p->code = "aff_moyenne_visites()";
	$p->interdire_scripts = false;
	return $p;
}

?>
