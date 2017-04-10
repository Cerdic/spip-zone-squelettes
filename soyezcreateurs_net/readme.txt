Ce squelette est ouvert aux commits après en avoir discuté avec son auteur : real3t@gmail.com

Licence : il est distribué en licence GPL

Documentation : https://contrib.spip.net/SoyezCreateurs,1237?tri_articles=titre

Il sera possible de participer à cette documentation sur SPIP-Contrib

En l'état, la dernière version ce squelette nécessite :
- SPIP 2.1.2
- plein de plugins

----
Méthode de travail en commun : le principe pour toucher au squelette :
- rajouter un mot clef ou une config
- rajouter la boucle utilisant le mot clef pour obtenir le comportement différent
- mettre à jour la procédure d'installation avec le mot clef ayant la valeur qui fait que la fonctionnalité est débrayée par défaut (sauf si elle apporte un vrai plus)
  Autrement dit, il ne faut pas que les sites déjà existants soient "cassés" par une mise à jour
- vérifier que c'est toujours valide XHTML avec et sans la fonctionnalité et commiter si possible avec une url d'exemple
- merci aussi de respecter au maximum les bonnes pratiques en terme d'accessibilité à tous.
- Eviter de créer des CSS supplémentaires quand celles déjà disponibles suffiraient avec le bon HTML

----

Travail avec des branches et des tags ? (copier/coller depuis IRC, jamais appliqué)

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