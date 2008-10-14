<?php 
function exec_eva_mentions_admin_dist() {
   include_spip("inc/presentation");
    // vérifier les droits
   global $connect_statut;
   global $connect_toutes_rubriques;
   if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {    
       debut_page(_T('titre'), "saveauto_admin", "plugin");
       echo _T('avis_non_acces_page');
       fin_page();
       exit;
   }

$icone = _DIR_PLUGIN_EVAMENTIONS."/img_pack/install.png";
$commencer_page = charger_fonction('commencer_page', 'inc');

   echo $commencer_page(_T('evamentions:titre_page'),'','','');	 
   echo "<br />";
   
   echo gros_titre(_T('evamentions:titre_page'),'',false);
   echo debut_gauche('',true);
	
   echo debut_boite_info(true);
   echo _T('evamentions:boite_info');

   echo '<br /><br /> Texte complet de la LCEN :';
   echo '<br /><a href="http://www.legifrance.gouv.fr/texteconsolide/PCEBX.htm" target="_blank" >L&eacute;gifrance</a>';
   echo '<br /><br /> Documentation officielle EVA-WEB :';
   echo '<br /><a href="http://eva-web.edres74.net/spip.php?rubrique4" target="_blank" >Documentation eva-web</a>';
   echo fin_boite_info(true);
	
   //echo debut_raccourcis();
   //echo 'contenu de la boite des raccourcis du plugin';
   //echo fin_raccourcis();
		
   echo debut_droite('',true);
   echo debut_cadre_trait_couleur($icone, true,'', _T('evamentions:titre_boite_principale'));
   echo debut_cadre_couleur('',true);

   echo _T('evamentions:lcen');
   echo "<br />"._T('evamentions:etab').lire_config('eva_mentions/structure');
   echo "<br /><br />"._T('evamentions:directeur').lire_config('eva_mentions/directeur');
   echo "<br /><br />"._T('evamentions:responsable').lire_config('eva_mentions/responsable');
   echo "<br /><br />"._T('evamentions:hebergeur').lire_config('eva_mentions/hebergeur');
   echo "<br /><br />"._T('evamentions:adresse').lire_config('eva_mentions/adresse');
   echo "<br /><br />"._T('evamentions:webmaster').lire_config('eva_mentions/webmaster');
   echo "<br /><br />"._T('evamentions:fonction').lire_config('eva_mentions/fonction');

$id = lire_config('eva_mentions/idwebmaster');
   echo "<br /><br /><strong>"._T('evamentions:idwebmaster')."</strong>";
   echo "<a href='?exec=auteur_infos&id_auteur=".$id."'>$id</a>";
   echo "<br /><br />";
   
   echo fin_cadre_couleur(true);
   
   echo '<form method="post" action="?exec=cfg&cfg=eva_mentions">';
    echo '<input type="submit" class="fondo" value="';
    echo _T('evamentions:modif_renseignements');
    echo '" />';
    echo '</form>';
   echo '<br />';

   echo '<form method="post" action="../spip.php?page=mentions">';
    echo '<input type="submit" class="fondo" value="';
    echo _T('evamentions:page_publique');
    echo '" />';
    echo '</form>';
   
   echo fin_cadre_trait_couleur(true);
   echo fin_gauche(), fin_page();
}				 
?>
