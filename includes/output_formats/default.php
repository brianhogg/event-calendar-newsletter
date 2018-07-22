<?php
function ecn_output_format_default( $format, $event, $args, $previous_date ) {
	if ( isset( $args['design'] ) and 'default' == $args['design'] ) {
		$format = "<h2>{title}</h2>\n{if_event_image}<p>{event_image}</p>{/if_event_image}\n<p>{start_date} {if_not_all_day}@ {start_time}{if_end_time} to {end_time}{/if_end_time}{/if_not_all_day}{if_location_name} at {location_name}{/if_location_name}</p>\n<p>{description}</p>\n<p>{link}</p>";
	}
	return $format;
}
add_filter( 'ecn_output_format', 'ecn_output_format_default', 10, 4 );