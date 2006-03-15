<?php
function generer_key(){
// génération du mot de passe 
    $chaine = "0123456789"; //caractères possibles 
    srand((double)microtime()*1000000); 
    for($i=0; $i<8; $i++) 
	{    
		//mot de passe de 8 caractères 
        $pass .= $chaine[rand()%strlen($chaine)];  
	}
	return $pass;  
}
session_start();
		// On crée un tableau ne contenant que les ids des articles sélectionnés
		$array_articles = array_keys($_SESSION['devis']);
		//On convertit le tableau en chaine, les éléments étant séparés par un trait |
		$str = implode('|', $array_articles);
		// on récupère le dernier caracterre de la chaine, et s'il s'agit d'unt trait et bien on le retire 
		// sinon cela fait planter SPIP qui cherche un truc vide
		$last = $str{strlen($str)-1};
		if ($last=='|'){
			$str = substr($str, 0,-1);
		}
		//return '^('.implode('|',$tableau).')$'; 
		$_GET['mes_ids'] ='^('. $str.')$';
//-------------------------------------
// PROPRE A SPIP
//-------------------------------------
$fond = "panier_print";
$delais = 24 * 3600;
include ("inc-public.php3");
?>
