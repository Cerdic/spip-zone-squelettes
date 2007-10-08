#Installation de SPIP
svn checkout svn://trac.rezo.net/spip/spip/ ./
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/gribouille

#Installation des plugins
mkdir plugins
cd plugins
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_dev_/compat193
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acces_restreint
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/acronymes
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/agenda/1_9_3 ./agenda/
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/balise_session
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/barre_typo_v2 
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/enluminures_typographiques_v2
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/boutonstexte
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/gestion_documents
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/recherche_etendue
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/sitemap
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/typo_exposants
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/typo_guillemets
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/w3c_go_home
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/widget_calendar
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/cfg
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/forms/forms_et_tables_1_9_1
#svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/thickbox
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_test_/sedna
svn checkout svn://zone.spip.org/spip-zone/_plugins_/_stable_/crayons


cd ..

#Installation du squelette SoyezCreateur : il faut le faire dans un sous dossier
#car sinon, conflit avec le .svn de SPIP
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_1.9.2/ ./__sc/
#Deplacement du squelette au bon endroit
mv ./__sc/htaccess.txt ./.htaccess
mv ./__sc/plugins/_soyezcreateurs ./plugins/_soyezcreateurs
svn checkout svn://zone.spip.org/spip-zone/_squelettes_/soyezcreateurs_net/plugins_1.9.3/ ./__sc193/
mv ./__sc193/plugins/__soyezcreateurs ./plugins/__soyezcreateurs

#Effacer ses traces
#rm -r ./__sc

#Creer le dossier squelettes au besoin
mkdir squelettes

#mettre les droits idoines pour les dossiers
chmod 777 config
chmod 777 IMG
chmod 777 local
chmod 777 tmp