<?php
/*
* Configuration de Noizetier pour SoyezCreateurs
* Realisation : RealET : real3t@gmail.com
*/

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('base/soyezcreateurs');

/*
	Fonction pour changer les mots liés à un article :
	- changer un mot pour un autre
	- inverser 2 mots
*/
function sc_mig_mot($mot_source, $gp_source, $mot_dest, $gp_dest, $inverser = false) {
	$id_mot_source = id_mot($mot_source,id_groupe($gp_source));
	$id_mot_dest = id_mot($mot_dest,id_groupe($gp_dest));
	// Trouver les articles attachés à EDITO et ZoomSur
	$Articles_Source = sql_allfetsel('id_objet', "spip_mots_liens", "id_mot=$id_mot_source AND objet='article'");
	if ($inverser) {
		$Articles_Dest = sql_allfetsel('id_objet', "spip_mots_liens", "id_mot=$id_mot_dest AND objet='article'");
	}
	if ($Articles_Source) {
		foreach ($Articles_Source as $Article_Source) {
			create_lien_mot($id_mot_dest, $Article_Source['id_objet'], 'article');
			delete_lien_mot($id_mot_source, $Article_Source['id_objet'], 'article');
		}
	}
	if ($inverser) {
		if ($Articles_Dest) {
			foreach ($Articles_Dest as $Article_Dest) {
				create_lien_mot($id_mot_source, $Article_Dest['id_objet'], 'article');
				delete_lien_mot($id_mot_dest, $Article_Dest['id_objet'], 'article');
			}
		}
	}
}