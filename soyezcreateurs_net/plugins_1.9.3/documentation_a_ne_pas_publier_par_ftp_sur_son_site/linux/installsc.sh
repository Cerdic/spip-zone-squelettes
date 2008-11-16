#! /bin/sh
#Installation de SPIP
svn checkout svn://trac.rezo.net/spip/branches/spip-2.0.0 ./
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/gribouille
sleep 1;
#Si besoin de la mutualisation, decomenter la ligne suivante
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/mutualisation
#sleep 1;

#Installation des plugins
mkdir plugins
cd plugins
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_1.9.3/plugins/__soyezcreateurs
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acces_restreint
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acronymes
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/agenda/2_0_0 ./agenda/
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/autorite
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/barre_typo_generalisee
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/barre_typo_v2 
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/boutonstexte
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/cfg
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/clevermail/1_9_3 ./clevermail/
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/couteau_suisse
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/crayons
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/enluminures_typographiques_v2
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/fonctions_images
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/forms/forms_et_tables_1_9_3 ./forms_et_tables/
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/Lecteur_multimedia
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/sedna
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/sitemap
sleep 1;
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/thickbox2
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/nyroceros
sleep 1;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/spip-bonux-2
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/woopra
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/notation
sleep 1;

cd ..

#Installation du squelette SoyezCreateur : il faut le faire dans un sous dossier
#car sinon, conflit avec le .svn de SPIP
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_1.9.3/ ./__sc/
sleep 1;
#Deplacement du squelette au bon endroit
mv ./__sc/htaccess.txt ./.htaccess

#Effacer ses traces
#rm -r ./__sc

#Creer le dossier squelettes au besoin
mkdir squelettes

#mettre les droits idoines pour les dossiers
chmod 755 config
chmod 755 IMG
chmod 755 local
chmod 755 tmp