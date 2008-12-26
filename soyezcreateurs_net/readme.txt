Ce squelette est ouvert aux commits après en avoir discuté avec son auteur : real3t@gmail.com

Licence : il est distribué en licence GPL

Documentation : http://www.soyezcreateurs.net/-Pyrat-net,71-.html

Il sera possible de participer à cette documentation sur :
http://www.soyezcreateurs.net/ecrire/

En l'état, ce squelette nécessite :
- SPIP 2.0
- plein de plugins :
- les rewrite rules doivent être disponibles sous apache (M$ IIS impossible) 

----
Méthode de travail en commun : le principe pour toucher au squelette :
- rajouter un mot clef ou une config
- rajouter la boucle utilisant le mot clef pour obtenir le comportement différent
- mettre à jour postconfig avec le mot clef ayant la valeur qui fait que la fonctionnalité est débrayée par défaut (sauf si elle apporte un vrai plus)
- vérifier que c'est toujours valide XHTML avec et sans la fonctionnalité et commiter si possible avec une url d'exemple

----

Travail avec des branches et des tags ? (copier/coller depuis IRC)

sous le dossier "soyezcreateurs_net" il convient de créer deux ou trois sous-dossiers en plus
"trunk"
"branches"
"tags" (éventuellement)
Donc
root/_squelettes_/soyezcreateurs_net/trunk
mais tu n'as pas besoin de ça
Voici comment on peut faire
svn mkdir svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/branches -m "Ajout d'un lieu de branches"
svn mkdir svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags -m "Ajout d'un lieu de tags"
Après que tu fais ça (ou moi) je ferai :
svn cp svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/squelettes svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/e-delib_squelettes
puis
pardon
svn cp svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/squelettes svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/branches/e-delib_squelettes
et
je tag
svn cp svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/branches/e-delib_squelettes svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/tags/e-delib_squelettes_tag-001
et pour être hyper clair, je tag aussi la branche trunk (qui s'appelle squelettes au fait)
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