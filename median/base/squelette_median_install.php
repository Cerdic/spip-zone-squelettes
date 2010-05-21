<?php

  if (!defined("_ECRIRE_INC_VERSION")) return;

	function squelette_median_installation($num_version){
    include_spip('base/create');
    include_spip('base/abstract_sql');

  // forcer l'utilisation des mots clés
    if (lire_meta('articles_mots') == 'non') ecrire_meta('articles_mots', 'oui');

  // création du groupe de mots clé squelette_median et de ses mots clés
    $Terreur = array();
    $Tstatuts = array('_invisible_','bloc_sommaire', 'edito_rubrique', 'form_account_creation',
                          'page_contact', 'page_souscription', 'photos_sommaire', 'restricted_access',
                          'port_folio_left', 'classement_date', 'classement_date_inverse');

    if (sql_countsel('spip_groupes_mots', "titre = 'squelette_Median'") == 0) {
        $id_groupe = sql_insertq('spip_groupes_mots',
                   array('titre'=>'squelette_Median', 'descriptif'=>_T('median:mots_cles_techniques_median'),
                         'tables_liees'=>'articles,breves,rubriques,syndic', 'minirezo'=>'oui')
                  );
        if (sql_errno() != 0) die((_T('median:erreur_install_groupe_technique ')).sql_error());
    }
    else {
    	$res = sql_fetsel(array('id_groupe'), 'spip_groupes_mots', "titre = 'squelette_Median'");
        $id_groupe = $res['id_groupe'];
        if (sql_errno() != 0) die((_T('median:erreur_install_groupe_technique ')).sql_error());
    }

    foreach ($Tstatuts as $st) {
        if (sql_countsel('spip_mots', "titre = '".$st."'") == 0) {
            sql_insertq('spip_mots',
                      array('titre'=>$st, 'id_groupe'=>$id_groupe, 'type'=>'squelette_Median')
                     );
            if (sql_errno() != 0) $Terreurs[] = (_T('erreur_creation_mot_cle')).$st.': '.sql_error();
        }
    }


  // création du groupe de mots clés Coordonnees et de ses mots cles
    if (sql_countsel('spip_groupes_mots', "titre = Coordonnees") == 0) {

        $id_groupe = sql_insertq('spip_groupes_mots',
                   array('titre'=>'Coordonnees', 'descriptif'=> _T('median:mots_cles_coordonnees'))
                  );
        if (sql_errno() != 0) die((_T('median:erreur_install_groupe_coordonnees')).sql_error());

        $Tstatuts = array('1. Tel','2. Fax', '3. Adress', '4. E-mail');
        foreach ($Tstatuts as $st) {
          sql_insertq('spip_mots',
                      array('titre'=>$st, 'id_groupe'=>$id_groupe, 'type'=>'Coordonnees')
                     );
          if (sql_errno() != 0) $Terreurs[] = (_T('erreur_creation_mot_cle')).$st.': '.sql_error();
        }
    }

  // stocker le num de version dans spip_meta
    ecrire_meta('squelette_median_version',$num_version);

    if (count($Terreurs) != 0) echo implode('<br>',$Terreurs);

	}

	function squelette_median_desinstallation() {
		effacer_meta('squelette_median_version');
		ecrire_metas();
	}

	function squelette_median_install($action){
    // vérifier les droits
      global $connect_statut, $connect_toutes_rubriques;
      if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
          debut_page(_T('titre'), "aff_zone", "plugin");
          echo _T('avis_non_acces_page');
          fin_page();
          exit;
      }

    // récupérer le numéro de version
      $Tplugins_actifs = liste_plugin_actifs();
      $version_script = $Tplugins_actifs['SQUELETTE_MEDIAN']['version'];

    // test/install/désinstall ?
		  switch ($action){
			case 'test':
				return (lire_meta('squelette_median_version') == $version_script);
			case 'install':
				if (lire_meta('squelette_median_version') != $version_script)
					squelette_median_installation($version_script);
				break;
			case 'uninstall':
				squelette_median_desinstallation();
				break;
		}
	}

?>
