<?php

if ( ! class_exists( 'ECNCalendarFeedAjaxCalendar' ) ) {
class ECNCalendarFeedAjaxCalendar extends ECNCalendarFeed {
    protected $REPEAT_DAY = 0;
    protected $REPEAT_WEEK = 1;
    protected $REPEAT_MONTH = 2;
    protected $REPEAT_YEAR = 3;

    function get_available_format_tags() {
        return array(
            'start_date',
            'end_date',
            'title',
            'description',
            'location_name',
            'location_address',
            'location_city',
            'location_state',
            'location_zip',
            'location_country',
            'contact_name',
            'contact_info',
            'all_day',
            'link',
            'repeat_frequency',
            'repeat_interval',
            'repeat_end',
        );
    }

    function get_events( $start_date, $end_date, $data = array() ) {
        $retval = array();
        $aec = new ajax_event_calendar();
        $aec_start_date = date( 'Y-m-d', $start_date );
        $aec_end_date = date( 'Y-m-d', $end_date );
        $events = $aec->db_query_events( $aec_start_date, $aec_end_date, false, false );
        foreach( (array) $aec->process_events( $events, $aec_start_date, $aec_end_date, true ) as $event ) {
            $aec_event = $aec->db_query_event( $event['id'] );
            $retval[] = new ECNCalendarEvent( array(
                'start_date' => $event['start'],
                'end_date' => $event['end'],
                'title' => stripslashes_deep( $event['title'] ),
                'description' => stripslashes_deep( $aec_event->description ),
                'location_name' => stripslashes_deep( $aec_event->venue ),
                'location_address' => stripslashes_deep( $aec_event->address ),
                'location_city' => stripslashes_deep( $aec_event->city ),
                'location_state' => stripslashes_deep( $aec_event->state ),
                'location_zip' => stripslashes_deep( $aec_event->zip ),
                'location_country' => stripslashes_deep( $aec_event->country ),
                'contact_name' => stripslashes_deep( $aec_event->contact ),
                'contact_info' => stripslashes_deep( $aec_event->contact_info ),
                'all_day' => ( $aec_event->allDay ? true : false ),
                'link' => stripslashes_deep( $aec_event->link ),
                'repeat_frequency' => $aec_event->repeat_freq,
                'repeat_interval' => $this->get_repeat_frequency_from_feed_frequency( $aec_event->repeat_int ),
                'repeat_end' => $aec_event->repeat_end,
            ) );
        }
        return $retval;
    }

    function get_description() {
        return 'Ajax Event Calendar';
    }

    function get_identifier() {
        return 'ajax-calendar';
    }

    function is_feed_available() {
        return is_plugin_active( 'ajax-event-calendar/ajax-event-calendar.php' );
    }
}
}