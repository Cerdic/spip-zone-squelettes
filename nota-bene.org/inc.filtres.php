<?

/*
* inc.filtres.php
* filtres de nb v4
* */



/*
* fonctions generiques pour les textes
* on appelle a travers cette fonction les sous-filtres necessaires
* (ca fait un seul point d'entree)
* */
function nb_texte($str) {
    if($str!="") {
        $str = nb_spip2xhtml($str);
        $str = nb_hreflang($str);
        // $str = nb_checkparas($str);
        $str = nb_lessclass($str);
        $str = nb_abbr($str);
    }
    return $str;
}
function nb_titre($str) {
    if($str!="") {
        $str = nb_abbr($str);
    }
    return $str;
}
function nb_texte_sommaire($str) {
    // special pour la home : on veut que les h2 de son contenu deviennent des h3 sur la home
    $str = nb_texte($str);
    $str = nb_h2toh3($str);
    return $str;
}
function nb_introduction($str) {
    if($str!="") {
        $str = nb_spip2xhtml($str);
        $str = nb_hreflang($str);
        $str = nb_checkparas($str);
        $str = nb_lessclass($str);
        $str = nb_abbr($str);
    }
    return $str;
}
function nb_notes($str) {
    if($str!="") {
        $str = nb_spip2xhtml($str);
        $str = nb_hreflang($str);
        $str = nb_checkparas($str);
        $str = nb_lessclass($str);
        $str = nb_abbr($str);
    }
    return $str;
}

function nb_ps($str) {
    if($str!="") {
        $str = nb_spip2xhtml($str);
        $str = nb_hreflang($str);
        $str = nb_checkparas($str);
        $str = nb_lessclass($str);
    }
    return $str;
}

function nb_url_site($str) {
    if($str!="") {
        $str = nb_hreflang($str);
    }
    return $str;
}

/*
* formatage du contenu pour validation xhtml
* */

function nb_spip2xhtml($str) {
    if($str!="") {

        // ol ou ul imbrique dans p
        $str = preg_replace( "/<p class=\"spip\"><(o|u)l class=\"spip\">/i" , "<\\1l class=\"spip\">" , $str);
        $str = preg_replace( "/<\/(o|u)l>( )*<\/p>/i" , "</\\1l>" , $str);

        // blockquote imbrique dans un p
        $str = preg_replace( "/<p class=\"spip\">( )*<blockquote class=\"spip\">/i" , "\n<blockquote><p>" , $str);
        $str = preg_replace( "/<\/blockquote>( )*<\/p>/i" , "</p></blockquote>\n" , $str);

    }

    // renvoyer la chaine corrigee
    return $str;
}

/*
* alleger le html produit en virant toutes les classes spip possibles
* */
function nb_lessclass($str) {
    $str = preg_replace( "/ class=\"spip\">/i" , ">" , $str);
    return $str;
}

/*
* filtre de hreflang avec callback
* */

function nb_hreflang($str) {
    $str = preg_replace_callback("/\(([a-z]{2})\)(http[^\"]*)/","nb_hreflang_callback",$str);
    return $str;
}
function nb_hreflang_callback($matches){
    return $matches[2] .  "\" " . $title . "hreflang=\"" . $matches[1];
}

/*
* verification des paragraphes
* c'est toujours foireux dans la 1.8 quand on a une seule ligne
* */
function nb_checkparas($str){
    $str = trim($str);
    if(substr($str, 0, 2)!="<p"
        && substr($str, 0, 11)!="<blockquote"
        && substr($str, 0, 3)!="<ul"
        && substr($str, 0, 3)!="<ol") {
        $str = "<p>" . $str;
        $flag_fermer = TRUE;
    }
    if(substr($str, strlen($str)-4, 4)!="</p>"
        && $flag_fermer==TRUE) {
        $str .= "</p>";
    }
    return $str;
}

/*
* transformation des h2 en h3 pour la home
* */
function nb_h2toh3($str) {
    if($str!="") {
        // blockquote imbrique dans un p
        $str = preg_replace( "/<h2(| .*?)>/i" , "<h3>" , $str);
        $str = preg_replace( "/<\/h2>/i" , "</h3>" , $str);
    }
    return $str;

}

/*
* gestion des abreviations
* credits : Michel Valdrighi pour l'idee originale
*           Julien Wajsberg et Gabriel Euzet pour l'aide a la simplification
* */
function nb_abbr($str) {
    // reste a finir : definitions comme mots entiers
    $array_acronyms = array(
        '/ALA/' => '<abbr title="A List Apart">\\0</abbr>',
        '/CSS/' => '<abbr title="Cascading Stylesheets">\\0</abbr>',
        '/DOM/' => '<acronym title="Document Object Model">\\0</acronym>',
        '/GIF/' => '<abbr title="Graphic Interchange Format">\\0</abbr>',
        '/([^A-Z])(HTML)/' => '\\1<abbr title="Hypertext Markup Language">\\2</abbr>',
        '/JS/' => '<abbr title="Javascript">\\0</abbr>',
        '/MDC/' => '<abbr title="Mozilla Developer Center">\\0</abbr>',
        '/MSIE/' => '<abbr title="Microsoft Internet Explorer">\\1</abbr>',
        '/([^A-Z])(IE)([^A-Z])/' => '\\1<abbr title="Microsoft Internet Explorer">\\2</abbr>\\3',
        '/([^A-Z])(NN)([^A-Z])/' => '\\1<abbr title="Netscape Navigator">\\2</abbr>\\3',
        '/PDF/' => '<abbr title="Portable Document Format">\\0</abbr>',
        '/PNG/' => '<abbr title="Portable Network Graphics">\\0</abbr>',
        '/RSS/' => '<abbr title="Really Simple Syndication">\\0</abbr>',
        '/SEO/' => '<abbr title="Search Engine Optimization">\\0</abbr>',
        '/W[aA][sS]P/' => '<acronym title="Web Standards Project">WaSP</acronym>',
        '/W3C/' => '<abbr title="World Wide Web Consortium">\\0</abbr>',
        '/WCAG/' => '<abbr title="Web Content Accessibility Guidelines">\\0</abbr>',
        '/wifi/i' => '<acronym title="Wireless network">\\0</acronym>',
        '/XHTML/i' => '<abbr title="eXtensible Hypertext Markup Language">\\0</abbr>',
        '/XML/' => '<abbr title="eXtensible Markup Language">\\0</abbr>',
        '/XSLT/' => '<abbr title="eXtensible Style Language Transformation">\\0</abbr>',
        '/(XSL)([^A-Z])/' => '<abbr title="eXtensible Style Language">\\1</abbr>\\2'
    );

    if( !ereg('<',$str)) { // premier test pour le cas des titres
        $str = preg_replace(array_keys($array_acronyms), array_values($array_acronyms) , $str);
    } else {
        $coll = explode('<',$str);
        $str = '' . $coll[0]; // on prend le premier morceau, qu'il soit vide ou pas
        for($i=1;$i<count($coll);$i++) {
            $coll[$i] = '<' . $coll[$i];
            if(!preg_match('/(<abbr|<acronym)/i',$coll[$i])) { // si le tag n'est ni abbr ni acronym
                $str .= substr($coll[$i],0,strpos($coll[$i],'>')+1)
                    . preg_replace(array_keys($array_acronyms), array_values($array_acronyms) , substr($coll[$i],strpos($coll[$i],'>')+1));
            } else { // sinon passer tel quel et aller au tag suivant
                $str .= $coll[$i];
            }
        }
    }
    return $str;
}

/**
* gravatar pour l'email du mec qui commente
* */

function nb_gravatar($str,$size=48) {
    if($str!='') {
        $strtmp = 'http://www.gravatar.com/avatar.php?gravatar_id='.md5($str).'&amp;size='.$size.'&amp;rating=PG&amp;default=' . urlencode("http://www.nota-bene.org/rien.gif") ;
        $str = "background:url(" . $strtmp . ") transparent top right no-repeat;";
    }
    return $str;
}
?>