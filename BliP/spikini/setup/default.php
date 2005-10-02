<form action="<?php echo  myLocation() ?>?installAction=install" method="POST">
<table>

	<tr><td></td><td><b>Installation</b></td></tr>

	<?php
	if ($wakkaConfig["wakka_version"])
	{
		echo "<tr><td></td><td>Votre syst&egrave;me WikiNi existant a &eacute;t&eacute; reconnu comme &eacute;tant la version ",$wakkaConfig["wakka_version"],". Vous &ecirc;tes sur le point de <b>mettre &agrave; jour</b> WikiNi pour la version ",WAKKA_VERSION,". Veuillez revoir vos informations de configuration ci-dessous.</td></tr>\n";
	}
	else
	{
		echo "<tr><td></td><td>Vous &ecirc;tes sur le point d'installer WikiNi ",WAKKA_VERSION,". Veuillez configurer votre WikiNi en utilisant le formulaire suivant.</td></tr>\n";
	}
	?>

<?php  if (! $multi) { ?>
	<tr><td></td><td><br>NOTE: Ce programme d'installation va essayer de modifier les options de configurations dans le fichier <tt>wakka.config.php</tt>, situ&eacute; dans votre r&eacute;pertoire WikiNi. Pour que cela fonctionne, veuillez vous assurez que votre serveur a les droits d'acc&egrave;s en &eacute;criture pour ce fichier. Si pour une raison quelconque vous ne pouvez pas faire &ccedil;a vous devrez modifier ce fichier manuellement (ce programme d'installation vous dira comment).</td></tr>
<?php } ?>

<!--
	<tr><td></td><td><br><b>Configuration de la base de donn&eacute;es</b></td></tr>
	<tr><td></td><td>La machine sur laquelle se trouve votre serveur MySQL. En g&eacute;n&eacute;ral c'est "localhost" (ie, la m&ecirc;me machine que celle o&ugrave; se trouve les pages de WikiNi.).</td></tr>
	<tr><td align="right" nowrap>Machine MySQL :</td><td><input type="text" size="50" name="config[mysql_host]" value="<?php echo  $wakkaConfig["mysql_host"] ?>"></td></tr>
	<tr><td></td><td>La base de donn&eacute;es MySQL &agrave; utiliser pour WikiNi. Cette base de donn&eacute;es doit d&eacute;j&agrave; exister avant de pouvoir continuer.</td></tr>
	<tr><td align="right" nowrap>Base de donn&eacute;es MySQL :</td><td><input type="text" size="50" name="config[mysql_database]" value="<?php echo  $wakkaConfig["mysql_database"] ?>"></td></tr>
	<tr><td></td><td>Nom et mot de passe de l'utilisateur MySQL qui sera utilis&eacute; pour se connecter &agrave; votre base de donn&eacute;es.</td></tr>
	<tr><td align="right" nowrap>Non de l'utilisateur MySQL :</td><td><input type="text" size="50" name="config[mysql_user]" value="<?php echo  $wakkaConfig["mysql_user"] ?>"></td></tr>
	<tr><td align="right" nowrap>Mot de passe MySQL :</td><td><input type="password" size="50" name="config[mysql_password]" value="<?php echo  $wakkaConfig["mysql_password"] ?>"></td></tr>
-->

<?php  if (! $multi) { ?>
	<tr><td></td><td>Pr&eacute;fixe &agrave; utiliser pour toutes les tables utilis&eacute;es par WikiNi. Ceci vous permet d'utiliser plusieurs WikiNi sur une m&ecirc;me base de donnn&eacute;es en donnant diff&eacute;rents pr&eacute;fixes aux tables.</td></tr>
	<tr><td align="right" nowrap>Prefixe des tables :</td><td><input type="text" size="50" name="config[table_prefix]" value="<?php echo  $wakkaConfig["table_prefix"] ?>"></td></tr>
<?php } ?>

	<tr><td></td><td><br><b>Configuration de votre site WikiNi</b></td></tr>

	<tr><td></td><td>Le nom de votre site WikiNi. Ceci est g&eacute;n&eacute;ralement un NomWiki et EstSousCetteForme.</td></tr>
	<tr><td align="right" nowrap>Le nom de votre WikiNi :</td><td><input type="text" size="50" name="config[wakka_name]" value="<?php echo  $wakkaConfig["wakka_name"] ?>"></td></tr>

	<tr><td></td><td>La page d'accueil de votre WikiNi. Ceci doit &ecirc;tre un NomWiki.</td></tr>
	<tr><td align="right" nowrap>Home page:</td><td><input type="text" size="50" name="config[root_page]" value="<?php echo  $wakkaConfig["root_page"] ?>"></td></tr>

<!--
	<tr><td></td><td>META Mots clefs/Description qui seront ins&eacute;r&eacute;s dans les codes HTML.</td></tr>
	<tr><td align="right" nowrap>Mots clefs :</td><td><input type="text" size="50" name="config[meta_keywords]" value="<?php echo  $wakkaConfig["meta_keywords"] ?>"></td></tr>
	<tr><td align="right" nowrap>Description :</td><td><input type="text" size="50" name="config[meta_description]" value="<?php echo  $wakkaConfig["meta_description"] ?>"></td></tr>

	<tr><td></td><td><br><b>Configuration de l'URL de votre WikiNi</b><?php echo  $wakkaConfig["wakka_version"] ? "" : "<br>Ceci est une nouvelle installation. Le programme d'installation va essayer de trouver les valeurs appropri&eacute;es. Changez-les uniquement si vous savez ce que vous faites." ?></td></tr>

	<tr><td></td><td>L'URL de base de votre site WikiNi. Les noms des pages seront directement rajout&eacute;s &agrave; cet URL. Supprimez la partie "?wiki=" uniquement si vous utilisez la redirection (voir ci apr&egrave;s).</td></tr>
	<tr><td align="right" nowrap>URL de base :</td><td><input type="text" size="50" name="config[base_url]" value="<?php echo  $wakkaConfig["base_url"] ?>"></td></tr>

	<tr><td></td><td>Le mode "redirection automatique" doit &ecirc;tre s&eacute;lectionn&eacute; uniquement si vous utilisez WikiNi avec la redirection d'URL (si vous ne savez pas ce qu'est la redirection d'URL n'activez pas cette option).</td></tr>
	<tr><td align="right" nowrap>Mode "redirection" :</td><td><input type="hidden" name="config[rewrite_mode]" value="0"><input type="checkbox" name="config[rewrite_mode]" value="1" <?php echo  $wakkaConfig["rewrite_mode"] ? "checked" : "" ?>> Activation</td></tr>
-->

<!--
	<tr><td></td><td><br><b>Options suppl&eacute;mentaires</b></td></tr>
-->

	<tr><td></td><td><input type="hidden" name="config[preview_before_save]" value="0"><input type="checkbox" name="config[preview_before_save]" value="1" <?php echo  $wakkaConfig["preview_before_save"] ? "checked" : "" ?>> Imposer de faire un aper&ccedil;u avant de pouvoir sauver une page.</td></tr>
	
	<tr><td></td><td><input type="submit" value="Continuer"></td></tr>
</table>
</form>
