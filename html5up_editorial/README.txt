Squelette SPIP pour intégrer le modèle Editorial de HTML5UP
https://html5up.net/editorial
Le squelette Solid State https://zone.spip.org/trac/spip-zone/browser/_squelettes_/html5up_solid_state
a été pris pour commencer celui-ci.

v1.0.0
Ce squelette n'utilise pour l'instant que les articles et les rubriques racines, sans sous-rubrique.

Conseil : utiliser Court-Circuit pour éviter la page rubrique s'il n'y a qu'un seul article dans une rubrique.

La page de configuration permet quelques réglages. On y défini le contenu de la page d'accueil, le premier article est le "héro", le second est le "majeur".
L'article héro : le titre, un résumé + le logo + un bouton "Lire la suite"
L'article majeur : le titre + l'introduction. Si cet article est une "page unique" (plugin "Pages") il n'apparaîtra pas dans le menu. Pour rédiger le texte, un modèle permet d'afficher comme dans le thème de départ une icône de FontAwesome et un texte en deux blocs par ligne. C'est le modèle <iconebloc|> qui prend quelques paramètres :
	|icone=fa-rocket (ou tout autre icone de FontAwesome http://fontawesome.io/icons/)
	|iconetitre=le titre
	|iconetexte=le texte
L'article héro de la colonne gauche est aussi désigné dans la page de configuration : on verra le titre, l'introduction et un lien vers la page. En utilisant le champ "Descriptif" des articles, on pourra rédiger le texte qui apparaît dans cette colonne gauche, qui pourra être différent des champs visible sur la page de l'article lui-même.
Le modèle <articleXX|resume> rendra le logo, le titre et un résumé de l'article XX, avec les parametres :
	|affichertitre=non
	|afficherlien=non	
Un autre modèle permet d'insérer n'importe quel icône de FontAwesome dans le flux d'un texte <icone> avec des parametres :
	|icone=fa-rocket (ou tout autre icone de FontAwesome http://fontawesome.io/icons/)
	|taille=3em (ou 60px ou 150%)

Le champ chapeau d'un article s'affiche en public en une colonne pleine largeur, le champ texte s'affiche lui sur deux colonnes, et le champ Post-scriptum se déroule sur 3 colonnes.

Un problème js empêchait aléatoirement le script javascript/main.js de retirer la classe "is-loading" qui est placé sur la balise body (par ce même script). Ce petit soucis cause des prblèmes plus gros dans l'interface.
Un petit bout de code dans javascript/perso.js permet de retirer cette classe de manière plus sûre, mais c'est une rustine en attendant mieux.

TODO
Vérifier et adapter les modèles où qu'on les insère => ok pour <iconebloc> - v1.0.4
Retrouver le multilinguisme 
Adapter les autres objets SPIP (mots, sites, brèves)
Se passer de google api pour les typos ?