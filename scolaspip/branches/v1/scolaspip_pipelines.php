<?php

function version_scolaspip_courante($dir) {


		}


function suivi_maj_spip () {

		$ret .= "";

		//Place le contenu du fichier dans un tableau, on suppose que le fichier existe sous peine d'avoir une erreur
		$tableau = @file('http://www.tice.ac-versailles.fr/scolaspip/suivi.scolaspip');

		//Si la variable $tableau est bien un tableau, on peut continuer
		if(is_array($tableau))
		{
			$contenu_fichier = '';

			foreach($tableau AS $ligne)
				  {
				       $base_scolaspip[] .= $ligne;
				  }


			//on va chercher les paramètres locaux
			$svn_revision_spip = version_svn_courante(_DIR_RACINE) ;
			$svn_revision_scolaspip = version_svn_courante(_DIR_PLUGIN_SCOLASPIP);

			// on va chercher les références quelque part
			$base_revision_spip = $base_scolaspip[0] ;
			$base_revision_scolaspip = $base_scolaspip[1];

			
			$ret.="<div class='cadre cadre-e'><div class='cadre_padding'><ul>";

			if ($svn_revision_scolaspip<$base_revision_scolaspip) {$ret.="<li><span style=\"color:green\">Nouvelle version de <strong>SCOLASPIP</strong></span></li></ul><center><a href='http://www.tice.ac-versailles.fr/Squelette-etablissement.html' title='mettre &agrave; jour scolaspip'><img src='"._DIR_PLUGIN_SCOLASPIP."/images/majscolaspip.png' alt='mettre &agrave; jour ScolaSpip'></a></center>";} else {$ret.="<li>scolaspip &agrave; jour</li></ul>";};
			$ret.="</div></div>";
		}

	return $ret;
}

function scolaspip_droite ($flux) {
	$exec = $flux["args"]["exec"];


	if ($exec == "accueil") {
		$data = $flux["data"];

		$ret = suivi_maj_spip();

		$flux["data"] = $data.$ret;

	}
	return $flux;
}

?>
