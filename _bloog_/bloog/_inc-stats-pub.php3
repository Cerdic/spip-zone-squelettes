<?php

// definir la période d'analyse

$periode = 105 ;


        /* Sur tout le site, nombre de visites pendant la période

	$query = "SELECT SUM(visites) AS total_absolu FROM spip_visites";
	$result = spip_query($query);

	if ($row = spip_fetch_array($result)) {
		$total_absolu = $row['total_absolu'];
	}  */
	

	$query="SELECT UNIX_TIMESTAMP(date) AS date_unix, SUM(visites) AS total_absolu FROM spip_visites ".
		"WHERE 1 AND date > DATE_SUB(NOW(),INTERVAL $periode DAY) ORDER BY date";
	$result=spip_query($query);
        while ($row = spip_fetch_array($result)) {
		echo $row['date_unix']." -> ".$row['total_absolu']."<br>";
	}
	 // Sur tout le site, nombre de visiteurs uniques pendant la journee
	// $query = "SELECT COUNT(DISTINCT ip) AS total_visites FROM spip_visites_temp";
	
		$query = "SELECT COUNT(DISTINCT ip) AS visites FROM spip_visites_temp";
		$result = spip_query($query);

	if ($row = @spip_fetch_array($result))
		$visites_today = $row['visites'];
	else
		$visites_today = 0;
        
        $total_absolu = $total_absolu + $visites_today;

		$query="SELECT UNIX_TIMESTAMP(date) AS date_unix FROM spip_visites ".
		"WHERE 1 ORDER BY date LIMIT 0,1";
	$result = spip_query($query);
	while ($row = spip_fetch_array($result)) {
		$date_premier = $row['date_unix'];
	}

         // Nombre moyen de visites par jour
	
        $moyenne =  round($total_absolu / ((date("U")-$date_premier)/(3600*24)));
	
	


	
         $query="SELECT visites FROM spip_visites ORDER BY date DESC LIMIT 1";
         $result = spip_query($query);
         if ($row = @spip_fetch_array($result))
         $visites_veille = $row['visites'];
         else
         $visites_veille = 0;
 
 echo " total : $total_absolu <br> $moyenne visites par jour<br> Hier : $visites_veille";

 $pr = ((date("U")-$date_premier)/(3600*24))   ;

 echo "<br>premier : $pr" ;

?>
