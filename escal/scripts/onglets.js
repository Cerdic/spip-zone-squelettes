    // Une fois le chargment de la page termin� ...
    $(document).ready(  function()
                        {
                            // Lorsqu'un lien a.tab est cliqu�
                            $("a.tab").click(   function () 
                                                {
                                                    // Mettre tous les onglets non actifs
                                                    $(".active").removeClass("active");
                                                    
                                                    // Mettre l'onglet cliqu� actif
                                                    $(this).addClass("active");
                                                    
                                                    // Cacher les bo�tes de contenu
                                                    $(".content").slideUp();
                                                    
                                                    // Pour afficher la bo�te de contenu associ�, nous
                                                    // avons modifi� le titre du lien par le nom de
                                                    // l'identifiant de la boite de contenu
                                                    var contenu_aff = $(this).attr("name");
                                                    $("#" + contenu_aff).slideDown();
                                                }
                                              );
                        }
                    );