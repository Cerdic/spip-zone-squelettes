//-----------------------------------------------------------------------------
// Gestion de l'affichage par onglets
//-----------------------------------------------------------------------------
function affiche1()
{	
	document.getElementById('panneau_1').style.display='block';
	document.getElementById('panneau_2').style.display='none';
	document.getElementById('panneau_3').style.display='none';
	document.getElementById('tab_1').className = "on";
	document.getElementById('tab_2').className = "";			
	document.getElementById('tab_3').className = "last";
}
function affiche2()
{
	document.getElementById('panneau_1').style.display='none';
	document.getElementById('panneau_2').style.display='block';
	document.getElementById('panneau_3').style.display='none';
	document.getElementById('tab_1').className = "";
	document.getElementById('tab_2').className = "on";		
	document.getElementById('tab_3').className = "last";
}	
function affiche3()
{
	document.getElementById('panneau_1').style.display='none';
	document.getElementById('panneau_2').style.display='none';
	document.getElementById('panneau_3').style.display='block';
	document.getElementById('tab_1').className = "";
	document.getElementById('tab_2').className = "";		
	document.getElementById('tab_3').className = "on last";
}	
