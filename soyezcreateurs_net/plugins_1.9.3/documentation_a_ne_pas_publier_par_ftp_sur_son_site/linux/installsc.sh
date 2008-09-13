#Installation de SPIP
svn checkout svn://trac.rezo.net/spip/branches/spip-2.0.0 ./
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/gribouille
#Si besoin de la mutualisation, decomenter la ligne suivante
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/mutualisation

#Installation des plugins
mkdir plugins
cd plugins
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_1.9.3/plugins/__soyezcreateurs
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acces_restreint
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acronymes
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/agenda/2_0_0 ./agenda/
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/autorite
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/barre_typo_generalisee
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/barre_typo_v2 
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/boutonstexte
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/cfg
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/clevermail/1_9_3 ./clevermail/
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/couteau_suisse
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/crayons
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/enluminures_typographiques_v2
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/fonctions_images
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/forms/forms_et_tables_1_9_3 ./forms_et_tables/
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/Lecteur_multimedia
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/sedna
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/sitemap
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/thickbox2
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/nyroceros
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/spip_2_reloaded
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/woopra
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/notation

cd ..

#Installation du squelette SoyezCreateur : il faut le faire dans un sous dossier
#car sinon, conflit avec le .svn de SPIP
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_1.9.3/ ./__sc/
#Deplacement du squelette au bon endroit
mv ./__sc/htaccess.txt ./.htaccess

#Effacer ses traces
#rm -r ./__sc

#Creer le dossier squelettes au besoin
mkdir squelettes

#mettre les droits idoines pour les dossiers
chmod 777 config
chmod 777 IMG
chmod 777 local
chmod 777 tmp