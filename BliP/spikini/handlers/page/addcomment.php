<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}
echo $this->Header();

if ($this->HasAccess("comment"))
{
	// find number
	if ($latestComment = $this->LoadSingle("select tag, id from ".$this->config["table_prefix"]."pages where comment_on != '' order by id desc limit 1"))
	{
		preg_match("/^Comment([0-9]+)$/", $latestComment["tag"], $matches);
		$num = $matches[1] + 1;
	}
	else
	{
		$num = "1";
	}

	$body = trim($_POST["body"]);
	if (!$body)
	{
		$this->SetMessage("Commentaire vide  -- pas de sauvegarde !");
	}
	else
	{
		// store new comment
		$this->SavePage("Comment".$num, $body, $this->tag);
	}

	
	// redirect to page
	$this->redirect($this->href());
}
else
{
	echo"<div class=\"page\"><i>Vous n'&ecirc;tes pas autoris&eacute; &agrave; commenter cette page.</i></div>\n";
}
echo $this->Footer();

?>