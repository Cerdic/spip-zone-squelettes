<?php

############### CONFIGURATION MULTILINGUE ####################

// Pour desactiver le mode multilingue, si votre site est monolingue,
// commenter en placant un '#' au debut de la ligne suivante :

    $forcer_lang = true;

############# CONFIGURATION ADRESSAGE .html ##################

// Pour activer,
// 1. activer le fichier .htaccess (lire INSTALL.txt situe a
//    la racine du repertoire de SPIP)
// 2. lire les instructions dans le fichier 'htaccess.txt'
// 3. pour obtenir des adresses du type /article23.html,
//    supprimer le '#' devant la ligne suivante :

//	$type_urls = "html";


################ CONFIGURATION TITRAGE #######################

// Dans le squelette AHUNTSIC, tous les #TITRE sont filtrés
// par #TITRE|supprimer_numero ; mais il est possible que nous
// en ayons oublie ; on ne prend pas de chance, on les supprime
// ici globalement ; ca s'appliquera aussi a tous les squelettes
// du site que nous pourrions ajouter et aux squelettes /dist/
// que l'on utilise (backend, formulaire, etc...).

    $table_des_traitements['TITRE'][] = 'supprimer_numero(typo(%s))';

############### CONFIGURATION COUTEAU SUISSE ################
// Installation des outils par defaut
// Voir : https://contrib.spip.net/Le-Couteau-Suisse-a-piloter
$GLOBALS['cs_installer']['Ahuntsic']['outils'] =
    'decoupe|sommaire|soft_scroller|guillemets|pucesli|liens_orphelins';
// Installation des variables par defaut
$GLOBALS['cs_installer']['Ahuntsic']['variables'] = array(
    'lgr_sommaire' => 50, // on limite les items du sommaire a 60 caracteres suivi de ...
    'auto_sommaire' => 1, // ou 0, si on ne desire pas de sommaire automatique
    'balise_sommaire' => 0, // ou 1, si on utilise la balise #CS_SOMMAIRE dans les squelettes

    'liens_interrogation' => 1, // ou 0, pour 'non'
    'liens_orphelins' => 1, // 1 pour 'etendu' ; 0 pour 'basique' ; -1 pour 'non'
);
// Compatibilite ascendante avec l'ancien filtre 'decoupe'
@define('_decoupe_COMPATIBILITE', '-----');
