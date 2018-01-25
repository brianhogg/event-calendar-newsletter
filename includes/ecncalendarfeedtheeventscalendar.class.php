<?php
if ( ! class_exists( 'ECNCalendarFeedTheEventsCalendar' ) ) {
class ECNCalendarFeedTheEventsCalendar extends ECNCalendarFeed {
    function get_available_format_tags() {
        return array(
            'start_date',
	        'start_time',
            'end_date',
	        'end_time',
            'title',
            'description',
            'excerpt',
            'location_name',
            'location_address',
            'location_city',
            'location_state',
            'location_zip',
            'location_country',
	        'location_phone',
	        'location_website',
            'contact_name',
            'contact_email',
            'contact_website',
            'contact_phone',
	        'organizer_name',
	        'organizer_email',
	        'organizer_website',
	        'organizer_phone',
	        'link',
	        'link_url',
	        'ical_link_url',
	        'gcal_link_url',
            'event_image',
	        'event_image_url',
            'event_cost',
	        'event_website',
	        'categories',
	        'category_links',
	        'tags',
	        'tag_links',
	        'all_day',
	        'recurring',
        );
    }

    /**
     * @param $start_date int
     * @param $end_date int
     * @param $data array
     * @return ECNCalendarEvent[]
     */
    function get_events( $start_date, $end_date, $data = array() ) {
        global $post;
        $retval = array();

	    $events = tribe_get_events( apply_filters( 'ecn_fetch_events_args-' . $this->get_identifier(), array( 'posts_per_page' => -1, 'hide_upcoming' => true, 'post_status' => 'publish', 'start_date' => date( 'Y-m-d H:i', $start_date ), 'end_date' => date( 'Y-m-d H:i', $end_date ) ), $start_date, $end_date, $data ) );

        foreach ( $events as $post ) {
			setup_postdata( $post );
            $event = $post;
            do_action( 'tribe_events_inside_before_loop' );
	        $current_start_date = tribe_get_start_date( null, true, 'Y-m-d H:i:s' );
	        $current_end_date = tribe_get_end_date( null, true, 'Y-m-d H:i:s' );
	        if ( strtotime( $current_start_date ) < $start_date )
		        continue;
	        if ( strtotime( $current_start_date ) > $end_date )
		        break;
            $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), apply_filters( 'ecn_image_size', 'medium', get_the_ID() ) );
            if ( !empty( $image_src ) ) {
                $image_url = $image_src[0];
                $image_alt = get_post_meta( get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true);
            } else {
                $image_url = $image_alt = false;
            }

            $retval[] = new ECNCalendarEvent( apply_filters( 'ecn_create_calendar_event_args-' . $this->get_identifier(), array(
	            'plugin' => $this->get_identifier(),
                'start_date' => $current_start_date,
                'end_date' => $current_end_date,
	            'published_date' => get_the_date( 'Y-m-d H:i:s', $event->ID ),
                'title' => stripslashes_deep( $event->post_title ),
	            'categories' => get_the_terms( $event->ID, 'tribe_events_cat' ),
	            'tags' => get_the_terms( $event->ID, 'post_tag' ),
                'description' => stripslashes_deep( $event->post_content ),
                'excerpt' => stripslashes_deep( $event->post_excerpt ),
                'location_name' => tribe_get_venue(),
                'location_address' => tribe_get_address(),
                'location_city' => tribe_get_city(),
                'location_state' => tribe_get_state(),
                'location_zip' => tribe_get_zip(),
                'location_country' => tribe_get_country(),
	            'location_phone' => tribe_get_phone(),
	            'location_website' => tribe_get_venue_website_url(),
                'contact_name' => tribe_get_organizer(),
                'contact_email' => ( tribe_get_organizer() ? tribe_get_organizer_email() : '' ),
                'contact_website' => ( tribe_get_organizer() ? tribe_get_organizer_website_url() : '' ),
                'contact_phone' => ( tribe_get_organizer() ? tribe_get_organizer_phone() : '' ),
	            'organizer_name' => tribe_get_organizer(),
	            'organizer_email' => ( tribe_get_organizer() ? tribe_get_organizer_email() : '' ),
	            'organizer_website' => ( tribe_get_organizer() ? tribe_get_organizer_website_url() : '' ),
	            'organizer_phone' => ( tribe_get_organizer() ? tribe_get_organizer_phone() : '' ),
                'link' => get_the_permalink(),
                'event_image_url' => $image_url,
                'event_image_alt' => $image_alt,
                'event_cost' => tribe_get_formatted_cost(),
	            'event_website' => ( function_exists( 'tribe_get_event_website_url' ) ? tribe_get_event_website_url() : '' ),
                'all_day' => tribe_event_is_all_day(),
	            'gcal_link_url' => ( function_exists( 'tribe_get_gcal_link' ) ? Tribe__Events__Main::instance()->esc_gcal_url( tribe_get_gcal_link() ) : '' ),
	            'ical_link_url' => ( function_exists( 'tribe_get_single_ical_link' ) ? esc_url( tribe_get_single_ical_link() ) : '' ),
				'recurrence_text' => ( function_exists( 'tribe_get_recurrence_text' ) ? tribe_get_recurrence_text() : '' ),
            ) ) );
            do_action( 'tribe_events_inside_after_loop' );
        }
        return $retval;
    }

    function get_description() {
        return 'The Events Calendar';
    }

    function get_identifier() {
        return 'the-events-calendar';
    }

    function is_feed_available() {
        return is_plugin_active( 'the-events-calendar/the-events-calendar.php' );
    }
}
}