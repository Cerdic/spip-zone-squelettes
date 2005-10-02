<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}
echo $this->Header();
?>
<div class="page">
<?php
// load revisions for this pageif
if ($this->HasAccess("read")) {

	if ($pages = $this->LoadRevisions($this->tag))
	{
		$output .= $this->FormOpen("diff", "", "get");
		$output .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";
		$output .= "<tr>\n";
		$output .= "<td><input class=\"spip_bouton\" type=\"submit\" value=\"Voir Diff&eacute;rences\" /></td>";
		$output .= "<td><input type=\"checkbox\" name=\"fastdiff\"/>\n".$this->Format("Affichage simplifi&eacute;")."</td>";
		$output .= "</tr>\n";
		$output .= "</table>\n";
		$output .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";
		if ($user = $this->GetUser())
		{
			$max = $user["revisioncount"];
		}
		else
		{
			$max = 20;
		}
	
		$c = 0;
		foreach ($pages as $page)
		{
			$c++;
			if (($c <= $max) || !$max)
			{
				$output .= "<tr>";
				$output .= "<td><input type=\"radio\" name=\"a\" value=\"".$page["id"]."\" ".($c == 1 ? "checked=\"checked\"" : "")." /></td>";
				$output .= "<td><input type=\"radio\" name=\"b\" value=\"".$page["id"]."\" ".($c == 2 ? "checked=\"checked\"" : "")." /></td>";
				$output .= "<td>&nbsp;<a href=\"".$this->href("show")."&amp;time=".urlencode($page["time"])."\">".$page["time"]."</a></td>";
				$output .= "<td>&nbsp;by ".$this->Format($page["user"])."</td>";
				$output .= "</tr>\n";
			}
		}
		$output .= "</table>\n".$this->FormClose()."\n";
	}
	echo $output ;
}
else
{
	echo "<i>Vous n'avez pas acc&egrave;s &agrave; cette page.</i>" ;
}
?>
</div>
<?php echo $this->Footer(); ?>