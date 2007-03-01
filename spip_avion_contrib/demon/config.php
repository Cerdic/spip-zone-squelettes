<?php
	//fichier de configuration
	global $host,$username,$password,$db,$table,$dir,$logfile,$delestage,$delnumber,$effacer_fichier;
	
	//Base de données
	$host="localhost"; 	//Hôte de la base de données
	$username="root"; 	//Nom d'utilisateur de la base de données
	$password=""; 		//Mot de passe de la base de données
	$db="spip_avion"; 	//Nom de la base de données
	$table="spip_avion_data"; //Nom de la table
	
	//Système de fichiers
	$dir="data/"; 		//Répertoire des fichiers texte
	$logfile="log.txt"; 	//Nom du fichier log où sont enregistrés les erreurs MySQL
	
	//Delestage
	$delestage="1";		//Activation du délestage des entrées trop vieilles
	$delnumber="1000";	//Nombre de lignes à garder après un délestage
	//
	$effacer_fichier="0";  //Efface le fichier après l'utilisation (p.ex. si vous avez des fichiers en continu)
?>
