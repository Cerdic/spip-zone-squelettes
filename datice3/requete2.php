<?php
echo "Connexion au serveur xx<br>";
/* 1�re �tape : essai de connexion � un serveur ldap
 * le param�tre doit �tre l'adresse IP du serveur LDAP, ici localhost
 */
$ds=ldap_connect("ldap.ac-creteil.fr");
// on teste : le serveur LDAP est-il trouv� ?
if ($ds)
 echo "Le r�sultat de connexion est ".$ds;
else
 die("connexion impossible au serveur LDAP");

/* 2�me �tape : on effectue une liaison au serveur, ici de type "anonymous"
 * pour une recherche permise par un acc�s en lecture seule
 */
echo "Liaison ..x";
$r=ldap_bind($ds);
// en cas de succ�s de la liaison, renvoie $r=1
if ($r)
  echo "Le r�sultat de connexion est $r";
else
  die("liaison impossible au serveur ldap ...");

/* 3�me �tape : on effectue une recherche anonyme, avec le dn de base,
 * par exemple, sur tous les noms commen�ant par T
 */
echo "Recherche suivant le filtre (sn=le magoariec)";
$dn="ou=personnels EN,ou=ac-creteil,ou=education,o=gouv,c=fr";
$filtre = "(&(sn='LE MAGOARIEC')(fonctm=ENS))";
//$filtre = "fonctm=DEC";
//$filtre = "sn=federini";
$sr=ldap_search($ds, $dn, $filtre);
echo "Le r�sultat de la recherche est $sr";


echo "Le nombre d'entr�es retourn�es est ".ldap_count_entries($ds,$sr)."<p>";
echo "Lecture de ces entr�es ....<p>";
$info = ldap_get_entries($ds, $sr);
echo "Donn�es pour ".$info["count"]." entr�es:<p>";

for ($i=0; $i < $info["count"]; $i++) {
        echo "dn est : ". $info[$i]["dn"] ."<br>";
        echo "premiere entree cn : ". $info[$i]["cn"][0] ."<br>";
        echo "premier email : ". $info[$i]["mail"][0] ."<br>";
        echo "rne : ". $info[$i]["rne"][0] ."<br>";
        echo "discipline : ". $info[$i]["discipline"][0] ."<br>";
	echo "RNE : ". $info[$i]["RNE"][0] ."<br>";
	 echo "fonction : ". $info[$i]["fonctm"][0] ."<p><hr>";
}
/* 4�me �tape : cloture de la session
 */
echo "Fermeture de la connexion";
ldap_close($ds);
?>


