<?php
require("connexion.inc.php");
include("fonctions.inc.php");
include("fonctions_balado.php");
require("auth.inc.php");
extract($_POST);
$siID =$_SESSION['siID'];
$res=mysql_query("select id_consigne from uploads  where id_upload='$id_upload'") or die (mysql_error());
$r=mysql_fetch_array($res);
$id_consigne=$r[id_consigne];
mysql_query("delete from uploads  where id_upload ='$id_upload'") or die (mysql_error());
echo liste_uploads($id_consigne,$modif=true);
?>