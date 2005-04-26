<?php
$fond = "benNbArticlesProp";
$delais = 3600*24;




include ("inc-public.php3");
include("ecrire/inc_connect.php3");
	$sql= "SELECT count(*) as cnt FROM spip_articles where statut='prop'";
		$result = spip_query($sql);
		while ($row = spip_fetch_array($result)) {
			echo $row['cnt'];
		}

?>
