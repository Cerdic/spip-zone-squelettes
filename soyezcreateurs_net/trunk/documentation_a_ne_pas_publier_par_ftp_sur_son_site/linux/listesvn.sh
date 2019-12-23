#!/bin/bash
#
# Ce script cr�e un fichier `liste_svn_co.done.sh` contenant une liste
# de commande svn checkout � faire pour retrouver la m�me arborescence
#
# Ceci sous-entend que seuls les r�pertoires � la racine du r�pertoire
# d'ex�cution sont sous svn (pas de sous r�pertoire ayant lui m�me les r�pertoires SVN).
# Tout r�pertoire non svn est ignor�.
#
# Ainsi, si le script est ex�cut� dans plugins/
# Avec cette arbo cela fonctionnera :
# - A
# - B
# - C
# o� A, B et C sont les r�pertoires issus d'un SVN quelconque.
#
# Mais *pas* avec cette arbo :
# - themes/A
# - themes/B
# - C
# Le r�pertoire 'themes' n'�tant pas en SVN sera ici ignor�.
#

FILE='liste_svn_co.done.sh'
ICI=$(pwd)

rm -f $FILE;
echo "#!/bin/bash" >> $FILE
echo "#" >> $FILE
echo "# Liste des svn co du r�pertoire :" >> $FILE
echo "# "$ICI >> $FILE
echo >> $FILE

for i in $(ls); do
	if [ -d $i ]; then
		cd $i
		if [ -d ".svn" ]; then
			URL=$(svn info | grep URL | cut -d ":" -f2-3)
			NOM=$(basename $i)
			cd ..
			if [ -n "$URL" ]; then
				echo "svn co"$URL $NOM >> $FILE;
			fi
		else
			if [ -d .git ]; then
				echo "== Remote URL: `git remote -v`"
				URL=$(git remote -v)
				NOM=$(basename $i)
				cd ..
			else
				cd ..
			fi
		fi
	fi
done