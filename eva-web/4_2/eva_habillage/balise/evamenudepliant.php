<?php
function balise_EVAMENUDEPLIANT($p) {
	$flux = '<script type="text/javascript" src="'._DIR_PLUGIN_EVA_HABILLAGE.'javascript/menu_depliant.js"></script>
	<style type="text/css">
	#sommaire {
		border:1px solid #ccc;
		-moz-border-radius: 12px;	
		background-color:#F4F4F4;
	}
	#sommaire, #sommaire li, #sommaire li ul {
		margin: 0;
		padding : 0;	
		list-style : none;	
	}
	#sommaire * {
		font-size : 14px;
		text-decoration : none;
	}
	#sommaire li {
		list-style-position: inside;
		margin-left:22px;	
		vertical-align : top;
	}
	#sommaire li a {
		height : 10px;			
	}		
	#sommaire .noeud {
		list-style-image:url('._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/deplierbas.gif);			
	}
	#sommaire .plier {
		list-style-image:url('._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/deplierhaut.gif);
	}
	#sommaire .plier > ul {
		display : none;
	}
	#sommaire .pliermsie {
		display : none;
	}	
	#sommaire a.noeud {
		margin-left : -12px;
		width : 10px;
		height : 10px;
		text-decoration: none ;
		background-image:url('._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/invisible.gif);
	}			
	#sommaire .feuille {			
		list-style-type : square;
		color : black;
	}
	#sommaire .on {
		color : red;
	}
	/* suivi du fil actif */	
	#sommaire .noeud.on,#sommaire .feuille.on{
		list-style-image:url('._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/puceon.gif);				
	}
	/* suivi du fil actif */	
	#sommaire ul.on{
		display : block;				
	}		
	ul#sommaire a {
		display:inline;}
	</style>';

	$p->code = "'".$flux."'";
	$p->interdire_scripts = false;
	return $p;
}
?>