<?php
// +-----------------------------------------------------------------------+
// | Speedzilla - a PHP/Ajax based bandwidth test
// | Copyright (C)2008 E. Haydont - J.P. Fortune speedzilla@speedzilla.net
// |
// | This program is free software: you can redistribute it and/or modify
// | it under the terms of the GNU Affero General Public License as
// | published by the Free Software Foundation, either version 3 of the
// | License, or (at your option) any later version.
// |
// | This program is distributed in the hope that it will be useful,
// | but WITHOUT ANY WARRANTY; without even the implied warranty of
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// | GNU Affero General Public License for more details.
// |
// | You should have received a copy of the GNU Affero General Public License
// | along with this program.  If not, see <http://www.gnu.org/licenses/>.
// +-----------------------------------------------------------------------+

// microtime struct to float convertion
// can be avoided in PHP5 see http://www.php.net/manual/en/function.microtime.php
function m2f($t){
    list($u, $s)=explode(" ",$t);
    return((float)$u+(float)$s);
}

$script = "";
switch($_POST['action']) {
case 'eval':
	$b=microtime();
	echo "<div><!--";
	include("./lo.inc");
	echo "--></div>";
	$e=m2f(microtime());
	$d=$e-m2f($b);
	if($d>=2) { // if more than 2s to download 128K -> low bw
		$script .= "g_hi_lo = 'lo';\n";
		$script .= "g_dwweight = 128;\n";
		$script .= "g_upweight = 32;\n";
	} else {
		$script .= "g_hi_lo = 'hi';\n";
		$script .= "g_dwweight = 512;\n";
		$script .= "g_upweight = 128;\n";
	}
	$script .= "console('ServerID: " . $_SERVER["SERVER_SOFTWARE"] . "');\n";
	$script .= "console('BrowserID: " . $_SERVER["HTTP_USER_AGENT"] . "');\n";
	$script .= "console('ConnectionID: " . $_POST['host'] . " [" . $_POST['ipaddr'] . "]" . "');\n";
	$script .= "console(str_console_preeval+g_dwweight+'K/'+g_upweight+'K');\n";
	$script .= "SpeedZilla ( ". $_POST['ns'] . ");";
	break;
case 'dw':
	// get spec for file size
	$w=$_POST['hilo'];

	// setup the line (auto adapted rwin)
	echo "<div id=\"load\"><div><!--";
	include("./lo.inc");
	echo "--></div>";

	// some random data
	echo md5(rand(time()));

	// we measure the download time of the specified file
	$b=microtime();
	echo "<div><!--";
	include("./".$w.".inc");
	echo "--></div></div>";
	$e=m2f(microtime());
	$d=$e-m2f( $b );

	$script = "g_difftime[g_count] = " . $d . "\n";
	$script .= "g_count--;\n";
	$script .= "console('" . round($d, 4) . " s');\n";
	$script .= "this.document.getElementById('load').innerHTML = '';\n";
	$script .= "SpeedZilla ( " . $_POST['ns'] . ");";
	break;
case 'upstart':
	$w=$_POST['hilo'];
	include("./up".$w.".inc");
	$script = "g_upstart=gettimestamp();\n";
	$script .= "new Ajax.Updater('spdtc', 'do.php', {\n";
	$script .= "	asynchronous: true,\n";
	$script .= "	evalScripts: true,\n";
	$script .= "	postBody: decodeURI(Form.serialize(document.upform))\n});";
	break;
case 'upstop':
	$script = "g_upstop=gettimestamp();\n";
	$script .= "SpeedZilla(3);";
	break;
case 'latency':
	$script = "SpeedZilla ( ". $_POST['ns'] . ");";
	break;
case 'sc':
default:
	break;
}
// output result as js variables
?>
<script language="JavaScript" type="text/javascript">
<?php echo $script; ?>
</script>
