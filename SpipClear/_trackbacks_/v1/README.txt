README.txt:
-----------

Version 'draft' des trackbacks pour SPIP

Installation :
==============

-* ajouter la ligne :

  include_local("inc-trackback.php");

dans le fichier mes_fonctions.php3

-* ajouter le tableau :

  $champs_extra = array (
    'articles' => array (
      "accepter_trackbacks" => "radio|brut|Accepter les trackbacks pour cet article|oui,a_priori,non"
    )
  );

dans le fichier ecrire/mes_options.php3

Exploitation des infos de trackbacks sur le site public :
=========================================================

pour permettre la découverte automatique, dans le squelette article.html, ajouter entre <head> et </head> :

[<!--(#PARAMETRES_TRACKBACK)
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
<rdf:Description
  rdf:about="[(#URL_ARTICLE|url_absolue)]"
  dc:identifier="[(#URL_ARTICLE|url_absolue)]"
  dc:title="#TITRE"
  trackback:ping="#URL_TRACKBACK" />
</rdf:RDF>
-->]

exemple pour lister les trackbacks d'un article :

<BOUCLE_trackbacks(FORUMS){id_article}{par date}{inverse}{statut=tbpublie}>
<div>[(#TITRE), ][(#DATE|affdate)][, <a href="(#URL_SITE)">[(#NOM_SITE|sinon{#URL_SITE})]</a>]</div>
[<div>(#TEXTE)</div>]
</BOUCLE_trackbacks>

exemple d'affichage de l'url de trackback (cas des trackbacks manuels) :

[(#PARAMETRES_TRACKBACK)Pour faire un trackback : <code class="spip">#URL_TRACKBACK</code>]

Reglage du paramètre de trackback par article dans l'espace privé :
===================================================================

le champ supplémentaire (bouton radio) peut prendre l'une des trois valeur suivante :

oui : on peut faire des trackbacks sur l'article et il pourront être modérés à posteriori
a_priori : on peut faire des trackbacks sur l'article et il devront être validés avant leur publication (modérés à priori)
non : on ne peut pas faire de trackbacks sur l'article

Modération des trackbacks reçus :
=================================

Appeler le script ecrire/articles_trackback.php?id_article=XX ou XX est le numéro de l'article concerné.
Fonctionne comme la moderation des messages de forum par article.

Envoi de trackbacks :
=====================

Appeler le script ecrire/trackback_envoi.php?id_article=XX ou XX est le numéro de l'article concerné.
La première zone de texte contient les urls de trackbacks découvertes par SPIP. Pour ce faire, SPIP cherche tous les liens externes (http://xxx) dans toutes les zones de textes de l'article. Pour chaque lien externe, la découverte automatique cherche l'url de trackback de la page. Il est possible d'ajouter et/ou supprimer des liens dans cette zone.
La seconde zone de texte contient un extrait du texte (basé sur le modèle de la balise INTRODUCTION et limité à 255 caractères). Il est possible de le modifier avant l'envoi.

TODO :
======

- Internationaliser.
- Patcher le noyau pour integrer des liens vers les nouvelles pages.
- Virer le champ extra et mettre un champ de BDD à la place.
- Historiser les pings.
- Creer une tache de fond pour faire des trackbacks sans intervention des auteurs/admins.
