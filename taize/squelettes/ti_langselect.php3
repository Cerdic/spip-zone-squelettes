<?php
$fond = 'ti_langselect';
$delais = 24 * 3600;
if (isset($_GET['id_document'])) {
	$contexte_inclus['id_document']=$_GET['id_document'];
}
include 'inc-public.php3';
?>