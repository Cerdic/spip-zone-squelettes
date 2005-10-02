<?php
//vérification de sécurité
if (!eregi("wakka.php", $_SERVER['PHP_SELF'])) {
    die ("acc&egrave;s direct interdit");
}
echo $this->Header();
?>
<div class="page">
<?php
if ($this->HasAccess("write") && $this->HasAccess("read"))
{
	if ($_POST)
	{

		// appliquer la reconnaissance auto des sauts de ligne
#		if (function_exists('post_autobr')) {
#			$_POST['body'] = post_autobr(trim($_POST['body']));
#		}

		// only if saving:
		if ($_POST["submit"] == "Sauver")
		{
			// check for overwriting
			if ($this->page)
			{
				if ($this->page["id"] != $_POST["previous"])
				{
					$error = "ALERTE : ".
					"Cette page a &eacute;t&eacute; modifi&eacute;e par quelqu'un d'autre pendant que vous l'&eacute;ditiez.<br />\n".
					"Veuillez copier vos changements et r&eacute;-&eacute;diter cette page.\n";
				}
			}


			// store
			if (!$error)
			{
				$body = str_replace("\r", "", $_POST["body"]);
				
				// test si la nouvelle page est differente de la précédente
				if(rtrim($body)==rtrim($this->page["body"])) {
					$this->SetMessage("Cette page n\'a pas &eacute;t&eacute; enregistr&eacute;e car elle n\'a subi aucune modification.");
					$this->Redirect($this->href());
				}

				// add page (revisions)
				$this->SavePage($this->tag, $body);

				// now we render it internally so we can write the updated link table.
				$this->ClearLinkTable();
				$this->StartLinkTracking();
				$dummy = $this->Header();
				$dummy .= $this->Format($body);
				$dummy .= $this->Footer();
				$this->StopLinkTracking();
				$this->WriteLinkTable();
				$this->ClearLinkTable();

				// forward
				$this->Redirect($this->href());
			}
		}
	}

	// fetch fields
	if (!$previous = $_POST["previous"]) $previous = $this->page["id"];
	if (!$body = $_POST["body"]) $body = $this->page["body"];

	// preview?
	if ($_POST["submit"] == "Aperçu")
	{
		$previewButtons =
			"<input class=\"spip_bouton\" name=\"submit\" type=\"submit\" value=\"Sauver\" accesskey=\"s\" />\n".
			"<input class=\"spip_bouton\" name=\"submit\" type=\"submit\" value=\"R&eacute;-&eacute;diter \" accesskey=\"p\" />\n".
			"<input class=\"spip_bouton\" type=\"button\" value=\"Annulation\" onClick=\"document.location='".$this->href("")."';\" />\n";
		$output .=
			$this->FormOpen("edit")."\n".
			"<input type=\"hidden\" name=\"previous\" value=\"".$previous."\" />\n".
			"<input type=\"hidden\" name=\"body\" value=\"".htmlentities($body)."\" />\n";
		
		$output .= "<div class=\"prev_alert\"><strong>Aper&ccedil;u</strong>\n";

		$output .=
			"<br />\n".
			$previewButtons.
			$this->FormClose()."</div>\n";

		$output .= $this->Format($body);

	}
	else
	{
		// display form
		if ($error)
		{
			$output .= "<div class=\"error\">$error</div>\n";
		}

		// append a comment?
		if ($_REQUEST["appendcomment"])
		{
			$body = trim($body)."\n\n----\n\n--".$this->UserName()." (".strftime("%c").")";
		}

#	// virer les sauts de ligne idiots
#	if (function_exists('post_autobr')) {
#		$body = post_autobr($body, " ");
#	}

		$output .=
			$this->FormOpen("edit").
			"<input type=\"hidden\" name=\"previous\" value=\"".$previous."\" />\n".
			"<textarea onKeyDown=\"fKeyDown()\" name=\"body\" cols=\"60\" rows=\"40\" wrap=\"soft\" class=\"edit\">\n".
			htmlspecialchars($body).
			"\n</textarea><br />\n".
			($this->config["preview_before_save"] ? "" : "<div class=\"aligndroit\">"."<input class=\"spip_bouton\" name=\"submit\" type=\"submit\" value=\"Sauver\" accesskey=\"s\" />\n").
			"<input class=\"spip_bouton\" name=\"submit\" type=\"submit\" value=\"Aper&ccedil;u\" accesskey=\"p\" />\n".
			"<input class=\"spip_bouton\" type=\"button\" value=\"Annulation\" onClick=\"document.location='".$this->href("")."';\" />\n".
			"</div>".
			$this->FormClose();
	}


	echo $output;
}
else
{
	echo "<i>Vous n'avez pas acc&egrave;s en &eacute;criture &agrave; cette page !</i>\n";
}
?>
<hr class="hr_clear" />
</div>
<?php echo $this->Footer(); ?>