<?php
# Permet de faire une redirection vers une autre pages Wiki du site
# 
# Parametres : page : nom wiki de la page vers laquelle ont doit rediriger (obligatoire)
# 
# exemple : {{redirect page="BacASable"}}
#
# copyrigth Eric Feldstein 2003 mailto:garfield_fr@tiscali.fr
#
# Licence GPL, vous etes libre d'utiliser et de modifier ce code a condition de
# laisser le copyright d'origine. Vous pouvez  bien sur vous ajouter a la liste
# des auteurs.
#
# Installation : copier le fichier dans le repertoire "actions" de WikiNi

//recuperation du parametres
$redirPageName = $this->GetParameter("page");

if (empty($redirPageName)){
	echo $this->Format("//Le param&ecirc;tre \"page\" est manquant.//");
}else{
	if (eregi("^".$redirPageName."$",$this->GetPageTag())){
		echo $this->Format("//Impossible &agrave; une page de se rediriger vers elle m&ecirc;me.//");
	}else{
		$fromPages = array();
		$fromPages = explode(":",$_COOKIE['redirectfrom']);
		if (in_array($this->GetPageTag(),$fromPages)){
			echo $this->Format("//Redirection circulaire.//");
		}else{
			$fromPages[] = $this->GetPageTag();
			SetCookie('redirectfrom', implode(":",$fromPages), time() + 30, "/"); 
			$this->Redirect("wakka.php?wiki=$redirPageName");
		}
	}
}

?>
