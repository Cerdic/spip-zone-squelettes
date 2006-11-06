<?php
//
// Configurateur Squelette Epona - 2006 Fev 28 - Marc Lebas.
//

function avertir($msg) {echo "<font color=orange>$msg</font><br>";}

function marque_erreur($msg) {
  global $erreur;
  echo "<b><font color=red>$msg</font></b><br>";
  $erreur = 1;
}

function dossier_squel() {
  if (!file_exists('../squelettes')) {
    marque_erreur ("dossier squelette ../squelettes non trouv&eacute;");
    return FALSE;
  }
  if (!is_writable("../squelettes")) {
    marque_erreur("Pas d'acc&eagrave;s en &eacute;criture dans le r&eacute;pertoire ../squelettes");
    return FALSE;
  }
  if (!file_exists("../squelettes/inc-menu.html"))
      avertir("../squelettes/inc-menu.html non trouv&eacute;");
  if (!file_exists("../squelettes/inc-menu_def.html"))
      avertir("../squelettes/inc-menu_def.html non trouv&eacute;");
  if (!is_writable("../squelettes/inc-menu.html"))
      avertir("Pas d'acc&eagrave;s en &eacute;criture pour ../squelettes/inc-menu.html");
  return TRUE;
}

function rubrique_vide($id_rubrique) {
	$query = "SELECT id_rubrique FROM spip_rubriques WHERE id_parent='$id_rubrique' LIMIT 0,1";
	list($n) = spip_fetch_array(spip_query($query));
	if ($n > 0) return false;
	$query = "SELECT id_article FROM spip_articles WHERE id_rubrique='$id_rubrique' AND (statut='publie' OR statut='prepa' OR statut='prop') LIMIT 0,1";
	list($n) = spip_fetch_array(spip_query($query));
	if ($n > 0) return false;
	$query = "SELECT id_breve FROM spip_breves WHERE id_rubrique='$id_rubrique' AND (statut='publie' OR statut='prop') LIMIT 0,1";
	list($n) = spip_fetch_array(spip_query($query));
	if ($n > 0) return false;
	$query = "SELECT id_syndic FROM spip_syndic WHERE id_rubrique='$id_rubrique' AND (statut='publie' OR statut='prop') LIMIT 0,1";
	list($n) = spip_fetch_array(spip_query($query));
	if ($n > 0) return false;
	$query = "SELECT id_document FROM spip_documents_rubriques WHERE id_rubrique='$id_rubrique' LIMIT 0,1";
	list($n) = spip_fetch_array(spip_query($query));
	if ($n > 0) return false;
	return true;
}

function cree_menu_rub($fw, $prub, $indent, $differ) {
  // Fonction recursive parcourant la hierarchie de rubriques publiees
  // pour generer la hiearchie du menu deroulant
  // fw = fichier, prub = rubrique parente, indent = indentation, differ = fermeture li
  $result = spip_query("SELECT id_rubrique, titre, statut FROM spip_rubriques WHERE id_parent=$prub AND statut='publie' AND titre!='Agenda' ORDER BY titre");
  while ($row = spip_fetch_array($result)) {
    if (!isset($found) && $prub != 0) fputs ($fw, " class=smenu$differ\n$indent<ul>\n"); 
    $found = 1;
    $titre=texte_script($row['titre']);
    $id_rub=$row['id_rubrique'];
    fputs ($fw, "$indent   <li");
   // on differe la fermeture du <li en memorisant le <a>...</a> pour pouvoir ajouter un eventuel class=smenu
    $differ1="><a href=\"?id_rubrique=".$id_rub."\">".$row['titre']."</a>";
    cree_menu_rub($fw, intval($row['id_rubrique']), "$indent   ", $differ1);
  }
  if ($prub ==0)  return;
  if (isset($found)) { fputs ($fw, "$indent</ul>\n$indent");  } else {fputs($fw, "$differ") ;}
  fputs ($fw, "</li>\n");
}

//
// Fonctions pour mot-cles
//
function groupe_vide($titre) {
  if (id_groupe($titre) != 0) {
       marque_erreur("Le groupe $titre existe d&eacute;j&agrave;");
       return FALSE;
  }
  return TRUE;
}

function id_groupe($titre) {
  // leve une erreur si plusieurs
  $result = spip_query("SELECT id_groupe FROM spip_groupes_mots WHERE titre='$titre'");
  switch (spip_num_rows($result)) {
    case 0 : return 0;
    case 1 : while ($row = spip_fetch_array($result)) return $row['id_groupe'];
    default : 
      marque_erreur(spip_num_rows($result)." groupes $titre : ");
      while ($row = spip_fetch_array($result)) echo 'id_groupe= '.$row['id_groupe'].'<br>';
      return -1;
  }
}

function id_mot($titre, $type) {
  // leve une erreur si plusieurs
  $result = spip_query("SELECT id_mot, titre FROM spip_mots WHERE titre='$titre' AND type='$type'");
  switch (spip_num_rows($result)) {
    case 0 : return 0;
    case 1 : while ($row = spip_fetch_array($result)) return $row['id_mot'];
    default : 
      marque_erreur(spip_num_rows($result)." mots $titre pour groupe mot $type :");
      while ($row = spip_fetch_array($result)) echo 'id_mot= '.$row['id_mot'].' '.$row['titre'].'<br>';
      return -1;
  }
}

function active_groupe($groupe, $mots) {
  $id_groupe=id_groupe($groupe);
  if ($id_groupe != 0) return FALSE;
  //Creation groupe + mot-cles
  if (!spip_query("INSERT INTO spip_groupes_mots SET titre='$groupe', unseul='non', obligatoire='non',
                 articles='oui', breves='non', rubriques='non', syndic='oui',
                  minirezo='oui', comite='oui', forum='non'")) {
     marque_erreur("Erreur cr&eacute;ation $groupe");
     return FALSE;
  }
  $id_groupe = spip_insert_id();
  foreach ($mots as $mot) {
    if (!spip_query("INSERT INTO spip_mots (type, titre, id_groupe) VALUES ('$groupe', '$mot', '$id_groupe')")) {
       marque_erreur("Erreur cr&eacute;ation mot $mot dans groupe $groupe");
       return FALSE;
    }
    echo " $mot";
  }
  echo " (groupe mots $groupe cr&eacute;&eacute;)<br>";
  return TRUE;
}

function active_groupe_rub($groupe, $mots) {
  $id_groupe=id_groupe($groupe);
  if ($id_groupe != 0) return FALSE;
  //Creation groupe + mot-cles
  if (!spip_query("INSERT INTO spip_groupes_mots SET titre='$groupe', unseul='non', obligatoire='non',
                 articles='non', breves='non', rubriques='oui', syndic='non',
                  minirezo='oui', comite='oui', forum='non'")) {
     marque_erreur("Erreur cr&eacute;ation $groupe");
     return FALSE;
  }
  $id_groupe = spip_insert_id();
  foreach ($mots as $mot) {
    if (!spip_query("INSERT INTO spip_mots (type, titre, id_groupe) VALUES ('$groupe', '$mot', '$id_groupe')")) {
       marque_erreur("Erreur cr&eacute;ation mot $mot dans groupe $groupe");
       return FALSE;
    }
    echo " $mot";
  }
  echo " (groupe mots $groupe cr&eacute;&eacute;)<br>";
  return TRUE;
}

function pre_desactive_groupe($titre) {
  // seulement pour verifier que le groupe est libre
  $rcode = TRUE;
  $id_groupe=id_groupe($titre);
  if ($id_groupe == 0) return TRUE;
  if ($id_groupe == -1) return FALSE;
  $result = spip_query("SELECT id_mot, titre FROM spip_mots WHERE id_groupe=$id_groupe");
  while ($row = spip_fetch_array($result)) {
    if (!pre_desactive_mot($row['id_mot'], $row['titre'])) $rcode = FALSE;
  }
  return $rcode;
}

function desactive_groupe($titre) {
  // aucun contrôle d'attachement; deja fait par pre_desactive_groupe
  $id_groupe=id_groupe($titre);
  if ($id_groupe == 0) return TRUE;
  if ($id_groupe == -1) return FALSE;
  $result = spip_query("SELECT id_mot, titre FROM spip_mots WHERE id_groupe=$id_groupe");
  while ($row = spip_fetch_array($result)) {
    spip_query("DELETE FROM spip_mots WHERE id_mot='".$row['id_mot']."'");
    foreach (array('breves', 'articles', 'rubriques', 'forum', 'syndic') as $elem)
      spip_query("DELETE FROM spip_mots_".$elem." WHERE id_mot=".$row['id_mot']);
    spip_query("DELETE FROM spip_index_mots WHERE id_mot=".$row['id_mot']);
    echo $row['titre'].' ';
  }
  spip_query("DELETE FROM spip_groupes_mots WHERE id_groupe='$id_groupe'");
  echo " (groupe mots $titre effac&eacute;)<br>";
  return TRUE;
}

function pre_desactive_mot($id_mot, $titre) {
  // pour verifier qu'un mot est libre
  $rcode = TRUE;
  foreach (array('breve', 'article', 'rubrique') as $elem) {
    $result = spip_query("SELECT id_".$elem." FROM spip_mots_".$elem."s WHERE id_mot=$id_mot");
    if ($row = spip_fetch_array($result)) {
      avertir("Le mot-cl&eacute; $titre est attach&eacute; ($elem)");
      $rcode = FALSE;
    }
  }
  foreach (array('forum', 'syndic') as $elem) {
    $result = spip_query("SELECT id_".$elem." FROM spip_mots_".$elem." WHERE id_mot=$id_mot");
    if ($row = spip_fetch_array($result)) {
      avertir("Le mot-cl&eacute; $titre est attach&eacute; ($elem)");
      $rcode = FALSE;
    }
  }
  return $rcode;
}

//
// fonctions agenda
//
function cree_secteur_agenda($genre) {
  if (id_agenda() != 0) {
    marque_erreur("Le secteur Agenda existe d&eacute;j&agrave;");
    return FALSE;
  }
  // cree le groupe Agenda
  $id_mot_agenda=cree_groupe_agenda($genre);
  if ($id_mot_agenda == 0) return FALSE;
  // cree secteur Agenda
  if (!spip_query("INSERT INTO spip_rubriques (titre, id_parent) VALUES ('Agenda', '0')")) {
     marque_erreur("Erreur cr&eacute;ation secteur Agenda");
     return FALSE;
  }
  $id_rub_agenda = spip_insert_id();
  echo "Rubrique Agenda cr&eacute;&eacute;e sous la racine<br>";
  // Liaison entre rubrique et mot-cle
  if (!spip_query("INSERT INTO spip_mots_rubriques (id_mot, id_rubrique) VALUES ('$id_mot_agenda', '$id_rub_agenda')")) {
     marque_erreur("Erreur liaison Agenda");
     return FALSE;
  }
  echo "Lien entre secteur Agenda et mot-cl&eacute; '$genre'<br>";
  return TRUE;
}

function cree_groupe_agenda($genre) {
  if (id_groupe('Agenda') != 0) {
    marque_erreur("Le groupe Agenda existe d&eacute;j&agrave;");
    return 0;
  }
  echo "Autorisation dates ant&eacute;rieures<br>";
  if (!spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_redac', 'oui')")) {
     marque_erreur("Erreur autorisation dates ant&eacute;rieures");
     return 0;
  }
  echo "Cr&eacute;ation groupe Agenda<br>";
  if(!spip_query("INSERT INTO spip_groupes_mots SET titre='Agenda', unseul='non', obligatoire='non',
                 articles='non', breves='non', rubriques='oui', syndic='non',
                  minirezo='oui', comite='non', forum='non'")) {
     marque_erreur("Erreur cr&eacute;ation groupe Agenda");
     return 0;
  }
  $id_groupe_agenda = spip_insert_id();
  echo "Cr&eacute;ation mot $genre dans groupe Agenda<br>";
  if (!spip_query("INSERT INTO spip_mots (type, titre, id_groupe) VALUES ('Agenda', '$genre', '$id_groupe_agenda')")) {
     marque_erreur("Erreur cr&eacute;ation mot ".$genre." dans groupe Agenda");
     return 0;
  }
  $GLOBALS['type_agenda']=$genre;
  echo "Groupe mot Agenda cr&eacute;&eacute;<br>";
  return spip_insert_id();
}

function type_agenda() {
  $result = spip_query("SELECT titre, id_mot FROM spip_mots WHERE type='Agenda'");
  switch (spip_num_rows($result)) {
    case 0 :  return 'aucun';
    case 1 :
       while ($row = spip_fetch_array($result)) $type=$row['titre'];
       switch ($type) {
         case 'agenda_mot' :
         case 'agenda_complet' :
         case 'agenda_secteur' :
           return $type;
         default :
           avertir("Type agenda ".$type." inconnu>");
           return $type;
       }
    default : 
       avertir(spip_num_rows($result)." mot-cl&eacute;s pour groupe mot Agenda: ");
       while ($row = spip_fetch_array($result)) echo 'mot-cl&eacute; : '.$row['titre'].' id_mot : '.$row['id_mot'].'<br>';
       return 'plusieurs';
  }
}

function id_agenda() {
  // leve une erreur si plusieurs
  $result = spip_query("SELECT id_rubrique FROM spip_rubriques WHERE titre='Agenda' AND id_parent=0");
  switch (spip_num_rows($result)) {
    case 0 :  return 0;
    case 1 :  while ($row = spip_fetch_array($result)) return $row['id_rubrique'];
    default : 
       marque_erreur(spip_num_rows($result)." secteurs Agenda: ");
       while ($row = spip_fetch_array($result)) echo 'id_rubrique : '.$row['id_rubrique'].'<br>';
       return -1;
  }
}

function pre_desactive_agenda() {
  $id_rubrique=id_agenda();
  if ($id_rubrique == 0) {return TRUE;}
  if ($id_rubrique == -1) {return FALSE;}
  if (!rubrique_vide($id_rubrique)) {
     marque_erreur("Le secteur Agenda n'est pas vide ");
     return FALSE;
  }
  return TRUE;
}

function desactive_agenda() {
  // aucun contrôle; deja fait par pre_desactive_agenda
  $id_rubrique=id_agenda();
  if ($id_rubrique > 0) {
    echo "Supprime secteur Agenda<br>";
    spip_query("DELETE FROM spip_mots_rubriques WHERE id_rubrique=$id_rubrique");
    spip_query("DELETE FROM spip_index_rubriques WHERE id_rubrique=$id_rubrique");
    spip_query("DELETE FROM spip_rubriques WHERE id_rubrique=$id_rubrique");
  }
  desactive_groupe('Agenda');
  return TRUE;
}

//
// Les points d'entrees
//
function menudef() {
  echo "<h1>Menu de base</h1>";
  if (!dossier_squel()) return FALSE;
  if (!copy('../squelettes/inc-menu_def.html', '../squelettes/inc-menu.html')) {
     marque_erreur("&eacute;chec copie squelettes/inc-menu_def.html vers queletton/inc-menu.html");
     return FALSE;
  }
}

function calcul_menu($type_agenda) {
  echo "<h1>Calcul menu HTML</h1>";
  if (!dossier_squel()) return FALSE;
  if (!$fw=fopen ("../squelettes/inc-menu.html","w")) {
    marque_erreur("Pas d'acc&eagrave;s en &eacute;criture pour ../squelettes/inc-menu.html");
    return FALSE;
  }
  fputs ($fw, "<div style=\"margin-left: 10px\">\n<ul id=menu>\n");
  // item accueil
  fputs ($fw, "    <li><a href='?'><:accueil_site:></a></li>\n");
  // item Agenda
  switch ($type_agenda) {
    case 'agenda_secteur' : 
    case 'agenda_complet' : 
       ereg("agenda_(.*)$", $type_agenda, $regs);
       $id_rub_agenda = id_agenda();
       if ($id_rub_agenda != 0) {
         $result = spip_query("SELECT id_mot FROM spip_mots WHERE type='Agenda'");
         if ($row = spip_fetch_array($result)) {
             $id_mot_agenda = $row['id_mot'];
             $result = spip_query("SELECT id_mot FROM spip_mots_rubriques WHERE id_mot=$id_mot_agenda AND id_rubrique=$id_rub_agenda");
             if ($row = spip_fetch_array($result)) {
               fputs ($fw, "    <li class=smenu><a href=\"?page=agen_mois_".$regs[1]."&amp;id_rubrique=".$id_rub_agenda."\"><:agenda:></a>\n");
               fputs ($fw, "      <ul>\n");
               fputs ($fw, "      <li><a href=\"?page=agen_mois_".$regs[1]."&amp;id_rubrique=".$id_rub_agenda."\"><:agenda_mois:></a></li>\n");
               fputs ($fw, "      <li><a href=\"?page=agen_an_".$regs[1]."&amp;id_rubrique=".$id_rub_agenda."\"><:agenda_an:></a></li>\n");
               fputs ($fw, "      </ul>\n");
               fputs ($fw, "    </li>\n");
             }
         }
       }
       break;
    case 'agenda_mot' :
        fputs ($fw, "    <li class=smenu><a href=?page=agen_mois_mot><:agenda:></a>\n");
        fputs ($fw, "      <ul>\n");
        fputs ($fw, "      <li><a href=?page=agen_mois_mot><:agenda_mois:></a></li>\n");
        fputs ($fw, "      <li><a href=?page=agen_an_mot><:agenda_an:></a></li>\n");
        fputs ($fw, "      </ul>\n");
        fputs ($fw, "    </li>\n");
       break;
    default :
       avertir("Pas d'agenda au menu pour type agenda : $type_agenda");
  }
  // items rubriques
  cree_menu_rub($fw, 0, " ", "");
  // items de fin de menu
  fputs ($fw, "    <li class=\"smenu\"><a href=ecrire><:le_site:></a>\n");
  fputs ($fw, "    <ul>\n");
  fputs ($fw, "      <li><a href=?page=articles><:articles:></a></li>\n");
  fputs ($fw, "      <li><a href=?page=le_site><:participer:></a></li>\n");
  fputs ($fw, "      <li><a href=ecrire><:espace_prive:></a></li>\n");
  fputs ($fw, "    </ul>\n");
  fputs ($fw, "    </li>\n");
  fputs ($fw, "    <li><a href=?page=plan><:plan_site:></a></li>\n");
  fputs ($fw, "</ul>\n</div>");
  fclose($fw);
  echo "inc-menu.html recalcul&eacute;<br>";
  return TRUE;
}

function mots_on() {
  echo "<h1>Cr&eacute;ation mot-cl&eacute;s</h1>";
  if (id_groupe('Album') == 0) {
    active_groupe('Album', array('album_simple', 'vignettes_image'));
  } else avertir("Le groupe Album existe d&eacute;j&agrave;");
  if (id_groupe('Epona') == 0) {
    active_groupe('Epona',  array('cacher', 'sommaire'));
  } else avertir("Le groupe Epona existe d&eacute;j&agrave;");
  if (id_groupe('_Article') == 0) {
    active_groupe('_Article',  array('livre', 'petition', 'album2'));
  } else avertir("Le groupe _Article existe d&eacute;j&agrave;");
  if (id_groupe('_Rubrique') == 0) {
    active_groupe_rub('_Rubrique',  array('par_mot'));
  } else avertir("Le groupe _Rubrique existe d&eacute;j&agrave;");
}

function mots_off() {
  echo "<h1>Suppression mot-cl&eacute;s</h1>";
  foreach (array('Epona', 'Album', '_Article', '_Rubrique') as $titre) {
    if (!pre_desactive_groupe($titre)) {
      avertir("Groupe $titre encore attach&eacute;");
    } else desactive_groupe($titre);
  }
}

function agenda_secteur() {
  echo "<h1>Agenda secteur</h1>";
  if (!cree_secteur_agenda('agenda_secteur')) return;
}

function agenda_mot() {
  echo "<h1>Agenda mot</h1>";
  if (!groupe_vide('_Agenda')) return FALSE;
  // cree le groupe agenda
  if (cree_groupe_agenda('agenda_mot') == 0) return FALSE;
  //Creation groupe _Agenda + mot-cle
  if (!active_groupe('_Agenda', array())) {
     marque_erreur("Erreur cr&eacute;ation groupe _Agenda");
     return FALSE;
  }
}

function agenda_complet() {
  echo "<h1>Agenda complet</h1>";
  if (!groupe_vide('_Agenda')) return FALSE;
  if (!cree_secteur_agenda('agenda_complet')) return;
  //Creation groupe _Agenda + mot-cle
  if (!active_groupe('_Agenda', array())) {
     marque_erreur("Erreur cr&eacute;ation groupe _Agenda");
     return FALSE;
  }
}

function agenda_off($type_agenda) {
  echo "<h1>Suppression $type_agenda</h1>";
  switch ($type_agenda) {
    case 'agenda_secteur' : 
        if (!pre_desactive_agenda()) return;
        desactive_agenda() ;
        break;
    case 'agenda_complet' : 
        if (!pre_desactive_agenda()) return;
        if (!pre_desactive_groupe('_Agenda')) {
          marque_erreur("Groupe '_Agenda' encore attach&eacute;");
          return;
        }
        desactive_groupe('_Agenda') ;
        desactive_agenda() ;
        break;
    case 'agenda_mot' :
        if (!pre_desactive_groupe('_Agenda')) {
          marque_erreur("Groupe '_Agenda' encore attach&eacute;");
          return;
        }
        desactive_groupe('Agenda');
        desactive_groupe('_Agenda') ;
        break;
  }
  $GLOBALS['type_agenda']='aucun';
}

//
// Main - Point d'entree du programme
//
function exec_epona_conf () {
}

global $type_agenda;
if (!file_exists("inc_version.php")) {
  marque_erreur("inc_version.php non trouv&eacute;. Suis-je bien dans le r&eacute;pertoire ecrire de Spip ?");
  exit;
}
if (!defined('_ECRIRE_INC_VERSION')) include ("inc_version.php");
include_ecrire('inc_cookie');
if ($GLOBALS['connect_statut'] != "0minirezo") {
  marque_erreur("Acc&eagrave;s refus&eacute;");
  exit;
}
if (file_exists(_FILE_OPTIONS)) include(_FILE_OPTIONS);
?>

<html dir="" lang="fr">
<head>
<title>Configurateur Epona v3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
#etat {
	position: absolute;
	left: 400px;
	top: 0px;
	margin: 5px;
	padding: 5px;
	margin-right: 2em;
	margin-top: 1.5em;
        border: 1px solid #a0a0a0;
}
body { background: #FFFFE0; margin: 10px; } 
</style>
</head>
<body>

<?php
//
// Affichage et arret si la base n'est pas coherente
//
foreach (array('Agenda', '_Agenda', 'Epona', 'Album', '_Article', '_Rubrique') as $titre) id_groupe($titre);
foreach (array('agenda_secteur', 'agenda_mot', 'agenda_complet') as $titre) id_mot($titre, 'Agenda');
foreach (array('sommaire', 'cacher') as $titre) id_mot($titre, 'Epona');
foreach (array('album_simple', 'vignettes_image') as $titre) id_mot($titre, 'Album');
foreach (array('livre', 'petition', 'album2') as $titre) id_mot($titre, '_Article');
foreach (array('par_titre') as $titre) id_mot($titre, '_Rubrique');
// ligne suivante pour Epona v2
id_mot('Agenda', 'Agenda');
$type_agenda=type_agenda();
id_agenda() ;
if (isset($erreur)) exit;
//
// Analyse et traitement requete
//
switch ($type_agenda) {
  case 'aucun' :
    switch ($GLOBALS['action']) {
      case 'agen_secteur' : agenda_secteur(); break;
      case 'agen_complet' : agenda_complet(); break;
      case 'agen_mot' : agenda_mot(); break;
    }
    break;
  case 'agenda_mot' :
  case 'agenda_complet' :
  case 'agenda_secteur' : if ($GLOBALS['action'] == 'agenda_off') agenda_off($type_agenda);
}
switch ($GLOBALS['action']) {
  case 'mots_on' : mots_on($type_agenda); break;
  case 'mots_off' : mots_off($type_agenda); break;
  case 'menu' : calcul_menu($type_agenda); break;
  case 'menudef' : menudef(); break;
}
if (isset($erreur)) marque_erreur("<h1>Echec</h1>");
//
// Affichage menu
//
echo "<h1>Menu configurateur</h1>";
if ($type_agenda == 'aucun') {
  echo "<a href=\"?exec=epona_conf&action=agen_secteur\">Cr&eacute;er l'agenda secteur</a><br>";
  echo "<a href=\"?exec=epona_conf&action=agen_mot\">Cr&eacute;er l'agenda mot</a><br>";
  echo "<a href=\"?exec=epona_conf&action=agen_complet\">Cr&eacute;er l'agenda complet</a><br>";
}
echo "<a href=\"?exec=epona_conf&action=mots_on\">Cr&eacute;er groupes mot-cl&eacute;s manquants</a><br>";
echo "<a href=\"?exec=epona_conf&action=menu\">Cr&eacute;er un menu HTML (facultatif)</a><br>";
echo "<a href=\"?exec=epona_conf&action=menudef\">Revenir au menu SPIP de base</a><br>";
echo '<br>';
echo "<a href=../squelettes/sql.txt>Infos pour configuration manuelle et optimisation</a><br>";
echo "<a href=../squelettes/MODIFS.txt>Description des changements</a><br>";
echo 'Retour au site <a href="../?recalcul=oui">Public</a> <a href="../ecrire">Priv&eacute;</a><br>';
//
// Affichage etat final
//
echo '<div id="etat">';
echo '<h3>Etat de la configuration:</h3>';
dossier_squel();
echo "Agenda :  $type_agenda<br>";
$id_rubrique = id_agenda();
if ($id_rubrique == 0) {echo "Rubrique Agenda : absente<br>";} else {
  echo "Rubrique Agenda : pr&eacute;sente<br>";
  if (!rubrique_vide($id_rubrique)) avertir("Rubrique Agenda non vide");
}
foreach (array('Agenda', '_Agenda', 'Epona', 'Album', '_Article', '_Rubrique') as $titre) {
  $id_groupe=id_groupe($titre);
  if ($id_groupe == 0) {echo  "Groupe ".$titre." : absent<br>";} else {
    echo  "Groupe ".$titre." : pr&eacute;sent<br>";
    pre_desactive_groupe($titre);
  }
}
echo '</div>';

?>

</body>
</html>

