Ce squelette est ouvert aux commits après en avoir discuté avec son auteur : real3t@gmail.com

Licence : il est distribué en licence CC-BY-SA

Documentation : http://www.soyezcreateurs.net/-Pyrat-net,71-.html

Il sera possible de participer à cette documentation sur :
http://www.soyezcreateurs.net/ecrire/

En l'état, ce squelette nécessite :
- SPIP 1.9 SVN
- le plugin http://zone.spip.org/trac/spip-zone/browser/_plugins_/_typo_/barre_typo_enrichie
- d'être installé à la racine d'un serveur (sous dossier impossible, à moins de refaire le .htaccess), voire le virtual host d'apache pour disposer de plusieurs serveurs sur une seule IP
- les rewrite rules doivent être disponibles sous apache (M$ IIS impossible) 

Il est nécessaire pour le fonctionnement du squelette d'installer les mots clefs :
- une fois identifié dans le site : /ecrire/ ?exec=postconfig
- il est possible de recréer le php de génération des mots clefs en allant dans /@motconf.html et de le copier coller dans squelettes/exec/postconfig.php

En l'état (avant travail en commun), le squelette a l'aspect de http://vallee-aisne60.cef.fr/
