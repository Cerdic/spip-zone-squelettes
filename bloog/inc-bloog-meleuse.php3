<?php
//Création du mail particulier

include("ecrire/inc_version.php3");
include_ecrire("inc_connect.php3");
include_ecrire("inc_filtres.php3");
include_ecrire("inc_config.php3");
include_ecrire("inc_texte.php3");
include_ecrire ("inc_session.php3");
include_ecrire ("inc_meta.php3");


// On utilise des extra de l'auteur 1 pour emuler une sorte de spip_meta.
// On récupère l'id du premier abonné du prochain lot à envoyer.

$deb = get_extra(1,"auteur");
$debut = $deb["debut"];

// Compter les auteurs

global $table_prefix;
$query = "SELECT nom, id_auteur, email, extra FROM ".$table_prefix."_auteurs ORDER BY nom ASC ";

$result_inscrits = spip_query($query);
$nb_inscrits = spip_num_rows($result_inscrits);
     
   
// Trouver le message à envoyer

global $table_prefix;
$query_message = "SELECT * FROM ".$table_prefix."_messages AS messages WHERE statut='encour' ORDER BY date_heure ASC LIMIT 0,1";

$result_pile = spip_query($query_message);
$message_pile = spip_num_rows($result_pile);

// virer les doublons, mais lesquels ???
				
if ($message_pile > 0){
	
	    $row = spip_fetch_array($result_pile);
	    
        $titre = typo($row["titre"]);
	    $texte = propre($row["texte"]);
	    $type = $row["type"];
	    $id_message = $row["id_message"];

	    $nomsite=lire_meta("nom_site");
	    $urlsite=lire_meta("adresse_site");
	    srand((double)microtime()*1000000);
	    $boundary = md5(uniqid(rand()));

	    $objet= filtrer_entites($titre);
                if ($charset <> 'utf-8') {
		   $objet = str_replace("&#8217;", "'", $objet);
			}

			$email_envoi = lire_meta("email_envoi");
			$email_webmaster = lire_meta("email_webmaster");

		    $from = email_valide($email_envoi) ? $email_envoi : $email_webmaster;
						
		  		  
// on nettoie pour la version texte


  if ($charset <> 'utf-8') $texte = str_replace("&#8217;", "'", $texte);
 

/* $page = ereg_replace ("</TR>","\n", $texte);
  $page = ereg_replace ("</tr>","\n", $page);
  $page = ereg_replace ("</div>","\n", $page);
  $page = ereg_replace ("</DIV>","\n", $page);
  $page = ereg_replace ("<br>","\n", $page);
  $page = ereg_replace ("<BR />","\n", $page);
  $page=textebrut($page);

  //BoOz fait des filtres ;op
  $page = ereg_replace ("\n","b_l_o", $page);
  $page = filtrer_entites($page);
  $page = ereg_replace ("b_l_o","\n", $page);
 */
 
 
 /****
 * titre : version_texte
 * d'après N Hoizey
****/

function version_texte ($in) {
 

	
    // Nettoyage des liens des notes de bas de page
    $out = ereg_replace("<a href=\"#n(b|h)[0-9]+-[0-9]+\" name=\"n(b|h)[0-9]+-[0-9]+\" class=\"spip_note\">([0-9]+)</a>", "\\3", $in);



	// les puces
    $out = str_replace($GLOBALS['puce'], "\n".'-', $out);

    // Remplace tous les liens
    while (eregi("<a href=['\"]([^'\">]+)['\"][^>]*>([^<]+)</a>", $out, $regs)) {
        $cleanReg1 = ereg_replace("\\?", "\?", $regs[1]);
        $cleanReg1 = ereg_replace("\\+", "\+", $cleanReg1);
        $cleanReg2 = ereg_replace("\\?", "\?", $regs[2]);
        $cleanReg2 = ereg_replace("\\+", "\+", $cleanReg2);
        if ($regs[1] == $regs[2]) {
            $out = eregi_replace("<a href=['\"]".$cleanReg1."['\"][^>]*>".$cleanReg1."</a>", $regs[1], $out);
        } else {
            $out = eregi_replace("<a href=['\"]".$cleanReg1."['\"][^>]*>".$cleanReg2."</a>", $regs[2]." (".$regs[1].")", $out);
        }
    }
    

    
    $out = str_replace("<p class=\"spip\"[^>]*>", "\n", $out);

    // Les notes de bas de page
    $out = str_replace("<p class=\"spip_note\">", "\n", $out);
    $out = ereg_replace("<sup>([0-9]+)</sup>", "[\\1]", $out);

    //$out = str_replace('<br /><img class=\'spip_puce\' src=\'puce.gif\' alt=\'-\' border=\'0\'>', "\n".'-', $out);
    $out = ereg_replace ('<li[^>]>', "\n".'-', $out);
    //$out = str_replace('<li>', "\n".'-', $out);


    // accentuation du gras - 
    // <b>texte</b> -> *texte*
    $out = ereg_replace ('<b[^>|r]*>','*' ,$out);
    $out = str_replace ('</b>','*' ,$out);
    
    // accentuation de l'italique
    // <i>texte</i> -> *texte*
    $out = ereg_replace ('<i[^>|mg]*>','*' ,$out);
    $out = str_replace ('</i>','*' ,$out);
    
        $out = str_replace('&oelig;', 'oe', $out);
	$out = str_replace("&nbsp;", " ", $out);
        $out = filtrer_entites($out);

   	$out = supprimer_tags($out);
   	
        $out = ereg_replace("^(\n|\r|\r\n| )+", "", $out);
        //$out = eregi_replace("(\n|\r|\r\n| ){3,}", "\n\n", $out);
        //$out = eregi_replace("(\n|\r|\r\n| ){3}", "\n\n", $out);

    return $out;
        
}
 $page = version_texte($texte); 
  
  
  $page = ereg_replace ("\.php3 \?",".php3?", $page);
  $page = ereg_replace ("\.php \?",".php?", $page);

  $page.="\n\n________________________________________________________________________"  ;
  $page.="\n\nEditeur : $nomsite\n"  ;
  $page.=$urlsite."\n";
  $page.="________________________________________________________________________"  ;

  $headers = "From: $from\n";
  $headers .= "Reply-to: $from\n";
   //$headers .= "cc:$from\n";
   //$headers .= "bcc:$from\n, $from\n";
  $headers .="MIME-Version: 1.0\n";
  $headers  .="Content-Type: text/plain; charset=\"iso-8859-1\"\n";
  $headers  .="Content-Transfer-Encoding:8bit\n";
  $headers  .="\n";



// on nettoie pour la version html

  
  // filtres à la BoOz
function propre_bloog($texte) {

        $texte = ereg_replace("<p class=\"spip\">(\r\n|\n|\r)?</p>",'',$texte);
        $texte = eregi_replace("\n{3}", "\n", $texte);

        // h3 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h3 class=\"spip\">" , "<h3 class=\"spip\">" , $texte);
        $texte = eregi_replace( "<\/h3>(\r\n|\n|\r| )*<\/p>" , "</h3>" , $texte);
        
        // h2 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h2>" , "<h2>" , $texte);
        $texte = eregi_replace( "<\/h2>(\r\n|\n|\r| )*<\/p>" , "</h2>" , $texte);

        // tableaux imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(table|TABLE)" , "<table" , $texte);
       $texte = eregi_replace( "<\/(table|TABLE)>(\r\n|\n|\r| )*<\/p>" , "</table>" , $texte);
	   
	   // TD imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(\/td|\/TD)" , "</td" , $texte);
       //$texte = eregi_replace( "<\/(td|TD)>(\r\n|\n|\r| )*<\/p>" , "</td>" , $texte);
	   
	   	   // p imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(p|P)" , "<p" , $texte);
       //$texte = eregi_replace( "<\/(td|TD)>(\r\n|\n|\r| )*<\/p>" , "</td>" , $texte);
         
         // DIV imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(div|DIV)" , "<div" , $texte);
       $texte = eregi_replace( "<\/(DIV|div)>(\r\n|\n|\r| )*<\/p>" , "</div>" , $texte);
  
 //$texte = PtoBR($texte);
  $texte = ereg_replace ("\.php3&nbsp;\?",".php3?", $texte);
  $texte = ereg_replace ("\.php&nbsp;\?",".php?", $texte);

  return $texte;
}  



$texteh = propre_bloog($texte);

  $pageh = "This is a multi-part message in MIME format\n";
  $pageh .="--$boundary\nContent-Type: text/plain;charset=\"iso-8859-1\"\n";
  $pageh .="Content-Transfer-Encoding: quoted-printable\n\n";
  $pageh .="Votre logiciel de messagerie ne peut apparemment pas afficher correctement la version graphique (HTML) de cet e-mail\n";
  $pageh .="\n\n";
  $pageh .="--$boundary\nContent-Type: text/html;charset=\"iso-8859-1\"\n";
  $pageh .="Content-Transfer-Encoding: 7 BIT\n\n";
  $pageh .="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
  $pageh .="<HTML><HEAD><BASE HREF=".$urlsite."></HEAD><BODY>";
  $pageh .= $texteh;


  $headersh = "From: $from\n";
  $headersh .= "Reply-to: $from\n";
  //$headers .= "cc:$from\n"; // CC to
  //$headers .= "bcc:$from\n, $from\n"; // BCCs to
  $headersh .="MIME-Version: 1.0\n";
  $headersh  .="Content-Type: MULTIPART/ALTERNATIVE;BOUNDARY=\"$boundary\"\n\n";


// Envoi par lot


$limit=20; // nombre de messages envoyés par boucles.
  

$query = "SELECT nom, id_auteur, email, extra FROM ".$table_prefix."_auteurs ORDER BY nom ASC LIMIT $debut,$limit";
$result_inscrits = spip_query($query);
$liste_abonnes = spip_num_rows($result_inscrits);

// on modifie la limite avant d'envoyer les mails pour éviter les doublons en cas d'erreur pendant l'envoi.

$debut = $debut+$limit;

if ($debut>$nb_inscrits){
	spip_query("UPDATE ".$table_prefix."_messages SET statut='publie' WHERE id_message='$id_message'");
	$deb["debut"] = "0";
	set_extra(1,$deb,"auteur");
	//attention si on interrompt
        }

	else{
	$deb["debut"] = $debut;
	set_extra(1,$deb,"auteur");
	}


if ($liste_abonnes > 0) {

$addresse_desabo =  $urlsite."/abonnement.php3";
		
	while ($row = spip_fetch_array($result_inscrits)) {
		$nom_auteur = $row["nom"];
		$email = $row["email"];
		$id = $row["id_auteur"];
		$total=$total+1;
		unset ($cookie);
		
		$extra = unserialize ($row["extra"]);
	if (($extra["abo"] == 'texte') OR ($extra["abo"] == 'html')) {$abo = true;}
        else {$abo = false;}
		
		
	if ($abo) {
		    
			$cookie = creer_uniqid();
			spip_query("UPDATE spip_auteurs SET cookie_oubli = '$cookie' WHERE email ='$email'");
			
			
		if ($extra["abo"] == 'texte'){


// pied de page texte	


$pagem =$page."\n\n"  ;
$pagem.= _T('bloog:abonnement_mail')."\n";
$pagem.= $addresse_desabo."?d=".$cookie."\n\n"  ;


// fin du pied de page texte
			
		$ok = mail($email,$objet,$pagem,$headers) ;
		
                }

                
                else if ($extra["abo"] == 'html'){
			
// pied de page HTML

$pagehm = $pageh."<hr>Editeur: <a href=\"".$urlsite."\">".$nomsite."</a><br>
<a href=\"".$urlsite."\">".$urlsite."</a><hr>
<a href=\"".$addresse_desabo."?d=".$cookie."\">"._T('bloog:abonnement_mail')."</a></BODY></HTML>";
$pagehm .="\n\n\n--$boundary--\n end of the multi-part";

// fin du pied de page HTML


		$ok = mail($email,$objet,$pagehm,$headersh) ;
		
                }
			
                        
               $total_abo = $total_abo + 1;
	       if($ok) $cmpt=$cmpt + 1 ;
	       }      
               
               
               /* fin abo*/
	       

	}      /* fin while */
}      /* fin liste abonnées */

}/* flag pile*/

echo "retour";

?>
