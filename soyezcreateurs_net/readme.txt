Ce squelette est ouvert aux commits apr�s en avoir discut� avec son auteur : real3t@gmail.com

Licence : il est distribu� en licence CC-BY-SA

Documentation : http://www.soyezcreateurs.net/-Pyrat-net,71-.html

Il sera possible de participer � cette documentation sur :
http://www.soyezcreateurs.net/ecrire/

En l'�tat, ce squelette n�cessite :
- SPIP 1.9 SVN
- le plugin http://zone.spip.org/trac/spip-zone/browser/_plugins_/_typo_/barre_typo_enrichie
- d'�tre install� � la racine d'un serveur (sous dossier impossible, � moins de refaire le .htaccess), voire le virtual host d'apache pour disposer de plusieurs serveurs sur une seule IP
- les rewrite rules doivent �tre disponibles sous apache (M$ IIS impossible) 

Il est n�cessaire pour le fonctionnement du squelette d'installer les mots clefs :
- une fois identifi� dans le site : /ecrire/ ?exec=postconfig
- il est possible de recr�er le php de g�n�ration des mots clefs en allant dans /@motconf.html et de le copier coller dans squelettes/exec/postconfig.php

En l'�tat (avant travail en commun), le squelette a l'aspect de http://vallee-aisne60.cef.fr/
