// le javascript / jQuery spécifique median-web

jQuery(document).ready(function() {
  // dans le "rechercher", si le contenu = search, le vider lorsque focus
    jQuery("#recherche").focus(function() {
        if (jQuery(this).val() == "search") jQuery(this).val("");
    });
    
  // dans les images du port-folio ajouter un saut de ligne entre titre et description
/*  ne fonctionne pas avec nyromodal
    jQuery("dt.vignette_pf a").each( function(){
        title = jQuery(this).attr("title");
        title.replace(/\s\s/, "<br />");
        jQuery(this).attr("title", title);
    });
*/
    
});

