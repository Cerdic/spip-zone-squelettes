$(function(){ 
    $("#onglets .onglet").hide(); 
    $("#onglets .onglet:eq(0)").show(); 
}); 

$(function(){ 
    $("#onglets .onglet").not(":first").hide(); 
}); 

$(function(){ 
    $("#onglets ul a").click(function(){ 
        $("#onglets .onglet").hide(); 
        $(this.hash).show(); 
        this.blur(); 
        return false; 
    }); 
}); 



$(function(){ 
	$("#test").click(
		function(){
			$('#palette').fadeOut("slow");
			});
	}); 

$(function(){ 
	$("input.colorwell").click(
		function(){
			
			$(this).after($('#palette'));
                         $('#palette').fadeIn("fast");

			})

	}); 


$(function(){ 
	$("a.couleur1").click(
		function(){
			$('#couleur1').fadeIn("slow");
			$("a.couleur1").css({ color: "red", background: "blue" });
			$('#couleur2').fadeOut("fast");
			$("a.couleur2").css({ color: "green", background: "none" });
			$('#couleur3').fadeOut("fast");
			$("a.couleur3").css({ color: "green", background: "none" });
			$('#couleur4').fadeOut("fast");
			$("a.couleur4").css({ color: "green", background: "none" });
			$('#couleur5').fadeOut("fast");
			$("a.couleur5").css({ color: "green", background: "none" });
			$('#couleur6').fadeOut("slow");
			$("a.couleur6").css({ color: "green", background: "none" });
			}
			);
	}); 

$(function(){ 
	$("a.couleur2").click(
		function(){
			$('#couleur2').fadeIn("slow");
			$("a.couleur2").css({ color: "red", background: "blue" });
			$('#couleur1').fadeOut("fast");
			$("a.couleur1").css({ color: "green", background: "none" });
			$('#couleur3').fadeOut("fast");
			$('#couleur4').fadeOut("fast");
			$('#couleur5').fadeOut("fast");
			$('#couleur6').fadeOut("slow");
			$("a.couleur6").css({ color: "green", background: "none" });
			}
			);
	}); 


$(function(){ 
	$("a.couleur3").click(
		function(){
			$('#couleur3').fadeIn("slow");
			$("a.couleur3").css({ color: "red", background: "blue" });
			$('#couleur1').fadeOut("fast");
			$("a.couleur1").css({ color: "green", background: "none" });
			$('#couleur2').fadeOut("fast");
			$("a.couleur2").css({ color: "green", background: "none" });
			$('#couleur5').fadeOut("fast");
			$("a.couleur5").css({ color: "green", background: "none" });
			$('#couleur6').fadeOut("slow");
			$("a.couleur6").css({ color: "green", background: "none" });
			}
			);
	}); 

$(function(){ 
	$("a.couleur5").click(
		function(){
			$('#couleur5').fadeIn("slow");
			$("a.couleur5").css({ color: "red", background: "blue" });
			$('#couleur1').fadeOut("fast");
			$("a.couleur1").css({ color: "green", background: "none" });
			$('#couleur2').fadeOut("fast");
			$("a.couleur2").css({ color: "green", background: "none" });
			$('#couleur3').fadeOut("fast");
			$("a.couleur3").css({ color: "green", background: "none" });
			$('#couleur6').fadeOut("slow");
			$("a.couleur6").css({ color: "green", background: "none" });
			}
			);
	}); 

$(function(){ 
	$("a.couleur6").click(
		function(){
			$('#couleur6').fadeIn("slow");
			$("a.couleur6").css({ color: "red", background: "blue" });
			$('#couleur5').fadeOut("fast");
			$("a.couleur5").css({ color: "green", background: "none" });
			$('#couleur1').fadeOut("fast");
			$("a.couleur1").css({ color: "green", background: "none" });
			$('#couleur2').fadeOut("fast");
			$("a.couleur2").css({ color: "green", background: "none" });
			$('#couleur3').fadeOut("fast");
			$("a.couleur3").css({ color: "green", background: "none" });
			}
			);
	}); 

$(function(){ 
	$("a.mots").click(
		function(){
			$('#mots').fadeIn("slow");
			$("a.mots").css({ color: "red", background: "blue" });
			$('#articles').fadeOut("fast");
			$("a.articles").css({ color: "green", background: "none" });
			}
			);
	}); 
$(function(){ 
	$("a.articles").click(
		function(){
			$('#articles').fadeIn("slow");
			$("a.articles").css({ color: "red", background: "blue" });
			$('#mots').fadeOut("fast");
			$("a.mots").css({ color: "green", background: "none" });
			}
			);
	}); 


$(function(){ 
	$("input").click(
		function(){
			
			$(this).after($('#palette'));
                         $('#palette').fadeIn("fast");

			})

	}); 


$(function(){ 
	$(".vue_bouton input").click(
		function(){
			var $this = $(this);
                if( $this.is('.voir') ) {
                        $this.parent().next().fadeIn("slow");
                        $this.removeClass('voir');
                        $this.addClass('cache');
exit();
		 }
                else {
                         $this.parent().next().fadeOut("slow");
                        $this. removeClass('cache');
                        $this.addClass('voir');
 			exit()	
                }
            
		
			}
			);
	}); 

