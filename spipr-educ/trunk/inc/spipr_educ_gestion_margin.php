<?php
// Ajout de margin pour les layout des largeurs supérieures à 1200px
function spipr_educ_gestion_margin_1200($layout) {
    $tab=array(
	'7'=>'@media (min-width: 1200px) { #aside { margin-left:-1140px; } #extra { width:210px; margin-left:-240px; } #content { margin-left:330px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'8'=>'@media (min-width: 1200px) { #extra { margin-left:-1140px; width:210px; } #aside { margin-left:-300px; } #content { margin-left:270px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'9'=>'@media (min-width: 1200px) { #extra { width:210px; margin-left:-240px; } #aside { margin-left:-540px; } #content { margin-left:30px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'10'=>'@media (min-width: 1200px) { #extra { width:210px; margin-left:-540px; } #aside { margin-left:-300px; } #content { margin-left:30px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'11'=>'@media (min-width: 1200px) { #extra { width:210px; margin-left:-840px; } #aside { margin-left:-1140px; } #content { margin-left:570px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'12'=>'@media (min-width: 1200px) { #extra { width:210px; margin-left:-1140px; } #aside { margin-left:-900px; } #content { margin-left:570px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'33'=>'@media (min-width: 1200px) { #extra { width:310px; margin-right:30px; } #aside { width:310px; margin-right:30px; } #content { margin-left:30px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'34'=>'@media (min-width: 1200px) {  #extra { width:310px; margin-left:30px; } #aside { width:310px; margin-left:30px; } #content { margin-right:30px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'35'=>'@media (min-width: 1200px) {  #extra { width:770px; margin-left:30px; } #aside { width:310px; margin-right:30px; } #content { margin-left:30px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'36'=>'@media (min-width: 1200px) { #extra { width:770px; margin-left:30px; } #aside { width:310px; margin-right:30px; } #content { margin-left:30px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:30px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'37'=>'@media (min-width: 1200px) { #extra { width:1110px; margin-right:30px; margin-left:30px; } #aside { width:310px; margin-right:30px; } #content { margin-left:30px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:20px;} .footer {padding-left:30px;padding-right:30px;} } ',
	'38'=>'@media (min-width: 1200px) { #extra { width:1110px; margin-right:30px; margin-left:30px; } #aside { width:310px; margin-left:30px; } #content { margin-left:30px; margin-right:30px; } .header .spip_logos {margin-left:30px;} .header .spip_logos {margin-left:20px;} .footer {padding-left:30px;padding-right:30px;} } ',
	);
	return $tab[$layout];
}
function spipr_educ_gestion_margin_980_1199($layout) {
    $tab=array(
	'7'=>'@media (min-width: 980px) and (max-width: 1199px) { #aside { margin-left:-920px; } #extra { width:180px; margin-left:-200px; } #content { margin-left:260px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'8'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { margin-left:-920px; width:180px; } #aside { margin-left:-240px; } #content { margin-left:220px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'9'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:180px; margin-left:-200px; } #aside { margin-left:-440px; } #content { margin-left:20px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'10'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:180px; margin-left:-440px; } #aside { margin-left:-240px; } #content { margin-left:20px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'11'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:180px; margin-left:-680px; } #aside { margin-left:-920px; } #content { margin-left:460px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'12'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:180px; margin-left:-920px; } #aside { margin-left:-720px; } #content { margin-left:460px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'33'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:250px; margin-right:20px; } #aside { width:250px; margin-right:20px; } #content { margin-left:20px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'34'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:250px; margin-left:20px; } #aside { width:250px; margin-left:20px; } #content { margin-right:20px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'35'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:620px; margin-left:20px; } #aside { width:250px; margin-right:20px; } #content { margin-left:20px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'36'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:620px; margin-right:20px; } #aside { width:250px; margin-left:20px; } #content { margin-right:20px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'37'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:900px; margin-right:20px; margin-left:20px; } #aside { width:250px; margin-right:20px; } #content { margin-left:20px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	'38'=>'@media (min-width: 980px) and (max-width: 1199px) { #extra { width:900px; margin-right:20px; margin-left:20px; } #aside { width:250px; margin-left:20px; } #content { margin-right:20px; } .header .spip_logos {margin-left:20px;} .footer {padding-left:20px;padding-right:20px;} }',
	);
	return $tab[$layout];
}
function spipr_educ_gestion_margin_768_979($layout) {
    $tab=array(
	'33'=>'@media (min-width: 768px) and (max-width: 979px) { #aside {width:208px; margin-right:10px;} #extra {width:208px; margin-right:10px;} #content {margin-left:10px;} .header .spip_logos {margin-left:10px;} .footer {padding-left:10px;padding-right:10px;} }',
	'34'=>'@media (min-width: 768px) and (max-width: 979px) { #aside {width:208px; margin-left:10px;} #extra {width:208px; margin-left:10px;} #content {margin-right:10px;} .header .spip_logos {margin-left:10px;} .footer {padding-left:10px;padding-right:10px;} }',
	'35'=>'@media (min-width: 768px) and (max-width: 979px) { #aside {width:208px; margin-right:10px;} #extra {margin-left:10px;} #content {margin-left:10px;} .header .spip_logos {margin-left:10px;} .footer {padding-left:10px;padding-right:10px;} }',
	'36'=>'@media (min-width: 768px) and (max-width: 979px) { #aside {width:208px; margin-left:10px;} #extra {margin-right:10px;} #content {margin-right:10px;} .header .spip_logos {margin-left:10px;} .footer {padding-left:10px;padding-right:10px;} }',
	'37'=>'@media (min-width: 768px) and (max-width: 979px) { #aside {width:208px; margin-right:10px;} #extra {margin-right:10px; margin-left:10px; width:704px;} #content {margin-left:10px;} .header .spip_logos {margin-left:10px;} .footer {padding-left:10px;padding-right:10px;} }',
	'38'=>'@media (min-width: 768px) and (max-width: 979px) { #aside {width:208px; margin-left:10px;} #extra {margin-right:10px; margin-left:10px; width:704px;} #content {margin-right:10px;} .header .spip_logos {margin-left:10px;} .footer {padding-left:10px;padding-right:10px;} }',
	'39'=>'@media (min-width: 768px) and (max-width: 979px) { #content {width:704px; margin-left:10px; margin-right:10px;} #aside {margin-left:10px; width:342px;} #extra {margin-right:10px; width:342px;} #footer{padding-left:10px;padding-right:10px;} .header .spip_logos {margin-left:10px;} }',
	'40'=>'@media (min-width: 768px) and (max-width: 979px) { #content {width:704px; margin-left:10px; margin-right:10px;} #aside {margin-right:10px; width:342px;} #extra {margin-left:10px; width:342px;} #footer{padding-left:10px;padding-right:10px;} .header .spip_logos {margin-left:10px;} }',
	);
	return $tab[$layout];
}
function spipr_educ_gestion_margin_451_767($layout) {
	$tab=array(
	'27'=>'@media (min-width: 451px) and (max-width: 767px) { #content {width:96%; margin-left:1.99%; margin-right:1.99%;} #extra {width:46%; margin-right:1.99%;} #aside {width:46%; margin-left:1.99%;} #footer{padding-left:1.99%; padding-right:1.99%;} .header .spip_logos {margin-left:1.99%;} }',
	'28'=>'@media (min-width: 451px) and (max-width: 767px) { #content {width:96%; margin-left:1.99%; margin-right:1.99%;} #extra {width:46%; margin-left:1.99%;} #aside {width:46%; margin-right:1.99%;} #footer{padding-left:1.99%; padding-right:1.99%;} .header .spip_logos {margin-left:1.99%;} }',
	);
	return $tab[$layout];
}
function spipr_educ_gestion_margin_450() {
	return '@media (max-width: 450px) { #content, #aside, #extra {width:94%; margin-left:1.99%; margin-right:1.99%; padding-left:0; padding-right:0;} #footer{padding-left:1.99%; padding-right:1.99%;} .header .spip_logos {margin-left:1.99%;} }';
}
function spipr_educ_gestion_margin_h1() {
	return '	
	@media (max-width: 450px) { #nom_site_spip{padding-left:1.99%;} }
	@media (min-width: 451px) and (max-width: 767px) { #nom_site_spip{padding-left:1.99%;} }
	@media (min-width: 768px) and (max-width: 979px) { #nom_site_spip{padding-left:10px;} }
	@media (min-width: 980px) and (max-width: 1199px) { #nom_site_spip{padding-left:20px;} }
	@media (min-width: 1200px) { #nom_site_spip{padding-left:30px;} }
	';
}
function spipr_educ_gestion_margin() {
	$retour='';
	// Tout d'abord en largeur >= 1200px
	$test_layout=sql_select('parametre1','spip_spipr_educ',"nom='layout_1200' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_test_layout=sql_fetch($test_layout);
	$test_layout_1200=$tab_test_layout['parametre1'];
	if (!$test_layout_1200) {$test_layout_1200=9;}
	$retour.=spipr_educ_gestion_margin_1200($test_layout_1200);
	// Ensuite entre 980px et 1199px
	$test_layout2=sql_select('parametre1','spip_spipr_educ',"nom='layout_grand' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_test_layout2=sql_fetch($test_layout2);
	$test_layout_grand=$tab_test_layout2['parametre1'];
	if (!$test_layout_grand) {$test_layout_grand=33;}
	$retour.=' '.spipr_educ_gestion_margin_980_1199($test_layout_grand);
	// Entre 768px et 979px
	$test_layout3=sql_select('parametre1','spip_spipr_educ',"nom='layout_moyen' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_test_layout3=sql_fetch($test_layout3);
	$test_layout_moyen=$tab_test_layout3['parametre1'];
	if (!$test_layout_moyen) {$test_layout_moyen=33;}
	$retour.=' '.spipr_educ_gestion_margin_768_979($test_layout_moyen);
	// Entre 451px et 767px
	$test_layout4=sql_select('parametre1','spip_spipr_educ',"nom='layout_petit' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_test_layout4=sql_fetch($test_layout4);
	$test_layout_petit=$tab_test_layout4['parametre1'];
	if (!$test_layout_petit) {$test_layout_petit=27;}
	$retour.=' '.spipr_educ_gestion_margin_451_767($test_layout_petit);
	// Enfin largeur <= 450px
	$retour.=' '.spipr_educ_gestion_margin_450();
	// Détacher le titre du site
	$retour.=' '.spipr_educ_gestion_margin_h1();
	//On retourne le tout
	return $retour;
}
?>