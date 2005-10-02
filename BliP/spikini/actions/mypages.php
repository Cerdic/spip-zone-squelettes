<?php

// actions/mypages.php
// written by Carlo Zottmann
// http://wakkawikki.com/CarloZottmann

if ($user = $this->GetUser())
{
	echo "<b>Liste des pages dont vous &ecirc;tes le propri&eacute;taire.</b><br /><br />\n" ;

	$my_pages_count = 0;

	if ($pages = $this->LoadAllPages())
	{
		foreach ($pages as $page)
		{
			if ($this->UserName() == $page["owner"] && !preg_match("/^Comment/", $page["tag"])) {
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
				
				$my_pages_count++;
			}
		}
		
		if ($my_pages_count == 0)
		{
			echo "<i>Vous n'&ecirc;tes le propri&eacute;taire d'aucune page.</i>";
		}
	}
	else
	{
		echo "<i>Aucune page trouv&eacute;e.</i>" ;
	}
}
else
{
	echo "<i>Vous n'&ecirc;tes pas identifi&eacute; : impossible d'afficher la liste des pages que vous avez modifi&eacute;es.</i>" ;
}

?>
