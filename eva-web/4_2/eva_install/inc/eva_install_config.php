<?php
/* Fonction permettant de stocker en meta une info transmisse par POST*/
function setVariable($v) {
  ecrire_meta('antispam_'.$v, $_POST[$v]);
}


function Antispam_config_fonction($params='') {
  global $spip_lang_right;

  include_spip("inc/config");		

  $out = "";
  $url = self();

  //Traitement
  //----------
  if(isset($_POST["sauve_fonction"])) {
    // Modification de la configuration
    setVariable("fonction_nom");
    setVariable("fonction_actif");

    ecrire_metas();
  }
  //Récupération de la configuration pour l'affichage
  $ffonction_actif = $GLOBALS['meta']['antispam_fonction_actif'];
  if (empty($ffonction_actif)) $ffonction_actif = "non";

  $ffonction_nom = $GLOBALS['meta']['antispam_fonction_nom'];
  if (empty($ffonction_nom)) $ffonction_nom = "ecrire_message";


  //Affichage
  //---------
  //Formulaire
  $out .=  "<form name='configuration_fonction' action='$url' method='post'>\n";

  $out .= _T('antispam:fonction_intro');

  //Actif
  $out .= "<table border=0 cellspacing=1 cellpadding=3 width=\"100%\">";
  $out .= "<tr><td align='$spip_lang_right' class='verdana2'>";
  $out .= bouton_radio("fonction_actif", "oui", _T('antispam:fonction_activation'), $ffonction_actif == "oui", "changeVisible(this.checked, 'config-fonction', 'block', 'none');");
  $out .= " &nbsp;";
  $out .= bouton_radio("fonction_actif", "non", _T('antispam:fonction_inactivation'), $ffonction_actif == "non", "changeVisible(this.checked, 'config-fonction', 'none', 'block');");
  $out .= "</td></tr></table>\n";

  //debut bloc config-fonction
  if ($ffonction_actif != "non") $style = "display: block;";
  else $style = "display: none;";
  $out .= "<div id='config-fonction' style='$style'>";

  // NOM
  $out .=  "<p>"._T('antispam:fonction_nom')."<br />\n";
  $out .=  "<input type='text' name='fonction_nom' value=\"$ffonction_nom\" class='formo' />";
  $out .=  "</p>\n";

  //fin bloc config-fonction
  $out .=  "</div>\n";

  //SUBMIT
  $out .=  "<div class='edition-bouton'>";
  $out .=  "<div style='text-align:$spip_lang_right'><input type='submit' name='sauve_fonction' value='"._T('bouton_enregistrer')."' class='fondo'></div>";
  $out .=  "</div>\n";


  $out .=  "</form>\n";

  return $out;

}

function Antispam_config_text($params='') {
  global $spip_lang_right, $spip_lang_left;

  include_spip("inc/config");		

  $out = "";
  $url = self();

  //Traitement
  //----------
  if(isset($_POST["sauve_texte"])) {
    // Modification de la configuration
    setVariable("texte_image");
    setVariable("texte_police");
    setVariable("texte_taille");
    setVariable("texte_couleur");
    setVariable("texte_survol");
    setVariable("texte_at");
    setVariable("texte_at_alea_actif");
    setVariable("texte_at_alea");
    setVariable("texte_point");
    setVariable("texte_point_alea_actif");
    setVariable("texte_point_alea");

    ecrire_metas();
  }
  //Récupération de la configuration pour l'affichage
  $ftexte_image = $GLOBALS['meta']['antispam_texte_image'];
  if (empty($ftexte_image)) $ftexte_image = "oui";
  
  $ftexte_police = $GLOBALS['meta']['antispam_texte_police'];
  if (empty($ftexte_police)) $ftexte_police = "dustismo_bold.ttf";

  $ftexte_taille = $GLOBALS['meta']['antispam_texte_taille'];
  if (empty($ftexte_taille)) $ftexte_taille = "12";
  
  $ftexte_couleur = $GLOBALS['meta']['antispam_texte_couleur'];
  if (empty($ftexte_couleur)) $ftexte_couleur = "0000FF";
  
  $ftexte_survol = $GLOBALS['meta']['antispam_texte_survol'];
  if (empty($ftexte_survol)) $ftexte_survol = " ";

  $ftexte_at = $GLOBALS['meta']['antispam_texte_at'];
  if (empty($ftexte_at)) $ftexte_at = "chez";

  $ftexte_at_alea_actif = $GLOBALS['meta']['antispam_texte_at_alea_actif'];
  if ($ftexte_at_alea_actif == '') $ftexte_at_alea_actif = "non";

  $ftexte_at_alea = $GLOBALS['meta']['antispam_texte_at_alea'];
  if (empty($ftexte_at_alea)) $ftexte_at_alea_actif = "4";

  $ftexte_point = $GLOBALS['meta']['antispam_texte_point'];
  if (empty($ftexte_point)) $ftexte_point = "point";

  $ftexte_point_alea_actif = $GLOBALS['meta']['antispam_texte_point_alea_actif'];
  if (empty($ftexte_point_alea_actif)) $ftexte_point_alea_actif = "non";

  $ftexte_point_alea = $GLOBALS['meta']['antispam_texte_point_alea'];
  if (empty($ftexte_point_alea)) $ftexte_point_alea_actif = "4";

  //Formulaire
  $out .=  "<form name='configuration_texte' action='$url' method='post'>\n";

  //Actif
  $out .= "<table border=0 cellspacing=1 cellpadding=3 width=\"100%\">";
  $out .= "<tr><td align='$spip_lang_right' class='verdana2'>";
  $out .= bouton_radio("texte_image", "oui", _T('antispam:texte_crypte_image'), $ftexte_image == "oui", "changeVisible(this.checked, 'config-image', 'block', 'none');changeVisible(this.checked, 'config-text', 'none', 'block');");
  $out .= " &nbsp;";
  $out .= bouton_radio("texte_image", "non", _T('antispam:texte_crypte_texte'), $ftexte_image == "non", "changeVisible(this.checked, 'config-image', 'none', 'block');changeVisible(this.checked, 'config-text', 'block', 'none');");
  $out .= "</td></tr></table>\n";

  //debut bloc CONFIG-TEXT
  if ($ftexte_image == "non") $style = "display: block;";
  else $style = "display: none;";
  $out .= "<div id='config-text' style='$style'>";

  // AT
  $out .=  "<p>"._T('antispam:texte_at')."<br />\n";
  $out .=  bouton_radio("texte_at_alea_actif", "non", _T('antispam:texte_unique'), $ftexte_at_alea_actif == "non", "changeVisible(this.checked, 'div_at', 'inline', 'none');changeVisible(this.checked, 'div_at_alea', 'none', 'inline');");
  $out .=  bouton_radio("texte_at_alea_actif", "oui", _T('antispam:texte_alea_actif'), $ftexte_at_alea_actif == "oui", "changeVisible(this.checked, 'div_at', 'none', 'inline');changeVisible(this.checked, 'div_at_alea', 'inline', 'none');");

  if ($ftexte_at_alea_actif == "non") $style = "display: block;";
  else $style = "display: none;";
  $out .=  "<div id='div_at' style='$style'>";
  $out .=  "<input type='text' name='texte_at' value=\"$ftexte_at\" class='formo' />";
  $out .=  "</div>";

  if ($ftexte_at_alea_actif == "oui") $style = "display: block;";
  else $style = "display: none;";
  $out .=  "<div id='div_at_alea' style='$style'>";
  $out .=  _T('antispam:texte_de')."&nbsp;&nbsp;";
  $out .=  "<input type='text' name='texte_at_alea' value=\"$ftexte_at_alea\" class='formo' style='width:auto;display:inline' size='4'/>";
  $out .=  "&nbsp;&nbsp;"._T('antispam:texte_nbre_caracteres');
  $out .=  "</div>";

  $out .=  "</p>\n";

  // POINT
  $out .=  "<p>"._T('antispam:texte_point')."<br />\n";
  $out .=  bouton_radio("texte_point_alea_actif", "non", _T('antispam:texte_unique'), $ftexte_point_alea_actif == "non", "changeVisible(this.checked, 'div_point', 'inline', 'none');changeVisible(this.checked, 'div_point_alea', 'none', 'inline');");
  $out .=  bouton_radio("texte_point_alea_actif", "oui", _T('antispam:texte_alea_actif'), $ftexte_point_alea_actif == "oui", "changeVisible(this.checked, 'div_point', 'none', 'inline');changeVisible(this.checked, 'div_point_alea', 'inline', 'none');");

  if ($ftexte_point_alea_actif == "non") $style = "display: block;";
  else $style = "display: none;";
  $out .=  "<div id='div_point' style='$style'>";
  $out .=  "<input type='text' name='texte_point' value=\"$ftexte_point\" class='formo' />";
  $out .=  "</div>";

  if ($ftexte_point_alea_actif == "oui") $style = "display: block;";
  else $style = "display: none;";
  $out .=  "<div id='div_point_alea' style='$style'>";
  $out .=  _T('antispam:texte_de')."&nbsp;&nbsp;";
  $out .=  "<input type='text' name='texte_point_alea' value=\"$ftexte_point_alea\" class='formo' style='width:auto;display:inline' size='4'/>";
  $out .=  "&nbsp;&nbsp;"._T('antispam:texte_nbre_caracteres');
  $out .=  "</div>";

  $out .=  "</p>\n";

  //fin bloc CONFIG-TEXT
  $out .=  "</div>\n";

  //debut bloc CONFIG-IMAGE
  if ($ftexte_image == "oui") $style = "display: block;";
  else $style = "display: none;";
  $out .= "<div id='config-image' style='$style'>";
  
  // Police
  $out .=  "<p style='margin-$spip_lang_left:30px'>"._T('antispam:texte_police')."&nbsp;\n";
  $out .=  "<input type='text' name='texte_police' value=\"$ftexte_police\" class='formo' style='width:auto;display:inline;' size=24 />";
  $out .=  "<br />" ._T('antispam:texte_police_info')."&nbsp;\n";
  $out .=  "</p>\n";

  // Taille
  $out .=  "<p style='margin-$spip_lang_left:30px'>"._T('antispam:texte_taille')."&nbsp;\n";
  $out .=  "<input type='text' name='texte_taille' value=\"$ftexte_taille\" class='formo' style='width:auto;display:inline;' size=4 />";
  $out .=  "</p>\n";

	// Couleur
  $out .=  "<p style='margin-$spip_lang_left:30px'>"._T('antispam:texte_couleur')."&nbsp;\n";
  $out .=  "<input type='text' name='texte_couleur' value=\"$ftexte_couleur\" class='formo' style='width:auto;display:inline;' size=8 />";
  $out .=  "<br />" ._T('antispam:texte_couleur_info')."&nbsp;\n";
  $out .=  "</p>\n";

// Texte de survol (alt)
  $out .=  "<p style='margin-$spip_lang_left:30px'>"._T('antispam:texte_survol')."&nbsp;\n";
  $out .=  "<input type='text' name='texte_survol' value=\"$ftexte_survol\" class='formo' style='width:auto;display:inline;' size=30 />";
  $out .=  "</p>\n";

  //fin bloc CONFIG-IMAGE
  $out .=  "</div>\n";

  //SUBMIT
  $out .=  "<div class='edition-bouton'>";
  $out .=  "<div style='text-align:$spip_lang_right'><input type='submit' name='sauve_texte' value='"._T('bouton_enregistrer')."' class='fondo'></div>";
  $out .=  "</div>\n";

  $out .=  "</form>\n";

  return $out;

}
?> 
