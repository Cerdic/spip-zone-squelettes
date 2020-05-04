# Integraal

Integraal est une base de travail pour vos projets d'intégration, sous la forme de 3 plugins gérant les squelettes, le thème et les fonctionnalités de l'application.

Il ne s’agit pas de plugins prêts à l'emploi : vous allez créer les squelettes et le thème de votre projet à partir de la base fournie par Intégraal, en modifiant directement celle-ci.

## Installation

Pour initialiser un nouveau projet basé sur intégraal, le plus simple est d'utiliser SPIP-Cli et de suivre les indications.
La commande va déployer les 3 plugins dans le dossier adéquat :

````
spip integraal:generer
````

Une fois les plugins créés, vous pouvez alors les modifier pour les adapter à votre projet.


## Branches

2 versions du thème sont disponibles.

### theme/branches/scssphp

Version compilable avec le plugin [scssphp](https://plugins.spip.net/scssphp.html).

### theme/trunk

Version compilable avec [node.js](https://nodejs.org) et l'automatiseur de tâches [gulp](https://gulpjs.com/)

**Pré-requis :**

* Installer node.js
* Installer gulp : ```[sudo] npm install gulp -g```
* Installer les modules en dépendances : ```npm install```

**Utilisation : **

Lancer la commande ```gulp watch``` avant d'éditer les fichiers.

Cette tâche principale va surveiller en direct toutes les modifications faîtes dans les dossiers /scss et /javascript, et lancer les sous tâches nécessaires : compilation, formatage, ajout des préfixes navigateur, minification, etc.

## Mise en œuvre rapide

* Placer les fichiers de polices dans css/fonts, puis déclarer les nouvelles familles en éditant css/font.css. Enfin, utiliser celles-ci en les ajoutant à la liste dans le fichier de configuration du thème : scss/base/settings.scss.
* Supprimer les scripts dont vous n'avez pas l'utilité dans inclure/head.html, après la balise `#INSERT_HEAD`
* Instructions à compléter...