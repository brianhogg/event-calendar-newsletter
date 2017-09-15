<?php
if ( ! class_exists( 'ECNCalendarFeedGoogleCalendarEvents' ) ) {
class ECNCalendarFeedGoogleCalendarEvents extends ECNCalendarFeed {
    function get_available_format_tags() {
        return array(
            'start_date',
	        'start_time',
            'end_date',
			'end_time',
            'title',
            'description',
            'location_name',
            'location_address',
            'link',
	        'link_url',
            'all_day',
        );
    }

    /**
     * @param $start_date int
     * @param $end_date int
     * @return ECNCalendarEvent[]
     */
    function get_events( $start_date, $end_date, $data = array() ) {
        $retval = array();

        // Grab all published calendars
        $calendar_posts = get_posts( apply_filters( 'ecn_fetch_events_args-' . $this->get_identifier(), array( 'post_type' => 'calendar', 'posts_per_page' => 100 ), $start_date, $end_date, $data ) );

        foreach ( $calendar_posts as $calendar_post ) {
            if ( isset( $data['force_fetching'] ) and $data['force_fetching'] ) {
                // Clear the cache to fetch the latest events
                simcal_delete_feed_transients( $calendar_post->ID );
            }

            $calendar = simcal_get_calendar( $calendar_post->ID );

            foreach ( $calendar->events as $ymd => $events ) {
	            foreach ( $events as $event ) {
	                // Skip events that are before the start date
	                if ( $event->start_dt->timestamp < $start_date )
	                    continue;

	                // Stop when we're at events too far in the future
	                if ( $event->start_dt->timestamp > $end_date )
	                    break;

	                $retval[] = new ECNCalendarEvent( array(
	                        'start_date' => ( isset( $event->multiple_days ) && $event->multiple_days > 0 && $event->whole_day ) ? $ymd : $event->start_dt->toDateTimeString(),
	                        'end_date' => $event->end_dt->toDateTimeString(),
	                        'title' => stripslashes_deep( $event->title ),
	                        'description' => stripslashes_deep( $event->description ),
	                        'location_name' => $event->start_location['name'],
	                        'location_address' => $event->start_location['address'],
	                        'link' => $event->link,
	                        'all_day' => $event->whole_day,
	                    )
	                );
	            }
            }
        }

        // Sort the results by timestamp, if we have multiple calendars
        uasort( $retval, array( $this, 'cmp_event_date' ) );

        return $retval;
    }

    function cmp_event_date( $a, $b ) {
        return ( $a->get_start_date() <= $b->get_start_date() ) ? -1 : 1;
    }

    function get_description() {
        return 'Simple Calendar (Google Calendar Events)';
    }

    function get_identifier() {
        return 'google-calendar-events';
    }

    function is_feed_available() {
        return is_plugin_active( 'google-calendar-events/google-calendar-events.php' );
    }
}
}