<?php 

function pasvide_som($colonne){
	foreach($colonne as $value){
		if($value!=''and $value!='aucun'){return true;};
	}
	return false;
}

function formulaires_sommaire_charger(){
	$valeurs = array('d1'=>'menu','d2'=>'boutonsgauche','d3'=>'miseajour','d4'=>'mentionslegales','d5'=>'diaporama');
	
	return $valeurs;
}

function formulaires_sommaire_verifier(){
	$erreurs = array();
	// verifier que les champs obligatoires sont bien la :
	//foreach(array('pos1','pos2','pos3','pos4','pos5') as $obligatoire)
	//	if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	// verifier que si un email a été saisi, il est bien valide :
	//include_spip('inc/filtres');
	//if (_request('email') AND !email_valide(_request('email')))
	//	$erreurs['email'] = 'Cet email n\'est pas valide';

	$choixsom=_request('choixsom');
	$gauche=lire_config("datice_sommaire/x");
	$droite=lire_config("datice_sommaire/y");
	if($choixsom=="1" and pasvide_som($droite) ){$erreurs['choixsom'] ="<span style='color:red'>La colonne droite  doit &ecirc;tre vide</span>"	;};

	
	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}

function rassembler_sommaire($i,$zone){
	$var=$i;
	$chemin='datice_sommaire/'.$zone.'/'.$var;
	$j=$i+1;
	$varplus=$j;
	$chemin_bas='datice_sommaire/'.$zone.'/'.$varplus;
	$pos_bas=lire_config($chemin_bas);
	ecrire_config($chemin,$pos_bas);
	ecrire_config($chemin_bas,'aucun');
	$i++;
	if($i<12){rassembler_sommaire($i,$zone);};
}


function formulaires_sommaire_traiter(){
	$choixsom=_request('choixsom');
	ecrire_config("datice_sommaire/choixsom",$choixsom);
	$position=_request('position');
	$action=substr($position,0,1);
	$zone=substr($position,1,1);
	$var=substr($position,2);

	if($action=="d" && $var<11 ){
		$varplus=$var+1;
		$chemin='datice_sommaire/'.$zone.'/'.$var;
		$chemin_bas='datice_sommaire/'.$zone.'/'.$varplus;
		$pos=lire_config($chemin);
		$pos_bas=lire_config($chemin_bas);
		ecrire_config($chemin_bas, $pos);
		ecrire_config($chemin,$pos_bas);				
	}
	if($action=="m" && $var>1 ){
		$varmoins=$var-1;
		$chemin='datice_sommaire/'.$zone.'/'.$var;
		$chemin_haut='datice_sommaire/'.$zone.'/'.$varmoins;
		$pos=lire_config($chemin);
		$pos_haut=lire_config($chemin_haut);
		ecrire_config($chemin_haut, $pos);
		ecrire_config($chemin,$pos_haut);		
	}
	if($action=="s"){
		$chemin='datice_sommaire/'.$zone.'/'.$var;
		ecrire_config($chemin,'aucun');	
		rassembler_sommaire($var,$zone);
	}
	if($action=="a"){
		$j=1;
		while($valeur!='aucun'){
		$chemin='datice_sommaire/'.$zone.'/'.$j;
		$valeur=lire_config($chemin);
		$j++;}
		if($j<11){
		ecrire_config($chemin,$var);
		}
			
	}
	if($action=="i"){
		$skelg=array('edito','article_plus_lus');
		$skeld=array('focus','derniers_articles');
		for ($i=1;$i<6;$i++){
			$j=$i-1;
			$chemin='datice_sommaire/'.$zone.'/'.$i;
			//effacer_config($chemin);
			if($zone=="g"){$skel=$skelg;}
			else{$skel=$skeld;};
			ecrire_config($chemin,$skel[$j]);
		}			
	}
	
	return array('message_ok'=>'enregistré');
}



?>