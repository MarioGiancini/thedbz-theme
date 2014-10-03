<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'The DBZ Official Theme' );
define( 'CHILD_THEME_URL', 'http://thedbz.com/' );
define( 'CHILD_THEME_VERSION', '2.1.2' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );

}

//* Structural Wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer-nav',
	'footer'
) );

//* Add Custom Navs
add_theme_support(
  'genesis-menus', 
	array(
		'primary'   => __( 'Primary Navigation Menu', 'child-domain' ),
		'secondary' => __( 'Secondary Navigation Menu', 'child-domain' ), 
		'top'       => __( 'Top Navigation Menu', 'child-domain' ),
		'footer'	=> __( 'Footer Navigation Menu', 'child-domain' )
	)
);

//* Add support for post formats
add_theme_support( 'post-formats', array(
	'audio',
	'gallery',
	'image',
	'link',
	'quote',
	'video'
) );

/**
 * Utilize Image Post Format to display featured image
 */
add_action( 'genesis_before_entry_content', 'post_format_image_featured' );
function post_format_image_featured() {
	if ( has_post_format( 'image' ) && has_post_thumbnail() && is_singular( 'post' ) ) { 
		$img = genesis_get_image( array( 'format' => 'html', 'size' => genesis_get_option( 'image_size' ), 'attr' => array( 'class' => 'post-image' ) ) );
		printf( '<a href="%s" id="featured-post-image" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	}
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );
