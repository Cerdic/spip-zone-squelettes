<?php
if ($pages = $this->LoadWantedPages())
{
	foreach ($pages as $page)
	{
		echo $this->Link($page["tag"])," (<a
 ref=\"",$this->href(),"&amp;linking_to=",$page["tag"],"\">",$page["count"],"</a>)<br />\n";
	}
}
else
{
	echo "<i>Aucune page &agrave; cr&eacute;er.</i>";
}
?>
