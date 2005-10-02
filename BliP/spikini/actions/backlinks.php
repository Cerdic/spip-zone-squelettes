<?php

	/*
	Action "backlinks".
	Développé par Patrick PAUL.
 	Licence GPL.
	*/


	if ($this->GetParameter("page"))
	{
		$page = $this->GetParameter("page");
		$title = "Pages ayant un lien vers ".$this->ComposeLinkToPage($page)."&nbsp;: <br />\n";
	}
	else
	{
		$page = $this->getPageTag();
		$title = "Pages ayant un lien vers la page courante&nbsp;: <br />\n";
	}

	$pages = $this->LoadPagesLinkingTo($page);

	if ($pages)
	{
		echo $title;
		if (!$exclude = $this->GetParameter("exclude"))
		{
			foreach ($pages as $page)
			{
				echo $this->ComposeLinkToPage($page["tag"]), "<br />\n";
			}
		}
		else
		{
			foreach ($pages as $page)
			{
				// Show link if it isn't an excluded link
				if (!preg_match("/".$page["tag"]."(;|$)/", $exclude)) echo $this->ComposeLinkToPage($page["tag"]), "<br />\n";
			}
		}
	}
	else
	{
		echo "<i>Aucune page n'a de lien vers ", $this->ComposeLinkToPage($page), ".</i>";
	}
?>