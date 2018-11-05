<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function ressourcotheque_declarer_champs_extras($champs = array()) {
  $champs['spip_articles']['contenu_documents'] = array(
      'saisie' => 'textarea',//Type du champ (voir plugin Saisies)
      'options' => array(
            'nom' => 'contenu_documents',
						'label' => _T('ressourcotheque:contenu_documents'),
						'conteneur_class'=>'pleine_largeur',
						'explication' => _T('ressourcotheque:contenu_documents_explication'),
            'sql' => "LONGTEXT NOT NULL DEFAULT ''",
						'defaut' => '',// Valeur par défaut
						'rechercher' => true
      ),
  );
  return $champs;
}
