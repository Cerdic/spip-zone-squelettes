#! /bin/sh
#Installation de SPIP 3.1 beta
svn checkout svn://trac.rezo.net/spip/branches/spip-3.1 ./
#svn checkout svn://trac.rezo.net/spip/spip ./
#sleep 2 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/gribouille
#Si besoin de la mutualisation, decomenter la ligne suivante
#sleep 2 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/mutualisation/trunk ./mutualisation/

#Installation des extensions
cd plugins-dist
mkdir plugins_soyezcreateurs
cd plugins_soyezcreateurs
#sleep 2 && svn checkout https://github.com/Cerdic/video_accessible/trunk ./video_accessible/
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/accessibilite/trunk accessibilite
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/agenda/trunk agenda
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/ancres_douces ancresdouces
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/boutonstexte/trunk boutonstexte
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/calendrier_mini/trunk calendriermini
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/citations_bien_balisees citations_bien_balisees
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/corbeille/trunk corbeille
#sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/couteau_suisse couteau_suisse
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/crayons crayons
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/dictionnaires/trunk dictionnaires
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/facteur/trunk facteur
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/fonctions_images/trunk fonctions_images
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/forms/forms_et_tables_2_5 formsettables
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/fulltext/trunk fulltext
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/inserer_modeles/trunk inserer_modeles
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/mailcrypt mailcrypt
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/memoization/trunk memoization
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/nospam nospam
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/notifications/trunk notifications
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/oembed oembed
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/orthotypo/trunk orthotypo
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/porte_plume_changement_langue/trunk porte_plume_changement_langue
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/porte_plume_partout/trunk porte_plume_partout
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/saisies/trunk saisies
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/savecfg/trunk savecfg
sleep 2 && svn co svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/trunk/plugins/soyezcreateurs soyezcreateurs
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/spip-bonux-3 spip_bonux
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/porte_plume_enluminures_typographiques/trunk porte_plume_enluminures_typographiques
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/typo_guillemets typo_guillemets
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/uploadhtml5/trunk uploadhtml5
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/verifier verifier
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/yaml yaml
cd ../..

#Installation des plugins
mkdir plugins
cd plugins
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/acces_restreint/trunk accesrestreint
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/article_pdf article_pdf
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/autorite/trunk autorite
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/clevermail/trunk clevermail
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/comments/trunk comments
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/contact/trunk contact
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/critere_mots/trunk critere_mots
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/en_travaux/trunk entravaux
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/eva_freemind/eva_freemind_2_0 eva_freemind
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/gis/trunk gis
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/gravatar gravatar
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/image_cliquable/trunk image_cliquable
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/mesfavoris/trunk mesfavoris
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/menu_langues_liens mll
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/notation/trunk notation
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/nuage/trunk nuage
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/palette/trunk palette
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/photospip/trunk photospip
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/player/trunk player
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/querypath/trunk querypath
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/qrcode/trunk qrcode
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/rainette/branches/v2 rainette
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/sedna/trunk sedna
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/sidr sidr
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/skeleditor/trunk skeleditor
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/socialtags socialtags
sleep 2 && svn co svn://zone.spip.org/spip-zone/_plugins_/splickrbox splickr

cd ..

#Création du dossier /lib et se placer dedans
mkdir lib
cd lib
# Pour le plugin Palette 
wget https://files.spip.net/contribs/farbtastic_1_3_1.zip
unzip farbtastic_1_3_1.zip
rm farbtastic_1_3_1.zip
# Pour le plugin PhotoSPIP
wget http://odyniec.net/projects/imgareaselect/jquery.imgareaselect-0.9.10.zip
unzip jquery.imgareaselect-0.9.10.zip
rm jquery.imgareaselect-0.9.10.zip
# Pour le plugin ArticlePDF
wget http://www.fpdf.org/fr/download/fpdf17.zip
unzip fpdf17.zip
rm fpdf17.zip
# Pour CKEditor
#wget http://download.cksource.com/CKEditor/CKEditor/CKEditor%203.6.5/ckeditor_3.6.5.zip
#unzip ckeditor_3.6.5.zip
#rm ckeditor_3.6.5.zip
#wget http://ftp.espci.fr/pub/html2spip/html2spip-0.6.zip
#unzip html2spip-0.6.zip
#rm html2spip-0.6.zip
#wget http://netcologne.dl.sourceforge.net/project/kcfinder/KCFinder/2.51/kcfinder-2.51.zip
#unzip kcfinder-2.51.zip
#rm kcfinder-2.51.zip
#retour à la racine
cd ..

svn export svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/trunk/htaccess.txt ./.htaccess

#Creer le dossier squelettes au besoin
mkdir squelettes

#mettre les droits idoines pour les dossiers
chmod -R 755 config/ IMG/ local/ tmp/ lib/ squelettes/