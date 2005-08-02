<?php

########################################################################
#      CONVERTISSEUR du squelette SEDNA 'sites syndiques / liens'
#      vers le squelette SEDITION, qui gere 'rubriques / articles'
#
#      Emploi :
#      en ligne de commande taper
#               > php sedition.phps
#      Les squelettes prets a l'emploi (ou presque) se trouvent
#      alors dans le repertoire sedition/
########################################################################


// Interdire 

chdir('../');
include('ecrire/inc_version.php3');

function transform_sedna($fichier) {

$r = array(
	'syndic_articles.url' => 'articles.chapo',
	'syndic_articles.lesauteurs' => 'articles.surtitre',
	'(SITES)' => '(RUBRIQUES)',
	'#ID_SYNDIC_ARTICLE' => '#ID_ARTICLE',
	'id_syndic_article' => 'id_article',
	'id_syndic' => 'id_rubrique',
	'syndic_articles' => 'articles',
	'#ID_SYNDIC' => '#ID_RUBRIQUE',
	'(SYNDIC_ARTICLES)' => '(ARTICLES)',
	'#URL_SITE/' => '#URL_RUBRIQUE/',
	'#URL_SITE|' => '#URL_RUBRIQUE|',
	'#URL_SITE"' => '#URL_RUBRIQUE"',
	'#URL_SYNDIC/' => '???/',
	'#NOM_SITE|' => '#TITRE|',
	"#NOM_SITE\n" => "#TITRE\n",
	' nom_site' => ' titre',
	'{syndication!=non}' => '',
	'#DESCRIPTIF' => '#INTRODUCTION',
	'descriptif' => 'texte',
	'sedna' => 'sedition',
	'#NOM_SITE<' => '#TITRE<',
	
	
);

return str_replace(array_keys($r), array_values($r), $fichier);

}

mkdir('sedition') or die('repertoire sedition/ pas cree');

lire_fichier('sedna/sedna.php', $contenu);
ecrire_fichier('sedition/sedition.php', transform_sedna($contenu));

lire_fichier('sedna/index.php', $contenu);
ecrire_fichier('sedition/index.php', transform_sedna($contenu));

lire_fichier('sedna/local_fr.php3', $contenu);
ecrire_fichier('sedition/local_fr.php3', transform_sedna($contenu));

lire_fichier('sedna/local_en.php3', $contenu);
ecrire_fichier('sedition/local_en.php3', transform_sedna($contenu));


lire_fichier('sedna/sedna.html', $contenu);
ecrire_fichier('sedition/sedition.html', transform_sedna($contenu));

lire_fichier('sedna/sedna-rss.html', $contenu);
ecrire_fichier('sedition/sedition-rss.html', transform_sedna($contenu));

lire_fichier('sedna/sedna.css', $contenu);
ecrire_fichier('sedition/sedition.css', transform_sedna($contenu));

lire_fichier('sedna/sedna.js', $contenu);
ecrire_fichier('sedition/sedition.js', transform_sedna($contenu));

copy('sedna/sedna-badge.png', 'sedition/sedition-badge.png');
copy('sedna/sedna-big.png', 'sedition/sedition-big.png');
copy('sedna/sedna-pink.gif', 'sedition/sedition-pink.gif');
copy('sedna/sedna-red.gif', 'sedition/sedition-red.gif');
copy('sedna/sedna-orange.gif', 'sedition/sedition-orange.gif');
copy('sedna/sedna-cyan.gif', 'sedition/sedition-cyan.gif');
copy('sedna/sedna-blue.gif', 'sedition/sedition-blue.gif');

?>