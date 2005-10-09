<?
/********************************************************************
*    file uploader - file uploader code snippet.
*   maxsize :
*        - you can set the maxsixe, if file size exceed maxsize it won't proceed;
*        - you can set the quota, if dir size exceed quota it won't proceed;
*        - you can set the ext, if file name extension listed on this array  it won't proceed;
*
*    Copyright (C) 2001 Wibisono Sastrodiwiryo.
*       This program is free software licensed under the
*       GNU General Public License (GPL).
*
*   CyberGL => Application Service Provider
*   http://www.cybergl.co.id
*    office@cybergl.co.id
*
*   $Id: uploader2.php3,v 0.2 2001/07/23 22:3:34 wibi Exp $
*********************************************************************/
$dir     ="/www/servers/upload"; # your uploaded file dir, this dir require proper permission to write access
$temp     ="/tmp";  # unix system temp dir
$maxsize ="40960"; # max 40 Kb
$quota   = 524288; # define space quota 500 Kb
$ext     = array(".p", ".php", ".php3", ".phtml", ".shtml"); # define file extension to reject

        if ($userfile AND $userfile != "none") {
            $total=0;
            $handle=opendir($dir);
            while ($file = readdir($handle)) {
                if (is_file("$dir/$file")) {$total+=filesize("$dir/$file");}
            }
            while (list($key,$val) = each($ext)) {
                if (strstr($userfile_name, $val)) {$invalidext=true;break;}
            }
            if ($userfile_size > $maxsize) {echo "ERR: File too large";}
            elseif ($invalidext) {echo "ERR: Forbiden file extension";}
            elseif ($total > $quota) {echo "ERR: Space quota exceeded";}
            else {
                rename("$userfile", "$temp/$userfile_name");
                copy("$temp/$userfile_name", "$dir/$userfile_name");
                unlink("$temp/$userfile_name");
                echo "OK: File \"$userfile_name\" uploaded succesfully";
            }
        } else {
?>
<form action="<?echo $PHP_SELF?>" method=POST ENCTYPE="multipart/form-data">
  <table>
    <tr>
      <td class=navbox>Select File:</td>
      <td>:</td>
      <td><input type=file name=userfile></td>
    </tr>
    <tr>
      <td class=navbox>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type=submit value=Upload></td>
    </tr>
</table>
  </form>
<?}?>