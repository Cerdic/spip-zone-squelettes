<?php
function eva_habillage_parametres_accessibilite() {
$Table1 = 'spip_eva_habillage';
$Table2 = 'spip_eva_habillage_themes';
$Table3 = 'spip_eva_habillage_images';
//Page d'article
$def_blocs ['sommaire_dyslexie']= array('non',9,'sommaire');

//Page d'article
$def_blocs ['article_dyslexie']= array('non',9,'article');

//Page auteur
$def_blocs ['auteur_dyslexie']= array('non',9,'auteur');

//Page breve
$def_blocs ['breve_dyslexie']= array('non',9,'breve');

//Page rubrique
$def_blocs ['rubrique_dyslexie']= array('non',9,'rubrique');

//Page site
$def_blocs ['site_dyslexie']= array('non',9,'site');

foreach($def_blocs as $cle=>$val) {
$eva_noms_habillages=sql_select('nom',$Table2,'');
while ($eva_noms_tab=sql_fetch($eva_noms_habillages)) {
$eva_verif_modularite=sql_select('*',$Table3,"type='bloc' AND nom_habillage='".$eva_noms_tab['nom']."' AND nom_div='".$cle."'");
$tab=sql_fetch($eva_verif_modularite);
if (!$tab['type']) {
sql_insertq($Table3,array(
'type'=>'bloc',
'nom_habillage'=>$eva_noms_tab['nom'],
'nom_div'=>$cle,
'nom_image'=>$val[0],
'pos_x'=>$val[1],
'attach'=>$val[2]));
}
elseif (!$tab['attach']) {
sql_updateq($Table3,array('pos_x'=>$val[1],'attach'=>$val[2]),"id=".$tab['id']);
}
}
}
}
?>