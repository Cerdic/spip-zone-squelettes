<?php
//
/**
* Permet d'afficher des liens "Page Suivante" "Sommaire" "Page Precedente" dans une page
*
* Cette action permet de lier des pages entre elle via une page contenant la liste
* ordonnées de ces pages. L'action affiche des liens de navigation permettant de
* passer à la page suivante ou précédente ou de revenir au sommaire.
*
* @param toc string nom de la page contenant la liste ordonnée des pages à liées entre elles
*/

/*
*   Installation :
*  Copiez ce fichier dans le répertoire actions de WikiNi
*  Modifiez ces lignes au fichier wakka.css pour modifier l'ascpect des boutons de navigation:
*  .trail_table {   line-height: 30px;}
*  .trail_button {background-color: transparent; border: medium outset White; border-spacing: 3px;  padding: 2px 10px 2px 10px;}
*/

/* La page sommaire doit contenir une liste de pages. Le premier mot de chaque élément
   de la liste doit être le nom d'une page du wiki, donc un mot wiki ou un lien force
   exemple de page sommaire:

===Sommaire===

 IntroductionAuProjet : présentation du projet.
 [[AnalyseProjet Analyse]] : analyse des besoins
   -BesoinDesUtilisateurs
   -ContraintesTechniques
 OutilsEtNormes

Texte texte  texte texte texte texte texte texte texte texte
texte texte texte texte texte texte texte texte texte texte texte
texte texte texte texte texte texte texte texte texte texte texte texte

*/
# copyrigth Eric Feldstein 2003 mailto:garfield_fr@tiscali.fr
#
# Licence GPL, vous êtes libre d'utiliser et de modifier ce code à condition de
# laisser le copyright d'origine. Vous pouvez  bien sur vous ajouter à la liste
# des auteurs.

# Installation : copier le fichier dans le repertoire "actions" de WikiNi
#
//echo $this->Format("===Action Trail===");
$sommaire = $this->GetParameter("toc");
if (!$sommaire) {
   echo $this->Format("//Indiquez le nom de la page sommaire, paramètre 'toc'//.");
}else{
   //chargement de la page sommaire
   $tocPage = $this->LoadPage($sommaire);
   //analyse de la page sommaire pour récupérer la liste des pages
   //recuperation de la liste
   if (preg_match_all("/\n[\t ]+(.*)/",$tocPage["body"],$tocListe)){
      //analyse de chaque ligne de la liste pour recupérer la page cible
      $currentPageIndex = NULL;
      foreach ($tocListe[1] as $line){
         //suppression d'un signe de liste eventuel
         $line = trim(preg_replace("/^([A-Za-z0-9]+\)|-)/","",$line));
         //recuperation du 1er mot
         $line = preg_replace("/^(\[\[.*\]\]|[A-Za-z0-9]+)\s*(.*)$/","$1",$line);
         //ajout a la liste des pages si le 1er mot est un lien force ou un mot wiki
         if (preg_match("/\[\[.*\]\]/",$line,$match)|$this->IsWikiName($line)){
            $pages[] = $line;
            //regarde si la page ajoute a la liste est la page courante
            if (strcasecmp($this->GetPageTag(),$line)==0){
               $currentPageIndex = count($pages)-1;
            }else {  //traite le cas des lien force
               if (preg_match("/\[\[".$this->GetPageTag()."/",$line)){
                  $currentPageIndex = count($pages)-1;
               }
            }

         }
      }//foreach
   }
   //ecriture des liens Page Précedente/sommaire/page suivante
   if ($currentPageIndex>0) {
      $PrevPage = $pages[$currentPageIndex-1];
      $btnPrev = "<span class=\"trail_button\">".$this->Format("&lt;&lt; $PrevPage")."</span>";
   }else{
      $btnPrev = "&nbsp;";
   }
   $btnTOC = "<span class=\"trail_button\">".$this->Format($sommaire)."</span>";
   if ($currentPageIndex < (count($pages)-1)){
      $NextPage = $pages[$currentPageIndex+1];
      $btnNext = "<span class=\"trail_button\">".$this->Format("$NextPage &gt;&gt;")."</span>";
   }else{
      $btnNext = "&nbsp;";
   }
   echo "<table class=\"trail_table\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n";
   echo "   <tr>\n";
   echo "      <td align=\"left\" width=\"35%\">$btnPrev</td>\n";
   echo "      <td align=\"center\">$btnTOC</td>\n";
   echo "      <td align=\"right\" width=\"35%\">$btnNext</td>\n";
   echo "   </tr>\n";
   echo "</table>\n";
}
?>