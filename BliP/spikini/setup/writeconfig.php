<?php

if ($multi) {
	$wakkaConfigLocation = multi_config_file();
}

// fetch config
$config = $config2 = unserialize($_POST["config"]);

// merge existing configuration with new one
$config = array_merge($wakkaConfig, $config);

// set version to current version, yay!
$config["wakka_version"] = WAKKA_VERSION;

// convert config array into PHP code
$configCode = "<?php\n// wakka.config.php cr&eacute;&eacute;e ".strftime("%c")."\n// ne changez pas la wakka_version manuellement!\n\n\$wakkaConfig = array(\n";
foreach ($config as $k => $v)
{
	$entries[] = "\t\"".$k."\" => \"".$v."\"";
}
$configCode .= implode(",\n", $entries).");\n?>";

// try to write configuration file
echo "<b>Cr&eacute;ation du fichier de configuration en cours...</b><br>\n";
test("&Eacute;criture du fichier de configuration <tt>".$wakkaConfigLocation."</tt>...", $fp = @fopen($wakkaConfigLocation, "w"), "", 0);

if ($fp)
{
	fwrite($fp, $configCode);
	// write
	fclose($fp);
	
	echo "<p>Voila c'est termin&eacute; ! Vous pouvez <a href=\"",$config["base_url"],"\">retourner sur votre site WikiNi</a>. Il est conseill&eacute; de retirer l'acc&egrave;s en &eacute;criture au fichier <tt>wakka.config.php</tt>. Ceci peut &ecirc;tre une faille dans la s&eacute;curit&eacute;.</p>";
}
else
{
	// complain
	echo"<p><span class=\"failed\">AVERTISSEMENT:</span> Le
fichier de configuration <tt>",$wakkaConfigLocation,"</tt> n'a pu &ecirc;tre
cr&eacute;&eacute;. Veuillez vous assurez que votre serveur a les droits d'acc&egrave;s en &eacute;criture pour ce fichier. Si pour une raison quelconque vous ne pouvez pas faire &ccedil;a vous devez copier les informations suivantes et les uploader sur le serveur dans un fichier <tt>wakka.config.php</tt> directement dans le r&eacute;pertoire de WikiNi. Une fois que vous aurez fais cela, votre site WikiNi devrait fonctionner correctement.</p>\n";
	?>
	<form action="<?php echo  myLocation() ?>?installAction=writeconfig" method="POST">
	<input type="hidden" name="config" value="<?php echo  htmlentities(serialize($config2)) ?>">
	<input type="submit" value="Essayer &agrave; nouveau">
	</form>	
	<?php
	echo"<div style=\"background-color: #EEEEEE; padding: 10px 10px;\">\n<xmp>",$configCode,"</xmp>\n</div>\n";
}

?>
