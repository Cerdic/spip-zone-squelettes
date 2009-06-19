<?php
// On declare ici les onglets et boutons a afficher dans le porte-plume sous forme de tableaux

//Chaque onglet est declare sous forme d'un tableau contenant le nom de l'id, le nom du bouton, le texte correspondant, et enfin le tableau des sous-boutons
function iconespedago_onglets() {
$retour=array(
array('iconespedago_onglet_consignes','bouton_plusieurs.gif',_T(iconespedago:condignes),iconespedago_onglet_consignes()),
);

return $retour;}

//Boutons de l'onglet consignes
function iconespedago_onglet_consignes() {
$retour=array(
array('iconespedago_dire',':dire',_T(iconespedago:dire),'bouton_dire.gif'),
array('iconespedago_lire',':lire',_T(iconespedago:lire),'bouton_lire.gif'),
array('iconespedago_ecrire',':ecrire',_T(iconespedago:ecrire),'bouton_ecrire.gif'),
array('iconespedago_seul',':seul',_T(iconespedago:seul),'bouton_seul.gif'),
array('iconespedago_plusieurs',':plusieurs',_T(iconespedago:plusieurs),'bouton_plusieurs.gif'),
);

return $retour;}
?>