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
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/acronymes
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/agenda/2_0_0 ./agenda/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/bandeau
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/boutonstexte
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/cfg
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/couteau_suisse
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/crayons
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/fonctions_images
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/forms/forms_et_tables_2_0 ./forms/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/fulltext
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/job_queue
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/mediabox
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/mediatheque
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/noie
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/nospam
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/notifications
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/porte_plume_extras/enluminures_typographiques_v3
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/porte_plume_extras/partout
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/previsu_redaction
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/protection_formulaires
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/saisies
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/savecfg
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/spip-bonux-2
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_2.1/plugins/soyezcreateurs
cd ../..

#Installation des plugins
mkdir plugins
cd plugins
#sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/woopra
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/accessibilite
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/acces_restreint
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/authentification/openid
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/autorite
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/clevermail/2_0 ./clevermail/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/comments/comments-200/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/contact
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/critere_mots
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/eva_freemind/eva_freemind_2_0
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/facteur
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/gis
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/googlemap_api
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/gravatar
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/insertion_modele
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/Lecteur_multimedia
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/memoization
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/menu_langues_liens
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/microblog
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/notation
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/rainette
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/sedna
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/socialtags
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/spip2pdf
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/splickrbox
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/twidget
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