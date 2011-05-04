<?php
$table="etab_user";
$self="inscriptionTICE.php";
require("connexion.inc.php");
extract($_POST);

function connexion_ldap($a,$login,$mdp){
$ds=ldap_connect("ldapr2.ac-creteil.fr");
$dn="uid=$login,ou=personnels EN,ou=ac-creteil,ou=education,o=gouv,c=fr";
// liaison authentifiée
if ($a)
  $r=ldap_bind($ds, $dn, $mdp);
else 
  $r=ldap_bind($ds);
if ( ! $r) die("Accès impossible au serveur ldap ... contactez l'administrateur ..");
else return $ds;
}

function recherche_ldap($ds,$f){
$ou="ou=ac-creteil,ou=education,o=gouv,c=fr";
$r=ldap_search($ds, $ou, $f);
$inf = ldap_get_entries($ds, $r);
return $inf;
}
function deconnexion_ldap($ds,$inf){
ldap_close($ds);
unset($inf);
}
function recherche_uid_mysql($table,$uid){
if ($uid !="") $req="select uid from $table where uid='$uid' ";
$res=mysql_query($req);
$n=mysql_num_rows($res);
return $n;
}
function recherche_rne_mysql($table,$rne){
$gests=array();
$req="select uid,nom,prenom,role from $table where rne='$rne' ";
echo "<p>$req</p>";
$res=mysql_query($req);
$n=mysql_num_rows($res);
if ($n>0)
 for ($i=0;$i<$n;$i++) {
   $gest=mysql_fetch_array($res);
   $gests[]=$gest;
}
return $gests;
}

function verif_ins_mysql($table,$rne,$uid) {
// retourne true si l'uid n'a pas été trouvé dans la table pour le rne
$req="select * from $table where uid='$uid' ";
$res=mysql_query($req);
$n=mysql_num_rows($res);
return ($n==0);
} 

// fin déclaration de fonctions
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Enquête TICE</title>
</head>

<body>
<h3><em>Enquête référents TICE & gestionnaires réseaux</em></h3>

<?php
if (! isset($v1) and ! isset($v2)  and ! isset($v3)) {
echo "<h4>Authentification</h4>";

echo "<form method='post' action=$self >
<label> Identifiant </label>
<input type='text' name='login' value=''><br>
<label>Mot de passe </label>	
<input type='password' name='mdp' value=''><br>
<input type='submit' name='v1' value='Valider'>
</form>";
}

elseif  (isset($v1)) {
// liaison authentifiée par ayant-droit, trouver le RNE
$ds=connexion_ldap(1,$login,$mdp);
$inf = recherche_ldap($ds,"uid=$login");
$rne=$inf[0]["rne"][0];
deconnexion_ldap($ds,$inf);

// d'abord trouver les inscrits actuels de l'étab dans la table des réf.
$gests=recherche_rne_mysql($table,$rne);
$n=sizeof($gests);
if ($n==0) 
  echo "<p>Aucun gestionnaire déclaré pour l'établissement $rne</p>";
else {
  echo "<p>Gestionnaires déjà déclarés pour l'établissement $rne</p>";
  for ($i=0;$i<$n;$i++) {
	echo $gests[$i]['prenom']." ".$gests[$i]['nom']." / uid : ".$gests[$i]['uid']." rôle : ".$gests[$i]['role']."
 Modifier | Supprimer <br>"; 
  }
}

// saisie du nom du référent TICE
echo "<h4>Saisir le nom du référent TICE et/ou gestionnaire réseau, à ajouter pour RNE=$rne</h4>";
echo "<form method='post' action=$self >
<label> Nom du référent TICE </label>
<input type='text' name='nom' value=$nom><br>
<input type='hidden' name='rne' value=$rne>
<input type='submit' name='v2' value='Valider'>
</form> ";
}

elseif (isset($v2)) {
// choix du référent parmi une liste éventuelle et de son rôle

$nom=$_POST[nom];
$rne=$_POST[rne];
$f2="(&(rne=$rne)(sn=$nom))";
$ds=connexion_ldap(0);
$inf = recherche_ldap($ds,$f2);

echo "<form method='post' action=$self >
<label>Sélectionner dans la liste </label>
<select name='uid'>";
for ($i=0; $i < $inf["count"]; $i++) {
  echo "<option value=".$inf[$i]["uid"][0].">".$inf[$i]["cn"][0]."</option>";
}
echo "</select><br>
Rôle <select name='role'>
<option value=1>Référent TICE</option>
<option value=2>Gestionnaire réseau</option>
<option value=3>Référent & gestionnaire</option>
</select><br>
<input type='hidden' name='rne' value=$rne>
<input type='submit' name='v3' value='Valider'>
</form>";
deconnexion_ldap($ds,$inf);
}

elseif (isset($v3)) {
// requete ldap sur ce référent et enregistrement dans la base mysql
//echo "Enregistrement dans la base ...";

$uid=$_POST['uid'];
$rne=$_POST['rne'];
$role=$_POST['role'];

if (verif_ins_mysql($table,$rne,$uid)) {

$f3="(&(rne=$rne)(uid=$uid))";
$ds=connexion_ldap(0);
$inf = recherche_ldap($ds,$f3);
$nom=addslashes($inf[0]["sn"][0]);
$prenom=addslashes($inf[0]["givenname"][0]);
$mail=addslashes($inf[0]["mail"][0]);
$civilite=$inf[0]["codecivilite"][0];
$discipline=addslashes($inf[0]["discim"][0]);
deconnexion_ldap($ds,$inf);

$req="insert into $table (uid, nom, prenom, mail, date,role,rne,discipline,civilite) values ('$uid','$nom', '$prenom', '$mail', now(),'$role','$rne','$discipline','$civilite')";
//echo $req;
mysql_query($req);
if (mysql_affected_rows()==1)
	echo "<p>Le gestionnaire ... a bien été enregistré </p>";
else 
	echo "<p>L'enregistrement n'a pas réussi ... </p>";
// envoi de msg 
}
else {
	echo "<p>Ce gestionnaire a déjà été enregistré <br>
	Modifier sa fiche ?<br>
	Retour à la saisie ?</p>";
 }
}
?>

</body>
