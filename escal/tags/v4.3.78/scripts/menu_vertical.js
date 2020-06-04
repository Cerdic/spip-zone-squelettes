(function($){
	$(document).ready(function(){

		/*
		 * Menu depliant de navigation
		 */
		$('#menuV li:not(.on) ul').hide();
		$('#menuV li a').hover(function(){
			var me=this;
			var time=400;
			// un temps plus long pour refermer !
			if ($(me).parent().find('>ul').is(':visible')) {
				time=800;
			}

			$(me).addClass('hop');
			setTimeout(function(){
				// verifier que la souris n'est pas deja partie !
				if ($(me).hasClass("hop")) {
					var parent = $(me).parent();
					// verifier que ce n'est pas une liste exposee
					if (!$(parent).hasClass('on')) {
						// fermer les ul
						var ul = $(parent).find('>ul');
						if ($(ul).is(':visible')) {
							$(ul).find('li:not(.on) ul').hide();
							$(ul).slideUp('fast');
						// ou ouvrir le premier
						} else {
							$(ul).slideDown('fast');
						}
					}
				}
			}, time);
		},function(){
			$(this).removeClass('hop');
		});


	});
})(jQuery);

