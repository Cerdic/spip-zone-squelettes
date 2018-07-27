#! /bin/sh
#Installation de SPIP 3.2
svn checkout svn://trac.rezo.net/spip/branches/spip-3.2 ./
#svn checkout svn://trac.rezo.net/spip/spip ./
#sleep 2 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/gribouille
#Si besoin de la mutualisation, decomenter la ligne suivante
#sleep 2 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/mutualisation/trunk ./mutualisation/

#Installation des extensions
cd plugins-dist
mkdir _soyezcreateurs_
cd _soyezcreateurs_
svn co svn://zone.spip.org/spip-zone/_plugins_/accessibilite/trunk accessibilite
svn co svn://zone.spip.org/spip-zone/_plugins_/agenda/trunk agenda
svn co svn://zone.spip.org/spip-zone/_plugins_/ancres_douces ancresdouces
svn co svn://zone.spip.org/spip-zone/_plugins_/boutonstexte/trunk boutonstexte
svn co svn://zone.spip.org/spip-zone/_plugins_/calendrier_mini/trunk calendriermini
svn co svn://zone.spip.org/spip-zone/_plugins_/carto_itineraire/trunk carto_itineraire
svn co svn://zone.spip.org/spip-zone/_plugins_/centre_image/trunk centre_images
svn co svn://zone.spip.org/spip-zone/_plugins_/porte_plume_changement_langue/trunk changement_langue
svn co svn://zone.spip.org/spip-zone/_plugins_/citations_bien_balisees citations_bien_balisees
svn co svn://zone.spip.org/spip-zone/_plugins_/corbeille/trunk corbeille
svn co svn://zone.spip.org/spip-zone/_plugins_/crayons/trunk crayons
svn co svn://zone.spip.org/spip-zone/_plugins_/cvt-upload/trunk cvt-upload
svn co svn://zone.spip.org/spip-zone/_plugins_/dictionnaires/trunk dictionnaires
svn co svn://zone.spip.org/spip-zone/_plugins_/emb_pdf/trunk emb_pdf
svn co svn://zone.spip.org/spip-zone/_plugins_/facteur/trunk facteur
svn co svn://zone.spip.org/spip-zone/_plugins_/fonctions_images/trunk fonctions_images
svn co svn://zone.spip.org/spip-zone/_plugins_/fulltext/trunk fulltext
svn co svn://zone.spip.org/spip-zone/_plugins_/ieconfig/trunk ieconfig
svn co svn://zone.spip.org/spip-zone/_plugins_/inserer_modeles/trunk inserer_modeles
svn co svn://zone.spip.org/spip-zone/_plugins_/mailcrypt/trunk mailcrypt
svn co svn://zone.spip.org/spip-zone/_plugins_/memoization/trunk memoization
svn co svn://zone.spip.org/spip-zone/_plugins_/nemequittepas nemequittepas
svn co svn://zone.spip.org/spip-zone/_plugins_/n-core/trunk n-core
svn co svn://zone.spip.org/spip-zone/_plugins_/noizetier/trunk noizetier
svn co svn://zone.spip.org/spip-zone/_plugins_/nospam nospam
svn co svn://zone.spip.org/spip-zone/_plugins_/notifications/trunk notifications
svn co svn://zone.spip.org/spip-zone/_plugins_/oembed oembed
svn co svn://zone.spip.org/spip-zone/_plugins_/orthotypo/trunk orthotypo
svn co svn://zone.spip.org/spip-zone/_plugins_/palette/trunk palette
svn co svn://zone.spip.org/spip-zone/_plugins_/porte_plume_partout/trunk porteplumepartout
svn co svn://zone.spip.org/spip-zone/_plugins_/saisies/trunk saisies
svn co svn://zone.spip.org/spip-zone/_plugins_/savecfg/trunk savecfg
svn co svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/trunk/plugins/soyezcreateurs soyezcreateurs
svn co svn://zone.spip.org/spip-zone/_plugins_/spip-bonux-3 spip_bonux
svn co svn://zone.spip.org/spip-zone/_plugins_/typo_guillemets typo_guillemets
svn co svn://zone.spip.org/spip-zone/_plugins_/porte_plume_enluminures_typographiques/trunk typoenluminee
svn co svn://zone.spip.org/spip-zone/_plugins_/uploadhtml5/trunk uploadhtml5
svn co svn://zone.spip.org/spip-zone/_plugins_/verifier verifier
svn co svn://zone.spip.org/spip-zone/_plugins_/yaml/trunk yaml
cd ../..

#Installation des plugins
mkdir plugins
cd plugins
svn co svn://zone.spip.org/spip-zone/_plugins_/acces_restreint/trunk accesrestreint
svn co svn://zone.spip.org/spip-zone/_plugins_/apropos/trunk apropos
svn co svn://zone.spip.org/spip-zone/_plugins_/article_pdf article_pdf
svn co svn://zone.spip.org/spip-zone/_plugins_/autolang/trunk autolang
svn co svn://zone.spip.org/spip-zone/_plugins_/autorite/trunk autorite
svn co https://github.com/nursit/bank/tags/v3.5.9 bank
svn co svn://zone.spip.org/spip-zone/_plugins_/blocsdepliables blocsdepliables
svn co svn://zone.spip.org/spip-zone/_plugins_/breves_vers_articles breves_vers_articles
svn co svn://zone.spip.org/spip-zone/_plugins_/campagnes/trunk campagnes
svn co svn://zone.spip.org/spip-zone/_plugins_/champs_extras_core/trunk champs_extras_core
svn co svn://zone.spip.org/spip-zone/_plugins_/champs_extras_interface/trunk champs_extras_interface
svn co svn://zone.spip.org/spip-zone/_plugins_/clevermail/trunk clevermail
svn co svn://zone.spip.org/spip-zone/_plugins_/comments/trunk comments
svn co svn://zone.spip.org/spip-zone/_plugins_/contact/trunk contact
svn co svn://zone.spip.org/spip-zone/_plugins_/critere_mots/trunk critere_mots
svn co svn://zone.spip.org/spip-zone/_plugins_/date_modif_manuelle/trunk date_modif_manuelle
svn co svn://zone.spip.org/spip-zone/_plugins_/duplicator/trunk duplicator
svn co svn://zone.spip.org/spip-zone/_plugins_/en_travaux/trunk entravaux
svn co svn://zone.spip.org/spip-zone/_plugins_/eva_freemind/eva_freemind_2_0 eva_freemind
svn co svn://zone.spip.org/spip-zone/_plugins_/formidable/trunk formidable
svn co svn://zone.spip.org/spip-zone/_plugins_/frimousses frimousses
svn co svn://zone.spip.org/spip-zone/_plugins_/fusion_spip/trunk fusion_spip
svn co svn://zone.spip.org/spip-zone/_plugins_/gis/trunk gis
svn co svn://zone.spip.org/spip-zone/_plugins_/gis_geometries/trunk gis_geometries
svn co svn://zone.spip.org/spip-zone/_plugins_/gravatar gravatar
svn co svn://zone.spip.org/spip-zone/_core_/branches/spip-3.2/plugins/grenier grenier
svn co svn://zone.spip.org/spip-zone/_plugins_/hash_documents/trunk hash_documents
svn co svn://zone.spip.org/spip-zone/_plugins_/image_cliquable/trunk image_cliquable
svn co svn://zone.spip.org/spip-zone/_plugins_/jeux/trunk jeux
svn co svn://zone.spip.org/spip-zone/_plugins_/joomla2spip/trunk joomla2spip
svn co svn://zone.spip.org/spip-zone/_plugins_/less-css/trunk less-css
svn co svn://zone.spip.org/spip-zone/_plugins_/linkcheck/trunk linkcheck
svn co svn://zone.spip.org/spip-zone/_plugins_/mailshot/trunk mailshot
svn co svn://zone.spip.org/spip-zone/_plugins_/mailsubscribers/trunk mailsubscribers
svn co svn://zone.spip.org/spip-zone/_plugins_/mesfavoris/trunk mesfavoris
svn co https://github.com/nursit/Migration/tags/v1.0.1 migration
svn co svn://zone.spip.org/spip-zone/_plugins_/menu_langues_liens mll
svn co svn://zone.spip.org/spip-zone/_plugins_/multilang/trunk multilang
svn co svn://zone.spip.org/spip-zone/_plugins_/navigation_bar_cef/trunk navigation_bar_cef
svn co svn://zone.spip.org/spip-zone/_plugins_/newsletters/trunk newsletters
svn co svn://zone.spip.org/spip-zone/_plugins_/nivoslider/trunk nivoslider
svn co svn://zone.spip.org/spip-zone/_plugins_/notation/trunk notation
svn co svn://zone.spip.org/spip-zone/_plugins_/nuage/trunk nuage
svn co svn://zone.spip.org/spip-zone/_plugins_/odt2spip/trunk odt2spip
svn co svn://zone.spip.org/spip-zone/_plugins_/partageur/trunk partageur
svn co svn://zone.spip.org/spip-zone/_plugins_/pdf_version/trunk pdf_version
svn co svn://zone.spip.org/spip-zone/_plugins_/photospip/trunk photospip
svn co svn://zone.spip.org/spip-zone/_plugins_/player/trunk player
svn co svn://zone.spip.org/spip-zone/_plugins_/prive_fluide/trunk prive_fluide
svn co svn://zone.spip.org/spip-zone/_plugins_/qrcode/trunk qrcode
svn co svn://zone.spip.org/spip-zone/_plugins_/querypath/trunk querypath
svn co svn://zone.spip.org/spip-zone/_plugins_/rainette/trunk rainette
svn co svn://zone.spip.org/spip-zone/_plugins_/rechremp/trunk rechercher_remplacer
svn co svn://zone.spip.org/spip-zone/_plugins_/sedna/trunk sedna
svn co svn://zone.spip.org/spip-zone/_plugins_/sidr sidr
svn co svn://zone.spip.org/spip-zone/_plugins_/skeleditor/trunk skeleditor
svn co svn://zone.spip.org/spip-zone/_plugins_/slick/trunk slick
svn co svn://zone.spip.org/spip-zone/_plugins_/smush_images/trunk smush_images
svn co svn://zone.spip.org/spip-zone/_plugins_/socialtags socialtags
svn co svn://zone.spip.org/spip-zone/_plugins_/spip-bible/trunk spip-bible
svn co svn://zone.spip.org/spip-zone/_plugins_/spip_hop/trunk spip_hop
svn co svn://zone.spip.org/spip-zone/_plugins_/spipdf/trunk spipdf
svn co svn://zone.spip.org/spip-zone/_plugins_/spiperipsum spiperipsum
svn co svn://zone.spip.org/spip-zone/_plugins_/splickrbox splickr
svn co svn://zone.spip.org/spip-zone/_plugins_/svp_stats/trunk svp_stats
svn co svn://zone.spip.org/spip-zone/_plugins_/thumbsites/trunk thumbsites
svn co svn://zone.spip.org/spip-zone/_plugins_/transaction transaction
svn co svn://zone.spip.org/spip-zone/_plugins_/twitter/trunk twitter
svn co svn://zone.spip.org/spip-zone/_dev_/univers_spip univers_spip
svn co svn://zone.spip.org/spip-zone/_plugins_/verifier_plugins/trunk verifier_plugins
svn co svn://zone.spip.org/spip-zone/_plugins_/webfonts/trunk webfonts

cd ..

#Création du dossier /lib et se placer dedans
mkdir lib
cd lib
# Pour le plugin PhotoSPIP
wget http://odyniec.net/projects/imgareaselect/jquery.imgareaselect-0.9.10.zip
unzip jquery.imgareaselect-0.9.10.zip
rm jquery.imgareaselect-0.9.10.zip
# Pour le plugin ArticlePDF
wget http://www.fpdf.org/fr/download/fpdf17.zip
unzip fpdf17.zip
rm fpdf17.zip
# Pour le plugin ArticlePDF
wget https://github.com/mpdf/mpdf/archive/v6.0.0.zip
unzip v6.0.0.zip -d mpdf
rm v6.0.0.zip
# Pour le plugin ArticlePDF
wget https://github.com/phayes/geoPHP/archive/1.2.zip
unzip 1.2.zip
rm 1.2.zip
#retour à la racine
cd ..


svn export svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/trunk/htaccess.txt ./.htaccess

#Creer le dossier squelettes au besoin
mkdir squelettes

#mettre les droits idoines pour les dossiers
chmod -R 755 config/ IMG/ local/ tmp/ lib/ squelettes/