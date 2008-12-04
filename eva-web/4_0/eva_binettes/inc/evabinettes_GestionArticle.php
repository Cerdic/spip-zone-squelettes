<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EVABINETTES',(_DIR_PLUGINS.end($p)));

function evabinettes_blocdroite_article() {
$retour = '';

	$chemin=_DIR_PLUGIN_EVABINETTES."binettes/";
	$binettes_tab=array(
		":->" => "diable.png",
		":-((" => "en_colere.png",
		":-))" => "mort_de_rire.png",
		":-)" => "sourire.png",
		";-)" => "clin_d-oeil.png",
		":\'-)" => "pleure_de_rire.png",
		":o)" => "rigolo.png",
		"B-)" => "lunettes.png",
		":-p" => "tire_la_langue.png",
		":-|" => "bof.png",
		":-/" => "mouai.png",
		":-o" => "surpris.png",
		":-O" => "surpris.png",
		":-(" => "pas_content.png",
		":\'-(" => "triste.png"		
	);
	$retour = '';
	$retour .= debut_cadre_relief($chemin."mort_de_rire.png", true, '', "<center><div style='text-decoration:underline;'>Plugin Eva Binettes</div> Ajout d'ic&ocirc;nes dans vos articles</center>");
	$retour .= "<center>Cliquez sur l'image afin de l'ins&eacute;rer dans votre article !</center><br /><hr /><center><table align='center'><tr align='center'>";
	$indent=0;
        foreach ($binettes_tab as $cle => $valeur) {
	if ($indent==5) {$retour .= "<tr align='center'>";}
	$retour .= '<td align="center"><a href="javascript:barre_inserer(\' '.$cle.' \',document.getElementById(\'text_area\'))" tabindex="1000" title="Ins&eacute;rer '.$cle.'"><img src="'.$chemin.$valeur.'"></a></td>';
	$indent++;
	if ($indent==5) {$retour .="</tr>"; $indent=0;}
	}
	$retour .= "</tr></table></center>";
	$retour .= fin_cadre_relief(true);
return $retour;
}
?>