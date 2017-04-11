<?php
/*
* Correspondance des articles pour ne pas mettre trop dans les autres fichiers
* Realisation : Yohann : prigent.yohann@gmail.com
* et RealET : real3t@gmail.com
* Attention, fichier en UTF-8 sans BOM
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip("inc/lang");
include_spip("inc/charsets");	

function trouve_article_sc($article) {
	$contenu = array();
	/* Premiers pas dans le squelette SoyezCreateurs */
	if ($article == "Premiers pas dans le squelette SoyezCreateurs") {
		$contenu['titre'] = $article;
		$contenu['texte'] = <<<EOF
Bravo !!!!

Vous avez correctement passé la première étape en installant ce squelette.

Et maintenant vous vous demandez « Que faire ? »

Ce squelette est entièrement personnalisable et il va vous permettre de changer les différents critères suivants : 
-* Pour changer l'Édito, créer un article et lui affecter le mot clef <code>EDITO</code>
-* Pour changer le nom du site et son logo : {URL de votre site}<code>/ecrire/?exec=configuration</code>
_ Le logo de survol s'il est présent est utilisé comme bannière en haut du site[[Lui donner précisément la taille voulue]]
-* Configuration du Squelette SoyezCreateurs {URL de votre site}<code>/ecrire/?exec=cfg&cfg=soyezcreateurs</code> (ex : position Logo) [[Attention, l'accès à cette configuration est réservée aux webmestres du site, par défaut, l'auteur n°1 avec ce squelette.]]
-* Choisir la disposition des différents parties du site parmi 40 modèles disponibles {URL de votre site}<code>/ecrire/?exec=cfg&cfg=soyezcreateurs_layout</code> (source: [LayoutGala/->http://blog.html.it/layoutgala/])

Vous trouverez aussi plusieurs documentations disponibles aux adresses ci-dessous : 
-* [Pyrat.net->http://www.pyrat.net/] :
-** [Raccourcis Typographiques de SPIP, mode d’emploi->http://www.pyrat.net/Raccourcis-Typographiques-de-SPIP.html]
-** [Rédiger pour Internet : les grandes règles->http://www.pyrat.net/Rediger-pour-Internet-les-grandes.html]
-** [Erreurs classiques de mise en forme typographique->http://www.pyrat.net/Erreurs-classiques-de-mise-en.html]
-* Les 2 groupes de Mots Clés : 
-** [Navigation->http://www.pyrat.net/@mot.html]
-** [Fonctionnels->http://www.pyrat.net/@motsfonctionnels.html]
EOF;
		$contenu['nom_site'] = "Original de l'article";
		$contenu['url_site'] = "https://contrib.spip.net/?article3075";
	}
	
	/* Raccourcis Typographiques de SPIP, mode d'emploi */
	if ($article == "Raccourcis Typographiques de SPIP, mode d'emploi") {
		$contenu['surtitre'] = "Ceci est un surtitre";
		$contenu['titre'] = $article;
		$contenu['soustitre'] = "Ceci est un soustitre";
		$contenu['descriptif'] = "Aller plus loin que la barre de raccourcis.";
		$contenu['chapo'] = <<<EOF
{{Un préalable important}} : la mise en page d'un texte est au service du {{sens}} de celui-ci, pas du goût personnel de celui qui se trouve devant l'écran! Or, les raccourcis typographiques de SPIP portent en eux-mêmes du {{sens}}. Il est {{important}} d'avoir une correspondance entre le {{sens}} typographique et le {{sens}} du texte. Par exemple, un titre du point de vue du texte doit aussi l'être du point de vue typographique.

N'oubliez pas non plus que votre site sera lu par des visiteurs pouvant être dans des résolutions d'écran différentes de la vôtre et qu'une «belle» mise en page chez vous pourrait être complètement différente pour le visiteur.

Avant d'aller plus loin, vous pouvez lire avec profit : [->452].
EOF;
		$contenu['texte'] = <<<EOF
{{{Le texte préexiste à la mise en page}}}

C'est peut-être une évidence, mais pour mettre en page un texte, il faut que le texte existe.

Dans le cas de SPIP, ça veut dire qu'il vaut mieux (au moins dans un premier temps):

-* disposer de tout le texte sans aucun raccourci typographique,
-* sauter une ligne à chaque changement d'idée (ce qui donne un changement de paragraphe, voire un titre),
-* faire un retour à la ligne avant chaque élément d'une énumération.

Ce n'est qu'ensuite que les raccourcis typographiques de SPIP pourront être appliqués avec discernement.

{{{Distinction entre paragraphes et caractères}}}

Certains attributs typographiques ne peuvent s'appliquer qu'à des paragraphes entiers, d'autres doivent être appliqués à des caractères dans le {{même}} paragraphe.

Dans la Barre Typographique de SPIP, les attributs de caractères forment le premier groupe sur la gauche, les attributs typographiques de paragraphes le deuxième.[definition_ancre<-]

{{{**Paragraphes}}}

Un paragraphe dans SPIP est précédé d'une ligne vide et suivi d'une ligne vide[[Sauf les listes à puce et les tableaux]].

Une règle générale est de ne mettre qu'un attribut de paragraphe par paragraphe.

Si deux paragraphes de suite ont le même attribut, il faut appliquer {{deux}} fois l'attribut, une fois pour chaque paragraphe.

Les attributs de paragraphe ne sont pas disponibles dans les champs de SPIP n'ayant qu'une ligne.

Les attributs de paragraphe sont :

-* les titres <code>{</code><code>{{</code>Paragraphe du titre<code>}}</code><code>}</code> et sous-titres <code>{n{</code>Texte du titre<code>}n}</code>, n variant de 2 à 5, la barre de raccourcis ne proposant que 2 et 3.
_ [*Attention*]: il est essentiel de respecter la {{hiérarchie}} de la titraille et de ne pas commencer par un élément sans qu'il soit précédé de son niveau supérieur (on ne doit pas commencer à 2 !). Voir les exemples de [titraille->#titraille]
_ [*Remarque*] : <code>{</code><code>{{</code>Titre de premier niveau<code>}}</code><code>}</code> est strictement équivalent à <code>{</code><code>1{</code>Titre de premier niveau<code>}1</code><code>}</code>.

-* centrer <code>[|</code>Paragraphe centré<code>|]</code> : à n'utiliser que de manière {{exceptionnelle}}[[J'avais mis ça en place à l'époque de la version 1.7 de SPIP qui gérait mal le centrage des images]] !

[|Paragraphe centré|]

-* aligner à droite <code>[/</code>Paragraphe aligné à droite<code>/]</code> : essentiellement pour mettre la signature d'un auteur

[/Paragraphe aligné à droite/]

-* encadrer <code>[(</code>Paragraphe à encadrer<code>)]</code>

[(Paragraphe à encadrer)]

Certains attributs sont un peu spéciaux :

-* Poésie <code><poesie></code>Le texte de la poésie, sur plusieurs lignes, les retour à la ligne simple {{étant}} pris en compte<code></poesie></code>

<poesie>Le geai gélatineux gégnait dans le jasmin
Voici mes infins le plus beau vers de la langue française.</poesie>

-* Cadre <code><cadre></code>Texte qui apparaitra dans une zone de formulaire facilitant le copier/coller[[Essentiellement utilisé sur spip-contrib pour donner des exemples de code]]<code></cadre></code>

<cadre>
Ceci est du texte dans un cadre.
      les espaces en début de ligne comptent !
Les retours à la ligne simples aussi !
</cadre>

-* Citation <code><quote></code>Texte d'une citation<code></quote></code>

<quote>C'est en forgeant que l'on devient forgeron.</quote>

{{{**Caractères}}}

Les attributs de caractères {{doivent}} être ouverts et fermés à l'intérieur du même paragraphe (pas question de débuter le gras sur un premier paragraphe et de le terminer sur un deuxième).

Ils peuvent être utilisés dans {{tous}} les champs de SPIP.

{{{***Mise en forme}}}

-* gras : <code>{{</code>texte en gras<code>}}</code>; à utiliser pour un élément que l'on souhaite appuyer (sera prononcé plus fort dans un logiciel de lecture vocal) : {{texte en gras}}
-* italique : <code>{</code>italique<code>}</code>; à utiliser pour une élément sur lequel on veut insister (sera prononcé avec emphase) : {italique}
-* mise en évidence <code>[*</code>texte en évidence<code>*]</code> : élément que l'on souhaite appuyer en attirant le regard par un changement de couleur : [*texte en évidence*]
-* mise en exposant : <code><sup></code>texte en exposant<code></sup></code> : pour l'abréviation de saint : S<sup>t</sup>
-* petites capitales : <code><sc></code>texte en petite capitales<code></sc></code> : à utiliser essentiellement pour les noms propres : Charles <sc>de Gaulle</sc>
-* code : <html><tt>&lt;code&gt;</tt></html>du code (raccourcis typographiques, html...)<html><tt>&lt;/code&gt;</tt></html> que l'on ne souhaite pas que SPIP interprète
-* biffé : <code><del></code>texte biffé<code></del></code> : pour indiquer qu'on avait pensé à un autre mot et que l'on a changé d'avis : SPIP, c'est <del>bien</del> fantastique!

{{{***Comportement spécifique}}}

{{{****Aides à la compréhension du texte}}}

-* bulle d'aide : <code>[GPL|Gnu Public Licence]</code> : pour donner la signification d'un terme ou d'une abréviation : [GPL|Gnu Public Licence]
_ Ce raccourcis est beaucoup moins nécessaire depuis que vous disposez de [->444] automatiques.

{{{****Liens internes et externes}}}

-* lien : <code>[texte du lien->http://www.spip.net/]</code> : lien : [texte du lien->http://www.spip.net/]
_ À noter qu'il est possible de faire des liens à l'intérieur du site SPIP à l'aide des {{numéros}} des éléments et de leur type (se reporter à l'aide en ligne fournie par SPIP).
-* lien avec bulle d'aide : <code>[texte du lien|Le site officiel de SPIP->http://www.spip.net/]</code> : [texte du lien|Le site officiel de SPIP->http://www.spip.net/]
-* lien avec langue de destination (non visible sur Internet Explorer) : <code>[texte du lien|{fr}->http://www.spip.net/]</code> : [texte du lien|{fr}->http://www.spip.net/]
-* lien avec bulle d'aide et langue de destination : <code>[texte du lien|Le site officiel de SPIP{fr}->http://www.spip.net/]</code> : [texte du lien|Le site officiel de SPIP{fr}->http://www.spip.net/]
-* ancre et retour à l'ancre : <code>[definition_ancre<-]</code> et <code>[retour à l'ancre->#definition_ancre]</code> : [retour à l'ancre->#definition_ancre]
-* définition dans Wikipedia : <code>[?GPL]</code> : appelle l'encyclopédie libre Wkipedia pour obtenir la définition du mot[[Si le mot n'existe pas, vous pouvez le créer vous-même!]] : [?GPL]
_ Avec bulle d'aide : <code>[?GPL|Définition sur Wikipédia]</code> : [?GPL|Définition sur Wikipédia]
-* note de bas de page : <code>texte[[note de bas de page]]</code> : crée une note de bas de page avec le texte entre les doubles crochets[[Et la note de bas de page est automatiquement numérotée, rendue clicable, pour la consulter, et pour revenir au texte l'ayant appelée]]

{{{**Listes}}}

Les listes sont à utiliser pour tout ce qui à le {{sens}} d'une énumération.

{{Attention}}: il faut entourer un bloc de listes à puces d'une ligne vide avant et après.

{{{***Listes à puces}}}

<cadre>
-* première ligne
-* deuxième ligne
-** une sous liste à puce
-* de retour dans le niveau initial
</cadre>

Donnera :

-* première ligne
-* deuxième ligne
-** une sous liste à puce
-* de retour dans le niveau initial

{{{***Listes numérotées}}}

<cadre>
-# première ligne
-# deuxième ligne
-## une sous liste à puce
-# de retour dans le niveau initial
</cadre>

Donnera :

-# première ligne
-# deuxième ligne
-## une sous liste numérotée
-# de retour dans le niveau initial

{{{**Tableaux}}}

Pour être complètement accessible, un tableau dans SPIP doit avoir un titre et une description.

Ainsi :

<cadre>
||Produits bio et prix|Ce tableau sert d'exemple de mise en forme spip||
| {{Produit}} | {{Prix €}} |
| Beurre Bio | 5€ |
| Lait Bio | 3€ |
| Choux Bio | 4€ |
</cadre>

Donnera :

||Produits bio et prix|Ce tableau sert d'exemple de mise en forme spip||
| {{Produit}} | {{Prix €}} |
| Beurre Bio | 5€ |
| Lait Bio | 3€ |
| Choux Bio | 4€ |

Notez les doubles <code>||</code> sur la première ligne du tableau !

[*Attention*]: les pièges classiques avec les tableaux sont :

-* ne pas avoir le même nombre de | sur une ligne
-* avoir un espace {{après}} le dernier | de la ligne (un moyen simple de vérifier : la touche fin du clavier amène à la fin de la ligne)

{{{**Tableaux avec fusion de cellules}}}

<cadre>
||Tableau avec fusion|Ce tableau sert d'exemple de mise en forme spip||
| {{Colonne 1}} | {{Colonne 2}} | {{Colonne 3}} |
| ligne 1 | Cellule fusionnée avec la suivante |<|
| ligne 2 | Cellule fusionnée
_ avec celle du dessous | normale |
| ligne 2 |^| normale aussi |
</cadre>

Donnera :

||Tableau avec fusion|Ce tableau sert d'exemple de mise en forme spip||
| {{Colonne 1}} | {{Colonne 2}} | {{Colonne 3}} |
| ligne 1 | Cellule fusionnée avec la suivante |<|
| ligne 2 | Cellule fusionnée
_ avec celle du dessous | normale |
| ligne 2 |^| normale aussi |

Principe :
-* <code>|<|</code> fusionne avec la cellule de gauche
-* <code>|^|</code> fusionne avec la cellule au dessus

{{{Images}}}

Pour les images et documents, reportez-vous à l'aide en ligne de SPIP. Seule contrainte pour l'accessibilité (et donc un meilleur référencement) : donnez un titre à {{toutes}} vos images décrivant le {{[sens|signification]}} de chacune d'elles.

{{{Caractères spéciaux}}}

-* <code>~</code> (espace insécable ou espace dur -- correspond au <code>&nbsp;</code> du [HTML|Hyper Text Markup Language]) placé entre deux mots remplace l'espace en ayant l'avantage d'être insécable, c'est-à-dire, qu'il empêchera les deux mots d'être séparés par un retour à la ligne malvenu. S'utilise en particulier entre le prénom et le nom propre.
-* <code>--></code> : --> (flèche vers la droite)
-* <code><--</code> : <-- (flèche vers la gauche)
-* <code><--></code> : <--> (flèche vers la gauche et vers droite)
-* <code>==></code> : ==> (double flèche vers la droite)
-* <code><==</code> : <== (double flèche vers la gauche)
-* <code><==></code> : <==> (double flèche vers la gauche et vers droite)
-* <code>--</code> : -- (tiret cadratin) à utiliser pour les incises dans un texte
-* <code>...</code> : ... (3 petits points) points de suspension
-* <code>(c)</code> : (c) : CopyRight
-* <code>(r)</code> : (r) : Registered
-* <code>(tm)</code> : (tm) : Trade Mark

{{{Ligne horizontale}}}

<code>----</code>: 4 signes moins en seuls sur une ligne (précédés d'une ligne vide et suivis d'une ligne vide) donneront un trait de séparation horizontal.

---- 

{{{Éléments dangereux}}}

Il y a deux éléments {{dangereux}} dans SPIP :

-* le retour à la ligne simple : <code>_ </code> (souligné espace) en début de ligne.
_ Usage toléré pour donner adresse et numéro de téléphone/fax.
_ Usage toléré : dans une liste à puce pour passer à la ligne sans passer à une nouvelle puce (comme ici).
_ Usage {{[*interdit*]}}: pour mettre plus d'espace vertical entre deux éléments de la page.
-* le [?HTML] pur : il est {possible} dans SPIP de mettre du code [HTML|Hyper Text Markup Language]. Le faire est fortement déconseillé :
-** parce que c'est la porte ouverte à toutes les dérives, ne serait-ce que celle de sortir de la charte graphique du site, ou celle de produire un code HTML non valide (voire non interprétable ailleurs que sur [Internet Explorer->115]
-** parce que c'est partir du postulat que votre site ne sera visité qu'en tant que site web ; il pourrait très bien être un jour disponible sous forme de fichiers PDF...

[titraille<-]

{{{Exemples de titraille : Titre principal}}}

<code>{</code><code>{{</code>Exemples de titraille : Titre principal<code>}}</code><code>}</code>

{{{**Titre niveau deux}}}

<code>{</code><code>{{**</code>Titre niveau deux<code>}}</code><code>}</code>

{{{***Titre niveau trois}}}

<code>{</code><code>{{***</code>Titre niveau trois<code>}}</code><code>}</code>

{{{****Titre niveau quatre}}}

<code>{</code><code>{{****</code>Titre niveau quatre<code>}}</code><code>}</code>

{{{*****Titre niveau cinq}}}

<code>{</code><code>{{*****</code>Titre niveau cinq<code>}}</code><code>}</code>

{{{Placement des images}}}

<img1|left><code><img1|left></code>

----

<img1|center>
<code><img1|center></code>

----

<img1|right><code><img1|right></code>

----

<doc1|left><code><doc1|left></code>

----

<doc1|center>
<code><doc1|center></code>

----

<doc1|right><code><doc1|right></code>

----

<emb1|left><code><emb1|left></code>

----

<emb1|center>
<code><emb1|center></code>

----

<emb1|right><code><emb1|right></code>

----

EOF;
		$contenu['ps'] = <<<EOF
Une extension pour FireFox est très utile pour savoir rapidement si vous avez fait une erreur de raccourcis typographiques : [HTML VALIDATOR (based on Tidy)->http://users.skynet.be/mgueury/mozilla/]. Dans la version modifiée de SPIP que j'utilise, cette validité est aussi vérifiable dans l'interface d'administration de SPIP, et pas seulement du côté des visiteurs.

Quant à l'écriture pour le Web, vous pouvez visiter l'excellent [Redaction.be|Le site des spécialistes de l'information en ligne->http://www.redaction.be/]
EOF;
		$contenu['nom_site'] = "Original de l'article";
		$contenu['url_site'] = "http://www.pyrat.net/Raccourcis-Typographiques-de-SPIP-mode-d-emploi.html";
	}
	
	/* Partage */
	if ($article == 'Partage') {
		$contenu['titre'] = $article;
		$contenu['descriptif'] = 'Sénèque';
		$contenu['texte'] = "«~Un bien n'est agréable que si on le partage.~»";
	}
	/* Économies */
	if ($article == 'Économies') {
		$contenu['titre'] = $article;
		$contenu['descriptif'] = 'Ma vieille grand-mère';
		$contenu['texte'] = "« On n'est pas assez riches pour acheter du bon marché. »";
	}
	/* Concision */
	if ($article == 'Concision') {
		$contenu['titre'] = $article;
		$contenu['descriptif'] = 'Pascal';
		$contenu['texte'] = "« Je n'ai pas eu le temps de faire court... »";
	}
	/* Contact */
	if ($article == 'Contact') {
		$contenu['titre'] = $article;
		$contenu['descriptif'] = 'Nous contacter';
		$contenu['chapo'] = "=aut1";
	}
	/* Politique d'accessibilité du site */
	if ($article == "Politique d'accessibilité du site") {
		$contenu['titre'] = $article;
		$contenu['descriptif'] = "Politique d'accessibilité du site";
		$contenu['chapo'] = "Le [squelette SPIP SoyezCreateurs->https://contrib.spip.net/SoyezCreateurs,1237] utilisé sur ce site est conçu pour faciliter la mise en œuvre des bonnes pratiques de l'accessibilité des sites pour tous.";
		$contenu['texte'] = <<<EOF
SoyezCreateurs accorde un soin tout particulier à la qualité de réalisation de ses sites Internet. Il est ainsi engagée dans une démarche d’optimisation de l’accessibilité de ses contenus web. Cette démarche vise dans un premier temps à faciliter la consultation de nos sites par les personnes handicapées, non voyantes, malvoyantes ou malentendantes. Mais plus généralement, la démarche d’accessibilité est indispensable pour garantir le plus large accès à nos contenus par tous les internautes et tous les dispositifs de lecture.

{{{L’accessibilité des services de communication publique de l’État}}}

La loi n° 2005-102 du 11 février 2005 « pour l’égalité des droits et des chances, la participation et la citoyenneté des personnes handicapées » instaure au titre de l’article 47, l’obligation pour les services de communication publique en ligne des services de l’Etat, des collectivités territoriales et des établissements publics qui en dépendent d’être accessibles aux personnes handicapées.

<quote>Article 47 : « Les services de communication publique en ligne des services de l’Etat, des collectivités territoriales et des établissements publics qui en dépendent doivent être accessibles aux personnes handicapées.

L’accessibilité des services de communication publique en ligne concerne l’accès à tout type d’information sous forme numérique quels que soient le moyen d’accès, les contenus et le mode de consultation. Les recommandations internationales pour l’accessibilité de l’internet doivent être appliquées pour les services de communication publique en ligne.

Un [décret en Conseil d’État->http://www.legifrance.gouv.fr/affichTexte.do?cidTexte=JORFTEXT000020616980&dateTexte=20090527] fixe les règles relatives à l’accessibilité et précise, par référence aux recommandations établies par l’Agence pour le développement de l’administration électronique, la nature des adaptations à mettre en œuvre ainsi que les délais de mise en conformité des sites existants, qui ne peuvent excéder trois ans, et les sanctions imposées en cas de non-respect de cette mise en accessibilité. Le décret énonce en outre les modalités de formation des personnels intervenant sur les services de communication publique en ligne ».</quote>

Le [Référentiel général d’accessibilité pour les administrations->http://www.references.modernisation.gouv.fr/] (RGAA) est le guide de référence (compatible avec les recommandations du W3C) pour assurer la mise en conformité des sites Internet publics.

SoyezCreateurs, respecte[[En ce qui concerne le contenant ; le contenu devant lui aussi être rendu accessible par les rédacteurs du site...]] l’intégralité des points de contrôle obligatoires et le plus grand nombre de points de contrôle recommandés.

Néanmoins, si vous rencontrez des difficultés techniques pour consulter notre site, merci de nous contacter.

{{{Conseils et astuces pour faciliter votre navigation}}}

{{{**Naviguez comme vous le souhaitez}}}

L’ensemble du site est consultable au clavier. Vous pouvez ainsi parcourir la page dans son ordre logique de lecture, de liens en liens, en utilisant la touche « tabulation » de votre clavier.

{{{**Agrandissez les caractères}}}

En appuyant simultanément sur les touches <code>Ctrl et +</code>, vous grossissez par effet de loupe l’ensemble de la page (Internet Explorer et Firefox).

<code>Ctrl + 0</code> permet de revenir à la taille par défaut

{{{**Imprimez une version adaptée au papier}}}

Toutes les pages sont imprimables (Fichier > Impression ou touches <code>CTRL + P</code>) dans une version adaptée au papier : le texte et plus aéré et les différents éléments inutiles à la lecture (principalement les menus de navigation) ont été supprimés.

{{{**Utilisez une version récente de navigateur}}}

En mettant à jour gratuitement la version de votre navigateur, vous vous assurez une lecture la plus conforme aux standards et donc la plus accessible. Pour télécharger les dernières versions des principaux navigateurs :

-* [Mozilla FireFox->http://www.mozilla-europe.org/fr/firefox/]
-* [Apple Safari->http://www.apple.com/fr/safari/]
-* [Opera->http://www.opera.com/browser/]
-* [Google Chrome->http://www.google.com/chrome]
-* [Microsoft Internet Explorer->http://www.microsoft.com/france/windows/products/winfamily/ie]

Nous vous invitons en particulier à ne plus utiliser les versions 6 et inférieures d’Internet Explorer, considérées aujourd’hui comme obsolètes en terme de sécurité et de conformité aux standards.

{{{**Ouverture des liens dans une nouvelle fenêtre/onglet}}}

Vous avez le choix ! C'est vous qui décidez ! Rien ne vous est imposé.

Pour ouvrir un lien dans une nouvelle fenêtre (ou un nouvel onglet), il suffit :
-* à la souris de cliquer avec la molette sur le lien
-* pas de molette ? <code>Ctrl + clic gauche</code>
-* ou encore, bouton droit sur le lien et choisir l'option adéquate 

Bonne navigation !
EOF;
		$contenu['PS'] = "{{NB}} : Ce texte a été librement repris et adapté depuis [son original->http://www.vie-publique.fr/information/politique-accessibilite.html] avec l'aimable autorisation de vie-publique.fr.";
	}
	/* Installation du site */
	if ($article == 'Installation du site') {
		$contenu['titre'] = $article;
		$contenu['descriptif'] = 'Date d\'installation du site';
		$contenu['texte'] = "Cet événement est là pour vous montrer que vous pouvez utiliser un [agenda événementiel dans votre site->https://contrib.spip.net/Agenda-evenementiel-avec].";
	}
	/* Événement exceptionnel */
	if ($article == 'Événement exceptionnel') {
		$contenu['titre'] = $article;
		$contenu['descriptif'] = "Pour un événement qui ne se produit qu'une fois";
		$contenu['texte'] = "Quand un événement ne se produit qu'une fois, il vaut mieux faire un article qui contienne un descriptif de l'événement et ne mettre dans l'événement lui-même que sa date. Le titre de l'événement devra alors être identique à celui de l'article.\n\nIl sera même possible de faire une galerie de photographies dans ce même article...";
	}
	/* Versions de SPIP */
	if ($article == 'Versions de SPIP ') {
		$contenu['titre'] = $article;
		$contenu['descriptif'] = "Historique des versions de SPIP";
		$contenu['texte'] = "[SPIP->http://www.spip.net/].";
	}

	return $contenu;
}
?>