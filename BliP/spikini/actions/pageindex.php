<?php

if ($pages = $this->LoadAllPages())
{
	foreach ($pages as $page)
	{
		if (!preg_match("/^Comment/", $page["tag"])) {
			$firstChar = strtoupper($page["tag"][0]);
			if (!preg_match("/[A-Z,a-z]/", $firstChar)) {
				$firstChar = "#";
			}

			if ($firstChar != $curChar) {
				if ($curChar) echo "<br />\n" ;
				echo "<b>$firstChar</b><br />\n" ;
				$curChar = $firstChar;
			}

			echo $this->ComposeLinkToPage($page["tag"]),"<br />\n" ;
		}
	}
}
else
{
	echo "<i>Aucune page trouv&eacute;e.</i>" ;
}

?>
