<?php

# Permet d'inclure une page Wiki dans un autre page
# 
# Param�tres :
# -- page : nom wiki de la page a inclure (obligatoire)
# -- class : nom de la classe de style � inclure (facultatif)
# 
# copyrigth Eric Feldstein 2003 mailto:garfield_fr@tiscali.fr
# (am�lior� par Charles N�pote malito:charles02@nepote.org)
#
# Licence GPL, vous �tes libre d'utiliser et de modifier ce code � condition de
# laisser le copyright d'origine. Vous pouvez  bien sur vous ajouter � la liste
# des auteurs.

# Installation : copier le fichier dans le repertoire "actions" de WikiNi
#

// r�cuperation du parametres
$incPageName = $this->GetParameter("page");
// TODO : am�liorer le traitement des classes
if ($this->GetParameter("class")) {
	$array_classes = explode(" ", $this->GetParameter("class"));
	foreach ($array_classes as $c) { $classes = $classes . "include_" . $c . " "; }
	}

// Affichage de la page ou d'un message d'erreur
if (empty($incPageName)) {
	echo $this->Format("//Le param�tre \"page\" est manquant.//");
} else {
	if (eregi("^".$incPageName."$",$this->GetPageTag())) {
		echo $this->Format("//Impossible � une page de s'inclure dans elle m�me.//");
	} else {
		if (!$this->HasAccess("read",$incPageName)){
			echo $this->Format("//Lecture de la page inclue $page non autoris�e.//");
		} else {
			$incPage = $this->LoadPage($incPageName);
			$output = $this->Format($incPage["body"]);
			if ($classes) echo "<div class=\"", $classes,"\">\n", $output, "</div>\n";
			else echo $output;
		}
	}
}

?>