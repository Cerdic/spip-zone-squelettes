<?php

// Which is the max number of pages to be shown ?
if ($max = $this->GetParameter("max"))
{
    if ($max=="last") $max=50; else $last = (int) $max;
}
/*elseif ($user = $this->GetUser())
{
    $max = $user["changescount"];
}*/
else
{
    $max = 50;
}

// Show recently changed pages
if ($pages = $this->LoadRecentlyChanged($max))
{
	if ($this->GetParameter("max"))
	{
		foreach ($pages as $i => $page)
		{
			// echo entry
			echo "(",$page["time"],") (",$this->ComposeLinkToPage($page["tag"], "revisions", "historique", 0),") ",$this->ComposeLinkToPage($page["tag"], "", "", 0)," . . . . ",$this->Format($page["user"]),"<br />\n" ;
		}
	}
	else
	{
		$curday='';
        foreach ($pages as $i => $page)
		{
			// day header
			list($day, $time) = explode(" ", $page["time"]);
			if ($day != $curday)
			{
				if ($curday) echo "<br />\n" ;
				echo "<b>$day&nbsp;:</b><br />\n" ;
				$curday = $day;
			}
			// echo entry
			echo "&nbsp;&nbsp;&nbsp;(",$time,") (",$this->ComposeLinkToPage($page["tag"], "revisions", "historique", 0),") ",$this->ComposeLinkToPage($page["tag"], "", "", 0)," . . . . ",$this->Format($page["user"]),"<br />\n" ;
		}
	}
}
?>
