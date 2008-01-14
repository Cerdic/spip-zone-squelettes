<?php
list($tmp_usec, $tmp_sec) = explode(" ", microtime());
$_GLOBALS["time_end"]=((float)$tmp_usec + (float)$tmp_sec);

// Used timeticks (in µs)
$dat = @getrusage();
$resu=$dat["ru_utime.tv_sec"]*1e6+$dat["ru_utime.tv_usec"];
// Human-time elapsed (in µs)
$timeu=intval(($_GLOBALS["time_end"]-$_GLOBALS["time_start"])*1e6);

$f=@fopen("/var/alternc/html/s/spip/spip-contrib/perflog.txt","ab");
@flock($f, LOCK_EX);
@fputs($f,date("d/m/Y H:i:s").";"."ella".";".$_SERVER["REQUEST_URI"].";".$timeu.";".$resu.";".@memory_get_usage().";".@ob_get_length()."\n");
@fclose($f);
@flock($f, LOCK_UN);
@ob_flush();
?>