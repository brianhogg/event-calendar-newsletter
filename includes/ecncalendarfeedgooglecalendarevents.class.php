<?php

if ( ! class_exists( 'ECNCalendarFeedGoogleCalendarEvents' ) ) {
    class ECNCalendarFeedGoogleCalendarEvents extends ECNCalendarFeed {

        public function get_available_format_tags() {
            return [
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
        ];
        }

        /**
         * @param $start_date int
         * @param $end_date   int
         *
         * @return ECNCalendarEvent[]
         */
        public function get_events( $start_date, $end_date, $data = [] ) {
            $retval = [];

            // Grab all published calendars
            $calendar_posts = get_posts( apply_filters( 'ecn_fetch_events_args-' . $this->get_identifier(), [ 'post_type' => 'calendar', 'posts_per_page' => 100 ], $start_date, $end_date, $data ) );

            foreach ( $calendar_posts as $calendar_post ) {
                if ( isset( $data['force_fetching'] ) and $data['force_fetching'] ) {
                    // Clear the cache to fetch the latest events
                    simcal_delete_feed_transients( $calendar_post->ID );
                }

                $calendar = simcal_get_calendar( $calendar_post->ID );

                foreach ( $calendar->events as $ymd => $events ) {
                    foreach ( $events as $event ) {
                        // Skip events that are before the start date
                        if ( $event->start_dt->timestamp < $start_date ) {
                            continue;
                        }

                        // Stop when we're at events too far in the future
                        if ( $event->start_dt->timestamp > $end_date ) {
                            break;
                        }

                        $is_existing = false;

                        $event = new ECNCalendarEvent( [
                            'start_date' => ( isset( $event->multiple_days ) && $event->multiple_days > 0 && $event->whole_day ) ? $ymd : $event->start_dt->toDateTimeString(),
                            'end_date' => $event->end_dt->toDateTimeString(),
                            'title' => stripslashes_deep( $event->title ),
                            'description' => stripslashes_deep( $event->description ),
                            'location_name' => $event->start_location['name'],
                            'location_address' => $event->start_location['address'],
                            'link' => $event->link,
                            'all_day' => $event->whole_day,
                        ] );

                        foreach ( $retval as $existing_event ) {
                            if ( $existing_event->get_guid() === $event->get_guid() ) {
                                $is_existing = true;
                                break;
                            }
                        }

                        if ( ! $is_existing ) {
                            $retval[] = $event;
                        }
                    }
                }
            }

            // Sort the results by timestamp, if we have multiple calendars
            uasort( $retval, [ $this, 'cmp_event_date' ] );

            return $retval;
        }

        public function cmp_event_date( $a, $b ) {
            return ( $a->get_start_date() <= $b->get_start_date() ) ? -1 : 1;
        }

        public function get_description() {
            return 'Simple Calendar (Google Calendar Events)';
        }

        public function get_identifier() {
            return 'google-calendar-events';
        }

        public function is_feed_available() {
            // TODO: Switch to something that doesn't depend on is_plugin_active (ie. for Newsletter preview that's not loading admin-init)
            return function_exists( 'is_plugin_active' ) and is_plugin_active( 'google-calendar-events/google-calendar-events.php' );
        }
    }
}
