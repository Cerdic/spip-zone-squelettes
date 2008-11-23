<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

// determine client IP address
if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
  $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
  if ($_SERVER["HTTP_CLIENT_IP"]) {
    $ip = $_SERVER["HTTP_CLIENT_IP"];
  } else {
    $ip = $_SERVER["REMOTE_ADDR"];
  }
}
$host=gethostbyaddr($ip);
if($host==$ip)
	$host="Unknown";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $lang['homepage_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="css/spdz.css" />
    <link rel="stylesheet" type="text/css" href="css/custom.css" />
<?php
$lg = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
if(file_exists($lg . ".php"))
	require_once($lg . ".php");
else
	require_once('en.php');
?>
	<script language="JavaScript" type="text/javascript" src="js/prototype.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/spdz.js"></script>
	<script language="JavaScript" type="text/javascript">
	window.onload = function() {
		SpeedZilla(0, null);
	}
	</script>
</head>
<body>
	<div id="spdtc" style="display:none;"></div>
	<div id="center">
		<div id="resw">
			<div id="connection"><?php echo $lang['YourConnection'] . $host . " [" . $ip . "]"?></div>
			<div id="status">&nbsp;<?php echo $lang['InitialStatus']; ?></div>
			<div class="bargraph">
				<div class="bargraphtitle" id="dwtitle"><?php echo $lang['Download']; ?></div>
				<div class="barcontainer"><div class="cal">&nbsp;</div><div id="dwbar"></div><div id="dwtext"><strong>&nbsp;</strong></div></div>
			</div>
			<div class="clr"></div>
			<div id="scale">
				<div class="step" style="width:15.488%"><span class="label">56k&nbsp;</span></div>
				<div class="step" style="width:5.556%"><span class="label">100k&nbsp;</span></div>
				<div class="step" style="width:15.152%"><span class="label">512k&nbsp;</span></div>
				<div class="step" style="width:6.566%"><span class="label">1m&nbsp;</span></div>
				<div class="step" style="width:21.886%"><span class="label">10m&nbsp;</span></div>
				<div class="step" style="width:21.886%"><span class="label">100m&nbsp;</span></div>
				<div class="stepn" style="width:10%"><span class="label">log&nbsp;</span></div>
			</div>
			<div class="clr"></div>
			<div class="bargraph">
				<div class="bargraphtitle" id="uptitle"><?php echo $lang['Upload']; ?></div>
				<div class="barcontainer"><div class="cal">&nbsp;</div><div id="upbar"></div><div id="uptext"><strong>&nbsp;</strong></div></div>
			</div>
			<div class="clr"></div>
			<div id="bottomblock">
				<div style="float:left;">
					<textarea id="console" rows="7" cols="45" readonly="readonly"></textarea>
					<div class="copyspeed">
						<a href="http://www.speedzilla.net/" target="_blank"><img id="imgcopy" src="img/copyspeed.png" alt="<?php echo $lang['Copyright']?>" border="none" /></a>
					</div>
				</div>
				<div id="right">
					<div id="results"></div>
					<button id="stb" onclick="SpeedZilla(0);return false;" style="display:none;"><?php echo $lang['RestartButton']; ?></button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>