<?php
if ( ! class_exists( 'ECNCalendarFeedEventOrganiser' ) ) {
class ECNCalendarFeedEventOrganiser extends ECNCalendarFeed {
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
	        'location_website',
            'link',
	        'link_url',
	        'colour',
            'event_image',
	        'event_image_url',
            'event_cost',
	        'categories',
	        'category_links',
	        'all_day',
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

	    $events = eo_get_events( apply_filters( 'ecn_fetch_events_args-' . $this->get_identifier(), array( 'posts_per_page' => 10000, 'post_status' => 'publish', 'event_start_after' => date( 'Y-m-d H:i', $start_date ), 'event_start_before' => date( 'Y-m-d H:i', $end_date ) ), $start_date, $end_date, $data ));

        foreach ( $events as $post ) {
			setup_postdata( $post );
            $event = $post;
	        $current_start_date = eo_get_the_start( 'Y-m-d H:i:s', $post->ID, $post->occurence_id );
	        $current_end_date = eo_get_the_end( 'Y-m-d H:i:s', $post->ID, $post->occurence_id );
	        if ( strtotime( $current_start_date ) < $start_date )
		        continue;
	        if ( strtotime( $current_start_date ) > $end_date )
		        break;
            $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), apply_filters( 'ecn_image_size', 'medium', get_the_ID() ) );
            if ( !empty( $image_src ) )
                $image_url = $image_src[0];
            else
                $image_url = false;

            $address = eo_get_venue_address();
            $retval[] = new ECNCalendarEvent( apply_filters( 'ecn_create_calendar_event_args-' . $this->get_identifier(), array(
	            'plugin' => $this->get_identifier(),
                'start_date' => $current_start_date,
                'end_date' => $current_end_date,
	            'published_date' => get_the_date( 'Y-m-d H:i:s', $event->ID ),
                'title' => stripslashes_deep( $event->post_title ),
	            'categories' => get_the_terms( $event->ID, 'event-category' ),
                'description' => stripslashes_deep( $event->post_content ),
                'excerpt' => stripslashes_deep( $event->post_excerpt ),
                'location_name' => eo_get_venue_name(),
                'location_address' => $address['address'],
                'location_city' => $address['city'],
                'location_state' => $address['state'],
                'location_zip' => $address['postcode'],
                'location_country' => $address['country'],
	            'location_website' => ( !is_wp_error( eo_get_venue_link() ) ? eo_get_venue_link() : '' ),
                'link' => eo_get_permalink(),
                'event_image_url' => $image_url,
	            'colour' => eo_get_event_color(),
                'all_day' => eo_is_all_day(),
            ) ) );
        }
        return $retval;
    }

    function get_description() {
        return 'Event Organiser';
    }

    function get_identifier() {
        return 'event-organiser';
    }

    function is_feed_available() {
        return is_plugin_active( 'event-organiser/event-organiser.php' );
    }
}
}