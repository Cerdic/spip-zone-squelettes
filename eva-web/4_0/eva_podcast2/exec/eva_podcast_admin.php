<?php
function exec_eva_podcast_admin() {
	include_spip('base/db_mysql');
	include_spip('base/abstract_sql');
	include_spip('inc/presentation');
	include_spip('base/spip_types_documents');
	
$icone = _DIR_PLUGIN_EVAPODCAST."/img_pack/podcast.gif";
$commencer_page = charger_fonction('commencer_page', 'inc');

echo $commencer_page(_T('evapodcast:EVA_nom'),'','','');	 
   echo "<br />";
   echo gros_titre(_T('evapodcast:gros_titre_page'),'',false);
   echo debut_gauche('',true);
	
echo debut_boite_info(true);
   	echo _T('evapodcast:presentation_aac');
echo fin_boite_info(true);
	
echo debut_droite('',true);
echo debut_cadre_trait_couleur($icone, true, '', _T('evapodcast:titre_boite_principale'));

// Cadre de présentation
echo debut_cadre_couleur('',true);
   echo _T('evapodcast:explications');
echo fin_cadre_couleur(true);

// Cadre de recherche de l'id mot
echo debut_cadre_couleur('',true);
	$resultat = sql_select('id_mot','spip_mots',"titre='podcast'");
	$tableau_result = sql_fetch($resultat);
	$nombre_mot = sql_count($resultat);
  	$idmot = $tableau_result['id_mot'];  	
echo "Nombre de mot podcast = ".$nombre_mot;
echo "<br>";
echo "id du mot podcast = ".$idmot;
echo "<br>";

// Recherche des id rubriques
  	$resultat2 = sql_select('id_rubrique','spip_mots_rubriques',"id_mot='$idmot'");
	$tableau_result2 = sql_query($resultat2);
	$nombre_pod = sql_count($resultat2);
	$idrubrique = $tableau_result2['id_rubrique'];
			
echo "Il y a ".$nombre_pod." podcast(s) hébergés par ce site.<br>";
echo "<br>";

// Recherche des rubriques podcasts
for($i=0;$i<=$nombre_pod;$i++){
		while ($row = spip_fetch_array($resultat2)){
			$idrub = $row['id_rubrique'];
			$listerub = sql_select('titre,descriptif,texte','spip_rubriques',"id_rubrique='$idrub'");
			$rub = sql_query($listerub);
			$nombre_rub = sql_count($listerub);
				while ($row_rub = spip_fetch_array($listerub)){
					echo debut_cadre_enfonce('', true, '', $row_rub['titre']);
					echo '<p>';
					echo "Mots-clés = ".$row_rub['descriptif'];
					echo '<br>';
					echo "Descriptif = ".$row_rub['texte'];   
				}
		echo '</p>';
		echo '<form method="post" action="?exec=cfg&cfg=eva_podcast">';
    	echo '<input type="submit" class="fondo" value="';
    	echo _T('evapodcast:modif_flux');
    	echo '" />';
    	echo '</form>';
    	echo fin_cadre_enfonce(true);
	    }
	}

echo fin_cadre_couleur(true);

// Cadre de présentation
echo debut_cadre_couleur('',true);
	echo '<form method="post" action="?exec=cfg&cfg=eva_podcast">';
    echo '<input type="submit" class="fondo" value="';
    echo _T('evapodcast:modif_renseignements');
    echo '" />';
    echo '</form>';
   	echo '<br />';
echo fin_cadre_couleur(true);

echo fin_gauche();
echo fin_cadre_trait_couleur(true);
echo fin_page();

}

?>
	