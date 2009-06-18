<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EVA_ICONESPEDAGO',(_DIR_PLUGINS.end($p)));

function iconespedago_pre_typo($chaine) {
	$chemin = '<img alt="icones_peda" src="'._DIR_PLUGIN_EVA_ICONESPEDAGO.'/img_pack/';

//consignes de travail

	    $chaine = preg_replace('/:dire+/m', $chemin . "dire.gif\" />", $chaine);
	    $chaine = preg_replace('/:ecrire+/m', $chemin . "ecrire.gif\" />", $chaine);
	    $chaine = preg_replace('/:lire+/m', $chemin . "lire.gif\" />", $chaine);
	    //$chaine = preg_replace('/:ecouter+/m', $chemin . "ecouter.gif\" />", $chaine);
	    
//mode de travail

		$chaine = preg_replace('/:seul+/m', $chemin . "seul.gif\" />", $chaine);
	    $chaine = preg_replace('/:plusieurs+/m', $chemin . "plusieurs.gif\" />", $chaine);
	    
// materiel


	    $chaine = preg_replace('/:ciseaux+/m', $chemin . "ciseaux.gif\" />", $chaine);
	    $chaine = preg_replace('/:colle+/m', $chemin . "colle.gif\" /", $chaine);
	    $chaine = preg_replace('/:compas+/m', $chemin . "compas.gif\" />", $chaine);
	    $chaine = preg_replace('/:equerre+/m', $chemin . "equerre.gif\" />", $chaine);
	    $chaine = preg_replace('/:regle+/m', $chemin . "regle.gif\" />", $chaine);
	    $chaine = preg_replace('/:gomme+/m', $chemin . "gomme.gif\" />", $chaine);
	    $chaine = preg_replace('/:crayon+/m', $chemin . "crayon.gif\" />", $chaine);
	    $chaine = preg_replace('/:rapporteur+/m', $chemin . "rapporteur.gif\" />", $chaine);
	    $chaine = preg_replace('/:pinceau+/m', $chemin . "pinceau.gif\" />", $chaine);
	    $chaine = preg_replace('/:sport+/m', $chemin . "sport.gif\" />", $chaine);
	    $chaine = preg_replace('/:cahier+/m', $chemin . "cahier.gif\" />", $chaine);
	    $chaine = preg_replace('/:classeur+/m', $chemin . "classeur.gif\" />", $chaine);
	    $chaine = preg_replace('/:livre+/m', $chemin . "livre.gif\" />", $chaine);
	    
//Supports d'ecriture

	    $chaine = preg_replace('/:q5mm+/m', $chemin . "quadrillage5mm.gif\" />", $chaine);
	    $chaine = preg_replace('/:q1cm+/m', $chemin . "quadrillage1cm.gif\" />", $chaine);
	    $chaine = preg_replace('/:carreaux1cm+/m', $chemin . "carreaux1cm.png\" />", $chaine);
	    $chaine = preg_replace('/:trou+/m', $chemin . "trou.png\" />", $chaine);
	    $chaine = preg_replace('/:rond+/m', $chemin . "rond.png\" />", $chaine);
	  	$chaine = preg_replace('/:ligne+/m', $chemin . "ligne.png\" />", $chaine);
		$chaine = preg_replace('/:frise+/m', $chemin . "frise.gif\" />", $chaine);

 // Conscience phonologique


		//$chaine = preg_replace('/:calcul+/m', $chemin . "calcul.gif\" />", $chaine);
		$chaine = preg_replace('/:oeil+/m', $chemin . "oeil.png\" />", $chaine);
		$chaine = preg_replace('/:oreille+/m', $chemin . "oreille.png\" />", $chaine);
		$chaine = preg_replace('/:noeil+/m', $chemin . "noeil.png\" />", $chaine);
		$chaine = preg_replace('/:noreille+/m', $chemin . "noreille.png\" />", $chaine);

//Numeration

		//dominos

	    $chaine = preg_replace('/:dominovide+/m', $chemin . "dominovide.png\" />", $chaine);
	    $chaine = preg_replace('/:domino0+/m', $chemin . "domino0.png\" />", $chaine);
	    $chaine = preg_replace('/:domino1+/m', $chemin . "domino1.png\" />", $chaine);
	    $chaine = preg_replace('/:domino2+/m', $chemin . "domino2.png\" />", $chaine);
	    $chaine = preg_replace('/:domino3+/m', $chemin . "domino3.png\" />", $chaine);
	    $chaine = preg_replace('/:domino4+/m', $chemin . "domino4.png\" />", $chaine);
	    $chaine = preg_replace('/:domino5+/m', $chemin . "domino5.png\" />", $chaine);
	    $chaine = preg_replace('/:domino6+/m', $chemin . "domino6.png\" />", $chaine);
	    $chaine = preg_replace('/:domino7+/m', $chemin . "domino7.png\" />", $chaine);
	    $chaine = preg_replace('/:domino8+/m', $chemin . "domino8.png\" />", $chaine);
	    $chaine = preg_replace('/:domino9+/m', $chemin . "domino9.png\" />", $chaine);
	    $chaine = preg_replace('/:dominoX+/m', $chemin . "dominoX.png\" />", $chaine);
	
		//doigts
		
	    $chaine = preg_replace('/:un-g+/m', $chemin . "un-g.png\" />", $chaine);
	    $chaine = preg_replace('/:deux-g+/m', $chemin . "deux-g.png\" />", $chaine);
	    $chaine = preg_replace('/:trois-g+/m', $chemin . "trois-g.png\" />", $chaine);
	    $chaine = preg_replace('/:quatre-g+/m', $chemin . "quatre-g.png\" />", $chaine);
	    $chaine = preg_replace('/:cinq-g+/m', $chemin . "cinq-g.png\" />", $chaine);
	    $chaine = preg_replace('/:un-d+/m', $chemin . "un-d.png\" />", $chaine);
	    $chaine = preg_replace('/:deux-d+/m', $chemin . "deux-d.png\" />", $chaine);
	    $chaine = preg_replace('/:trois-d+/m', $chemin . "trois-d.png\" />", $chaine);
	    $chaine = preg_replace('/:quatre-d+/m', $chemin . "quatre-d.png\" />", $chaine);
	    $chaine = preg_replace('/:cinq-d+/m', $chemin . "cinq-d.png\" />", $chaine);
	    
//Binettes
	$chaine = preg_replace('/:->+/m', $chemin.'diable.png" />',$chaine);
	$chaine = preg_replace('/:-\(\(+/m', $chemin.'en_colere.png" />', $chaine);
	$chaine = preg_replace('/:-\)\)+/m', $chemin."mort_de_rire.png\" />", $chaine);
	$chaine = preg_replace('/:-D+/m', $chemin."mort_de_rire.png\" />", $chaine);
	$chaine = preg_replace('/:-\)+/m', $chemin."sourire.png\" />", $chaine);
	$chaine = preg_replace('/;-\)+/m', $chemin."clin_d-oeil.png\" />", $chaine);
	$chaine = preg_replace("/:'-\)+/m", $chemin."pleure_de_rire.png\" />", $chaine);
	$chaine = preg_replace("/:'-D+/m", $chemin."pleure_de_rire.png\" />", $chaine);
	$chaine = preg_replace('/:o\)+/m', $chemin."rigolo.png\" />", $chaine);
	$chaine = preg_replace('/B-\)+/m', $chemin."lunettes.png\" />", $chaine);
	$chaine = preg_replace('/\s:-p/m', $chemin."tire_la_langue.png\" />", $chaine);
	$chaine = preg_replace('/:-\|+/m', $chemin."bof.png\" />", $chaine);
	$chaine = preg_replace('/:-\/+/m', $chemin."mouai.png\" />", $chaine);
	$chaine = preg_replace('/:-o+/m', $chemin."surpris.png\" />", $chaine);
	$chaine = preg_replace('/:-O+/m', $chemin."surpris.png\" />", $chaine);
	$chaine = preg_replace('/:-\(+/m', $chemin."pas_content.png\" />", $chaine);
	$chaine = preg_replace("/:'-\(+/m", $chemin."triste.png\" />", $chaine);

return $chaine;
}

?>