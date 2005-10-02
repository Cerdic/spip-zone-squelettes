<?php echo  $this->FormOpen("", "", "get") ?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>Ce que vous souhaitez chercher :&nbsp;</td>
		<td><input name="phrase" size="40" value="<?php echo  htmlentities($_REQUEST["phrase"]) ?>" /> <input type="submit" value="Chercher" /></td>
	</tr>
</table>
<?php echo  $this->FormClose(); ?>

<?php
if ($phrase = $_REQUEST["phrase"])
{
	echo "<br />" ;
	if ($results = $this->FullTextSearch($phrase))
	{
		echo "<b>R&eacute;sultat(s) de la recherche de \"$phrase\":</b><br /><br />\n" ;
		foreach ($results as $i => $page)
		{
			echo ($i+1),". ",$this->ComposeLinkToPage($page["tag"]),"<br />\n" ;
		}
	}
	else
	{
		echo "Aucun r&eacute;sultat pour \"$phrase\". :-(" ;
	}
}

?>
