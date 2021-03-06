#! /bin/sh
#Installation de SPIP
svn checkout svn://trac.rezo.net/spip/branches/spip-2.0 ./
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/gribouille
#Si besoin de la mutualisation, decomenter la ligne suivante
#sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/mutualisation

#Installation des plugins
mkdir plugins
cd plugins
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_2.0/plugins/__soyezcreateurs
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/acces_restreint
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/acronymes
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/agenda/2_0_0 ./agenda/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/autorite
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/boutonstexte
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/cfg
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/saisies
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/facteur
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/clevermail/2_0 ./clevermail/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/couteau_suisse
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/crayons
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_core_/plugins/porte_plume
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/porte_plume_extras/enluminures_typographiques_v3
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/fonctions_images
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/forms/forms_et_tables_2_0 ./forms/
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/Lecteur_multimedia
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/sedna
#sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/thickbox2
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/nyroceros
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/spip-bonux-2
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/accessibilite
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/fulltext
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/savecfg
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/gestion_documents
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/contact
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/protection_formulaires
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/critere_mots
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/porte_plume_extras/partout
#sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/woopra
#sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_plugins_/notation

cd ..

#Installation du squelette SoyezCreateur : il faut le faire dans un sous dossier
#car sinon, conflit avec le .svn de SPIP
sleep 15 && svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_2.0/ ./__sc/
#Deplacement du squelette au bon endroit
mv ./__sc/htaccess.txt ./.htaccess

#Effacer ses traces
rm -r -f ./__sc

#Creer le dossier squelettes au besoin
mkdir squelettes

#mettre les droits idoines pour les dossiers
chmod 755 config/ IMG/ local/ tmp/