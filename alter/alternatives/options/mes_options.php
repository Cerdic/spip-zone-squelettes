<?php
##############################################################
# Fichier mes_options.php                        SPIP v1.9.2 #
#                                                            #
# L'utilisation de ce fichier est optionnelle,               #
# mais fortement recommandee                                 #
#                                                            #
# Permet de configurer :                                     #
# 1. le mode multilingue du site (ACTIVE)                    #
# 2. le type d'adressage (URL) (INACTIVE)                    #
#    le mode propsose ici est 'html'                         #
# 3. la suppression des numeros devant les TITRES            #
#    pour en forcer le tri (ACTIVE)                          #
#                                                            #
# Pour utiliser ce fichier copiez-le dans le repertoire      #
# /config, en veillant a ne pas ecraser un mes_options.php   #
# personnalise qui s'y trouverait deja                       #
#                                                            #
##############################################################

############### CONFIGURATION MULTILINGUE ####################

// Pour desactiver le mode multilingue, si votre site est monolingue,
// commenter en placant un '#' au debut de la ligne suivante :

	$forcer_lang = true ;

############# CONFIGURATION ADRESSAGE .html ##################

// Pour activer, 
// 1. activer le fichier .htaccess (lire INSTALL.txt situe a la racine du repertoire de SPIP)
// 2. lire les instructions dans le fichier 'htaccess.txt' 
// 3. pour obtenir des adresses du type /article23.html,
//    supprimer le '#' devant la ligne suivante :

#	$type_urls = "html";


################ CONFIGURATION TITRAGE #######################

// Dans le squelette ALTERNATIVES, tous les #TITRE sont filtr�s
// par #TITRE|supprimer_numero ; mais il est possible que nous
// en ayons oublie ; on ne prend pas de chance, on les supprime
// ici globalement ; ca s'appliquera aussi a tous les squelettes
// du site que nous pourrions ajouter et aux squelettes /dist/
// que l'on utilise (backend, formulaire, etc...).

	$table_des_traitements['TITRE'][]= 'supprimer_numero(typo(%s))';

?>