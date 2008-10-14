<?php
/******************************************************************
***  Ce plugin EVA_habillage, crיי par Olivier Gautier, est mis ***
***      א disposition sous un contrat Creative Commons BY      *** 
***                 consultable א l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function eva_habillage_creer_tables($table) {
    include_spip('base/db_mysql');
    include_spip('base/abstract_sql');
    include_spip('inc/presentation');

    $createTableQuery ='CREATE TABLE IF NOT EXISTS '.$table.'
    (id_habillage INTEGER NOT NULL AUTO_INCREMENT,
    habillage TEXT NOT NULL,
    sauvegarde TEXT NOT NULL,
    PRIMARY KEY (id_habillage)
    )';
    
    $resCreateTableQuery = spip_query($createTableQuery);
    $createPremierElement = "INSERT INTO ".$table." VALUES ('','0','Defaut')";
    $resPremierElement = spip_query($createPremierElement);
    debut_cadre_relief('', false, '', "Cr&eacute;ation de la Table");
    echo _T('evahabillage:EVA_creation_table');
    fin_cadre_relief();
    spip_log($table.' created', 'mysql');
    
    
    return;
}

function eva_habillage_creer_tables_themes($table) {
    include_spip('inc/eva_habillage_definition_themes');
    $eva_habillage_themes = eva_habillage_definition_themes ();
    
    $createTableThemesQuery ='CREATE TABLE IF NOT EXISTS '.$table.'_themes (id INTEGER NOT NULL AUTO_INCREMENT, nom TEXT NOT NULL, ';
    foreach($eva_habillage_themes as $eva_themes => $inutile) {
        $createTableThemesQuery .= $eva_themes.' TEXT NOT NULL, ';
    }
    $createTableThemesQuery .= 'PRIMARY KEY (id))';
    $creation_themes = spip_query($createTableThemesQuery);
    $createPremierElementThemes = "INSERT INTO ".$table."_themes VALUES ('','Defaut'";
    foreach($eva_habillage_themes as $eva_themes => $inutile) {
        $createPremierElementThemes .= ",''";
    }
    $createPremierElementThemes .= ")";
    spip_query($createPremierElementThemes);
    debut_cadre_relief('', false, '', "Cr&eacute;ation de la Table");
    echo _T('evahabillage:EVA_creation_table_themes');
    fin_cadre_relief();
    spip_log($table.'_themes created', 'mysql');
}

function eva_habillage_creer_tables_images($table) {
    $createTableImagesQuery ='CREATE TABLE IF NOT EXISTS '.$table.'_images 
    (id INTEGER NOT NULL AUTO_INCREMENT,
    type TEXT NOT NULL,
    nom_habillage TEXT NOT NULL,
    nom_div TEXT NOT NULL,
    nom_image TEXT NOT NULL,
    pos_x TEXT NOT NULL,
    pos_y TEXT NOT NULL,
    repetition TEXT NOT NULL,
    attach TEXT NOT NULL,
    PRIMARY KEY (id))';
    $creation_images = spip_query($createTableImagesQuery);
    debut_cadre_relief('', false, '', "Cr&eacute;ation de la Table");
    echo _T('evahabillage:EVA_creation_table_images');
    fin_cadre_relief();
    spip_log($table.'_images created', 'mysql');
}


function eva_habillage_drop_table() {
    include_spip('base/db_mysql');
    include_spip('base/abstract_sql');
    include_spip('inc/presentation');
    
    $query_drop1 = 'DROP TABLE eva_habillage_themes';
    spip_query($query_drop1);
    $query_drop2 = 'DROP TABLE eva_habillage';
    spip_query($query_drop2);
    $query_drop3 = 'DROP TABLE eva_habillage_images';
    spip_query($query_drop3);
}
?>