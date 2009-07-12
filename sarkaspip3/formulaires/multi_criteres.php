<?php
function formulaires_multi_criteres_charger_dist($resultat_bref=''){
    return array('resultat_bref' =>$resultat_bref);
}

function formulaires_multi_criteres_verifier_dist(){
    $groupe = _request('groupe');

    if (array_sum($groupe) == 0){
        return array('message_erreur' =>_T('collection:choisir_un_critere'));
    }
    return array();
    }
function formulaires_multi_criteres_traiter_dist(){
    $groupe = _request('groupe');
    return array('message_ok' => $groupe);
    
}
?>