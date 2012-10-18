<?php 
function articles_pasvide($colonne){
	foreach($colonne as $value){
		if($value!=''and $value!='aucun'){return true;};
	}
	return false;
}

function formulaires_articles_charger(){
	$valeurs = array('d1'=>'menu','d2'=>'boutonsgauche','d3'=>'miseajour','d4'=>'mentionslegales','d5'=>'diaporama');
	
	return $valeurs;
}

function formulaires_articles_verifier(){
	$erreurs = array();
	// verifier que les champs obligatoires sont bien la :
	//foreach(array('pos1','pos2','pos3','pos4','pos5') as $obligatoire)
	//	if (_request($style)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	// verifier que si un email a �t� saisi, il est bien valide :
	//include_spip('inc/filtres');
	//if (_request('email') AND !email_valide(_request('email')))
	//	$erreurs['email'] = 'Cet email n\'est pas valide';

	$style=_request('style');
	$gauche=lire_config("datice_squelettes/g");
	
	$droite=lire_config("datice_squelettes/d");
	if($style=="layout2.css" and pasvide($droite) ){$erreurs['style'] ="La colonne droite  doit �tre vide"	;};
	if($style=="layout3.css" and pasvide($gauche) ){$erreurs['style'] ="La colonne gauche doit �tre vide"	;};
	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}

function articles_skels(){
	effacer_config("datice_article/skel");
	$squel=array();
	$chemin=_DIR_PLUGIN_DATICE;
	$chemin=$chemin."modules/articles";
	$i=1;
	if ($handle = opendir($chemin)) {    		
    		while (false !== ($file = readdir($handle))) {
		$sk=substr($file,0,-5);
		if($sk!='' && strlen($sk)>3){
			$cheminskels="datice_article/skel/skels".$i;
        		ecrire_config($cheminskels,$sk);
			$i++;
			}
		
		
    		}
		
	};
	
}


function articles_rassembler($i){
	$var=$i;
	$chemin='datice_article/effectifs/'.$var;
	$j=$i+1;
	$varplus=$j;
	$chemin_bas='datice_article/effectifs/'.$varplus;
	$pos_bas=lire_config($chemin_bas);
	ecrire_config($chemin,$pos_bas);
	ecrire_config($chemin_bas,'aucun');
	$i++;
	if($i<12){articles_rassembler($i);};
}


function formulaires_articles_traiter(){
	$position=_request('position');
	if($position=='skels'){articles_skels();return false;}
	$action=substr($position,0,1);
	$var=substr($position,1);
	
	if($action=="d" && $var<11 ){
		$varplus=$var+1;
		$chemin='datice_article/effectifs/'.$var;
		$chemin_bas='datice_article/effectifs/'.$varplus;
		$pos=lire_config($chemin);
		$pos_bas=lire_config($chemin_bas);
		ecrire_config($chemin_bas, $pos);
		ecrire_config($chemin,$pos_bas);			
	}
	if($action=="m" && $var>1 ){
		$varmoins=$var-1;
		$chemin='datice_article/effectifs/'.$var;
		$chemin_haut='datice_article/effectifs/'.$varmoins;
		$pos=lire_config($chemin);
		$pos_haut=lire_config($chemin_haut);
		ecrire_config($chemin_haut, $pos);
		ecrire_config($chemin,$pos_haut);			
	}
	if($action=="s"){
		$chemin='datice_article/effectifs/'.$var;
		ecrire_config($chemin,'aucun');	
		articles_rassembler($var,$zone);
	}
	if($action=="a"){
		$j=1;
		while($valeur!='aucun'){
		$chemin='datice_article/effectifs/'.$j;
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
			$chemin='datice_article/effectifs/'.$i;					
			ecrire_config($chemin,$skelg[$j]);
		}			
	}
	
	return array('message_ok'=>'enregistr�');
}



?>