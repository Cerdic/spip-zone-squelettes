#! /bin/sh
#Installation de SPIP
svn checkout svn://trac.rezo.net/spip/branches/spip-2.1 ./
#sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/gribouille
#Si besoin de la mutualisation, decomenter la ligne suivante
#sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/mutualisation

#Installation des extensions
cd extensions
mkdir plugins_soyezcreateurs
cd plugins_soyezcreateurs
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/accessibilite
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/agenda/2_0_0 ./agenda/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/bandeau
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/boutonstexte/branches/v1 ./boutonstexte/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/cfg
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/porte_plume_extras/changement_langue
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/couteau_suisse
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/crayons
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/dictionnaires/branches/v0 ./dictionnaires/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/facteur/branches/v1 ./facteur/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/fonctions_images
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/forms/forms_et_tables_2_0 ./forms/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/forum
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/fulltext
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/job_queue
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/Lecteur_multimedia
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/mediabox
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/mediatheque
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/noie
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/nospam
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/notifications
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/porte_plume_extras/changement_langue
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/porte_plume_extras/enluminures_typographiques_v3
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/porte_plume_extras/partout
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/previsu_redaction
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/protection_formulaires
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/saisies
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/savecfg
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/spip-bonux-2
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_2.1/plugins/soyezcreateurs
sleep 15 && svn checkout http://svn.github.com/Cerdic/video_accessible.git ./video_accessible/
cd ../..

#Installation des plugins
mkdir plugins
cd plugins
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/acces_restreint/branches/v3 ./access_restreint/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/afficher_objets
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/article_pdf
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/autorite
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/clevermail/branches/2.0.0 ./clevermail/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/comments/comments-200/ ./comments/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/contact/branches/v0_7 ./contact/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/contacts_et_organisations/branches/v1 ./contacts_et_organisations/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/coordonnees/branches/v1.4 ./coordonnees/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/critere_mots/branches/1.2.3 ./critere_mots
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/eva_freemind/eva_freemind_2_0
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/formidable/branches/v0
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/gis/branches/v2 ./gis/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/gravatar
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/inserer_modeles/branches/v_0 ./insertion_modele
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/jquery_ui
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/player/branches/lm_v1 ./lecteur_multimedia/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/memoization
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/menu_langues_liens
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/microblog
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/notation/branches/v_0_9 ./notation
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/nuage/trunk ./nuage/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/odt2spip/version_0.1_stable ./odt2spip/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/pays/branches/v1.0 ./pays/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/rainette
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/sedna
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/skeleditor/skeleditor-2 ./skeleditor/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/socialtags
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/spip2pdf
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/splickrbox
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/twidget
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/verifier
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/yaml
cd ..

#Installation du squelette SoyezCreateur : il faut le faire dans un sous dossier
#car sinon, conflit avec le .svn de SPIP
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_2.1/ ./__sc/
#Deplacement du squelette au bon endroit
mv ./__sc/htaccess.txt ./.htaccess

#Effacer ses traces
rm -r -f ./__sc

#Creer le dossier squelettes au besoin
mkdir squelettes

#mettre les droits idoines pour les dossiers
chmod 755 config/ IMG/ local/ tmp/