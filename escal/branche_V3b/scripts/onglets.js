    // Une fois le chargment de la page terminé ...
    $(document).ready(  function()
                        {
                            // Lorsqu'un lien a.tab est cliqué
                            $("a.tab").click(   function () 
                                                {
                                                    // Mettre tous les onglets non actifs
                                                    $(".active").removeClass("active");
                                                    
                                                    // Mettre l'onglet cliqué actif
                                                    $(this).addClass("active");
                                                    
                                                    // Cacher les boîtes de contenu
                                                    $(".content").slideUp();
                                                    
                                                    // Pour afficher la boîte de contenu associé, nous
                                                    // avons modifié le titre du lien par le nom de
                                                    // l'identifiant de la boite de contenu
                                                    var contenu_aff = $(this).attr("name");
                                                    $("." + contenu_aff).slideDown();
                                                }
                                              );
                        }
                    ); 