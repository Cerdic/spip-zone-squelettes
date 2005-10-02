<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}
echo $this->Header();
?>
<div class="page">
<?php
if ($global = $_REQUEST["global"])
{
	$title = "Sites faisant r&eacute;f&eacute;rence &agrave; ce wiki (<a href=\"".$this->href("referrers_sites", "", "global=1")."\">voir la liste des domaines</a>)&nbsp;:";
	$referrers = $this->LoadReferrers();
}
else
{
	$title = "Pages externes faisant r&eacute;f&eacute;rence &agrave;  ".$this->ComposeLinkToPage($this->GetPageTag()).
	($this->GetConfigValue("referrers_purge_time") ? " (depuis ".($this->GetConfigValue("referrers_purge_time") == 1 ? "24 heures" : $this->GetConfigValue("referrers_purge_time")." jours").")" : "")." (<a href=\"".$this->href("referrers_sites")."\">voir la liste des domaines</a>)&nbsp;:";
		
	$referrers = $this->LoadReferrers($this->GetPageTag());
}

echo "<b>$title</b><br /><br />\n" ;
if ($referrers)
{
	{
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n" ;
		foreach ($referrers as $referrer)
		{
			echo "<tr>" ;
			echo "<td width=\"30\" align=\"right\" valign=\"top\" style=\"padding-right: 10px\">",$referrer["num"],"</td>" ;
			echo "<td valign=\"top\"><a href=\"",$referrer["referrer"],"\">",$referrer["referrer"],"</a></td>" ;
			echo "</tr>\n" ;
		}
		echo "</table>\n" ;
	}
}
else
{
	echo "<i>Aucune <acronym tilte=\"Uniform Resource Locator (adresse web)\">URL</acronym> ne fait r&eacute;f&eacute;rence &agrave; cette page.</i><br />\n" ;
}

if ($global)
{
	echo "<br />[<a href=\"",$this->href("referrers_sites"),"\">Voir les domaines faisant r&eacute;f&eacute;rence &agrave; ",$this->GetPageTag()," seulement</a> | <a href=\"",$this->href("referrers"),"\">Voir les r&eacute;f&eacute;rences &agrave; ",$this->GetPageTag()," seulement</a>]" ;
}
else
{

	echo "<br />[<a href=\"",$this->href("referrers_sites", "", "global=1"),"\">Voir tous les domaines faisant r&eacute;f&eacute;rence </a> | <a href=\"",$this->href("referrers", "", "global=1"),"\">Voir toutes les r&eacute;f&eacute;rences </a>]" ;
}


?>
</div>
<?php echo $this->Footer(); ?>