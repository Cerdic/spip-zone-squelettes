<!--
#############################################################
  Le jeu de squelettes AHUNTSIC - version 1.0
#############################################################

Ce dossier contient :
- le jeu de squelettes 'ahuntsic'

Compatibilité : SPIP 2.0 ou plus recent

La documentation de ce jeu de squelettes se trouve a :
	http://edu.ca.edu/rubrique43.html

Aussi référencé https://contrib.spip.net
	

1. POUR INSTALLER LE JEU DE SQUELETTES AHUNTSIC
---------------------------------------------------

AUTOMATIQUE (méthode préférée) :
1. Créer à la racine de SPIP les dossiers /plugins/auto/
2. Dans l'interface privé de SPIP, aller à :
  'Configuration > Gestion des plugins : Ajoutez des plugins'
3. Cliquer sur ou insérer :
     http://files.spip.org/spip-zone/paquets.rss.xml.gz
   et 'Valider'
4. Dans la liste des plugins à installer qui s'affichent, repérer et sélectionner 'ahuntsic'
5. 'Valider' (la dernière version des squelettes sera téléchargé dans /plugins/auto/)
6. Dans la 'Liste des plugins' du haut, cocher 'Squelette Ahuntsic' et 'Valider' pour activer.
7. Dans 'Configuration',  'Vider le cache' du répertoire de SPIP et des images calculées.
8. 'Visiter' votre site public.

Pour une mise à jour automatique des squelettes Ahuntsic, répéter les étapes 4 à 8.

MANUELLE
1. Comme plugin (alternative acceptable à la méthode précédente)
   - Télécharger :
		http://files.spip.org/spip-zone/ahuntsic.zip
   - Décompresser l'archive sur votre poste
   - Créer sur votre serveur à la racine de SPIP les dossiers /plugins/auto/
   - Téléversez le dossier 'ahuntsic' dans :
		./plugins/auto/ahuntsic
   - Dans 'Configuration > Gestion des plugins' activer 'Ahuntsic'
   - Dans 'Configuration',  'Vider le cache' du répertoire de SPIP et des images calculées.

2. Comme squelette ordinaire (pas de mise à jour automatique - possible, mais pas conseillé)
   - Télécharger et décompresser le jeu de squelettes 'ahuntsic.zip'.
   - Créer un dossier ./squelettes/ à la racine de votre installation de SPIP sur votre serveur.
   - Téléverser le CONTENU du dossier 'ahuntsic' dans ./squelettes/ sur votre serveur.
   - Renommer le fichier 'ahuntsic_options.php' en 'mes_options.php' et le déplacer dans le
     dossier ./config/ sur votre serveur.
   - Dans 'Configuration',  'Vider le cache' du répertoire de SPIP et des images calculées.
  

2. POUR PERSONNALISER LES SQUELETTES AHUNTSIC
-------------------------------------------------

Si vous desirez profiter des mises à jour régulières du jeu de squelettes
AHUNTSIC, il est fortement recommandé de ne PAS modifier aucun des fichiers 
qui se trouvent dans :
	/plugins/auto/ahuntsic/

Pour personnaliser un fichier du jeu de squelettes AHUNTSIC, 
utiliser plutôt la procédure suivante :

- Créer à la racine de SPIP un dossier /squelettes/
  Si un dossier /squelettes/ y est déjà présent, le renommer
  sous un autre nom (exemple : '_squelettes').

- Pour modifier les styles de base d'AHUNTSIC
  - créer une feuille de styles très exactement libellé : 
  		/squelettes/styles/perso.css
  -	y inscrire les modifications ou ajouts des régles de styles désirées,  
  	ainsi que les images associées dans un dossier 
  		/squelettes/styles/img/

- Pour modifier n'importe quel autre fichier du jeu de squelettes AHUNTSIC, 
  il suffit de le recopier dans ce dossier de personnaliation et de 
  le modifier selon vos besoins. Il faut seulement respecter la même
  arboresence de fichiers. 
  Exemple :
  	/squelettes/rubrique.html
  	/squelettes/inc/inc-bas.html

- Au besoin, videz le cache de SPIP
	-> Configuration -> Vider le cache

Pour les changements recents en cours de developpement, voir :
	- CHANGES.txt (dans ce meme repertoire)
-->