<?php

/****************************************
Theme Helpers
*****************************************/

/**
 * Add capabilities for a custom post type
 */
function dbz_add_capabilities( $posttype ) {
	// gets the author role
	$role = get_role( 'administrator' );

	// adds all capabilities for a given post type to the administrator role
	$role->add_cap( 'edit_' . $posttype . 's' );
	$role->add_cap( 'edit_others_' . $posttype . 's' );
	$role->add_cap( 'publish_' . $posttype . 's' );
	$role->add_cap( 'read_private_' . $posttype . 's' );
	$role->add_cap( 'delete_' . $posttype . 's' );
	$role->add_cap( 'delete_private_' . $posttype . 's' );
	$role->add_cap( 'delete_published_' . $posttype . 's' );
	$role->add_cap( 'delete_others_' . $posttype . 's' );
	$role->add_cap( 'edit_private_' . $posttype . 's' );
	$role->add_cap( 'edit_published_' . $posttype . 's' );
}

/**
 * Shortcode to display current year and company name for copyright
 */
function dbz_shortcode_copyright() {
	$copyright = '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' );
	return $copyright;
}
add_shortcode( 'copyright', 'mb_shortcode_copyright' );

/**
 * Shortcode to display human time instead of date
 */
function set_post_date_human( $atts ) {
    return human_time_diff( get_the_time('U'), current_time('timestamp') );
}
add_shortcode('post_date_human_time', 'set_post_date_human');