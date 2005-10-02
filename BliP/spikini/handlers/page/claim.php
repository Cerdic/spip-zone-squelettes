<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}
echo $this->Header();

// only claim ownership if this page has no owner, and if user is logged in.
if ($this->page && !$this->GetPageOwner() && $this->GetUser())
{
	$this->SetPageOwner($this->GetPageTag(), $this->GetUserName());
	$this->SetMessage("Vous &ecirc;tes maintenant le propri&eacute;taire de cette page");
}

$this->Redirect($this->href());

echo $this->Footer();
?>