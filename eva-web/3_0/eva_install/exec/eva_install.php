<?php
if (!defined('_DIR_PLUGIN_EVAINSTALL')){
	$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(dirname(__FILE__)))));
	define('_DIR_PLUGIN_EVAINSTALL',(_DIR_PLUGINS.end($p)));
}

	include_spip('base/db_mysql');
	include_spip('base/abstract_sql');
  	include_spip('inc/presentation');
  	#include_spip('action/eva_mentions_modif');  

function exec_eva_install() {
	$bloc = 0;

  GLOBAL $connect_statut;
  if ($connect_statut != '0minirezo') {
    echo debut_page();
    echo _T('avis_non_acces_page');
    echo fin_page();
    exit;
  }
	
  $icone = _DIR_PLUGIN_EVAINSTALL."/img_pack/petite_eva3.png";

  echo debut_page(_T('evainstall:eva_titre'));	 
  echo "<br />";
  echo gros_titre(_T('evainstall:gros_titre_page'));
   
debut_gauche();
	debut_boite_info();
	echo '<img src="'._DIR_PLUGIN_EVAINSTALL.'/img_pack/eva3.png" border="0" alt="logo eva-web">';
	echo '<img src="'._DIR_PLUGIN_EVAINSTALL.'/img_pack/install.png" border="0" alt="logo eva_install"><br/>';
        echo _T('evainstall:Gestion des mots-cl&eacute;s');
	echo '<br/><br/>';
  	echo _T('evainstall:siteoff1');
	echo _T('evainstall:lienoff1');
fin_boite_info();


debut_droite();

###########################################################################
debut_cadre_enfonce('', false, '', _T('evainstall:groupes_eva'));
	lister_groupes();

###stockage, affichage des id des groupes#############
	
   $table_grp = 'spip_groupes_mots';
   $champ_grp = 'titre';
   $requete_act = "SELECT id_groupe FROM ".$table_grp." WHERE  titre='activites' LIMIT 1";
   $requete_aff = "SELECT id_groupe FROM ".$table_grp." WHERE  titre='affichage' LIMIT 1";
   $resultat_act = spip_query($requete_act);
   $resultat_aff = spip_query($requete_aff);   
   $test_act = spip_num_rows($resultat_act);
   $test_aff = spip_num_rows($resultat_aff);

$grp2_activites = array("jclic" => "Transforme un article en activit&eacute; jclic", 
	"livre" => "Transforme une rubrique en livre",
	"couverture-livre" => "Article servant de couverture au livre",	
	"geometrie" => "Transforme un article en activit&eacute; de g&eacute;om&eacute;trie dynamique",
	"album" => "Transforme une rubrique et tous les articles quelle contient en livre-album",
	"podcast" => "Permet de publier un fichier comme podcast");

$grp2_affichage = array("agenda" => "Afficher une rubrique sous forme d\'agenda",
	"article1" => "Afficher un article en haut de liste dans un cadre diff&eacute;rent en permanence dans une page rubrique",
	"calendrier" => "Afficher une rubrique sous forme de calendrier",
	"editorial" => "Afficher un article en haut de liste dans un cadre diff&eacute;rent en permanence dans la page d\'accueil",
	"logo-bloc" => "Afficher le logo d\'un site r&eacute;renc&eacute; dans un bloc dans la page d\'accueil",
	"logo-pied" => "Afficher le logo d\'un site r&eacute;renc&eacute; dans le pied de page de la page d\'accueil",
	"portfolio" => "Transformer les images jointes à un article en portfolio",
	"mentions" => "Permet d\'ajouter des mentions l&eacute;gales personnalis&eacute;es",	
	"lien-haut" => "Placer un lien dans la ligne de lien tout en haut de la page",
        "mini-calendrier" => "Ajoute un repère dans le mini-calendrier");

$nbrgrpact = count($grp2_activites);
$nbrgrpaff = count($grp2_affichage);

$requete_act2 = "SELECT id_groupe FROM ".$table_grp." WHERE  titre='activites' LIMIT 1";
$resultat_act2 = spip_query($requete_act2);
	while ($tab_act = spip_fetch_array($resultat_act2)){
		$id_act = $tab_act['id_groupe'];	
	}

$requete_aff2 = "SELECT id_groupe FROM ".$table_grp." WHERE  titre='affichage' LIMIT 1";
$resultat_aff2 = spip_query($requete_aff2);
	while ($tab_aff = spip_fetch_array($resultat_aff2)){
		$id_aff = $tab_aff['id_groupe'];	
	}

                                
	if ($test_act == 0){
	echo _T('evainstall:groupe_act_non');
	echo '<form method="POST" action="'.generer_url_ecrire("eva_install").'">';
	echo "<input type='submit' name='creeract' value='"._T('evainstall:creer_groupe_act')."' class='fondo'>";
	echo "</form>";
		if (_request('creeract')!=NULL){
			crea_groupe('activites','Permet de transformer un article en une activit&eacute;');		
                        #crea_mots2($nbrgrpact,$grp2_activites,$id_act,'activites');
		}
	}
        #else{
        #test_mots($nbrgrpact,$id_act,'activites');
        #}
	
	if ($test_aff == 0){
	echo _T('evainstall:groupe_aff_non');
	echo '<form method="POST" action="'.generer_url_ecrire("eva_install").'">';
	echo "<input type='submit' name='creeraff' value='"._T('evainstall:creer_groupe_aff')."' class='fondo'>";
	echo "</form>";
	echo "<br>";	
		if (_request('creeraff')!=NULL){	
			crea_groupe('affichage','Modifie la pr&eacute;sentation du contenu');		
                }
	}
        #else{
        #test_mots($nbrgrpaff,$id_aff,'affichage');
        #crea_mots2($nbrgrpaff,$grp2_affichage,$id_aff,'affichage');
        #}
        
fin_cadre_enfonce();

debut_cadre_enfonce('', false, '', _T('evainstall:Liste_mots_activites'));
	$manque=test_mots($nbrgrpact,$id_act,'activites');

        echo 'il manque '.$manque.' mots-clés<br/>';
        
	if ($manque <> 0) {
	#echo _T('evainstall:pas_mots_cle');
	echo '<form method="POST" action="'.generer_url_ecrire("eva_install").'">';
	echo "<input type='submit' name='creermots' value='"._T('evainstall:creer_mots')."' class='fondo'>";
	echo "</form>";
		if (_request('creermots')!=NULL){	
		    crea_mots2($nbrgrpact,$grp2_activites,$id_act,'activites');
		}
	}
        else
        {        
        lister_mots ($id_act,'activites');
        }
fin_cadre_enfonce();

debut_cadre_enfonce('', false, '', _T('evainstall:Liste_mots_affichage'));
	$manque2= test_mots($nbrgrpaff,$id_aff,'affichage');
        echo 'il manque '.$manque2.' mots-clés<br/>';
        
        if ($manque2 < 0) {
        echo 'Il semble qu\'il y a plus de mot que prévu dans ce groupe.<br/>';
        lister_mots ($id_aff,'affichage');
        }
        elseif ($manque2 > 0) {
	#echo _T('evainstall:pas_mots_cle');
	echo '<form method="POST" action="'.generer_url_ecrire("eva_install").'">';
	echo "<input type='submit' name='creermotsaff' value='"._T('evainstall:creer_mots')."' class='fondo'>";
	echo "</form>";
		if (_request('creermotsaff')!=NULL){
		    crea_mots2($nbrgrpaff,$grp2_affichage,$id_aff,'affichage');
		    #echo 'id aff ='.$id_aff.'<br/>';
		}
	}
        else
        {
        lister_mots ($id_aff,'affichage');
        }
fin_cadre_enfonce();


echo fin_gauche();
echo fin_page();
}
	
##################################################################################
#############################
function crea_groupe($groupe,$descriptif){
	$ajoutgrp = "INSERT INTO spip_groupes_mots (titre,descriptif,unseul,obligatoire,articles,breves,rubriques,syndic,minirezo,comite,forum) VALUES ('".$groupe."','".$descriptif."','non','non','oui','oui','oui','oui','oui','oui','non')";
	$resultatgrp = spip_query($ajoutgrp);
	echo '<br>Le groupe '.$groupe.' vient d\'etre cr&eacute;&eacute;<br>';
}
####################
function lister_groupes() {

	$table = 'spip_groupes_mots';
	$champ = 'titre';
   $requete = "SELECT * FROM ".$table." WHERE titre='activites' OR titre='affichage'";
   $resultat1 = spip_query($requete);
   $nombre = spip_num_rows($resultat1);
	
	if ($nombre < 1) {
	echo _T('evainstall:pas_groupe');

	}else
	echo "Il existe ".$nombre." groupes de mots-cl&eacute;s EVA :</br>";
	
	for($i=0;$i<$nombre;$i+1)
    {
		   while ($row = spip_fetch_array($resultat1))
	    {

	echo '<p>';
	echo _T('evainstall:groupe_titre').$row["titre"].'<br/>';
	echo _T('evainstall:groupe_num').$row["id_groupe"].'<br/>';
	echo _T('evainstall:groupe_descriptif').$row["descriptif"].'<br/>';
	echo '<a href=?exec=mots_type&id_groupe='.$row["id_groupe"].' class="fondo">Modifier ce groupe</a>';
	echo '</p>';

	    }
	    $i++;
	}
}
####################
function crea_mots2 ($nbr,$grp2,$id,$groupe){
#echo 'Dans la fonction, id = '.$id.'<br/>';

#echo "<br/>-----------------------------------<br/>";

#echo "Valeur de id du groupe =".$id."<br/>";
echo 'Cr&eacute;ation des mots-cl&eacute;s du groupe '.$groupe.' num. '.$id.'<br/>';

$requete = "SELECT titre FROM spip_mots WHERE id_groupe='".$id."'";
$resultat_req = spip_query($requete);
$nb_req = spip_num_rows($resultat_req);
    
  if ($nb_req <> $nbr){
	echo "<br/>Nombre de mots-cl&eacute;s dans le groupe ".$groupe." cr&eacute;es : ".$nbr."<br/>";

    foreach ($grp2 as $motcle => $descriptifmot) {
        #echo "Mot cl&eacute; : $motcle_act => Descriptif : $descriptifmot_act<br>";
        $req="SELECT titre,id_groupe FROM spip_mots WHERE titre='".$motcle."'";
        $resultreq=spip_query($req);
        $nbreq = spip_num_rows($resultreq);
        $row= spip_fetch_array($resultreq);
        #echo 'nbreq = '.$nbreq.'<br/>';
        #echo 'row titre = '.$row["titre"].'<br/>';
        #echo 'row id groupe = '.$row["id_groupe"].'<br/>';
        
                if ($nbreq == 0){
                        $ajout_mot = "INSERT INTO spip_mots (titre,descriptif,id_groupe,type,idx) VALUES ('".$motcle."','".$descriptifmot."','".$id."','".$groupe."','oui')";
                        $resultat = spip_query($ajout_mot);
                }
                elseif ($row["id_groupe"]<>$id){
                        echo $motcle.' existe d&eacute;ja <br>';
                        echo 'Je le d&eacute;place dans le groupe '.$groupe.'<br>';
                        $modif = "UPDATE spip_mots SET id_groupe='".$id."', type='".$groupe."', descriptif='".$descriptifmot."' WHERE titre='".$motcle."'";
                        $req_modif = spip_query($modif);
                }
    }
  }
}
####################
function test_mots($nb,$id,$groupe){

#echo 'nb = '.$nb.'<br/>';
#echo 'id = '.$id.'<br/>';
#echo 'groupe = '.$groupe.'<br/>';

$requete = "SELECT titre FROM spip_mots WHERE id_groupe='".$id."'";
$resultat = spip_query($requete);
$nb_req = spip_num_rows($resultat);

#echo 'nombre trouve pour '.$groupe.'= '.$nb_req.'<br>';

$manque=$nb-$nb_req;
#if ($nb_req <> $nb ){
#        echo 'il n\'y a pas le bon nombre de mots-clés.<br/>';
#        echo 'il manque '.$etat.' mots-clés<br/>';
#        return $etat;
#}else{
#        echo 'C\'est OK.<br/>';
        return $manque;
#        }
#echo '----------------------------<br/>';
}
####################
function lister_mots($id,$groupe) {

	$requete2 = "SELECT * FROM spip_mots WHERE type='".$groupe."'";
	$resultat2 = spip_query($requete2);
	$nombre2 = spip_num_rows($resultat2);
	
	#if ($nombre2 == 0) {
	#echo _T('evainstall:pas_mots_cle');
	#echo '<form method="POST" action="'.generer_url_ecrire("eva_install").'">';
	#echo "<input type='submit' name='creermots' value='"._T('evainstall:creer_mots de ce groupe')."' class='fondo'>";
	#echo "</form>";
	#	if (_request('creermots')!=NULL){	
	#	    crea_mots2 ($nbr,$grp2,$id,$groupe);
	#	    echo $id;
	#	}
	#return;
	#}
        #else
        #{
	echo "Voici les ".$nombre2." mots-cl&eacute;s du groupe ".$groupe." :</br>";
	
	for($i=0;$i<$nombre2;$i++){
		while ($row = spip_fetch_array($resultat2)){
			echo '<p>';
			echo _T('evainstall:mot_titre').$row["titre"].'<br/>';
			echo _T('evainstall:mot_descriptif').$row["descriptif"].'<br/>';
			echo '<a href=?exec=mots_edit&id_mot='.$row["id_mot"].' class="fondo">Modifier ce mot</a>';
			echo '</p>';
	    }
	    #$i++;
	}
#}
}

###############################
function verif_url($url) {
  $motif_url = "/^(http:\/\/)(w{0}|{3})\.?[a-zA-Z0-9._-]
    +\.+[a-zA-Z]{2,3}\$/i";
  if (!preg_match($motif_url, $url)) 
  {
  return false;
  }else
  { return true;}
} 
####################
function filtrer_mot($name){
//permet de filtrer tout ce qui n'est pas un mot (caractÃ¨res alphanumÃ©riques).
	if($_REQUEST[$name]==eregi_replace('[^a-z0-9_]', '', $_REQUEST[$name])) {
		return ('ok');
	}else{
	return ('non');
	}
}

?>
