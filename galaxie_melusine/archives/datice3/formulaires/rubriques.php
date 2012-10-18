<?php 
function rubriques_pasvide($colonne){
	foreach($colonne as $value){
		if($value!=''and $value!='aucun'){return true;};
	}
	return false;
}

function formulaires_rubriques_charger(){
	$valeurs = array('d1'=>'menu','d2'=>'boutonsgauche','d3'=>'miseajour','d4'=>'mentionslegales','d5'=>'diaporama');
	
	return $valeurs;
}

function formulaires_rubriques_verifier(){
	$erreurs = array();
	// verifier que les champs obligatoires sont bien la :
	//foreach(array('pos1','pos2','pos3','pos4','pos5') as $obligatoire)
	//	if (_request($style)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	// verifier que si un email a été saisi, il est bien valide :
	//include_spip('inc/filtres');
	//if (_request('email') AND !email_valide(_request('email')))
	//	$erreurs['email'] = 'Cet email n\'est pas valide';

	$style=_request('style');
	$gauche=lire_config("datice_squelettes/g");
	
	$droite=lire_config("datice_squelettes/d");
	if($style=="layout2.css" and pasvide($droite) ){$erreurs['style'] ="La colonne droite  doit être vide"	;};
	if($style=="layout3.css" and pasvide($gauche) ){$erreurs['style'] ="La colonne gauche doit être vide"	;};
	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}

function rubriques_skels(){
	effacer_config("datice_rubrique/skel");
	$squel=array();
	$chemin=_DIR_PLUGIN_DATICE;
	$chemin=$chemin."modules/rubriques";
	$i=1;
	if ($handle = opendir($chemin)) {    		
    		while (false !== ($file = readdir($handle))) {
		$sk=substr($file,0,-5);
		if($sk!='' && strlen($sk)>3){
			$cheminskels="datice_rubrique/skel/skels".$i;
        		ecrire_config($cheminskels,$sk);
			$i++;
			}
		
		
    		}
		
	};
	
}


function rubriques_rassembler($i){
	$var=$i;
	$chemin='datice_rubrique/effectifs/'.$var;
	$j=$i+1;
	$varplus=$j;
	$chemin_bas='datice_rubrique/effectifs/'.$varplus;
	$pos_bas=lire_config($chemin_bas);
	ecrire_config($chemin,$pos_bas);
	ecrire_config($chemin_bas,'aucun');
	$i++;
	if($i<12){rubriques_rassembler($i);};
}


function formulaires_rubriques_traiter(){
	$position=_request('position');
	if($position=='skels'){rubriques_skels();return false;}
	$action=substr($position,0,1);
	$var=substr($position,1);
	
	if($action=="d" && $var<11 ){
		$varplus=$var+1;
		$chemin='datice_rubrique/effectifs/'.$var;
		$chemin_bas='datice_rubrique/effectifs/'.$varplus;
		$pos=lire_config($chemin);
		$pos_bas=lire_config($chemin_bas);
		ecrire_config($chemin_bas, $pos);
		ecrire_config($chemin,$pos_bas);			
	}
	if($action=="m" && $var>1 ){
		$varmoins=$var-1;
		$chemin='datice_rubrique/effectifs/'.$var;
		$chemin_haut='datice_rubrique/effectifs/'.$varmoins;
		$pos=lire_config($chemin);
		$pos_haut=lire_config($chemin_haut);
		ecrire_config($chemin_haut, $pos);
		ecrire_config($chemin,$pos_haut);			
	}
	if($action=="s"){
		$chemin='datice_rubrique/effectifs/'.$var;
		ecrire_config($chemin,'aucun');	
		rubriques_rassembler($var,$zone);
	}
	if($action=="a"){
		$j=1;
		while($valeur!='aucun'){
		$chemin='datice_rubrique/effectifs/'.$j;
		$valeur=lire_config($chemin);
		$j++;}
		if($j<11){
		ecrire_config($chemin,$var);
		}
			
	}
	if($action=="i"){
		$skelg=array('aucun','bip');
		
		for ($i=1;$i<3;$i++){
			$j=$i-1;
			$chemin='datice_rubrique/effectifs/'.$i;					
			ecrire_config($chemin,$skelg[$j]);
		}			
	}
	
	return array('message_ok'=>'enregistré');
}



?>