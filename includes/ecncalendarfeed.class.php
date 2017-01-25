<?php

if ( ! class_exists( 'ECNCalendarFeed' ) ) {
abstract class ECNCalendarFeed {

    protected $REPEAT_DAY;
    protected $REPEAT_WEEK;
    protected $REPEAT_MONTH;
    protected $REPEAT_YEAR;

    /**
     * Translate local feed frequency into
     * @param $frequency
     * @return string
     */
    protected function get_repeat_frequency_from_feed_frequency( $frequency ) {
        switch ( $frequency ) {
            case $this->REPEAT_DAY:
                return ECNCalendarEvent::REPEAT_DAY;
            case $this->REPEAT_WEEK:
                return ECNCalendarEvent::REPEAT_WEEK;
            case $this->REPEAT_MONTH:
                return ECNCalendarEvent::REPEAT_MONTH;
            case $this->REPEAT_YEAR:
                return ECNCalendarEvent::REPEAT_YEAR;
        }
        return false;
    }

    /**
     * Fetch events in the given date range
     *
     * @param $start_date
     * @param $end_date
     * @param $data array
     * @return ECNCalendarEvent[]
     */
    abstract function get_events( $start_date, $end_date, $data = array() );

    /**
     * Sort events by the start date
     * @param $events ECNCalendarEvent[]
     * @return ECNCalendarEvent[]
     */
    function sort_events_by_start_date( $events ) {
        usort( $events, array( $this, 'compare_event_start_date' ) );
        return $events;
    }

    /**
     * @param $a ECNCalendarEvent
     * @param $b ECNCalendarEvent
     *
     * @return int
     */
    function compare_event_start_date( $a, $b ) {
        if ( $a->get_start_date() == $b->get_start_date() )
            return 0;
        return ( $a->get_start_date() < $b->get_start_date() ) ? -1 : 1;
    }

    /**
     * Function to fetch the available format tags for this feed
     *
     * @return array
     */
    abstract function get_available_format_tags();

    /**
     * Fetch description for this calendar feed
     *
     * @return string
     */
    abstract function get_description();

    /**
     * Fetch unique identifier for this calendar feed
     *
     * @return string
     */
    abstract function get_identifier();

	abstract function is_feed_available();
}
}