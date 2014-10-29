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
 * Calculate the time difference - a replacement for `human_time_diff()` until it is improved.
 *
 * Based on BuddyPress function `bp_core_time_since()`, which in turn is based on functions created by
 * Dunstan Orchard - http://1976design.com
 *
 * This function will return an text representation of the time elapsed since a
 * given date, giving the two largest units e.g.:
 *
 *  - 2 hours and 50 minutes
 *  - 4 days
 *  - 4 weeks and 6 days
 *
 * @since 1.7.0
 *
 * @param $older_date int Unix timestamp of date you want to calculate the time since for`
 * @param $newer_date int Optional. Unix timestamp of date to compare older date to. Default false (current time)`
 *
 * @return str The time difference
 */
function dbz_human_time_diff( $older_date, $newer_date = false, $timeunits = 1 ) {

	//* If no newer date is given, assume now
	$newer_date = $newer_date ? $newer_date : time();
	
	$timeunits = ( $timeunits >= 2 ) ? 2 : 1;
	
	//* Difference in seconds
	$since = absint( $newer_date - $older_date );

	if ( ! $since )
		return '0 ' . _x( 'seconds', 'time difference', 'genesis' );

	//* Hold units of time in seconds, and their pluralised strings (not translated yet)
	$units = array(
		array( 31536000, _nx_noop( '%s year', '%s years', 'time difference', 'genesis' ) ),  // 60 * 60 * 24 * 365
		array( 2592000, _nx_noop( '%s month', '%s months', 'time difference', 'genesis' ) ), // 60 * 60 * 24 * 30
		array( 604800, _nx_noop( '%s week', '%s weeks', 'time difference', 'genesis' ) ),    // 60 * 60 * 24 * 7
		array( 86400, _nx_noop( '%s day', '%s days', 'time difference', 'genesis' ) ),       // 60 * 60 * 24
		array( 3600, _nx_noop( '%s hour', '%s hours', 'time difference', 'genesis' ) ),      // 60 * 60
		array( 60, _nx_noop( '%s minute', '%s minutes', 'time difference', 'genesis' ) ),
		array( 1, _nx_noop( '%s second', '%s seconds', 'time difference', 'genesis' ) ),
	);

	//* Step one: the first unit
	for ( $i = 0, $j = count( $units ); $i < $j; $i++ ) {
		$seconds = $units[$i][0];

		//* Finding the biggest chunk (if the chunk fits, break)
		if ( ( $count = floor( $since / $seconds ) ) != 0 )
			break;
	}

	//* Translate unit string, and add to the output
	$output = sprintf( translate_nooped_plural( $units[$i][1], $count, 'genesis' ), $count );

	//* Note the next unit
	$ii = $i + 1;

	//* Step two: the second unit
	if ( $ii < $j && $timeunits > 1) {
		$seconds2 = $units[$ii][0];

		//* Check if this second unit has a value > 0
		if ( ( $count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2 ) ) !== 0 )
			//* Add translated separator string, and translated unit string
			$output .= sprintf( ' %s ' . translate_nooped_plural( $units[$ii][1], $count2, 'genesis' ),	_x( 'and', 'separator in time difference', 'genesis' ),	$count2	);
	}

	return $output;

}

add_shortcode( 'dbz_post_date', 'dbz_post_date_shortcode' );
/**
 * Produces the custom date of post publication.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   label (text following 'before' output, but before date).
 *   untis (number of units to describe the human date)
 *
 * Output passes through 'dbz_post_date_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function dbz_post_date_shortcode( $atts ) {

	$defaults = array(
		'after'		=> '',
		'before'	=> '',
		'label'		=> '',
		'units'		=> 1
	);

	$atts = shortcode_atts( $defaults, $atts, 'dbz_post_date' );

	$display = dbz_human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ), $atts['units'] ) . ' ' . __( 'ago', 'genesis' );

	if ( genesis_html5() )
		$output = sprintf( '<time %s>', genesis_attr( 'entry-time' ) ) . $atts['before'] . $atts['label'] . $display . $atts['after'] . '</time>';
	else
		$output = sprintf( '<span class="date published time" title="%5$s">%1$s%3$s%4$s%2$s</span> ', $atts['before'], $atts['after'], $atts['label'], $display, get_the_time( 'c' ) );

	return apply_filters( 'dbz_post_date_shortcode', $output, $atts );

}
