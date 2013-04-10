<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2012 - Distribue sous licence GNU/GPL
 * 
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Construitre l'email personalise de notification d'un forum
 *
 * @param array $t
 * @param string $email
 * @return string
 */
function email_notification_forums_bis($t, $email) {
	static $contexte = array();

	if(!isset($contexte[$t['id_forum']])){
		$url = '';
		$id_forum = $t['id_forum'];

		if ($t['statut'] == 'prive') # forum prive
		{
			if ($t['id_objet'])
				$url = generer_url_entite($t['id_objet'], $t['objet'], '', '#id'.$id_forum, false);
		}
		else if ($t['statut'] == 'privrac') # forum general
		{
			$url = generer_url_ecrire('forum').'#id'.$id_forum;
		}
		else if ($t['statut'] == 'privadm') # forum des admins
		{
			$url = generer_url_ecrire('forum_admin').'#id'.$id_forum;
		}
		else if ($t['statut'] == 'publie') # forum publie
		{
			$url = generer_url_entite($id_forum, 'forum');
		}
		else #  forum modere, spam, poubelle direct ....
		{
			$auteur = sql_fetsel('*','spip_auteurs','email='.sql_quote($email));
			/**
			 * Si on a mediaspip config et que l'on est autorisé à configurer,
			 * on a accès à la gestion générique des forums
			 */
			if(defined('_DIR_PLUGIN_MEDIASPIP_CONFIG') && autoriser('configurer','','',$auteur))
				$url = parametre_url(generer_url_public('ms_config','ms_config=forums', "&"),'id_forum',$t['id_forum'],'&');
			else{
				$table = table_objet_sql($t['objet']);
				$id_table = id_table_objet($t['objet']);
				
				if($table = 'spip_articles')
					$table = 'spip_auteurs_articles';
				
				$auteurs = sql_allfetsel("id_auteur", "$table", "$id_table=".$t['id_objet']);
				$auteurs_objet=array();
				foreach($auteurs as $auteur){
					$auteurs_objet[] = $auteur['id_auteur'];
				}
				if(in_array($auteur['id_auteur'],$auteurs_objet))
					$url = parametre_url(generer_url_entite($auteur['id_auteur'], "auteur"),'vue','forums');
				else {
					$url = parametre_url(generer_url_entite($auteurs_objet[0], "auteur"),'vue','forums');
				}
					
			}
		}

		if (!$url) {
			spip_log("forum $id_forum sans referent",'notifications');
			$url = './';
		}
		if ($t['id_objet']) {
			$f = charger_filtre('generer_info_entite');
			$t['titre_source'] = $f($t['id_objet'], $t['objet'], 'titre');
		}

		$t['url'] = $url;

		// detecter les url des liens du forum
		// pour la moderation (permet de reperer les SPAMS avec des liens caches)
		$links = array();
		foreach ($t as $champ)
			$links = $links + extraire_balises($champ,'a');
		$links = extraire_attribut($links,'href');
		$links = implode("\n",$links);
		$t['liens'] = $links;

		$contexte[$t['id_forum']] = $t;
	}

	$t = $contexte[$t['id_forum']];
		// Rechercher eventuellement la langue du destinataire
	if (NULL !== ($l = sql_getfetsel('lang', 'spip_auteurs', "email=" . sql_quote($email))))
		$l = lang_select($l);

	$parauteur = (strlen($t['auteur']) <= 2) ? '' :
		(_T('forum_par_auteur', array(
			'auteur' => $t['auteur'])
		) .
		 ($t['email_auteur'] ? ' <' . $t['email_auteur'] . '>' : ''));

	$titre = textebrut(typo($t['titre_source']));
	$forum_poste_par = ($t['id_article']
		? _T('forum_poste_par', array(
			'parauteur' => $parauteur, 'titre' => $titre))
		: $parauteur . ' (' . $titre . ')');

	$t['par_auteur'] = $forum_poste_par;

	$envoyer_mail = charger_fonction('envoyer_mail','inc'); // pour nettoyer_titre_email
	$corps = recuperer_fond("notifications/forum_poste",$t);

	if ($l)
		lang_select();

	return $corps;
}
