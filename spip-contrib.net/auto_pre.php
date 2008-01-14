<?php
ob_start();
list($tmp_usec, $tmp_sec) = explode(" ", microtime());
$_GLOBALS["time_start"]=((float)$tmp_usec + (float)$tmp_sec);
?>