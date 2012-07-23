<?php
function regex_twitter($twitt){
      $twitt = preg_replace('#((http(s?):\/\/|ftp:\/\/{1})([0-9a-zA-Z.\-]*\/?)*)#i',
            '<a href="$0" target="_blank">$0</a>', $twitt);
      $twitt = preg_replace('#@([a-zA-Z0-9_-]+)#i',
            '<a href="http://twitter.com/$1" target="_blank">@$1</a>', $twitt);
      $twitt = preg_replace('#\#([a-z0-9_-]+)#i',
            '<a href="http://search.twitter.com/search?q=%23$1" target="_blank">#$1</a>',
            $twitt);      
      return $twitt;
}
?>