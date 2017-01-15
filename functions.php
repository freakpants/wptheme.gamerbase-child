<?php 

// Enqueue parent theme css
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function pixie_child_styles(){

	// Enqueue all child theme css
	$parent_style = 'pixiehype-style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style',
	    get_stylesheet_directory_uri() . '/style.css',
	    array( $parent_style ),
	    wp_get_theme()->get('Version')
	);
  
}
add_action('wp_enqueue_scripts', 'pixie_child_styles'); // Add Theme Stylesheet

