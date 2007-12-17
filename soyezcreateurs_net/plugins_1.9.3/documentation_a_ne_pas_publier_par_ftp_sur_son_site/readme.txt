Ce squelette est ouvert aux commits apr�s en avoir discut� avec son auteur : real3t@gmail.com
C'est un squelette hybrid� en plugins.

Licence : il est distribu� en licence CC-BY-SA

ToDo : Documentation

Il sera possible de participer � cette documentation sur :
http://www.soyezcreateurs.net/ecrire/

Les veinards sous Linux peuvent consulter le dossier linux qui contient 2 fichiers de shell :
- installsc.sh qui r�cup�re par SVN SPIP et *tous* les plugins n�cessaires (ou pratiques) pour utiliser ce squelette
- updatesc.sh qui fait automatiquement la mise � jour par SVN de SPIP et de *tous* les plugins install�s (sous r�serve qu'ils ne soient pas dans un sous sous dossier de plugins/)

En l'�tat, ce squelette n�cessite :
- SPIP 1.9.3
- les plugins (liste � v�rifier par rapport � www.pyrat.net en affichant les header) :
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acces_restreint
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acronymes
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/agenda/1_9_2 ./agenda/
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/balise_session
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/barre_typo_v2 
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/enluminures_typographiques_v2
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/boutonstexte
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/gestion_documents
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/recherche_etendue
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/sitemap
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/typo_exposants
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/typo_guillemets
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/w3c_go_home
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/widget_calendar
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/cfg
 - svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/forms/forms_et_tables_1_9_1
- d'�tre install� � la racine d'un serveur (sous dossier impossible, � moins de refaire le .htaccess). Doncn, voir le virtual host d'apache pour disposer de plusieurs serveurs sur une seule IP
- les rewrite rules doivent �tre disponibles sous apache (M$ IIS impossible) 

Il est n�cessaire pour le fonctionnement du squelette d'installer les mots clefs :
- une fois identifi� dans le site : /ecrire/ ?exec=postconfig
- il est possible de recr�er le php de g�n�ration des mots clefs en allant dans /@motconf.html et de le copier coller dans  exec/postconfig.php du plugin

En l'�tat (avant travail en commun), le squelette a l'aspect de http://www.ecolotech.eu/

----
M�thode de travail en commun : le principe pour toucher au squelette :
- rajouter un mot clef ou rajouter une config
- rajouter la boucle utilisant le mot clef pour obtenir le comportement diff�rent
- mettre � jour postconfig avec le mot clef ayant la valeur qui fait que la fonctionnalit� est d�bray�e par d�faut (sauf si elle apporte un vrai plus)
- v�rifier que c'est toujours valide XHTML avec et sans la fonctionnalit� et commiter si possible avec une url d'exemple
