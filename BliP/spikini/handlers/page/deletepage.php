<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}
echo $this->Header();
?>
<div class="page">
<?php

if ($this->UserIsOwner())
{
	if ($pages = $this->IsOrphanedPage($this->GetPageTag()))
	{
		foreach ($pages as $page)
		{
			$this->DeleteOrphanedPage($this->GetPageTag());
		}
	}
	else
	{
		echo"<i>Cette page n'est pas orpheline.</i>";
	}

}
else
{
	echo"<i>Vous n'&ecirc;tes pas le propri&eacute;taire de cette page.</i>";
}

?>
</div>
<?php echo $this->Footer(); ?>