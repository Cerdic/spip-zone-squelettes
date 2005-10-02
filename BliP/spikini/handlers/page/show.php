<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}
echo $this->Header();
?>
<div class="page">
<?php
if ($HasAccessRead=$this->HasAccess("read"))
{
	if (!$this->page)
	{
		echo "Cette page n'existe pas encore, voulez vous la <a href=\"".$this->href("edit")."\">cr&eacute;er</a> ?" ;
	}
	else
	{
		// comment header?
		if ($this->page["comment_on"])
		{
			echo "<div class=\"commentinfo\">Ceci est un commentaire sur ",$this->ComposeLinkToPage($this->page["comment_on"], "", "", 0),", post&eacute; par ",$this->Format($this->page["user"])," &agrave; ",$this->page["time"],"</div>";
		}

		if ($this->page["latest"] == "N")
		{
			echo "<div class=\"revisioninfo\">Ceci est une version archiv&eacute;e de <a href=\"",$this->href(),"\">",$this->GetPageTag(),"</a> &agrave; ",$this->page["time"],".</div>";
		}


		// display page
		echo $this->Format($this->page["body"], "spip");

		// if this is an old revision, display some buttons
		if (($this->page["latest"] == "N") && $this->HasAccess("write"))
		{
			$latest = $this->LoadPage($this->tag);
			?>
			<br />
			<?php echo  $this->FormOpen("edit") ?>
			<input type="hidden" name="previous" value="<?php echo  $latest["id"] ?>">
			<input type="hidden" name="body" value="<?php echo  htmlentities($this->page["body"]) ?>">
			<input type="submit" value="R&eacute;-&eacute;diter cette version archiv&eacute;e">
			<?php echo  $this->FormClose(); ?>
			<?php
		}
	}
}
else
{
	echo "<i>Vous n'&ecirc;tes pas autoris&eacute; &agrave; lire cette page</i>" ;
}
?>
<hr class="hr_clear" />
</div>


<?php
if ($HasAccessRead)
{
	// load comments for this page
	$comments = $this->LoadComments($this->tag);
	
	// store comments display in session
	$tag = $this->GetPageTag();
	if (!isset($_SESSION["show_comments"][$tag]))
		$_SESSION["show_comments"][$tag] = ($this->UserWantsComments() ? "1" : "0");
	if (isset($_REQUEST["show_comments"])){	
	switch($_REQUEST["show_comments"])
	{
	case "0":
		$_SESSION["show_comments"][$tag] = 0;
		break;
	case "1":
		$_SESSION["show_comments"][$tag] = 1;
		break;
	}
	}
	// display comments!
	if ($this->page && $_SESSION["show_comments"][$tag])
	{
		// display comments header
		?>
		<div class="commentsheader">
			Commentaires [<a href="<?php echo  $this->href("", "", "show_comments=0") ?>">Cacher commentaires/formulaire</a>]
		</div>
		<?php
		
		// display comments themselves
		if ($comments)
		{
			foreach ($comments as $comment)
			{
				echo "<a name=\"",$comment["tag"],"\"></a>\n" ;
				echo "<div class=\"comment\">\n" ;
				echo $this->Format($comment["body"]),"\n" ;
				echo "<div class=\"commentinfo\">\n-- ",$this->Format($comment["user"])," (".$comment["time"],")\n</div>\n" ;
				echo "</div>\n" ;
			}
		}
		
		// display comment form
		echo "<div class=\"commentform\">\n" ;
		if ($this->HasAccess("comment"))
		{
			?>
				Ajouter un commentaire &agrave; cette page:<br />
				<?php echo  $this->FormOpen("addcomment"); ?>
					<textarea name="body" rows="6" style="width: 100%"></textarea><br />
					<input type="submit" value="Ajouter Commentaire" accesskey="s">
				<?php echo  $this->FormClose(); ?>
			<?php
		}
		echo "</div>\n" ;
	}
	else
	{
/*		?>
		<div class="commentsheader">
		<?php
			switch (count($comments))
			{
			case 0:
				echo "Il n'y a pas de commentaire sur cette page." ;
				break;
			case 1:
				echo "Il y a un commentaire sur cette page." ;
				break;
			default:
				echo "Il y a ",count($comments)," commentaires sur cette page." ;
			}
		?>
		
		[<a href="<?php echo  $this->href("", "", "show_comments=1") ?>">Afficher commentaires/formulaire</a>]

		</div>
		<?php
*/
	}
}
echo $this->Footer();
?>