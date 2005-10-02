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
	if ($_POST)
	{
		// store lists
		$this->SaveAcl($this->GetPageTag(), "read", $_POST["read_acl"]);
		$this->SaveAcl($this->GetPageTag(), "write", $_POST["write_acl"]);
		$message = "Droits d\'acc&egrave;s mis &agrave; jour ";//$message = "Access control lists updated";
		
		// change owner?
		if ($newowner = $_POST["newowner"])
		{
			$this->SetPageOwner($this->GetPageTag(), $newowner);
			$message .= " et changement du propri&eacute;taire. Nouveau propri&eacute;taire : ".$newowner;//$message .= " and gave ownership to ".$newowner;
		}

		// redirect back to page
		$this->SetMessage($message."!");
		$this->Redirect($this->Href());
	}
	else
	{
		// load acls
		$readACL = $this->LoadAcl($this->GetPageTag(), "read");
		$writeACL = $this->LoadAcl($this->GetPageTag(), "write");

		// show form
		?>
		<p>Liste des droits d'acc&eacute;s de la page  <?php echo  $this->ComposeLinkToPage($this->GetPageTag()) ?></p><!-- Access Control Lists for-->
		<br />
		
		<?php echo  $this->FormOpen("acls") ?>
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" style="padding-right: 20px">
					<b>Droits de lecture :</b><br /><!-- Read ACL:-->
					<textarea name="read_acl" rows="4" cols="20"><?php echo  $readACL["list"] ?></textarea>
				<td>
				<td valign="top" style="padding-right: 20px">
					<b>Droits d'&eacute;criture :</b><br /><!-- Write ACL:-->
					<textarea name="write_acl" rows="4" cols="20"><?php echo  $writeACL["list"] ?></textarea>
				<td>
			</tr>
			<tr>
				<td colspan="3">
					<b>Changer le propri&eacute;taire :</b><br /><!-- Set Owner:-->
					<select name="newowner">
						<option value="">Ne rien modifier</option><!-- Don't change-->
						<option value=""></option>
						<?php
						if ($users = $this->LoadUsers())
						{
							foreach($users as $user)
							{
								echo "<option value=\"",htmlentities($user["name"]),"\">",$user["name"],"</option>\n";
							}
						}
						?>
					</select>
				<td>
			</tr>
			<tr>
				<td colspan="3">
					<br />
					<div class="aligndroit">
					<input type="submit" value="Enregistrer" class="spip_bouton" accesskey="s"><!-- Store ACLs-->
					<input type="button" value="Annuler" onClick="history.back();" class="spip_bouton"><!-- Cancel -->
					</div>
				</td>
			</tr>
		</table>
		<?php
		echo$this->FormClose();
	}
}
else
{
	echo"<i>Vous n'&ecirc;tes pas le propri&eacute;taire de cette page.</i>";
	//echo"<i>You're not the owner of this page.</i>";
}

?>
</div>
<?php echo $this->Footer(); ?>
