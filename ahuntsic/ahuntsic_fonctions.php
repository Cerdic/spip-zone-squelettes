<?php

// ===============================
// Balise : #VERSION_SPIP_AFFICHEE
// ===============================
// Balise pour afficher la version de SPIP en cours sur votre site
// Contrib de Scoty : http://www.koakidi.com/
// voir : https://contrib.spip.net/Collection-de-Balises
function balise_VERSION_SPIP_AFFICHEE($p)
{
    $p->code = "'".$GLOBALS['spip_version_affichee']."'";
    $p->statut = 'php';

    return $p;
}

// ==============================
// Balise : #VERSION_SQUELETTE
// ==============================
// Auteur: SarkASmeL
// Fonction : affiche la version utilise du squelette variable globale $version_squelette
// ==============================
function balise_VERSION_SQUELETTE($p)
{
    $p->code = 'calcul_version_squelette()';
    $p->interdire_scripts = false;

    return $p;
}

function calcul_version_squelette()
{
    $version = null;

    if (lire_fichier(_DIR_PLUGIN_AHUNTSIC.'/plugin.xml', $contenu)
    && preg_match('/<version>(.*?)<\/version>/', $contenu, $match)) {
        $version .= trim($match[1]);
    }

    $revision = version_svn_courante(_DIR_PLUGIN_AHUNTSIC);
    if ($revision > 0) {
        $version .= ' ['.strval($revision).']';
    } elseif ($revision < 0) {
        $version .= ' ['.strval(abs($revision)).'&nbsp;<strong>svn</strong>]';
    }

    return $version;
}

function affvisit()
{
    $query = 'SELECT SUM(visites) AS total_absolu FROM spip_visites';
    $result = spip_query($query);
    $visites_today = 0;

    if ($row = spip_fetch_array($result)) {
        $total_absolu = $row['total_absolu'];
    }

    $query = 'SELECT visites FROM spip_visites WHERE date=NOW()';
    $result = spip_query($query);

    if ($row = @spip_fetch_array($result)) {
        $visites_today = $row['visites'];
    }

    $total_gen = $total_absolu + $visites_today;

    return $total_gen;
}
