<?php

@header ("content-type:text/css");

/*
*  choix de la CSS à utiliser
* */
if(isset($_COOKIE['usecss']) && $_COOKIE['usecss'] !='') { // si un cookie est posé
	$use = $_COOKIE['usecss'];
} else if(isset($_GET['use']) && $_GET['use']!='') { // sinon si une demande particulière est passée
	$use = $_GET['use'];
} else { // sinon utiliser css par défaut
	$use = 'default';
}
if($use == 'ie') $use = 'default'; // ancien test du temps où on avait 2 CSS

/*
* choix de la décoration à utiliser
* */
// inclusion de la liste des decorations
include('decoration/inc.php');

/*
* récupération du cache de décoration
* */
if(file_exists('decoration/cache.php')) {
	include('decoration/cache.php');
} else {
	$deco_old = 0;
}

if(isset($_GET['deco']) && $_GET['deco'] < count($decoration) ) { // si on a forcé par GET un nouveau $deco
	$deco = $_GET['deco'];
} else { // sinon prendre le $deco_old qui est dans le cache
	$deco = $deco_old;
}

if($deco != $deco_old) {
	/*
	* génération nouveau fichier de cache
	* + enregistrement
	* */
	$str = "<?php\n\$deco_old = $deco; \n?>";
	if($fp = fopen('decoration/cache.php','w')) {
		fwrite($fp,$str);
		fclose($fp);
	}
}

$css = 'screen_' . $use . '.css';
if(file_exists($css) && $use != 'default') {
	$import_css = $css;
	$deco_code = '';
} else {
	$import_css = 'screen_default.css';
	$deco_code = $decoration[$deco]['css'];
}

echo '

/*
	this is the "be nice to Michael Guitton" hack
	also known as the Holly Hack of course :)
	inspired by Ethan Marcotte http://sidesh0w.com/_share/skin/040528/screen.css
\*/

	@import url("' . $import_css . '");
	
' . $deco_code . '

/* and here\'s the end of hide-and-seek for old IE mac */
';

?>