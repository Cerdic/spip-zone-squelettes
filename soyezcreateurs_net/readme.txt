Ce squelette est ouvert aux commits apr�s en avoir discut� avec son auteur : real3t@gmail.com

Licence : il est distribu� en licence GPL

Documentation : http://www.spip-contrib.net/SoyezCreateurs,1237?tri_articles=titre

Il sera possible de participer � cette documentation sur SPIP-Contrib

En l'�tat, la derni�re version ce squelette n�cessite :
- SPIP 2.1.2
- plein de plugins

----
M�thode de travail en commun : le principe pour toucher au squelette :
- rajouter un mot clef ou une config
- rajouter la boucle utilisant le mot clef pour obtenir le comportement diff�rent
- mettre � jour la proc�dure d'installation avec le mot clef ayant la valeur qui fait que la fonctionnalit� est d�bray�e par d�faut (sauf si elle apporte un vrai plus)
  Autrement dit, il ne faut pas que les sites d�j� existants soient "cass�s" par une mise � jour
- v�rifier que c'est toujours valide XHTML avec et sans la fonctionnalit� et commiter si possible avec une url d'exemple
- merci aussi de respecter au maximum les bonnes pratiques en terme d'accessibilit� � tous.
- Eviter de cr�er des CSS suppl�mentaires quand celles d�j� disponibles suffiraient avec le bon HTML

----

Travail avec des branches et des tags ? (copier/coller depuis IRC, jamais appliqu�)

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