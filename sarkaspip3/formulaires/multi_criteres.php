<?php
function formulaires_multi_criteres_charger_dist($resultat_bref=''){
    return array('resultat_bref' =>$resultat_bref);
}

function formulaires_multi_criteres_verifier_dist(){
    $mot = _request('mot');

    if (array_sum($mot) == 0){
        return array('message_erreur' =>_T('sarkaspip:choisir_un_critere'));
    }
    return array();
    }
function formulaires_multi_criteres_traiter_dist(){
    $mot = _request('mot');
    return array('message_ok' => $mot);
    
}
?>