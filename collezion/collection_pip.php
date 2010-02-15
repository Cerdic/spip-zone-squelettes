<?php
function collection_pre_boucle($boucle){
    include_spip('inc/plugin');
    $liste=liste_plugin_actifs();

        if ($liste['PAGES'] and $boucle->type_requete=='articles' and !collection_page_explicite($boucle->where)){

            $boucle->where[]=array(sql_quote('='),sql_quote('articles.page'),sql_quote("''"));
            }

    return $boucle;
    
    }

function collection_page_explicite($where){
    $serialize = serialize($where);

    if (strpos($serialize,'articles.page')){
        return true;
    }
    return false;

}
?>