#!/bin/bash
#
# Ce script crée un fichier `liste_svn_co.done.sh` contenant une liste
# de commande svn checkout à faire pour retrouver la même arborescence
#
# Ceci sous-entend que seuls les répertoires à la racine du répertoire
# d'exécution sont sous svn (pas de sous répertoire ayant lui même les répertoires SVN).
# Tout répertoire non svn est ignoré.
#
# Ainsi, si le script est exécuté dans plugins/
# Avec cette arbo cela fonctionnera :
# - A
# - B
# - C
# où A, B et C sont les répertoires issus d'un SVN quelconque.
#
# Mais *pas* avec cette arbo :
# - themes/A
# - themes/B
# - C
# Le répertoire 'themes' n'étant pas en SVN sera ici ignoré.
#

FILE='liste_svn_co.done.sh'
ICI=$(pwd)

rm -f $FILE;
echo "#!/bin/bash" >> $FILE
echo "#" >> $FILE
echo "# Liste des svn co du répertoire :" >> $FILE
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