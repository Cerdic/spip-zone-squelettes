<?php
/******************************************************************************************/
/* La bloOgletter est un système de gestion de listes d'information par email pour SPIP   */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique Générale GNU publiée par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU  */
/* pour plus de détails.                                                                  */
/*                                                                                        */
/* Vous devez avoir reçu une copie de la Licence Publique Générale GNU                    */
/* en même temps que ce programme ; si ce n'est pas le cas, écrivez à la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, États-Unis.                   */
/******************************************************************************************/


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


if($champs_extra AND ($confirm == 'oui') ){

$res = spip_query("SELECT * FROM spip_auteurs WHERE cookie_oubli='$d' AND statut<>'5poubelle' AND pass<>''");
   if ($row = spip_fetch_array($res)) {

   $extras = bloog_extra_recup_saisie('auteurs');

   spip_query("UPDATE spip_auteurs SET extra = '$extras' WHERE cookie_oubli ='$d'");
   spip_query("UPDATE spip_auteurs SET cookie_oubli = '0' WHERE cookie_oubli ='$d'");
   
   
   $extra = get_extra($row['id_auteur'],'auteur');
   
   If ($extra['abo'] == 'non')  {
   bdebut_html(_T('bloog:desabonnement_valid'));
   echo"<h4>"._T('bloog:desabonnement_valid')."</h4>".$row['email']."<br>\n";
   bfin_html();
   }
   else {
   bdebut_html(_T('bloog:abonnement_modifie'));
   echo"<h4>"._T('bloog:abonnement_modifie')."</h4><p>"._T('bloog:abonnement_nouveau_format').$extra['abo']."<br>\n";
   bfin_html();
   }


   } else  {
           	bdebut_html(_T('pass_erreur_code_inconnu'));
           	echo _T('pass_erreur_code_inconnu');
           	bfin_html();
   }
}

// recuperer le cookie de relance désabonnement
if ($d = addslashes($d) AND ($confirm != 'oui')) {

	$res = spip_query ("SELECT * FROM spip_auteurs WHERE cookie_oubli='$d' AND statut<>'5poubelle' AND pass<>''");
	if ($row = spip_fetch_array($res)) {

         // Modifier la valeur du champs .

		 
         bdebut_html(_T('bloog:abonnement'));
         echo "[".$row['nom']."]";
		 echo "<h4>"._T('bloog:abonnement')."</h4>"   ;
         echo"<form action='abonnement.php3' method='post'>";
         echo"<p align='center'>";
         bloog_extra_saisie($row['extra'], 'auteurs', 'inscription');
         echo"<input type='submit' name='Valider' value='"._T('bloog:abonnement_bouton')."'>";
         echo"<input type='hidden' name='d'  value=$d >";
         echo"<input type='hidden' name='confirm'  value='oui' >";
         echo"</p>";
         echo"</form>";
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

				$message = _T('bloog:abonnement_mail_passcookie', array('nom_site_spip' => $nomsite, 'adresse_site' => $urlsite, 'cookie' => $cookie));
				if (envoyer_mail($email, "[$nomsite] "._T('bloog:abonnement_titre_mail'), $message))
					$erreur = _T('bloog:pass_recevoir_mail');
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
        bdebut_html(_T('bloog:abonnement_change_format'));
        echo"["._T('bloog:lettre_d_information')."]";
		echo"<h4>"._T('bloog:abonnement_change_format', array('nom_site_spip' => $nomsite))."</h4>\n";
	
	echo "<p>";
	if ($erreur)
		echo $erreur;
	else {
		echo _T('bloog:abonnement_texte_mail');

		echo "<p>";
		echo "<form action='".$PHP_SELF."' method='post'>";
		echo "<div align='right'>";
		echo "<input type='text' class='fondo' name='email_desabo' value=''>";
		echo "<input type='hidden' name='desabo' value='oui'>";
		echo "<input type=submit class='fondl' name='oubli' value='OK'></div></form>";

	}
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

	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n<head>\n<html>\n<title>[$nom_site_spip] $titre</title>\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'">';
	echo '
      
      <style>
<!--

.cadre {
	border: 1px #000000 solid;
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
      
	echo "</head><body text='#000000' bgcolor='#e4e4e4' ";
	if ($spip_lang_rtl)
		echo " dir='rtl'";
	echo "><div class='bloc'><h1>".$nom_site_spip."</h1><div class='cadre' align='center' >";
}

function bfin_html() {
 $urlsite=lire_meta("adresse_site");

	echo "</div><p><a href='".$urlsite."'>"._T('pass_retour_public')."</a></p><br><div class='cdt'>"._T('bloog:desabonnement_cdt')."</div></div></body></html>\n";

}

?>
