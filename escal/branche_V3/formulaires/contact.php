<?php

if (!defined("_ECRIRE_INC_VERSION")) return;



function formulaires_contact_charger_dist(){
        $valeurs = array(
            'nom'=>'',
            'prenom'=>'',
            'email'=>'',
            'champsup1'=>'',
            'champsup2'=>'',
            'sujet'=>'',
            'checkbox'=>'',
            'Antispam'=>'',
            'message'=>''
        );
        
        return $valeurs;
}

function formulaires_contact_verifier_dist(){
        include_spip('inc/config');
        include_spip('inc/filtres');
        
        $erreurs = array();
        
        // verifier que les champs nom et prénom sont bien la :
        foreach(array('nom','prenom') as $obligatoire)
                if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('info_obligatoire_02'); 
       

                                        
        // Si le champ mail est activé dans la configuration de escal
        if(lire_config('escal/config/contactmail') == 'oui'){
            $email = _request('email');
            // verifier si un email a été saisi
            if (!_request('email')) {
                    $erreurs['email'] = _T('info_obligatoire_02');       
            }
            // Vérifier que c'est une adresse valide
            else if(!preg_match("#^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-_.]?[0-9a-z])*\\.[a-z]{2,4}$#",$email)){
                    $erreurs['email'] = _T('escal:contact_alerte_mail');
            }
        }
        
        // Si les autres champs sont activés dans la configuration de escal
      	if (!_request('champsup1') AND lire_config('escal/config/champsup1') == 'oui' AND lire_config('escal/config/champsup1oblig') == 'oui' ) 
              $erreurs['champsup1'] = _T('info_obligatoire_02');              
      	if (!_request('champsup2') AND lire_config('escal/config/champsup2') == 'oui' AND lire_config('escal/config/champsup2oblig') == 'oui' ) 
              $erreurs['champsup2'] = _T('info_obligatoire_02'); 
      	if (!_request('sujet') AND lire_config('escal/config/radio') == 'oui' AND lire_config('escal/config/radiooblig') == 'oui' ) 
              $erreurs['sujet'] = _T('info_obligatoire_02');
      	if (!_request('checkbox') AND lire_config('escal/config/checkbox') == 'oui' AND lire_config('escal/config/checkboxoblig') == 'oui' ) 
              $erreurs['checkbox'] = _T('info_obligatoire_02');        
        
        
        // vérification du message        
        $test_message = nocode(_request('message'));
            // verifier si un message a été saisi
            if (!_request('message')) {
                    $erreurs['message'] = _T('escal:contact_alerte_message');       
            }
            // Vérifier que c'est un message valide
            else if($test_message==FALSE){
                    $erreurs['message']=_T('escal:contact_alerte_interdit').$test_message;
            }                    
        
        // message général si oubli ou erreur
        if (count($erreurs))
                $erreurs['message_erreur'] = _T('escal:contact_alerte_entete');
                
        return $erreurs;
}


function formulaires_contact_traiter_dist(){
    
        include_spip('inc/config');
        
        $champs = array(
            'nom'  => _request('nom'),
            'prenom' => _request('prenom'),
            'email' => _request('email'),
            'message'=> _request('message'),
            'champsup1'=>_request('champsup1'),
            'champsup2'=>_request('champsup2'),
            'sujet'=>_request('sujet'),
            'checkbox'=>_request('checkbox'),
            'anstispam'=>_request('Antispam'),
        );
        
        $nom_site = extraire_multi($GLOBALS['meta']["nom_site"]); 
        $email_webmaster = $GLOBALS['meta']['email_webmaster'];
        $email_to= lire_config('escal/config/destinataire').",".$email_webmaster;
        $sujet = _T('escal:page_contact2')." : ".$nom_site;
        $email_from = $champs['email'];


        
        $message =  "<b>"._T('escal:envoi_mail_nom')."</b>".clean($champs['nom'])."\n";
        $message .= "<b>"._T('escal:envoi_mail_prenom')."</b>".clean($champs['prenom'])."\n\n\n";
         
        
        if (lire_config('escal/config/champsup1') == 'oui') {
            $message .= "<b>"._T_ou_typo(lire_config('escal/config/titrechampsup1'))."</b>";
            $message .= clean($champs['champsup1'])."\n\n";
        }
        
        if (lire_config('escal/config/champsup2') == 'oui') {
            $message.= "<b>"._T_ou_typo(lire_config('escal/config/titrechampsup2'))."</b>";
            $message.= clean($champs['champsup2'])."\n\n";
        }
        
        if (lire_config('escal/config/radio') == 'oui') {
            $message.= "<b>"._T('escal:envoi_mail_motif')."</b>";
            $message.= clean($champs['sujet'])."\n\n";
        }
        
        if (lire_config('escal/config/checkbox') == 'oui') {
            $message .= "<b>"._T_ou_typo(lire_config('escal/config/titrecheckbox'))."</b>";
            if (is_array($champs['checkbox'])) {
              $message .= implode(" - ",$champs['checkbox'])."\n\n";
            }
        }
        
        $message .= "<b>"._T('escal:envoi_mail_message')."</b>"."\n ".clean($champs['message'])."\n\n";

             
        if ($champs['antispam']=='' ){
            $envoyer_mail = charger_fonction('envoyer_mail','inc');
            $corps = array(
                'texte'=> supprimer_tags($message),
                'from'=> $email_from,
                'html'=> preg_replace('#([\n])+#','<br />',$message),
                );
            // http://code.spip.net/autodoc/tree/ecrire/inc/envoyer_mail.php.html#function_inc_envoyer_mail_dist
            $envoyer_mail($email_to,$sujet,$corps);
            return array(
                'message_ok'=>_T('escal:contact_retour_commentaire')."\n"."<strong>". _request('email')."</strong>"
                );
        }else{
            return array('message_erreur'=>'Pas de robots ici !!');
        }

        
}
// Vérification basique d'insertion de code pour la fonction vérifier
function nocode($text){
    if(!preg_match("/[]%~#`$&|}{^[><]/",$text))
        return trim($text);
    else
        return FALSE;
}
// Nettoyage minimal pour les champs textes input
function clean($text){
    $text = htmlentities(trim($text));
    return $text;
}
// Présentation du message reçu
function presente($txt){
    $avant = "<span class=\"envoi-mail\"> " ;
    $apres = "</span>" ;
      $txt = $avant.$txt.$apres;
    return $txt;
}

?>