<?php
	$message = $this->GetMessage();
	$user = $this->GetUser();
	$multi = $GLOBALS['multi'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>


<head>
<title><?php echo "[".$this->GetWakkaName()."]&nbsp;"."[wiki]&nbsp;".$this->GetPageTag(); ?></title>
<?php
if ($this->GetMethod() != 'show' || isset($_REQUEST["time"]))
	echo "<meta name=\"robots\" content=\"noindex, nofollow\"/>\n";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<meta name="keywords" content="<?php echo $this->GetConfigValue("meta_keywords") ?>" />
<meta name="description" content="<?php echo  $this->GetConfigValue("meta_description") ?>" />

<?php
include ("blip/inclusions/inc_structure_css.php3");
?>

<script type="text/javascript">
function fKeyDown()	{
	if (event.keyCode == 9) {
		event.returnValue= false;
		document.selection.createRange().text = String.fromCharCode(9) } }
</script>
</head>


<body <?php echo (!$user || ($user["doubleclickedit"] != 'N')) && ($this->GetMethod() == "show") ? "ondblclick=\"document.location='".$this->href("edit")."';\" " : "" ?>
<?php echo $message ? "onLoad=\"alert('".$message."');\" " : "" ?>  id="spikini"><a name="hautdepage"></a>





<div id="page">

	<?php	
		include ("blip/inclusions/inc_structure_entete_sedna.php3");
	?> 	

	<div id="contenu_principal_wiki">


<h1 class="titre_article"><a href="<?php echo $this->config["base_url"] ?>RechercheTexte&amp;phrase=<?php echo urlencode($this->GetPageTag()); ?>" title="Rechercher"><?php echo $this->GetPageTag(); ?></a></h1>
<h5>
					<?php
					echo  $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"Cliquez pour voir les derni&egrave;res modifications sur cette page.\">".$this->GetPageTime()."</a>"." | " : "";
					echo  $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" title=\"Cliquez pour modifier cette page.\">Modifier cette page</a>"." | " : "";
					// if this page exists
						if ($this->page)
						{
							// if owner is current user
							if ($this->UserIsOwner())
							{
								echo $this->GetPageOwner()." | ",
								"<a href=\"",$this->href("acls")."\" title=\"Cliquez pour &eacute;diter les permissions de cette page.\">Mod&eacute;rer</a>"." | ",
								"<a href=\"",$this->href("deletepage")."\">Supprimer</a>";
							}
							else
							{
								if ($owner = $this->GetPageOwner())
								{
									echo $this->Format($owner);
								}
								else
								{
									echo "Pas de propri&eacute;taire | ";
									echo ($this->GetUser() ? "<a href=\"".$this->href("claim")."\">S'approprier cette page</a>" : "");
								}
							}
						}
					?>

| <a href="<?php echo $this->href("referrers") ?>" title="Cliquez pour voir les URLs faisant r&eacute;f&eacute;rence &agrave; cette page.">URLs faisant r&eacute;f&eacute;rence &agrave; cette page</a>
</h5>
<h5>
Revenir à l'<a href="<?php echo lire_meta('adresse_site') ?>/spikini/?wiki=PagePrincipale">accueil</a> de ce Wiki, consulter l'<a href="<?php echo lire_meta('adresse_site') ?>/spikini/?wiki=DerniersChangements">historique des modifications</a>, afficher la <a href="<?php echo lire_meta('adresse_site') ?>/spikini/?wiki=ListeDesPages">liste des pages</a>
 publiées, lire l'<a href="<?php echo lire_meta('adresse_site') ?>/spikini/?wiki=AideEnLigne">aide en ligne</a>.

</h5>


<div id="Container-texte">