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
						'versionner' => true,
						'defaut' => '',// Valeur par défaut
						'rechercher' => true
      ),
	);
  $champs['spip_rubriques']['guide_redaction'] = array(
      'saisie' => 'textarea',//Type du champ (voir plugin Saisies)
      'options' => array(
            'nom' => 'guide_redaction',
						'label' => _T('ressourcotheque:guide_redaction'),
						'conteneur_class'=>'pleine_largeur',
						'explication' => _T('ressourcotheque:guide_redaction_explication'),
            'sql' => "LONGTEXT NOT NULL DEFAULT ''",
						'versionner' => true,
						'defaut' => '',// Valeur par défaut
						'rechercher' => true,
						'traitements' => '_TRAITEMENT_RACCOURCIS',
      ),
	);
  $champs['spip_documents']['source'] = array(
      'saisie' => 'case',//Type du champ (voir plugin Saisies)
      'options' => array(
            'nom' => 'source',
						'label_case' => _T('ressourcotheque:source'),
						'conteneur_class'=>'pleine_largeur',
						'explication' => _T('ressourcotheque:source_explication'),
            'sql' => "varchar(3) DEFAULT '' NOT NULL",
						'versionner' => true,
						'defaut' => '',// Valeur par défaut
      ),
  );
  return $champs;
}
