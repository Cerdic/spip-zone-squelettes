<?

//
// Fonctions php a utiliser dans les squelettes directement
//     (doivent etre disponibles a chaque chargement des pages)
//

//
// auteur et auteur
//
function auteur_et_auteur($tous) {
	return ereg_replace(", ([^,]*)$"," et \\1",$tous);
}

?>
