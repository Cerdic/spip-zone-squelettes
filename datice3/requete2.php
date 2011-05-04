<?php
echo "Connexion au serveur xx<br>";
/* 1ère étape : essai de connexion à un serveur ldap
 * le paramètre doit être l'adresse IP du serveur LDAP, ici localhost
 */
$ds=ldap_connect("ldap.ac-creteil.fr");
// on teste : le serveur LDAP est-il trouvé ?
if ($ds)
 echo "Le résultat de connexion est ".$ds;
else
 die("connexion impossible au serveur LDAP");

/* 2ème étape : on effectue une liaison au serveur, ici de type "anonymous"
 * pour une recherche permise par un accès en lecture seule
 */
echo "Liaison ..x";
$r=ldap_bind($ds);
// en cas de succès de la liaison, renvoie $r=1
if ($r)
  echo "Le résultat de connexion est $r";
else
  die("liaison impossible au serveur ldap ...");

/* 3ème étape : on effectue une recherche anonyme, avec le dn de base,
 * par exemple, sur tous les noms commençant par T
 */
echo "Recherche suivant le filtre (sn=le magoariec)";
$dn="ou=personnels EN,ou=ac-creteil,ou=education,o=gouv,c=fr";
$filtre = "(&(sn='LE MAGOARIEC')(fonctm=ENS))";
//$filtre = "fonctm=DEC";
//$filtre = "sn=federini";
$sr=ldap_search($ds, $dn, $filtre);
echo "Le résultat de la recherche est $sr";


echo "Le nombre d'entrées retournées est ".ldap_count_entries($ds,$sr)."<p>";
echo "Lecture de ces entrées ....<p>";
$info = ldap_get_entries($ds, $sr);
echo "Données pour ".$info["count"]." entrées:<p>";

for ($i=0; $i < $info["count"]; $i++) {
        echo "dn est : ". $info[$i]["dn"] ."<br>";
        echo "premiere entree cn : ". $info[$i]["cn"][0] ."<br>";
        echo "premier email : ". $info[$i]["mail"][0] ."<br>";
        echo "rne : ". $info[$i]["rne"][0] ."<br>";
        echo "discipline : ". $info[$i]["discipline"][0] ."<br>";
	echo "RNE : ". $info[$i]["RNE"][0] ."<br>";
	 echo "fonction : ". $info[$i]["fonctm"][0] ."<p><hr>";
}
/* 4ème étape : cloture de la session
 */
echo "Fermeture de la connexion";
ldap_close($ds);
?>


