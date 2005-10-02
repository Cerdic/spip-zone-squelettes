<?php

// fetch configuration
$config = $_POST["config"];

if ($multi) {	// on installe en fonction de wname
	$config['table_prefix'] = 'wiki_'.$wname.'_';
	$config['base_url'] = '/'.$wname.'/';
	$config['rewrite_mode'] = 1;
	$wakkaConfigLocation = multi_config_file();
} else {
	$config['base_url'] = ereg_replace("installAction=.*", "wiki=", $REQUEST_URI);
	$config['rewrite_mode'] = 0;
}

// test configuration
/*
echo "<b>Test de la configuration</b><br>\n";
test("Test connexion MySQL ...", $dblink = @mysql_connect($config["mysql_host"], $config["mysql_user"], $config["mysql_password"]));
test("Recherche base de donn&eacute;es ...", @mysql_select_db($config["mysql_database"], $dblink), "La base de donn&eacute;es que vous avez choisie n'existe pas, vous devez la cr&eacute;er avant d'installer WikiNi !");
echo "<br>\n" ;
*/

// do installation stuff
if (!$version = trim($wakkaConfig["wakka_version"])) $version = "0";

switch ($version)
{
// new installation
case "0":
	echo "<b>Installation</b><br>\n";
	test("Creation table page...",
		@spip_query(
			"CREATE TABLE ".$config["table_prefix"]."pages (".
  			"id int(10) unsigned NOT NULL auto_increment,".
  			"tag varchar(50) NOT NULL default '',".
  			"time datetime NOT NULL default '0000-00-00 00:00:00',".
  			"body text NOT NULL,".
  			"body_r text NOT NULL,".
  			"owner varchar(50) NOT NULL default '',".
  			"user varchar(50) NOT NULL default '',".
  			"latest enum('Y','N') NOT NULL default 'N',".
  			"handler varchar(30) NOT NULL default 'page',".
  			"comment_on varchar(50) NOT NULL default '',".
  			"PRIMARY KEY  (id),".
  			"FULLTEXT KEY tag (tag,body),".
  			"KEY idx_tag (tag),".
  			"KEY idx_time (time),".
  			"KEY idx_latest (latest),".
  			"KEY idx_comment_on (comment_on)".
			") TYPE=MyISAM;", $dblink), "Already exists?", 0);
	test("Creation table ACL ...",
		@spip_query(
			"CREATE TABLE ".$config["table_prefix"]."acls (".
  			"page_tag varchar(50) NOT NULL default '',".
			"privilege varchar(20) NOT NULL default '',".
  			"list text NOT NULL,".
 			"PRIMARY KEY  (page_tag,privilege)".
			") TYPE=MyISAM", $dblink), "Already exists?", 0);
	test("Creation table link ...",
		@spip_query(
			"CREATE TABLE ".$config["table_prefix"]."links (".
			"from_tag char(50) NOT NULL default '',".
  			"to_tag char(50) NOT NULL default '',".
  			"UNIQUE KEY from_tag (from_tag,to_tag),".
  			"KEY idx_from (from_tag),".
  			"KEY idx_to (to_tag)".
			") TYPE=MyISAM", $dblink), "Already exists?", 0);
	test("Creation table referrer ...",
		@spip_query(
			"CREATE TABLE ".$config["table_prefix"]."referrers (".
  			"page_tag char(50) NOT NULL default '',".
  			"referrer char(150) NOT NULL default '',".
  			"time datetime NOT NULL default '0000-00-00 00:00:00',".
  			"KEY idx_page_tag (page_tag),".
  			"KEY idx_time (time)".
			") TYPE=MyISAM", $dblink), "Already exists?", 0);
	test("Creation table user ...",
		@spip_query(
			"CREATE TABLE ".$config["table_prefix"]."users (".
  			"name varchar(80) NOT NULL default '',".
  			"password varchar(32) NOT NULL default '',".
  			"email varchar(50) NOT NULL default '',".
  			"motto text NOT NULL,".
  			"revisioncount int(10) unsigned NOT NULL default '20',".
  			"changescount int(10) unsigned NOT NULL default '50',".
  			"doubleclickedit enum('Y','N') NOT NULL default 'Y',".
  			"signuptime datetime NOT NULL default '0000-00-00 00:00:00',".
  			"show_comments enum('Y','N') NOT NULL default 'N',".
  			"PRIMARY KEY  (name),".
  			"KEY idx_name (name),".
  			"KEY idx_signuptime (signuptime)".
			") TYPE=MyISAM", $dblink), "Already exists?", 0);
	spip_query("insert into ".$config["table_prefix"]."pages set tag = '".$config["root_page"]."', body = '".mysql_escape_string("Bienvenue ! Cliquez sur le lien \"Editer cette page\" au bas de la page pour démarrer.\n\nPage utiles: PagesOrphelines, PagesACreer, RechercheTexte, ReglesDeFormatage.")."', user = 'WikiNiInstaller', time = now(), latest = 'Y'", $dblink);
	spip_query("insert into ".$config["table_prefix"]."pages set tag = 'DerniersChangements', body = '((RecentChanges))', user = 'WikiNiInstaller', time = now(), latest = 'Y'", $dblink);
	spip_query("insert into ".$config["table_prefix"]."pages set tag = 'DerniersCommentaires', body = '((RecentlyCommented))', user = 'WikiNiInstaller', time = now(), latest = 'Y'", $dblink);
	spip_query("insert into ".$config["table_prefix"]."pages set tag = 'ParametresUtilisateur', body = '((UserSettings))', user = 'WikiNiInstaller', time = now(), latest = 'Y'", $dblink);
	spip_query("insert into ".$config["table_prefix"]."pages set tag = 'PagesACreer', body = '((WantedPages))', user = 'WikiNiInstaller', time = now(), latest = 'Y'", $dblink);
	spip_query("insert into ".$config["table_prefix"]."pages set tag = 'PagesOrphelines', body = '((OrphanedPages))', user = 'WikiNiInstaller', time = now(), latest = 'Y'", $dblink);
	spip_query("insert into ".$config["table_prefix"]."pages set tag = 'RechercheTexte', body = '((TextSearch))', user = 'WikiNiInstaller', time = now(), latest = 'Y'", $dblink);
	spip_query("insert into ".$config["table_prefix"]."pages set tag = 'ReglesDeFormatage', body = '{{{ Guide des règles de formatage }}}\n\nLes règles de formatage de spikini sont celles de SPIP.\n\nVous pouvez effectuer vos propres tests dans le BacASable : c\'est un endroit fait pour ça.\n\nRègles de base :\n-* <html>{{Texte en gras !}}</html> ---> {{Texte en gras !}}\n-* <html>{Texte en italique.}</html> ---> {Texte en italique.}\n\nIntertitres :\n-* <html>{{{Intertitre}}}</html>\n\nSéparateur horizontal :\n-* <html>----</html>\n\n- Puce :\n-* - commencer la ligne par un tiret', user = 'WikiNiInstaller', time = now(), latest = 'Y'", $dblink);
	test("Ajout de pages...", 1);
	break;
	
	// The funny upgrading stuff. Make sure these are in order! //
case "0.1":
	echo "<b>En cours de mise &agrave; jour de WikiNi 0.1</b><br>\n";
	test("Just very slightly altering the pages table...", 
		@spip_query("alter table ".$config["table_prefix"]."pages add body_r text not null default '' after body", $dblink), "Already done? Hmm!", 0);
	test("Claiming all your base...", 1);
}

?>

<p>
A l'&eacute;tape suivante, le programme d'installation va essayer
d'&eacute;crire le fichier de configuration <tt><?php echo  $wakkaConfigLocation ?></tt>.
Assurez vous que le serveur web a bien le droit d'&eacute;crire dans ce fichier, sinon vous devrez le modifier manuellement.  </p>

<form action="<?php echo  myLocation(); ?>?installAction=writeconfig" method="POST">
<input type="hidden" name="config" value="<?php echo  htmlentities(serialize($config)) ?>">
<input type="submit" value="Continuer">
</form>
