<?php
if ( ! class_exists( 'ECNCalendarFeedAi1ec' ) ) {
class ECNCalendarFeedAi1ec extends ECNCalendarFeed {
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
            'contact_name',
            'contact_email',
            'contact_website',
            'contact_phone',
            'link',
	        'link_url',
	        'event_website',
            'event_image',
	        'event_image_url',
            'event_cost',
	        'categories',
	        'category_links',
            'all_day',
	        'instant_event',
        );
    }

    /**
     * @param $start_date int
     * @param $end_date int
     * @param $data array
     * @return ECNCalendarEvent[]
     */
    function get_events( $start_date, $end_date, $data = array() ) {
	    global $ai1ec_registry;
        $retval = array();

	    $start_time = $ai1ec_registry->get( 'date.time' );
	    $end_time = $ai1ec_registry->get( 'date.time' );
	    $search = $ai1ec_registry->get( 'model.search' );
	    $settings = $ai1ec_registry->get( 'model.settings' );

	    // Get localized time
	    $start_time->set_date_time( date( 'Y-m-d H:m:s', $start_date ), get_option( 'timezone_string' ) );
	    $end_time->set_date_time( date( 'Y-m-d H:m:s', $end_date ), get_option( 'timezone_string' ) );

	    $filters = array(
		    'cat_ids' => array(),
		    'tag_ids' => array(),
	    );
	    $filters = apply_filters( 'ecn_ai1ec_filters', $filters, $data );
	    $event_results = $search->get_events_between( $start_time, $end_time, $filters );

	    // see app/model/event/entity.php for properties (private vars without initial $_)
	    $post_ids = array();

        foreach ( $event_results as $event ) {
	        $post = get_post( $event->get( 'post_id' ) );

	        if ( apply_filters( 'ecn_ai1ec_recurring_once', false ) and in_array( $post->ID, $post_ids ) )
		        continue;

	        $post_ids[] = $post->ID;

            $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
            if ( !empty( $image_src ) )
                $image_url = $image_src[0];
            else
	            $image_url = false;

	        $permalink = get_the_permalink( $post->ID );
	        if ( $event->get( 'instance_id' ) )
	        	$permalink .= ( ( false !== strpos( $permalink, '?' ) ) ? '&instance_id=' : '?instance_id=' ) . intval( $event->get( 'instance_id' ) );

            $retval[] = new ECNCalendarEvent( array(
                'start_date' => $event->get( 'start' )->format( 'Y-m-d H:i:s', $event->get( 'timezone_name' ) ),
	            'instant_event' => $event->get( 'instant_event' ),
                'end_date' => $event->get( 'end' )->format( 'Y-m-d H:i:s', $event->get( 'timezone_name' ) ),
                'title' => stripslashes_deep( $post->post_title ),
                'description' => stripslashes_deep( $post->post_content ),
                'published_date' => get_the_date( 'Y-m-d H:i:s', $post->ID ),
	            'excerpt' => stripslashes_deep( $post->post_excerpt ),
	            'categories' => get_the_terms( $post->ID, 'events_categories' ),
                'location_name' => $event->get( 'venue' ),
                'location_address' => $event->get( 'address' ),
                'location_city' => $event->get( 'city' ),
                'location_state' => $event->get( 'province' ),
                'location_zip' => $event->get( 'postal_code' ),
                'location_country' => $event->get( 'country' ),
                'contact_name' => $event->get( 'contact_name' ),
                'contact_email' => $event->get( 'contact_email' ),
                'contact_website' => $event->get( 'contact_url' ),
                'contact_phone' => $event->get( 'contact_phone' ),
                'link' => $permalink,
	            'event_website' => $event->get( 'ticket_url' ),
                'event_image_url' => $image_url,
                'event_cost' => ( $event->get( 'is_free' ) ? __( 'FREE', 'event-calendar-newsletter' ) : $event->get( 'cost' ) ),
                'all_day' => $event->get( 'allday' ),
//                'repeat_frequency' => '', $aec_event->repeat_freq,
//                'repeat_interval' => $this->get_repeat_frequency_from_feed_frequency( $aec_event->repeat_int ),
//                'repeat_end' => $aec_event->repeat_end,

            ) );
	        $retval = $this->sort_events_by_start_date( $retval );
        }
        return $retval;
    }

    function get_description() {
        return 'All-in-One Event Calendar';
    }

    function get_identifier() {
        return 'all-in-one-event-calendar';
    }

    function is_feed_available() {
        return is_plugin_active( 'all-in-one-event-calendar/all-in-one-event-calendar.php' );
    }
}
}