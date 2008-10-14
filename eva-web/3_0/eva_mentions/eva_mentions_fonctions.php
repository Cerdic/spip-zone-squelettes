<?php
// balise #NOM_ETAB
function evamentions_nom_etab() {
	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   $requete_mentions = "SELECT etab FROM ".$table_mentions;
   $resultat_mentions = spip_query($requete_mentions);
   $nombre_mentions = spip_num_rows($resultat_mentions);
   
   while ($row_mentions= spip_fetch_array($resultat_mentions)){
   $row_mentions["etab"];
	return $row_mentions["etab"];
	}
}
function balise_NOM_ETAB($p) {
	$p->code = "evamentions_nom_etab()";
	$p->statut = 'php';
	return $p;
}

// balise #DIRECTEUR_PUBLICATION
function evamentions_directeur_publication() {
	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   $requete_mentions = "SELECT dir_pub FROM ".$table_mentions;
   $resultat_mentions = spip_query($requete_mentions);
   $nombre_mentions = spip_num_rows($resultat_mentions);
   
   while ($row_mentions= spip_fetch_array($resultat_mentions)){
   $row_mentions["dir_pub"];
	return $row_mentions["dir_pub"];
	}
}
function balise_DIRECTEUR_PUBLICATION($p) {
	$p->code = "evamentions_directeur_publication()";
	$p->statut = 'php';
	return $p;
}

// balise #RESPONSABLE_EDITION
function evamentions_responsable_edition() {
	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   $requete_mentions = "SELECT resp_edit FROM ".$table_mentions;
   $resultat_mentions = spip_query($requete_mentions);
   $nombre_mentions = spip_num_rows($resultat_mentions);
   
   while ($row_mentions= spip_fetch_array($resultat_mentions)){
   $row_mentions["resp_edit"];
	return $row_mentions["resp_edit"];
	}
}
function balise_RESPONSABLE_EDITION($p) {
	$p->code = "evamentions_responsable_edition()";
	$p->statut = 'php';
	return $p;
}

// balise #HEBERGEUR
function evamentions_hebergeur() {
	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   $requete_mentions = "SELECT hebergeur FROM ".$table_mentions;
   $resultat_mentions = spip_query($requete_mentions);
   $nombre_mentions = spip_num_rows($resultat_mentions);
   
   while ($row_mentions= spip_fetch_array($resultat_mentions)){
   $row_mentions["hebergeur"];
	return $row_mentions["hebergeur"];
	}
}
function balise_HEBERGEUR($p) {
	$p->code = "evamentions_hebergeur()";
	$p->statut = 'php';
	return $p;
}

// balise #ADRESSE_HEBERGEUR
function evamentions_adresse_hebergeur() {
	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   $requete_mentions = "SELECT adresse FROM ".$table_mentions;
   $resultat_mentions = spip_query($requete_mentions);
   $nombre_mentions = spip_num_rows($resultat_mentions);
   
   while ($row_mentions= spip_fetch_array($resultat_mentions)){
   $row_mentions["adresse"];
	return $row_mentions["adresse"];
	}
}
function balise_ADRESSE_HEBERGEUR($p) {
	$p->code = "evamentions_adresse_hebergeur()";
	$p->statut = 'php';
	return $p;
}

// balise #WEBMESTRE
function evamentions_webmestre() {
	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   $requete_mentions = "SELECT webmestre FROM ".$table_mentions;
   $resultat_mentions = spip_query($requete_mentions);
   $nombre_mentions = spip_num_rows($resultat_mentions);
   
   while ($row_mentions= spip_fetch_array($resultat_mentions)){
   $row_mentions["webmestre"];
	return $row_mentions["webmestre"];
	}
}
function balise_WEBMESTRE($p) {
	$p->code = "evamentions_webmestre()";
	$p->statut = 'php';
	return $p;
}

// balise #QUALITE
function evamentions_qualite_webmestre() {
	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   $requete_mentions = "SELECT qualite FROM ".$table_mentions;
   $resultat_mentions = spip_query($requete_mentions);
   $nombre_mentions = spip_num_rows($resultat_mentions);
   
   while ($row_mentions= spip_fetch_array($resultat_mentions)){
   $row_mentions["qualite"];
	return $row_mentions["qualite"];
	}
}
function balise_QUALITE_WEBMESTRE($p) {
	$p->code = "evamentions_qualite_webmestre()";
	$p->statut = 'php';
	return $p;
}

// balise #ID_WEBMESTRE
function evamentions_id_webmestre() {
	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   $requete_mentions = "SELECT idweb FROM ".$table_mentions;
   $resultat_mentions = spip_query($requete_mentions);
   $nombre_mentions = spip_num_rows($resultat_mentions);
   
   while ($row_mentions= spip_fetch_array($resultat_mentions)){
   $row_mentions["idweb"];
	return $row_mentions["idweb"];
	}
}
function balise_ID_WEBMESTRE($p) {
	$p->code = "evamentions_id_webmestre()";
	$p->statut = 'php';
	return $p;
}
?>