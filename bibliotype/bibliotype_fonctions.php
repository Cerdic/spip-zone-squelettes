<?php

function lettrine_first_para($texte) {

	// <p class="fp">F<span class="sc">rom dreams</span> I...

	$texte = preg_replace('/<p>(\w)(\w*( \w+){2})/msS', '<p class="fp">\1<span class="sc">\2</span>', $texte, 1);

	$texte = preg_replace('/(<\/h3>\s*)<p>(\w)(\w*( \w+){2})/msS', '\1<p class="fp">\2<span class="sc">\3</span>', $texte);

	return $texte;
}