<?php

// déclaration du site dans domaine interne 
// pour changement des class spip_out en spip_in 
// pour les liens internes de type page=machin

  define('_DOMAINE_INT', $GLOBALS['meta']['adresse_site'] ); 


// Suppression globale des nombres devant les titres du type :
//   1. Mon titre

	$table_des_traitements['TITRE'][]= 'supprimer_numero(typo(%s))';


?>