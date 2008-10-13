<?php
/******************************************************************
***  Ce plugin EVA_habillage, créé par Olivier Gautier, est mis ***
***      à disposition sous un contrat Creative Commons BY      *** 
***                 consultable à l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function balise_EVAMENUDEPLIANT($p) {
	$flux = '<script type="text/javascript" src="'._DIR_PLUGIN_EVA_HABILLAGE.'javascript/menu_depliant.js"></script>
<style type="text/css">
#Sommaire {
	border:1px solid #ccc;
	-moz-border-radius: 12px;	
	background-color:#F4F4F4;
	}
#Sommaire, #Sommaire li, #Sommaire li ul {
	margin: 0;
	padding : 0;	
	list-style : none;	
}
#Sommaire * {
	font-size : 14px;
	text-decoration : none;
}
#Sommaire li {
	list-style-position: inside;
	margin-left:22px;	
	vertical-align : top;
}
#Sommaire li a {
	height : 10px;			
}		
#Sommaire .noeud {
	list-style-image:url('._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/deplierbas.gif);			
}
#Sommaire .plier {
	list-style-image:url('._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/deplierhaut.gif);
}
#Sommaire .plier > ul {
	display : none;
}
#Sommaire .pliermsie {
	display : none;
}	
#Sommaire a.noeud {
	margin-left : -12px;
	width : 10px;
	height : 10px;
	text-decoration: none ;
	background-image:url('._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/invisible.gif);
}			
#Sommaire .feuille {			
	list-style-type : square;
	color : black;
}	
#Sommaire .on {
	color : red;
}
/* suivi du fil actif */	
#Sommaire .noeud.on,#Sommaire .feuille.on{
	list-style-image:url('._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/puceon.gif);				
}
/* suivi du fil actif */	
#Sommaire ul.on{
	display : block;				
}		
ul#Sommaire a {
display:inline;}
</style>';

$p->code = "'".$flux."'";
$p->interdire_scripts = false;
return $p;
}

?>