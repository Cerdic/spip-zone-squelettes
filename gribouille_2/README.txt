GRIBOUILLE
==========

Gribouille est un squelette qui tente de refaire (en pur SPIP) ce qu'on
avait avec spikini.


INSTALLATION
============

* installer et activer "les crayons"

* installer et activer le plugin "Gribouille 2"

* Configurez via CFG le ou les secteurs Wiki


CONFIGURATION
=============


Autorisations
-------------

Les autorisations sont gérées dans le formulaire de configuration CFG dans 
l'administration de SPIP


Cantonner ces articles
----------------------

Si l'on veut éviter que ces articles ne s'affichent ailleurs (RSS,
page d'accueil etc), une possibilité est d'utiliser un plugin ad hoc
(par exemple accès restreint), en lui disant d'exclure les rubriques
consacrées aux wiki. Il faut alors désactiver ce plugin sur les deux
squelettes spécialisés (TODO).



Mise à jour depuis spikini
--------------------------

Si vous utilisiez déjà spikini, celui-ci dispose maintenant d'une fonction
d'import vers SPIP. Il suffit d'aller sur la page d'accueil du spikini, et
d'ajouter ?importer=oui dans l'URL, puis de préciser le numéro de la rubrique
vers laquelle importer les données. Attention la procédure est très lourde
et risque d'échouer sur de gros sites spikini si le temps alloué à php est
faible.

Les adresses des pages sont ensuite perdues, mais il est possible de rediriger
automatiquement /spikini/ vers l'adresse de la rubrique où les données ont été
importées.

