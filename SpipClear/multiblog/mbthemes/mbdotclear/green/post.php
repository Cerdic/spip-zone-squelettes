<?php
# ***** BEGIN LICENSE BLOCK *****
# This file is part of DotClear.
# Copyright (c) 2004 Olivier Meunier and contributors. All rights
# reserved.
#
# DotClear is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# DotClear is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with DotClear; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****
?>

<div class="post">
	<h2 class="post-title"><?php dcPostTitle(); ?></h2>
	<p class="post-info">Par <?php dcPostAuthor(); ?>,
		<?php dcPostDate(); ?> &agrave; <?php dcPostTime(); ?>
		<a href="<?php dcPostCatURL(); ?>">
		<br/>Cat&eacute;gorie : <?php dcPostCatTitle(); ?></a>
		<span>-</span> <a href="<?php dcPostURL(); ?>"
		title="Lien permanent vers : <?php dcPostTitle(); ?>">#<?php dcPostID(); ?></a>
		<span>-</span> <a href="<?php dcInfo('rss'); ?>?type=co&amp;post=<?php dcPostID(); ?>"
		title="fil RSS des commentaires de : <?php dcPostTitle(); ?>">rss</a>
	</p>
	<?php dcPostChapo('<div class="post-chapo">%s</div>'); ?>
	<div class="post-content"><?php dcPostContent(); ?></div>
</div>

<div id="trackbacks">
	<h3 id="tb">Trackbacks</h3>
	
	<?php /*Le lien pour ajouter un trackback si ceux-ci sont autorisés*/ ?>
	<?php if (dcPostOpenTrackbacks() && dc_allow_trackbacks) : ?>
		<p>Pour faire un trackback sur ce billet&nbsp;:
		<?php echo dcPostTrackBackURI(); ?></p>
	<?php else: ?>
		<p>Les trackbacks pour ce billet sont ferm&eacute;s.</p>
	<?php endif; ?>
	<?php if ($trackbacks->isEmpty()) : /* Message si aucune trackback */?>
		<p>Aucun trackback.</p>
	<?php endif; ?>
	
	<?php while ($trackbacks->fetch()) : /* Liste des trackbacks */
		// On met le numéro du trackback dans une variable
		$tb_num = $trackbacks->int_index+1;
	?>
	<div class="trackback-list">
		<p id="c<?php dcTBID(); ?>" class="comment-info">
		<span class="comment-number"><a href="#c<?php dcTBID(); ?>"><?php echo $tb_num; ?>.</a></span>
		Le <?php dcTBDate(); ?> &agrave;
		<?php dcTBTime(); ?>, de
		<strong><?php dcTBAuthor(); ?></strong></p>
		
		<?php /* on affiche le trackback */ ?>
		<blockquote>
		<?php dcTBContent(); ?>
		</blockquote>
		<p class="linktop"><a href="#debut"><img src="<?php dcInfo('theme'); ?>/images/champi.png" alt="Haut de page" title="Haut de page"/></a></p>
	</div>
	<?php endwhile; ?>
</div>
	
<div id="comments">
	<h3 id="co">Commentaires</h3>
	<?php if ($comments->isEmpty()) : /* Message si aucune commentaire */	?>
		<p>Aucun commentaire pour le moment.</p>
	<?php endif; ?>
	
	<?php while ($comments->fetch()) : /* Boucle de commentaires */
		// On met le numéro du commentaire dans une variable
		$co_num = $comments->int_index+1;
	?>

	<div class="comments-list">
		<p id="c<?php dcCommentID(); ?>" class="comment-info">
		<span class="comment-number"><a href="#c<?php dcCommentID(); ?>"><?php echo $co_num; ?>.</a></span>
		Le <?php dcCommentDate(); ?> &agrave;
		<?php dcCommentTime(); ?>, par
		<strong><?php dcCommentAuthor(); ?></strong>
		</p>
		
		<?php /* on affiche le commentaire */ ?>
		<blockquote>
		<?php dcCommentContent(); ?>
		</blockquote>
		<p class="linktop"><a href="#debut"><img src="<?php dcInfo('theme'); ?>/images/champi.png" alt="Haut de page" title="Haut de page"/></a></p>
	</div>
	
	<?php endwhile; ?>
	
	<div id="add-comment">
		<h3>Ajouter un commentaire</h3>
		<?php if (dcPostOpenComments() && dc_allow_comments) : /* Si les commentaires sont permis */?>
			<?php if (dc_allow_comments) : /* Si les commentaires sont permis */?>
				<?php include dirname(__FILE__).'/form.php'; ?>
			<?php endif; ?>
		<?php else : ?>
			<p>Les commentaires pour ce billet sont ferm&eacute;s.</p>
		<?php endif; ?>
	</div>
</div>
