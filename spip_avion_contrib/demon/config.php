<?php
	//fichier de configuration
	global $host,$username,$password,$db,$table,$dir,$logfile,$delestage,$delnumber,$effacer_fichier;
	
	//Base de donn�es
	$host="localhost"; 	//H�te de la base de donn�es
	$username="root"; 	//Nom d'utilisateur de la base de donn�es
	$password=""; 		//Mot de passe de la base de donn�es
	$db="spip_avion"; 	//Nom de la base de donn�es
	$table="spip_avion_data"; //Nom de la table
	
	//Syst�me de fichiers
	$dir="data/"; 		//R�pertoire des fichiers texte
	$logfile="log.txt"; 	//Nom du fichier log o� sont enregistr�s les erreurs MySQL
	
	//Delestage
	$delestage="1";		//Activation du d�lestage des entr�es trop vieilles
	$delnumber="1000";	//Nombre de lignes � garder apr�s un d�lestage
	//
	$effacer_fichier="0";  //Efface le fichier apr�s l'utilisation (p.ex. si vous avez des fichiers en continu)
?>
