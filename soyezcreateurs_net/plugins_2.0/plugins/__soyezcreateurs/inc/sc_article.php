<?php
/*
* Correspondance des articles pour ne pas mettre trop dans les autres fichiers
* Realisation : Yohann : prigent.yohann@gmail.com
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip("inc/lang");
include_spip("inc/charsets");	

function trouve_article_sc($article) {
	if ($article = "Premiers pas dans le squelette SoyezCreateurs") {
		$texte = <<<EOF
Bravo !!!!

Vous avez correctement passé la première étape en installant ce squelette.

Et maintenant vous vous demandez « Que faire ? »

Ce squelette est entièrement personnalisable et il va vous permettre de changer les différents critères suivants :

-* Pour changer la page d'accueil
-* Pour changer le nom du site et son logo
-* Configuration du Squelette SoyezCreateurs (ex : position Logo)[[Attention, l’accès à cette configuration est réservée aux webmestres du site, par défaut, l’auteur n°1 avec ce squelette.]]
-* Choisir la disposition des différents parties du site parmi 40 modèles disponibles (source : http://blog.html.it/layoutgala/)

Vous trouverez aussi plusieurs documentations disponibles aux adresses ci-dessous :

-* Pyrat.net :
-** Raccourcis Typographiques de SPIP, mode d’emploi
-** Rédiger pour Internet : les grandes règles
-** Erreurs classiques de mise en forme typographique
-* Les 2 groupes de Mots Clés :
-** Navigation
-** Fonctionnels
EOF;
	}
return $texte;
}
?>