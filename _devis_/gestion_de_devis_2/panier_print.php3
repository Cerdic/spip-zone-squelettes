<?php
function generer_key(){
// g�n�ration du mot de passe 
    $chaine = "0123456789"; //caract�res possibles 
    srand((double)microtime()*1000000); 
    for($i=0; $i<8; $i++) 
	{    
		//mot de passe de 8 caract�res 
        $pass .= $chaine[rand()%strlen($chaine)];  
	}
	return $pass;  
}
session_start();
		// On cr�e un tableau ne contenant que les ids des articles s�lectionn�s
		$array_articles = array_keys($_SESSION['devis']);
		//On convertit le tableau en chaine, les �l�ments �tant s�par�s par un trait |
		$str = implode('|', $array_articles);
		// on r�cup�re le dernier caracterre de la chaine, et s'il s'agit d'unt trait et bien on le retire 
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
