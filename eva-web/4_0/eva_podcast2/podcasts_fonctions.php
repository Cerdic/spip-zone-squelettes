<?php


	/**
	 * SPIP-podcasts : plugin de gestion de podcasts
	 *  
	 * Ce programme est un logiciel libre distribue sous licence GNU/GPL.
	 * Pour plus de details voir le fichier COPYING.txt.
	 *  
	 **/


	include_spip('base/create');
	include_spip('base/podcasts');
	include_spip('inc/plugin');

	/**
	 * podcasts_header_prive
	 *
	 * Vérifie que la base est à jour
	 *
	 * @param string texte
	 * @return string texte avec le chemin modifié
	 **/
	function podcasts_header_prive($texte) { 
		podcasts_verifier_base();
		return $texte;
	}


	/**
	 * podcasts_taches_generales_cron
	 *
	 * Ajout des tâches planifiées pour le plugin
	 *
	 * @param array taches_generales
	 * @return true
	 **/
	function podcasts_taches_generales_cron($taches_generales) {
		$taches_generales['podcasts'] = 60 * 5; // toutes les 5 minutes
		return $taches_generales;
	}


	/**
	 * cron_podcasts
	 *
	 * Tâche de fond pour publier/terminer les podcasts
	 *
	 * @param array taches_generales
	 * @return true
	 **/
	function cron_podcasts($t) {
		$requete_tous_les_podcasts_en_ligne = 'SELECT id_podcast FROM spip_podcasts WHERE en_ligne="oui"';
		$resultat_tous_les_podcasts_en_ligne = spip_query($requete_tous_les_podcasts_en_ligne);
		while (list($id_podcast) = spip_fetch_array($resultat_tous_les_podcasts_en_ligne, SPIP_NUM)) {
			podcasts_mettre_a_jour_podcast($id_podcast);
		}
		return true;
	}


	/**
	 * podcasts_accueil
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_accueil($flux) {
		global $spip_lang_left, $connect_statut;

		if ($connect_statut == "0minirezo") {
			switch($flux['args']['zone']) {

			 	case 'gadget_0minirezo' :
					$flux['data'].= "<td>";
					$flux['data'].= icone_horizontale(_T('podcasts:raccourci_creer_nouveau_podcast'), generer_url_ecrire("podcasts_edit", "new=oui"), '../'._DIR_PLUGIN_podcastS.'/img_pack/podcasts-24.png', 'creer.gif', false);
					$flux['data'].= "</td>";
					break;

				case 'etat_base' :
					$res = spip_query("SELECT COUNT(*) AS cnt, statut FROM spip_podcasts GROUP BY statut");
					while($row = spip_fetch_array($res)) {
						$var  = 'nb_podcasts_'.$row['statut'];
						$$var = $row['cnt'];
					}
					if ($nb_podcasts_en_attente OR $nb_podcasts_publie OR $nb_podcasts_termine) {
						$flux['data'].= afficher_plus(generer_url_ecrire("podcasts_tous",""))."<b>"._T('podcasts:podcasts')."</b>";
						$flux['data'].= "<ul style='margin:0px; padding-$spip_lang_left: 20px; margin-bottom: 5px;'>";
						$flux['data'].= "<li>"._T("podcasts:nb_podcasts").": ".($nb_podcasts_en_attente + $nb_podcasts_publie + $nb_podcasts_termine);
						if ($nb_podcasts_en_attente)	$flux['data'].= "<li>"._T("podcasts:nb_podcasts_en_attente").": ".$nb_podcasts_en_attente;
						if ($nb_podcasts_publie)		$flux['data'].= "<li>"._T("podcasts:nb_podcasts_publie").": ".$nb_podcasts_publie;
						if ($nb_podcasts_termine)		$flux['data'].= "<li>"._T("podcasts:nb_podcasts_termine").": ".$nb_podcasts_termine;
						$flux['data'].= "</ul>";
					}
					break;

			}
		}
		return $flux;
	}


	/**
	 * podcasts_gadgets
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_gadgets($flux) {
		global $spip_lang_left, $couleur_foncee, $connect_statut;

		if ($connect_statut == "0minirezo") {
			switch($flux['args']['zone']) {
				case 'raccourcis' :
					$flux['data'].= "<div style='width: 140px; float: $spip_lang_left;'>";
					$flux['data'].= icone_horizontale(_T('podcasts:raccourci_creer_nouveau_podcast'), generer_url_ecrire("podcasts_edit", "new=oui"), '../'._DIR_PLUGIN_podcastS.'/img_pack/podcasts-24.png', 'creer.gif', false);
					$flux['data'].= "</div>";
					break;
			}
		}
		return $flux;
	}


	/**
	 * podcasts_raccourcis_naviguer
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_raccourcis_naviguer($flux) {
		global $connect_statut;
		if ($connect_statut == "0minirezo") {
			$id_rubrique = $flux['args']['id_rubrique'];
			$flux['data'].= icone_horizontale(_T('podcasts:raccourci_creer_nouveau_podcast'), generer_url_ecrire("podcasts_edit", "id_rubrique=$id_rubrique&new=oui"), '../'._DIR_PLUGIN_podcastS.'/img_pack/podcasts-24.png', 'creer.gif', false);
		}
		return $flux;
	}


	/**
	 * podcasts_contenu_naviguer
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_contenu_naviguer($flux) {
		global $spip_lang_right;
		global $connect_statut;
		if ($connect_statut == "0minirezo") {
			$id_rubrique = $flux['args']['id_rubrique'];
			$flux['data'].= podcasts_afficher_podcasts(_T('podcasts:tous_podcasts_rubrique'), array("FROM" => 'spip_podcasts', "WHERE" => "id_rubrique='$id_rubrique'", 'ORDER BY' => "maj DESC"), '../'._DIR_PLUGIN_LETTRE_INFORMATION.'/img_pack/lettre-24.png');
			$flux['data'].= "<div align='$spip_lang_right'>";
			$flux['data'].= icone(_T('podcasts:raccourci_creer_nouveau_podcast'), generer_url_ecrire("podcasts_edit", "id_rubrique=$id_rubrique&new=oui"), '../'._DIR_PLUGIN_podcastS.'/img_pack/podcasts-24.png', 'creer.gif', '', 'non');
			$flux['data'].= "</div><p>";
		}
		return $flux;
	}


	/**
	 * podcasts_brouteur_frame
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_brouteur_frame($flux) {
		global $connect_statut;
		if ($connect_statut == "0minirezo") {
			$id_rubrique = $flux['args']['id_rubrique'];

			$result = spip_query("SELECT * FROM spip_podcasts WHERE id_rubrique='$id_rubrique' ORDER BY titre");
			if (spip_num_rows($result)>0) {
				$flux['data'].= "<div style='padding-top: 6px; padding-bottom: 3px;'><b class='verdana2'>"._T('podcasts:podcasts')."</b></div>";
				$flux['data'].= "<div class='plan-articles'>";
				while($row = spip_fetch_array($result)){
					$id_podcast	= $row['id_podcast'];
					$titre		= typo($row['titre']);
					$statut		= $row['statut'];
					$en_ligne	= $row['en_ligne'];
					switch ($en_ligne) {
						case 'non':
							$classe = 'prepa';
							break;
						case 'oui':
							switch ($statut) {
								case 'en_attente' :
									$classe = 'prop';
									break;
								case 'publie' :
									$classe = 'publie';
									break;
								case 'termine' :
									$classe = 'poubelle';
									break;
							}
							break;
					}
					$flux['data'].= '<a class="'.$classe.'" href="javascript:window.parent.location=\''.generer_url_ecrire('podcasts',"id_podcast=$id_podcast").'\'">'.$titre.'</a>';
				}
				$flux['data'].= "</div>";
			}
		}
		return $flux;
	}


	/**
	 * podcasts_tester_rubrique_vide
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_tester_rubrique_vide($flux) {
		global $connect_statut;
		if ($connect_statut == "0minirezo") {
			$id_rubrique = $flux['args']['id_rubrique'];
			$nb_podcasts = spip_num_rows(spip_query('SELECT id_podcast FROM spip_podcasts WHERE id_rubrique="'.$id_rubrique.'"'));
			$flux['data'] = $flux['data'] + $nb_podcasts;
		}
		return $flux;
	}


	/**
	 * podcasts_calculer_rubriques
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_calculer_rubriques($flux) {
		// Publier et dater les rubriques qui ont un podcast
		$r = spip_query("SELECT rub.id_rubrique AS id,
		max(fille.maj) AS date
		FROM spip_rubriques AS rub, spip_podcasts AS fille
		WHERE rub.id_rubrique = fille.id_rubrique
		AND rub.date_tmp <= fille.maj AND fille.en_ligne='oui'
		GROUP BY rub.id_rubrique");
		while ($row = spip_fetch_array($r))
			spip_query("UPDATE spip_rubriques
			SET statut_tmp='publie', date_tmp='".$row['date']."'
			WHERE id_rubrique=".$row['id']);
		return $flux;
	}


	/**
	 * podcasts_propager_les_secteurs
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_propager_les_secteurs($flux) {
		// propager les secteurs aux podcasts
		$r = spip_query("SELECT fille.id_podcast AS id, maman.id_secteur AS secteur
		FROM spip_podcasts AS fille, spip_rubriques AS maman
		WHERE fille.id_rubrique = maman.id_rubrique
		AND fille.id_secteur <> maman.id_secteur");
		while ($row = spip_fetch_array($r))
			spip_query("UPDATE spip_podcasts SET id_secteur=".$row['secteur']." WHERE id_podcast=".$row['id']);

		return $flux;
	}


	/**
	 * podcasts_calculer_langues_rubriques
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_calculer_langues_rubriques($flux) {
		$s = spip_query("SELECT fille.id_podcast AS id_podcast, mere.lang AS lang
			FROM spip_podcasts AS fille, spip_rubriques AS mere
			WHERE fille.id_rubrique = mere.id_rubrique
			AND fille.langue_choisie != 'oui' AND (fille.lang='' OR mere.lang<>'')
			AND mere.lang<>fille.lang");
		while ($row = spip_fetch_array($s)) {
			$id_podcast = $row['id_podcast'];
			spip_query("UPDATE spip_podcasts SET lang=" . spip_abstract_quote($row['lang']) . ", langue_choisie='non' WHERE id_podcast=$id_podcast");
		}
		return $flux;
	}


	/**
	 * podcasts_recherche
	 *
	 * @param array flux
	 * @return array flux
	 **/
	function podcasts_recherche($flux) {
		$args = $flux['args'];
		$data = $flux['data'];
		$activer_moteur = ($GLOBALS['meta']['activer_moteur'] == 'oui');

		$testnum		= $args['testnum'];
		$recherche		= $args['recherche'];
		$where			= $args['where'];
		$hash_recherche = $args['hash_recherche'];

		$query_podcasts['FROM'] = 'spip_podcasts';
		$query_podcasts['WHERE'] = ($testnum ? "(id_podcast = $recherche)" :'') . $where;
		$query_podcasts['ORDER BY'] = "maj DESC";

		if ($activer_moteur) {	// texte integral
			$query_podcasts_int = requete_txt_integral('spip_podcasts', $hash_recherche);
		}

		$nbs = podcasts_afficher_podcasts(_T('podcasts:podcasts_trouves'), $query_podcasts);

		if ($activer_moteur) {
			if ($nbs) {
				$query_podcasts_int['WHERE'] .= " AND objet.id_podcast NOT IN ($doublons)";
			}
			$nbs1 = podcasts_afficher_podcasts(_T('podcasts:podcasts_trouves_dans_texte'), $query_podcasts_int);
		}

		if ($data) $resultat = true;
		else
			if ($nbs) $resultat = true;
			else
				if ($nbs1) $resultat = true;
				else $resultat = false;

		return array('args' => $args, 'data' => $resultat);
	}


	/**
	 * podcasts_calculer_pourcentage
	 *
	 * calcule le pourcentage associé à un choix
	 *
	 * @param int id_podcast
	 * @param int id_choix
	 * @return string pourcentage
	 **/
	function podcasts_calculer_pourcentage($id_podcast, $id_choix) {
		$requete_total_podcast = 'SELECT A.id_avis
								FROM spip_avis AS A, spip_sondes AS S 
								WHERE S.id_sonde=A.id_sonde
									AND S.id_podcast="'.$id_podcast.'"';
		$resultat_total_podcast = spip_query($requete_total_podcast);
		$total_podcast = intval(spip_num_rows($resultat_total_podcast));
		
		$requete_total_avis = 'SELECT A.id_avis
								FROM spip_avis AS A, spip_sondes AS S 
								WHERE S.id_sonde=A.id_sonde
									AND A.id_choix="'.$id_choix.'"
									AND S.id_podcast="'.$id_podcast.'"';
		$resultat_total_avis = spip_query($requete_total_avis);
		$total_avis = intval(spip_num_rows($resultat_total_avis));
		
		if ($total_podcast == 0) {
			return 0;
		} else {
			$pourcentage = ( ($total_avis / $total_podcast) * 100 );
			$pourcentage = number_format($pourcentage, 1, '.', '');
			return $pourcentage;
		}
	}


	/**
	 * podcasts_pourcentage
	 *
	 * calcule le pourcentage associé à un choix
	 *
	 * @param int total_avis
	 * @param int id_podcast
	 * @return string pourcentage
	 **/
	function podcasts_pourcentage($total_avis, $id_podcast) {
		$requete_total_podcast = 'SELECT A.id_avis
								FROM spip_avis AS A, spip_sondes AS S 
								WHERE S.id_sonde=A.id_sonde
									AND S.id_podcast="'.$id_podcast.'"';
		$resultat_total_podcast = spip_query($requete_total_podcast);
		$total_podcast = intval(spip_num_rows($resultat_total_podcast));
		
		$pourcentage = ( ($total_avis / $total_podcast) * 100 );
		$pourcentage = number_format($pourcentage, 1, '.', '');
		return $pourcentage;
	}


	/**
	 * podcasts_largeur
	 *
	 * calcule la largeur pour le total passé en argument
	 *
	 * @param int total_avis
	 * @param int id_podcast
	 * @param int largeur_max
	 * @return string pourcentage
	 **/
	function podcasts_largeur($total_avis, $id_podcast, $largeur_max) {
		$requete_total_podcast = 'SELECT A.id_avis
								FROM spip_avis AS A, spip_sondes AS S 
								WHERE S.id_sonde=A.id_sonde
									AND S.id_podcast="'.$id_podcast.'"';
		$resultat_total_podcast = spip_query($requete_total_podcast);
		$total_podcast = intval(spip_num_rows($resultat_total_podcast));
		
		$requete_max = 'SELECT COUNT(id_choix) AS total
						FROM spip_avis
						WHERE id_podcast="'.$id_podcast.'"
						GROUP BY id_choix
						ORDER BY total DESC 
						LIMIT 1';
		$resultat_max = spip_query($requete_max);
		list($max) = spip_fetch_array($resultat_max, SPIP_NUM);
		if ($max == 0)
			return '';
		
		$rapport = $total_avis / $max;
		$largeur = $rapport * $largeur_max;

		return $largeur;
	}


	/**
	 * balise_URL_podcast
	 *
	 * @param p est un objet SPIP
	 * @return string url d'un podcast
	 **/
	function balise_URL_podcast($p) {
		$_id_podcast = '';
		if ($p->param && !$p->param[0][0]){
			$_id_podcast =  calculer_liste($p->param[0][1],
								$p->descr,
								$p->boucles,
								$p->id_boucle);
		}
		if (!$_id_podcast)
			$_id_podcast = champ_sql('id_podcast',$p);
		$p->code = "generer_url_public(podcast, 'id_podcast='.$_id_podcast)";
	
		if ($p->boucles[$p->nom_boucle ? $p->nom_boucle : $p->id_boucle]->hash)
		$p->code = "url_var_recherche(" . $p->code . ")";

		$p->interdire_scripts = false;
		return $p;
	}


	/**
	 * balise_POURCENTAGE
	 *
	 * @param p est un objet SPIP
	 * @return float pourcentage
	 **/
	function balise_POURCENTAGE($p) {
		$_id_choix = champ_sql('id_choix',$p);
		$_id_podcast = champ_sql('id_podcast',$p);
		$p->code = "podcasts_calculer_pourcentage($_id_podcast, $_id_choix)";
		$p->statut = 'php';
		return $p;
	}


	/**
	 * balise_POURCENTAGE_MAX
	 *
	 * @param p est un objet SPIP
	 * @return float pourcentage max pour le podcast
	 **/
	function balise_POURCENTAGE_MAX($p) {
		$_id_podcast = champ_sql('id_podcast',$p);
		$p->code = "podcasts_calculer_pourcentage_max($_id_podcast)";
		$p->statut = 'php';
		return $p;
	}


	/**
	 * podcasts_verifier_base
	 *
	 * @return true
	 **/
	function podcasts_verifier_base() {
		$info_plugin_podcasts = plugin_get_infos(_NOM_PLUGIN_podcastS);
		$version_plugin = $info_plugin_podcasts['version'];
		if (!isset($GLOBALS['meta']['spip_podcasts_version'])) {
			creer_base();
			spip_query("ALTER TABLE spip_groupes_mots ADD podcasts VARCHAR(3) NOT NULL DEFAULT 'non';");
			ecrire_meta('spip_podcasts_version', $version_plugin);
			ecrire_meta('fond_podcast', 'podcast');
			ecrire_metas();
		} else {
			$version_base = $GLOBALS['meta']['spip_podcasts_version'];
			if ($version_base < 1.1) {
				creer_base();
				spip_query("ALTER TABLE spip_podcasts ADD idx ENUM('', '1', 'non', 'oui', 'idx') DEFAULT '' NOT NULL;");
				ecrire_meta('spip_podcasts_version', $version_base = 1.1);
				ecrire_metas();
			}
			if ($version_base < 1.2) {
				creer_base();
				spip_query("ALTER TABLE spip_avis ADD id_podcast bigint(21) NOT NULL AFTER id_avis;");
				$requete = 'SELECT C.id_podcast AS id_podcast, 
								A.id_avis AS id_avis
							FROM spip_avis AS A 
							INNER JOIN spip_choix AS C ON C.id_choix=A.id_choix';
				$resultat = spip_query($requete);
				while ($arr = spip_fetch_array($resultat)) 
					spip_query('UPDATE spip_avis SET id_podcast="'.$arr['id_podcast'].'" WHERE id_avis="'.$arr['id_avis'].'"');
				ecrire_meta('spip_podcasts_version', $version_base = 1.2);
				ecrire_metas();
			}
			if ($version_base < 1.3) {
				spip_query("ALTER TABLE spip_podcasts ADD id_secteur BIGINT(21) NOT NULL AFTER id_rubrique;");
				spip_query("ALTER TABLE spip_podcasts ADD langue_choisie VARCHAR(3) DEFAULT 'non' AFTER lang;");
				ecrire_meta('spip_podcasts_version', $version_base = 1.3);
				ecrire_metas();
			}
			if ($version_base < 1.4) {
				creer_base();
				spip_query("ALTER TABLE spip_groupes_mots ADD podcasts VARCHAR(3) NOT NULL DEFAULT 'non';");
				ecrire_meta('spip_podcasts_version', $version_base = 1.4);
				ecrire_metas();
			}
			if ($version_base < 1.5) {
				$req = spip_query('SELECT A.id_avis AS id_avis,
										S.id_podcast AS id_podcast
									FROM spip_avis AS A
									INNER JOIN spip_sondes AS S ON S.id_sonde=A.id_sonde');
				while ($arr = spip_fetch_array($req)) {
					spip_query('UPDATE spip_avis SET id_podcast="'.$arr['id_podcast'].'" WHERE id_avis="'.$arr['id_avis'].'"');
				}
				ecrire_meta('spip_podcasts_version', $version_base = 1.5);
				ecrire_metas();
			}
			if ($version_base < 1.6) {
				list($id_rubrique_publiee) = spip_fetch_array(spip_query('SELECT id_rubrique FROM spip_rubriques WHERE statut="publie" ORDER BY id_rubrique LIMIT 1'), SPIP_NUM);
				$podcasts_racine = spip_query('SELECT id_podcast FROM spip_podcasts WHERE id_rubrique=0');
				while ($arr = spip_fetch_array($podcasts_racine))
					spip_query('UPDATE spip_podcasts SET id_rubrique="'.$id_rubrique_publiee.'" WHERE id_podcast="'.$arr['id_podcast'].'"');
				podcasts_propager_les_secteurs($dummy);
				podcasts_calculer_langues_rubriques($dummy);
				ecrire_meta('spip_podcasts_version', $version_base = 1.6);
				ecrire_metas();
			}
			if ($version_base < 1.7) {
				// renommage des logos de produit
				$tous_les_podcasts = spip_query('SELECT id_podcast FROM spip_podcasts');
				global $table_logos;
				$table_logos['id_podcast'] = 'son';
				$chercher_logo = charger_fonction('chercher_logo', 'inc');
				while ($arr = spip_fetch_array($tous_les_podcasts)) {
					$id_podcast = $arr['id_podcast'];
					if ($logo_on = $chercher_logo($id_podcast, 'id_podcast', 'on')) {
						$ancien_nom = $logo_on[0];
						$nouveau_nom = $logo_on[1].'podcaston'.$id_podcast.'.'.$logo_on[3];
						rename($ancien_nom, $nouveau_nom);
					}
					if ($logo_off = $chercher_logo($id_podcast, 'id_podcast', 'off')) {
						$ancien_nom = $logo_off[0];
						$nouveau_nom = $logo_off[1].'podcastoff'.$id_podcast.'.'.$logo_off[3];
						rename($ancien_nom, $nouveau_nom);
					}
				}
				ecrire_meta('spip_podcasts_version', $version_base = 1.7);
				ecrire_metas();
			}
		}

		if (isset($GLOBALS['meta']['MotsPartout:tables_installees'])) {
			$tables_installees = unserialize($GLOBALS['meta']['MotsPartout:tables_installees']);
			if (!$tables_installees['podcasts']) {
				$tables_installees['podcasts'] = true;
				ecrire_meta('MotsPartout:tables_installees',serialize($tables_installees));
	  			ecrire_metas();
			}
		}

		if (isset($GLOBALS['meta']['INDEX_elements_objet'])){
			$INDEX_elements_objet = unserialize($GLOBALS['meta']['INDEX_elements_objet']);
			if (!isset($INDEX_elements_objet['spip_podcasts'])){
				$INDEX_elements_objet['spip_podcasts'] = array('titre'=>8,'texte'=>1);
				ecrire_meta('INDEX_elements_objet',serialize($INDEX_elements_objet));
				ecrire_metas();
			}
		}

		return true;
	}
	
	
	/**
	 * podcasts_mettre_a_jour_podcast
	 *
	 * met à jour un podcast en fonction de ses dates de début et de fin
	 *
	 * @param int id_podcast
	 * @return true
	 **/
	function podcasts_mettre_a_jour_podcast($id_podcast) {
		$requete_en_attente = 'SELECT statut FROM spip_podcasts WHERE id_podcast="'.$id_podcast.'" AND NOW() < date_debut';
		$resultat_en_attente = spip_query($requete_en_attente);
		if (spip_num_rows($resultat_en_attente) == 1) {
			list($statut) = spip_fetch_array($resultat_en_attente, SPIP_NUM);
			if ($statut != 'en_attente')
				spip_query('UPDATE spip_podcasts SET statut="en_attente" WHERE id_podcast="'.$id_podcast.'"');
			return true;
		}

		$requete_publie = 'SELECT statut FROM spip_podcasts WHERE id_podcast="'.$id_podcast.'" AND NOW() >= date_debut AND NOW() <= date_fin';
		$resultat_publie = spip_query($requete_publie);
		if (spip_num_rows($resultat_publie) == 1) {
			list($statut) = spip_fetch_array($resultat_publie, SPIP_NUM);
			if ($statut != 'publie')
				spip_query('UPDATE spip_podcasts SET statut="publie" WHERE id_podcast="'.$id_podcast.'"');
			return true;
		}

		$requete_termine = 'SELECT statut FROM spip_podcasts WHERE id_podcast="'.$id_podcast.'" AND NOW() > date_fin';
		$resultat_termine = spip_query($requete_termine);
		if (spip_num_rows($resultat_termine) == 1) {
			list($statut) = spip_fetch_array($resultat_termine, SPIP_NUM);
			if ($statut != 'termine')
				spip_query('UPDATE spip_podcasts SET statut="termine" WHERE id_podcast="'.$id_podcast.'"');
			return true;
		}
	}


	/**
	 * podcasts_afficher_statistiques_globales
	 *
	 * @return string un cadre avec qq stats
	 **/
	function podcasts_afficher_statistiques_globales() {
		$info_plugin_lettres = plugin_get_infos(_NOM_PLUGIN_podcastS);

		$requete_nb_podcasts = 'SELECT id_podcast 
								FROM spip_podcasts';
		$nb_podcasts = @spip_num_rows(spip_query($requete_nb_podcasts));
		
		$requete_nb_podcasts_en_ligne = 'SELECT id_podcast 
										FROM spip_podcasts
										WHERE en_ligne="oui"';
		$nb_podcasts_en_ligne = @spip_num_rows(spip_query($requete_nb_podcasts_en_ligne));
		
		$nb_podcasts_hors_ligne = $nb_podcasts - intval($nb_podcasts_en_ligne);
		
		$requete_nb_avis = 'SELECT id_avis
							FROM spip_avis';
		$nb_avis = @spip_num_rows(spip_query($requete_nb_avis));

		$cadre = '';
		$cadre.= debut_cadre_relief("plugin-24.gif", true, "", _T('podcasts:podcasts'));
		$cadre.= "<div class='verdana1'>";
		$cadre.= "<b>"._T('podcasts:plugin')."</b>";
		$cadre.= "<ul style='margin:0px; padding-$spip_lang_left: 20px; margin-bottom: 5px;'>";
		$cadre.= "<li>"._T("podcasts:plugin_version")."&nbsp;: <b>".$info_plugin_lettres['version'].'</b></li>';
		$cadre.= "<li>"._T("podcasts:plugin_auteur")."&nbsp;: <b>".propre($info_plugin_lettres['auteur']).'</b></li>';
		$cadre.= "</ul>";
		$cadre.= "<br />";
		if ($nb_podcasts) {
			$cadre.= "<b>"._T('podcasts:podcasts')."</b>";
			$cadre.= "<ul style='margin:0px; padding-$spip_lang_left: 20px; margin-bottom: 5px;'>";
			$cadre.= "<li>"._T("podcasts:nb_podcasts")."&nbsp;: <b>".$nb_podcasts.'</b></li>';
			if ($nb_podcasts_en_ligne)		$cadre.= "<li>"._T("podcasts:nb_podcasts_en_ligne")."&nbsp;: <b>".$nb_podcasts_en_ligne.'</b></li>';
			if ($nb_podcasts_hors_ligne)	$cadre.= "<li>"._T("podcasts:nb_podcasts_hors_ligne")."&nbsp;: <b>".$nb_podcasts_hors_ligne.'</b></li>';
			if ($nb_avis)					$cadre.= "<li>"._T("podcasts:nb_avis")."&nbsp;: <b>".$nb_avis.'</b></li>';
			$cadre.= "</ul>";
		}
		$cadre.= "</div>";
		// 2 </div> suppélementaires
		$cadre.= "</div>";
		$cadre.= "</div>";
		$cadre.= fin_cadre_relief();
		$cadre.= '<br />';

		echo $cadre;
	}


	/**
	 * podcasts_afficher_raccourci_creer_podcast
	 *
	 * affiche un raccourci vers la création d'un nouveau podcast
	 *
	 **/
	function podcasts_afficher_raccourci_creer_podcast() {
		icone_horizontale(_T('podcasts:raccourci_creer_nouveau_podcast'), generer_url_ecrire("podcasts_edit", "new=oui"), '../'._DIR_PLUGIN_podcastS.'/img_pack/podcasts-24.png', 'creer.gif');
	}


	/**
	 * podcasts_afficher_raccourci_liste_podcasts
	 *
	 * affiche un raccourci vers la liste des podcasts
	 *
	 **/
	function podcasts_afficher_raccourci_liste_podcasts() {
		icone_horizontale(_T('podcasts:raccourci_aller_liste_podcasts'), generer_url_ecrire("podcasts_tous"), '../'._DIR_PLUGIN_podcastS.'/img_pack/podcasts-24.png', '');
	}


	/**
	 * podcasts_afficher_podcasts
	 *
	 * affiche la liste des podcasts
	 *
	 * @param string titre
	 * @param string requete
	 * @return string la liste des podcasts
	 **/
	function podcasts_afficher_podcasts($titre_table, $requete) {

		global $couleur_foncee, $options;

		$tmp_var = 't_' . substr(md5(join('', $requete)), 0, 4);

		if ($options == "avancees") {
			$largeurs = array('12', '', 100, 100, 50);
			$styles = array('arial1', 'arial2', 'arial1', 'arial1', 'arial1');
		} else {
			$largeurs = array('12', '', 100, 100);
			$styles = array('arial1', 'arial2', 'arial1', 'arial1');
		}

		return affiche_tranche_bandeau($requete, _DIR_PLUGIN_podcastS.'/img_pack/podcasts-24.png', $couleur_foncee, 'white', $tmp_var, $titre_table, false, $largeurs, $styles, 'podcasts_afficher_podcasts_boucle', array());
	}


	/**
	 * podcasts_afficher_podcasts_boucle
	 *
	 * affiche une ligne
	 *
	 **/
	function podcasts_afficher_podcasts_boucle($row, &$tous_id, $voir_logo, $own) {
	
		global $connect_id_auteur, $dir_lang, $options, $spip_lang_right;
		
		$vals = '';

		$id_podcast		= $row['id_podcast'];
		$tous_id[]		= $id_podcast;
		$titre			= $row['titre'];
		$date_debut		= $row['date_debut'];
		$date_fin		= $row['date_fin'];
		$statut			= $row['statut'];

		switch ($statut) {
			case 'brouillon':
				$vals[] = http_img_pack("puce-blanche.gif", "puce-blanche", "border='0' style='margin: 1px;'");
				break;
			case 'en_attente':
				$vals[] = http_img_pack("puce-orange.gif", "puce-orange", "border='0' style='margin: 1px;'");
				break;
			case 'publie':
				$vals[] = http_img_pack("puce-verte.gif", "puce-verte", "border='0' style='margin: 1px;'");
				break;
			case 'termine':
				$vals[] = http_img_pack("puce-poubelle.gif", "puce-poubelle", "border='0' style='margin: 1px;'");
				break;
		}

		$s = "<div><a href='" . generer_url_ecrire("plans","id_plan=$id_plan") . "'>";
		if ($voir_logo) {
			$chercher_logo = charger_fonction('chercher_logo', 'inc');
			if ($logo = $chercher_logo($id_plan, 'id_plan', 'on')) {
				list($fid, $dir, $nom, $format) = $logo;
				include_spip('inc/filtres_images');
				$logo = image_reduire("<img src='$fid' alt='' />", 26, 20);
				if ($logo)
					$s .= "\n<span style='float: $spip_lang_right; margin-top: -2px; margin-bottom: -2px;'>$logo</span>";
			}
		}

		$s = "<div>";
		$s .= "<a href='" . generer_url_ecrire("podcasts","id_podcast=$id_podcast") .
			"'$dir_lang style=\"display:block;\">";
		if ($voir_logo) {
			$chercher_logo = charger_fonction('chercher_logo', 'inc');
			if ($logo = $chercher_logo($id_podcast, 'id_podcast', 'on')) {
				list($fid, $dir, $nom, $format) = $logo;
				include_spip('inc/filtres_images');
				$logo = image_reduire("<img src='$fid' alt='' />", 26, 20);
				if ($logo)
					$s .= "\n<span style='float: $spip_lang_right; margin-top: -2px; margin-bottom: -2px;'>$logo</span>";
			}
		}
		$s .= typo($titre);
		$s .= "</a>";
		$s .= "</div>";
	
		$vals[] = $s;

		$vals[] = affdate_jourcourt($date_debut);
		$vals[] = affdate_jourcourt($date_fin);


		if ($options == "avancees") {
			$vals[] = "<b>"._T('info_numero_abbreviation')."$id_podcast</b>";
		}
	
		return $vals;
	}


	/**
	 * podcasts_afficher_numero_podcast
	 *
	 * @param int id_podcast
	 * @param boolean prévisualisation
	 * @param boolean statistiques
	 **/
	function podcasts_afficher_numero_podcast($id_podcast, $previsu=false, $statistiques=false) {
		echo "<br />";
		debut_boite_info();
		echo "<div align='center'>\n";
		echo "<font face='Verdana,Arial,Sans,sans-serif' size='1'><b>"._T('podcasts:numero_podcast')."</b></font>\n";
		echo "<br><font face='Verdana,Arial,Sans,sans-serif' size='6'><b>$id_podcast</b></font>\n";
		$fond_podcast = $GLOBALS['meta']['fond_podcast'];
		if ($previsu) {
			podcasts_icone_horizontale_nouvelle_fenetre(_T('podcasts:previsualiser'), generer_url_podcast($id_podcast, true), $image, "racine-24.gif", true, 'target="_blank"');
		}
		echo "</div>\n";
		fin_boite_info();
	}


	/**
	 * podcasts_icone_horizontale_nouvelle_fenetre
	 *
	 **/
	function podcasts_icone_horizontale_nouvelle_fenetre($texte, $lien, $fond = "", $fonction = "", $echo = true, $javascript='') {
		global $spip_display;

		$retour = '';


		if ($spip_display != 4) {
			//if (!$fonction) $fonction = "rien.gif";
	
			if ($spip_display != 1) {
				$retour .= "<a href='$lien' class='cellule-h' $javascript>";
				$retour .= "<table cellpadding='0' valign='middle'><tr>\n";
				$retour .= "<td><a href='$lien' class='cellule-h' $javascript><div class='cell-i'>" ;
				if ($fonction){
				  $retour .= http_img_pack($fonction, "", http_style_background($fond, "center center no-repeat"));
				}
				else {
					$retour .= http_img_pack($fond, "", "");
				}
				$retour .= "</div></a></td>\n" .
				  "<td class='cellule-h-lien'><a href='$lien' class='cellule-h' $javascript>$texte</a></td>\n";
				$retour .= "</tr></table>\n";
				$retour .= "</a>\n";
			}
			else {
				$retour .= "<a href='$lien' class='cellule-h-texte' $javascript><div>$texte</div></a>\n";
			}
			if ($fonction == "supprimer.gif")
				$retour = "<div class='danger'>$retour</div>";
		} else {
			$retour = "<li><a href='$lien' $javascript>$texte</a></li>";
		}

		if ($echo) echo $retour;
		return $retour;
	}


	/**
	 * podcasts_afficher_dates
	 *
	 * @param datetime date de debut
	 * @param datetime date de fin
	 * @param boolean affiche pour modifs
	 **/
	function podcasts_afficher_dates($date_debut, $date_fin, $modif=false) {
		$titre_barre = _T('podcasts:periode_de_validite').'<br>'._T('podcasts:du').'&nbsp;'.majuscules(affdate($date_debut)).'&nbsp;'._T('podcasts:au').'&nbsp;'.majuscules(affdate($date_fin));
		if ($modif) {
			debut_cadre_enfonce('../'._DIR_PLUGIN_podcastS.'/img_pack/periode.png', false, "", bouton_block_invisible('dates').$titre_barre);
			echo debut_block_invisible('dates');
			echo "<table border='0' width='100%' style='text-align: right'>";
			echo "<tr>";
			echo "	<td><span class='verdana1'><B>"._T('podcasts:changer_date_debut')."</B></span> &nbsp;</td>";
			echo "	<td>";
			echo afficher_jour(affdate($date_debut, 'jour'), "name='jour_debut' size='1' class='fondl'", true);
			echo afficher_mois(affdate($date_debut, 'mois'), "name='mois_debut' size='1' class='fondl'", true);
			echo afficher_annee(affdate($date_debut, 'annee'), "name='annee_debut' size='1' class='fondl'");
			echo "	</td>";
			echo "	<td>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
			echo "	<td><span class='verdana1'><B>"._T('podcasts:changer_date_fin')."</B></span> &nbsp;</td>";
			echo "	<td>";
			echo afficher_jour(affdate($date_fin, 'jour'), "name='jour_fin' size='1' class='fondl'", true);
			echo afficher_mois(affdate($date_fin, 'mois'), "name='mois_fin' size='1' class='fondl'", true);
			echo afficher_annee(affdate($date_fin, 'annee'), "name='annee_fin' size='1' class='fondl'");
			echo "	</td>";
			echo "	<td> &nbsp; <INPUT TYPE='submit' NAME='changer_dates' VALUE='"._T('podcasts:changer')."' CLASS='fondo' STYLE='font-size:10px'></td>";
			echo "</tr>";
			echo "</table>";
			echo fin_block();
			fin_cadre_enfonce();
		} else {
			debut_cadre_enfonce('../'._DIR_PLUGIN_podcastS.'/img_pack/date.png', false, "", $titre_barre);
			fin_cadre_enfonce();
		}
	}


	/**
	 * podcasts_afficher_auteurs
	 *
	 * @param int id_podcast
	 * @param boolean affiche pour modifs
	 **/
	function podcasts_afficher_auteurs($id_podcast, $modif=false) {
		$titre_barre = _T('podcasts:auteurs');

		if ($modif)
			debut_cadre_enfonce('../'._DIR_PLUGIN_podcastS.'/img_pack/auteurs.png', false, "", bouton_block_invisible('auteurs').$titre_barre);
		else
			debut_cadre_enfonce('../'._DIR_PLUGIN_podcastS.'/img_pack/auteurs.png', false, "", $titre_barre);

		$tableau_auteurs_interdits = array();

		$auteurs_associes = 'SELECT A.id_auteur,
								A.email,
								A.nom
							FROM spip_auteurs AS A
							INNER JOIN spip_auteurs_podcasts AS AL ON AL.id_auteur=A.id_auteur
							WHERE AL.id_podcast="'.$id_podcast.'"
							ORDER BY A.nom';
		$resultat_auteurs_associes = spip_query($auteurs_associes);
		if (@spip_num_rows($resultat_auteurs_associes) > 0) {
			echo "<div class='liste'>\n";
			echo "<table width='100%' cellpadding='3' cellspacing='0' border='0' background=''>\n";
			while ($arr = spip_fetch_array($resultat_auteurs_associes)) {
				$tableau_auteurs_interdits[] = $arr['id_auteur'];
				echo "<tr class='tr_liste'>\n";
				echo "<td width='25' class='arial11'>\n";
				echo "</td>\n";
				echo "<td class='arial2'>\n";
				echo "<A HREF='".generer_url_ecrire("auteur_infos","id_auteur=".$arr['id_auteur'], '&')."'>\n";
				echo propre($arr['nom']);
				echo "</A>\n";
				echo "</td>\n";
				echo "<td class='arial2'>\n";
				echo $arr['email'];
				echo "</td>\n";
				if ($modif) {
					echo "<td class='arial1'>\n";
					echo "<A HREF='".generer_url_ecrire("podcasts","id_podcast=$id_podcast&supprimer_auteur=".$arr['id_auteur'], '&')."'>\n";
					echo _T('podcasts:retirer_auteur')."\n";
					echo "</A>\n";
					echo "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
			echo "</div>\n";
		}
		if ($modif) {
			$auteurs_interdits = implode(",", $tableau_auteurs_interdits);
			if (!empty($auteurs_interdits))
				$where_auteurs_interdits = ' WHERE A.id_auteur NOT IN ('.$auteurs_interdits.')';
			else
				$where_auteurs_interdits = '';
			$requete = 'SELECT A.id_auteur, 
							A.nom
						FROM spip_auteurs AS A
						'.$where_auteurs_interdits.'
						ORDER BY A.nom';
			$resultat_requete = spip_query($requete);
			if (@spip_num_rows($resultat_requete) > 0) {
				echo debut_block_invisible('auteurs');
				echo "<table border='0' width='100%' style='text-align: right'>";
				echo "<tr>";
				echo "	<td><span class='verdana1'><B>"._T('podcasts:ajouter_auteur')."</B></span> &nbsp;</td>";
				echo "	<td>";
				echo "		<select name='id_auteur' SIZE='1' STYLE='width: 180px;' CLASS='fondl'>";
				while ($arr = spip_fetch_array($resultat_requete)) {
					echo "				<option value='".$arr['id_auteur']."'>".propre($arr['nom'])."</option>";
				}
				echo "		</select><br/>";
				echo "	</td>";
				echo "	<td> &nbsp; <INPUT TYPE='submit' NAME='changer_auteur' VALUE='"._T('podcasts:choisir')."' CLASS='fondo' STYLE='font-size:10px'></td>";
				echo "</tr>";
				echo "</table>";
				echo fin_block();
			}
		}
		fin_cadre_enfonce();
	}
	

	/**
	 * podcasts_afficher_langue
	 *
	 * @param string lang
	 * @param boolean modif
	 **/
	function podcasts_afficher_langue($lang, $modif=false) {
		$titre_barre = _T('podcasts:langue')."&nbsp; (".traduire_nom_langue($lang).")";
		$ret = liste_options_langues('changer_lang', $lang);
		if ($modif)
			debut_cadre_enfonce('langues-24.gif', false, "", bouton_block_invisible('languespodcast').$titre_barre);
		else
			debut_cadre_enfonce('langues-24.gif', false, "", $titre_barre);
		if ($modif) {
			echo debut_block_invisible('languespodcast');
			echo "<table border='0' width='100%' style='text-align: right'>";
			echo "<tr>";
			echo "	<td><span class='verdana1'><B>"._T('podcasts:langue_ce_podcast')."</B></span> &nbsp;</td>";
			echo "	<td>";
			echo '		<select name="lang" size="1" style="width: 180px;"  CLASS="fondl">';
			echo $ret;
			echo '		</select>';
			echo "	</td>";
			echo "	<td> &nbsp; <INPUT TYPE='submit' NAME='changer_langue' CLASS='fondo' VALUE='"._T('podcasts:changer')."' STYLE='font-size:10px'></td>";
			echo "</tr>";
			echo "</table>";
			echo fin_block();
		}
		fin_cadre_enfonce();
	}


	/**
	 * podcasts_modifier_ordre_choix
	 *
	 * @param int id_podcast
	 * @param int id_choix
	 * @param int position
	 **/
	function podcasts_modifier_ordre_choix($id_podcast, $id_choix, $position) {
		$tous_les_choix = 'SELECT id_choix FROM spip_choix WHERE id_podcast="'.$id_podcast.'" AND id_choix!="'.$id_choix.'" ORDER BY ordre';
		$resultat_tous_les_choix = spip_query($tous_les_choix);
		if ($position === 'dernier') {
			$tableau_choix = array();
			while ($arr = spip_fetch_array($resultat_tous_les_choix)) {
				$tableau_choix[] = $arr['id_choix'];
			}
			$tableau_final = array_merge($tableau_choix, array($id_choix));
		} else if ($position == 0) {
			$tableau_choix = array();
			while ($arr = spip_fetch_array($resultat_tous_les_choix)) {
				$tableau_choix[] = $arr['id_choix'];
			}
			$tableau_final = array_merge(array($id_choix), $tableau_choix);
		} else {
			$i = 0;
			$tableau_choix_avant = array();
			$tableau_choix_apres = array();
			$deuxieme_tableau = false;
			while ($arr = spip_fetch_array($resultat_tous_les_choix)) {
				if ($position == $i)
					$deuxieme_tableau = true;
				if ($deuxieme_tableau)
					$tableau_choix_apres[] = $arr['id_choix'];
				else
					$tableau_choix_avant[] = $arr['id_choix'];
				$tableau_choix[] = $arr['id_choix'];
				$i++;
			}
			$tableau_final = array_merge($tableau_choix_avant, array($id_choix), $tableau_choix_apres);
		}

		foreach ($tableau_final as $cle => $valeur) {
			spip_query('UPDATE spip_choix SET ordre="'.$cle.'" WHERE id_choix="'.$valeur.'"');
		}

	}
	

	/**
	 * RACCOURCIS TYPO
	 *
	 **/


	/**
	 * calculer_url_podcast
	 *
	 * permet d'intégrer des raccourcis [lien->podcastXX] ou [->podcastXX] dans les textes
	 *
	 * @param int id_podcast
	 * @param string texte
	 * @param string ancre
	 * @return array lien
	 **/
	function calculer_url_podcast($id_podcast, $texte, $ancre) {
		$lien = generer_url_podcast($id_podcast) . $ancre;
		if (!$texte) {
			$row = @spip_fetch_array(spip_query("SELECT titre FROM spip_podcasts WHERE id_podcast=$id_podcast"));
			$texte = $row['titre'];
		}
		return array($lien, 'spip_in', $texte);
	}


	/**
	 * generer_url_podcast
	 *
	 * génère le lien vers le squelette d'un podcast
	 *
	 * @param int id_podcast
	 * @param boolean preview
	 * @return string url squelette podcast
	 **/
	function generer_url_podcast($id_podcast, $preview=false) {
		if ($preview)
			$var_mode = '&var_mode=preview';
		return generer_url_public('podcast', 'id_podcast='.$id_podcast.$var_mode);
	}


?>