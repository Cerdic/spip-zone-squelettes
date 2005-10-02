<?php

# Permet d'inclure une page Wiki dans un autre page
# 
# Paramètres :
# -- page : nom wiki de la page a inclure (obligatoire)
# -- class : nom de la classe de style à inclure (facultatif)
# 
# copyrigth Eric Feldstein 2003 mailto:garfield_fr@tiscali.fr
# (amélioré par Charles Népote malito:charles02@nepote.org)
#
# Licence GPL, vous êtes libre d'utiliser et de modifier ce code à condition de
# laisser le copyright d'origine. Vous pouvez  bien sur vous ajouter à la liste
# des auteurs.

# Installation : copier le fichier dans le repertoire "actions" de WikiNi
#

// récuperation du parametres
$incPageName = $this->GetParameter("page");
// TODO : améliorer le traitement des classes
if ($this->GetParameter("class")) {
	$array_classes = explode(" ", $this->GetParameter("class"));
	foreach ($array_classes as $c) { $classes = $classes . "include_" . $c . " "; }
	}

// Affichage de la page ou d'un message d'erreur
if (empty($incPageName)) {
	echo $this->Format("//Le paramètre \"page\" est manquant.//");
} else {
	if (eregi("^".$incPageName."$",$this->GetPageTag())) {
		echo $this->Format("//Impossible à une page de s'inclure dans elle même.//");
	} else {
		if (!$this->HasAccess("read",$incPageName)){
			echo $this->Format("//Lecture de la page inclue $page non autorisée.//");
		} else {
			$incPage = $this->LoadPage($incPageName);
			$output = $this->Format($incPage["body"]);
			if ($classes) echo "<div class=\"", $classes,"\">\n", $output, "</div>\n";
			else echo $output;
		}
	}
}

?>