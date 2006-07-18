<?php

include ("ecrire/inc_version.php3");

include_ecrire ("inc_meta.php3");
include_ecrire ("inc_session.php3");
include_ecrire ("inc_filtres.php3");
include_ecrire ("inc_texte.php3");
include_ecrire ("inc_meta.php3");
include_ecrire ("inc_mail.php3");
include_ecrire ("inc_acces.php3");

//utiliser_langue_site();
$nomsite=lire_meta("nom_site");
$urlsite=lire_meta("adresse_site");



// 3 Cas :  
// 1) La personne valide le formulaire de modif, traitement des données
// 2) Recuperer le cookie de relance désabonnement / afficher le forumlaire de modif
// 3) Envoyer par mail le cookie de relance modif abonnement
//presentation


 // La personne valide le formulaire

 // revoir le test ?
if($champs_extra AND ($confirm == 'oui') ){

$res = spip_query("SELECT * FROM spip_auteurs WHERE cookie_oubli='$d' AND statut<>'5poubelle' AND pass<>''");
   if ($row = spip_fetch_array($res)) {
    $id_auteur = $row['id_auteur'];
	$statut = $row['statut'];
	$nom = $row['nom'];
	$mail_abo = $row['email'];

    // abonnement aux listes
    //(http://www.phpfrance.com/tutorials/index.php?page=2&id=13)

//selectionne les listes et desabonne l'auteur
$listes = spip_query ("SELECT * FROM spip_articles WHERE statut = 'liste'");
while($row = spip_fetch_array($listes)) {
$id_liste = $row['id_article'] ;	
$query="DELETE FROM spip_auteurs_articles WHERE id_auteur='$id_auteur' AND id_article='$id_liste'";
$result=spip_query($query);
}

if(is_array($list)){

 // on abonne l'auteur aux listes choisies
 while( list(,$val) = each($list) ){
		
        $query="INSERT INTO spip_auteurs_articles (id_auteur,id_article) VALUES ('$id_auteur','$val')";
        $result=spip_query($query);
		
 }
} else { $desabo="oui"; }

// fin de l'abo  aux listes

 // prendre en compte les extras

   $extras = bloog_extra_recup_saisie('auteurs');

   spip_query("UPDATE spip_auteurs SET extra = '$extras' WHERE cookie_oubli ='$d'");
   spip_query("UPDATE spip_auteurs SET cookie_oubli = '0' WHERE cookie_oubli ='$d'");

   // affichage des modifs

   $extra = get_extra($id_auteur,'auteur');

   If ($extra['abo'] == 'non')  {
   bdebut_html(_T('spiplistes:desabonnement_valid'));
   echo"<h4>"._T('spiplistes:desabonnement_valid')."</h4>".$mail_abo."<br>\n";
   bfin_html();
   }
   else {
   bdebut_html(_T('spiplistes:abonnement_modifie'));
   echo"<h4>"._T('spiplistes:abonnement_modifie')."</h4>" ;



   // $message .= _T('spiplistes:mail_format', array('nom_site_spip' => $nom_site_spip))." : ".$GLOBALS['suppl_abo']."\n";
        $message = "";

        //SELECT des listes de l'abonné
        $query = "SELECT * FROM spip_auteurs_articles AS abonnements, spip_articles AS listes WHERE abonnements.id_auteur='$id_auteur' AND abonnements.id_article=listes.id_article AND listes.statut='liste'";
		$res = spip_query($query);

		 //lister les listes
         $nb_listes_abo = spip_num_rows($res);
         if($nb_listes_abo>0){
			while($row = spip_fetch_array($res)) {
			$id_article = $row['id_article'] ;
			$query = "SELECT * FROM spip_articles WHERE statut='liste' AND id_article=$id_article";
		    $result = spip_query($query);
				if(spip_num_rows($result)>0){
				$row = spip_fetch_array($result);
				$titre = $row['titre'] ;
				$message .= "<li>".$titre."</li>" ;
				}
			}
        echo "<ul>".$message."</ul>";
        }else{
       	//echo " vous n'êtes plus abonné aux lettres d'information" ;
        }
   echo"<p>"._T('spiplistes:abonnement_nouveau_format').$extra['abo']."<br>\n";
   bfin_html();
   }


   } else  {
           	bdebut_html(_T('pass_erreur_code_inconnu'));
           	echo _T('pass_erreur_code_inconnu');
           	bfin_html();
   }
}

// recuperer le cookie de relance désabonnement, et afficher le formulaire de modif
if ($d = addslashes($d) AND ($confirm != 'oui')) {

	$res = spip_query ("SELECT * FROM spip_auteurs WHERE cookie_oubli='$d' AND statut<>'5poubelle' AND pass<>''");
	if ($row = spip_fetch_array($res)) {
             $id_auteur = $row['id_auteur'];
			 $nom = $row['nom'];
			 $extra_aut = $row['extra'];

          //SELECT des listes de l'abonné
        
		$listes = spip_query ("SELECT * FROM spip_articles WHERE statut = 'liste' OR statut = 'inact'");
			while($row = spip_fetch_array($listes)) {
			$id_liste = $row['id_article'] ;	
			$query = "SELECT * FROM spip_auteurs_articles WHERE id_auteur=$id_auteur AND id_article=$id_liste";
			$res = spip_query($query);
			//lister les listes
            while($row2 = spip_fetch_array($res)) {
			$tab_articles[] = $row2['id_article'] ;
            }
            }   
             
		 if(!is_array($tab_articles)) { $desabo="oui"; }

         // permettre de modifier la valeur des champs d'abo .


         bdebut_html(_T('spiplistes:abonnement'));
         echo "[$nom]";
		 echo "<h4>"._T('spiplistes:abonnement')."</h4>"   ;
         echo "<form action='abonnement.php3' method='post'>";
         echo "<div style='text-align:left'>";

            	/***********/


            $list = spip_query ("SELECT * FROM spip_articles WHERE statut = 'liste' ");
			$nb_listes = spip_num_rows($list);
			if($nb_listes == 0){
			echo "<fieldset>";
			echo "<legend> Abonnement à la lettre d'information </legend>";
			}
			elseif($nb_listes == 1){
			echo "<fieldset>";
			echo "<legend> Abonnement à la lettre d'information </legend>";
			echo "<ul style='width:350px'>" ;
			while($row2 = spip_fetch_array($list)) {

			echo "<li>" ;
			$id_article = $row2['id_article'] ;
			$titre = $row2['titre'] ;


            echo "<div style='float:right'>"."<input type=\"checkbox\" name=\"list[]\" checked=\"checked\" value=\"".$id_article."\" />"."</div><a href='?liste=$id_article'>$titre</a>" ;
			echo "</li>" ;
			}
			echo "</ul>" ;
			}
			else{
			



            echo "<fieldset> ";
			echo "<legend> Abonnement aux listes de diffusion </legend>";
			echo "<ul style='width:350px'>" ;
			while($row3 = spip_fetch_array($list)) {

			echo "<li>" ;
			$id_article = $row3['id_article'] ;
			$titre = $row3['titre'] ;
			
                        //Gérer les CHECKED
                        if ($desabo != "oui"){
                         if (in_array ($id_article, $tab_articles)) {
                         $checked = "checked=\"checked\"";
                         }else{$checked = "";}
                         
                        }

            echo "<div style='float:right'>"."<input type=\"checkbox\" name=\"list[]\" ".$checked."  value=\"".$id_article."\" />"."</div><a href='?liste=$id_article' title='informations sur cette liste'>$titre</a>" ;
			echo "</li>" ;
			}
			echo "</ul>" ;


		    } // fin du test nb listes
		



               /**************/



         bloog_extra_saisie($extra_aut, 'auteurs', 'inscription');
	echo "<input type='submit' name='Valider' value='"._T('spiplistes:abonnement_bouton')."' />";
	echo "<input type='hidden' name='d'  value=$d  />";
	echo "<input type='hidden' name='confirm'  value='oui' />";
	echo "</fieldset> </div> </form>";
        bfin_html();

        }
	else
		{
           	bdebut_html(_T('pass_erreur_code_inconnu'));
           	echo _T('pass_erreur_code_inconnu');
           	bfin_html();
   }
}   else {

// envoyer le cookie de relance modif abonnement
if ($email_desabo) {
	if (email_valide($email_desabo)) {
		$email = addslashes($email_desabo);
		$res = spip_query("SELECT * FROM spip_auteurs WHERE email ='$email'");
		if ($row = spip_fetch_array($res)) {
			if ($row['statut'] == '5poubelle')
				$erreur = _T('pass_erreur_acces_refuse');
			else {
				$cookie = creer_uniqid();
				spip_query("UPDATE spip_auteurs SET cookie_oubli = '$cookie' WHERE email ='$email'");

				$message = _T('spiplistes:abonnement_mail_passcookie', array('nom_site_spip' => $nomsite, 'adresse_site' => $urlsite, 'cookie' => $cookie));
				if (envoyer_mail($email, "[$nomsite] "._T('spiplistes:abonnement_titre_mail'), $message))
					$erreur = _T('spiplistes:pass_recevoir_mail');
				else
					$erreur = _T('pass_erreur_probleme_technique');
			}
		}
		else
			$erreur = _T('pass_erreur_non_enregistre', array('email_oubli' => htmlspecialchars($email_desabo)));
	}
	else
		$erreur = _T('pass_erreur_non_valide', array('email_desabo' => htmlspecialchars($email_desabo)));
}

if($confirm != 'oui'){
	// debut presentation
        bdebut_html(_T('spiplistes:abonnement_change_format'));
        
        
          echo "<fieldset> ";
	echo "<legend>"._T('spiplistes:lettre_d_information')." </legend>";

        
        echo"<h4>"._T('spiplistes:abonnement_change_format', array('nom_site_spip' => $nomsite))."</h4>\n";


	if ($erreur)
		echo $erreur;
	else {
		echo _T('spiplistes:abonnement_texte_mail');

		echo "<form action='".$PHP_SELF."' method='post'>";
		echo "<div style='text-align:right'>";
		echo "<input type='text' class='fondo' name='email_desabo' value='' />";
		echo "<input type='hidden' name='desabo' value='oui' />";
		echo "<input type='submit' class='fondl' name='oubli' value='OK' /></div></form>";
	}

	echo "</fieldset> ";
      bfin_html();
}
}

function bdebut_html($titre = "") {
	global $couleur_foncee, $couleur_claire, $couleur_lien, $couleur_lien_off;
	global $flag_ecrire;
	global $spip_lang_rtl;

	$nom_site_spip = entites_html(lire_meta("nom_site"));
	$titre = textebrut(typo($titre));

	if (!$nom_site_spip) $nom_site_spip="SPIP";
	if (!$charset = lire_meta('charset')) $charset = 'utf-8';

	@Header("Expires: 0");
	@Header("Cache-Control: no-cache,no-store");
	@Header("Pragma: no-cache");
	@Header("Content-Type: text/html; charset=$charset");

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">';
	echo "<head>";
	echo "<title>[$nom_site_spip] $titre</title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=".$charset."' />";
	echo '

      <style type="text/css">
<!--

body {
	color:#000000;
	background-color:#F5F5F5;
}


.cadre {
	/*border: 1px #000000 solid;*/
	background-color:#FFFFFF;
        text-align: justify;
        width:500px;
        padding: 10px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 10px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

h1 {
 font-size: 150%;
 text-decoration: underline ;

}

.bloc {
 margin-top: 100px;
 padding: 10px;
 text-align: center;
}

.cdt{
  font-size:10px;
}

-->
</style>
  ';

	echo "</head><body ";
	if ($spip_lang_rtl)
		echo " dir='rtl'";
	echo "><div class='bloc'><h1>".$nom_site_spip."</h1><div class='cadre'>";
}

function bfin_html() {
 $urlsite=lire_meta("adresse_site");

	echo "</div><p><a href='".$urlsite."'>"._T('pass_retour_public')."</a></p><br /><div class='cdt'>"._T('spiplistes:abonnement_cdt')."</div></div></body></html>\n";

}

?>
