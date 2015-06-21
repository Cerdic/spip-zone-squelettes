<?php

// Un énorme merci à Arnaud Bérard pour son aide

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
        
        // verifier que les champs nom et prenom sont bien la :
        foreach(array('nom','prenom') as $obligatoire)
                if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('info_obligatoire_02'); 
       

                                        
        // Si le champ mail est active dans la configuration de escal
        if(lire_config('escal/config/contactmail') == 'oui'){
            $email = _request('email');
            // verifier si un email a ete saisi
            if (!_request('email')) {
                    $erreurs['email'] = _T('info_obligatoire_02');       
            }
            // Verifier que c'est une adresse valide
            else if(!preg_match("#^[0-9A-Za-z]([-_.]?[0-9A-Za-z])*@[0-9A-Za-z]([-_.]?[0-9A-Za-z])*\\.[A-Za-z]{2,4}$#",$email)){
                    $erreurs['email'] = _T('escal:contact_alerte_mail');
            }
        }
        
        // Si les autres champs sont actives dans la configuration de escal
      	if (!_request('champsup1') AND lire_config('escal/config/champsup1') == 'oui' AND lire_config('escal/config/champsup1oblig') == 'oui' ) 
              $erreurs['champsup1'] = _T('info_obligatoire_02');              
      	if (!_request('champsup2') AND lire_config('escal/config/champsup2') == 'oui' AND lire_config('escal/config/champsup2oblig') == 'oui' ) 
              $erreurs['champsup2'] = _T('info_obligatoire_02'); 
      	if (!_request('sujet') AND lire_config('escal/config/radio') == 'oui' AND lire_config('escal/config/radiooblig') == 'oui' ) 
              $erreurs['sujet'] = _T('info_obligatoire_02');
      	if (!_request('checkbox') AND lire_config('escal/config/checkbox') == 'oui' AND lire_config('escal/config/checkboxoblig') == 'oui' ) 
              $erreurs['checkbox'] = _T('info_obligatoire_02');        
        
        
        // verification du message        
        $test_message = nocode(_request('message'));
            // verifier si un message a ete saisi
            if (!_request('message')) {
                    $erreurs['message'] = _T('escal:contact_alerte_message');       
            }
            // Verifier que c'est un message valide
            else if($test_message==FALSE){
                    $erreurs['message']=_T('escal:contact_alerte_interdit').$test_message;
            }                    
        
        // message general si oubli ou erreur
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
        $sujet = _T('escal:page_contact2')." ".$nom_site;
        $email_from = $champs['email'];


        
        $message =  "<strong>"._T('escal:envoi_mail_nom')."</strong>".$champs['nom']."\n\n";
        $message .= "<strong>"._T('escal:envoi_mail_prenom')."</strong>".$champs['prenom']."\n\n";

        
        if (lire_config('escal/config/champsup1') == 'oui') {
            $message .= "<strong>"._T_ou_typo(lire_config('escal/config/titrechampsup1'))."&nbsp"."</strong>";
            $message .= $champs['champsup1']."\n\n";
        }
        
        if (lire_config('escal/config/champsup2') == 'oui') {
            $message.= "<strong>"._T_ou_typo(lire_config('escal/config/titrechampsup2'))."&nbsp"."</strong>";
            $message.= $champs['champsup2']."\n\n";
        }
        
        if (lire_config('escal/config/radio') == 'oui') {
            $message.= "<strong>"._T('escal:envoi_mail_motif')."</strong>";
            $message.= $champs['sujet']."\n\n";
        }
        
        if (lire_config('escal/config/checkbox') == 'oui') {
            $message .= "<strong>"._T_ou_typo(lire_config('escal/config/titrecheckbox'))."</strong>" ;
            if (is_array($champs['checkbox'])) {
              $message .= implode(" - ",$champs['checkbox'])."\n\n";
            }
        }
        
        $message .= "<strong>"._T('escal:envoi_mail_message')."</strong>"."\n ".$champs['message'];

             
        if ($champs['antispam']=='' ){
            if(send_email($email_to,$email_from,$email_webmaster,$sujet,$message)==true){
                return array(
                    'editable' => false,
                    'message_ok'=>_T('escal:contact_retour_commentaire')."\n"."<strong>". _request('email')."</strong>"
                    );
            }else{
                return array(
                'message_erreur'=>_T('pass_erreur_probleme_technique')
                );
            }
        }else{
            return array('message_erreur'=>'Pas de robots ici !!');
        }

        
}
// Verification basique d'insertion de code pour la fonction verifier
function nocode($text){
    if(!preg_match("/[]%~#`$&|}{^[><]/",$text))
        return trim($text);
    else
        return FALSE;
}

/*
  Envoi de mail avec php 
*/
function send_email($destinataire,$email_from,$email_reply,$sujet,$message) {
    //http://www.vulgarisation-informatique.com/mail.php

  $message_texte=supprimer_tags($message); 
  $message_html='<html> 
    <head> 
      <title>'.$sujet.'</title> 
    </head> 
    <body>
      <div style="width:500px; margin:auto">
        <div style="padding:10px; font-size:20px; font-weight:bold; background-color:#82ADE2">
          '.$sujet.'
        </div>
        <div style="padding:10px; background-color:#DAE6F6">
          '.nl2br($message).'
        </div>
      </div>
    </body> 
    </html>'; 

     //----------------------------------------------- 
     //GENERE LA FRONTIERE DU MAIL ENTRE TEXTE ET HTML 
     //----------------------------------------------- 

     $frontiere = '-----=' . md5(uniqid(mt_rand())); 

     //----------------------------------------------- 
     //HEADERS DU MAIL 
     //----------------------------------------------- 

     $headers = 'From: <'.$email_from.'>'."\n";
     $headers .= 'Reply-To: <'.$email_from.'>'."\n";
     $headers .= 'Return-Path: <'.$email_reply.'>'."\n"; 
     $headers .= 'MIME-Version: 1.0'."\n"; 
     $headers .= 'Content-Type: multipart/alternative; boundary="'.$frontiere.'"'; 

     //----------------------------------------------- 
     //MESSAGE TEXTE 
     //----------------------------------------------- 
     $message = 'This is a multi-part message in MIME format.'."\n\n"; 

     $message .= '--'.$frontiere."\n"; 
     $message .= 'Content-Type: text/plain; charset="utf-8"'."\n"; 
     $message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
     $message .= html_entity_decode($message_texte)."\n\n"; 

     //----------------------------------------------- 
     //MESSAGE HTML 
     //----------------------------------------------- 
     $message .= '--'.$frontiere."\n";
     $message .= 'Content-Type: text/html; charset="utf-8"'."\n"; 
     $message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
     $message .= $message_html."\n\n"; 

     $message .= '--'.$frontiere."\n"; 

     if(mail($destinataire,$sujet,$message,$headers)) { 
          return true; 
     } else { 
          return false; 
     } 
}


?>