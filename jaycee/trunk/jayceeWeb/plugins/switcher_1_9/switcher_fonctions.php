<?php
function switcher_affichage_final($texte){

	global 	$html;
	global $squelettes_alternatifs;
	global $styleListeSwitcher;

	if ($html) {
	
		if (SWITCHER_AFFICHER) {
			
			// Insertion du Javascript de rechargement de page
			$code='<script type="text/javascript">
						//<![CDATA[
						function gotof(url) {
						window.location=url;
						}//]]>
						</script>';	  
			
			// Insertion du selecteur de squelettes			
			$code.='<div id="plugin_switcher">';
			$code.='<form action="" method="post">';
			//$code.='<fieldset style="margin:0;padding:0;border:0">';
			$code.='<select name="selecteurSkel" style="'.$styleListeSwitcher.'" onchange="gotof(this.options[this.selectedIndex].value)">';
			$code.='<option selected="selected" value="">Charte graphique</option>';
			foreach( $squelettes_alternatifs as $key => $value)	$code.='<option value="'.parametre_url(self(),'var_skel',$key).'">&nbsp;-> '.$key.'</option>';
			$code.='</select>';
			//$code.='</fieldset>';
			$code.='</form>';
			$code.='</div>';
			}

			
		// On rajoute le code du selecteur de squelettes avant la balise </body>
		$anchor="<a id='switcher_anchor'></a>";
		$texte=eregi_replace($anchor,"$anchor$code",$texte);
	}
	return($texte);
}
?>
