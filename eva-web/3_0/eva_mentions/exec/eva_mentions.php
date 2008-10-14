<?php
if (!defined('_DIR_PLUGIN_EVAMENTIONS')){
	$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(dirname(__FILE__)))));
	define('_DIR_PLUGIN_EVAMENTIONS',(_DIR_PLUGINS.end($p)));
}

	include_spip('base/db_mysql');
	include_spip('base/abstract_sql');
  	include_spip('inc/presentation');
  	#include_spip('action/eva_mentions_modif');  

#############
function exec_eva_mentions() {
	$bloc = 0;

  GLOBAL $connect_statut;
  if ($connect_statut != '0minirezo') {
    echo debut_page();
    echo _T('avis_non_acces_page');
    echo fin_page();
    exit;
  }
	
  $icone = _DIR_PLUGIN_EVAMENTIONS."/img_pack/petite_eva3.png";

  echo debut_page(_T('evamentions:eva_titre'));	 
  echo "<br />";
  echo gros_titre(_T('evamentions:gros_titre_page'));
   
debut_gauche();
	debut_boite_info();
	echo '<img src="'._DIR_PLUGIN_EVAMENTIONS.'/img_pack/eva3.png" border="0" alt="logo eva-web"><br/>';
        echo _T('evamentions:Gestion des mentions l&eacute;gales');
	echo '<br/><br/>';
  	echo _T('evamentions:siteoff1');
	echo _T('evamentions:lienoff1');
fin_boite_info();


debut_droite();

###gestion des mentions légales#############
debut_cadre_enfonce('', false, '', _T('evamentions:eva_mentions'));
        echo _T('evamentions:lcen');
        $etab = _request('etab2');
        $dir = _request('dir2');
        $resp = _request('resp2');
        $heb = _request('heb2');
        $adres = _request('adres2');
        $web = _request('web2');
        $qua = _request('qua2');
        $idweb = _request('idweb2');

$base_mentions = spip_abstract_select('*', 'eva_mentions');
$row_mentions = spip_fetch_array($base_mentions);

echo '<br />';

if (isset($etab) || isset($dir) || isset($resp) || isset($heb) || isset($adres) || isset($web) || isset($qua) || isset($idweb)){
	echo '<form>';
	echo _T('evamentions:etab').$etab."<br />";
        echo _T('evamentions:dir_pub').$dir."<br />";
	echo _T('evamentions:resp_edit').$resp."<br />";
	echo _T('evamentions:heb_site').$heb."<br />";
	echo _T('evamentions:adresse').$adres."<br />";
	echo _T('evamentions:webmestre').$web."<br/>";
	echo _T('evamentions:qualite').$qua."<br />";
        echo _T('evamentions:idweb').$idweb."<br /><br/>";
	//echo '<input type="submit" name ="editmentions" value="Editer les mentions" class="fondo">';
	echo '</form>';
	
	debut_cadre_trait_couleur();
	echo bouton_block_invisible($bloc);
   echo _T('evamentions:editer_mentions');
   echo debut_block_invisible($bloc);  	
	echo '<form method="post" action="'.generer_url_ecrire("eva_mentions").'">';
	echo '<p>';
	echo _T('evamentions:etab');
	echo "<input type='text' name='etab2' value='".$etab."'/><br />";
	echo _T('evamentions:dir_pub');
	echo "<input type='text' name='dir2' value='".$dir."'/><br />";
	echo _T('evamentions:resp_edit');
	echo "<input type='text' name='resp2' value='".$resp."'/><br />";
	echo _T('evamentions:heb_site');
	echo "<input type='text' name='heb2' value='".$heb."'/><br />";	
	echo _T('evamentions:adresse');
	echo "<input type='text' name='adres2' value='".$adres."'/><br />";
	echo _T('evamentions:webmestre');
	echo "<input type='text' name='web2' value='".$web."'/><br />";
	echo _T('evamentions:qualite');
	echo "<input type='text' name='qua2' value='".$qua."'/><br />";
	echo _T('evamentions:idweb');
	echo "<input type='text' name='idweb2' value='".$idweb."'/><br />";
        echo '<input type="submit" name ="modifmentions" value="Modifier les mentions" class="fondo">';
	echo '</p>';
	echo '</form>';

   if (_request('modifmentions')!=NULL){
		$etab = _request('etab2');
		$dir = _request('dir2');
		$resp = _request('resp2');
		$heb = _request('heb2');
		$adres = _request('adres2');
		$web = _request('web2');
		$qua = _request('qua2');
                $idweb = _request('idweb2');
		$rq_modif_mentions = "UPDATE eva_mentions SET etab='".$etab."',dir_pub='".$dir."',resp_edit='".$resp."',hebergeur='".$heb."',adresse='".$adres."',webmestre='".$web."',qualite='".$qua."',idweb='".$idweb."' WHERE id_mentions='1'";
		$resultat_modif_mentions = spip_query($rq_modif_mentions);
	   $message = '<br>Modification de la table effectu&eacute;e';
	}
	fin_block();
	fin_cadre_trait_couleur();
	}else{
//test de la présence et la version de la table eva_mentions			
#############################
if ($row_mentions == ''){
	echo _T('evamentions:pas_mentions');
	echo '<form method="post" action="'.generer_url_ecrire("eva_mentions").'">';
	echo '<input type="submit" name ="creertable" value="Cr&eacute;er la table" class="fondo">';
	echo '</form>';
		if (_request('creertable')!=NULL){	
		creer_mentions();
		}
        }else{
        if (!isset($row_mentions['version'])){
                echo '<fieldset>';
                echo "Mauvaise version de la table d'ebregistrement, il faut recr&eacute;er la table";
                echo '<form method="post" action="'.generer_url_ecrire("eva_mentions").'">';
        	echo '<input type="submit" name ="effacertable" value="Effacer puis recr&eacute;er la table" class="fondo">';
                echo '</form>';
                echo '</fieldset>';
        		if (_request('effacertable')!=NULL){	
        		effacer_table(1);
        		}
                }
        }
        echo '<br />';
  $requete_mentions = "SELECT * FROM eva_mentions LIMIT 1";
  $resultat_mentions = spip_query($requete_mentions);
  $nombre_mentions = spip_num_rows($resultat_mentions);
		
  if ($nombre_mentions > 0) {
	while ($row_mentions= spip_fetch_array($resultat_mentions)){
		$etab = $row_mentions["etab"];
		$dir = $row_mentions["dir_pub"];
		$resp = $row_mentions["resp_edit"];
		$heb = $row_mentions["hebergeur"];
		$adres = $row_mentions["adresse"];
		$web = $row_mentions["webmestre"];
		$qua = $row_mentions["qualite"];
                $idweb = $row_mentions["idweb"];
	}

	echo '<form>';
        echo _T('evamentions:etab').$etab."<br />";
        echo _T('evamentions:dir_pub').$dir."<br />";
	echo _T('evamentions:resp_edit').$resp."<br />";
	echo _T('evamentions:heb_site').$heb."<br />";
	echo _T('evamentions:adresse').$adres."<br />";
	echo _T('evamentions:webmestre').$web."<br/>";
	echo _T('evamentions:qualite').$qua."<br />";
        echo _T('evamentions:idweb').$idweb."<br /><br/>";
	//echo '<input type="submit" name ="editmentions" value="Editer les mentions" class="fondo">';
	echo '</form>';

debut_cadre_trait_couleur();
echo bouton_block_invisible($bloc);
   echo _T('evamentions:editer_mentions');
   echo debut_block_invisible($bloc);  	
	//if (_request('editmentions')!=NULL){

	echo '<form method="post" action="'.generer_url_ecrire("eva_mentions").'">';
	echo '<p>';
	echo _T('evamentions:etab');
	echo "<input type='text' name='etab2' value='".$etab."'/><br />";
	echo _T('evamentions:dir_pub');
	echo "<input type='text' name='dir2' value='".$dir."'/><br />";
	echo _T('evamentions:resp_edit');
	echo "<input type='text' name='resp2' value='".$resp."'/><br />";
	echo _T('evamentions:heb_site');
	echo "<input type='text' name='heb2' value='".$heb."'/><br />";	
	echo _T('evamentions:adresse');
	echo "<input type='text' name='adres2' value='".$adres."'/><br />";
	echo _T('evamentions:webmestre');
	echo "<input type='text' name='web2' value='".$web."'/><br />";
	echo _T('evamentions:qualite');
	echo "<input type='text' name='qua2' value='".$qua."'/><br />";
        echo _T('evamentions:idweb');
	echo "<input type='text' name='idweb2' value='".$idweb."'/><br />";
	echo '<input type="submit" name ="modifmentions" value="Modifier les mentions" class="fondo">';
	echo '</p>';
	echo '</form>';

   if (_request('modifmentions')!=NULL){
		$etab = _request('etab2');
		$dir = _request('dir2');
		$resp = _request('resp2');
		$heb = _request('heb2');
		$adres = _request('adres2');
		$web = _request('web2');
		$qua = _request('qua2');
                $idweb = _request('idweb2');
		$rq_modif_mentions = "UPDATE eva_mentions SET etab='".$etab."',dir_pub='".$dir."',resp_edit='".$resp."',hebergeur='".$heb."',adresse='".$adres."',webmestre='".$web."',qualite='".$qua."',idweb='".$idweb."' WHERE id_mentions='1'";
		$resultat_modif_mentions = spip_query($rq_modif_mentions);
	   $message = '<br>Modification de la table effectu&eacute;e';
	}
}
}
fin_block();
fin_cadre_trait_couleur();
fin_cadre_enfonce();
echo fin_gauche();
echo fin_page();
}
	
##################################################################################
#############################
function creer_mentions(){
   
    $requete_creertable ='CREATE TABLE IF NOT EXISTS eva_mentions
    (id_mentions INTEGER NOT NULL AUTO_INCREMENT,
    etab TEXT NOT NULL,
    dir_pub TEXT NOT NULL, 
    resp_edit TEXT NOT NULL,
    hebergeur TEXT NOT NULL,
    adresse TEXT NOT NULL,
    webmestre TEXT NOT NULL,
    qualite TEXT NOT NULL,
    idweb TINYINT(3) NOT NULL,
    version TINYINT(3) NOT NULL,
    PRIMARY KEY (id_mentions)
    )';
    
	$evadirpub = '';
	$evarespredac = '';
	$evahebsite = '';
	$evaeditsite = '';
	$evarefcharte = '';
    
	$resultat_creertable = spip_query($requete_creertable);
	$enregistrement1 = "INSERT INTO eva_mentions (etab,dir_pub,resp_edit,hebergeur,adresse,webmestre,qualite,idweb,version) VALUES ('ECOLE ou ETABLISSEMENT','A DEFINIR','A DEFINIR','A DEFINIR','A DEFINIR','A DEFINIR','A DEFINIR','1','1')";
   $resultat = spip_query($enregistrement1);
    
	echo _T('evamentions:table_creee');
}
####################
function lister_mentions() {

  $requete_mentions = "SELECT * FROM eva_mentions LIMIT 1";
  $resultat_mentions = spip_query($requete_mentions);
  $nombre_mentions = spip_num_rows($resultat_mentions);
		
  if ($nombre_mentions > 0) {
	while ($row_mentions= spip_fetch_array($resultat_mentions)){
        $etab = $row_mentions["etab"];
        $dir = $row_mentions["dir_pub"];
	$resp = $row_mentions["resp_edit"];
	$heb = $row_mentions["hebergeur"];
	$adres = $row_mentions["adresse"];
	$web = $row_mentions["webmestre"];
        $qua = $row_mentions["qualite"];
        $idweb = $row_mentions["idweb"];

	echo '<form method="post" action="'.generer_url_ecrire("eva_mentions").'">';
	echo _T('evamentions:etab').$etab."<br />";
        echo _T('evamentions:dir_pub').$dir."<br />";
	echo _T('evamentions:resp_edit').$resp."<br />";
	echo _T('evamentions:heb_site').$heb."<br />";
	echo _T('evamentions:adresse').$adres."<br />";
	echo _T('evamentions:webmestre').$web."<br/>";
	echo _T('evamentions:qualite').$qua."<br />";
        echo _T('evamentions:idweb').$idweb."<br/><br/>";
      	echo '<input type="submit" name ="editmentions" value="Editer les mentions" class="fondo">';
      	echo '</form>';
      }
	
	if (_request('editmentions')!=NULL){
           modif_mentions($etab,$dir,$resp,$heb,$adres,$web,$qua,$idweb);
	}

	}
	echo 'message = '.$message;
	echo 'Valeurs = '.$etab.$dir.$resp.$heb.$adres.$web.$qua.$idweb.'<br>';						

}
####################
function modif_mentions($etab,$dir,$resp,$heb,$adres,$web,$qua,$idweb) {

	echo '<form method="post" action="'.generer_url_ecrire("eva_mentions").'">';
	echo '<p>';
	echo _T('evamentions:etab');
	echo "<input type='text' name='etab2' value='".$etab."'/><br />";
	echo _T('evamentions:dir_pub');
	echo "<input type='text' name='dir2' value='".$dir."'/><br />";
	echo _T('evamentions:resp_edit');
	echo "<input type='text' name='resp2' value='".$resp."'/><br />";
	echo _T('evamentions:heb_site');
	echo "<input type='text' name='heb2' value='".$heb."'/><br />";	
	echo _T('evamentions:adresse');
	echo "<input type='text' name='adres2' value='".$adres."'/><br />";
	echo _T('evamentions:webmestre');
	echo "<input type='text' name='web2' value='".$web."'/><br />";
	echo _T('evamentions:qualite');
	echo "<input type='text' name='qua2' value='".$qua."'/><br />";
        echo _T('evamentions:idweb');
	echo "<input type='text' name='idweb2' value='".$idweb."'/><br />";
	echo '<input type="submit" name ="modifmentions" value="Modifier les mentions" class="fondo">';
	echo '</p>';
	echo '</form>';

        if (_request('modifmentions')!=NULL){
		$etab = _request('etab2');
		$dir = _request('dir2');
		$resp = _request('resp2');
		$heb = _request('heb2');
		$adres = _request('adres2');
		$web = _request('web2');
		$qua = _request('qua2');
                $idweb = _request('idweb2');
           //echo 'Valeurs = '.$dir.$resp.$heb.$edit.$ref.'<br>';
		update_mentions($etab,$dir,$resp,$heb,$adres,$web,$qua,$idweb);

	}

}
###############################
function update_mentions($etab,$dir,$resp,$heb,$adres,$web,$qua,$idweb){
	$rq_modif_mentions = "UPDATE eva_mentions SET etab='".$etab."', dir_pub='".$dir."', resp_edit='".$resp."', hebergeur='".$heb."', adresse='".$adres."', webmestre='".$web."', qualite='".$qua."',idweb='".$idweb."'
		 	WHERE id_mentions='1'";
	   $resultat_modif_mentions = spip_query($rq_modif_mentions);
	   
	   echo '<br>Modification de la table effectu&eacute;e';
	   $message = 'Modification de la table effectu&eacute;e';

}
###############################
function effacer_table($recreer) {
    $requete_efftable = 'DROP TABLE eva_mentions';
    spip_query($requete_efftable);
echo _T('evamentions:La table eva_mentions est supprimée<br />');
        if ($recreer == 1){
                creer_mentions();
        }
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
