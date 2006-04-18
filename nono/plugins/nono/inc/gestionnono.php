<? 
function nono_install(){
	nono_verifier_base();
}

function nono_uninstall(){
	include_spip('base/liste_meta_nono');
	include_spip('base/abstract_sql');

	// suppression du champ evenements a la table spip_groupe_mots
	$query = "ALTER TABLE `spip_meta` DROP `xxxx`";
	spip_query($query);
	
}

function nono_verifier_base(){
	$version_base = 0.2;
	$current_version = 0.0;
	if (   (!isset($GLOBALS['meta']['nono_base_version']) )
			|| (($current_version = $GLOBALS['meta']['nono_base_version'])!=$version_base)){
		include_spip('base/nono_tables');
		if ($current_version==0.0){
			include_spip('base/create');
			include_spip('base/abstract_sql');
			creer_base();
			// ajout du champ evenements a la table spip_groupe_mots
			// si pas deja existant
			$desc = spip_abstract_showtable("spip_meta");
			if (!isset($desc['field']['xxxx'])){
				$query = "ALTER TABLE `spip_meta` ADD `xxxx` VARCHAR(3) NOT NULL AFTER `syndic`";
				spip_query($query);
			}
			$current_version = $version_base;
		}
		if ($current_version<0.11){
			$query = "ALTER TABLE `spip_evenements` ADD `horaire` ENUM('oui','non') DEFAULT 'oui' NOT NULL AFTER `lieu`";
			spip_query($query);
		}
		
		ecrire_meta('nono_base_version',$version_base);
		ecrire_metas();
	}
}



?>