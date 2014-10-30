<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

include_once( get_stylesheet_directory()  . '/lib/theme-helpers.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'The DBZ Official Theme' );
define( 'CHILD_THEME_URL', 'http://thedbz.com/' );
define( 'CHILD_THEME_VERSION', '2.1.2' );

//* Enqueue Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );
	
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );

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
		'primary'   => __( 'Primary Navigation Menu', 'thedbz' ),
		'secondary' => __( 'Secondary Navigation Menu', 'thedbz' ), 
		'top'       => __( 'Top Navigation Menu', 'thedbz' ),
		'footer'	=> __( 'Footer Navigation Menu', 'thedbz' )
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

//* Add new image sizes
add_image_size('dbz-grid', 400, 200, TRUE);
add_image_size('dbz-medium', 600, 300, TRUE);
add_image_size('dbz-large', 800, 400, TRUE);
add_image_size('dbz-xl', 1200, 600, TRUE);

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Allow shortcodes to work in text widget
add_filter('widget_text', 'do_shortcode');

/**
 * Utilize Image Post Format to display featured image on single post
 */
add_action( 'genesis_before_entry_content', 'post_format_image_featured' );
function post_format_image_featured() {
	if ( has_post_format( 'image' ) && has_post_thumbnail() && is_singular( 'post' ) ) { 
		$img = genesis_get_image( array( 'format' => 'html', 'size' => genesis_get_option( 'image_size' ), 'attr' => array( 'class' => 'post-image' ) ) );
		printf( '<a href="%s" id="featured-post-image" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	}
}


/**
 * Custom entry meta in entry header - remove "by" & "edit"
 */
add_filter( 'genesis_post_info', 'dbz_post_info_filter' );
function dbz_post_info_filter($post_info) {
	
	if( is_singular() ) {
		$post_info = '[post_date format="relative"] [post_author_posts_link]';
	    return $post_info;
	} else {
		$post_info = '[dbz_post_date] [post_categories before=""]';
    	return $post_info;
	}

}
 
/**
 * Custom post meta in entry footer - remove text
 */
add_filter( 'genesis_post_meta', 'dbz_filter_post_meta' );
function dbz_filter_post_meta($post_meta) {
    
	if( is_singular() ) {
		$post_meta = '[post_categories before=""] [post_tags before=""]';
    	return $post_meta;
	} else {
		$post_meta = ''; // removed tags: [post_tags before=""]
    	return $post_meta;
	}
}

//* Add Read More Link to Excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
   return '...&nbsp;<a href="' . get_permalink() . '" class="morelink">Keep&nbsp;Reading</a>';
}

