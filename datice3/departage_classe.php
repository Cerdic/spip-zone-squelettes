<?php
require("connexion.inc.php");
include("fonctions.inc.php");
require("auth.inc.php");

$siID =$_SESSION['siID'];
$user_id=$siID;
$id_classe=$_POST['id_classe'];


$id_consigne=mysql_query("select id_consigne from session_consigne  where user_id='$user_id'");
$id_cons=mysql_fetch_array($id_consigne);
$id_c=$id_cons[0];




mysql_query("delete from classe_consigne where id_consigne=$id_cons[0] and id_classe=$id_classe ") or die (mysql_error());



?>