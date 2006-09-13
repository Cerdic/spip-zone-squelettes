<?php

// filtre replace pour faire des operations avec expression reguliere 
// [(#TEXTE|replace{^ceci$,cela,Uims})] 
// http://doc.spip.org/@replace 
function replace($texte, $expression, $replace='', $modif="UimsS") { 
	$expression=str_replace("\/","/",$expression); 
	$expression=str_replace("/","\/",$expression); 
	return preg_replace("/$expression/$modif",$replace,$texte); 
}

?>