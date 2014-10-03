<?php


//* Add the Featured Article section 
add_action( 'genesis_after_header', 'home_featured_articles' );
function home_featured_articles() {

	echo '<div class="home-featured widget-area"><div class="wrap">';

    if (is_active_sidebar( 'home-featured' )) { // sidebar created with simple sidebars plugin
        genesis_widget_area( 'home-featured', array(
            'before' => '<div class="two-thirds featured-single">',
            'after' => '</div>'
            ) );
    }

	if (is_active_sidebar( 'home-featured-2' )) { // sidebar created with simple sidebars plugin
        genesis_widget_area( 'home-featured-2', array(
            'before' => '<div class="one-third featured-double">',
            'after' => '</div>'
            ) );
    }
	
	echo '</div></div>';

}

//* Add the Featured Article section 
add_action( 'genesis_after_header', 'home_featured_columns' );
function home_featured_columns() {

	echo '<div class="home-featured-columns widget-area"><div class="wrap">';

    if (is_active_sidebar( 'home-featured-left' )) { // sidebar created with simple sidebars plugin
        genesis_widget_area( 'home-featured-left', array(
            'before' => '<div class="one-half first featured-column">',
            'after' => '</div>'
            ) );
    }

	if (is_active_sidebar( 'home-featured-right' )) { // sidebar created with simple sidebars plugin
        genesis_widget_area( 'home-featured-right', array(
            'before' => '<div class="one-half last featured-column">',
            'after' => '</div>'
            ) );
    }
	
	echo '</div></div>';

}


genesis();