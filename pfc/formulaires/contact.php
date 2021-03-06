<?php
function formulaires_contact_charger_dist(){
    $valeurs = array('email'=>'', 'sujet'=>'', 'message'=>'');
    return $valeurs;
}

function formulaires_contact_verifier_dist(){
    $erreurs = array();
    // verifier que les champs obligatoires sont bien la :
    foreach(array('email', 'sujet', 'message') as $obligatoire)
	    if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('info_obligatoire');
   
    // verifier que si un email a été saisi, il est bien valide :
    include_spip('inc/filtres');
    if (_request('email') AND !email_valide(_request('email')))
	    $erreurs['email'] = _T('form_email_non_valide');

    if (count($erreurs))
	    $erreurs['message_erreur'] = _T('pfc:message_erreur_saisie');
    return $erreurs;
}

function formulaires_contact_traiter_dist(){
    $envoyer_mail = charger_fonction('envoyer_mail','inc');
    $email_to = $GLOBALS['meta']['email_webmaster'];
    $email_from = _request('email');
    $sujet = _request('sujet');
    $message = _request('message');
    $envoyer_mail($email_to,$sujet,$message,$email_from);
    return array('message_ok'=>_T('message_ok_contact'));
}

?>