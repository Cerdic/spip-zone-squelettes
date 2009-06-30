<?php

function collection_install($action){

    switch($action){
        case 'test':
            return true;
        case 'install':
            ecrire_config('collection/menu','plan');
            ecrire_config('collection/sommaire[]','alea9');
            return true;
        case 'uninstall':
            effacer_config('collection/menu[]');
            effacer_config('collection/sommaire[]');
            return true;
    }

}

?>