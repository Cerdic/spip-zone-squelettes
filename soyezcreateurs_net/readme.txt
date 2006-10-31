Ce squelette est ouvert aux commits apr�s en avoir discut� avec son auteur : real3t@gmail.com

Licence : il est distribu� en licence CC-BY-SA

Documentation : http://www.soyezcreateurs.net/-Pyrat-net,71-.html

Il sera possible de participer � cette documentation sur :
http://www.soyezcreateurs.net/ecrire/

En l'�tat, ce squelette n�cessite :
- SPIP 1.9.1
- les plugins :
 - agenda
 - barre_typo_enrichie
 - -jQuery
 - widget_calendar
- d'�tre install� � la racine d'un serveur (sous dossier impossible, � moins de refaire le .htaccess), voir le virtual host d'apache pour disposer de plusieurs serveurs sur une seule IP
- les rewrite rules doivent �tre disponibles sous apache (M$ IIS impossible) 

Il est n�cessaire pour le fonctionnement du squelette d'installer les mots clefs :
- une fois identifi� dans le site : /ecrire/ ?exec=postconfig
- il est possible de recr�er le php de g�n�ration des mots clefs en allant dans /@motconf.html et de le copier coller dans squelettes/exec/postconfig.php

En l'�tat (avant travail en commun), le squelette a l'aspect de http://vallee-aisne60.cef.fr/

----
M�thode de travail en commun : le principe pour toucher au squelette :
- rajouter un mot clef
- rajouter la boucle utilisant le mot clef pour obtenir le comportement diff�rent
- mettre � jour postconfig avec le mot clef ayant la valeur qui fait que la fonctionnalit� est d�bray�e par d�faut (sauf si elle apporte un vrai plus)
- v�rifier que c'est toujours valide XHTML avec et sans la fonctionnalit� et commiter si possible avec une url d'exemple

----

Travail avec des branches et des tags ? (copier/coller depuis IRC)

sous le dossier "soyezcreateurs_net" il convient de cr�er deux ou trois sous-dossiers en plus
"trunk"
"branches"
"tags" (�ventuellement)
Donc
root/_squelettes_/soyezcreateurs_net/trunk
mais tu n'as pas besoin de �a
Voici comment on peut faire
svn mkdir svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/branches -m "Ajout d'un lieu de branches"
svn mkdir svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags -m "Ajout d'un lieu de tags"
Apr�s que tu fais �a (ou moi) je ferai :
svn cp svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/squelettes svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/e-delib_squelettes
puis
pardon
svn cp svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/squelettes svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/branches/e-delib_squelettes
et
je tag
svn cp svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/branches/e-delib_squelettes svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags/e-delib_squelettes_tag-001
et pour �tre hyper clair, je tag aussi la branche trunk (qui s'appelle squelettes au fait)
svn cp svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/squelettes svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags/squelettes_tag-001
...
Pour rassembler ensuite, voici comment on fait
cd squelettes (le vrai)
svn merge svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags/e-delib_squelettes_tag-001 svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags/e-delib_squelettes_tag-002 svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/branches/e-delib_squelettes
ou
svn merge
svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags/e-delib_squelettes_tag-001
svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags/e-delib_squelettes_tag-002
.
et on test le dossier local
puis svn ci