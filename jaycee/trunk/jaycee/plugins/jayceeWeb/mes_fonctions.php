<?php

function spip_jaycee( $texte) {
	
	$texte = preg_replace( '!<p>§<---x<\/p>!sU', "<hr class='clearLeft' />", $texte);
	$texte = preg_replace( '!<p>§<---<\/p>!sU', "<hr class='clearLeftHidden' />", $texte);
	$texte = preg_replace( '!<p>§x---><\/p>!sU', "<hr class='clearRight' />", $texte);
	$texte = preg_replace( '!<p>§---><\/p>!sU', "<hr class='clearRightHidden' />", $texte);
	$texte = preg_replace( '!<p>§<---><\/p>!sU', "<hr class='clearBothHidden' />", $texte);
		
	return $texte;
}

function changeURL( $texte, $asCherche, $asRemplace) {
	$texte = preg_replace( '!(.*)'.$asCherche.'([0-9]+)\.html!sU', '$1'.$asRemplace.'$2.html', $texte);
	return $texte;
} 

function art2ann( $texte) {
	return changeURL( $texte, 'art', 'ann');
}

function rub2anns( $texte) {
	return changeURL( $texte, 'rub', 'anns');
}


function winGUI( $texte) {

	//Headers h1, h2, ...
	$texte = preg_replace( '!<p class="spip">([\n])?§([1-6])-(.*)<\/p>!sU', '<h$2>$3</h$2>', $texte);
	//Headers à supprimer dans Introduction
	$texte = preg_replace( '!<br />$([1-6])-!sU', '<br />', $texte);

  //nettoyage spip
	$texte = preg_replace( '!<p class="spip">!', '<p>', $texte);
	$texte = preg_replace( '! border=0 !', ' ', $texte);
	$texte = preg_replace( '! border="0" !', ' ', $texte);
	//$texte = preg_replace( "!<p><p align='([a-z]*)'>(.*)</p></p>!", "<p align='$1'>$2</p>", $texte);

    //Dialogues
	$texte = preg_replace( "!§dialog-(.*)-§!sU", "<span class='spanDialog'>$1</span>", $texte);
    //Labels
	$texte = preg_replace( "!§label-(.*)-§!sU", "<span class='spanLabel'>$1</span>", $texte);
    //Boutons
	$texte = preg_replace( "!§b-(.*)-§!sU", "<span class='spanButton'>$1</span>", $texte);
	$texte = preg_replace( "!§bouton-(.*)-§!sU", "<span class='spanButton'>$1</span>", $texte);
    //Bulles d'aide
	$texte = preg_replace( "!§aide-(.*)-§!sU", "<span class='spanHelp'>$1</span>", $texte);
    //Bo?s combin? (ComboBox)
	$texte = preg_replace( "!§select-(.*)-§!sU", "<span class='spanComboBox'>$1</span>", $texte);
    //Touches de clavier
	$texte = preg_replace( "!§k-(.*)-§!sU", "<span class='spanKey'>$1</span>", $texte);
	$texte = preg_replace( "!§touche-(.*)-§!sU", "<span class='spanKey'>$1</span>", $texte);
	//Commande de Menu
	$texte = preg_replace( "!§m-(.*)-§!sU", "<span class='spanMenu'>$1</span>", $texte);
	$texte = preg_replace( "!§menu-(.*)-§!sU", "<span class='spanMenu'>$1</span>", $texte);
    //Onglet de dialogue
	$texte = preg_replace( "!§o-(.*)-§!sU", "<span class='spanTabs'>$1</span>", $texte);
	$texte = preg_replace( "!§onglet-(.*)-§!sU", "<span class='spanTabs'>$1</span>", $texte);
	//HyperLien sur site externe
	$texte = preg_replace( "!§w-<a href(.*)</a>!sU", "<a target='Web' href$1</a>", $texte);
	//
	$texte = preg_replace( "!§=-!sU", "<hr class='cbh' />", $texte);

	//Logos
	$texte = preg_replace( "!§doc-!sU", "<img src='/images/Icon-Word2000-32.gif'>", $texte);
	$texte = preg_replace( "!§docX-!sU", "<img src='/images/Icon-WordXP-32.gif'>", $texte);
	$texte = preg_replace( "!§sxw-!sU", "<img src='/images/Icon-StarOffice-32.gif'>", $texte);
  
  // Liens sortant
  $texte = preg_replace( "!§target-(.*)-§<a href=\"(.*)\" !sU", "<a href=\"$2\" target=\"$1\" ", $texte);
  
	return $texte;

}

function meta_revisit_after( $texte) {
	$gasMAJ = array(
		'_MaJ-1_Heure', '_MaJ-2_DemiJour', '_MaJ-3_Jour', '_MaJ-4_qqJours',
		'_MaJ-5_Semaine', '_MaJ-6_Quinzaine', '_MaJ-7_Mois', 
		'_MaJ-8_Trimestre', '_MaJ-9_Annee' 
		);
	$gasMeta = array( 
		'1 hour', '12 hours', '1 day', '4 days',
		'7 days', '14 days', '30 days',
		'90 days', '1 year'
	);

	$rsMeta = str_replace( $gasMAJ, $gasMeta, $texte);
	if ($rsMeta == $texte) $rsMeta = '';
	
	return $rsMeta;
}

function sitemap_changefreq( $texte) {
	$gasMAJ = array(
		'_MaJ-1_Heure', '_MaJ-2_DemiJour', '_MaJ-3_Jour', '_MaJ-4_qqJours',
		'_MaJ-5_Semaine', '_MaJ-6_Quinzaine', '_MaJ-7_Mois', 
		'_MaJ-8_Trimestre', '_MaJ-9_Annee' 
		);
	$gasMeta = array( 
		'hourly', 'daily', 'daily', 'weekly',
		'weekly', 'weekly', 'monthly',
		'monthly', 'yearly'
	);

	$rsMeta = str_replace( $gasMAJ, $gasMeta, $texte);
	if ($rsMeta == $texte) $rsMeta = '';
	
	return $rsMeta;
}


?><?php

// Compatibilite 1.9.2
if (version_compare($GLOBALS['spip_version_code'],'1.9300','<'))
	include_spip('gribouille/compat_gribouille');

// Creation d'un nouvel article du WIKI -- cf. inc-entete
if ( (_request('creer_nouvel_article')!==NULL)
AND (!preg_match(",http://,",_request('creer_nouvel_article'))) // pas d'url en titre de page, non mais
AND (_request('id_rubrique')!==NULL)
AND (!_request('pas_de_robot_merci'))) {
//AND _request('id_rubrique') == $GLOBALS['contexte']['id_rubrique'])

	$id_rubrique = intval($_POST['id_rubrique']);
	$id_auteur = intval($_POST['id_auteur']);
	$id_article = null;
	$titre = _request('creer_nouvel_article');
	$lsTexte = "Nouvel article... Double-cliquez et saisissez votre texte.";
	$lsDate = date('Y-m-d H:i:s');

		include_spip('inc/autoriser');
		if (autoriser('publierdans', 'rubrique', $id_rubrique)) {

		//$id_article = insert_article($id_rubrique);
		if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
			$query=
				"INSERT INTO spip_articles (titre, id_rubrique, texte, date, statut) 
				VALUES ('$titre', '$id_rubrique', '$lsTexte', '$lsDate', 'publie')";
			spip_query($query);
			$id_article = spip_insert_id();
		
		} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
			$id_article = sql_insertq( 'spip_articles', array(
				'titre'=>$titre, 'id_rubrique'=>$id_rubrique, 
				'texte'=>$lsTexte, 'statut'=>'publie', 'id_secteur'=>0, 
				'date'=> $lsDate, 'accepter_forum'=>'non', 'lang'=>$lang));
		}		
			
			
			$query="INSERT INTO spip_auteurs_articles (id_auteur, id_article) VALUES ('$id_auteur', '$id_article')";
			$riResult = spip_query($query);

			# pour SPIP 1.9.3
			if (function_exists('instituer_article'))
				instituer_article($id_article,array('statut' => 'publie'));
		}

	if (!$id_article)
		die("Erreur : creation d'article interdite");

			
	charger_generer_url();
	include_spip('inc/headers');
	redirige_par_entete( generer_url_article($id_article));
}

define ('RUBRIQUE_WIKI_OK', true);

?>
