# Integraal

Integraal est une base de travail pour vos projets d'intégration.

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