/* Proposer un devis en ligne */

/* Proposer par soon7 [ https://contrib.spip.net/ecrire/articles.php3?id_article=1091 ] */


Ceci est ma première contrib.

Le but ici est de mettre en place une gestion de caddie, ce qui permet à l’internaute de réaliser un devis en ligne, tout ça grâce à des boucles Spip et un poil de PHP. J’ai utilisé une certaine façon de faire, qui n’est surement pas la meilleure, mais que vous pourrez aisément adapter pour votre usage.

Avant de mettre les mains dans le cambouis voyons un peu la théorie :

LA THEORIE

Sur votre site, vous présentez vos produits (qui sont en fait des "articles" au sens de Spip). Chacun des produits a un lien qui permet de l’amener à une page "Ajouter au bon de commande", où on lui réaffiche le produit, son image, son prix, etc, et là l’utilisateur peut entrer la quantité du produit qu’il souhaite... Si il souhaite l’ajouter, il valide et le produit est ajouté parmi les autres déjà sélectionnés dans son bon de commande. On lui affiche donc son bon de commande avec tous les produits, les quantités, leur prix, les totaux, et le total des Totaux.

MA FACON DE FAIRE

Le but du jeu est de sauvegarder dans une variable de session php un tableau à 2 colonnes, la premiere étant pour les id des articles, la seconde pour la quantité de chacun des articles.

J’ai fait le choix de stocker le prix de chaque produit dans le chapeau de l’article qui lui correspond. Cela reste un choix, vous pourriez créer un champ extra rien que pour ça, il faudra changer quelques éléments, mais la façon de faire reste la même.

Grâce à cette variable de session et aux chapeaux, on peu donc calculer pour chaque article le cout total (quantité * prix) puis le total de la commande , qui est en fait la somme des couts totaux...

MISE EN PRATIQUE

On va y aller pages par pages :

- page(s) "Produit" : Vous créer les pages que vous voulez comme vous voulez, l’important étant de faire en sorte de pouvoir envoyer l’Id de l’article à la page "Ajouter au bon de commande". Dans mon cas, j’ai choisi un formulaire, donc je POSTE ma variable et je la récupère en $_POST.

  page "Ajouter au Bon de Commande" : Cette page récupère l’Id posté précédemment, et réaffiche les éléments concernant le produit ayant l’Id posté. On utlise pour cela une boucle ARTICLES :

id_article=[(#ENVid_dernier,.)]> 

Le #ENV permet d’utiliser la variable postée comme argument pour la boucle. Dans mon cas j’ai nommé la variable postée id_dernier, donc je l’appelle ici par le nom que je lui ai donné.

Lorsque je réaffiche les infos du produit, j’inclus un formulaire où la personne peut choisir la quantité qu’il désire pour le produit en question.

Quand le client a tout régler, il clique sur valider pour ajouter effectivement ce produit et cette quantité à son bon de commande. Pour ce faire je poste l’Id du produit et sa quantité vers la page "Bon de Commande".

  page "Bon de Commande" : Le squelette de cette page permet d’afficher le bon de commande, qui est un récapitulatif des différents produits et de leur quantités associées, leurs prix et par la suite tout calculer.

Le traitement des infos se fait quand à lui dans le fichier php lui même. Pourquoi donc ? J’y viens... Le but est de se servir des boucles de spip pour afficher le bon de commande. Pour ce faire, une boucle du type ferait l’affaire : id_article == ^(12|25|45|3> (Cette boucle affiche les éléments des articles 12, 25,45 et 3.

Or, nous stockons les Id dans une variable de session de php. Mais, ô désespoir, Spip interprète d’abord les boucles et ensuite le php est interprété sur le serveur... Heureusement il y a une contrib expliquant comment utiliser des variables php dans des boucles et c’est son principe que j’applique ici. (En résumé, la variable que vous voulez utiliser dans votre boucle doit être présente dans le tableau $_GET et être appelée par #ENVle nom de la variable

Donc le fichier php Bon de Commande (bdc.php) gère l’ajout du dernier produit, la suppresion d’un produit, la mise à jour d’une quantité. Tout est très bien commenté dedans.

Le fichier squelette quand à lui gère l’affichage et le calculs des différents totaux.

On aurait pu s’arrêter là, mais dans mon cas j’ai rajouté un bouton permettant de vider le bon de commande (toute la session en fait). J’ai rajouté aussi un bouton qui conduit vers une ultime page qui réaffiche le bon de commande en version imprimable puis lance un javascript pour imprimer.

Je l’utilise sur ce site [ http://www.jhpneisson.fr/vin-alsace-blanc.php ]

*soon7
