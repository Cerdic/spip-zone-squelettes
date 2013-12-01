<?php
/* 

Copier ce fichier à la racine du site dont vous voulez obtenir le script d'installation svn
En l'état, ce script ne fonctionnera qu'avec SubVersioN 1.7 minimum (car ce dernier n'a qu'un .svn par repository utilisé).

Inspiré de :
http://ericlondon.com/scanning-file-system-path-all-version-control-remote-repository-urls
http://code.dunae.ca/src/svn2zip.php
*/

// define a path to scan
$scan_path = __DIR__;

function liste_Dirs($dir,$tofind)
{
    $dossier = opendir($dir);

    while($item = readdir($dossier))
    {
        $berk = array('.', '..'); // ne pas tenir compte de ses répertoires / fichiers

        if (!in_array($item, $berk))
        {
            $new_Dir = $dir.'/'.$item;

            if(is_dir($new_Dir))
            {
                if ($item==$tofind) $output .= $new_Dir."\n";
					else $output .= liste_Dirs($new_Dir,$tofind);
            }
        }
    }


    return $output;
}

function get_svn_info($src) {
        $info = array();

        // run 'svn info' on the repository
        $cmd = sprintf("svn info %s", escapeshellarg($src), escapeshellarg($tmp_path));

        exec($cmd, $out, $ret);
        
        if($ret != 0)
            exit_with_error('Unable to get repository info');

        $out = implode($out, "\n");

        // extract the revision number
        if(preg_match('/^revision\:[ ]?([0-9]+)[ ]?$/im', $out, $matches) > 0)
            $info['revision'] = $matches[1];

        // extract the path
        if(preg_match('/^URL\:[ ]?(.+)[ ]?$/im', $out, $matches) > 0)
            $info['svnurl'] = $matches[1];
        
		$info['src'] = $src;
			

        return $info;
}

$files = liste_Dirs($scan_path,'.svn');

// explode on "\n"
$files = explode("\n", $files);

// Directory to exclude
$dir2exclude[] = '/extensions/compresseur/';
$dir2exclude[] = '/extensions/filtres_images/';
$dir2exclude[] = '/extensions/msie_compat/';
$dir2exclude[] = '/extensions/porte_plume/';
$dir2exclude[] = '/extensions/safehtml/';
$dir2exclude[] = '/extensions/vertebres/';

// loop through files
$repo_list = array();
foreach($files as $key => $file) {

  $repo_path = substr($file, 0, -4);

  // get svn repo root
  if ($repo_path) $repo_list[]= get_svn_info($repo_path);
}

foreach($repo_list as $key => $repo) {
	$chemin = str_replace($scan_path,'',$repo['src']);
	if (!in_array($chemin,$dir2exclude))
		echo 'sleep 15 && svn checkout '.$repo['svnurl'].' .'.$chemin.' -r'.$repo['revision'].'<br />';
}
?>