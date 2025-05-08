<?php

if ( ! class_exists( 'ECNCalendarFeedTheEventsCalendar' ) ) {
    class ECNCalendarFeedTheEventsCalendar extends ECNCalendarFeed {

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
            'location_phone',
            'location_website',
            'location_names',
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
            'featured',
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
            global $post;
            $retval = [];

            $args = apply_filters( 'ecn_fetch_events_args-' . $this->get_identifier(), [ 'posts_per_page' => -1, 'hide_upcoming' => true, 'post_status' => 'publish', 'meta_query' => [ 'relation' => 'AND', [ 'key' => '_EventEndDate', 'value' => [ wp_date( 'Y-m-d H:i', $start_date ), wp_date( 'Y-m-d H:i', $end_date ) ], 'compare' => 'BETWEEN', 'type' => 'DATETIME' ] ] ], $start_date, $end_date, $data );
            $events = tribe_get_events( $args );

            foreach ( $events as $post ) {
                setup_postdata( $post );
                $event = $post;
                do_action( 'tribe_events_inside_before_loop' );
                $current_start_date = tribe_get_start_date( null, true, 'Y-m-d H:i:s' );
                $current_end_date = tribe_get_end_date( null, true, 'Y-m-d H:i:s' );
                $current_start_timestamp = strtotime( $current_start_date );

                if ( ! isset( $data['in_progress_events'] ) || ! $data['in_progress_events'] ) {
                    $timezone = get_post_meta( get_the_ID(), '_EventTimezone', true );

                    if ( $timezone ) {
                        $timezone = get_post_meta( get_the_ID(), '_EventTimezone', true );

                        // Something like UTC+0 is invalid for DateTimeZone, so we'd need to convert.
                        if ( preg_match( '/^UTC([+-])(\d{1,2})(?::(\d{2}))?$/', $timezone, $matches ) ) {
                            $sign  = $matches[1];
                            $hours = str_pad( $matches[2], 2, '0', STR_PAD_LEFT );
                            $mins  = isset( $matches[3] ) ? str_pad( $matches[3], 2, '0', STR_PAD_LEFT ) : '00';

                            $timezone = $sign . $hours . $mins; // e.g. "+0130", "-0045"
                        }

                        $timezone_obj = timezone_open( $timezone );

                        if ( $timezone_obj ) {
                            $current_start_date_obj = date_create( $current_start_date, $timezone_obj );

                            if ( $current_start_date_obj ) {
                                $current_start_timestamp = $current_start_date_obj->getTimestamp();
                            }
                        }
                    }

                    if ( $current_start_timestamp < $start_date ) {
                        continue;
                    }

                    if ( $current_start_timestamp > $end_date ) {
                        break;
                    }
                }
                $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), apply_filters( 'ecn_image_size', 'medium', get_the_ID() ) );

                if ( !empty( $image_src ) ) {
                    $image_url = $image_src[0];
                    $image_alt = get_post_meta( get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true );
                } else {
                    $image_url = $image_alt = false;
                }

                $event_data = [
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
                    'featured' => get_post_meta( get_the_ID(), '_tribe_featured', true ) ? true : false,
                    'gcal_link_url' => ( function_exists( 'tribe_get_gcal_link' ) ? Tribe__Events__Main::instance()->esc_gcal_url( tribe_get_gcal_link() ) : '' ),
                    'ical_link_url' => ( function_exists( 'tribe_get_single_ical_link' ) ? esc_url( tribe_get_single_ical_link() ) : '' ),
                    'recurrence_text' => ( function_exists( 'tribe_get_recurrence_text' ) ? tribe_get_recurrence_text() : '' ),
                ];

                if ( function_exists( 'tribe_get_venues' ) ) {
                    $event_data['venues'] = tribe_get_venues( false, -1, true, [ 'event' => $event->ID ] );
                }

                $retval[] = new ECNCalendarEvent( apply_filters( 'ecn_create_calendar_event_args-' . $this->get_identifier(), $event_data, $post ) );
                do_action( 'tribe_events_inside_after_loop' );
            }
            $retval = apply_filters( 'ecn_get_events_retval', $this->sort_events_by_start_date( $retval ), $this, $args, $start_date, $end_date );

            return $retval;
        }

        public function get_description() {
            return 'The Events Calendar';
        }

        public function get_identifier() {
            return 'the-events-calendar';
        }

        public function is_feed_available() {
            return class_exists( 'Tribe__Events__Main' );
        }
    }
}
