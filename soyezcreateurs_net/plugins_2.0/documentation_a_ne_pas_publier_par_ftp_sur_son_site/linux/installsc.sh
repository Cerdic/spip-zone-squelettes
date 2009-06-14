#! /bin/sh
#Installation de SPIP
svn checkout svn://trac.rezo.net/spip/branches/spip-2.0 ./
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/gribouille
sleep 15;
#Si besoin de la mutualisation, decomenter la ligne suivante
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/mutualisation
#sleep 15;

#Installation des plugins
mkdir plugins
cd plugins
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_2.0/plugins/__soyezcreateurs
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/acces_restreint
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acronymes
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/agenda/2_0_0 ./agenda/
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/autorite
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/boutonstexte
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/cfg
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/clevermail/1_9_3 ./clevermail/
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/couteau_suisse
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/crayons
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_core_/plugins/porte_plume
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/enluminures_typographiques_v3
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/fonctions_images
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_fondation_/forms_1_9_3_foireux_mais_parfois_utile ./forms/
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/Lecteur_multimedia
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/sedna
sleep 15;
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/thickbox2
svn checkout svn://zone.spip.org/spip-zone/_plugins_/nyroceros
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/spip-bonux-2
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/accessibilite
sleep 15;
svn checkout svn://zone.spip.org/spip-zone/_plugins_/fulltext
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/woopra
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/notation
sleep 15;

cd ..

#Installation du squelette SoyezCreateur : il faut le faire dans un sous dossier
#car sinon, conflit avec le .svn de SPIP
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_2.0/ ./__sc/
#Deplacement du squelette au bon endroit
mv ./__sc/htaccess.txt ./.htaccess

#Effacer ses traces
rm -r -f ./__sc

#Creer le dossier squelettes au besoin
mkdir squelettes

#mettre les droits idoines pour les dossiers
chmod 755 config
chmod 755 IMG
chmod 755 local
chmod 755 tmp