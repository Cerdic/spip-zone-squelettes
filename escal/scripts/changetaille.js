var styles = [ "60%" , "80%" , "100%" , "120%" , "140%" , "160%" , "180%" ]
var style = 3
function changestyle(l_direction)
	{
	if ( ( style == 1 ) && ( l_direction == -1 ) ) { alert("Stop ! Vous avez une loupe sur vous ?") }
	if ( ( style > 1 ) && ( l_direction == -1 ) ) { style -- }
	if ( ( style < 7 ) && ( l_direction == 1 ) ) { style ++ }
	if ( ( style == 7 ) && ( l_direction == 1 ) ) { alert("Et si vous alliez voir votre ophtalmo, mmh ?") }
	document.getElementById("texte-article").style.fontSize = styles[style-1]
	}
