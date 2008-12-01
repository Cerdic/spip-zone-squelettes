<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name'=>'MiddleColumn',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="mast">',
        'after_title' => '</h3>',
    ));

	register_sidebar(array(
		'name'=>'RightColumn',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h3 class="mast">',
    	'after_title' => '</h3>',
));
?>