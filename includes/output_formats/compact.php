<?php
function ecn_output_format_compact( $format, $event, $args, $previous_date ) {
	if ( isset( $args['design'] ) and 'compact' == $args['design'] )
		$format = '<div><strong>{start_date}</strong> - {title} {if_not_all_day}{start_time}{if_end_time}-{end_time}{/if_end_time}{/if_not_all_day} {if_location_name} at {location_name}{/if_location_name}</div>';
	return $format;
}
add_filter( 'ecn_output_format', 'ecn_output_format_compact', 10, 4 );