<?php 
include_spip('inc/config');
function formulaires_melusine_nuage_charger($id_noisette){
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
  
  return $valeurs;
}

function formulaires_melusine_nuage_verifier(){
	$erreurs = array();
	// verifier que les champs obligatoires sont bien la :
	//foreach(array('pos1','pos2','pos3','pos4','pos5') as $obligatoire)
	//	if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	// verifier que si un email a été saisi, il est bien valide :
	//include_spip('inc/filtres');
	//if (_request('email') AND !email_valide(_request('email')))
	//	$erreurs['email'] = 'Cet email n\'est pas valide';

	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}





function formulaires_melusine_nuage_traiter(){
	include_spip('action/editer_objet');
	$id_noisette=_request('id_noisette');

	// effacer_config(melusine_nuage);
	$params=array();
	$params['couleur']=_request('couleur');	
	$mots=_request('mot');
	foreach($mots as $key=>$mot){
		if(isset($mot['titre'])){
			
			$params['mots'][$key]=$mot;
		}
	}

	$articles=_request('article');
	foreach($articles as $key=>$article){
		if(isset($article['titre'])){
			$params['articles'][$key]=$article;
		}
	}
	
	// $chemin_couleur="melusine_nuage/couleur";
	// ecrire_config($chemin_couleur,$couleur);
	// $mots=_request('mot',$tableau);
	// $texte="<tags>\n";
	// if($mots){
	// 	foreach ($mots as $value){
	// 		$tab_mot=explode(" ",$value['titre']);
	// 		$titre=str_replace($tab_mot[0],"",$value['titre']);
	// 		$pattern="/^( [0-9])\. /";
	// 		$titre=preg_replace($pattern,"",$titre);
	// 		$chemin_id="melusine_nuage/mot/".$tab_mot[0]."/id";
	// 		$chemin_tit="melusine_nuage/mot/".$tab_mot[0]."/titre";
	// 		$chemin_taille="melusine_nuage/mot/".$tab_mot[0]."/taille";
	// 		if ($titre){
	// 			ecrire_config($chemin_id,$tab_mot[0]);
	// 			ecrire_config($chemin_tit,$titre);
	// 			ecrire_config($chemin_taille,$value['taille']);
	// 			$couleur_mot=str_replace("#","0x",$couleur);
	// 			$texte.="<a href='spip.php?page=mot&id_mot=".$tab_mot[0]."'  rel='tag' style='font-size:".$value['taille']."px;' color='".$couleur_mot."' >".$titre."</a>\n";
	// 		}
		
	// 	};
	// };
	// $articles=_request('article',$tableau2);
	// if($articles){
	// 	foreach ($articles as $value){
	// 		$tab_article=explode(" ",$value['titre']);
	// 		$titre=str_replace($tab_article[0],"",$value['titre']);
	// 		$pattern="/^( [0-9])\. /";
	// 		$titre=preg_replace($pattern,"",$titre);
	// 		$chemin_id="melusine_nuage/article/".$tab_article[0]."/id";
	// 		$chemin_tit="melusine_nuage/article/".$tab_article[0]."/titre";
	// 		$chemin_taille="melusine_nuage/article/".$tab_article[0]."/taille";
	// 		if ($titre){
	// 			ecrire_config($chemin_id,$tab_article[0]);
	// 			ecrire_config($chemin_tit,$titre);
	// 			ecrire_config($chemin_taille,$value['taille']);
	// 			$couleur_article=str_replace("#","0x",$couleur);
	// 			$texte.="<a href='spip.php?page=article&id_article=".$tab_article[0]."'  rel='tag' style='font-size:".$value['taille']."px;' color='".$couleur_article."' >".$titre."</a>\n";
	// 		}
	// 	};
	// };
	$set=array('parametres'=>serialize($params));
	objet_modifier("noisette", $id_noisette, $set);
	
	return array('message_ok'=>'enregistré', 'id_noisette'=>$id);
	
}



?>