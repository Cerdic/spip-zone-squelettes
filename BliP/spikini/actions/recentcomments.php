<?php

if ($comments = $this->LoadRecentComments())
{
	foreach ($comments as $comment)
	{
		// day header
		list($day, $time) = explode(" ", $comment["time"]);
		if ($day != $curday)
		{
			if ($curday) echo "<br />\n" ;
			echo "<b>$day:</b><br />\n" ;
			$curday = $day;
		}

		// echo entry
		echo "&nbsp;&nbsp;&nbsp;(",$comment["time"],") <a href=\"",$this->href("", $comment["comment_on"], "show_comments=1"),"#",$comment["tag"],"\">",$comment["comment_on"],"</a> . . . . ",$this->Format($comment["user"]),"<br />\n" ;
	}
}
else
{
	echo "<i>Pas de commentaires r&eacute;cents.</i>" ;
}

?>
