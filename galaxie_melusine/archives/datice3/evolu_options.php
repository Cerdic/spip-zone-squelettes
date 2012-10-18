<?php
// Les chemins des dossiers contenant des squelettes
//$skel=_DIR_PLUGIN_DATICE;
 //$GLOBALS['dossier_squelettes'] =$skel."inclusions:".$skel."styles:".$skel."scripts:".$skel."puces:".$skel."dhteumeuleu:".$skel."images:".$skel."modules:".$skel."modules/rubriques:".$skel."modules/chemin:".$skel."modules/footer:".$skel."modules/articles";
 
// Les définitions des champs extras
$GLOBALS['champs_extra'] = Array (         
        
         'articles' => Array (
                        "fondtexte2" => "couleur|brut|couleur du fond de l'article",
                        "bord2" => "couleur|brut|couleur du bord de l'article" ,
                        "texte2" => "couleur|brut|couleur du texte de l'article"
                                 )
        
    );                  
 
$GLOBALS['champs_extra_proposes'] = Array (                
         'articles' => Array (
                // couleurs pour les articles (fond,bord, texte)
                'tous' => 'fondtexte2|bord2|texte2'
                ),
      
    );

?>