<?php

// This is a SPIP module file  --  Ceci est un fichier module de SPIP

$GLOBALS['i18n_bloog_fr'] = array(

'entree_nouveau_passe' => 'Nouveau mot de passe',


// A
'abonner' => 's\'abonner',

// B
'form_forum_bonjour' => 'Bonjour,',
'form_forum_identifiants' => 'abonnement',
'entree_nom_pseudo' => 'Votre nom ou votre pseudo',
'titre_cadre_signature_obligatoire' => '<B>Signature</B> [Obligatoire]<BR>',
'entree_adresse_email' => 'Votre adresse email',
'info_reserve_admin' => 'Seuls les administrateurs peuvent modifier cette adresse.',
'entree_infos_perso' => 'Qui &ecirc;tes-vous ?',
'entree_biographie' => 'Courte biographie en quelques mots.',
'entree_nom_site' => 'Le nom de votre site',
'entree_url' => 'L\'adresse (URL) de votre site',
'info_avertissement' => 'Avertissement',
'texte_login_precaution' => 'Attention&nbsp;! Ceci est le login sous lequel vous &ecirc;tes connect&eacute; actuellement.
	Utilisez ce formulaire avec pr&eacute;caution...',
'item_login' => 'Login',
'texte_plus_trois_car' => 'plus de 3 caract&egrave;res',
'item_login' => 'Login',
'info_non_modifiable' => 'ne peut pas &ecirc;tre modifi&eacute;',
'info_plus_cinq_car' => 'plus de 5 caract&egrave;res',
'info_confirmer_passe' => 'Confirmer ce nouveau mot de passe :',



'inscription_mail_forum' => 'Voici vos identifiants pour vous connecter au site @nom_site_spip@ (@adresse_site@)',

'inscription_mail_redac' => 'Voici vos identifiants pour vous connecter au site @nom_site_spip@ (@adresse_site@) et à l\'interface de rédaction (@adresse_site@/ecrire)',

'bloogletter_mail_non' => 'Vous n\'êtes pas abonné à la lettre d\'information du site @nom_site_spip@',
'bloogletter_mail_format' => 'Vous êtes abonné à la lettre d\'information du site @nom_site_spip@ en format',
'bloogletter_annuler_envoi' => 'Annuler l\'envoi',
'bloogletter_suivi' => 'Suivi des abonnements',
'bloogletter_envoi_nouv' => 'Envoi des nouveautés',
'bloogletter_envoi_nouv' => 'Envoi des nouveautés',
'bloogletter_definir_squel' => 'Définir les squelettes',
'bloogletter_message_en_cours' => 'Message en cours d\'envoi',
'bloogletter_texte_boite_en_cours' => 'La bloOgletter envoie un message automatique en ce moment. <p> Vous pouvez provoquer l\'envoi accéléré des lots grâce au lien ci-dessous.</p> <p>Cette boite disparaitra une fois l\'envoi achevé.</p>',
'bloogletter_actualiser' => 'Actualiser',
'bloogletter_lot_suivant' => 'Provoquer l\'envoi du lot suivant',
'bloogletter_info_nouv' => 'Vous avez activé l\'envoi des nouveautés',
'bloogletter_info_nouv_texte' => 'Prochain envoi des nouveautés dans @proch@ jours',
'bloogletter_aide' => 'La bloOgletter permet (aux administrateurs) d\'envoyer un courrier électronique aux personnes inscrites. Ce message peut être un squelette Spip ou un simple texte<br><br>Les abonnés définissent en ligne leur statut d\'abonnement, les listes auxquelles ils s\'abonnent et le format dans lequel il souhaient recevoir les courriers (Html / texte).
<br><br> Vous pouvez utiliser le Html aussi bien dans les courriers que dans les squelettes que vous définissez.<br><br>Tout message sera traduit automatiquement en format texte pour les abonnés qui en ont fait la demande.<br><br><b>Note :</b><br>L\'envoi des mails peut prendre quelques minutes, les lots partent à mesure que les utilisateurs parcourent le site public, vous pouvez aussi activer manuellement l\'envoi des lots.',
'bloogletter_alerte_edit' => 'Attention : ce message peut être modifié par tous les administrateurs du site et est reçu par tous les abonnés. N\'utilisez la lettre d\'information que pour exposer par mail des événements importants de la vie du site.',
'bloogletter_message_type' => 'Courrier électronique',
'bloogletter_message_redac' => 'En cours de rédaction et prêt à l\'envoi',
'bloogletter_envoi_program' => 'Envoi programmé',
'bloogletter_message_arch' => 'Message archivé',
'bloogletter_envoi' => 'Envoi :',
'bloogletter_envoi_texte' => 'Si ce message vous convient, vous pouvez l\'envoyer',
'bloogletter_abonnement' => 'Abonnement',

'bloogletter_aff_redac' => 'Courriers en cours de rédaction',
'bloogletter_aff_encours' => 'Courriers en cours d\'envoi',
'bloogletter_aff_envoye' => 'Courriers envoyés',
'bloogletter_aff_lettre_auto' => 'Lettres des nouveautés envoyées',
'bloogletter_aff_envoye' => 'Courriers envoyés',
'info_bloogletter_auto' => 'La bloOgletter pour spip peut envoyer régulièrement aux inscrits, l\'annonce des dernières nouveautés du site (articles et brèves récemment publiés).',
'info_bloogletter_heberg' => 'Certains hébergeurs désactivent l\'envoi automatique de mails depuis leurs serveurs. Dans ce cas, les fonctionnalités suivantes de la bloogletter pour SPIP ne fonctionneront pas',

'bloogletter_adresse' => 'Indiquez ici l\'adresse à utiliser pour les retours de mails (à défaut, l\'adresse du webmestre sera utilisée comme adresse de retour) :',
'bloogletter_definir_squel_texte' => 'Vous pouvez ajouter des squelettes HTML par FTP dans le repertoire /squelettes_bloogletter (à la racine de votre site Spip).',
'bloogletter_definir_squel_choix' => 'A la rédaction d\'un nouveau courrier, la bloogletter vous permet de charger un patron. En appuyant sur un bouton, vous chargez dans le corps du message le contenu d\'un des squelettes du repertoire <b>/squelettes_bloogletter</b> (situé à la racine de votre site Spip). <p><b>Vous pouvez éditer et modifier ces squelettes selon vos goûts.</b></p> <UL><li>Ces squelettes peuvent contenir du code HTML classique</li>
<li>Ce squelette peut contenir des boucles Spip</li>
<li>Après le chargement du patron, vous pourrez re-éditer le message avant envoi (pour ajouter du texte)</li>
</ul><p>La fonction "charger un patron" permet donc d\'utiliser des gabarits HTML personnalisés pour vos courriers ou de créer des lettres d\'information thématiques dont le contenu est défini grâce aux boucles Spip.</p><p>Attention : ce squelette ne doit pas contenir de balises body, head ou html mais juste du code HTML ou des boucles Spip.</p>',
'bloogletter_courriers' => 'Courriers',
'bloogletter_messages_auto' => 'Messages automatiques',
'bloogletter_charger_patron' => 'charger un patron',
'bloogletter_messages_auto_texte' => '<p>Par défaut, le squelette des nouveautés permet d\'envoyer automatiquement la liste des articles et brèves publiés sur le site depuis le dernier envoi automatique. </p><p>vous pouvez personnaliser le message en définissant l\'adresse d\'un logo et d\'une image de fond pour les titres de parties en éditant le fichier nommé <b>"nouveautes.html"</b> (situé à la racine de votre site Spip).</p>',
'bloogletter_alerte_modif' => '<b>Après le chargement du patron vous pouvez modifier le code source du message</b>',
'bloogletter_charger_le_patron' => 'charger le patron',
'bloogletter_patron_disponibles' => 'patrons disponibles pour les courriers',
 

//D
'form_forum_identifiant_confirm'=>'Votre abonnement est enregistré, vous allez recevoir un mail de confirmation.',
'devenir_redac'=>'devenir rédacteur pour ce site',
'devenir_abonne'=>'Vous inscrire sur ce site',
'abonnement_bouton'=>'modifier votre abonnement',
'abonnement_titre_mail'=>'Modifier votre abonnement',
'abonnement_mail'=>'Pour modifier votre abonnement, veuillez vous rendre à l\'adresse suivante',
'abonnement'=>'Vous souhaitez modifier votre abonnement à la lettre d\'information',
'abonnement_texte_mail'=>'Indiquez ci-dessous l\'adresse email sous laquelle vous vous êtes précédemment enregistrés. 
Vous recevrez un email permettant d\'accéder à page de modification de votre abonnement.',
'abonnement_mail_passcookie'=>'(ceci est un message automatique)
Pour modifier votre abonnement à la lettre d\'information de ce site :
@nom_site_spip@ (@adresse_site@)

Veuillez vous rendre à l\'adresse suivante :

    @adresse_site@/abonnement.php3?d=@cookie@

Vous pourrez alors confirmer la modification de votre abonnement.',

'desabonnement_valid'=>'L\'adresse suivante n\'est plus abonnée à la lettre d\'information' ,
'pass_recevoir_mail'=>'Vous allez recevoir un email vous indiquant comment modifier votre abonnement. ',
'desabonnement_confirm'=>'Vous êtes sur le point de résilier votre abonnement à la lettre d\'information',
'abonnement_modifie'=>'Vos modifications sont prises en compte',
'abonnement_nouveau_format'=>'Votre format de réception est désormais : ',
'abonnement_change_format'=>'Vous pouvez changer de format de réception ou vous désabonner : ',


//E
'email' => 'E-mail',

//F
'faq' => 'FAQ',
'forum' => 'Forum',
'ferme' => 'Cette discussion est clôturée',

//I
'inscription_visiteurs' => 'L\'abonnement vous permet d\'accéder aux parties du site en accès restreint,
d\'intervenir sur les forums réservés aux visiteurs enregistrés et de recevoir les lettres d\'informations.' ,

'inscription_redacteurs' =>'L\'espace de rédaction de ce site est ouvert aux visiteurs après inscription.
Une fois enregistré, vous pourrez consulter les articles en cours de rédaction, proposer des articles
et participer à tous les forums.  L\'inscription permet également d\'accéder aux parties du site en accès restreint
et de recevoir les lettres d\'informations.',



//L
'login' => 'Connexion',
'logout' => 'Déconnexion',
'lieu' => 'Localisation',
'lettre_d_information' => 'Lettre d\'information',
'texte_lettre_information' => 'Voici la lettre d\'information du site',
//M

'modifier' => 'modifier',
'membres_liste' => 'Liste des Membres',
'membres_groupes' => 'Groupes d\'utilisateurs',
'membres_profil' => 'Profil',
'membres_messages_deconnecte' => 'Se connecter pour vérifier ses messages privés',
'membres_sans_messages_connecte' => 'Vous n\'avez pas de nouveaux messages',
'membres_avec_messages_connecte' => 'Vous avez @nombres@ nouveau(x) message(s)',
'message' => 'Message',
'message_date' => 'Posté le ',
'message_sujet' => 'Sujet ',
'messages' => 'Messages',
'messages_derniers' => 'Derniers Messages',
'messages_forum_clos' => 'Forum désactivé',
'messages_nouveaux' => 'Nouveaux messages',
'messages_pas_nouveaux' => 'Pas de nouveaux messages',
'messages_non_lus_grand' => 'Pas de nouveaux messages',
'messages_repondre' => 'Nouvelle Réponse',
'messages_voir_dernier' => 'Voir le dernier message',
'moderateurs' => 'Modérateur(s)',

//n
'nom' => 'Nom d\'utilisateur',
'nouveaux_messages' => 'Nouveaux messages',

//P
'poster' => 'Poster un Message',

//R
'recherche' => 'Rechercher',

'revenir_haut' => 'Revenir en haut de la page',
'reponse' => 'En réponse au message',

//S
'sujet_nouveau' => 'Nouveau sujet',
'sujet_auteur' => 'Auteur',
'sujet_visites' => 'Visites',
'abonnement_cdt'=>'<a href=\'http://bloog.net\'>bloOgletter</a>' ,
'sujets' => 'Sujets',
'sujets_aucun' => 'Pas de sujet dans ce forum pour l\'instant',
'site' => 'Site web',
'sujet_clos_titre' => 'Sujet Clos',
'sujet_clos_texte' => 'Ce sujet est clos, vous ne pouvez pas y poster.',
 
 //T
'texte_lettre_information' => 'Voici la lettre d\'information du site',

//V
'voir' => 'voir'


);

?>
