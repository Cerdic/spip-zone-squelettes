<?php
/*
Template Name: Links Page
*/
?>
<INCLURE{fond=inclure/head,env} />
<INCLURE{fond=inclure/header,env} />

	<div id="container">
		<div id="content" role="main">

<?php the_post() ?>

			<div id="post-<?php the_ID() ?>" <?php post_class() ?>>
				<h2 class="entry-title"><?php the_title() ?></h2>
				<div class="entry-content">
<?php the_content() ?>

					<ul id="links-page" class="xoxo">
<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>&category_before=<li id="page-%id" class="%class">&after=</li>') ?>

					</ul>
<?php edit_post_link( __( 'Edit', 'erudite' ), '<span class="edit-link">', '</span>' ) ?>

				</div>
			</div><!-- .post -->

<?php if ( post_type_supports('page', 'comments') ) {
	comments_template();
}  ?>

		</div><!-- #content -->
	</div><!-- #container -->

<INCLURE{fond=inclure/sidebar,env} />
<INCLURE{fond=inclure/footer,env} />