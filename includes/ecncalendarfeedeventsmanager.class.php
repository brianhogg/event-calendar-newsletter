<?php

if ( ! class_exists( 'ECNCalendarFeedEventsManager' ) ) {
    class ECNCalendarFeedEventsManager extends ECNCalendarFeed {

        public function get_available_format_tags() {
            return [
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
            'event_rsvp_available',
            'link',
            'link_url',
            'event_image',
            'event_image_url',
            'categories',
            'category_links',
            'all_day',
        ];
        }

        /**
         * @param $start_date int
         * @param $end_date   int
         * @param $data       array
         *
         * @return ECNCalendarEvent[]
         */
        public function get_events( $start_date, $end_date, $data = [] ) {
            $retval = [];

            $filters = [
            'category' => [],
            'tag' => [],
            'scope' => wp_date( 'Y-m-d', $start_date ) . ',' . wp_date( 'Y-m-d', $end_date + 86400 ),
        ];
            $event_results = EM_Events::get( apply_filters( 'ecn_fetch_events_args-' . $this->get_identifier(), $filters, $start_date, $end_date, $data ) );

            foreach ( $event_results as $event ) {
                $post = get_post( $event->post_id );
                $location = $event->get_location();
                $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), apply_filters( 'ecn_image_size', 'medium' ) );

                if ( !empty( $image_src ) ) {
                    $image_url = $image_src[0];
                } else {
                    $image_url = false;
                }

                // Skip events that are before the start date
                if ( strtotime( $event->event_start_date . ' ' . $event->event_start_time ) < $start_date ) {
                    continue;
                }

                // Stop when we're at events too far in the future
                if ( strtotime( $event->event_start_date . ' ' . $event->event_start_time ) > $end_date ) {
                    break;
                }

                $retval[] = new ECNCalendarEvent( apply_filters( 'ecn_create_calendar_event_args-' . $this->get_identifier(), [
                'plugin' => $this->get_identifier(),
                'start_date' => $event->event_start_date . ' ' . $event->event_start_time,
                'end_date' => $event->event_end_date . ' ' . $event->event_end_time,
                'published_date' => get_the_date( 'Y-m-d H:i:s', $post->ID ),
                'title' => stripslashes_deep( $event->event_name ),
                'description' => stripslashes_deep( $event->post_content ),
                'excerpt' => stripslashes_deep( $event->post_excerpt ),
                'categories' => get_the_terms( $post->ID, 'event-categories' ),
                'tags' => get_the_terms( $post->ID, 'event-tags' ),
                'location_name' => $location->location_name,
                'location_address' => $location->location_address,
                'location_city' => $location->location_town,
                'location_state' => $location->location_state,
                'location_zip' => $location->location_postcode,
                'location_country' => $location->location_country,
                'contact_name' => $event->event_owner_name,
                'contact_email' => $event->event_owner_email,
                'link' => get_the_permalink( $post->ID ),
                'event_image_url' => $image_url,
                'all_day' => $event->event_all_day,
                'event_rsvp_available' => $event->event_rsvp ? intval( $event->event_rsvp ) : 0,
            ], $post, $event ) );
            }

            return $retval;
        }

        public function get_description() {
            return 'Events Manager';
        }

        public function get_identifier() {
            return 'events-manager';
        }

        public function is_feed_available() {
            return class_exists( 'EM_Events' );
        }
    }
}
