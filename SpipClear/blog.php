<?php

$forcer_lang = true;

if(!isset($_GET['id_blog'])) $_GET['id_blog'] = 1; //blog: secteur par défaut

if(!isset($_GET['recherche']))
  if(!isset($_GET['id_article']))
    if(!isset($_GET['id_rubrique']))
      if(!isset($_GET['archives']))
        $_GET['id_rubrique'] = $_GET['id_blog'];

$fond = "blog";
$delais = isset($_GET['recherche'])?0:(2 * 3600);


include ("inc-public.php3");

?>
