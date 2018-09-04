<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function parallelism_insert_head($flux){
    $poptroxjs = find_in_path('js/jquery.poptrox.js');
    $configjs = generer_url_public('config.js'); //calculer prefix en attendant mieux

	// si on est dans une page_unique, transmettre l'info à config.js.html 
	// pour éventuels paramétrages spécifiques
	if (isset($GLOBALS['page']['contexte']['id_article'])) {
		$where = 'id_article='.$GLOBALS['page']['contexte']['id_article'];
		$id_rub = sql_getfetsel('id_rubrique', 'spip_articles', $where);
		if ($id_rub == -1) {
			$configjs .= '&page_unique=oui';
		}
	}

    $skeljs = find_in_path('js/skel.js');
    $html5shiv = find_in_path('js/html5shiv.js'); 
    $cssspipstyle = find_in_path('css/spip-style.css'); // mis ici pour passer après style.css !

    $flux .= '<!--[if lte IE 8]><script src="'.$html5shiv.'"></script><![endif]-->
    <script src="'.$poptroxjs.'"></script>
    <script src="'.$configjs.'"></script>
    <script src="'.$skeljs.'"></script>
    <link rel="stylesheet" type="text/css" media="all" href="'.$cssspipstyle.'" />';// mis ici pour passer après style.css !
    return $flux;
    }
    
function parallelism_insert_head_css($flux) {
    $cssnoscript = find_in_path('css/skel-noscript.css');
    // css/style.css fait déja partie des css embarquées par le head de la dist alors pas la peine de le charger en double
    //$cssstyle = find_in_path('css/style.css');
    $cssstyledesktop = find_in_path('css/style-desktop.css');
    $cssstylenoscript = find_in_path('css/style-noscript.css');

    // générer une css au départ d'un squelette SPIP
    // $css_icones = generer_url_public('barre_outils_icones.css');
    
    $flux .= '<noscript>
		<link rel="stylesheet" type="text/css" media="all" href="'.$cssnoscript.'" />
		<link rel="stylesheet" type="text/css" media="all" href="'.$cssstylenoscript.'" />
    </noscript>
    <link rel="stylesheet" type="text/css" media="all" href="'.$cssstyledesktop.'" />
    
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->';

    //<link rel="stylesheet" type="text/css" media="all" href="'.$cssstyle.'" />
    
    //. "<link rel="stylesheet" type="text/css" media="all" href="$css_icones" />";
    return $flux;
    }