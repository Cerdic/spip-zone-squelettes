<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

include_local(find_in_path("inc-formulaire_inscription.php3"));

// Balise independante du contexte
global $balise_FORMULAIRE_MOT_AUTEUR_collecte ;
$balise_FORMULAIRE_MOT_AUTEUR_collecte = array();

// args[0] est le parametre 'focus' -- [(#FORMULAIRE_PROFIL{focus})]
function balise_FORMULAIRE_MOT_AUTEUR_stat($args, $filtres) {
	if (!$args[0]) $args[0]=0;
	if (!$args[1]) $args[1]=0;
	return $args;
}

function balise_FORMULAIRE_MOT_AUTEUR_dyn($num_form,$old_mot) {
	$new_mot=0;
	$url=new Link();
	$url->delVar("choix_mot_".$num_form);
	$url->delVar("old_mot_".$num_form);
	$_url=$url->getUrl();
	if (($GLOBALS['auteur_session']['statut']!="1comite")
	  &&($GLOBALS['auteur_session']['statut']!="0minirezo")
	  &&($GLOBALS['auteur_session']['statut']!="6forum")){
		return array('formulaire_login_abo', 0, array());
	}
	else {
		
		$table_pref = 'spip';
		if ($GLOBALS['table_prefix']) $table_pref = $GLOBALS['table_prefix'];
		
		$message='';
		if (_request("choix_mot_".$num_form)){
			$new_mot=_request("choix_mot_".$num_form);
			$old_mot=_request("old_mot_".$num_form);
			$query="insert into ".$table_pref."_mots_auteurs(id_auteur,id_mot) values(".$GLOBALS['auteur_session']['id_auteur'].",".$new_mot.")";
			if ($result=spip_query($query)) 
			{
				spip_query("delete from ".$table_pref."_mots_auteurs where id_auteur=".$GLOBALS['auteur_session']['id_auteur']." and id_mot=".$old_mot);
				$old_mot=$new_mot;
				$message="Modifications sauvegard&eacute;es";
			}
			else $message="Erreur &agrave; l'enregistrement";
		}
		if ($message) return "<b>".$message."</b><br/><a href=\"".$_url."&var_mode=calcul\">Actualiser</a>";
		else return array("formulaire_mot_auteur", $GLOBALS['delais'],
						array('id_auteur' => $GLOBALS['auteur_session']['id_auteur'],
							'message' => $message,
							'num_form' => $num_form,
							'old_mot' => $old_mot,
							'url' => $_url
						));
	}
	
}

?>
