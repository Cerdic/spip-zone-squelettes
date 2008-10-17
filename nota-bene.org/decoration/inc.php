<?php

/*
* pour rappel :
* div#header height:77px;
* body.sommaire div#header height:166px;
* */

$i = 0;

$decoration[$i]['titre'] = 'la fleur de l\'&acirc;ge';
$decoration[$i]['css'] = '
div#header {
    background:url(/v4/decoration/0_header_bg.jpg) #790102 top left no-repeat; color:#ffffff;
}
body.sommaire div#header {
    background:url(/v4/decoration/0_header_bg_home.jpg) #790102 top left no-repeat; color:#ffffff;
}
';

$i++;
$decoration[$i]['titre'] = 'les petits bonheurs';
$decoration[$i]['css'] = '
div#header {
    background:url(/v4/decoration/1_header_bg.jpg) #B19D7F top left no-repeat; color:#ffffff;
}
body.sommaire div#header {
    background:url(/v4/decoration/1_header_bg_home.jpg) #B19D7F top left no-repeat; color:#ffffff;
}
';

$i++;
$decoration[$i]['titre'] = 'en passant...';
$decoration[$i]['css'] = '
div#header, body.sommaire div#header {
    background:url(/v4/decoration/2_header_bg.jpg) #759CCA left center no-repeat; color:#ffffff;
}
';

$i++;
$decoration[$i]['titre'] = 'souriez !';
$decoration[$i]['css'] = '
div#header {
    background:url(/v4/decoration/3_header_bg.jpg) #2D4011 top left no-repeat; color:#ffffff;
}
body.sommaire div#header {
    background:url(/v4/decoration/3_header_bg_home.jpg) #2D4011 top left no-repeat; color:#ffffff;
}
';

$i++;
$decoration[$i]['titre'] = 'ici on joue &agrave; chat';
$decoration[$i]['css'] = '
div#header {
    background:url(/v4/decoration/4_header_bg.jpg) #9D9C9C left top no-repeat; color:#ffffff;
}
body.sommaire div#header {
    background:url(/v4/decoration/4_header_bg_home.jpg) #9D9C9C left top no-repeat; color:#ffffff;
}
';

$i++;
$decoration[$i]['titre'] = 'dehors il fait beau';
$decoration[$i]['css'] = '
div#header {
    background:url(/v4/decoration/5_header_bg.jpg) #79918A left top no-repeat; color:#ffffff;
}
body.sommaire div#header {
    background:url(/v4/decoration/5_header_bg_home.jpg) #79918A left top no-repeat; color:#ffffff;
}
';


?>