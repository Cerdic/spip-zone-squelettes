Les squelettes mis en ligne à partir de la template html5up-strongly-typed sont pour la plupart opérationnels.
Vous trouverez les fichiers originaux à l’adresse suivante :
https://html5up.net/strongly-typed

Les points suivants n'ont pas été résolus :
- la balise #FORMULAIRE_FORUM n'affiche pas le forum, mais affiche l'ensemble des interventions dans les forums et validés pour publication, elle a donc été enlevé 
- de même la balise [(#PLUGIN{socialtags}|oui)[(#INCLURE{fond=noisettes/socialtags}{id_article})]] n'affiche rien, 
- il nous a pas été possible d'afficher les images comme le propose le squelette ARTICLE de la Distribution,
- nous n'avons pas utilisé un plug-in pour l'affichage vertical des rubriques du haut, car ne maitrisant pas parfaitement ceux proposant le type d'affichage demandé.

Les squelettes du premier niveau contiennent tous la commande INCLURE vers des fichiers de deuxième et troisième niveau. 
Ainsi tous les squelettes du premier niveau contiennent un include vers le fichier footer.html, lui-même ayant un include vers retour_haut.html.
Seul le fichier du deuxième niveau  partie_droite_sommaire_1.html contient un include pour le fichier flash_infos.html

Dans le répertoire SQUELETTES/IMG se trouve l'image 1959a.png appelé par le squelette 404.html.
De même dans le répertoire IMAGES se trouve le fichier image QUADRATURE.PNG pouvant remplacer l'appel vers l'url indiqué dans cette ligne de commande 
<center><a href="https://www.laquadrature.net/fr" alt="La Quadrature du Net"><img src="http://blog.spyou.org/wordpress-mu/files/2011/05/20110524-lqdn-300x300.png"></a></center>
située dans les squelettes partie_droite_sommaire_2.html, partie_droite_rubrique_2.html, partie_droite_rubrique.html

 L'url du site permettant de configurer ou de changer les icônes est la suivante :  http://fontawesome.io/icons/ 
 Il suffit via le moteur de recherche du site, d'afficher la ligne de commande correspondante à un icône demandé, 
 par exemple fa-file-text-o viendra dans la ligne de commande <h2 class="icon fa-file-text-o"> pour que l'icône demandé s'affiche. 
 Tous les squelettes ont été dans la mesure du possible documentés : partie haute, partie gauche, partie droite, ..... 
 
 Le 25/04/17