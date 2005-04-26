<?php

// on fait les includes qui vont bien 
include ("ecrire/inc_version.php3");
include_ecrire('inc_texte.php3');
include ("inc-calcul-outils.php3");

//on lit le fichier à parser
$ficin.=".html";
if ($f = @fopen($ficin, 'r')) {
	//on le met dans un tableau
	$file =file($ficin);
}



echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"fr\">";
echo "<head><title>Squelette de la page $ficin.html</title></head>	";
echo "<link href=\"spip_style.css\" rel=\"stylesheet\" type=\"text/css\" />";


//on parcoure le tableau
for ($i=0;$i<count($file);$i++){
	//on récupère la ligne
	$texte= $file[$i];
	//Damned c'est une fin de commentaire ! 
	if (preg_match("/-->/",$texte)){
		$texte = preg_replace("/-->/",$texte,"");
		$code=true;
		echo ("</h2>");
		//echo "<div id='error'>";
	}
	if (preg_match("/<!--/",$texte)){
		$texte = preg_replace("/<!--/",$texte,"");
		$code=false;
		echo "<h2 class=\"spip\">";

	}
	
	if ($code)
		echo propre("<code>$texte</code><br>");
	else
		echo propre("$texte<br>");
	
}	




?>