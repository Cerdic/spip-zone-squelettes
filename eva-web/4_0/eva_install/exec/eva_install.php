<?php
if (!defined('_DIR_PLUGIN_EVAINSTALL')){
	$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(dirname(__FILE__)))));
	define('_DIR_PLUGIN_EVAINSTALL',(_DIR_PLUGINS.end($p)));
}

	include_spip('base/db_mysql');
	include_spip('base/abstract_sql');
  	include_spip('inc/presentation');
	include_spip('inc/vieilles_defs');
  	#include_spip('action/eva_mentions_modif');  

function exec_eva_install() {
	$bloc = 0;

  GLOBAL $connect_statut;
  if ($GLOBALS['connect_statut'] != "0minirezo" OR !$GLOBALS["connect_toutes_rubriques"]) {
    echo debut_page();
    echo _T('avis_non_acces_page');
    echo fin_page();
    exit;
  }
	
  $icone = _DIR_PLUGIN_EVAINSTALL."/img_pack/petite_eva3.png";


$commencer_page = charger_fonction('commencer_page', 'inc');
echo $commencer_page(_T('evainstall:eva_titre') , '', '', '');
echo gros_titre(_T('evainstall:gros_titre_page'),'',false);

	echo debut_gauche("",true);
	echo debut_boite_info(true);
	echo '<img src="'._DIR_PLUGIN_EVAINSTALL.'/img_pack/eva3.png" border="0" alt="logo eva-web">';
	echo '<img src="'._DIR_PLUGIN_EVAINSTALL.'/img_pack/install.png" border="0" alt="logo eva_install"><br/>';
        echo _T('evainstall:Gestion des mots-cl&eacute;s');
	echo '<br/><br/>';
  	echo _T('evainstall:siteoff1');
	echo _T('evainstall:lienoff1');
	echo fin_boite_info(true);


echo debut_droite("",true);

###########################################################################
	echo debut_cadre_enfonce('', true,'', _T('evainstall:groupes_eva'));
	

###stockage, affichage des id des groupes#############
	
	if (_request('creeraff')!=NULL){	
		crea_groupe('affichage','Modifie la pr&eacute;sentation du contenu');		
	}
	if (_request('creeract')!=NULL){
		crea_groupe('activites','Permet de transformer un article en une activit&eacute;');		
		#crea_mots2($nbrgrpact,$grp2_activites,$id_act,'activites');
	}
	
	lister_groupes();
   $table_grp = 'spip_groupes_mots';
   $champ_grp = 'titre';
   $resultat_act = sql_select('id_groupe',$table_grp,"titre='activites' LIMIT 1");
   $resultat_aff = sql_select('id_groupe',$table_grp,"titre='affichage' LIMIT 1");   
   $test_act = sql_count($resultat_act);
   $test_aff = sql_count($resultat_aff);

$grp2_activites = array(
	"jclic" => "Transforme un article en activit&eacute; jclic", 
	"livre" => "Transforme une rubrique en livre",
	"couverture-livre" => "Article servant de couverture au livre",	
	"geometrie" => "Transforme un article en activit&eacute; de g&eacute;om&eacute;trie dynamique",
	"album" => "Transforme une rubrique et tous les articles quelle contient en livre-album",
	"podcast" => "Permet de publier un fichier comme podcast");

$grp2_affichage = array(
	"agenda" => "Afficher une rubrique sous forme d'agenda",
	"article1" => "Afficher un article en haut de liste dans un cadre diff&eacute;rent en permanence dans une page rubrique",
	"calendrier" => "Afficher une rubrique sous forme de calendrier",
	"editorial" => "Afficher un article en haut de liste dans un cadre diff&eacute;rent en permanence dans la page d'accueil",
	"logo-bloc" => "Afficher le logo d'un site r&eacute;renc&eacute; dans un bloc dans la page d'accueil",
	"logo-pied" => "Afficher le logo d'un site r&eacute;renc&eacute; dans le pied de page de la page d'accueil",
	"portfolio" => "Transformer les images jointes à un article en portfolio",
	"diaporama" => "Pr&eacute;sente les documents joints aux rubriques et articles sous forme de diaporama avec pagination et m&eacute;thode AJAX",
	"mentions" => "Permet d'ajouter des mentions l&eacute;gales personnalis&eacute;es",	
	"lien-haut" => "Placer un lien dans la ligne de lien tout en haut de la page",
        "mini-calendrier" => "Ajoute un rep&egrave;re dans le mini-calendrier",
	"excluredusommaire" => "Supprime de la page de sommaire les &eacute;l&eacute;ments (articles, sites, ...) ayant ce mot cl&eacute;",
	"excluredumenu" => "Supprime du menu de navigation les rubriques concern&eacute;es par ce mot cl&eacute;"),
	"exclureduplan" => "Supprime du plan du site les rubriques concern&eacute;es par ce mot cl&eacute;");

$nbrgrpact = count($grp2_activites);
$nbrgrpaff = count($grp2_affichage);

$resultat_act2 = sql_select('id_groupe',$table_grp,"titre='activites' LIMIT 1");
	while ($tab_act = sql_fetch($resultat_act2)){
		$id_act = $tab_act['id_groupe'];	
	}

$resultat_aff2 = sql_select('id_groupe',$table_grp,"titre='affichage' LIMIT 1");
	while ($tab_aff = sql_fetch($resultat_aff2)){
		$id_aff = $tab_aff['id_groupe'];	
	}

                                
	if ($test_act == 0){
	echo _T('evainstall:groupe_act_non');
	echo '<form method="POST" action="'.generer_url_ecrire("eva_install").'">';
	echo "<input type='submit' name='creeract' value='"._T('evainstall:creer_groupe_act')."' class='fondo'>";
	echo "</form>";
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
	}
        #else{
        #test_mots($nbrgrpaff,$id_aff,'affichage');
        #crea_mots2($nbrgrpaff,$grp2_affichage,$id_aff,'affichage');
        #}
        
echo fin_cadre_enfonce(true);

echo debut_cadre_enfonce('', true, '', _T('evainstall:Liste_mots_activites'));
	if (_request('creermots')!=NULL){	
		crea_mots2($nbrgrpact,$grp2_activites,$id_act,'activites');
	}
	$manque=test_mots($nbrgrpact,$id_act,'activites');

        echo 'Il manque '.$manque.' mots-cl&eacute;s<br/>';
        
	if ($manque <> 0) {
	#echo _T('evainstall:pas_mots_cle');
	echo '<form method="POST" action="'.generer_url_ecrire("eva_install").'">';
	echo "<input type='submit' name='creermots' value='"._T('evainstall:creer_mots')."' class='fondo'>";
	echo "</form>";
	}
        else
        {        
        lister_mots ($id_act,'activites');
        }
echo fin_cadre_enfonce(true);

echo debut_cadre_enfonce('', true, '', _T('evainstall:Liste_mots_affichage'));


	if (_request('creermotsaff')!=NULL){
		crea_mots2($nbrgrpaff,$grp2_affichage,$id_aff,'affichage');
		#echo 'id aff ='.$id_aff.'<br/>';
	}

	$manque2= test_mots($nbrgrpaff,$id_aff,'affichage');
        echo 'Il manque '.$manque2.' mots-cl&eacute;s<br/>';
        
        if ($manque2 < 0) {
        echo 'Il semble qu\'il y a plus de mot que pr&eacute;vu dans ce groupe.<br/>';
        lister_mots ($id_aff,'affichage');
        }
        elseif ($manque2 > 0) {
	#echo _T('evainstall:pas_mots_cle');
	echo '<form method="POST" action="'.generer_url_ecrire("eva_install").'">';
	echo "<input type='submit' name='creermotsaff' value='"._T('evainstall:creer_mots')."' class='fondo'>";
	echo "</form>";
		
	}
        else
        {
        lister_mots ($id_aff,'affichage');
        }
echo fin_cadre_enfonce(true);


echo fin_gauche();
echo fin_page();
}
	
##################################################################################
#############################
function crea_groupe($groupe,$descriptif){
	$resultatgrp = sql_insertq('spip_groupes_mots',array('titre'=>$groupe,'tables_liees'=>'articles,breves,rubriques,syndic,','descriptif'=>$descriptif,'unseul'=>'non','obligatoire'=>'non','minirezo'=>'oui','comite'=>'oui','forum'=>'non'));
	echo '<br>Le groupe '.$groupe.' vient d\'etre cr&eacute;&eacute;<br>';
}
####################
function lister_groupes() {

	$table = 'spip_groupes_mots';
	$champ = 'titre';
   $resultat1 = sql_select('*',$table,"titre='activites' OR titre='affichage'");
   $nombre = sql_count($resultat1);
	
	if ($nombre < 1) {
	echo _T('evainstall:pas_groupe');

	}else
	echo "Il existe ".$nombre." groupes de mots-cl&eacute;s EVA :</br>";
	
	for($i=0;$i<$nombre;$i+1)
    {
		   while ($row = sql_fetch($resultat1))
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
echo 'Cr&eacute;ation des mots-cl&eacute;s du groupe '.$groupe.' num&eacute;ro '.$id.'<br/>';

$resultat_req = sql_select('titre','spip_mots',"id_groupe='".$id."'");
$nb_req = sql_count($resultat_req);
    
  if ($nb_req <> $nbr){
	echo "<br/>Nombre de mots-cl&eacute;s dans le groupe ".$groupe." cr&eacute;es : ".$nbr."<br/>";

    foreach ($grp2 as $motcle => $descriptifmot) {
        #echo "Mot cl&eacute; : $motcle_act => Descriptif : $descriptifmot_act<br>";
        $resultreq=sql_select('titre,id_groupe','spip_mots',"titre='".$motcle."'");
        $nbreq = sql_count($resultreq);
        $row= sql_fetch($resultreq);
        #echo 'nbreq = '.$nbreq.'<br/>';
        #echo 'row titre = '.$row["titre"].'<br/>';
        #echo 'row id groupe = '.$row["id_groupe"].'<br/>';
        
                if ($nbreq == 0){
                        $ajout_mot = sql_insertq('spip_mots',array('titre'=>$motcle,'descriptif'=>$descriptifmot,'id_groupe'=>$id));
                }
                elseif ($row["id_groupe"]<>$id){
                        echo $motcle.' existe d&eacute;j&agrave; <br>';
                        echo 'Je le d&eacute;place dans le groupe '.$groupe.'<br>';
                        sql_updateq('spip_mots',array('id_groupe'=>$id,'descriptif'=>$descriptifmot),"titre = '".$motcle."'");
                }
    }
  }
}
####################
function test_mots($nb,$id,$groupe){

#echo 'nb = '.$nb.'<br/>';
#echo 'id = '.$id.'<br/>';
#echo 'groupe = '.$groupe.'<br/>';

$resultat = sql_select('titre','spip_mots',"id_groupe='".$id."'");
$nb_req = sql_count($resultat);

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

	$resultat2 = sql_select('*','spip_mots',"id_groupe='".$id."'");
	$nombre2 = sql_count($resultat2);
	
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
		while ($row = sql_fetch($resultat2)){
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
