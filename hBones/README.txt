/* hBones, un projet qui démarre avec Allergie, Izo & Fil */


Le projet est de monter des squelettes au code XHTML minimaliste respectant les principes et mettant en oeuvre les propositions formulées par le site http://microformats.org/

Chacun peut participer, en gardant à l'esprit qu'il s'agit d'y aller très doucement. Chaque ajout, notamment, doit être justifié par les microformats (avec une référence précise aux éléments introduits).


TODO: passer tout ça en mode "noisettes", avec une structure ou chaque noisette correspond à un composant microformat

	article.html
		<INCLURE(article-header.html)>
		<body>
		<INCLURE(article-long.html)>
		</body>

	article-header.html
		<header><title>#TITRE</title>
		<INCLURE(header-mots){id_article}>
		</header>


	article-long.html  (format blog-post)
		#SURTITRE
		#TITRE
		#CHAPO
		<INCLURE(auteurs.html){id_article}>
		#TEXTE
		<INCLURE(mots.html){id_article}>
		<INCLURE(traductions.html){id_article}>


	auteurs.html  (format hCard)
		<BOUCLE(AUTEURS){id_article?}{id_auteur?}>


	mots.html   (format relTag)
		<BOUCLE(AUTEURS){id_article?}{id_breve?}{id_mot?}{id_rubrique?}{id_syndic?}>


etc.

