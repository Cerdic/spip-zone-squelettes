<?php
function exec_eva_podcast_admin() {
	include_spip('base/db_mysql');
	include_spip('base/abstract_sql');
	include_spip('inc/presentation');
	include_spip('base/spip_types_documents');

	echo debut_page(_T('evapodcast:EVA_nom'),'','','');	 
   echo "<br />";
   echo gros_titre(_T('evapodcast:gros_titre_page'),'',false);
   echo debut_gauche('',true);
	
   echo debut_boite_info(true);
   echo _T('evapodcast:presentation_aac');
   echo fin_boite_info(true);
		
   echo debut_droite('',true);
   echo debut_cadre_trait_couleur("jclic.gif", false, "", _T('evapodcast:titre_boite_principale'));       
   echo debut_cadre_couleur('',true);
// simple test de lire_config()
   echo _T('evapodcast:explications');
  
   echo fin_cadre_couleur(true);
   
	echo debut_cadre_enfonce('', false, '', _T('evapodcast:verifications_m4a'));  
        $table = 'spip_types_documents';
		$champ = 'id_type';
        $data = 'extension';
        $format = 'm4a';
        $nombre_m4a = rechercher($champ,$table,'extension','m4a');
        
	if ($nombre_m4a > 1) {
	echo 'Il y a un problème dans votre base de données.<br/>';
	fin();
	}
	else if ($nombre_m4a == 1){
	echo 'Le format m4a est déjà supporté par votre site<br/>';
	fin();
	} else {
	echo 'Le format m4a n\'est pas supporté<br/>';
	echo 'Ce site va être maintenant être configuré pour supporter ce format<br/>';
	
	//Dans la table spip_mots_articles, r&eacute;cup&eacute;rer tous les ID articles associ&eacute;s à ID jclic

	//$ajout = "INSERT INTO ".$table." (titre,extension,inclus,upload) VALUES ('M4A','m4a','embed','oui')";
        //$resultat2 = spip_query($ajout);
        //echo 'La requête est terminée<br/>';
        ajouter($table,'M4A','m4a');
	}
        
        echo '<br/>';
	echo _T('evapodcast:copier_image_m4a');
	echo '<img src="'._DIR_PLUGIN_EVAPODCAST.'/img_pack/m4a.png" border="0" alt="">';
        
echo fin_cadre_enfonce(true);
        
echo debut_cadre_enfonce('', false, '', _T('evapodcast:verifications_m4v')); 
        $nombre_m4v = rechercher($champ,$table,'extension','m4v');	
        if ($nombre_m4v > 1) {
	echo 'Il y a un problème dans votre base de données.<br/>';
	fin();
	}
	else if ($nombre_m4v == 1){
	echo 'Le format m4v est déjà supporté par votre site<br/>';
	fin();
	} else {
	echo 'Le format m4v n\'est pas supporté<br/>';
	echo 'Ce site va être maintenant être configuré pour supporter ce format<br/>';

        ajouter($table,'M4V','m4v');
	}
        
	echo '<br/>';
	echo _T('evapodcast:copier_image_m4v');
	echo '<img src="'._DIR_PLUGIN_EVAPODCAST.'/img_pack/m4a.png" border="0" alt="">';
        
echo fin_cadre_enfonce(true);
}				

function rechercher($champ,$table,$data,$format){
   $requete = "SELECT ".$champ." FROM ".$table." WHERE ".$data."='".$format."'";
   $resultat1 = spip_query($requete);
   $nb = spip_num_rows($resultat1);
   return ($nb);
}

function ajouter($table,$titre,$extension){        
	$ajout = "INSERT INTO ".$table." (titre,extension,inclus,upload) VALUES ('".$titre."','".$extension."','embed','oui')";
        $resultat2 = spip_query($ajout);
        echo 'Ajout du format '.$extension.' terminée<br/>';
}

function fin() {

}

	
	?>
	