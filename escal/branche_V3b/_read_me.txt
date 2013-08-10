ESCAL V3b :
===========

Installation des mots-clefs auto :
----------------------------------

Le schema (tructure de l'arborescence des mots-clefs technique de Escal),
est stocké dans une fonction schema_escal() placée dans escal_fonctions.php,
la fonction retourne un tableau (array) :

    array(
        'groupes' => array(
                array(
                    'titre'=>'affichage',
                    'descriptif'=>'Groupe de mots-cl&eacute;s techniques utilis&eacute;s dans Escal',
                    'tables_liees'=>'articles,rubriques,syndic',
                    'minirezo'=>'oui',
                    'comite'=>'oui'
                ),
                // ...
            ),
        'mots'=> array(
                array(
                    'titre'=>'pas-au-menu',
                    'descriptif'=>'pour ne pas afficher une rubrique ou un article dans le menu horizontal',
                    'type'=>'affichage'
                    ),
                array(
                    'titre'=>'pas-au-menu-vertical',
                    'descriptif'=>'pour ne pas afficher une rubrique ou un article dans les menus verticaux',
                    'type'=>'affichage'
                )
                // ...
            )    
    )

METTRE A JOUR :
---------------

Pour proposer une mise a jour du schema des groupes et mots-clefs,
il faut incrémenter dans paquet.xml le numéro de schema et pour l'offrir au utilisateur via svp le numéro de version du plugin,

puis dans escal_administrations.php

soit incrémenter le tableau $maj['x.x.X'],
pour une modification mineur :
orthographe dans un descriptif, nouveau champ utilisé dans la table groupe ou mots

Soit pour une modification majeur :
écrire une fonction correspondante aux actions a faire,
suppressions d'un mot-clef, renomage d'un titre, changer les articles associés au mot ..

DESINSTALLATION :
-----------------

La fonction de désinstallation, supprime les mots-clefs associé au groupe décrit dans le shema, puis le groupe.
Les articles ne sont pas touché, et aucune procédure ne les désassocie ou nettoie la table mot_liens pour le moment.
    
    
LIMITATIONS :
-------------

*   On ne peut pas modifier un titre : On peut modifier toutes les infos, sauf le titre sur lequel les fonctions se base, pour mettre a jour
*   On ne peut pas supprimer un groupe ou un mot-clef du schema, il ne se désinstallera pas pour le moment
