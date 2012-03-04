<?php
/* 
   Start Page Thingie version 1.21 - Andreas Haugstrup Pedersen <andreas@solitude.dk> April 2nd, 2003
   The newest version of File Thingie can be found at <http://www.solitude.dk/>
   Comments, suggestions etc. are welcome and encouraged at the above e-mail.
   
   LICENSE INFORMATION:
   This work is licensed under the Creative Commons Attribution-NonCommercial-ShareAlike License.
   To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/1.0/
   If you want to use File Thingie for a commercial work please contact me at <andreas@solitude.dk>
   
   KNOWN ISSUES IN THIS VERSION:
   The MIME-type check is not working as well as I would have liked. It appears that the MIME-type is always 
   linked to the file ending. Ie. if you have a PNG image and you rename it to image.txt it will also get the MIME-type of text/plain. This means you should be extra careful as to which file endings you allow for upload as the MIME-type never can be trusted.
   The script does check for allowed file endings on renaming a file so it is not possible to upload evilhackerscript.txt, rename it to evilhackscript.php and then blast everything into bits.

   On my webhost I do not get an error message if I try to upload a file that is too large. The file is not uploaded, but no error is displayed either. It works fine on PHP 4.2 at home (my host has PHP 4.1.2).

   TODO list:
   - Make lock/unlock feature so important files can't be deleted on accident.
   - Fix MIME check with the mime.magic extension
   - Make language customization easy.
   - Create new file.
   - Upload url.
   - Multiple file upload.
   - Possibility for adding (company) logo.

   Changelog for version 1.21:
   - Fixed HTML typo. Thanks to Chris from somewhere out there.

   Changelog for version 1.2:
   - Fixed issue with renaming php files.
   - Added comments to the stylesheet to make customization easier.
   - Added text/xml to the list of allowed files.
   - Added feature for moving files.
   - Show Source function disabled for PHP versions lower than 4.2.0 because it doesn't work properly.
   - <link> elements added for additional navigation.
   - CSS customization made easier with the "Colours and fonts" section.
   - Help file included.

   Changelog for version 1.1:
   - Fixed error message when trying to view source for files that don't exists.
   - Fixed infinite loop when trying to log out. Thanks to Milos from the Czech Republic.
   - New feature: Edit txt, html and php files.
   - Optimizations of the php code.
*/
session_start();

/* Setup information. Change as appropriate */

header ("Content-type: text/html; charset=ISO-8859-1"); /* Your character set. You probably don't have to change this. */
$username = "geranium";										/* The username. Case sensitive. */
$password = "g3r4n1um";										/* The password. Case sensitive */
$dir = ".";											/* The subdir name. This file has to be located 
															   one step above this. Don't start with a slash */
$maxsize = 2100000;											/* Maximum upload size in bytes */
$showphp = true;											/* Decides whether it should be allowed to show 
															   source on PHP files. Can have the values TRUE 
															   or FALSE. Set to FALSE by default for security 
															   reasons. */
$edithtml = TRUE;											/* Decides if HTML/CSS files can be edited. TRUE
															   on deafult. */
$edittxt = TRUE;											/* Decides if text files can be edited. TRUE on deafult. */
$editphp = true;											/* Decides if PHP files can be edited. FALSE on deafult. */
$converttabs = TRUE;										/* Decides if tabs should be converted into spaces 
															   when a file is opened for edit. TRUE on deafult. */
$phpendings = array("php", "php3", "php4", "phtml");		/* List of PHP file endings. Used for security when 
															   editing and showing source. */

/* List of allowed file endings and their MIME-types. Both file ending and MIME-type has to match before the file is allowed for upload. */
$allowedfile["jpg"] = "image/jpeg";							/* JPEG image file (.jpg) */
$allowedfile["jpeg"] = "image/jpeg";						/* JPEG image file (.jpeg) */
$allowedfile["jpe"] = "image/jpeg";							/* JPEG image file (.jpe) */
$allowedfile["gif"] = "image/gif";							/* GIF image file */
$allowedfile["png"] = "image/png";							/* PNG image file */
$allowedfile["tif"] = "image/tif";							/* TIFF image file (.tif) */
$allowedfile["tiff"] = "image/tiff";						/* TIFF image file (.tiff) */
$allowedfile["html"] = "text/html";							/* HTML file (.html) */
$allowedfile["htm"] = "text/html";							/* HTML file (.htm) */
$allowedfile["css"] = "text/css";							/* CSS file (.css) */
$allowedfile["xml"] = "text/xml";							/* XML file (.xml) */
$allowedfile["txt"] = "text/plain";							/* Regular text file */
$allowedfile["doc"] = "application/msword";					/* MS Word document */
$allowedfile["rtf"] = "application/rtf";					/* RTF document */
$allowedfile["pdf"] = "application/pdf";					/* PDF document */
$allowedfile["pot"] = "application/mspowerpoint";			/* MS PowerPoint document (.pot) */
$allowedfile["pps"] = "application/mspowerpoint";			/* MS PowerPoint document (.pps) */
$allowedfile["ppt"] = "application/mspowerpoint";			/* MS PowerPoint document (.ppt) */
$allowedfile["ppz"] = "application/mspowerpoint";			/* MS PowerPoint document (.ppz) */
$allowedfile["xls"] = "application/x-excel";				/* MS Excel document */
$allowedfile["php"] = "application/octet-stream";			/* PHP file. Turned off per default for security reasons */
$allowedfile["php3"] = "application/octet-stream";		/* PHP3 file. Turned off per default for security reasons */
$allowedfile["py"] = "application/octet-stream";		/* Python file. Turned off per default for security reasons */

/* End setup information */

/* Start colours and fonts */

$CSS_fontSize = "12px";										/* The normal font size */
$CSS_fontFamily = "Verdana, \"Arial Narrow\", sans-serif";	/* Normal font */
$CSS_bg = "#fff";											/* Page background */
$CSS_fontColour = "#000";									/* Normal font colour */
$CSS_smallText = "10px";									/* Font size for small text */
$CSS_linkColour = "#039";									/* Links for filenames */
$CSS_linkHover = "#9cc";									/* Background colour on link hover */
$CSS_errorColour = "#f00";									/* The colour of error messages */
$CSS_okayColour = "#393";									/* The colour of okay messages */
$CSS_tableHeaderBg = "#039";								/* Background colour for the table header */
$CSS_tableHeaderColour = "#fff";							/* Font colour for the table header */
$CSS_tableHeaderSize = "14px";								/* Font size for the table header */
$CSS_tableBg = "#fff";										/* Normal background for the file list */
$CSS_tableBgAlt = "#ddd";									/* Alternative background for the file list */
$CSS_menuColour = "#000";									/* Font colour for the menu */
$CSS_menuBg = "#9cc";										/* Background colour for the menu */
$CSS_menuHoverBg = "#cff";									/* Background colour for the menu on hover */

/* End colours and fonts */

function getExt ($name) {
	// This function returns the file ending without the "."
	if (strstr($name, ".")) {
		$ext = str_replace(".", "", strrchr($name, "."));
	} else {
		$ext = "";
	}
	return $ext;
}
function checkFileType ($type, $ext) {
	// This function checks whether the type and file ending is in the list of allowed files.
	global $allowedfile, $_FILES;
	foreach ($allowedfile as $currentext => $currenttype) {
		if ($ext == strtolower($currentext) && $type == strtolower($currenttype)) {
			return TRUE;
			break;
		}
	}
}
function outputAcceptedFiles($allowedfile) {
	// This function returns a comma-seperated list of allowed file types for use in the HTML form.
	$allowedfile = array_unique($allowedfile);
	foreach ($allowedfile as $mimetype) {
		$formaccept = "{$formaccept}, {$mimetype}";
	}
	$formaccept = substr($formaccept, 2);
	return $formaccept;
}
function xhtml_highlight($file) {
	// This function changes the highlight_string() to be xhtml compliant.
	if (version_compare(phpversion(), "4.2.0") == "-1") {
//		$string = implode ("", file($file));
//		$string = highlight_string($string);
		$string = "<p class=\"error\">Error: Your PHP version is <strong>".phpversion()."</strong>. You need at least version 4.2.0 for the Show Source function to work.</p>";
	} else {
		$string = highlight_file($file, TRUE);
	}
	// Fix lines
	$string = str_replace("<br />", "\n", $string);
	// Fix spaces and tabs
	$string = str_replace("&nbsp;&nbsp;&nbsp;&nbsp;", "\t", $string);
	$string = str_replace("&nbsp;", " ", $string);
	// Fix <font>-tags
	$string = str_replace("</font>", "</span>", $string);
	$string = str_replace("<font color=\"", "<span style=\"color:", $string);
	return $string;
}
function checkForEdit($ext) {
	// This functions checks a file ending when editing files.
	global $edittxt, $edithtml, $editphp, $phpendings;
	if ($edittxt == TRUE && $ext == "txt") {
		return 1;
	} elseif ($edithtml == TRUE && ($ext == "html" || $ext == "htm" || $ext == "css")) {
		return 1;
	} elseif ($editphp == TRUE && in_array($ext, $phpendings)) {
		return 1;
	} else {
		return 0;
	}
}
function checkForSource($ext) {
	// This functions checks a file ending when showing the source of files.
	global $showphp, $phpendings;
	if ($showphp == TRUE && in_array($ext, $phpendings)) {
		return 1;
	} elseif ($ext == "htm") {
		return 1;
	} elseif ($ext == "html") {
		return 1;
	}
}
function buildMenu($self, $uplink, $reloadlink, $helplink) {
	// This functions outputs the menu.
	global $subdir;
	if (IsSet($subdir)) {
		$uplink = "<li><a href=\"{$self}{$uplink}\">Up &uArr;</a></li>";
	} else {
		$uplink = "";
	}
	echo "<ul id=\"menu\">
		{$uplink}
		<li><a href=\"{$self}\">Home</a></li>
		<li><a href=\"{$self}{$reloadlink}\">Reload</a></li>
		<li><a href=\"{$self}{$helplink}\">Help</a></li>
		<li><a href=\"{$self}?action=logout\">Log out</a></li>
	</ul>";
}
function renameFile ($name, $phpendings, $editphp, $showphp, $allowedfile, $dir) {
	// This function handles renaming of files.
	global $_POST;
	if ((!in_array(getExt($_POST["oldfile"]), $phpendings) && !in_array(getExt($_POST["newfile"]), $phpendings)) || ($editphp == TRUE && $showphp == TRUE) || (getExt($_POST["oldfile"]) == getExt($_POST["newfile"]))) {
		if (array_key_exists(getExt($name), $allowedfile) || is_dir("{$dir}/{$_POST["oldfile"]}")) {
			if (is_writeable("{$dir}/{$_POST["oldfile"]}")) {
				if (@rename("{$dir}/{$_POST["oldfile"]}", "{$dir}/{$_POST["newfile"]}")) {
					echo "<p class=\"okay\">File {$_POST["oldfile"]} was renamed to {$_POST["newfile"]}</p>";
				} else {
					echo "<p class=\"error\">Error: File {$_POST["oldfile"]} could not be renamed. Possible reason: New file name already exists.</p>";
				}
			} else {
				echo "<p class=\"error\">Error: You do not have permissions to rename {$_POST["oldfile"]}</p>"; 
			}
		} else {
			echo "<p class=\"error\">Error: File {$_POST["oldfile"]} could not be renamed. New file ending (.".getExt($_POST["newfile"]).") not allowed.</p>";
		}
	} else {
		echo "<p class=\"error\">Error: You do not have permissions to rename {$_POST["oldfile"]}. Either you don't have permission to rename it to a php file or {$_POST["oldfile"]} is a php file.</p>";
	}
}
function printCssValue ($value, $isColour = TRUE) {
	// This function outputs values used in the stylesheet.
	$value = rtrim($value, ";");
	if ($isColour == TRUE && $value[0] != "#") {
		$value = "#{$value}";
	}
	echo $value;
}
$self = basename($_SERVER["PHP_SELF"]);
if (stristr($_SERVER["REQUEST_URI"], "?")) {
	$requesturi = substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], "?"));
	$location = "Location: http://{$_SERVER["HTTP_HOST"]}{$requesturi}";
} else {
	$location = "Location: http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}";
}
/* modif stef */
$log_user = $_POST["log_user"];
$log_pass = $_POST["log_pass"];
$ses_user = $_SESSION["user"];
$ses_pass = $_SESSION["pass"];
/* * fin modif stef */
if (IsSet($_GET["subdir"])) {
	$subdir = $_GET["subdir"];
	if (strstr($subdir, "..")) {
		UnSet($subdir);
	}
}
if (IsSet($_POST["action"])) {
	$action = $_POST["action"];
} else {
	$action = $_GET["action"];
}
/* modif stef */
if ($action == "logout") {
	session_unset();
	session_destroy();
	header($location);
	exit;
} /* fin modif stef */
if (IsSet($subdir)) {
// If we are in a subdirectory the action value for forms are changed and the link to move one directory up is defined.
	$dir = "{$dir}/{$subdir}";
	$formaction = "{$self}?subdir={$subdir}";
	$reloadlink = "?action=list&amp;subdir={$subdir}";
	$helplink = "?action=help&amp;subdir={$subdir}";
	if (strstr($subdir, "/")) {
		$uplink = substr($subdir, 0, strrpos($subdir, "/"));
		$uplink = "?action=list&amp;subdir={$uplink}";
	} else {
		$uplink = "?action=list";
	}
} else {
	$formaction = $self;
	$uplink = "";
	$helplink = "?action=help";
	$reloadlink = "?action=list";
}
/* modif stef */
if($ses_user != $username || $ses_pass != $password) {
	if($action == "login") {
		if ($log_user != $username || $log_pass != $password) {
			$location = "$location?x=error";
			header($location);
			exit;			
		} else {
			$user = $log_user;
			$pass = $log_pass;
			session_register("user");
			session_register("pass");
			header($location);
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>File Thingie: Login</title>
		<style type="text/css">
			body {
				padding:20px;
				margin:0;
				font-family:"Courier New", monospace;
				font-size:<?php printCssValue($CSS_fontSize, FALSE);?>;
				background:<?php printCssValue($CSS_bg);?>;
				color:<?php printCssValue($CSS_fontColour);?>;
			}
			h1 {
				font-size:24px;
				font-weight:normal;
				border-bottom:1px dashed <?php printCssValue($CSS_fontColour);?>;
			}
			div input {
				vertical-align:middle;
			}
		</style>
	</head>
	<body>
		<form action="<?php echo $self;?>" method="post">
		<?php
			if ($_GET["x"] == "error") {
				echo "<h1>Login error</h1>";
			} else {
				echo "<h1>Please login</h1>";
			}
		?>
			<div>
				<label for="log_user">User: </label><input type="text" size="15" name="log_user" id="log_user" />
			</div>
			<div>
				<label for="log_pass">Pass: </label><input type="password" size="15" type="password" name="log_pass" id="log_pass" />
				<input type="hidden" name="action" value="login" />
				<input type="submit" value="login" />
			</div>
		</form>
	</body>
</html>
<?php
exit;
} else {
/* * fin modif stef */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>File Thingie</title>
<link rel="home" title="Home" href="<?php echo $self;?>" />
<link rel="help" title="Help" href="<?php echo "{$self}{$helplink}";?>" />
<?php
	if(IsSet($subdir)) {
?>
<link rel="up" title="One Level Up" href="<?php echo "{$self}{$uplink}";?>" />
<?php 
	}
?>
<link rel="copyright" title="License Information" href="http://creativecommons.org/licenses/by-nc-sa/1.0/" />
<link rel="author" title="About the Author" href="http://www.solitude.dk/" />
<style type="text/css">
form, form div, ul, h1, h2, input, table, td, th, p, body {
	margin:0;
	padding:0;
}
body, td {
	padding:20px;;
	font-family:<?php printCssValue($CSS_fontFamily, FALSE);?>;
	font-size:<?php printCssValue($CSS_fontSize, FALSE);?>;
	background:<?php printCssValue($CSS_bg);?>;
	color:<?php printCssValue($CSS_fontColour);?>;
}
.small {
	font-size:<?php printCssValue($CSS_smallText, FALSE);?>;
}
a { /* Normal links and file names. */
	color:<?php printCssValue($CSS_linkColour);?>;
	text-decoration:none;
}
a.dir { /* Links that points to a directory. */
	font-weight:bold;
}
a:hover { /* Hover effect for links and filenames. */
	text-decoration:underline;
	background:<?php printCssValue($CSS_linkHover);?>;
}
p { /* Normal paragraphs. Used for error and okay messages. */
	margin:1em 0 0 1em;
}
.error { /* Error messages */
	color:<?php printCssValue($CSS_errorColour);?>;
}
.okay { /* Okay messages */
	color:<?php printCssValue($CSS_okayColour);?>;
}
h1 { /* The header. "Files in: ..." */
	font-size:24px;
	font-weight:normal;
	border-bottom:1px dashed <?php printCssValue($CSS_fontColour);?>;
}
h2 { /* Headers on the Help page. */
	font-size:16px;
	font-weight:normal;
	margin:1em 0 0 0;
}
input { /* All form fields. */
	font-family:Verdana, sans-serif;
	height:20px;
	vertical-align:middle;
}
input[disabled][type="text"] { /* Rename fields for write protected files. */
	background:gray;
	color:black;
}
label { /* "Upload file:" and "Create dicrectory" */
	font-weight:bold;
}
ul#menu { /* Overall for the menu */
	list-style:none;
	margin:20px 20px 0 0;
	float:left;
}
ul#menu li { /* Each menu item. */
	padding:0 4px 0 0;
	margin:5px 0;
	text-align:center;
}
ul#menu li a { /* Menu links. */
	display:block;
	color:<?php printCssValue($CSS_menuColour);?>;
	background:<?php printCssValue($CSS_menuBg);?>;
	text-decoration:none;
	width:60px;
	padding:2px;
	margin:0;
	border:1px solid <?php printCssValue($CSS_fontColour);?>;
}
ul#menu li a:hover { /* Hover effect for menu links. */
	background:<?php printCssValue($CSS_menuHoverBg);?>;
	color:<?php printCssValue($CSS_menuColour);?>;
	text-decoration:none;
	border:1px dashed <?php printCssValue($CSS_fontColour);?>;
}
p.empty { /* "Directory is empty" message. */
	margin:20px 0 20px 0;
}
table { /* Table for the listing of files. */
	margin:20px 0 20px 0;
	border-left:1px solid <?php printCssValue($CSS_fontColour);?>;
	empty-cells:show;
}
td, th { /* Cells and cell headers for listing of files. */
	padding:4px 10px 4px 10px;
}
th { /* Cell headers for lsiting of files. */
	font-size:<?php printCssValue($CSS_tableHeaderSize, FALSE);?>;
	font-weight:bold;
	background:<?php printCssValue($CSS_tableHeaderBg);?>;
	color:<?php printCssValue($CSS_tableHeaderColour);?>;
	text-align:left;
	border-top:1px solid <?php printCssValue($CSS_fontColour);?>;
	border-bottom:1px solid <?php printCssValue($CSS_fontColour);?>;
	border-right:1px solid <?php printCssValue($CSS_fontColour);?>;
}
td { /* Individual cells for listing of files. */
	border-bottom:1px solid <?php printCssValue($CSS_fontColour);?>;
	border-right:1px solid <?php printCssValue($CSS_fontColour);?>;
}
td.bottom { /* The last cell: "NN file(s), N.NNkb" */
	background:<?php printCssValue($CSS_tableHeaderBg);?>;
	color:<?php printCssValue($CSS_tableHeaderColour);?>;
	text-align:right;
}
.center { /* Used to center "rename / delete" */
	text-align:center;
}
div {
	margin:0em 1em;
}
span.size { /* Span for showing the individual file sizes. */
	font-weight:normal;
}
div#forms {
	margin:20px 0 0 0;
}
fieldset {
	border:0px hidden white;
}
textarea { /* Textarea when editing files. */
	display:block;
	margin:20px 0 0 0;
}
code { /* Overall when viewing source. */
	font-family:monospace;
	display:block;
	white-space:pre;
}
.klikket form, .ikkeklikket span {
	display:inline;
}
.ikkeklikket form, .klikket span {
	display:none;
}
.white {
/* Initial colour for cell backgrounds. */
	background:<?php printCssValue($CSS_tableBg);?>;
}
.grey {
/* Alternate colour for cell backgrounds. */
	background:<?php printCssValue($CSS_tableBgAlt);?>;
}
.klikket form input[type="text"] {
/* Input field when renaming a file. */
	border:1px dotted <?php printCssValue($CSS_linkColour);?>;
}
.klikket form input { /* Both input field and button when renaming file. */
	height:20px;
}
a.renamelink { /* The "rename" link. */
	cursor:pointer;
}
strong.button { /* Mimics the menu buttons for the help page. */
	color:<?php printCssValue($CSS_menuColour);?>;
	background:<?php printCssValue($CSS_menuBg);?>;
	text-decoration:none;
	padding:2px 10px;
	margin:0;
	border:1px solid <?php printCssValue($CSS_fontColour);?>;
	font-weight:normal;
}
ul#help {
	list-style:none;
	float:left;
	border:1px dashed <?php printCssValue($CSS_fontColour);?>;
	padding:10px;
	margin:20px 20px 20px 0;
	width:150px;
	line-height:150%;
}
ul#help li:before {
	content:"\00BB \0020";
}
ul#setupinfo {
	margin:1em 4em;
	list-style:circle;
}
ul#setupinfo, p {
	line-height:150%;
}
ul#setupinfo code, p code {
	color:<?php printCssValue($CSS_okayColour);?>;
	display:inline;
}
</style>
<script type="text/javascript">
function skift(obj) {
	if (obj.className=='ikkeklikket') {
		obj.className = 'klikket';
		document.getElementById(obj.id + '.ipt').focus();
	}
	else if (obj.className=='klikket') {
		obj.className = 'ikkeklikket';
	}
}
</script>
</head>
<body>
<?php
if ($action == "showsource") {
	echo "<h1>Showing source: {$dir}/{$_GET["file"]} <a href=\"{$self}{$reloadlink}\" class=\"small\">[Go back]</a></h1>";
	if (file_exists("{$dir}/{$_GET["file"]}")) {
		if (checkForSource(getExt($_GET["file"])) == 1) {
			echo xhtml_highlight("{$dir}/{$_GET["file"]}");
		} else {
			echo "<p class=\"error\">Error: You are not allowed to view the source of this file.</p>";
		}
	} else {
		echo "<p class=\"error\">Error: This file does not exists.</p>";
	}
} elseif ($action == "edit") {
	$editfile = "{$dir}/{$_GET["file"]}";
	if (checkForEdit(getExt($editfile)) == 1) {
		if (file_exists($editfile) && is_writeable($editfile)) {
			echo "<h1>Edit: {$editfile}</h1>";
			$filecontent = implode ("", file("{$dir}/{$_GET["file"]}"));
			$filecontent = htmlentities($filecontent);
			if ($converttabs == TRUE) {
				$filecontent = str_replace("\t", "    ", $filecontent);
			}
?>
<form action="<?php echo $formaction;?>" method="post">
	<fieldset>
	<textarea cols="76" rows="20" name="filecontent"><?php echo $filecontent;?></textarea>
	<input type="hidden" name="editfile" value="<?php echo $editfile;?>" />
	<input type="hidden" name="action" value="savefile" />
	<input type="submit" value="Save file" name="submittype" />
	<input type="submit" value="Cancel" name="submittype" />
	<input type="checkbox" name="convertspaces" id="convertspaces" /><label for="convertspaces">Convert spaces to tabs</label>
	</fieldset>
</form>
<?php
		} else {
			echo "<p class=\"error\">You cannot edit this file. Either is doesn't exists or it is write protected. <a href=\"{$self}{$reloadlink}\">[Go back]</a></p>";
		}
	} else {
		echo "<p class=\"error\">You are not allowed to edit this type of file. <a href=\"{$self}{$reloadlink}\">[Go back]</a></p>";
	}
} elseif ($action == "help") {
	echo "<h1>Help Me! <a href=\"{$self}{$reloadlink}\" class=\"small\">[Go back]</a></h1>";
?>
<ul id="help" class="small">
<li><a href="#license">License</a></li>
<li><a href="#navigation">Navigation</a></li>
<li><a href="#upload">Uploading Files and Creating Directories</a></li>
<li><a href="#rename">Renaming, Moving and Deleting Files</a></li>
<li><a href="#showsource">The Show Source function</a></li>
<li><a href="#edit">Editing Files</a></li>
<li><a href="#setup">Setting up File Thingie</a></li>
<li><a href="#customize">Customizing File Thingie</a></li>
</ul>
<h2 id="license">License</h2>
<p>This work is licensed under the Creative Commons <a href="http://creativecommons.org/licenses/by-nc-sa/1.0/">Attribution-NonCommercial-ShareAlike License</a>. Please read the license information before distributing this or derivative works. If you want to use File Thingie for a commercial project please <a href="mailto:files@solitude.dk">contact me</a>.</p>
<h2 id="navigation">Navigation</h2>
<p>Navigating is done with the links to the left of the file listing. The <strong class="button">Home</strong> link will always take you to the same position you started at when you logged in. If you are in a subdirectory an <strong class="button">Up</strong> link will appear. This will take you one level up in the directory structure. <strong class="button">Reload</strong> will reload the current page. This is more useful than the reload button of the browser if you have just performed an action (eg. renamed a file). <strong class="button">Help</strong> will take you to this page and <strong class="button">Log out</strong> will log you out out. Be sure to always log out if you are using File Thingie from a shared or public computer!</p>
<p>If your browser supports navigation with <code>&lt;link&gt;</code> elements you will see additional navigation. The "Home", "Help" and "Up" buttons are identical to those in the menu. "Copyright" will take you to the page with license information for File Thingie and "Author" will take you to the author's website.</p>
<h2 id="upload">Uploading Files and Creating Directories</h2>
<p>To upload a file you simply click on the button next to the "upload" button (in my browser it's called "Choose", yours might be "Browse", "..." or something else). This allows you to choose a file from your harddrive you want to upload. When you have selected a file the path should be inserted into the text field. Click "Upload" and wait. If the file you are uploading it can take a while. You will get a <span class="okay">green</span> confirmation if the file was uploaded or a <span class="error">red</span> error message if the file was not uploaded correctly. The file be uploaded to the directory you are currently in.</p>
<p>To create a directory simply type the name you you want in text field and click "Mkdir". The directory will be dreated as a subdirectory to the directory you are currently in. You will get a <span class="okay">green</span> confirmation if the directory was created or a <span class="error">red</span> error message if it wasn't.</p>
<h2 id="rename">Renaming, Moving and Deleting Files</h2>
<p>To rename a file or directory click the "rename" link next to the name of the file or directory you wish to rename. The name will change to a text field and an "ok" button. Type the new name in the field and click the "ok" button. Even if you click multiple rename links and change multiple names only the name next to the "ok" button will be renamed.</p>
<p>It is also possible to move a file with the rename field. To move a file or directory to a subdirectory in the current directory simply write the path in the text field. For example: If you want to move the file.txt to the subdirectory subdirectory simply write "subdirectory/file.txt" in the text field. If you want to move a file or directory <em>up</em> in the directory structure use "../". For example: If you have file.txt in a subdirectory and you wish to move it to the home directory simply write "../file.txt" in the text field. Use multiple (eg. "../../") if you want to move the file up more than one step.</p>
<p>To delete a file or directory simply click the "delete" link. <strong>Warning:</strong> the file will be deleted without confirmation!</p>
<p>You will get a <span class="okay">green</span> confirmation if the file was moved/renamed/deleted or a <span class="error">red</span> error message if it wasn't.</p>
<h2 id="showsource">The Show Source function</h2>
<p>If you enable it in your <a href="#setup">configuration</a> File Thingie will allow you to view the source of <acronym title="HyperText Markup Language">HTML</acronym>/<acronym title="Cascading Style Sheets">CSS</acronym>/PHP documents. By default it is enabled for <acronym title="HyperText Markup Language">HTML</acronym> and <acronym title="Cascading Style Sheets">CSS</acronym> and thus you can avoid having to finding the "View Source" functionality in your browser. If you enable view source for PHP files you will get colour coded source code to help you. The view source link will show up as a link titled <strong>[src]</strong> after the file name and size.</p>
<p>Due to problems with earlier versions of PHP the view source function is only available for PHP versions of 4.2.0 or later. Your PHP version is <strong><?php echo phpversion();?></strong></p>
<h2 id="edit">Editing Files</h2>
<p>If it's enabled in your <a href="#setup">configuration</a> you can edit <acronym title="HyperText Markup Language">HTML</acronym>/<acronym title="Cascading Style Sheets">CSS</acronym>/PHP documents. It is enabled by default only for text, <acronym title="HyperText Markup Language">HTML</acronym> and <acronym title="Cascading Style Sheets">CSS</acronym>. If you can edit a file there will be a <strong>[edit]</strong> after the file name. Clicking this will take you to the edit screen. After you are done click "Save file", or click "Cancel" if you don't want to edit the file anyway. Checking the "Convert spaces to tabs" box will convert every <strong>four</strong> spaces to a tab when the file is saved.</p>
<p>You will get a <span class="okay">green</span> confirmation if the file was saved successfully or a <span class="error">red</span> error message if it wasn't.</p>
<h2 id="setup">Setting up File Thingie</h2>
	<p>The configurations start after the line that says: <code>/* Setup information. Change as appropriate */</code></p>
	<ul id="setupinfo">
		<li><code>$username = "USERNAME";</code> Change "USERNAME" to whatever username you want to use. If you want to use <code>BartSimpson</code> as your username the lines should be changed to <code>$username = "BartSimpson";</code>. The username is case sensitive!</li>
		<li><code>$password = "PASSWORD";</code> Change "PASSWORD" to whatever you want your password to be. The password is case sensitive!</li>
		<li><code>$dir = "test";</code> Change "test" to the subdirectory you want to File Thingie to work in. The File Thingie file has to be located one step above this directory. Eg. if you want File Thingie to work in /public_html/subdirectory/ the file should be placed in /public_html/ and the line should be changed to <code>$dir = "subdirectory";</code></li>
		<li><code>$maxsize = 100000;</code> Change this to the maximum file size you want to allow for upload. The size is given in bytes.</li>
		<li><code>$showphp = FALSE;</code> Change FALSE to TRUE if you want to allow the viewing of source for PHP files.</li>
		<li><code>$edithtml = TRUE;</code> Change TRUE to FALSE if you want to turn off editing of HTML and CSS files.</li>
		<li><code>$edittxt = TRUE;</code> Change TRUE to FALSE if you want to turn off editing of text files.</li>
		<li><code>$editphp = FALSE;</code> Change FALSE to TRUE if you want to turn on editing of PHP files.</li>
		<li><code>$converttabs = TRUE;</code> Change TRUE to FALSE if you don't want to convert tabs to spaces when editing files. In a browser it's easier to work with spaces than tabs (since the tab-key doesn't work in a text field).</li>
		<li><code>$phpendings = array("php", "php3", "php4", "phtml");</code> A list of files percieved by File Thingie as PHP files. You probably don't have to add anything.</li>
		<li><code>$allowedfile["jpg"] = "image/jpeg";</code> There is a long list of lines that looks like this. They represent all the different types of files allowed for upload. If you want to disallow a file type place two slashes (//) in front of the line (like it has been done with the two last lines). If you want to add more file types just add your own lines in this format: <code>$allowedfile["FileEnding"] = "MIMEType";</code></li>
	</ul>
	<p>Remember that you should CHMOD the <em>subdirectory</em> you want to work with to 777. Otherwise File Thingie will not have permissions to upload files.. or permissions to do anything other than state "Directory is empty" often.</p>
<h2 id="customize">Customizing File Thingie</h2>
<p>It is possible to quickly choose your own colours and fonts to use with File Thingie. The settings are immediately after the setup information. Each option is explained there.</p>
<p>When writing a font-family it is important the seperate each font with a comma. Futhermore it is vital that double quotes (") are written with a backslash infront (ie. \" and not just "). You are encouraged to always end your list with a default font-family - usually either <code>sans-serif</code> or <code>serif</code>.</p>
<p>The colour part of the colours and fonts <strong>only</strong> accepts <strong>hex-values</strong>. It is not possible to use decimal values or any of the keywords. Only hex-values!</p>
<p>If you want to modify more of the design than just the colours and fonts the stylesheet for File Thingie begins around line 350.</p>
<?php
} else {
	echo "<h1>Files in: {$dir}/</h1>";
?>
<div id="forms">
	<form action="<?php echo $formaction;?>" method="post" enctype="multipart/form-data" accept="<?php echo outputAcceptedFiles($allowedfile);?>">
		<fieldset>
			<label for="localfile">Upload file: </label>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxsize;?>" />
			<input type="file" name="localfile" id="localfile" />
			<input type="hidden" name="action" value="upload" />
			<input type="submit" value="Upload" />
		</fieldset>
	</form>
	<form action="<?php echo $formaction;?>" method="post">
		<fieldset>
			<label for="newdir">Create directory: </label>
			<input size="15" name="newdir" id="newdir" />
			<input type="hidden" name="action" value="mkdir" />
			<input type="submit" value="Mkdir" />
		</fieldset>
	</form>
</div>
<?php
	if ($action == "delete") {
	// If we are to delete a file or directory we bring forward the flaming sword.
		$file = "{$dir}/{$_GET["file"]}";
		if (is_dir($file)) {
			if (!@rmdir($file)) {
				echo "<p class=\"error\">Error: Directory {$file} not deleted. Possible error: Directory not empty.</p>";
			} else {
				echo "<p class=\"okay\">Directory {$file} removed.</p>";
			}
		} else {
			if (!@unlink($file)) {
				echo "<p class=\"error\">Error: File {$file} not deleted</p>";
			} else {
				echo "<p class=\"okay\">File {$file} deleted</p>";
			}
		}
	} elseif ($action == "upload") {
	// If we are to upload a file we will do so.
		$tmp_name = $_FILES['localfile']['tmp_name'];
		$name = strtolower("{$dir}/{$_FILES['localfile']['name']}");
		$ext = getExt($name);
		$type = $_FILES["localfile"]["type"];
		if ($_FILES["localfile"]["error"] == 0) {
			if (checkFileType($type, getExt($name)) == TRUE) {
				if (@move_uploaded_file($tmp_name, $name)) {
					@chmod($name, 0755);
					echo "<p class=\"okay\">File {$name} uploaded.</p>";
				}
			} else {
				echo "<p class=\"error\">Error: Files of the type {$_FILES["localfile"]["type"]} and the ending .".getExt($name)." are not allowed for upload.</p>";
			}
		} else {
			switch($_FILES["localfile"]["error"]) {
				case 1:
					$currenterror = "The file was too large.";
					break;
				case 2:
					$currenterror = "The file was too large.";
					break;
				case 3:
					$currenterror = "Only a part of the file was uploaded. Please try again.";
					break;
				case 4:
					$currenterror = "No file was uploaded. Please try again.";
					break;
				default:
					$currenterror = "Unknown error.";
					break;
			}
			echo "<p class=\"error\">Error: {$currenterror}</p>";
		}
	} elseif ($action == "mkdir") {
	// If we are to create a dictory we will give it our best shot.
		$newdir = strtolower("{$dir}/{$_POST["newdir"]}");
		$oldumask = umask(0);
		if (@mkdir($newdir, 0755)) {
			echo "<p class=\"okay\">Directory {$newdir} created.</p>";
		} else {
			echo "<p class=\"error\">Error: Directory {$newdir} not created.</p>";
		}
		umask($oldumask);
	} elseif ($action == "rename") {
		if (stristr($_POST["newfile"], "/")/* && !is_dir("{$dir}/{$_POST["oldfile"]}")*/) {
			// If the new file name contains a / we try to move the file.
			if (stristr($_POST["newfile"], "../")) {
				if (IsSet($subdir)) {
					// Okay, check for level.
					$level = substr_count($_POST["newfile"], "../");
					if ($level <= substr_count($dir, "/")) {
						$name = "{$dir}/{$_POST["newfile"]}";
						renameFile ($name, $phpendings, $editphp, $showphp, $allowedfile, $dir);
					} else {
						echo "<p class=\"error\">Error: File not moved. You cannot move files outside the designated starting directory.</p>";
					}
				} else {
					echo "<p class=\"error\">Error: File not moved. You cannot move files outside the designated starting directory.</p>";
				}
			} else {
				$name = "{$dir}/{$_POST["newfile"]}";
				renameFile ($name, $phpendings, $editphp, $showphp, $allowedfile, $dir);
			}
		} else {
		// Else we rename the file in question.
			$name = "{$dir}/{$_POST["newfile"]}";
			renameFile ($name, $phpendings, $editphp, $showphp, $allowedfile, $dir);
		}
	} elseif ($action == "savefile") {
		// Save a file that has been edited.
		$editfile = $_POST["editfile"];
		if ($_POST["submittype"] == "Save file") {
			if (checkForEdit(getExt($editfile)) == 1) {
				$filecontent = stripslashes($_POST["filecontent"]);
				if ($_POST["convertspaces"] != "") {
					$filecontent = str_replace("    ", "\t", $filecontent);
				}
				if (is_writeable("{$editfile}")) {
					$fp = fopen("{$editfile}", "wb");
					fputs ($fp, $filecontent);
					fclose($fp);
					echo "<p class=\"okay\">File {$editfile} edited.</p>";
				} else {
					echo "<p class=\"error\">Error: Could not edit the file because it is write protected.</p>";
				}
			} else {
				echo "<p class=\"error\">Error: File {$editfile} could not be edited. File ending (.".getExt($editfile).") not allowed for edit.</p>";
			}
		}
	}
	$filelist = array();
	if ($dirlink = @opendir($dir)) {
		// Creates an array with all file names in current directory.
		while (($file = readdir($dirlink)) !== false) {
			if ($file != "." && $file != "..") {
				if (is_dir("{$dir}/{$file}")) {
					$subdirs[] = $file;
				} else {
					$filelist[] = $file;
				}
			}
		}
	closedir($dirlink);
	}
	$filenum = sizeof($filelist)+sizeof($subdirs);
	buildMenu($self, $uplink, $reloadlink, $helplink);
	if (count($filelist) != 0 || is_array($subdirs)) {
		echo "<table cellspacing=\"0\">
		<tr>
			<th>File</th>
			<th class=\"center\">Options</th>
		</tr>";
		if (is_array($subdirs)) {
			rsort($subdirs);
			sort($filelist);
			for ($i = 0; $i < sizeof($subdirs); $i++) {
				array_unshift($filelist, $subdirs[$i]);
			}
		} else {
			sort($filelist);
		}
		for ($i = 0; $i < $filenum; $i++) {
			$file = $filelist[$i];
			if (is_dir("{$dir}/{$file}")) {
				if ($dirlink = @opendir("{$dir}/{$file}")) {
					while (($current = readdir($dirlink)) !== false) {
						if ($current != "." && $current != "..") {
							$size++;
						}
					}
				}
				closedir($dirlink);
				if (!IsSet($size)) {
					$size = "0";
				}
				if ($size == 1) {
					$size = "{$size} file";
				} else {
					$size = "{$size} files";
				}
				if (!IsSet($subdir)) {
					$filelink = "<a href=\"{$self}?action=list&amp;subdir={$file}\" title=\"List files in {$file}\" class=\"dir\">{$file}</a> <span class=\"size small\">({$size})</span>";
				} else {
					$filelink = "<a href=\"{$self}?action=list&amp;subdir={$subdir}/{$file}\" title=\"List files in {$file}\" class=\"dir\">{$file}</a> <span class=\"size small\">({$size})</span>";
				}
			} else {
				$size = filesize("{$dir}/{$file}");
				$totalsize = $totalsize + $size;
				$size = substr($size/1024, 0, 4)."kb";
				if (is_readable("{$dir}/{$file}")) {
					$filelink = "<a href=\"{$dir}/{$file}\" title=\"Open {$file} in the browser\">{$file}</a> <span class=\"size small\">({$size})</span>";
					if (checkForSource(getExt($file)) == 1) {
						if(IsSet($subdir)) {
							$filelink = "{$filelink} <a href=\"{$self}?action=showsource&amp;file={$file}&amp;subdir={$subdir}\" class=\"small\" title=\"View the source of {$file}\">[src]</a>";
						} else {
							$filelink = "{$filelink} <a href=\"{$self}?action=showsource&amp;file={$file}\" class=\"small\" title=\"View the source of {$file}\">[src]</a>";
						}
					}
					if (checkForEdit(getExt($file)) == 1 && is_writeable("{$dir}/{$file}")) {
						if(IsSet($subdir)) {
							$filelink = "{$filelink} <a href=\"{$self}?action=edit&amp;file={$file}&amp;subdir={$subdir}\" class=\"small\" title=\"Edit {$file}\">[edit]</a>";
						} else {
							$filelink = "{$filelink} <a href=\"{$self}?action=edit&amp;file={$file}\" class=\"small\" title=\"Edit {$file}\">[edit]</a>";
						}
					}
				} else {
					$filelink = "{$file}";
				}
			}
			if (is_writeable("{$dir}/{$file}") && IsSet($subdir)) {
				/* modif by stef */
				$delete = "<a onclick=\"skift(document.getElementById('{$file}'))\" class=\"renamelink\">rename</a> / <a onclick=\"if(confirm('do you wish to delete this file for good?')) { return true; } else { return false; }\" href=\"{$self}?action=delete&amp;file={$file}&amp;subdir={$subdir}\" title=\"Delete {$file}\">delete</a>";
				/* end modif by stef */
				$rename = "<input type=\"hidden\" name=\"subdir\" value=\"{$subdir}\" />
							<input type=\"text\" name=\"newfile\" value=\"{$file}\" size=\"".strlen($file)."\" />
							<input type=\"submit\" value=\"ok\" />";
			} elseif (is_writeable("{$dir}/{$file}") && !IsSet($subdir)) {
				/* modif by stef */
				$delete = "<a onclick=\"skift(document.getElementById('{$file}'))\" class=\"renamelink\">rename</a> / <a onclick=\"if(confirm('do you wish to delete this file for good?')) { return true; } else { return false; }\" href=\"{$self}?action=delete&amp;file={$file}\" title=\"Delete {$file}\">delete</a>";
				/* end modif by stef */
				$rename = "<input type=\"text\" name=\"newfile\" value=\"{$file}\" size=\"".strlen($file)."\" />
						<input type=\"submit\" value=\"ok\" />";
			} else {
				$delete = "";
				$rename = "<input type=\"text\" name=\"newfile\" disabled=\"disabled\" />
				<input type=\"submit\" value=\"rename\" disabled=\"disabled\" />";
			}
			if ($i % 2 == 0) {
				$style = "white";
			} else {
				$style = "grey";
			}
			echo "<tr class=\"ikkeklikket\" id=\"{$file}\">
					<td class=\"{$style}\"><span>{$filelink}</span>
						<form action=\"{$formaction}\" method=\"post\" id=\"{$file}.ipt\">
							<input type=\"hidden\" name=\"action\" value=\"rename\" />
							<input type=\"hidden\" name=\"oldfile\" value=\"{$file}\" />
							{$rename}
						</form>
					</td>
					<td class=\"center small {$style}\">{$delete}</td>
				</tr>";
			Unset($size);
		}
		$totalsize = substr($totalsize/1024, 0, 4);
		echo "<tr><td colspan=\"2\" class=\"bottom small\">{$filenum} file(s), {$totalsize}kb</td></tr>";
		echo "</table>";
	} else {
		echo "<p class=\"empty\">Directory is empty.</p>";
	}
	echo "<p>File Thingie is &copy; <!-- Copyright --> 2003 <a href=\"http://www.solitude.dk\">Andreas Haugstrup</a>. Some rights <a href=\"http://creativecommons.org/licenses/by-nc-sa/1.0/\">reserved.</a></p>";
}
?>
</body>
</html>
<?php
	clearstatcache();
/* modif stef */
}
/* * fin modf stef */
?>