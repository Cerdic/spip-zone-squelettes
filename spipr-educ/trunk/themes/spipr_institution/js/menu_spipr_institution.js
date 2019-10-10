$(document).ready(function() {

    // Par defaut on cache les sous-menus
    $('.encart_menu_rub').removeClass('sous_rubrique_active');

    // Fermer le menu
    $(".fermer_menu").click(function() {
        $('div.encart_menu_rub').slideUp();
        return false;
    });

    // Menu racine actif au chargement de la page
    var rubStart = $("#menu_racine li a.on").attr('rel');

    // Click sur menu racine
    $("#menu_racine li a.lien").click(function() {
        var rubOn = $("#menu_racine li a.on").attr('rel'); // Rubrique active
        var rubClick = $(this).attr('rel'); // Rubrique clickée

        // Debug
        var debug = rubStart+' | '+rubClick+' | '+rubOn;

        // Si la rubClick != rubOn 
        if(rubOn != rubClick) {

            $('#menu_racine li, #menu_racine li a').removeClass('on');
            $(this).addClass('on');
            $('#sous_menu .plan_rubrique').fadeOut();
            $("#sous_menu div.encart_menu_rub").slideUp('slow');
            $('#sous_menu .plan_rubrique').fadeIn(2000);
            $("#sous_menu div#"+rubClick).slideDown('slow');
			
			$('#menu_racine .plan_rubrique').fadeOut();
            $("#menu_racine div.encart_menu_rub").slideUp('slow');
            $("#menu_racine div#menudeplie"+rubClick+" .plan_rubrique").fadeIn(2000);
            $("#menu_racine div#menudeplie"+rubClick).slideDown('slow');
            
			$(this).parent('li').addClass('on');
            
            debug = debug+' !=';
            
        } else if(rubOn == rubClick) {

            /* si la rubrique cliquée est la même que la rubrique active,
            on repli ou depli le menu */
            $('#menu_racine li, #menu_racine li a').removeClass('on');
            debug = debug+' ==';
            var rubClickShow = "#sous_menu div#"+rubClick;
			var rubClickShow2 = "#menu_racine div#menudeplie"+rubClick;
            
            if($(rubClickShow).css('display') == 'block') {

                $(rubClickShow).slideUp();

                // si la rubrique de départ est différente de la dernière séléctionnée
                if(rubOn != rubStart) {

                    $('#menu_racine li, #menu_racine li a').removeClass('on');
                    debug = rubStart;

                    // si la rubrique de départ n'est pas la page d'accueil on reactive le menu sur la rubrique d'arrivée
                    if(!isNaN(rubStart)) {
                        $("#menu_racine li a[rel="+rubStart+"]").addClass('on');
                        $("#menu_racine li a[rel="+rubStart+"]").parent('li').addClass('on');
                    }
                    debug = rubStart+$("#menu_racine li a.on").attr('rel');

                }

            } else {

                $(rubClickShow).slideDown();

            }
			
			if($(rubClickShow2).css('display') == 'block') {

                $(rubClickShow2).slideUp();


            } else {

                $(rubClickShow2).slideDown();

            }
            //$("#sous_menu div#"+rubClick).toggle('5000');
            //$('#sous_menu').fade('50');

            
        }

        // Debug
        //$("#debug").html(debug);

        return false;
    });

});
