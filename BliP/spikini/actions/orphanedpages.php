<?php

if ($pages = $this->LoadOrphanedPages())
{
	foreach ($pages as $page)
	{
		echo $this->ComposeLinkToPage($page["tag"], "", "", 0),"<br />\n" ;
	}
}
else
{
	echo "<i>Pas de pages orphelines</i>" ;
}

?>
