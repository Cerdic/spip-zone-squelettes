<?php
function eva_bonus_tab() {
$retour=array(
array('menu_tout_deplie','sommaire rubrique article breve site auteur','Un menu de navigation enti&egrave;rement d&eacute;pli&eacute;','Olivier Gautier'),
array('menu_depliable_articles','sommaire rubrique article breve site auteur','Un menu de navigation enti&egrave;rement d&eacute;pliable affichant &eacute;galement les articles','Thomas Delhom&eacute;nie'),
array('menu_depliable_horizontal','entete','Un menu de navigation horizontal d&eacute;pliable adapt&eacute; du plugin <a href="http://www.spip-contrib.net/Le-menu-deroulant-Babbibel">Menu d&eacute;roulant Babbibel</a> (&agrave accompagner imp&eacute;rativement des headers accompagnant ce menu : headers_menu_depliable_horiz)','Thomas Delhom&eacute;nie et Olivier Gautier'),
array('menu_depliable_horizontal_articles','entete','Un menu de navigation horizontal d&eacute;pliable affichant &eacute;galement les articles, adapt&eacute; du plugin <a href="http://www.spip-contrib.net/Le-menu-deroulant-Babbibel">Menu d&eacute;roulant Babbibel</a> (&agrave accompagner imp&eacute;rativement des headers accompagnant ce menu : headers_menu_depliable_horiz)','Thomas Delhom&eacute;nie et Olivier Gautier'),
array('headers_menu_depliable_horiz','headers','Headers du menu horizontal d&eacute;pliable adapt&eacute; du plugin <a href="http://www.spip-contrib.net/Le-menu-deroulant-Babbibel">Menu d&eacute;roulant Babbibel</a> ','Thomas Delhom&eacute;nie et Olivier Gautier'),
array('nuage_mot_cle','sommaire','Ajoute un nuage de mots cl&eacute; (plugin nuage indispensable)','Olivier Gautier'),
array('bloc_recherche','sommaire rubrique article breve site auteur','Bloc formulaire de recherche','Olivier Gautier'),
array('eva_topten','sommaire rubrique article breve site auteur','Les dix articles les mieux not&eacute;s (plugin notation indispensable)','Olivier Gautier'),
array('eva_topten_breves','sommaire rubrique article breve site auteur','Les dix br&egrave;ves les mieux not&eacute;es (plugin notation indispensable)','Olivier Gautier'),
array('eva_topten_forums','sommaire rubrique article breve site auteur','Les dix forums les mieux not&eacute;s (plugin notation indispensable)','Olivier Gautier'),
array('boussole','sommaire rubrique article breve site auteur entete pied','Un condens&eacute; des sites de r&eacute;f&eacute;rence de la galaxie SPIP','Jacques Jermer, compl&eacute;t&eacute; et modifi&eacute; par Olivier Gautier'),
array('meteo_actuelle','sommaire rubrique article breve site auteur','Bloc affichant la m&eacute;t&eacute;o en temps r&eacute;el','Olivier Gautier'),
array('meteo_infos','sommaire rubrique article breve site auteur','Bloc affichant les informations g&eacute;ographiques de la commune (longitude et latitude)','Olivier Gautier'),
array('meteo_jour_nuit','sommaire rubrique article breve site auteur','Bloc affichant les pr&eacute;visions m&eacute;t&eacute;o des deux demi-journ&eacute;es du lendemain','Olivier Gautier'),
array('meteo_previsions','sommaire rubrique article breve site auteur','Bloc affichant les pr&eacute;visions m&eacute;t&eacute;o des jours &agrave; venir','Olivier Gautier'),
array('derniers_commentaires','sommaire','Bloc affichant les derniers commentaires du site','David Buffo et Olivier Gautier'),
array('sites_acces_direct','sommaire','Bloc affichant les derniers sites avec un acc&egrave;s direct dans les liens g&eacute;n&eacute;r&eacute;s','Olivier Gautier'),
array('sites_par_num_titre','sommaire','Bloc affichant les derniers sites rang&eacute;s dans l\'ordre de leur num&eacute;ro de nom. Les liens g&eacute;n&eacute;r&eacute;s ouvrent un nouvel onglet (non conforme Xhtml Strict). Seuls les sites poss&eacute;dant un num&eacute;ro seront affich&eacute;s.','Olivier Gautier'),
array('logo_bloc','rubrique article breve site auteur','Bloc affichant les sites partenaires (sites ayant un logo et le mot-cl&eacute; "logo-bloc"). Ce bloc est disponible par d&eacute;faut uniquement pour le sommaire dans EVA. Ici, on peut l\'&eacute;tendre aux autres pages du site.','Olivier Gautier'),

);
return $retour;
}
?>
