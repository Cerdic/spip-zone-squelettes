<?php

/***************************************************************************\
 *                                                                         *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/config');
include_spip('inc/presentation');
include_spip('inc/layer');

function BlipConfig_afficher_config_courante () {
    if ($res = spip_query("SELECT id_config, titre, texte, type, descriptif, ordre, actif FROM blip_config ORDER BY ordre")) {
        $compte = spip_num_rows($res);
        $index = 1;
        while ($elements = spip_fetch_array($res, SPIP_ASSOC)) {
//            print_r($elements);
//            foreach ($elements as $v) {
//                echo $v." ";
//            }
            $s = "";
//       		$s .= bouton_block_invisible($elements['id_config']);
//       		if (! file_exists(getcwd().'/'._DIR_PLUGINS.'blipconfig/ecrire/img_pack/rien-16.png')) {
//       		    echo "pas de fichier à ".getcwd().'/'._DIR_PLUGINS."blipconfig/ecrire/img_pack/rien-16.png";
//       		}
            if ($index != $compte) {
                $s .= " <a href='".generer_url_ecrire('BlipConfig_config',"action=descendre&id=".$elements['id_config'])."'><img src='"._DIR_IMG_PACK."descendre-16.png' style='border:0'></a>";
       		} else {
       		    $s .= ' <img src="'._DIR_PLUGINS.'blipconfig/ecrire/img_pack/rien-16.png" />';
            }
       		if ($index != 1) {
       		    $s .= " <a href='".generer_url_ecrire('BlipConfig_config',"action=monter&id=".$elements['id_config'])."'><img src='"._DIR_IMG_PACK."monter-16.png' style='border:0'></a>";
       		} else {
       		    $s .= ' <img src="'._DIR_PLUGINS.'blipconfig/ecrire/img_pack/rien-16.png" />';
       		}
            $s .= " <a href='".generer_url_ecrire('BlipConfig_config',"action=supprimer&id=".$elements['id_config'])."'><img src='"._DIR_IMG_PACK."poubelle.gif' style='border:0'></a>";
//            $s .= " - ";
       		$s .= "<a href='".generer_url_ecrire('BlipConfig_config',"action=editer&id=".$elements['id_config'])."'>";
       		$s .= " "._T('bouton_modifier')." ";
       		$s .= "</a>";
   		    $s .= (($elements['actif']=="oui")?"<strong>":"").typo($elements['titre']).(($elements['actif']=="oui")?"</strong>":"");
   		    if ($elements['descriptif'] != "") {
    		    $s .= " : ".typo($elements['descriptif']);
    		}
    		if ($elements['texte'] != "") {
    		    $s .= " (".typo($elements['texte']).".html)";
    		}
//    		$s .= debut_block_invisible($elements['id_config']);
//    		$s .= typo($elements['descriptif'])."<br />";
//    		$s .= "Lien vers : ".typo($elements['texte']).".html<br />";
//    		$s .= "Type : ".typo($elements['type'])."<br />";
//            $s .= fin_block();
            echo $s;
            echo "<br />";
            $index++;
        }
    }
}

function exec_BlipConfig_config() {
	global $connect_statut;
	global $connect_toutes_rubriques;
	global $spip_lang_right;
	$surligne = "";
  
	if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
		debut_page(_T('blip_config'), "administration", "BLiP");
		echo _T('avis_non_acces_page');
		fin_page();
		exit;
	}
	
	debut_page(_T('blip_config'), "administration", "BLiP");
	echo "<br/><br/><br/>";
	
	gros_titre(_T('blip_config'));

	debut_gauche();
	debut_boite_info();
	echo _T('info_gauche_admin_tech');
	fin_boite_info();

	debut_droite();

	debut_cadre_relief();

    BlipConfig_afficher_config_courante();
    
    echo "<hr />";
    echo <<<END
      <form name="form1" id="form1" method="post" action="">
      <input name="id_item" type="hidden" id="id_item" value="0" />
      <input name="type" type="hidden" id="type" value="dynamique" />
      Titre 
      <input name="titre" type="text" id="titre" />
      <br />
      Descriptif 
      <input name="descriptif" type="text" id="descriptif" />
      <br />
      Style 
      <input name="style" type="text" id="style" />
      <br />
      Position 
      <select name="position" id="position">
        <option value="manu_principal" selected="selected">Menu principal</option>
      </select>
      <br />
      Actif 
      <select name="actif" id="actif">
        <option value="oui">oui</option>
        <option value="non">non</option>
      </select>
    <p>
      <input type="submit" name="Submit" value="Submit" />
    </p>
  </form>
END;
    if (isset($_GET['action'])) {
        echo "action = ".$_GET['action'];
        if (isset($_GET['id'])) {
            echo "<br />id = ".$_GET['id'];
        }
    }
	fin_page();

}
?>
