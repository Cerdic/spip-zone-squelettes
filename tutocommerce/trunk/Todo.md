# Plugin TutoCommerce : à faire

> Liste de choses à faire, notes et idées diverses, sans version particulière ciblée.

- Produits : se baser sur le plugin [Produits](https://git.spip.net/spip-contrib-extensions/tunnels) au lieu de la table maison `spip_produits_demos`.
- Ajouter une étape « choix des adresses » ? À voir.
- peetdu : dans demo/inc-preambule.html, vérifier que c'est bien le presta activé qui est en mode TEST
- Mentionner le plugin commandes d'abonnements.
- Se baser sur le plugin [Tunnels](https://git.spip.net/spip-contrib-extensions/tunnels) et proposer plusieurs tunnels : produits, abonnement, avec ou sans livraison, etc.
- Expliquer les possibilités concernant la connexion :
  - Soit on utilise l'action commande_paniers et il faut être déjà connecté
  - Soit on utilise l'action commande_paniers_if_loged et il faut être connecté à l'épate suivante
  - Soit on permet de passer commande sans être connecté (possible ? à vérifier)
- Utiliser un script de « tour » :
  - [Sepherd](https://github.com/shipshapecode/shepherd)
  - [aSimpleTour](https://github.com/alvaroveliz/aSimpleTour)
- Utiliser un framework chargé depuis un CDN pour la présentation (bootstrap, semanticui, peu importe)
