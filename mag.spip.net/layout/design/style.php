<?php header("Content-type: text/css; charset: UTF-8");

if($_GET['dir'] == 'rtl') { ?>

	/* Positionnement */
	@import url(position_rtl.css);

	/* Typographie */
	@import url(typographie_rtl.css);

	/* Elements propres a SPIP */
	@import url(spip_rtl.css);

<?php } else { ?>

	/* Positionnement */
	@import url(position.css);

	/* Typographie */
	@import url(typographie.css);

	/* Elements propres a SPIP */
	@import url(spip.css);

<?php } ?>

/* Style des extraits de code (plugin coloration_code) */
@import url(code.css);

/* Style du moteur de recherche */
@import url(recherche.css);

/* Style du moteur de recherche */
@import url(forum.css);

