<?php
	// Inclusion du fichier de configuration
	include_once('config.php');
	
	// Fonction qui envoie les erreurs dans un fichier texte et qui, par la suite arrêtera la boucle
	function log_errors($error){
		global $host,$username,$password,$db,$table,$dir,$logfile,$delestage,$delnumber;
		$file=fopen($logfile,"a+");
		fputs($file,$error);
		fclose($file);
		return $error;
	}
	
	//Fonction principale du script
	function text_to_db() {
		global $host,$username,$password,$db,$table,$dir,$logfile,$delestage,$delnumber,$effacer_fichier;
		
		//Connexion à la bdd
		mysql_connect($host, $username,$password) or die(log_errors(mysql_error())) ;
		mysql_select_db($db) or die(log_errors(mysql_error()));	
		
		//Prend le premier fichier dans l'ordre alphabétique
		$dh  = opendir($dir);
		while (false !== ($filename = readdir($dh))) {
			$files[] = $filename;
		}
		
		 if (!isset($files[3])){ sleep(1);return null;}
		
		sort($files);
		//Mise des lignes du fichier dans un tableau
		$lines = file ("$dir/$files[2]");
		if (!$lines)
			die ("Impossible de lire le fichier");
		
		foreach ($lines as $key => $value) {	
		
			// séparation les valeurs	
			$tmp=explode(";", $value);
			foreach($tmp as $key2 => $value2){
				$_GLOBAL['array'] [$key][$key2]=trim($value2,";");
			}
		}
		
		// insertion dans la base de donnée
		
		foreach($_GLOBAL['array'] as $value)	{
		
			foreach($value as $value2)
				$value2=stripslashes($value2);
			
			$query="INSERT into $table
			(date,x,y,altitude,roulis,tangage,lacet,vx,vz,temps)
			values (now(),'$value[0]','$value[1]','$value[2]','$value[3]', '$value[4]', '$value[5]','$value[6]','$value[7]','$value[8]')";
			mysql_query($query) or die(log_errors(mysql_error())) ;
			
			sleep(1);
		}
		if ($delestage=="1")
		{
			//compte le nombre d'entrées dans la table "$table"
			$result=mysql_query("select count(*) from $table")or die(log_errors(mysql_error())) ;
			$arr=mysql_fetch_array($result);
			$num=$arr['count(*)']-$delnumber;
			if (count > 0)
			{
				//efface toutes les entrées sauf les x dernières
				mysql_query("delete from $table order by id asc LIMIT $num;") or die(log_errors(mysql_error())) ;
			}
		}
		if ($effacer_fichier=="1")
			unlink("$dir/$files[2]");
		return (null);
	}

?>
