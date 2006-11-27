<?php

	#
	# SPIP_LOADER recupere et installe la version stable de SPIP
	#

	######################### CONFIGURATION #
	#
	# decommenter la ligne ci-dessous pour charger la version
	# de developpement (nightly build SVN) et commenter la ligne de
	# telechargement de la version STABLE
	# define('_URL_PAQUET_ZIP','http://trac.rezo.net/files/spip/spip.zip');

	# URL du paquet de la version STABLE a telecharger
	define('_URL_PAQUET_ZIP','http://www.spip.net/spip-dev/DISTRIB/spip.zip');

	# Adresse des librairies necessaires a spip_loader
	# (pclzip et fichiers de langue)
	define('_URL_LOADER_DL',"http://www.spip.net/spip-dev/INSTALL/");

	# telecharger a travers un proxy
	define('_URL_LOADER_PROXY', '');

	# auteur(s) autorise(s) a proceder aux mises a jour : '1:2:3'
	define('_SPIP_LOADER_UPDATE_AUTEURS', '1');

	#
	#######################################################################

	# code de reinstallation
	if (@file_exists('ecrire/inc_version.php')) {
		include_once 'ecrire/inc_version.php';
		if (defined('_FILE_CONNECT')
		AND _FILE_CONNECT)
			spip_loader_reinstalle();
	}

	# langues disponibles
	$langues = array (
		'ar' => '&#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;',
		'br' => 'brezhoneg',
		'ca' => 'catal&agrave;',
		'en' => 'English',
		'eo' => 'Esperanto',
		'es' => 'espa&ntilde;ol',
		'fr' => 'fran&ccedil;ais',
		'gl' => 'galego',
		'it' => 'italiano',
		'pt_br' => 'Portugu&#234;s do Brasil',
		'ro' => 'rom&#226;n&#259;'
	);

	//
	// Traduction des textes de SPIP
	//
	function _TT($code, $args=array()) {
		global $lang;
		$code = str_replace('tradloader:', '', $code);
		$text = $GLOBALS['i18n_tradloader_'.$lang][$code];
		while (list($name, $value) = @each($args))
			$text = str_replace ("@$name@", $value, $text);
		return $text;
	}

	//
	// Ecrire un fichier de maniere un peu sure
	//
	function ecrire_fichierT ($fichier, $contenu) {

		$fp = @fopen($fichier, 'wb');
		$s = @fputs($fp, $contenu, $a = strlen($contenu));

		$ok = ($s == $a);

		@fclose($fp);

		if (!$ok) {
			@unlink($fichier);
		}

		return $ok;
	}

	function regler_langue_navigateurT() {
		$accept_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		if (is_array($accept_langs)) {
			foreach($accept_langs as $s) {
				if (eregi('^([a-z]{2,3})(-[a-z]{2,3})?(;q=[0-9.]+)?$', trim($s), $r)) {
					$lang = strtolower($r[1]);
					if (isset($GLOBALS['langues'][$lang])) return $lang;
				}
			}
		}
		return false;
	}

	function menu_languesT($lang) {
		$r = '<div style="float:'.$GLOBALS['spip_lang_right'].';">';
		$r .= '<form action="./spip_loader.php" method="get">';
		$r .= '<select name="lang"
			onchange="window.location=\'spip_loader.php?lang=\'+this.value;">';
		foreach ($GLOBALS['langues'] as $l => $nom)
			$r .= '<option value="'.$l.'"' . ($l == $lang ? ' selected' : '')
				. '>'.$nom.'</option>';
		$r .= '</select> <noscript><input type="submit" name="ok" value="ok" /></noscript></form>';
		$r .= '</div>';
		return $r;
	}


	//
	// Gestion des droits d'acces
	//
	function tester_repertoire() {
		global $chmod;
		
		$ok = false;
		$self = basename($_SERVER['PHP_SELF']);
		$uid = @fileowner('.');
		$uid2 = @fileowner($self);
		$gid = @filegroup('.');
		$gid2 = @filegroup($self);
		$perms = @fileperms($self);

		// Comparer l'appartenance d'un fichier cree par PHP
		// avec celle du script et du repertoire courant
		@rmdir('test');
		@unlink('test'); // effacer au cas ou
		@touch('test');
		if ($uid > 0 && $uid == $uid2 && @fileowner('test') == $uid)
			$chmod = 0700;
		else if ($gid > 0 && $gid == $gid2 && @filegroup('test') == $gid)
			$chmod = 0770;
		else
			$chmod = 0777;
		// Appliquer de plus les droits d'acces du script
		if ($perms > 0) {
			$perms = ($perms & 0777) | (($perms & 0444) >> 2);
			$chmod |= $perms;
		}
		@unlink('test');

		// Verifier que les valeurs sont correctes

		@mkdir('test', $chmod);
		@chmod('test', $chmod);
		$f = @fopen('test/test.php', 'w');
		if ($f) {
			@fputs($f, '<'.'?php $ok = true; ?'.'>');
			@fclose($f);
			@chmod('test/test.php', $chmod);
			include('test/test.php');
		}
		@unlink('test/test.php');
		@rmdir('test');

		return $ok;
	}

	//
	// Demarre une transaction HTTP (s'arrete a la fin des entetes)
	// retourne un descripteur de fichier
	//
	function init_http($get, $url, $refuse_gz=false) {
		//global $http_proxy;
		$fopen = false;
		if (!eregi("^http://", _URL_LOADER_PROXY))
			$http_proxy = '';
		else
			$http_proxy = _URL_LOADER_PROXY;

		$t = @parse_url($url);
		$host = $t['host'];
		if ($t['scheme'] == 'http') {
			$scheme = 'http'; $scheme_fsock='';
		} else {
			$scheme = $t['scheme']; $scheme_fsock=$scheme.'://';
		}
		if (!isset($t['port']) OR !($port = $t['port'])) $port = 80;
		$query = isset($t['query'])?$t['query']:"";
		if (!isset($t['path']) OR !($path = $t['path'])) $path = "/";

		if ($http_proxy) {
			$t2 = @parse_url($http_proxy);
			$proxy_host = $t2['host'];
			$proxy_user = $t2['user'];
			$proxy_pass = $t2['pass'];
			if (!($proxy_port = $t2['port'])) $proxy_port = 80;
			$f = @fsockopen($proxy_host, $proxy_port);
		} else
			$f = @fsockopen($scheme_fsock.$host, $port);

		if ($f) {
			if ($http_proxy)
				fputs($f, "$get $scheme://$host" . (($port != 80) ? ":$port" : "") . $path . ($query ? "?$query" : "") . " HTTP/1.0\r\n");
			else
				fputs($f, "$get $path" . ($query ? "?$query" : "") . " HTTP/1.0\r\n");

			$version_affichee = isset($GLOBALS['spip_version_affichee'])?$GLOBALS['spip_version_affichee']:"xx";
			fputs($f, "Host: $host\r\n");
			fputs($f, "User-Agent: SPIP-$version_affichee (http://www.spip.net/)\r\n");

			// Proxy authentifiant
			if (isset($proxy_user) AND $proxy_user) {
				fputs($f, "Proxy-Authorization: Basic "
				. base64_encode($proxy_user . ":" . $proxy_pass) . "\r\n");
			}

		}
		// fallback : fopen
		else if (!$http_proxy) {
			$f = @fopen($url, "rb");
			$fopen = true;
		}
		// echec total
		else {
			$f = false;
		}

		return array($f, $fopen);
	}

	//
	// Recupere une page sur le net
	// et au besoin l'encode dans le charset local
	//
	// options : get_headers si on veut recuperer les entetes
	function recuperer_page($url) {

		// Accepter les URLs au format feed:// ou qui ont oublie le http://
		$url = preg_replace(',^feed://,i', 'http://', $url);
		if (!preg_match(',^[a-z]+://,i', $url)) $url = 'http://'.$url;

		for ($i=0;$i<10;$i++) {	// dix tentatives maximum en cas d'entetes 301...
			list($f, $fopen) = init_http('GET', $url);

			// si on a utilise fopen() - passer a la suite
			if ($fopen) {
				break;
			} else {
				// Fin des entetes envoyees par SPIP
				fputs($f,"\r\n");

				// Reponse du serveur distant
				$s = trim(fgets($f, 16384));
				if (ereg('^HTTP/[0-9]+\.[0-9]+ ([0-9]+)', $s, $r)) {
					$status = $r[1];
				}
				else return;

				// Entetes HTTP de la page
				$headers = '';
				while ($s = trim(fgets($f, 16384))) {
					$headers .= $s."\n";
					if (eregi('^Location: (.*)', $s, $r)) {
						$location = $r[1];
					}
					if (preg_match(",^Content-Encoding: .*gzip,i", $s))
						$gz = true;
				}
				if ($status >= 300 AND $status < 400 AND $location)
					$url = $location;
				else if ($status != 200)
					return;
				else
					break; # ici on est content
				fclose($f);
				$f = false;
			}
		}

		// Contenu de la page
		if (!$f) {
			return false;
		}

		$result = '';
		while (!feof($f))
			$result .= fread($f, 16384);
		fclose($f);

		// Decompresser le flux
		if ($gz = $_GET['gz'])
			$result = gzinflate(substr($result,10));

		return $result;
	}

	function telecharger_langue($lang, $droits) {
		global $dir_base;
		$fichier = 'tradloader_'.$lang.'.php';
		$GLOBALS['idx_lang'] = 'i18n_tradloader_'.$lang;
		if(!file_exists($dir_base.$fichier)) {
			$contenu = recuperer_page(_URL_LOADER_DL.$fichier.".txt");
			if ($contenu AND $droits) {
				ecrire_fichierT($dir_base.$fichier, $contenu);
				include($dir_base.$fichier);
				return true;
			} elseif($contenu AND !$droits) {
				eval('?'.'>'.$contenu);
				return true;
			} else {
				return false;
			}
		} else {
			include($dir_base.$fichier);
			return true;
		}
	}

	function selectionner_langue($droits) {
		global $langues; # langues dispo

		if (isset($_COOKIE['spip_lang_ecrire'])) {
			$lang = $_COOKIE['spip_lang_ecrire'];
		}

		if (isset($_GET['lang']))
			$lang = $_GET['lang'];

		# reglage par defaut selon les preferences du brouteur
		if (!$lang OR !isset($langues[$lang]))
			$lang = regler_langue_navigateurT();

		# valeur par defaut
		if (!isset($langues[$lang])) $lang = 'fr';

		# memoriser dans un cookie pour l'etape d'apres *et* pour l'install
		setcookie('spip_lang_ecrire', $lang);

		# RTL
		if ($lang == 'ar' OR $lang == 'he' OR $lang == 'fa') {
			$GLOBALS['spip_lang_right']='left';
			$GLOBALS['spip_lang_dir']='rtl';
		} else {
			$GLOBALS['spip_lang_right']='right';
			$GLOBALS['spip_lang_dir']='ltr';
		}

		# code de retour = capacite a telecharger le fichier de langue
		$GLOBALS['idx_lang'] = 'i18n_tradloader_'.$lang;
		return telecharger_langue($lang,$droits) ? $lang : false;
	}

	function debut_html() {
		?>
		<HTML <?php echo "dir='".$GLOBALS['spip_lang_dir']."'";?>>
		<HEAD>
		<TITLE><?php echo _TT('tradloader:titre'); ?></TITLE>
		<META HTTP-EQUIV="Expires" CONTENT="0">
		<META HTTP-EQUIV="cache-control" CONTENT="no-cache,no-store">
		<META HTTP-EQUIV="pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">


		<style>
		<!--
			a {text-decoration: none; }
			A:Hover {color:#FF9900; text-decoration: underline;}
			.forml {width: 100%; background-color: #FFCC66; background-position: center bottom; float: none; color: #000000}
			.formo {width: 100%; background-color: #970038; background-position: center bottom; float: none; color: #FFFFFF}
			.fondl {background-color: #FFCC66; background-position: center bottom; float: none; color: #000000}
			.fondo {background-color: #970038; background-position: center bottom; float: none; color: #FFFFFF}
			.fondf {background-color: #FFFFFF; border-style: solid ; border-width: 1; border-color: #E86519; color: #E86519}
		-->
		</style>
		</HEAD>

		<body bgcolor="#FFFFFF" text="#000000" link="#E86519" vlink="#6E003A" alink="#FF9900" TOPMARGIN="0" LEFTMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0">

		<BR><BR><BR>
		<CENTER>
		<TABLE WIDTH=450>
		<TR><TD WIDTH=450>
		<?php echo menu_languesT($GLOBALS['lang']); ?>

		<FONT FACE="Verdana,Arial,Helvetica,sans-serif" SIZE=4 COLOR="#970038"><B><?php
			echo _TT('tradloader:titre');
		?></B></FONT>
		<FONT FACE="Georgia,Garamond,Times,serif" SIZE=3>
		<?php
	}


	function fin_html() {
		?>
		</FONT>
		</TD></TR></TABLE>
		</CENTER>
		</BODY>

		</HTML>
		<?php
	}

	function nettoyer_racine($fichier) {
		global $dir_base;
		@unlink($dir_base.$fichier);
		@unlink($dir_base.'pclzip.php');
		$d = opendir($dir_base);
		while (false !== ($f = readdir($d))) {
			if(preg_match('/^tradloader_(.+).php$/', $f)) @unlink($dir_base.$f);
		}
		closedir($d);
		return true;
	}

///////////////////////////////////////////////
// debut du process
//

	error_reporting(E_ALL ^ E_NOTICE);

	$dir_base = './'; //repertoire d'installation

	$droits = tester_repertoire();

	if ($lang = selectionner_langue($droits)) {
		if(!$droits) {
			//on ne peut pas ecrire
			debut_html(_TT('tradloader:titre'));
			echo _TT('tradloader:texte_preliminaire');

			fin_html();
			exit;
		}
		else {
			//on telecharge, on ecrit, au fait, on peut dezipper ?
			//
			// Verifier si la ZLib est utilisable
			//
			$gz = function_exists("gzopen");
			if ($gz) {
				if(!file_exists($dir_base."pclzip.php")) {
					$contenu = recuperer_page(_URL_LOADER_DL."pclzip.php.txt");
					if ($contenu) {
						ecrire_fichierT($dir_base."pclzip.php", $contenu);
						include($dir_base."pclzip.php");
					}
				} else {
					include($dir_base."pclzip.php");
				}
			}
			else
				die ('fonctions zip non disponibles');

			$fichier = basename(_URL_PAQUET_ZIP);

			//
			// deploiement de l'archive
			//
			if ($_GET['fichier'] == 'oui'
			AND file_exists($dir_base.$fichier)) {
				$zip = new PclZip($dir_base.$fichier);
				$ok = $zip->extract(
					PCLZIP_OPT_PATH, $dir_base,
					PCLZIP_OPT_SET_CHMOD, $chmod & ~0111,
					PCLZIP_OPT_REMOVE_PATH, "spip/");
				if ($zip->error_code<0) {
					debut_html();
					echo _TT('tradloader:donnees_incorrectes',
						array('erreur' => $zip->errorInfo()));
					fin_html();
					exit;
				}
				nettoyer_racine($fichier);
				header("Location: ".$dir_base."ecrire/");
				exit;
			}
			//
			// Si pas encore fait, afficher la page de presentation
			//
			if ($_GET['charger'] != 'oui') {
				debut_html();
				echo _TT('tradloader:texte_intro');
				echo "<DIV ALIGN='".$GLOBALS['spip_lang_right']."'>";
				echo "<FORM ACTION='spip_loader.php' METHOD='get'>";
				echo "<INPUT TYPE='hidden' NAME='charger' VALUE='oui'>";
				echo "<INPUT TYPE='submit' NAME='Valider' VALUE=\""._TT('tradloader:bouton_suivant')."\">";
				echo "</FORM>";

				fin_html();
				exit;
			}

			$contenu = recuperer_page(_URL_PAQUET_ZIP);

			if(!($contenu AND ecrire_fichierT($dir_base.$fichier, $contenu))) {
				debut_html();
				echo _TT('tradloader:echec_chargement');
				fin_html();
				exit;
			}

			// Passer a l'etape suivante (desarchivage)
			header("Location: spip_loader.php?fichier=oui");
			exit;
		}
	}
	else {
		//on ne peut pas telecharger, c'est foutu.
		$lang = 'fr'; //francais par defaut
		$GLOBALS['i18n_tradloader_fr']['titre'] = 'T&eacute;l&eacute;chargement de SPIP';
		$GLOBALS['i18n_tradloader_fr']['echec_chargement'] = '<h4>Le chargement a &eacute;chou&eacute;. Veuillez r&eacute;essayer, ou utiliser l\'installation manuelle.</h4>';
		debut_html();
		echo _TT('tradloader:echec_chargement');
		fin_html();
		exit;
	}

	function spip_loader_reinstalle() {
		if ($GLOBALS['auteur_session']['statut'] != '0minirezo'
		OR !in_array($GLOBALS['auteur_session']['id_auteur'],
		explode(':', _SPIP_LOADER_UPDATE_AUTEURS))) {
			include_spip('inc/headers');
			include_spip('inc/minipres');
			http_status('403');
			install_debut_html();
			echo _T('ecrire:avis_non_acces_page');
			install_fin_html();
			exit;
		}
	}

?>
