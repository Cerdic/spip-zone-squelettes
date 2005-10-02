<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}

if ($this->HasAccess("read"))
{
	if (!$this->page)
	{
		return;
	}
	else
	{
		header("Content-type: text/plain");
		// display raw page
		echo $this->page["body"];
	}
}
else
{
	return;
}
?>