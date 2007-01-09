﻿<?php
//
// Configurateur de mots clefs et de rubriques bas'e sur
// Configurateur Squelette Epona - 2004 Nov 10 - Marc Lebas.
// Realisation : RealET : real3t@gmail.com
//

function refus($msg) {
  echo "<b><font color=red>$msg</font></b><br>";
  echo "Action non commencée; rectifier les conditions initiales avant de reprendre<br>";
}

function abandon($msg) {
  echo "<b><font color=red>$msg</font></b><br>";
  echo "Action abandonnée en cours d'éxécution<br>";
  echo "Rectifier le problème et rétablir des conditions initiales avant de reprendre<br>";
}

function avertir($msg) { echo "<font color=orange>$msg</font><br>"; }

//
// Fonctions pour mot-clés
//
function id_groupe($titre) {
	$result = spip_query("SELECT id_groupe FROM spip_groupes_mots WHERE titre='$titre'");
	if ($row = spip_fetch_array($result)) return $row['id_groupe'];
	return 0;
}

function id_mot($titre) {
	$result = spip_query("SELECT id_mot FROM spip_mots WHERE titre='$titre'");
	if ($row = spip_fetch_array($result)) return $row['id_mot'];
	return 0;
}

function id_rubrique($titre) {
	$result = spip_query("SELECT id_rubrique FROM spip_rubriques WHERE titre='$titre'");
	if ($row = spip_fetch_array($result)) return $row['id_rubrique'];
	return 0;
}

function create_groupe($groupe, $descriptif='', $texte='', $unseul='non', $obligatoire='non', $articles='oui', $breves='non', $rubriques='non', $syndic='non', $evenements='non', $minirezo='oui', $comite='oui', $forum='non') {
	$groupe = importer_charset($groupe);
	$id_groupe=id_groupe($groupe);
	$texte = importer_charset($texte);
	$descriptif = importer_charset($descriptif);
	if ($id_groupe == 0) {
		//Création groupe + mots clé
		$query = "INSERT INTO spip_groupes_mots SET titre='$groupe', descriptif='$descriptif', texte='$texte', unseul='$unseul', obligatoire='$obligatoire',
			articles='$articles', breves='$breves', rubriques='$rubriques', syndic='$syndic', evenements='$evenements',
			minirezo='$minirezo', comite='$comite', forum='$forum'";
		spip_query($query);
		$id_groupe = spip_insert_id();
	} else {
		// Mise à jour
		spip_query("UPDATE spip_groupes_mots SET descriptif='$descriptif', texte='$texte', unseul='$unseul', obligatoire='$obligatoire',
			articles='$articles', breves='$breves', rubriques='$rubriques', syndic='$syndic', evenements='$evenements',
			minirezo='$minirezo', comite='$comite', forum='$forum' WHERE id_groupe=$id_groupe");
	}
	$groupe = stripslashes($groupe);
	echo "<h2>Groupe: $groupe (<a href='?exec=mots_type&id_groupe=$id_groupe'>$id_groupe</a>)</h2>";
	return $id_groupe;
}

function create_mot($groupe, $mot, $descriptif='', $texte='') {
	$groupe = importer_charset($groupe);
	$id_groupe=id_groupe($groupe);
	$mot = importer_charset($mot);
	$texte = importer_charset($texte);
	$descriptif = importer_charset($descriptif);
	if ($id_groupe != 0) {
		$id_mot=id_mot($mot);
		if ($id_mot == 0 ) {
			spip_query("INSERT INTO spip_mots (type, titre, id_groupe, descriptif, texte) VALUES ('$groupe', '$mot', '$id_groupe', '$descriptif', '$texte')");
			$id_mot = spip_insert_id();
		} else {
			// Mise à jour
			spip_query("UPDATE spip_mots SET type='$groupe', id_groupe='$id_groupe', descriptif='$descriptif', texte='$texte' WHERE id_mot=$id_mot");
		}
	}
	$mot = stripslashes($mot);
	echo "<li>Mot: $mot (<a href='?exec=mots_edit&id_mot=$id_mot&redirect=%3Fexec%3Dmots_tous'>$id_mot</a>)</li>";
	return $id_mot;
}

function create_rubrique($titre, $id_parent='0', $descriptif='') {
	$id_rubrique = id_rubrique($titre);
	if ($id_rubrique==0) {
		$titre = importer_charset($titre);
		$descriptif = importer_charset($descriptif);
		$query="INSERT INTO spip_rubriques (titre, id_parent, descriptif) VALUES ('$titre', '$id_parent', '$descriptif')";
		spip_query($query);
		$id_rubrique = spip_insert_id();
	}
	$titre = stripslashes($titre);
	echo "<li>Rubrique: $titre (<a href='?exec=naviguer&id_rubrique=$id_rubrique'>$id_rubrique</a>)</li>";
	return $id_rubrique;
}

function create_rubrique_mot($rubrique, $mot) {
	$id_rubrique = id_rubrique($rubrique);
	$id_mot=id_mot($mot);
	if ($id_rubrique!=0 && $id_mot!=0) {
		$query="SELECT count(*) as nb_rub_mot FROM spip_mots_rubriques WHERE id_mot='$id_mot' AND id_rubrique='$id_rubrique'";
		$result=spip_query($query);
		if ($row = spip_fetch_array($result)) {
			if ($row['nb_rub_mot']==0) {
				$query="INSERT INTO spip_mots_rubriques (id_mot, id_rubrique) VALUES ('$id_mot', '$id_rubrique')";
				spip_query($query);
			}
		}
	}
	echo "<li>Liaison entre Rubrique (<a href='?exec=naviguer&id_rubrique=$id_rubrique'>$id_rubrique</a>) et Mot (<a href='?exec=mots_edit&id_mot=$id_mot&redirect=%3Fexec%3Dmots_tous'>$id_mot</a>)</li>";
	return TRUE;
}

function config_site() {
	// Autorisations dates antérieures et gestion avancée des mots clé
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('config_precise_groupes', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_redac', 'oui')");
	// Création rubriques
	
	echo "<h2>Cr&eacute;ation des rubriques sp&eacute;ciales</h2>";
	create_rubrique('000. Racine', '0', "Vous trouverez dans cette rubrique:\n\n-* Les Éditos\n-* Des articles concernant le site lui-même\n");
	create_rubrique('900. Agenda', '0');
	create_rubrique('999. Citations', '0', "Mettre dans cette rubrique une citation par article");

## -------------------------------------------->

	create_groupe("Thèmes de l\'Agenda", "Détermine la liste des éléments pouvant être présentés en liste déroulante dans l\'Agenda du site", "Un événement de l\'Agenda peut avoir un ou {{plusieurs}} mot clefs ratachés (les sélectionner avec maj-clic).", 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'oui', 'oui', 'non');

	create_groupe("_AgendaStatut", "Statut d\'un événement dans l\'Agenda", "Permet de spécifier un statut d\'un événement dans l\'Agenda.\n\nL\'événement sera affiché dans la couleur spécifiée par le {Texte} du Mot Clef.\n\nLe {Descriptif rapide} sera quant à lui utilisé en bulle d\'aide.", 'oui', 'oui', 'non', 'non', 'non', 'non', 'oui', 'oui', 'oui', 'non');
		create_mot("_AgendaStatut", "Annulé", "Activité annulée pour des raisons indépendantes de notre volonté", "ab051c");
		create_mot("_AgendaStatut", "Changement d\'animateur(s)", "Les des animateurs a été remplacé", "a70592");
		create_mot("_AgendaStatut", "Complet", "Il n\'y a plus de place", "F00");
		create_mot("_AgendaStatut", "Date changée", "La nouvelle date est ici indiquée.", "3a92d5");
		create_mot("_AgendaStatut", "Liste d\'attente", "Inscrivez-vous en liste d\'attente", "DE8E39");

	create_groupe("_CouleurRubrique", "Permet de changer la couleur d\'une Rubrique.", "Affecter un mot clef de ce groupe à une rubrique (et ses descendants) pour en changer la tonalité de couleur.\n\nPour chacun des mots clefs, mettre en titre quelque chose d\'intelligible, un éventuel descriptif rapide sur l\'usage à en faire et le code hexadecimal de la couleur dans le texte. \n\nExemple : \n-* Titre: Orange\n-* Texte : f78221", 'oui', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_CouleurRubrique", "Bleu", "", "6392A9");
		create_mot("_CouleurRubrique", "Marron clair", "", "9F7561");
		create_mot("_CouleurRubrique", "Turkoise pastel", "", "89A699");

	create_groupe("_HTTP-EQUIV", "Paramétrage du site", "Paramétrage des entêtes HTML HTTP-EQUIV.\n\nÀ utiliser en sachant pourquoi.", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_HTTP-EQUIV", "pics-label", "Mettre ci-dessous le contenu du label ICRA (XHTML) généré depuis [->http://www.icra.org/].\n\nIl s\'agit d\'une démarche volontaire du responsable du site visant à indiquer si le site peut ou non être visité sans dommage par des enfants.", "");

	create_groupe("_InformationsLegales", "Mention légales obligatoire ([CNIL|Commision Nationale Informatique et Liberté->http://www.cnil.fr/] et [LcEN|Loi sur la confiance en l\'Économie Numérique->http://www.legifrance.gouv.fr/WAspad/UnTexteDeJorf?numjo=ECOX0200175L])", "[Décryptage des obligations légales->http://maitre.eolas.free.fr/journal/index.php?2005/05/27/135-responsabilite-du-blogueur].", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_InformationsLegales", "10. Propriétaire du site", "Mettre les coordonnées du propriétaire du site ci-dessous", "");
		create_mot("_InformationsLegales", "20. Hébergeur", "Mettre les coordonnées de l\'hébergeur ci-dessous");
		create_mot("_InformationsLegales", "30. Liens vers ce site", "Mettre ci-dessous les conditions d\'utilisation du contenu", "Le site autorise tout site Internet ou tout autre support à le citer ou à mettre en place un lien hypertexte pointant vers son contenu.\n\nL’autorisation de mise en place d’un lien est valable pour tout support, à l’exception de ceux diffusant des informations à caractère polémique, pornographique, xénophobe ou pouvant, dans une plus large mesure porter atteinte à la sensibilité du plus grand nombre.\n\nLa reprise intégrale du contenu d\'une page est aussi autorisée, sous réserve d\'établir un lien clair vers sa source.");
		create_mot("_InformationsLegales", "40. Réalisation", "Mettre ci-dessous les informations concernant la réalisation de ce site.", "Ce site a été réalisé par [PYRAT.net|Création de sites web->http://www.pyrat.net/] en utilisant l\'outil [SPIP->http://www.spip.net/].\n\n[PYRAT.net|Création de sites web->http://www.pyrat.net/] a réalisé ce site dans les respect des [normes pour l\'accessibilité->http://www.pyrat.net/Accessibilite-d-un-site-web,193.html] des sites web à tous.");

	create_groupe("_LayoutGala", "Permet de faire appel à l\'une des 40 mises en page disponibles sur [Layout Gala->http://blog.html.it/layoutgala/]", "Mode d\'emploi : \n-* affecter un des mots mots clefs de ce groupe à un objet de SPIP (Articles, Rubriques, Brèves, Sites) permet de lui affecter la mise en page associée\n-* de plus, le mot clef de ce groupe ayant « ParDefaut » dans son texte sera utilisé par défaut pour l\'ensemble du site", 'oui', 'non', 'oui', 'oui', 'oui', 'oui', 'non', 'oui', 'non', 'non');
		create_mot("_LayoutGala", "01. Three percentage columns", "", "");
		create_mot("_LayoutGala", "07. Three fixed columns", "", "");
		create_mot("_LayoutGala", "13. Liquid, secondary columns fixed-width", "", "ParDefaut");
		create_mot("_LayoutGala", "24. Two columns liquid, side fixed", "", "");
		create_mot("_LayoutGala", "26. Two percentage columns", "", "");
		create_mot("_LayoutGala", "27. One column liquid and two halves", "", "");
		create_mot("_LayoutGala", "34. Two colums fixed", "", "");

	create_groupe("_LogosExtra", "Permet de placer une image en fond de la colonne Extra (c\'est-à-dire, soit la colonne secondaire qui peut être afichée soit de l\'autre côté du menu, soit en dessous de celui-ci).", "{{Utilisation}} : affecter un ou plusieurs mots clefs de ce groupe aux rubriques (héritage automatique) qui doivent avoir une ou plusieurs image en fond. L\'image est choisie aléatoirement parmis celles disponibles.\n\n{{Configuration}} : \n-* créer des mots clefs dans ce groupe et leur donner un logo de mot clef.\n-* il est possible de mettre un logo de survol qui sera alors utilisé en fond de texte (en plus de l\'autre logo) et positionné en haut à droite sauf si le texte contient les ordres CSS de positionnement ({bottom left} par exemple)", 'non', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_LogosExtra", "300. Tourisme sous-bois", "", "top right");
		create_mot("_LogosExtra", "310. Tourisme Roches enchantées", "", "");
		create_mot("_LogosExtra", "320. Tourisme La Loue (Rivière)", "", "bottom right");

	create_groupe("_META", "Paramètrage du site", "Permet de spécifier des META pour le site.\n\nIl est possible de rajouter des METAs non encore présents, mais, comme d\'habitude en la matière : sachez ce que vous faites !", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_META", "Description", "Mettre ci-dessous la description du site", "");
		create_mot("_META", "ICBM", "Mettre la latitude et la longitude du lieu sous la forme : XXX.XXXXX, XXX.XXXXX\n_ Pour trouver vos coordonnées : [Multimap->http://www.multimap.com/]\n_ Et [vous référencer sur GeoURL->http://geourl.org/ping/]", "");
		create_mot("_META", "Keywords", "Mettre ci-dessous les mots clef du site séparés par des virgules", "");
		create_mot("_META", "revisit-after", "Fréquence d\'indexation du site", "3 days");

	create_groupe("_ModePortail", "Les mots clefs de ce groupe permettent de gérer les éléments qui s\'affichent sur la page d\'accueil du site si celui-ci est en mode portail.", "Les mots clefs numérotés dans leur titre de 0. à 9. verront leur logo utilisé dans les colonnes de gauche et de droite de la page d\'accueil (respectivement pour les numéros impairs et pairs).", 'oui', 'non', 'oui', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_ModePortail", "1. Mot1", "", "");
		create_mot("_ModePortail", "2. Mot2", "", "");
		create_mot("_ModePortail", "Goodies", "Affecter ce mot clef aux objets SPIP devant apparaitre dans la zone des Goodies.", "Ne pas oublier de mettre un logo (120×30) aux objet concernés.");
		create_mot("_ModePortail", "ZoomSur", "Affecter ce mot clef à l\'objet que vous voulez placer dans le cadre « Zoom sur » (facultatif).\n\nLe site prendra les 3 derniers articles ayant ce mot clef", "S\'applique aux :\n-* articles\n-* rubriques");

	create_groupe("_Params", "Paramétrages globaux du site", "Ces paramètres règlent des comportements globaux pour tout le site.", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_Params", "Aff_DatePublication", "Mettre Oui ci-dessous si le site doit afficher la date de publication des articles", "Oui");
		create_mot("_Params", "Aff_Google_Analytics", "Mettre ci-dessous la partie du code entre les guillemets (extrait du code fournis par Google) : _uacct = \"{{UA-00000-0}}\"; pour bénéficier des services de statistiques de [Google Analytics->http://www.google.com/analytics/fr-FR/].", "");
		create_mot("_Params", "Aff_Habillage", "Permet de spécifier l\'emplacement de la zone de choix de l\'habillage du site, soit en haut à droite, soit en bas à gauche.\n\nValeurs possible à mettre ci-dessous : Left ou Right", "Left");
		create_mot("_Params", "AgendaFuturSeul", "Mettre Oui ci-dessous pour bénéficier d\'un agenda (format liste) qui affiche tous les événements futurs et seulement eux.", "");
		create_mot("_Params", "AgendaScolaire", "Mettre Oui ci-dessous si l\'agenda doit afficher des années scolaires (septembre à décembre de l\'année suivante inclus) et non des années légales.", "");
		create_mot("_Params", "AgendaThematique", "Mettre Oui ci-dessous afin de provoquer par défaut l\'affichage de l\'Agenda sous forme d\'un plan hiérarchique des rubriques et des articles présents dans ce dernier.", "");
		create_mot("_Params", "AnonymatGlobal", "Mettre Oui ci-dessous si le site ne doit pas afficher le nom des auteurs", "Oui");
		create_mot("_Params", "BandeauContact", "Mettre ci-dessous le contenu à afficher dans le bandeau de contact (en bas du site). Laisser vide s\'il ne doit pas être affiché.", "");
		create_mot("_Params", "CitationsHeader", "Par défaut, les citations sont en haut du menu de droite (ou en dessous de la recherche si site en 2 colonnes).\n\nMettre Oui ci-dessous pour que les citations soient affichées dans le bandeau d\'en-tête du site.", "");
		create_mot("_Params", "CNIL", "N° de déclaration CNIL, si non déclaration (ce qui est illégal!), laisser le texte explicatif vide.\n\nPour procéder à la déclarion, rendez-vous sur le [site de la CNIL->http://www.cnil.fr/index.php?id=32]", "");
		create_mot("_Params", "ModeNews", "Mettre Oui ci-dessous si le site ne doit pas afficher un Edito seul, mais plutôt une liste des derniers articles", "");
		create_mot("_Params", "ModePortail", "Mettre Oui ci-dessous si le site ne doit s\'afficher sur sa page d\'accueil dans un mode portail.", "");
		create_mot("_Params", "ModeStatique", "Mettre Oui ci-dessous si le site web est destiné à être utilisé dans un environement statique (par exemple dans le cas d\'une aspiration du site).\n\nCeci désactivera :\n-* le lien résumé en bas du menu de gauche (le résumé étant dynamique en fonction des visites, il n\'a pas de sens dans un environement statique)", "");
		create_mot("_Params", "NavigationTransversaleSansAutresMenusHaut", "Limitation de la navigation transversale : mettre {{Oui}} ci-dessous.\n\nDans le cas d\'un site avec des Menus placés en haut du site (navigation horizontale), permet de limiter la fonctionalité de navigation transversale par mots clefs :\n-* à la rubrique en cours\n-* aux rubriques qui ne sont pas dans un secteur ayant le mot clef MenuHaut", "Oui");
		create_mot("_Params", "NewsLetterID", "Mettre le numéro de la WaNewsLetter ici pour permettre l\'abonnement à la lettre (Si elle existe, sinon rien)", "");
		create_mot("_Params", "PasDeMiniAgenda", "Mettre Oui ci-dessous pour que le mini Agenda ne soit pas affiché sur la page d\'accueil du site.", "");
		create_mot("_Params", "PasDeResume", "Mettre Oui ci-dessous pour ne pas afficher l\'accès à la page Résumé dans le menu du site (sous le Plan)", "");
		create_mot("_Params", "Xiti_ID", "IDENTIFICATION DU NUMÉRO D\'INSCRIPTION\nRemplacer ###### par votre numéro d\'inscription Xiti", "######");
		create_mot("_Params", "Xiti_URL", "IDENTIFICATION DE  L\'ADRESSE DE VOTRE MARQUEUR XITI.\nRemplacer ###### par l\'adresse (URL) de votre marqueur.\nElle se trouve dans une ligne du code du marqueur Xiti qui ressemble à :\nhsi += \'src=\"http://logv24.xiti.com/hit.xiti?s=1234\';\nL\'adresse ici serait http://logv24.xiti.com/hit.xiti", "######");

	create_groupe("_ParamsApparence", "Des paramètres pour régler l\'apparence du site", "Ces paramètres influent directement sur l\'apparence du site.\n\nLà encore, ne rien faire sans savoir pourquoi.", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_ParamsApparence", "AvertissementIE", "Mettre Oui ci-dessous pour afficher l\'avertissement d\'obsolescence d\'Internet Explorer 5 et 5.5", "Oui");
		create_mot("_ParamsApparence", "BandeauContactExtra", "Mettre Oui ci-dessous pour que le Bandeau de contact s\'affiche dans la navigation secondaire (et non pas dans le pied de la page).", "");
		create_mot("_ParamsApparence", "FrmRecherchePerso", "Mettre ci-dessous le nom du Formulaire de Recherche s\'il doit être différent du formulaire de recherche par défaut.\n\nSi le fichier de squelette est {nomfichier.html}, mettre {nomfichier}", "");
		create_mot("_ParamsApparence", "LargeurMenuDroit", "Pour régler la largeur du menu de droite si présent (l\'unité est le pixel)", "140");
		create_mot("_ParamsApparence", "LargeurMenuGauche", "Pour régler la largeur du menu de gauche (l\'unité est le pixel)", "160");
		create_mot("_ParamsApparence", "LogoHeader", "Mettre Oui ci-dessous pour que le logo du site soit dans la zone d\'entête au lieu d\'être en haut de la zone de menu.", "");
		create_mot("_ParamsApparence", "MenuHautHeader", "Mettre Oui ci-dessous si le MenuHaut doit être dans le #header de la page", "");
		create_mot("_ParamsApparence", "Nombre_ALaUne", "Mettre ci-dessous le nombre d\'élements que la zone « À la Une » de la page d\'accueil doit contenir.", "3");
		create_mot("_ParamsApparence", "Nombre_QuoideNeuf", "Mettre ci-dessous le nombre d\'élements que le quoi de neuf de la page d\'accueil doit contenir.", "10");

	create_groupe("_ParamsSlyleSwitcher", "Paramétrage du menu de choix d\'affichage du site", "Il est possible :\n\n-* d\'enlever un élément\n-* de changer de place un «alternate» pour changer le style par défaut du site", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_ParamsSlyleSwitcher", "centerbleu", "", "Bleu");

	create_groupe("_Specialisation", "Spécialisation d’un article ", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d’un article particulier\n", 'non', 'non', 'oui', 'non', 'non', 'non', 'non', 'oui', 'oui', 'non');
		create_mot("_Specialisation", "AccesibiliteLien", "Affecter ce mot clef à l\'article traitant de la politique d\'accessibilité du site.", "Un fois l\'article écrit, lui affecter ce mot clef pour qu\'il soit disponible en lien en haut de la page (caché pour les voyants, sauf sur la page d\'accueil).");
		create_mot("_Specialisation", "ALaUne", "Article qui doit rester à la une du site (soit dans quoi de neuf, soit dans la liste des articles en ModeNews, Soit dans le cartouche À la une en ModePortail)", "");
		create_mot("_Specialisation", "DevoilerDate", "Mettre ce mot clef à un article dont on veut afficher la date de publication.", "");
		create_mot("_Specialisation", "DevoilerIdentite", "Mettre ce mot clef à un article dont on veut afficher le nom du ou des auteurs (au sens de SPIP)", "");
		create_mot("_Specialisation", "EDITO", "Sert à dire que l\'article est un éditorial.", "{{Attention}} : le site utilisera l\'article le plus récent ayant ce mot clef pour l\'afficher en tant qu\'éditorial.\n\n[*Conséquence*] : ne changez pas le contenu d\'un éditorial par le nouvel éditorial, créez un nouvel article éditorial!");
		create_mot("_Specialisation", "Gallerie", "Si l\'article contient une galerie de photos (portofolio).", "Pour faire un portofolio, il faut attacher à un article des documents de type images (.jpeg, .gif et .png).\n\nAvec ce mot clef, ces images seront automatiquement affichées sous forme de vignettes avec la possibilité de cliquer sur une image pour en voir une version plus grande et pourvoir de nouveau cliquer pour avoir dans une nouvelle fenêtre l\'image de la taille originale.\n\n[*Attention*]: surveillez l\'espace occupé sur votre hébergement de site pour ne pas le dépasser avec trop d\'images...");
		create_mot("_Specialisation", "GraverSonNom", "Un article avec ce mot clef permettra aux visiteurs de laisser leur nom sur le site en tant que bulle d\'aide sur l\'image (Logo du mot) et de faire parvenir un texte aux administrateurs", "Il faut pour que ça fonctionne:\n\n-* un article\n-* un forum modéré a posteriori\n-* ce mot mot clef attaché à cet article\n-* un logo à ce mot clef\n\nÀ partir de là, l\'article permet aux visiteurs de «graver leur nom» dans le site. Leur nom aparaitra en bulle d\'aide sur une image (le logo de ce mot clef).");
		create_mot("_Specialisation", "Livre d\'Or", "Pour empécher que l\'on puisse répondre à un forum", "Ce mot clef appliqué à un article ayant un forum fait que ce forum n\'a qu\'un niveau (pas possible de répondre à une intervention, seulement d\'en rajouter)");
		create_mot("_Specialisation", "MENURACINE", "Doit s\'afficher en dessous de Accueil", "Pour dire que l\'article s\'affiche en dessous de Accueil dans le menu de gauche avant les rubriques du site");
		create_mot("_Specialisation", "MENURACINEBAS", "Pour dire que l\'article s\'affiche au dessus de Plan", "Permet de placer dans le menu de gauche un (ou plusieurs) article(s) en bas de menu, avant le plan du site.");
		create_mot("_Specialisation", "MENURACINEBAS_Systematique", "Affichage systématique dans le menu de gauche en bas", "Affecter ce mot clef à un article qui devra être présent dans le menu de gauche, en bas, que l\'on soit dans un secteur avec MenuHaut ou non.");
		create_mot("_Specialisation", "MENURACINE_Systematique", "Affichage systématique dans le menu de gauche en haut", "Affecter ce mot clef à un article qui devra être présent dans le menu de gauche, en haut, que l\'on soit dans un secteur avec MenuHaut ou non.");
		create_mot("_Specialisation", "PasDansRecherche", "Permet de masquer un article des résultats de la recherche", "À affecter aux articles qui ne doivent pas être affichées dans les résultats de la recherche");
		create_mot("_Specialisation", "PasdeSiteDansForums", "Pour que les sites référencés n\'apparaissent pas dans un forum (mesure anti SPAM)", "Pour décourager ceux qui utiliseraient vos forums pour faire de la pub pour leurs site (généralement, des sonneries de téléphone)");

	create_groupe("_Specialisation_Rubrique", "Spécialisation d’une rubrique", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d’une rubrique et de ses articles\n", 'non', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'oui', 'non');
		create_mot("_Specialisation_Rubrique", "AfficherArticlesMenu", "Affichage des articles de la rubrique dans le menu de gauche", "Affecter ce mot clef aux rubriques dont la liste des articles doit être affichée dans le menu de gauche.");
		create_mot("_Specialisation_Rubrique", "Agenda", "Pour dire qu\'une rubrique est dans l\'Agenda", "Il est impératif de mettre ce mot clef pour la rubrique à la racine ayant cette caractéristique (inutile pour les sous rubriques de cette rubrique).");
		create_mot("_Specialisation_Rubrique", "Citations", "Rubrique destinée à recevoir de courtes citations (une par article) affichées en haut à droite des pages du site de manière alléatoire (une nouvelle citation toutes les heures)", "Créer un article par citation avec :\n\n-* La citation dans le corps du texte (entourée de guillemets si nécessaires)\n-* L\'auteur dans le sous-titre\n-* Le titre de l\'article sert d\'accroche pour le lecteur\n");
		create_mot("_Specialisation_Rubrique", "DessousBreves", "Pour placer une rubrique et ses articles qui sont placés sous les brèves (dans la colonne de droite du site)", "[*Attention*] : une rubrique qui a ce mot clef ne doit pas avoir de sous-rubrique !\n\nLe titre de la rubrique sera affiché sur la droite et la liste de ses articles en dessous.\n\nSeuls les articles sont clicables pour accéder à leur contenu.");
		create_mot("_Specialisation_Rubrique", "MenuHaut", "Pour qu\'un secteur soit dans un menu horizontal en haut du site", "Affecter ce mot clef aux secteurs (rubriques rattachées à la racine du site) qui doivent être dans le menu horizontal en haut du site.");
		create_mot("_Specialisation_Rubrique", "NewsLetter", "Mettre ce mot clef à une rubrique dont le contenu doit servir de newsLetter.\n\nMettre ci-dessous l\'URL de désabonnement.", "maito:");
		create_mot("_Specialisation_Rubrique", "PasDansMenu", "Pour interdire que la rubrique (et ses sous-rubriques) soi(en)t dans le menu de gauche", "");
		create_mot("_Specialisation_Rubrique", "PasDansPlan", "Permet de masquer une rubrique, et tout son contenu (y compris les sous-rubriques) du plan du site", "À affecter aux rubriques qui ne doivent pas être affichées dans le plan du site");
		create_mot("_Specialisation_Rubrique", "SecteurPasDansQuoiDeNeuf", "Pour interdire que les articles d\'un secteur entier soit dans «Quoi de Neuf» sur la page d\'accueil", "Un secteur, c\'est une rubrique rattachée à la racine du site et toutes ses sous-rubriques");

	create_groupe("_Specialisation_Rubrique_ou_Article", "Spécialisation d\'une rubrique ou d\'un article", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d\'une rubrique et de ses articles\n-* le comportement d\'un article particulier", 'non', 'non', 'oui', 'non', 'oui', 'non', 'non', 'oui', 'oui', 'non');
		create_mot("_Specialisation_Rubrique_ou_Article", "PasDansQuoiDeNeuf", "Pour interdire que l\'article ou la rubrique soit dans «Quoi de Neuf» sur la page d\'accueil", "À mettre soit:\n\n-* pour un article précis\n-* pour une rubrique particulière\n\nRemarque : si elle a des sous rubriques, il faut aussi le faire pour chacunes de celles-ci si on veut les exclure aussi...");
		create_mot("_Specialisation_Rubrique_ou_Article", "Sommaire", "Pour dire que les articles de cette rubrique ont un sommaire ou que l\'article a un sommaire", "Un sommaire automatique sera placé en début d\'article.\n\nCe sommaire sera bati à partir des titres et sous-titres du texte de l\'article.");


## <--------------------------------------------

	// Liaison entre rubrique et mot clé
	create_rubrique_mot('000. Racine', 'SecteurPasDansQuoiDeNeuf');
	create_rubrique_mot('000. Racine', 'PasDansMenu');
	create_rubrique_mot('900. Agenda', 'Agenda');
	create_rubrique_mot('900. Agenda', 'SecteurPasDansQuoiDeNeuf');
	create_rubrique_mot('900. Agenda', 'PasDansMenu');
	create_rubrique_mot('999. Citations', 'SecteurPasDansQuoiDeNeuf');
	create_rubrique_mot('999. Citations', 'PasDansMenu');
	create_rubrique_mot('999. Citations', 'PasDansPlan');
	create_rubrique_mot('999. Citations', 'Citations');
	return TRUE;
}

function exec_postconfig() {
	if (!defined("_ECRIRE_INC_VERSION")) return;

	include_spip("inc/presentation");
	include_spip("inc/lang");
	include_spip("inc/charsets");

	install_debut_html("Configurateur site");
	config_site();

	echo "<h1>Installation termin&eacute;</h1><p>Vous pouvez revenir à l'<a href='./'>administration du site</a></p>";
	install_fin_html();
}
?>