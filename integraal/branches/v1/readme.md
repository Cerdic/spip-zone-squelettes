# Integraal

Integraal est une base de travail pour vos projets d'intégration, sous la forme de 3 plugins gérant les squelettes, le thème et les fonctionnalités de l'application.

## Installation

Pour initialiser un nouveau projet basé sur intégraal, le plus simple est d'utiliser SPIP-Cli et de suivre les indications.
La commande va déployer les 3 plugins dans le dossier adéquat :

````
spip integraal:generer
````

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