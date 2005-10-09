<?php
// $title =  $contexte_inclus['titre'];
// $sqlstr = "UPDATE spip_articles SET date = '". date("Y-m") ."-01 00:00:00', titre='" . $title . "' WHERE id_article = '" . $id_article . "'";
include 'ecrire/inc_connect.php3';
$sqlstr  = 'SELECT spip_articles.date FROM spip_articles  WHERE id_article = "' . $id_article . '";';
$result = mysql_query($sqlstr) or die("Query 1 - MySQL problem in setdate.php3: " . mysql_error() . " (" . mysql_errno() . ")");
$row = mysql_fetch_array($result);
$mydate = strtotime($row['date']);

if (date('Y-m', time()) > date('Y-m', $mydate)) {
	$sqlstr = "UPDATE spip_articles SET date = '". date("Y-m") ."-01 00:00:00' WHERE id_article = '" . $id_article . "'";
	$res = mysql_query($sqlstr) or die("Query 2 - MySQL problem in setdate.php3: " . mysql_error() . " (" . mysql_errno() . ")");
}
?>