//==============================================================
// Cette fonction affiche le nuancier de choix de couleur 
// Appelée depuis la page "cfg_durzy"
//==============================================================

//initialisation des variables

//cadre derniers articles, derniers messages et même rubrique
var init_couleur_last_articles_fond = "E5EFF8"; 
var init_couleur_last_articles_titre = "82ADE2"; 
var init_couleur_last_articles_bordures = "999"; 

//cadre Edito
var init_couleur_edito_fond = "FFF8AC";
var init_couleur_edito_titre = "FFED00";
var init_couleur_edito_bordures = "999";

//cadre Brèves
var init_couleur_breves_fond = "E5EFF8";
var init_couleur_breves_titre = "82ADE2";
var init_couleur_breves_bordures = "999";

//cadre Acces Direct
var init_couleur_acces_direct_fond = "D6EACA";
var init_couleur_acces_direct_titre = "51B169";
var init_couleur_acces_direct_bordures = "999";

//menu
var init_couleur_menu = "82ADE2";
var init_couleur_sousmenu = "90B5D3";
var init_couleur_sousmenusurvole = "E5EFF8";

//cadre inférieur
var init_couleur_pied = "D6EACA";

//cadre inférieur
var init_couleur_footer = "000";

//Fond du site
var init_couleur_fond = "FFFFFF"; 


//variables liées aux précédentes

//cadre derniers articles
var couleur_last_articles_fond_r = init_couleur_last_articles_fond.substring(0,2);
var couleur_last_articles_fond_g = init_couleur_last_articles_fond.substring(2,4);
var couleur_last_articles_fond_b = init_couleur_last_articles_fond.substring(4,6);
var couleur_last_articles_fond_rgb = "" + couleur_last_articles_fond_r + couleur_last_articles_fond_g + couleur_last_articles_fond_b;

var couleur_last_articles_titre_r = init_couleur_last_articles_titre.substring(0,2);
var couleur_last_articles_titre_g = init_couleur_last_articles_titre.substring(2,4);
var couleur_last_articles_titre_b = init_couleur_last_articles_titre.substring(4,6);
var couleur_last_articles_titre_rgb = "" + couleur_last_articles_titre_r + couleur_last_articles_titre_g + couleur_last_articles_titre_b;

var couleur_last_articles_bordures_r = init_couleur_last_articles_bordures.substring(0,2);
var couleur_last_articles_bordures_g = init_couleur_last_articles_bordures.substring(2,4);
var couleur_last_articles_bordures_b = init_couleur_last_articles_bordures.substring(4,6);
var couleur_last_articles_bordures_rgb = "" + couleur_last_articles_bordures_r + couleur_last_articles_bordures_g + couleur_last_articles_bordures_b;

//cadre edito
var couleur_edito_fond_r = init_couleur_edito_fond.substring(0,2);
var couleur_edito_fond_g = init_couleur_edito_fond.substring(2,4);
var couleur_edito_fond_b = init_couleur_edito_fond.substring(4,6);
var couleur_edito_fond_rgb = "" + couleur_edito_fond_r + couleur_edito_fond_g + couleur_edito_fond_b;

var couleur_edito_titre_r = init_couleur_edito_titre.substring(0,2);
var couleur_edito_titre_g = init_couleur_edito_titre.substring(2,4);
var couleur_edito_titre_b = init_couleur_edito_titre.substring(4,6);
var couleur_edito_titre_rgb = "" + couleur_edito_titre_r + couleur_edito_titre_g + couleur_edito_titre_b;

var couleur_edito_bordures_r = init_couleur_edito_bordures.substring(0,2);
var couleur_edito_bordures_g = init_couleur_edito_bordures.substring(2,4);
var couleur_edito_bordures_b = init_couleur_edito_bordures.substring(4,6);
var couleur_edito_bordures_rgb = "" + couleur_edito_bordures_r + couleur_edito_bordures_g + couleur_edito_bordures_b;

//cadre breves
var couleur_breves_fond_r = init_couleur_breves_fond.substring(0,2);
var couleur_breves_fond_g = init_couleur_breves_fond.substring(2,4);
var couleur_breves_fond_b = init_couleur_breves_fond.substring(4,6);
var couleur_breves_fond_rgb = "" + couleur_breves_fond_r + couleur_breves_fond_g + couleur_breves_fond_b;

var couleur_breves_titre_r = init_couleur_breves_titre.substring(0,2);
var couleur_breves_titre_g = init_couleur_breves_titre.substring(2,4);
var couleur_breves_titre_b = init_couleur_breves_titre.substring(4,6);
var couleur_breves_titre_rgb = "" + couleur_breves_titre_r + couleur_breves_titre_g + couleur_breves_titre_b;

var couleur_breves_bordures_r = init_couleur_breves_bordures.substring(0,2);
var couleur_breves_bordures_g = init_couleur_breves_bordures.substring(2,4);
var couleur_breves_bordures_b = init_couleur_breves_bordures.substring(4,6);
var couleur_breves_bordures_rgb = "" + couleur_breves_bordures_r + couleur_breves_bordures_g + couleur_breves_bordures_b;

//cadre acces_direct
var couleur_acces_direct_fond_r = init_couleur_acces_direct_fond.substring(0,2);
var couleur_acces_direct_fond_g = init_couleur_acces_direct_fond.substring(2,4);
var couleur_acces_direct_fond_b = init_couleur_acces_direct_fond.substring(4,6);
var couleur_acces_direct_fond_rgb = "" + couleur_acces_direct_fond_r + couleur_acces_direct_fond_g + couleur_acces_direct_fond_b;

var couleur_acces_direct_titre_r = init_couleur_acces_direct_titre.substring(0,2);
var couleur_acces_direct_titre_g = init_couleur_acces_direct_titre.substring(2,4);
var couleur_acces_direct_titre_b = init_couleur_acces_direct_titre.substring(4,6);
var couleur_acces_direct_titre_rgb = "" + couleur_acces_direct_titre_r + couleur_acces_direct_titre_g + couleur_acces_direct_titre_b;

var couleur_acces_direct_bordures_r = init_couleur_acces_direct_bordures.substring(0,2);
var couleur_acces_direct_bordures_g = init_couleur_acces_direct_bordures.substring(2,4);
var couleur_acces_direct_bordures_b = init_couleur_acces_direct_bordures.substring(4,6);
var couleur_acces_direct_bordures_rgb = "" + couleur_acces_direct_bordures_r + couleur_acces_direct_bordures_g + couleur_acces_direct_bordures_b;

//Fond du site
var couleur_fond_r = init_couleur_fond.substring(0,2);
var couleur_fond_g = init_couleur_fond.substring(2,4);
var couleur_fond_b = init_couleur_fond.substring(4,6);
var couleur_fond_rgb = "" + couleur_fond_r + couleur_fond_g + couleur_fond_b;

//pied de page
var couleur_footer_r = init_couleur_footer.substring(0,2);
var couleur_footer_g = init_couleur_footer.substring(2,4);
var couleur_footer_b = init_couleur_footer.substring(4,6);
var couleur_footer_rgb = "" + couleur_footer_r + couleur_footer_g + couleur_footer_b;

//cadre inférieur
var couleur_pied_r = init_couleur_pied.substring(0,2);
var couleur_pied_g = init_couleur_pied.substring(2,4);
var couleur_pied_b = init_couleur_pied.substring(4,6);
var couleur_pied_rgb = "" + couleur_pied_r + couleur_pied_g + couleur_pied_b;

//Menu
var couleur_menu_r = init_couleur_menu.substring(0,2);
var couleur_menu_g = init_couleur_menu.substring(2,4);
var couleur_menu_b = init_couleur_menu.substring(4,6);
var couleur_menu_rgb = "" + couleur_menu_r + couleur_menu_g + couleur_menu_b;

//sousmenu
var couleur_sousmenu_r = init_couleur_sousmenu.substring(0,2);
var couleur_sousmenu_g = init_couleur_sousmenu.substring(2,4);
var couleur_sousmenu_b = init_couleur_sousmenu.substring(4,6);
var couleur_sousmenu_rgb = "" + couleur_sousmenu_r + couleur_sousmenu_g + couleur_sousmenu_b;

//sous-menu-survolé
var couleur_sousmenusurvole_r = init_couleur_sousmenusurvole.substring(0,2);
var couleur_sousmenusurvole_g = init_couleur_sousmenusurvole.substring(2,4);
var couleur_sousmenusurvole_b = init_couleur_sousmenusurvole.substring(4,6);
var couleur_sousmenusurvole_rgb = "" + couleur_sousmenusurvole_r + couleur_sousmenusurvole_g + couleur_sousmenusurvole_b;





//tableau des codes hexa
var hexcode_array = new Array('00','11','22','33','44','55','66','77','88','99','AA','BB','CC','DD','EE','FF');

//les fonctions 

//variable pour repérer le bouton coché
function chooserMode(MODE)
{
   if(MODE == "couleur_last_articles_fond") { var RGB = couleur_last_articles_fond_rgb; }
   else if(MODE == "couleur_last_articles_titre") { var RGB = couleur_last_articles_titre_rgb; }
   else if(MODE == "couleur_last_articles_bordures") { var RGB = couleur_last_articles_bordures_rgb; }
   else if(MODE == "couleur_edito_fond") { var RGB = couleur_edito_fond_rgb; }
   else if(MODE == "couleur_edito_titre") { var RGB = couleur_edito_titre_rgb; }
   else if(MODE == "couleur_edito_bordures") { var RGB = couleur_edito_bordures_rgb; }
   else if(MODE == "couleur_breves_fond") { var RGB = couleur_breves_fond_rgb; }
   else if(MODE == "couleur_breves_titre") { var RGB = couleur_breves_titre_rgb; }
   else if(MODE == "couleur_breves_bordures") { var RGB = couleur_breves_bordures_rgb; }
   else if(MODE == "couleur_acces_direct_fond") { var RGB = couleur_acces_direct_fond_rgb; }
   else if(MODE == "couleur_acces_direct_titre") { var RGB = couleur_acces_direct_titre_rgb; }
   else if(MODE == "couleur_acces_direct_bordures") { var RGB = couleur_acces_direct_bordures_rgb; }
   else if(MODE == "couleur_last_messages_fond") { var RGB = couleur_last_messages_fond_rgb; }
   else if(MODE == "couleur_last_messages_titre") { var RGB = couleur_last_messages_titre_rgb; }
   else if(MODE == "couleur_fond") { var RGB = couleur_fond_rgb; }
   else if(MODE == "couleur_pied") { var RGB = couleur_pied_rgb; }
   else if(MODE == "couleur_menu") { var RGB = couleur_menu_rgb; }
   else if(MODE == "couleur_sousmenu") { var RGB = couleur_sousmenu_rgb; }
   else if(MODE == "couleur_sousmenusurvole") { var RGB = couleur_sousmenusurvole_rgb; }
   // Extraction des valeurs R, G et B
   var RR = RGB.substring(0,2);
   var GG = RGB.substring(2,4);
   var BB = RGB.substring(4,6);
   // Surlignage des valeurs choisies
   reColorAndGray(RR,GG,BB);
}

// Choix des couleur par sélection d'une valeur hexadécimale
function colorsOne(RGorB,XX)
{
	//couleur_fond
   if(window.document.pickerform.chooser[0].checked == true)
   {
      if(RGorB == "R") { couleur_fond_r = XX; }
      else if(RGorB == "G") { couleur_fond_g = XX; }
      else if(RGorB == "B") { couleur_fond_b = XX; }
      couleur_fond_rgb = "" + couleur_fond_r + couleur_fond_g + couleur_fond_b;
      window.document.pickerform.couleur_fond.value = couleur_fond_rgb;
      window.document.pickerform.couleur_fond_view.style.backgroundColor = "#"+couleur_fond_rgb;
      reColorAndGray(couleur_fond_r,couleur_fond_g,couleur_fond_b);

	}
   //couleur_last_articles_fond
   else if(window.document.pickerform.chooser[1].checked == true)
   {
      if(RGorB == "R") { couleur_last_articles_fond_r = XX; }
      else if(RGorB == "G") { couleur_last_articles_fond_g = XX; }
      else if(RGorB == "B") { couleur_last_articles_fond_b = XX; }
      couleur_last_articles_fond_rgb = "" + couleur_last_articles_fond_r + couleur_last_articles_fond_g + couleur_last_articles_fond_b;
      window.document.pickerform.couleur_last_articles_fond.value = couleur_last_articles_fond_rgb;
      window.document.pickerform.couleur_last_articles_fond_view.style.backgroundColor = "#"+couleur_last_articles_fond_rgb;
      reColorAndGray(couleur_last_articles_fond_r,couleur_last_articles_fond_g,couleur_last_articles_fond_b);

   }

   //couleur_last_articles_titre
   else if(window.document.pickerform.chooser[2].checked == true)
   {
      if(RGorB == "R") { couleur_last_articles_titre_r = XX; }
      else if(RGorB == "G") { couleur_last_articles_titre_g = XX; }
      else if(RGorB == "B") { couleur_last_articles_titre_b = XX; }
      couleur_last_articles_titre_rgb = "" + couleur_last_articles_titre_r + couleur_last_articles_titre_g + couleur_last_articles_titre_b;
      window.document.pickerform.couleur_last_articles_titre.value = couleur_last_articles_titre_rgb;
      window.document.pickerform.couleur_last_articles_titre_view.style.backgroundColor = "#"+couleur_last_articles_titre_rgb;
      reColorAndGray(couleur_last_articles_titre_r,couleur_last_articles_titre_g,couleur_last_articles_titre_b);
   }

   //couleur_last_articles_bordures
   else if(window.document.pickerform.chooser[3].checked == true)
   {
      if(RGorB == "R") { couleur_last_articles_bordures_r = XX; }
      else if(RGorB == "G") { couleur_last_articles_bordures_g = XX; }
      else if(RGorB == "B") { couleur_last_articles_bordures_b = XX; }
      couleur_last_articles_bordures_rgb = "" + couleur_last_articles_bordures_r + couleur_last_articles_bordures_g + couleur_last_articles_bordures_b;
      window.document.pickerform.couleur_last_articles_bordures.value = couleur_last_articles_bordures_rgb;
      window.document.pickerform.couleur_last_articles_bordures_view.style.backgroundColor = "#"+couleur_last_articles_bordures_rgb;
      reColorAndGray(couleur_last_articles_bordures_r,couleur_last_articles_bordures_g,couleur_last_articles_bordures_b);
   }

   //couleur_edito_fond
   else if(window.document.pickerform.chooser[4].checked == true)
   {
      if(RGorB == "R") { couleur_edito_fond_r = XX; }
      else if(RGorB == "G") { couleur_edito_fond_g = XX; }
      else if(RGorB == "B") { couleur_edito_fond_b = XX; }
      couleur_edito_fond_rgb = "" + couleur_edito_fond_r + couleur_edito_fond_g + couleur_edito_fond_b;
      window.document.pickerform.couleur_edito_fond.value = couleur_edito_fond_rgb;
      window.document.pickerform.couleur_edito_fond_view.style.backgroundColor = "#"+couleur_edito_fond_rgb;
	  reColorAndGray(couleur_edito_fond_r,couleur_edito_fond_g,couleur_edito_fond_b);

   }

   //couleur_edito_titre
   else if(window.document.pickerform.chooser[5].checked == true)
   {
      if(RGorB == "R") { couleur_edito_titre_r = XX; }
      else if(RGorB == "G") { couleur_edito_titre_g = XX; }
      else if(RGorB == "B") { couleur_edito_titre_b = XX; }
      couleur_edito_titre_rgb = "" + couleur_edito_titre_r + couleur_edito_titre_g + couleur_edito_titre_b;
      window.document.pickerform.couleur_edito_titre.value = couleur_edito_titre_rgb;
      window.document.pickerform.couleur_edito_titre_view.style.backgroundColor = "#"+couleur_edito_titre_rgb;
	  reColorAndGray(couleur_edito_titre_r,couleur_edito_titre_g,couleur_edito_titre_b);
   }

   //couleur_edito_bordures
   else if(window.document.pickerform.chooser[6].checked == true)
   {
      if(RGorB == "R") { couleur_edito_bordures_r = XX; }
      else if(RGorB == "G") { couleur_edito_bordures_g = XX; }
      else if(RGorB == "B") { couleur_edito_bordures_b = XX; }
      couleur_edito_bordures_rgb = "" + couleur_edito_bordures_r + couleur_edito_bordures_g + couleur_edito_bordures_b;
      window.document.pickerform.couleur_edito_bordures.value = couleur_edito_bordures_rgb;
      window.document.pickerform.couleur_edito_bordures_view.style.backgroundColor = "#"+couleur_edito_bordures_rgb;
	  reColorAndGray(couleur_edito_bordures_r,couleur_edito_bordures_g,couleur_edito_bordures_b);
   }

   //couleur_breves_fond
   else if(window.document.pickerform.chooser[7].checked == true)
   {
      if(RGorB == "R") { couleur_breves_fond_r = XX; }
      else if(RGorB == "G") { couleur_breves_fond_g = XX; }
      else if(RGorB == "B") { couleur_breves_fond_b = XX; }
      couleur_breves_fond_rgb = "" + couleur_breves_fond_r + couleur_breves_fond_g + couleur_breves_fond_b;
      window.document.pickerform.couleur_breves_fond.value = couleur_breves_fond_rgb;
      window.document.pickerform.couleur_breves_fond_view.style.backgroundColor = "#"+couleur_breves_fond_rgb;
	  reColorAndGray(couleur_breves_fond_r,couleur_breves_fond_g,couleur_breves_fond_b);

   }

   //couleur_breves_titre
   else if(window.document.pickerform.chooser[8].checked == true)
   {
      if(RGorB == "R") { couleur_breves_titre_r = XX; }
      else if(RGorB == "G") { couleur_breves_titre_g = XX; }
      else if(RGorB == "B") { couleur_breves_titre_b = XX; }
      couleur_breves_titre_rgb = "" + couleur_breves_titre_r + couleur_breves_titre_g + couleur_breves_titre_b;
      window.document.pickerform.couleur_breves_titre.value = couleur_breves_titre_rgb;
      window.document.pickerform.couleur_breves_titre_view.style.backgroundColor = "#"+couleur_breves_titre_rgb;
	  reColorAndGray(couleur_breves_titre_r,couleur_breves_titre_g,couleur_breves_titre_b);
   }

   //couleur_breves_bordures
   else if(window.document.pickerform.chooser[9].checked == true)
   {
      if(RGorB == "R") { couleur_breves_bordures_r = XX; }
      else if(RGorB == "G") { couleur_breves_bordures_g = XX; }
      else if(RGorB == "B") { couleur_breves_bordures_b = XX; }
      couleur_breves_bordures_rgb = "" + couleur_breves_bordures_r + couleur_breves_bordures_g + couleur_breves_bordures_b;
      window.document.pickerform.couleur_breves_bordures.value = couleur_breves_bordures_rgb;
      window.document.pickerform.couleur_breves_bordures_view.style.backgroundColor = "#"+couleur_breves_bordures_rgb;
	  reColorAndGray(couleur_breves_bordures_r,couleur_breves_bordures_g,couleur_breves_bordures_b);
   }

   //couleur_acces_direct_fond
   else if(window.document.pickerform.chooser[10].checked == true)
   {
      if(RGorB == "R") { couleur_acces_direct_fond_r = XX; }
      else if(RGorB == "G") { couleur_acces_direct_fond_g = XX; }
      else if(RGorB == "B") { couleur_acces_direct_fond_b = XX; }
      couleur_acces_direct_fond_rgb = "" + couleur_acces_direct_fond_r + couleur_acces_direct_fond_g + couleur_acces_direct_fond_b;
      window.document.pickerform.couleur_acces_direct_fond.value = couleur_acces_direct_fond_rgb;
      window.document.pickerform.couleur_acces_direct_fond_view.style.backgroundColor = "#"+couleur_acces_direct_fond_rgb;
	  reColorAndGray(couleur_acces_direct_fond_r,couleur_acces_direct_fond_g,couleur_acces_direct_fond_b);

   }

   //couleur_acces_direct_titre
   else if(window.document.pickerform.chooser[11].checked == true)
   {
      if(RGorB == "R") { couleur_acces_direct_titre_r = XX; }
      else if(RGorB == "G") { couleur_acces_direct_titre_g = XX; }
      else if(RGorB == "B") { couleur_acces_direct_titre_b = XX; }
      couleur_acces_direct_titre_rgb = "" + couleur_acces_direct_titre_r + couleur_acces_direct_titre_g + couleur_acces_direct_titre_b;
      window.document.pickerform.couleur_acces_direct_titre.value = couleur_acces_direct_titre_rgb;
      window.document.pickerform.couleur_acces_direct_titre_view.style.backgroundColor = "#"+couleur_acces_direct_titre_rgb;
	  reColorAndGray(couleur_acces_direct_titre_r,couleur_acces_direct_titre_g,couleur_acces_direct_titre_b);
   }

   //couleur_acces_direct_bordures
   else if(window.document.pickerform.chooser[12].checked == true)
   {
      if(RGorB == "R") { couleur_acces_direct_bordures_r = XX; }
      else if(RGorB == "G") { couleur_acces_direct_bordures_g = XX; }
      else if(RGorB == "B") { couleur_acces_direct_bordures_b = XX; }
      couleur_acces_direct_bordures_rgb = "" + couleur_acces_direct_bordures_r + couleur_acces_direct_bordures_g + couleur_acces_direct_bordures_b;
      window.document.pickerform.couleur_acces_direct_bordures.value = couleur_acces_direct_bordures_rgb;
      window.document.pickerform.couleur_acces_direct_bordures_view.style.backgroundColor = "#"+couleur_acces_direct_bordures_rgb;
	  reColorAndGray(couleur_acces_direct_bordures_r,couleur_acces_direct_bordures_g,couleur_acces_direct_bordures_b);
   }

   //couleur_pied de page
   else if(window.document.pickerform.chooser[13].checked == true)
   {
      if(RGorB == "R") { couleur_footer_r = XX; }
      else if(RGorB == "G") { couleur_footer_g = XX; }
      else if(RGorB == "B") { couleur_footer_b = XX; }
      couleur_footer_rgb = "" + couleur_footer_r + couleur_footer_g + couleur_footer_b;
      window.document.pickerform.couleur_footer.value = couleur_footer_rgb;
      window.document.pickerform.couleur_footer_view.style.backgroundColor = "#"+couleur_footer_rgb;
	  reColorAndGray(couleur_footer_r,couleur_footer_g,couleur_footer_b);
   }
   
   //couleur_cadre inférieur
   else if(window.document.pickerform.chooser[14].checked == true)
   {
      if(RGorB == "R") { couleur_pied_r = XX; }
      else if(RGorB == "G") { couleur_pied_g = XX; }
      else if(RGorB == "B") { couleur_pied_b = XX; }
      couleur_pied_rgb = "" + couleur_pied_r + couleur_pied_g + couleur_pied_b;
      window.document.pickerform.couleur_pied.value = couleur_pied_rgb;
      window.document.pickerform.couleur_pied_view.style.backgroundColor = "#"+couleur_pied_rgb;
	  reColorAndGray(couleur_pied_r,couleur_pied_g,couleur_pied_b);
   }   
   
   //couleur_menu
   else if(window.document.pickerform.chooser[15].checked == true)
   {
      if(RGorB == "R") { couleur_menu_r = XX; }
      else if(RGorB == "G") { couleur_menu_g = XX; }
      else if(RGorB == "B") { couleur_menu_b = XX; }
      couleur_menu_rgb = "" + couleur_menu_r + couleur_menu_g + couleur_menu_b;
      window.document.pickerform.couleur_menu.value = couleur_menu_rgb;
      window.document.pickerform.couleur_menu_view.style.backgroundColor = "#"+couleur_menu_rgb;
	  reColorAndGray(couleur_menu_r,couleur_menu_g,couleur_menu_b);
   }      
   
   //couleur_sousmenu
   else if(window.document.pickerform.chooser[16].checked == true)
   {
      if(RGorB == "R") { couleur_sousmenu_r = XX; }
      else if(RGorB == "G") { couleur_sousmenu_g = XX; }
      else if(RGorB == "B") { couleur_sousmenu_b = XX; }
      couleur_sousmenu_rgb = "" + couleur_sousmenu_r + couleur_sousmenu_g + couleur_sousmenu_b;
      window.document.pickerform.couleur_sousmenu.value = couleur_sousmenu_rgb;
      window.document.pickerform.couleur_sousmenu_view.style.backgroundColor = "#"+couleur_sousmenu_rgb;
	  reColorAndGray(couleur_sousmenu_r,couleur_sousmenu_g,couleur_sousmenu_b);
   }  
   
   //couleur_sousmenusurvole
   else if(window.document.pickerform.chooser[15].checked == true)
   {
      if(RGorB == "R") { couleur_sousmenusurvole_r = XX; }
      else if(RGorB == "G") { couleur_sousmenusurvole_g = XX; }
      else if(RGorB == "B") { couleur_sousmenusurvole_b = XX; }
      couleur_sousmenusurvole_rgb = "" + couleur_sousmenusurvole_r + couleur_sousmenusurvole_g + couleur_sousmenusurvole_b;
      window.document.pickerform.couleur_sousmenusurvole.value = couleur_sousmenusurvole_rgb;
      window.document.pickerform.couleur_sousmenusurvole_view.style.backgroundColor = "#"+couleur_sousmenusurvole_rgb;
	  reColorAndGray(couleur_sousmenusurvole_r,couleur_sousmenusurvole_g,couleur_sousmenusurvole_b);
   }     
}

function colorsAlltest(RGB)
{
   var RR = RGB.substring(0,2);
   var GG = RGB.substring(2,4);
   var BB = RGB.substring(4,6);
   var couleur="";

  //couleur_fond
   if(window.document.pickerform.chooser[0].checked == true) {couleur="couleur_fond";}   
   else if(window.document.pickerform.chooser[1].checked == true){couleur="couleur_last_articles_fond";}
   else if(window.document.pickerform.chooser[2].checked == true){couleur="couleur_last_articles_titre";}
   else if(window.document.pickerform.chooser[3].checked == true){couleur="couleur_last_articles_bordures";}
   
   color_r=couleur+'_r';
   color_g=couleur+'_g';
   color_b=couleur+'_b';
   color_rgb=couleur+'_rgb'; 
   color_view=couleur+'_view';
      
   color_r = RR; 
   color_g = GG; 
   color_b = BB;
   color_rgb = "" + color_r + color_g + color_b;

   document.getElementById(couleur).value = color_rgb;
   document.getElementById(color_view).style.backgroundColor = "#"+color_rgb;
   reColorAndGray(color_r,color_g,color_b);
}


// Sélection d'une couleurs par clic dans le tableau du nuancier
function colorsAll(RGB)
{
   var RR = RGB.substring(0,2);
   var GG = RGB.substring(2,4);
   var BB = RGB.substring(4,6);

  //couleur_fond
   if(window.document.pickerform.chooser[0].checked == true)
   {
      couleur_fond_r = RR; 
      couleur_fond_g = GG; 
      couleur_fond_b = BB;
      couleur_fond_rgb = "" + couleur_fond_r + couleur_fond_g + couleur_fond_b;
      window.document.pickerform.couleur_fond.value = couleur_fond_rgb;
      window.document.pickerform.couleur_fond_view.style.backgroundColor = "#"+couleur_fond_rgb;
	  reColorAndGray(couleur_fond_r,couleur_fond_g,couleur_fond_b);
   }
   
   //couleur_last_articles_fond
   else if(window.document.pickerform.chooser[1].checked == true)
   {
      couleur_last_articles_fond_r = RR; 
      couleur_last_articles_fond_g = GG; 
      couleur_last_articles_fond_b = BB;
      couleur_last_articles_fond_rgb = "" + couleur_last_articles_fond_r + couleur_last_articles_fond_g + couleur_last_articles_fond_b;
      window.document.pickerform.couleur_last_articles_fond.value = couleur_last_articles_fond_rgb;
      window.document.pickerform.couleur_last_articles_fond_view.style.backgroundColor = "#"+couleur_last_articles_fond_rgb;
	  reColorAndGray(couleur_last_articles_fond_r,couleur_last_articles_fond_g,couleur_last_articles_fond_b);
   }

   //couleur_last_articles_titre
   else if(window.document.pickerform.chooser[2].checked == true)
   {
      couleur_last_articles_titre_r = RR; 
      couleur_last_articles_titre_g = GG; 
      couleur_last_articles_titre_b = BB;
      couleur_last_articles_titre_rgb = "" + couleur_last_articles_titre_r + couleur_last_articles_titre_g + couleur_last_articles_titre_b;
      window.document.pickerform.couleur_last_articles_titre.value = couleur_last_articles_titre_rgb;
      window.document.pickerform.couleur_last_articles_titre_view.style.backgroundColor = "#"+couleur_last_articles_titre_rgb;
	  reColorAndGray(couleur_last_articles_titre_r,couleur_last_articles_titre_g,couleur_last_articles_titre_b);
   }

   //couleur_last_articles_bordures
   else if(window.document.pickerform.chooser[3].checked == true)
   {
      couleur_last_articles_bordures_r = RR; 
      couleur_last_articles_bordures_g = GG; 
      couleur_last_articles_bordures_b = BB;
      couleur_last_articles_bordures_rgb = "" + couleur_last_articles_bordures_r + couleur_last_articles_bordures_g + couleur_last_articles_bordures_b;
      window.document.pickerform.couleur_last_articles_bordures.value = couleur_last_articles_bordures_rgb;
      window.document.pickerform.couleur_last_articles_bordures_view.style.backgroundColor = "#"+couleur_last_articles_bordures_rgb;
	  reColorAndGray(couleur_last_articles_bordures_r,couleur_last_articles_bordures_g,couleur_last_articles_bordures_b);
   }

   //couleur_edito_fond
	else if(window.document.pickerform.chooser[4].checked == true)
   {
      couleur_edito_fond_r = RR; 
      couleur_edito_fond_g = GG; 
      couleur_edito_fond_b = BB;
      couleur_edito_fond_rgb = "" + couleur_edito_fond_r + couleur_edito_fond_g + couleur_edito_fond_b;
      window.document.pickerform.couleur_edito_fond.value = couleur_edito_fond_rgb;
      window.document.pickerform.couleur_edito_fond_view.style.backgroundColor = "#"+couleur_edito_fond_rgb;
	  reColorAndGray(couleur_edito_fond_r,couleur_edito_fond_g,couleur_edito_fond_b);
   }

   //couleur_edito_titre
   else if(window.document.pickerform.chooser[5].checked == true)
   {
      couleur_edito_titre_r = RR; 
      couleur_edito_titre_g = GG; 
      couleur_edito_titre_b = BB;
      couleur_edito_titre_rgb = "" + couleur_edito_titre_r + couleur_edito_titre_g + couleur_edito_titre_b;
      window.document.pickerform.couleur_edito_titre.value = couleur_edito_titre_rgb;
      window.document.pickerform.couleur_edito_titre_view.style.backgroundColor = "#"+couleur_edito_titre_rgb;
	  reColorAndGray(couleur_edito_titre_r,couleur_edito_titre_g,couleur_edito_titre_b);
   }

   //couleur_edito_bordures
   else if(window.document.pickerform.chooser[6].checked == true)
   {
      couleur_edito_bordures_r = RR; 
      couleur_edito_bordures_g = GG; 
      couleur_edito_bordures_b = BB;
      couleur_edito_bordures_rgb = "" + couleur_edito_bordures_r + couleur_edito_bordures_g + couleur_edito_bordures_b;
      window.document.pickerform.couleur_edito_bordures.value = couleur_edito_bordures_rgb;
      window.document.pickerform.couleur_edito_bordures_view.style.backgroundColor = "#"+couleur_edito_bordures_rgb;
	  reColorAndGray(couleur_edito_bordures_r,couleur_edito_bordures_g,couleur_edito_bordures_b);
   }

   //couleur_breves_fond
	else if(window.document.pickerform.chooser[7].checked == true)
   {
      couleur_breves_fond_r = RR; 
      couleur_breves_fond_g = GG; 
      couleur_breves_fond_b = BB;
      couleur_breves_fond_rgb = "" + couleur_breves_fond_r + couleur_breves_fond_g + couleur_breves_fond_b;
      window.document.pickerform.couleur_breves_fond.value = couleur_breves_fond_rgb;
      window.document.pickerform.couleur_breves_fond_view.style.backgroundColor = "#"+couleur_breves_fond_rgb;
	  reColorAndGray(couleur_breves_fond_r,couleur_breves_fond_g,couleur_breves_fond_b);
   }

   //couleur_breves_titre
   else if(window.document.pickerform.chooser[8].checked == true)
   {
      couleur_breves_titre_r = RR; 
      couleur_breves_titre_g = GG; 
      couleur_breves_titre_b = BB;
      couleur_breves_titre_rgb = "" + couleur_breves_titre_r + couleur_breves_titre_g + couleur_breves_titre_b;
      window.document.pickerform.couleur_breves_titre.value = couleur_breves_titre_rgb;
      window.document.pickerform.couleur_breves_titre_view.style.backgroundColor = "#"+couleur_breves_titre_rgb;
	  reColorAndGray(couleur_breves_titre_r,couleur_breves_titre_g,couleur_breves_titre_b);
   }

   //couleur_breves_bordures
   else if(window.document.pickerform.chooser[9].checked == true)
   {
      couleur_breves_bordures_r = RR; 
      couleur_breves_bordures_g = GG; 
      couleur_breves_bordures_b = BB;
      couleur_breves_bordures_rgb = "" + couleur_breves_bordures_r + couleur_breves_bordures_g + couleur_breves_bordures_b;
      window.document.pickerform.couleur_breves_bordures.value = couleur_breves_bordures_rgb;
      window.document.pickerform.couleur_breves_bordures_view.style.backgroundColor = "#"+couleur_breves_bordures_rgb;
	  reColorAndGray(couleur_breves_bordures_r,couleur_breves_bordures_g,couleur_breves_bordures_b);
   }

   //couleur_acces_direct_fond
	else if(window.document.pickerform.chooser[10].checked == true)
   {
      couleur_acces_direct_fond_r = RR; 
      couleur_acces_direct_fond_g = GG; 
      couleur_acces_direct_fond_b = BB;
      couleur_acces_direct_fond_rgb = "" + couleur_acces_direct_fond_r + couleur_acces_direct_fond_g + couleur_acces_direct_fond_b;
      window.document.pickerform.couleur_acces_direct_fond.value = couleur_acces_direct_fond_rgb;
      window.document.pickerform.couleur_acces_direct_fond_view.style.backgroundColor = "#"+couleur_acces_direct_fond_rgb;
	  reColorAndGray(couleur_acces_direct_fond_r,couleur_acces_direct_fond_g,couleur_acces_direct_fond_b);
   }

   //couleur_acces_direct_titre
   else if(window.document.pickerform.chooser[11].checked == true)
   {
      couleur_acces_direct_titre_r = RR; 
      couleur_acces_direct_titre_g = GG; 
      couleur_acces_direct_titre_b = BB;
      couleur_acces_direct_titre_rgb = "" + couleur_acces_direct_titre_r + couleur_acces_direct_titre_g + couleur_acces_direct_titre_b;
      window.document.pickerform.couleur_acces_direct_titre.value = couleur_acces_direct_titre_rgb;
      window.document.pickerform.couleur_acces_direct_titre_view.style.backgroundColor = "#"+couleur_acces_direct_titre_rgb;
	  reColorAndGray(couleur_acces_direct_titre_r,couleur_acces_direct_titre_g,couleur_acces_direct_titre_b);
   }

   //couleur_acces_direct_bordures
   else if(window.document.pickerform.chooser[12].checked == true)
   {
      couleur_acces_direct_bordures_r = RR; 
      couleur_acces_direct_bordures_g = GG; 
      couleur_acces_direct_bordures_b = BB;
      couleur_acces_direct_bordures_rgb = "" + couleur_acces_direct_bordures_r + couleur_acces_direct_bordures_g + couleur_acces_direct_bordures_b;
      window.document.pickerform.couleur_acces_direct_bordures.value = couleur_acces_direct_bordures_rgb;
      window.document.pickerform.couleur_acces_direct_bordures_view.style.backgroundColor = "#"+couleur_acces_direct_bordures_rgb;
	  reColorAndGray(couleur_acces_direct_bordures_r,couleur_acces_direct_bordures_g,couleur_acces_direct_bordures_b);
   }

   
   //couleur_pied de page
   else if(window.document.pickerform.chooser[13].checked == true)
   {
      couleur_footer_r = RR; 
      couleur_footer_g = GG; 
      couleur_footer_b = BB;
      couleur_footer_rgb = "" + couleur_footer_r + couleur_footer_g + couleur_footer_b;
      window.document.pickerform.couleur_footer.value = couleur_footer_rgb;
      window.document.pickerform.couleur_footer_view.style.backgroundColor = "#"+couleur_footer_rgb;
	  reColorAndGray(couleur_footer_r,couleur_footer_g,couleur_footer_b);
   }

   //couleur_cadre-inférieur
   else if(window.document.pickerform.chooser[14].checked == true)
   {
      couleur_pied_r = RR; 
      couleur_pied_g = GG; 
      couleur_pied_b = BB;
      couleur_pied_rgb = "" + couleur_pied_r + couleur_pied_g + couleur_pied_b;
      window.document.pickerform.couleur_pied.value = couleur_pied_rgb;
      window.document.pickerform.couleur_pied_view.style.backgroundColor = "#"+couleur_pied_rgb;
	  reColorAndGray(couleur_pied_r,couleur_pied_g,couleur_pied_b);
   }
   
 	//menu
   else if(window.document.pickerform.chooser[15].checked == true)
   {
      couleur_menu_r = RR; 
      couleur_menu_g = GG; 
      couleur_menu_b = BB;
      couleur_menu_rgb = "" + couleur_menu_r + couleur_menu_g + couleur_menu_b;
      window.document.pickerform.couleur_menu.value = couleur_menu_rgb;
      window.document.pickerform.couleur_menu_view.style.backgroundColor = "#"+couleur_menu_rgb;
	  reColorAndGray(couleur_menu_r,couleur_menu_g,couleur_menu_b);
   }

 	//Sous menu
   else if(window.document.pickerform.chooser[16].checked == true)
   {
      couleur_sousmenu_r = RR; 
      couleur_sousmenu_g = GG; 
      couleur_sousmenu_b = BB;
      couleur_sousmenu_rgb = "" + couleur_sousmenu_r + couleur_sousmenu_g + couleur_sousmenu_b;
      window.document.pickerform.couleur_sousmenu.value = couleur_sousmenu_rgb;
      window.document.pickerform.couleur_sousmenu_view.style.backgroundColor = "#"+couleur_sousmenu_rgb;
	  reColorAndGray(couleur_sousmenu_r,couleur_sousmenu_g,couleur_sousmenu_b);
   }

 	//Sous menu survolé
   else if(window.document.pickerform.chooser[17].checked == true)
   {
      couleur_sousmenusurvole_r = RR; 
      couleur_sousmenusurvole_g = GG; 
      couleur_sousmenusurvole_b = BB;
      couleur_sousmenusurvole_rgb = "" + couleur_sousmenusurvole_r + couleur_sousmenusurvole_g + couleur_sousmenusurvole_b;
      window.document.pickerform.couleur_sousmenusurvole.value = couleur_sousmenusurvole_rgb;
      window.document.pickerform.couleur_sousmenusurvole_view.style.backgroundColor = "#"+couleur_sousmenusurvole_rgb;
	  reColorAndGray(couleur_sousmenusurvole_r,couleur_sousmenusurvole_g,couleur_sousmenusurvole_b);
   }
}


// Surlignage de la couleur
function reColorAndGray(RR,GG,BB)
{
   //recolor codes
   for(var i = 0; i < 16; i++) { window.document.getElementById("R" + hexcode_array[i]).style.backgroundColor = "#ffdddd"; }
   for(var i = 0; i < 16; i++) { window.document.getElementById("G" + hexcode_array[i]).style.backgroundColor = "#ddffdd"; }
   for(var i = 0; i < 16; i++) { window.document.getElementById("B" + hexcode_array[i]).style.backgroundColor = "#ddddff"; }

   //gray out current
   window.document.getElementById("R" + RR).style.backgroundColor = "#bbbbbb";
   window.document.getElementById("G" + GG).style.backgroundColor = "#bbbbbb";
   window.document.getElementById("B" + BB).style.backgroundColor = "#bbbbbb";
}


function fillColorBoxes()
{
   window.document.pickerform.couleur_last_articles_fond.value = couleur_last_articles_fond_rgb;
   window.document.pickerform.couleur_last_articles_titre.value = couleur_last_articles_titre_rgb;
   window.document.pickerform.couleur_last_articles_bordures.value = couleur_last_articles_bordures_rgb;
   window.document.pickerform.couleur_edito_fond.value = couleur_edito_fond_rgb;
   window.document.pickerform.couleur_edito_titre.value = couleur_edito_titre_rgb;
   window.document.pickerform.couleur_edito_bordures.value = couleur_edito_bordures_rgb;
   window.document.pickerform.couleur_breves_fond.value = couleur_breves_fond_rgb;
   window.document.pickerform.couleur_breves_titre.value = couleur_breves_titre_rgb;
   window.document.pickerform.couleur_breves_bordures.value = couleur_breves_bordures_rgb;
   window.document.pickerform.couleur_acces_direct_fond.value = couleur_acces_direct_fond_rgb;
   window.document.pickerform.couleur_acces_direct_titre.value = couleur_acces_direct_titre_rgb;
   window.document.pickerform.couleur_acces_direct_bordures.value = couleur_acces_direct_bordures_rgb;
   window.document.pickerform.couleur_last_messages_fond.value = couleur_last_messages_fond_rgb;
   window.document.pickerform.couleur_last_messages_titre.value = couleur_last_messages_titre_rgb;
   window.document.pickerform.couleur_fond.value = couleur_fond_rgb;
   window.document.pickerform.couleur_pied.value = couleur_pied_rgb;
   window.document.pickerform.couleur_menu.value = couleur_menu_rgb;
   window.document.pickerform.couleur_sousmenu.value = couleur_sousmenu_rgb;
   window.document.pickerform.couleur_sousmenusurvole.value = couleur_sousmenusurvole_rgb;
}
