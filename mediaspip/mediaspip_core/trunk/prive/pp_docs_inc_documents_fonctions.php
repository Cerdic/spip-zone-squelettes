<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

if(!$GLOBALS['browser_barre'])
	include_spip("inc/layer"); // défini browser_barre en cas d'ajax
include_spip('inc/documents'); // pour la fonction affiche_raccourci_doc

function pp_docs_raccourcis_doc($id_document,$titre,$descriptif,$inclus,$largeur,$hauteur,$mode,$vu){
	$raccourci = '';
	$doc = 'doc';

	if ($mode=='image')
		$doc = 'img';

	// Affichage du raccourci <doc...> correspondant
	if ($vu=='oui')
		$raccourci = affiche_raccourci_doc($doc, $id_document, '');
	else {
		$raccourci = 
			  affiche_raccourci_doc($doc, $id_document, 'left')
			. affiche_raccourci_doc($doc, $id_document, 'center')
			. affiche_raccourci_doc($doc, $id_document, 'right');
		if ($mode=='document'
			AND ($inclus == "embed" OR $inclus == "image")
			AND $largeur > 0 AND $hauteur > 0) {
			$raccourci =
			  "<span>"._T('info_inclusion_vignette')."</span>"
			. $raccourci
			. "<span>"._T('info_inclusion_directe')."</span>"
			. affiche_raccourci_doc('emb', $id_document, 'left')
			. affiche_raccourci_doc('emb', $id_document, 'center')
			. affiche_raccourci_doc('emb', $id_document, 'right');
		}
	}
	return "<div class='raccourcis'>".$raccourci."</div>";
}


?>