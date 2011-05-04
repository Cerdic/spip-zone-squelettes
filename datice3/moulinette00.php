<?php
require("connexion.inc.php");
require("fonctions.inc.php");





$ctice94=array();
$handle = @fopen("ctice94.csv", "r");
if ($handle) {
	$i=0;
    while (($buffer = fgets($handle, 4096)) !== false) {
        //echo $buffer."<br>";
		
		$ligne=explode(",",$buffer);
		$nom3=explode(" ",$ligne[1]);
		$nom=$nom3[2];
		if($nom3[3]!="") $nom.="-".$nom3[3];
		$ctice94[$i][rne]=str_ireplace('"','',$ligne[0]);
		$ctice94[$i][nom]=str_ireplace('"','',$nom);
		$ctice94[$i][nom]=str_ireplace("'",'-',$ctice94[$i][nom]);
		$ctice94[$i][verif]=$ligne[1];
		$i++;
    }
    if (!feof($handle)) {
        echo "Erreur: fgets() a échoué\n";
		
    }
    fclose($handle);
}

foreach($ctice94 as $etab){
	$rne=$etab[rne];
	$nom=$etab[nom];
	echo $etab[rne].":".$etab[nom].": ".$etab[verif]."=>";
	

$ds=ldap_connect("ldap.ac-creteil.fr");
$r=ldap_bind($ds);
$dn="ou=personnels EN,ou=ac-creteil,ou=education,o=gouv,c=fr";
//$filtre = "(&(sn=Gourdin)(fonctm=ENS))";
//$filtre = "(&(sn=$nom)(rne=$rne))";
$filtre = "(&(sn=$nom)(rne=$rne))";
//$filtre = "sn=federini";
$sr=ldap_search($ds, $dn, $filtre);

$info = ldap_get_entries($ds, $sr);


for ($i=0; $i < $info["count"]; $i++) {
       // echo "dn est : ". $info[$i]["dn"] ."<br>";
        //echo "premiere entree cn : ". $info[$i]["cn"][0] ."<br>";
        //echo  $info[$i]["mail"][0] ;
        //echo "rne : ". $info[$i]["rne"][0] ."<br>";
        //echo "discipline : ". $info[$i]["discipline"][0] ."<br>";
	//echo "RNE : ". $info[$i]["RNE"][0] ."<br>";
	 //echo "fonction : ". $info[$i]["fonctm"][0] ."<p><hr>";
$req="insert into $table (uid, nom, prenom, mail, date,role,rne,discipline,civilite) values ($info[$i]['uid'][0],'$info[$i][givenname][0]', '$info[$i][cn][0]', '$info[$i][mail][0]', now(),'2','$info[$i][rne][0]','$info[$i][discipline][0]','$info[$i][civilite][0]')";
echo $req."<br>";
//mysql_query($req);
}
/* 4ème étape : cloture de la session
 */
echo "<br>";
ldap_close($ds);

}
?>



	
	
	

}
?>
