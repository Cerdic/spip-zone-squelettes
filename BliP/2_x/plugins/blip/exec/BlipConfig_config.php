<?php

/***************************************************************************\
 *                                                                         *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/config');
include_spip('inc/presentation');
include_spip('inc/layer');

/***************************************************/
/* Génération automatique d'éléments de formulaire */
/***************************************************/
function blipconfig_generer_option_select($nom, $valeurs, $actif="") {
    $s  = '<select name="'.$nom.'" id="'.$nom.'">';
    foreach ($valeurs as $valeur => $description) {
        $s .= '<option value="'.$valeur.'"';
        if ($actif == $valeur) {
            $s .= ' selected="selected"';
        }
        $s .= '>'.$description."</option>\n";
    }
    $s .= "</select>\n";
    return $s;
}

function blipconfig_generer_checkbox($nom, $valeur) {
    $r = '<input type="checkbox" name="'.$nom.'" value="'.$nom.'"';
    if ($valeur && ! preg_match("/non?/i", $valeur)) {
        $r .= ' checked="checked"';
    }
    $r .= ' />';
    return $r;
}

/**************************************************/
/* Affichier le contenu de la table               */
/* mais seulement le principal pour l'utilisateur */
/* avec les actions de positionnement             */
/**************************************************/
function blipconfig_afficher_config_courante () {
    if ($res = spip_query("SELECT id_config, titre, texte, type, descriptif, ordre, actif FROM blip_config ORDER BY ordre")) {
        $compte = spip_num_rows($res);
        $index = 1;
        echo '<a href="'.generer_url_ecrire('blipconfig_config',"action=creer").'">Ajouter</a>';
        echo "<br />";
        while ($elements = spip_fetch_array($res, SPIP_ASSOC)) {
            $s = "";
            if ($index != $compte) {
                $s .= " <a href='".generer_url_ecrire('blipconfig_config',"action=descendre&id=".$elements['id_config'])."'><img src='"._DIR_IMG_PACK."descendre-16.png' style='border:0'></a>";
       		} else {
       		    $s .= ' <img src="'._DIR_PLUGINS.'blipconfig/ecrire/img_pack/rien-16.png" />';
            }
       		if ($index != 1) {
       		    $s .= " <a href='".generer_url_ecrire('blipconfig_config',"action=monter&id=".$elements['id_config'])."'><img src='"._DIR_IMG_PACK."monter-16.png' style='border:0'></a>";
       		} else {
       		    $s .= ' <img src="'._DIR_PLUGINS.'blipconfig/ecrire/img_pack/rien-16.png" />';
       		}
       		$s .= "<a href='".generer_url_ecrire('blipconfig_config',"action=editer&id=".$elements['id_config'])."'>";
       		$s .= " "._T('bouton_modifier')." ";
       		$s .= "</a>";
   		    $s .= (($elements['actif']=="oui")?"<strong>":"").typo($elements['titre']).(($elements['actif']=="oui")?"</strong>":"");
   		    if ($elements['descriptif'] != "") {
    		    $s .= " : ".typo($elements['descriptif']);
    		}
    		if ($elements['texte'] != "") {
    		    $s .= " (".typo($elements['texte']).")";
    		}
            echo $s;
            echo "<br />";
            $index++;
        }
    }
}

function blipconfig_initialiser_valeurs_formulaire() {
    //valeurs par défaut
    $blipconfig_item = array(
        'id_config' => "",
        'position' => "menu_principal", //plutot que position, parent serait plus approprié, non ?
        'id_item' => "",
        'ordre' => "dernier", // mot clé pour dire de le mettre à la fin
        'type' => "dynamique",
        'titre' => "",
        'descriptif' => "",
        'texte' => "",
        'style' => "",
        'actif' => "non"
        );
    // surcharge de ces valeurs le cas échéant par celles de la base si action sur un item a priori existant
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $res = spip_query("SELECT * FROM blip_config WHERE id_config='$id' LIMIT 1");
            $blipconfig_item = spip_fetch_array($res, SPIP_ASSOC);
        }
    }
    return $blipconfig_item;
}

/* générer un formulaire prérempli pour l'item nouveau ou modifié */
function blipconfig_generer_formulaire($action) {
    $blipconfig_menutypes = array(
        'dynamique' => "Menu dynamique",
        'statique' => "Menu statique"
    );
    $blipconfig_positions = array(
        'menu_principal' => "Menu principal"
    );
    $blipconfig_actif = array(
        'oui' => "Oui",
        'non' => "Non"
    );
    $formval = blipconfig_initialiser_valeurs_formulaire();
    $f  = '<form name="form1" id="form1" method="post" action="'.generer_url_ecrire('blipconfig_config',"action=formulaire").'">';
    $f .= '<input name="id_config" type="hidden" id="id_config" value="'.$formval['id_config'].'" />';
    $f .= '<p align="center">';
    $f .= 'Titre <input name="titre" type="text" id="titre" value="'.$formval['titre'].'" /> ';
    $f .= 'Actif '.blipconfig_generer_option_select("actif", $blipconfig_actif, $formval['actif']);
    $f .= "</p><p>";
    $f .= 'Descriptif <input name="descriptif" type="text" id="descriptif" value="'.$formval['descriptif'].'" size="45" />';
    $f .= "</p><p>";
    $f .= 'Lien vers la page <input name="texte" type="text" id="texte" value="'.$formval['texte'].'" />';
    $f .= "</p><p>";
    $f .= 'Type '.blipconfig_generer_option_select('type', $blipconfig_menutypes, $formval['type']);
    $f .= "</p><p>";
    $f .= 'Position '.blipconfig_generer_option_select('position', $blipconfig_positions, $formval['position']);
    $f .= '<input name="style" type="hidden" id="style" value="'.$formval['style'].'" />';
    $f .= '</p><p align="center">';
    if ($action=="editer") {
        $f .= '<input name="action" type="hidden" value="modifier" />';
        $f .= '<input type="submit" name="modif" value="Appliquer les modifications" />';
        $f .= " <a href='".generer_url_ecrire('blipconfig_config',"action=supprimer&id=".$formval['id_config'])."'><img title='Supprimer !' src='"._DIR_IMG_PACK."poubelle.gif' style='border:0'></a>";
    } else { // Ajouter
        $f .= '<input name="action" type="hidden" value="ajouter" />';
        $f .= '<input type="submit" name="ajout" value="Ajouter ce nouvel element" />';
    }
    $f .= "</p></form>";
    $f .= "<hr />\n";
    return $f;
}

/* Exécuter les actions immédiates telles que monter/descendre un item ou le supprimer */
function blipconfig_action_immediate($action, $id) {
    if ($res = spip_query("SELECT id_config, ordre FROM blip_config WHERE id_config='$id' LIMIT 1")) {
        switch ($action = $_GET['action']) {
        case "monter" :
            $element_courant = spip_fetch_array($res, SPIP_ASSOC);
            if ($res = spip_query("SELECT id_config, ordre FROM blip_config WHERE ordre<".$element_courant['ordre']." ORDER BY ordre DESC LIMIT 1")) {
                $element_precedent = spip_fetch_array($res, SPIP_ASSOC);
                if ($res = spip_query("UPDATE blip_config SET ordre='".$element_courant['ordre']."' WHERE id_config='".$element_precedent['id_config']."' LIMIT 1")) {
                    $res = spip_query("UPDATE blip_config SET ordre='".$element_precedent['ordre']."' WHERE id_config='".$element_courant['id_config']."' LIMIT 1");
                }
            }
            break;
        case "descendre" :
            $element_courant = spip_fetch_array($res, SPIP_ASSOC);
            if ($res = spip_query("SELECT id_config, ordre FROM blip_config WHERE ordre>".$element_courant['ordre']." ORDER BY ordre ASC LIMIT 1")) {
                $element_precedent = spip_fetch_array($res, SPIP_ASSOC);
                if ($res = spip_query("UPDATE blip_config SET ordre='".$element_courant['ordre']."' WHERE id_config='".$element_precedent['id_config']."' LIMIT 1")) {
                    $res = spip_query("UPDATE blip_config SET ordre='".$element_precedent['ordre']."' WHERE id_config='".$element_courant['id_config']."' LIMIT 1");
                }
            }
            break;
        case "supprimer" :
            if (spip_num_rows($res) == 1) {
                if ($res = spip_query("DELETE FROM blip_config WHERE id_config='".$id."' LIMIT 1")) {
                    echo _T('blipconfig_element_efface');
                    echo "<hr />";
                }
            }
            break;
        }
    }
}

function blipconfig_action_formulaire() {
//    print_r($_POST);
    // TODO : vérifications d'usage de la validité des champs du formulaire
    // attention à ne par confondre les variables $_POST['action'] et $_GET['action']
    if (isset($_POST['action'])) {
        $valeurs = blipconfig_initialiser_valeurs_formulaire();
        // filtre antiparasite : ne retenir que les valeurs gérables par le système
        foreach ($_POST as $var => $val) {
            if (array_key_exists($var, $valeurs)) {
                $valeurs[$var] = htmlspecialchars($val, ENT_QUOTES);
            }
        }
        // TODO éviter ce traitement pas propre du cas où il est besoin de retrouver la plus grande valeur d'ordre pour ajouter l'item à la fin
        if (($_POST['action']=='ajouter') && ($res = spip_query("SELECT MAX(ordre) FROM `blip_config`"))) {
            // ATTENTION : cette fonction n'est pas encapsulée par spip (would be spip_result()), ça signifie pas portable vers base de données non MySQL !!
            $max = mysql_result($res, 0);
            $valeurs['ordre'] = $max + 10;
        }
        // TODO : il doit exister une fonction dans spip ou ailleurs qui génère automatiquement une requète 
        // en fonction d'un tableau d'association au lieu de faire ça manuellement comme ici
        $preliste_c = $preliste_v = array();
        foreach ($valeurs as $champ => $valeur) {
            if ($champ != 'id_config') {
                array_push($preliste_c, " `".$champ."`");
                array_push($preliste_v, " '".$valeur."'");
            }
        }
        switch ($_POST['action']) {
            case 'ajouter' :
                $req  = "INSERT INTO `blip_config` ( ";
                $req .= implode(",", $preliste_c);
                $req .= " ) VALUES ( ";
                $req .= implode(",", $preliste_v);
                $req .= " );";
            break;
            case 'modifier' :
                $req  = "UPDATE `blip_config` SET ";
                $preliste = array();
                foreach ($preliste_c as $position => $champ) {
                    array_push($preliste, $champ."=".$preliste_v[$position]);
                }
                $req .= implode(",", $preliste);
                $req .= " WHERE `id_config`='".$valeurs['id_config']."' LIMIT 1;";
            break;
        }
//        echo $req;
        if (spip_query($req)) {
            echo "Ok<hr />\n";
        }
    }
}

function blipconfig_afficher_desinstall() {
    echo "<hr />\n";
    echo bouton_block_invisible('desinstall');
    echo "D&eacute;sinstaller BLiP";
    echo debut_block_invisible('desinstall');
    echo '<div align="center">';
    echo '<form method="post" action="'.generer_url_ecrire('blipconfig_config',"action=desinstall").'">';
    echo '<input type="submit" name="appliq" value="D&eacute;sinstaller BliP" />';
    echo '</form></div>';
    echo fin_block();
}
function blipconfig_afficher_install() {
    echo '<div align="center">';
    echo '<form method="post" action="'.generer_url_ecrire('blipconfig_config',"action=install").'">';
    echo '<input type="submit" name="appliq" value="Installer/mettre &agrave; jour la base pour BLiP" />';
    echo '</form></div>';
}

/*********************************************************/
// Verifier que la table existe.
// Servira plus tard pour des vérifications plus poussées
// en particulier en cas d'upgrade si le format des tables change
// Infos de version à stocker en meta
function blipconfig_verifier_base() {
    return (spip_query("SELECT * FROM `blip_config`"));
}

function blipconfig_installer_base() {
    $req = "
CREATE TABLE `blip_config` (
  `id_config` bigint(21) NOT NULL auto_increment,
  `position` tinytext NOT NULL,
  `id_item` bigint(21) NOT NULL default '0',
  `ordre` bigint(21) NOT NULL default '0',
  `type` tinytext NOT NULL,
  `titre` text NOT NULL,
  `descriptif` text NOT NULL,
  `texte` text NOT NULL,
  `style` tinytext NOT NULL,
  `actif` char(3) NOT NULL default '',
  PRIMARY KEY  (`id_config`),
  KEY `actif` (`actif`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
";
    if (spip_query($req)) {
        echo _T('blipconfig_base_mise_a_jour');
        echo '<div align="center">';
        echo '<form method="post" action="'.generer_url_ecrire('blipconfig_config').'">';
        echo '<input type="submit" name="appliq" value="'._T('continuer').'" />';
        echo '</form></div>';
    } else {
        echo _T('avis_operation_echec');
        // TODO : traiter les cas d'erreur traitables ou expliquer
    }
}

function blipconfig_desinstaller_base() {
    $req = "DROP table `blip_config`";
    if (spip_query($req)) {
        echo '<div align="center">';
        echo _T('blipconfig_base_mise_a_jour');
        echo "<br/><br/>\n";
        echo _T('blipconfig_desactiver_plugin');
        echo "<br/><br/>\n";
        echo '</div>';
    } else {
        echo _T('avis_operation_echec');
    }
}

function exec_blipconfig_config() {
	global $connect_statut;
	global $connect_toutes_rubriques;
	global $spip_lang_right;

	if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
		debut_page(_T('blibconfig:blip_config'), "administration", "BLiP");
		echo _T('avis_non_acces_page');
		fin_page();
		exit;
	}
	
	debut_page(_T('blibconfig:blip_config'), "administration", "BLiP");
	echo "<br/><br/><br/>";
	
	gros_titre(_T('blibconfig:blip_config'));

	debut_gauche();
	debut_boite_info();
	echo _T('info_gauche_admin_tech');
	fin_boite_info();

	debut_droite();

	debut_cadre_relief();

    if (isset($_GET['action'])) {
        
        switch ($action = $_GET['action']) {
            case "editer" :
            case "creer" :
                echo blipconfig_generer_formulaire($action);
                break;
            case "monter" :
            case "descendre" :
            case "supprimer" :
                if (isset($_GET['id'])) {
                    blipconfig_action_immediate($action, $_GET['id']);
                }
                break;
            case "formulaire" :
                blipconfig_action_formulaire();
                break;
            case "install" :
                blipconfig_installer_base();
                break;
            case "desinstall" :
                blipconfig_desinstaller_base();
                break;
        }
    }
    if (blipconfig_verifier_base()) {
        blipconfig_afficher_config_courante();
        blipconfig_afficher_desinstall();
    } else {
        blipconfig_afficher_install();
    }
	fin_page();
}
?>
