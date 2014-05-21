<?php

function parallelism_insert_head($flux){
    $poptroxjs = find_in_path('js/jquery.poptrox.min.js');
    $configjs = generer_url_public('js/config.js'); //calculer prefix en attendant mieux
    $skeljs = find_in_path('js/skel.js');
    $css = find_in_path('css/style.css');
    // Cette surcharge ne fonctionne pas
    // $prefixcss = str_replace(".css", "", $css); 
    $flux .= '<script src="'.$poptroxjs.'"></script>
    <script src="'.$configjs.'"></script>
    <script src="'.$skeljs.'"></script>'; // surcharge avec config { prefix: /$prefixcss } marche po
    return $flux;
    }
    
function parallelism_insert_head_css($flux) {
    $cssnoscript = find_in_path('css/skel-noscript.css');
    $cssstyle = find_in_path('css/style.css');
    $cssstyledesktop = find_in_path('css/style-desktop.css');
    $cssstylenoscript = find_in_path('css/style-noscript.css');

    // générer une css au départ d'un squelette SPIP
    // $css_icones = generer_url_public('barre_outils_icones.css');
    
    $flux .= "<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400' rel='stylesheet' type='text/css' />
    <noscript>
      <link rel='stylesheet' type='text/css' media='all' href='$cssnoscript' />
      <link rel='stylesheet' type='text/css' media='all' href='$cssstyle' />
      <link rel='stylesheet' type='text/css' media='all' href='$cssstyledesktop' />
      <link rel='stylesheet' type='text/css' media='all' href='$cssstylenoscript' />
    </noscript>";
    //. "<link rel='stylesheet' type='text/css' media='all' href='$css_icones' />";
    return $flux;
    }

?>