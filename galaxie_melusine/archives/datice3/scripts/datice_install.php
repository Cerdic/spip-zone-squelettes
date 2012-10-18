<?php 

//si le fichier logo créteil n'existe pas (1ere install) => création
$chemin="../IMG/";
$logo_img=$chemin."config/boutons/image_b2.png";
$logo_plugin=_DIR_PLUGIN_DATICE."/images/image_b2.png";
if (!file_exists($logo_img)){
	$config=$chemin."config";
	$boutons=$config."/boutons";
	if(!is_dir($config)){mkdir($config, 0777);};
	if(!is_dir($boutons)){mkdir($boutons, 0777);};
	copy($logo_plugin,$logo_img);
};

//si le fichier perso.css n'existe pas (1ere install) => création
$css_back=_DIR_PLUGIN_DATICE."/styles/perso_back.css";
$css=_DIR_PLUGIN_DATICE."/styles/perso.css";
if (!file_exists($css)){
	chmod ($css_back,0775);
	copy($css_back,$css);
};

//si le fichier perso-mobil.css n'existe pas (1ere install) => création
$css_back=_DIR_PLUGIN_DATICE."/styles/perso_mobil_back.css";
$css=_DIR_PLUGIN_DATICE."/styles/perso-mobil.css";
if (!file_exists($css)){
	chmod ($css_back,0775);
	copy($css_back,$css);
};


//si le fichier inclusion/onglets.html existe on le supprime
$chemin=_DIR_PLUGIN_DATICE;	
$chemin_onglet=$chemin."/inclusions/onglets.html";
if (file_exists($chemin_onglet)){
	unlink($chemin_onglet);
}


$conf=array('bandeau','blocs','boutons','couleurs','mentions','sommaire','squelettes','rubrique','chemin','footer','article','mobil');	
$chemin=_DIR_PLUGIN_DATICE;	
$chemin_conf=$chemin."/images/couleurs.txt";
$file=file($chemin_conf); 


//si les entrées datice de la table meta n'existent pas elles sont créées
$i=0;
foreach($conf as $value){
	$meta="datice_".$value;
	if(!lire_config($meta)){
		
		ecrire_config($meta,$file[$i]);		
	};
	$i++;
};




?>