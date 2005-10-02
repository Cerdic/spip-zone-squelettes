<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}

header("Content-type: text/xml");

if ($HasAccessRead=$this->HasAccess("read"))
{
// TODO : Return an empty xml ?
// TODO : Return an error read (noaccess) xml ?
	if ($this->page)
	{
		// display page
		echo $this->Format($this->page["body"], "action") ;
	}
}
?>