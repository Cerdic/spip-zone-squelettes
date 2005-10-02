<?php
/**
* Souligneur syntaxique Delphi
******************************
* D'apres le code originale de FEREY Damien et Dark Skull Software
* publi� sur http://www.phpcs.com/article.aspx?Val=649
* Modifi� par Eric Feldstein (mise sous forme de classe et adapt� � WikiNi)
******************************
* Peut facilement �tre adapt� pour d'autres langages (vb, c, c++...)
* Il suffit de modifier le contenu des variables
*
* @version 1.0
* @copyright FEREY Damien 23/06/2003 
* @copyright Dark Skull Software
*          http://www.darkskull.net
**/


class DelphiHightlighter{

 var $code = ''; //le code a analyser
 var $newcode = ''; //le code genere
 var $tok;            // Le mot en train d'�tre d�coup�
 var $char;        // Le caract�re en cours
 var $i;          // La position en cours dans le code
 var $codelength;  // La longueur de la chaine de code
 /****************************************************************/
 /* Les variables qui d�finissent le comportement de l'analyseur */
 /****************************************************************/
 var $case_sensitive = FALSE;                   // Langage sensible � la case ou pas
 var $tokdelimiters = " []()=+-/*:;,.\n\t\r  "; // Les d�limiteurs de mots

 /***************************************************/
 /* Les couleurs associ�es � chaque type de donn�es */
 /***************************************************/
 var $colorkeyword = "";
 var $colortext = "";
 var $colorstring   = "#000000";
 var $colorcomment = "#FF0000";
 var $colorsymbol   = "";
 var $colornumber   = "#000080";
 var $colorpreproc = "#008000";

 /*************************************************/
 /* Les styles donn�s pour chaque type de donn�es */
 /*************************************************/
 var $stylekeyword = array("<b>", "</b>");
 var $styletext = array("", "");
 var $stylestring   = array("<span style=\"background-color:yellow\">", "</span>");
 var $stylecomment = array("<i>", "</i>");
 var $stylesymbol   = array("", "");
 var $stylenumber   = array("", "");
 var $stylepreproc = array("<i>", "</i>");

 /*****************/
 /* Les mots cl�s */
 /*****************/
 var $keywords = array(
    'unit','interface','implementation','initialization','finalization','uses',
    'type','var','begin','end','with','do','function','procedure','property',
    'to','as','is','while','loop','for','repeat','until','use','class','private',
    'protected','public','published','record','packed','case','of','const','array',
    'try','finally','except','message','if','then','else','out','nil','string',
    'constructor','destructor','library','set','inherited','object','overload',
    'override','virtual','abstract','read','write','default','program','absolute',
    'asm','external','stdcall','resourcestring','downto','exports','inline',
    'raise','goto','label','dispinterface','file','threadvar','not','or','and',
    'xor','mod','shl','shr','div');
 /***********************************/
 /* Les d�limiteurs de commentaires */
 /***********************************/
 var $commentdelimiters = array(
   array("//", "\n"),
   array("{", "}"),
   array("(*", "*)")
 );

 /********************************************/
 /* Les d�limiteurs de chaines de caract�res */
 /********************************************/
 var $stringdelimiters = array(
   array("'", "'")
 );

 /********************************************************/
 /* Les d�limiteurs d'instructions pour le pr�processeur */
 /********************************************************/
 var $preprocdelimiters = array(
   array("(*\$", "*)"),
   array("{\$", "}")
 );

/////////////////////////////////////////////////////////////////////////////////////////
// Le code en lui-m�me
/////////////////////////////////////////////////////////////////////////////////////////

 /************************************************************************/
 /* Renvoie vrai si un caract�re est visible et peut �tre mis en couleur */
 /************************************************************************/
 function visiblechar($char) {
   $inviblechars = " \t\n\r  ";
   return (!is_integer(strpos($inviblechars, $char)));
 }

 /************************************************************/
 /* Formatte un mot d'une mani�re sp�ciale (couleur + style) */
 /************************************************************/
 function formatspecialtok($tok, $color, $style)
 {
   if (empty($color)) return sprintf("%s$tok%s", $style[0], $style[1]);
   return sprintf("%s<font color=\"%s\">$tok</font>%s", $style[0], $color, $style[1]);
 }


 /*******************************************************************/
 /* Recherche un �l�ment dans un tableau sans se soucier de la case */
 /*******************************************************************/
 function array_search_case($needle, $array)
 {
   if (!is_array($array)) return FALSE;
   if (empty($array)) return FALSE;
   foreach($array as $index=>$string)
     if (strcasecmp($needle, $string) == 0) return intval($index);
   return FALSE;
 }


 /*****************************************************/
 /* Analyse un mot et le renvoie de mani�re formatt�e */
 /*****************************************************/
 function analyseword($tok)
 {
   // Si c'est un nombre
   if (($tok[0] == '$') || ($tok[0] == '#') || ($tok == (string)intval($tok)))
     return $this->formatspecialtok($tok, $this->colornumber, $this->stylenumber);
   // Si c'est vide, on renvoie une chaine vide
   if (empty($tok)) return $tok;
   // Si c'est un mot cl�
   if ((($this->case_sensitive) && (is_integer(array_search($tok, $this->keywords, FALSE)))) ||
      ((!$this->case_sensitive) && (is_integer($this->array_search_case($tok, $this->keywords)))))
      return $this->formatspecialtok($tok, $this->colorkeyword, $this->stylekeyword);
   // Sinon, on renvoie le mot sans formattage
   return $this->formatspecialtok($tok, $this->colortext, $this->styletext);
 }


 /***************************************************/
 /* On regarde si on ne tombe pas sur un d�limiteur */
 /***************************************************/
 function parsearray($array, $color = "#000080", $style = array("<i>", "</i>"))
 {
   // On effectue quelques v�rifications
   if (!is_array($array))   return FALSE;
   if (!strlen($this->code))     return FALSE;
   if (!sizeof($array))     return FALSE;

   // On va essayer de comparer le caract�re courrant avec le 1�
   // caract�re de chaque premier d�limiteur
   foreach($array as $delimiterarray) {
     $delimiter1 = $delimiterarray[0];
     // Si le 1� char correspond
     if ($this->char == $delimiter1[0]) {
       $match = TRUE;
       // On va tenter de comparer tous les autres caract�res
       // Pour v�rifier qu'on a bien le d�limiteur complet
       for ($j = 1; ($j < strlen($delimiter1)) && $match; $j++) {
         $match = ($this->code[$this->i + $j] == $delimiter1[$j]);
       } // for
       // Si on l'a en entier
       if ($match) {
         $delimiter2 = $delimiterarray[1];
         // Alors on recherche le d�limiteur de fin
         $delimiterend = strpos($this->code, $delimiter2, $this->i + strlen($delimiter1));
         // Si on ne trouve pas le d�limiteur de fin, on prend tout le fichier
         if (!is_integer($delimiterend)) $delimiterend = strlen($this->code);
         // Maintenant qu'on a tout, on analyse le mot avant le d�limiteur, s'il existe
         if (!empty($this->tok)) {
           $this->newcode .= $this->analyseword($this->tok);
           $this->tok = "";
         }
         // Ensuite, on place le texte contenu entre les d�limiteurs
         $this->newcode .= $this->formatspecialtok(substr($this->code, $this->i, $delimiterend - $this->i + strlen($delimiter2)), $color, $style);
         // On replace l'indice au bon endroit
         $this->i = $delimiterend + strlen($delimiter2);
         // Enfin on r�cup�re le caract�re en cours
         if ($this->i > $this->codelength) $this->char = NULL;
         else $this->char = $this->code[$this->i];
         // On pr�cise qu'on a trouv�
         return TRUE;
       } //if
     } // if
   } // foreach
   return FALSE;
 }


 /******************************/
 /* On traite les cas sp�ciaux */
 /******************************/
 function parsearrays()
 {
   $haschanged = TRUE;
   // A chaque changement, on redemarre la boucle enti�re
   while($haschanged){
     // On regarde si on ne tombe pas sur un d�limiteur de commentaire
     $haschanged = $this->parsearray($this->preprocdelimiters, $this->colorpreproc, $this->stylepreproc);
     if (!$haschanged) {
       // On regarde si on ne tombe pas sur un d�limiteur de commentaire
       $haschanged = $this->parsearray($this->commentdelimiters, $this->colorcomment, $this->stylecomment);
       if (!$haschanged) {
         // Ou de chaine de caract�re
         $haschanged = $this->parsearray($this->stringdelimiters, $this->colorstring, $this->stylestring);
       } // if
     } // if
   } // while
 } // parsearrays


 function dump($var,$name){
//  echo "<pre>$name = \n";
//  print_r($var);
//  echo "</pre><br>";
 }
 function trace($msg){
//  error_log("$msg");
 }
 /***************************/
 /* Analyse un code complet */
 /***************************/
 function analysecode($text)
 {
  // On initialise les variables
  $this->newcode = "";
  $this->tok = "";
  $this->char = NULL;
  $this->code = $text;
  $this->codelength = strlen($this->code);

  $this->trace("debut analysecode");
  $this->dump($this->codelength,"codelength");
  $this->dump($this->code,"code");
  for ($this->i = 0; $this->i < $this->codelength; $this->i++ ) {
   $this->dump($this->i,"i");
   $this->char = $this->code[$this->i];
   $this->dump($this->char,"char");
   // On regarde si on tombe sur un cas sp�cial
   $this->parsearrays();
   // On regarde si on est arriv� au bout de la chaine
   if ($this->char == NULL) return $this->newcode;
   // On a fini d'analyser les commentaires, on regarde si on a un mot complet
   if (is_integer(strpos($this->tokdelimiters, $this->char))) {
    // On tombe sur un d�limiteur, on coupe le mot
    $this->newcode .= $this->analyseword($this->tok);
    // On formatte le d�limiteur
    if ($this->visiblechar($this->char)) $this->newcode .= $this->formatspecialtok($this->char, $this->colorsymbol, $this->stylesymbol);
    else $this->newcode .= $this->char;
    // On remet � 0 le mot en cours
    $this->tok = "";
   }
   else {// On n'a pas de mot complet, on complete le mot
    $this->tok .= $this->char;
   }
  } // for
  // On regarde si on arrive au bout du code
  if (!empty($this->tok)) $this->newcode .= $this->analyseword($this->tok);
  return $this->newcode;
 }
}

/**********************/
/* On analyse le code */
/**********************/
$DH = new DelphiHightlighter();
echo "<pre>".$DH->analysecode($text)."</pre>";
unset($DH);

?>