<?php

// actions/mychanges.php
// written by Carlo Zottmann
// http://wakkawikki.com/CarloZottmann

if ($user = $this->GetUser())
{
	$my_edits_count = 0;

	if (($bydate = $this->GetParameter("bydate")))
	{
		echo "<b>Liste des pages que vous avez modifi&eacute;es, tri&eacute;e par date de modification.</b><br /><br />\n";	

		if ($pages = $this->LoadAll("SELECT tag, time FROM ".$this->config["table_prefix"]."pages WHERE user = '".mysql_escape_string($this->UserName())."' AND tag NOT LIKE 'Comment%' ORDER BY time ASC, tag ASC"))
		{
			foreach ($pages as $page)
			{
				$edited_pages[$page["tag"]] = $page["time"];
			}

			 arsort($edited_pages);

			foreach ($edited_pages as $page["tag"] => $page["time"])
			{
				// day header
				list($day, $time) = explode(" ", $page["time"]);
				if ($day != $curday)
				{
					if ($curday) echo "<br />\n";
					echo "<b>$day:</b><br />\n";
					$curday = $day;
				}

				// echo entry
				echo "&nbsp;&nbsp;&nbsp;($time) (",$this->ComposeLinkToPage($page["tag"], "revisions", "history", 0),") ",$this->ComposeLinkToPage($page["tag"], "", "", 0),"<br />\n";

				$my_edits_count++;
			}
			
			if ($my_edits_count == 0)
			{
				echo "<i>Vous n'avez pas modifi&eacute; de page.</i>";
			}
		}
		else
		{
			echo "<i>Aucune page trouv&eacute;e.</i>";
		}
	}
	else
	{
		echo "<b>Liste des pages que vous avez modifi&eacute;es, tri&eacute;e par ordre alphab&eacute;tique.</b><br /><br />\n";	

		if ($pages = $this->LoadAll("SELECT tag, time FROM ".$this->config["table_prefix"]."pages WHERE user = '".mysql_escape_string($this->UserName())."' AND tag NOT LIKE 'Comment%' ORDER BY tag ASC, time DESC"))
		{
			foreach ($pages as $page)
			{
				if ($last_tag != $page["tag"]) {
					$last_tag = $page["tag"];
					$firstChar = strtoupper($page["tag"][0]);
					if (!preg_match("/[A-Z,a-z]/", $firstChar)) {
						$firstChar = "#";
					}
		
					if ($firstChar != $curChar) {
						if ($curChar) echo "<br />\n";
						echo "<b>$firstChar</b><br />\n";
						$curChar = $firstChar;
					}
	
					// echo entry
					echo "&nbsp;&nbsp;&nbsp;(",$page["time"],") (",$this->ComposeLinkToPage($page["tag"], "revisions", "history", 0),") ",$this->ComposeLinkToPage($page["tag"], "", "", 0),"<br />\n";
	
					$my_edits_count++;
				}
			}
			
			if ($my_edits_count == 0)
			{
				echo "<i>Vous n'avez pas modifi&eacute; de page.</i>";
			}
		}
		else
		{
			echo "<i>Aucune page trouv&eacute;e.</i>";
		}
	}
}
else
{
	echo "<i>Vous n'&ecirc;tes pas identifi&eacute; : impossible d'afficher la liste des pages que vous avez modifi&eacute;es.</i>";
}

?>
