<?php
if ( ! class_exists( 'ECNCalendarEvent' ) ) {
class ECNCalendarEvent {
	private $_plugin;
	private $_categories = array();
	private $_tags = array();
    private $_start_date;
	private $_published_date;
	private $_instant_event;
    private $_end_date;
    private $_description;
    private $_title;
    private $_location_name;
    private $_location_address;
    private $_location_city;
    private $_location_zip;
    private $_location_state;
    private $_location_country;
    private $_location_website;
	private $_location_phone;
    private $_contact_name;
    private $_contact_info;
    private $_contact_website;
    private $_contact_email;
    private $_contact_phone;
	private $_organizer_name;
	private $_organizer_website;
	private $_organizer_email;
	private $_organizer_phone;
	private $_event_website;
    private $_event_cost;
    private $_excerpt;
    private $_event_image_url;
    private $_event_image_alt;
    private $_all_day;
    private $_link;
	private $_gcal_link_url;
	private $_ical_link_url;
    private $_repeat_frequency;
    private $_repeat_interval;
    private $_repeat_end;
	private $_recurrence_text;
	private $_colour;
	private $_subtitle;
	private $_featured;
	private $_additional_data = array();

    const REPEAT_DAY = 'day';
    const REPEAT_MONTH = 'month';
    const REPEAT_YEAR = 'year';
    const REPEAT_WEEK = 'week';

    public function __construct( array $args = array() ) {
	    if ( isset( $args['plugin'] ) )
		    $this->set_plugin( $args['plugin'] );
	    if ( isset( $args['categories'] ) )
		    $this->set_categories( $args['categories'] );
	    if ( isset( $args['tags'] ) )
	    	$this->set_tags( $args['tags'] );
        if ( isset( $args['start_date'] ) )
            $this->set_start_date( $args['start_date'] );
	    if ( isset( $args['published_date'] ) )
		    $this->set_published_date( $args['published_date'] );
        if ( isset( $args['end_date'] ) )
            $this->set_end_date( $args['end_date'] );
	    if ( isset( $args['instant_event'] ) )
		    $this->set_instant_event( $args['instant_event'] );
        if ( isset( $args['description'] ) )
            $this->set_description( $args['description'] );
        if ( isset( $args['title'] ) )
            $this->set_title( $args['title'] );
        if ( isset( $args['location_name'] ) )
            $this->set_location_name( $args['location_name'] );
        if ( isset( $args['location_address'] ) )
            $this->set_location_address( $args['location_address'] );
        if ( isset( $args['location_city'] ) )
            $this->set_location_city( $args['location_city'] );
        if ( isset( $args['location_state'] ) )
            $this->set_location_state( $args['location_state'] );
        if ( isset( $args['location_zip'] ) )
            $this->set_location_zip( $args['location_zip'] );
        if ( isset( $args['location_country'] ) )
            $this->set_location_country( $args['location_country'] );
        if ( isset( $args['location_website'] ) )
            $this->set_location_website( $args['location_website'] );
	    if ( isset( $args['location_phone'] ) )
		    $this->set_location_phone( $args['location_phone'] );
        if ( isset( $args['contact_name'] ) )
            $this->set_contact_name( $args['contact_name'] );
        if ( isset( $args['contact_info'] ) )
            $this->set_contact_info( $args['contact_info'] );
        if ( isset( $args['contact_website'] ) )
            $this->set_contact_website( $args['contact_website'] );
        if ( isset( $args['contact_phone'] ) )
            $this->set_contact_phone( $args['contact_phone'] );
        if ( isset( $args['contact_email'] ) )
            $this->set_contact_email( $args['contact_email'] );
	    if ( isset( $args['organizer_name'] ) )
		    $this->set_organizer_name( $args['organizer_name'] );
	    if ( isset( $args['organizer_website'] ) )
		    $this->set_organizer_website( $args['organizer_website'] );
	    if ( isset( $args['organizer_phone'] ) )
		    $this->set_organizer_phone( $args['organizer_phone'] );
	    if ( isset( $args['organizer_email'] ) )
		    $this->set_organizer_email( $args['organizer_email'] );
        if ( isset( $args['all_day'] ) )
            $this->set_all_day( $args['all_day'] );
        if ( isset( $args['link'] ) )
            $this->set_link( $args['link'] );
	    if ( isset( $args['gcal_link_url'] ) )
		    $this->set_gcal_link_url( $args['gcal_link_url'] );
	    if ( isset( $args['ical_link_url'] ) )
		    $this->set_ical_link_url( $args['ical_link_url'] );
        if ( isset( $args['event_cost'] ) )
            $this->set_event_cost( $args['event_cost'] );
        if ( isset( $args['event_website'] ) )
            $this->set_event_website( $args['event_website'] );
        if ( isset( $args['excerpt'] ) )
            $this->set_excerpt( $args['excerpt'] );
        if ( isset( $args['event_image_url'] ) )
            $this->set_event_image_url( $args['event_image_url'] );
	    if ( isset( $args['event_image_alt'] ) )
		    $this->set_event_image_alt( $args['event_image_alt'] );
        if ( isset( $args['repeat_frequency'] ) )
            $this->set_repeat_frequency( $args['repeat_frequency'] );
        if ( isset( $args['repeat_interval'] ) )
            $this->set_repeat_interval( $args['repeat_interval'] );
        if ( isset( $args['repeat_end'] ) )
            $this->set_repeat_end( $args['repeat_end'] );
	    if ( isset( $args['recurrence_text'] ) )
	    	$this->set_recurrence_text( $args['recurrence_text'] );
	    if ( isset( $args['colour'] ) )
		    $this->set_colour( $args['colour'] );
	    if ( isset( $args['featured'] ) )
		    $this->set_featured( $args['featured'] );
	    if ( isset( $args['subtitle'] ) )
	    	$this->set_subtitle( $args['subtitle'] );
	    if ( isset( $args['additional_data'] ) )
		    $this->set_additional_data( $args['additional_data'] );
    }

    public static function get_day_text( $number = 1 ) {
        return _n( 'day', 'days', $number, 'event-calendar-newsletter' );
    }

    public static function get_week_text( $number = 1 ) {
        return _n( 'week', 'weeks', $number, 'event-calendar-newsletter' );
    }

    public static function get_month_text( $number = 1 ) {
        return _n( 'month', 'months', $number, 'event-calendar-newsletter' );
    }

    public static function get_year_text( $number = 1 ) {
        return _n( 'year', 'years', $number, 'event-calendar-newsletter' );
    }

    public static function get_available_format_tags( $plugin_slug = false ) {
        $all_tags = array(
            'title' => __( 'Title', 'event-calendar-newsletter' ),
	        'subtitle' => __( 'Subtitle', 'event-calendar-newsletter' ),
            'description' => __( 'Description', 'event-calendar-newsletter' ),
            'start_date' => __( 'Start Date', 'event-calendar-newsletter' ),
            'start_time' => __( 'Start Time', 'event-calendar-newsletter' ),
            'end_date' => __( 'End Date', 'event-calendar-newsletter' ),
            'end_time' => __( 'End Time', 'event-calendar-newsletter' ),
	        'instant_event' => __( 'No End Date Flag', 'event-calendar-newsletter' ),
            'location_name' => __( 'Location Name', 'event-calendar-newsletter' ),
            'location_address' => __( 'Location Address', 'event-calendar-newsletter' ),
            'location_city' => __( 'Location City', 'event-calendar-newsletter' ),
            'location_state' => __( 'Location State', 'event-calendar-newsletter' ),
            'location_zip' => __( 'Location Zip/Postal', 'event-calendar-newsletter' ),
            'location_country' => __( 'Location Country', 'event-calendar-newsletter' ),
            'location_website' => __( 'Location Website', 'event-calendar-newsletter' ),
	        'location_phone' => __( 'Location Phone', 'event-calendar-newsletter' ),
            'contact_name' => __( 'Contact Name', 'event-calendar-newsletter' ),
            'contact_info' => __( 'Contact Info', 'event-calendar-newsletter' ),
            'contact_phone' => __( 'Contact Phone', 'event-calendar-newsletter' ),
            'contact_website' => __( 'Contact Website', 'event-calendar-newsletter' ),
            'contact_email' => __( 'Contact Email', 'event-calendar-newsletter' ),
	        'organizer_name' => __( 'Organizer Name', 'event-calendar-newsletter' ),
            'organizer_email' => __( 'Organizer Email', 'event-calendar-newsletter' ),
            'organizer_website' => __( 'Organizer Website', 'event-calendar-newsletter' ),
            'organizer_phone' => __( 'Organizer Phone', 'event-calendar-newsletter' ),
            'event_cost' => __( 'Event Cost', 'event-calendar-newsletter' ),
	        'event_website' => __( 'Event/Ticket Website', 'event-calendar-newsletter' ),
            'excerpt' => __( 'Excerpt', 'event-calendar-newsletter' ),
            'event_image' => __( 'Event Image', 'event-calendar-newsletter' ),
	        'event_image_url' => __( 'Event Image (URL only)', 'event-calendar-newsletter' ),
            'all_day' => __( 'All Day', 'event-calendar-newsletter' ),
            'link' => __( 'Event Link', 'event-calendar-newsletter' ),
            'link_url' => __( 'Event Link (URL only)', 'event-calendar-newsletter' ),
	        'ical_link_url' => __( 'iCal Link (URL only)', 'event-calendar-newsletter' ),
	        'gcal_link_url' => __( 'Google Calendar Link (URL only)', 'event-calendar-newsletter' ),
            'recurring' => __( 'Recurring Description (if recurring)', 'event-calendar-newsletter' ),
	        'categories' => __( 'Categories', 'event-calendar-newsletter' ),
	        'category_links' => __( 'Category Links', 'event-calendar-newsletter' ),
	        'tags' => __( 'Tags', 'event-calendar-newsletter' ),
	        'tag_links' => __( 'Tag Links', 'event-calendar-newsletter' ),
	        'colour' => __( 'Colour', 'event-calendar-newsletter' ),
	        'featured' => __( 'Featured', 'event-calendar-newsletter' ),
        );

        try {
            $retval = array();
            $feed = ECNCalendarFeedFactory::create( $plugin_slug );
            foreach ( $feed->get_available_format_tags() as $tag ) {
                if ( ! isset( $all_tags[$tag] ) )
                    continue;
                $retval[$tag] = $all_tags[$tag];
            }
        } catch ( Exception $e ) {
            $retval = $all_tags;
        }
        return apply_filters( 'ecn_available_format_tags_display', $retval, $plugin_slug );
    }

    private function sanitize_link( $link ) {
        return $link;
    }
    
    private function sanitize_date( $date ) {
        if ( is_numeric( $date ) )
            return $date;
        elseif ( strtotime( $date ) !== FALSE )
            return strtotime( $date );
        else
            throw new Exception( __( 'Invalid date', 'event-calendar-newsletter' ) );
    }

	public function set_additional_data( $data ) {
		$this->_additional_data = (array) $data;
	}

	public function get_additional_data() {
		return $this->_additional_data;
	}

	public function set_plugin( $plugin ) {
		$this->_plugin = $plugin;
	}

	public function get_plugin() {
		return $this->_plugin;
	}

	public function get_guid() {
		if ( $this->get_link() )
			return md5( $this->get_title() . ' ' . $this->get_link() . ' ' . $this->get_start_date() );
		return md5( $this->get_title() . ' ' . $this->get_start_date() );
	}

	public function set_colour( $colour ) {
		$this->_colour = $colour;
	}

	public function get_colour() {
		return $this->_colour;
	}

	public function set_subtitle( $subtitle ) {
		$this->_subtitle = $subtitle;
	}

	public function get_subtitle() {
		return $this->_subtitle;
	}

	public function set_featured( $featured ) {
		$this->_featured = $featured;
	}

	public function get_featured() {
		return $this->_featured;
	}

	public function set_organizer_phone( $organizer_phone ) {
		$this->_organizer_phone = $organizer_phone;
	}

	public function get_organizer_phone() {
		return $this->_organizer_phone;
	}

	public function set_organizer_website( $organizer_website ) {
		$this->_organizer_website = $organizer_website;
	}

	public function get_organizer_website() {
		return $this->_organizer_website;
	}

	public function set_organizer_email( $organizer_email ) {
		$this->_organizer_email = $organizer_email;
	}

	public function get_organizer_email() {
		return $this->_organizer_email;
	}

	public function set_organizer_name( $organizer_name ) {
		$this->_organizer_name = $organizer_name;
	}

	public function get_organizer_name() {
		return $this->_organizer_name;
	}

	public function set_contact_phone( $contact_phone ) {
        $this->_contact_phone = $contact_phone;
    }

    public function get_contact_phone() {
        return $this->_contact_phone;
    }

    public function set_contact_website( $contact_website ) {
        $this->_contact_website = $contact_website;
    }

    public function get_contact_website() {
        return $this->_contact_website;
    }

    public function set_contact_email( $contact_email ) {
        $this->_contact_email = $contact_email;
    }

    public function get_contact_email() {
        return $this->_contact_email;
    }

    public function set_location_website( $location_website ) {
        $this->_location_website = $location_website;
    }

    public function get_location_website() {
        return $this->_location_website;
    }

	public function set_location_phone( $location_phone ) {
		$this->_location_phone = $location_phone;
	}

	public function get_location_phone() {
		return $this->_location_phone;
	}
    
    public function set_event_website( $event_website ) {
        $this->_event_website = $event_website;
    }

    public function get_event_website() {
        return $this->_event_website;
    }

    public function set_event_cost( $event_cost ) {
        $this->_event_cost = $event_cost;
    }

    public function get_event_cost() {
        return $this->_event_cost;
    }

    public function get_event_image() {
	    if ( $this->get_event_image_url() )
		    return '<img src="' . esc_url( $this->get_event_image_url() ) . '" alt="' . esc_attr( $this->get_event_image_alt() ) . '" />';
	    return '';
    }

	public function set_event_image_alt( $event_image_alt ) {
		$this->_event_image_alt = sanitize_text_field( $event_image_alt );
	}

	public function get_event_image_alt() {
		return $this->_event_image_alt;
	}

    public function set_event_image_url( $event_image_url ) {
        $this->_event_image_url = $event_image_url;
    }


    public function get_event_image_url() {
	    if ( ! $this->_event_image_url ) {
		    preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $this->get_description(), $matches );
		    if ( is_array( $matches) and isset( $matches[1], $matches[1][0] ) and !empty( $matches[1][0] ) )
			    return $matches[1][0];
	    }
        return $this->_event_image_url;
    }

    public function set_excerpt( $excerpt ) {
        $this->_excerpt = $excerpt;
    }

    public function get_excerpt() {
	    if ( ! $this->_excerpt ) {
		    $excerpt = strip_shortcodes( $this->get_description() );
		    $excerpt = strip_tags( $excerpt );
		    return apply_filters( 'ecs_get_excerpt_from_description', apply_filters( 'ecn_get_excerpt', wp_trim_words( $excerpt, apply_filters( 'ecn_get_excerpt_words', 55, $this ), apply_filters( 'ecn_excerpt_more', ' [&hellip;]', $this ) ), $this ), $this );
	    }
        return apply_filters( 'ecn_get_excerpt', $this->_excerpt, $this );
    }

    public function set_recurrence_text( $text ) {
    	$this->_recurrence_text = trim( strip_tags( $text ) );
    }

    public function get_recurrence_text() {
    	return $this->_recurrence_text;
    }

    public function set_repeat_end( $repeat_end ) {
        $this->_repeat_end = $this->sanitize_date( $repeat_end );
    }

    public function get_repeat_end() {
        return date( 'Y-m-d', $this->_repeat_end );
    }

    public function set_repeat_interval( $repeat_interval ) {
        if ( ! in_array( $repeat_interval, array( self::REPEAT_DAY, self::REPEAT_MONTH, self::REPEAT_WEEK, self::REPEAT_YEAR ) ) )
            $this->_repeat_interval = false;
        $this->_repeat_interval = $repeat_interval;
    }

    public function get_repeat_interval() {
        return $this->_repeat_interval;
    }

    public function get_repeat_interval_text( $number = 1 ) {
        return $this->{"get_" . $this->get_repeat_interval() . "_text"}( $number );
    }

    public function set_repeat_frequency( $repeat_frequency ) {
        $this->_repeat_frequency = $repeat_frequency;
    }

    public function get_repeat_frequency() {
        return $this->_repeat_frequency;
    }

    public function set_link( $link ) {
        $this->_link = $link;
    }

    public function get_link() {
        return $this->_link;
    }

	public function set_gcal_link_url( $gcal_link_url ) {
		$this->_gcal_link_url = $gcal_link_url;
	}

	public function get_gcal_link_url() {
		return $this->_gcal_link_url;
	}

	public function set_ical_link_url( $ical_link_url ) {
		$this->_ical_link_url = $ical_link_url;
	}

	public function get_ical_link_url() {
		return $this->_ical_link_url;
	}

	public function set_all_day( $all_day ) {
        $this->_all_day = $all_day ? true : false;
    }

    public function get_all_day() {
        return $this->_all_day;
    }

    public function set_contact_info( $contact_info ) {
        $this->_contact_info = $contact_info;
    }

    public function get_contact_info() {
        return $this->_contact_info;
    }

    public function set_contact_name( $contact_name ) {
        $this->_contact_name = $contact_name;
    }

    public function get_contact_name() {
        return $this->_contact_name;
    }

    public function set_location_country( $location_country ) {
        $this->_location_country = $location_country;
    }

    public function get_location_country() {
        return $this->_location_country;
    }

    public function set_location_zip( $location_zip ) {
        $this->_location_zip = $location_zip;
    }

    public function get_location_zip() {
        return $this->_location_zip;
    }

    public function set_location_state( $location_state ) {
        $this->_location_state = $location_state;
    }

    public function get_location_state() {
        return $this->_location_state;
    }

    public function set_location_city( $location_city ) {
        $this->_location_city = $location_city;
    }

    public function get_location_city() {
        return $this->_location_city;
    }

    public function set_location_name( $location_name ) {
        $this->_location_name = $location_name;
    }

    public function get_location_name() {
        return $this->_location_name;
    }

    public function set_location_address( $location_address ) {
        $this->_location_address = $location_address;
    }

    public function get_location_address() {
        return $this->_location_address;
    }

    public function set_description( $description ) {
        $this->_description = $description;
    }

    public function get_description() {
        return $this->_description;
    }

    public function set_title( $title ) {
        $this->_title = $title;
    }

    public function get_title() {
        return $this->_title;
    }

	public function set_categories( $categories ) {
		if ( is_array( $categories ) )
			$this->_categories = $categories;
	}

	public function get_categories() {
		return $this->_categories;
	}

	public function set_tags( $tags ) {
		if ( is_array( $tags ) )
			$this->_tags = $tags;
	}

	public function get_tags() {
		return $this->_tags;
	}

	public function set_start_date( $start_date ) {
        $this->_start_date = $this->sanitize_date( $start_date );
    }

    public function get_start_date() {
        return $this->_start_date;
    }

	public function set_published_date( $published_date ) {
		$this->_published_date = $this->sanitize_date( $published_date );
	}

	public function get_published_date() {
		return $this->_published_date;
	}


	public function set_end_date( $end_date ) {
        $this->_end_date = $this->sanitize_date( $end_date );
    }

    public function get_end_date() {
        return $this->_end_date;
    }

	public function set_instant_event( $instant_event ) {
		$this->_instant_event = boolval($instant_event);
	}

	public function get_instant_event() {
		return $this->_instant_event;
	}

    public function get_from_format( $format, $options = array() ) {
        $retval = $format;
	    $retval = $this->handle_conditional_tags( $retval, $options );
	    $retval = $this->handle_format_tags( $retval, $options );
        return $retval;
    }

	/**
	 * Handle replacing a conditional tag
     *
	 * @param $tag string - the tag without the {}
	 * @param $condition
	 * @param $output
	 *
	 * @return string $output modified
	 */
	function replace_conditional_tag( $tag, $condition, $output ) {
        while ( false !== strpos( $output, '{' . $tag . '}' ) and
                false !== strpos( $output, '{/' . $tag . '}', strpos( $output, '{' . $tag . '}' ) ) ) {
            if ( $condition ) {
                $output = str_replace( '{' . $tag . '}', '', $output );
                $output = str_replace( '{/' . $tag . '}', '', $output );
            } else {
                // Handle each conditional separate in case they use the same conditional more than once on a page
                $start = strpos( $output, '{' . $tag . '}' );
                $end = strpos( $output, '{/' . $tag . '}', $start ) + strlen( '{/' . $tag . '}' );
                $output = substr_replace( $output, '', $start, $end - $start );
            }
		}
		return $output;
	}

	function handle_conditional_tags( $output, $options = array() ) {
		$output = $this->replace_conditional_tag( 'if_end_time', ( $this->get_end_date() and ! $this->get_instant_event() and ( ! $this->get_all_day() and $this->get_start_date() != $this->get_end_date() or ( $this->get_all_day() and date( 'Y-m-d', $this->get_start_date() ) != date( 'Y-m-d', $this->get_end_date() ) ) ) ), $output );
		$output = $this->replace_conditional_tag( 'if_end_date', ( $this->get_end_date() && date( 'Y-m-d', $this->get_start_date() ) !== date( 'Y-m-d', $this->get_end_date() ) ), $output );

		// No matter what we want to handle all day since the Single Row with Button template uses it
        $output = $this->replace_conditional_tag( 'if_all_day', (bool) $this->get_all_day(), $output );
        $output = $this->replace_conditional_tag( 'if_not_all_day', ! ( (bool) $this->get_all_day() ), $output );

		foreach ( $this->get_available_format_tags( $this->get_plugin() ) as $format_tag => $description ) {
			if ( ! in_array( $format_tag, array( 'end_time', 'end_date', 'all_day' ) ) ) {
				if ( array_key_exists( $format_tag, $this->get_additional_data() ) ) {
					$additional_data = $this->get_additional_data();
					$output = $this->replace_conditional_tag( 'if_' . $format_tag, $additional_data[$format_tag], $output );
					$output = $this->replace_conditional_tag( 'if_not_' . $format_tag, ! $additional_data[$format_tag], $output );
				} elseif ( method_exists( $this, "get_" . $format_tag ) ) {
					$output = $this->replace_conditional_tag( 'if_' . $format_tag, $this->{"get_" . $format_tag}(), $output );
					$output = $this->replace_conditional_tag( 'if_not_' . $format_tag, ! $this->{"get_" . $format_tag}(), $output );
				}
			}
		}
		return $output;
	}

	function get_taxonomy_name( $taxonomy ) {
		return $taxonomy->name;
	}

	function get_category_link( $category ) {
		return '<a href="' . esc_url( get_term_link( $category ) ) . '" alt="' . esc_attr( sprintf( __( 'View all events in %s', 'event-calendar-newsletter' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>';
	}

	function replace_start_date_with_format( $matches ) {
        return date_i18n( $matches[1], $this->get_start_date() );
    }

    function replace_end_date_with_format( $matches ) {
        return date_i18n( $matches[1], $this->get_end_date() );
    }

	function handle_format_tags( $output, $options = array() ) {
		foreach ( apply_filters( 'ecn_available_format_tags', self::get_available_format_tags( $this->get_plugin() ) ) as $tag => $description ) {
			switch ( $tag ) {
				case 'tags':
					$output = str_replace( '{tags}', implode( ', ', array_map( array( $this, 'get_taxonomy_name' ), $this->get_tags() ) ), $output );
					break;
				case 'tag_links':
					$output = str_replace( '{tag_links}', implode( ', ', array_map( array( $this, 'get_category_link' ), $this->get_tags() ) ), $output );
					break;
				case 'categories':
					$output = str_replace( '{categories}', implode( ', ', array_map( array( $this, 'get_taxonomy_name' ), $this->get_categories() ) ), $output );
					break;
				case 'category_links':
					$output = str_replace( '{category_links}', implode( ', ', array_map( array( $this, 'get_category_link' ), $this->get_categories() ) ), $output );
					break;
				case 'start_date':
					$output = str_replace( '{start_date}', apply_filters( 'ecn_start_date_output', date_i18n( apply_filters( 'ecn_start_date_format', get_option( 'date_format' ) ), $this->get_start_date() ), $this, $options ), $output );
                    $output = preg_replace_callback( '/\{start_date\|([^\}]+)\}/', array( $this, 'replace_start_date_with_format' ), $output );
					break;
				case 'start_time':
					$output = str_replace( '{start_time}', apply_filters( 'ecn_start_time_output', date_i18n( apply_filters( 'ecn_start_time_format', get_option( 'time_format' ) ), $this->get_start_date() ), $this, $options ), $output );
                    $output = preg_replace_callback( '/\{start_time\|([^\}]+)\}/', array( $this, 'replace_start_date_with_format' ), $output );
                    break;
				case 'end_date':
					if ( $this->get_instant_event() ) {
						$output = str_replace( '{end_date}', '', $output );
                    } else {
						$output = str_replace( '{end_date}', apply_filters( 'ecn_end_date_output', date_i18n( apply_filters( 'ecn_end_date_format', get_option( 'date_format' ) ), $this->get_end_date() ), $this, $options ), $output );
                        $output = preg_replace_callback( '/\{end_date\|([^\}]+)\}/', array( $this, 'replace_end_date_with_format' ), $output );
                    }
					break;
				case 'end_time':
					if ( $this->get_instant_event() ) {
						$output = str_replace( '{end_time}', '', $output );
                    } else {
						$output = str_replace( '{end_time}', date_i18n( apply_filters( 'ecn_end_time_format', get_option( 'time_format' ) ), $this->get_end_date() ), $output );
                        $output = preg_replace_callback( '/\{end_time\|([^\}]+)\}/', array( $this, 'replace_end_date_with_format' ), $output );
                    }
					break;
				case 'instant_event':
					$output = str_replace( '{instant_event}', ( $this->get_instant_event() ? 'instant' : '' ), $output );
					break;
				case 'all_day':
					if ( $this->get_all_day() )
						$output = str_replace( '{all_day}', __( 'All day', 'event-calendar-newsletter' ), $output );
					else
						$output = str_replace( '{all_day}', '', $output );
					break;
				case 'event_cost':
					if ( $this->get_event_cost() )
						$output = str_replace( '{event_cost}', $this->get_event_cost(), $output );
					else
						$output = str_replace( '{event_cost}', '', $output );
					break;
				case 'recurring':
					if ( $this->get_recurrence_text() )
						$output = str_replace( '{recurring}', $this->get_recurrence_text(), $output );
					elseif ( $this->get_repeat_frequency() > 0 and $this->get_repeat_interval() )
						$output = str_replace( '{recurring}', sprintf( _n( 'Occurs every %s %s', 'Occurs every %s %s', $this->get_repeat_frequency(), 'event-calendar-newsletter' ), $this->get_repeat_frequency(), $this->get_repeat_interval_text( $this->get_repeat_frequency() ) ), $output );
					else
						$output = str_replace( '{recurring}', '', $output );
					break;
				case 'link':
					if ( $this->get_link() )
						$output = str_replace( '{link}', '<a href="' . $this->get_link() . '">'  . apply_filters( 'ecn_event_link_text', __( 'More information', 'event-calendar-newsletter' ) ) . '</a>', $output );
					else
						$output = str_replace( '{link}', '', $output );
					break;
				case 'link_url':
					$output = str_replace( '{link_url}', ( $this->get_link() ? $this->get_link() : '' ), $output );
					break;
				default:
					if ( method_exists( $this, "get_$tag" ) )
						$output = str_replace( '{' . $tag . '}', $this->{"get_$tag"}(), $output );
					elseif ( array_key_exists( $tag, $this->get_additional_data() ) ) {
						$additional_data = $this->get_additional_data();
						$output = str_replace( '{' . $tag . '}', $additional_data[$tag], $output );
					} elseif ( apply_filters( 'ecn_handle_tag_output', false, $tag, $this ) )
						$output = str_replace( '{' . $tag . '}', apply_filters( 'ecn_generate_custom_output', '', $tag, $this ), $output );
			}
		}
		return $output;		
	}
}
}