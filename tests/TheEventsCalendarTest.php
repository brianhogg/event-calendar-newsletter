<?php
class TheEventsCalendarTest extends WP_UnitTestCase {

	static $feed;
	static $time;

	static function setUpBeforeClass() {
		self::$time = time();
		
		update_option( 'timezone_string', 'America/New_York' );
		date_default_timezone_set( get_option( 'timezone_string' ) );

		require_once( dirname( __FILE__ ) . '/../../the-events-calendar/the-events-calendar.php' );
		update_option( 'active_plugins', array( 'event-calendar-newsletter/event-calendar-newsletter.php', 'the-events-calendar/the-events-calendar.php' ) );
		Tribe__Events__Main::activate();
		self::$feed = ECNCalendarFeedFactory::create('the-events-calendar');
		self::createSampleEvents();
	}

	static function createSampleEvents() {
		$venue_id = tribe_create_venue( array(
			'post_status' => 'publish',
			'Venue' => 'The Pheasant Plucker',
			'Country' => 'CA',
			'Address' => '20 Augusta St',
			'City' => 'Hamilton',
			'Province' => 'Ontario',
			'Zip' => 'L8N 1P7',
			'Phone' => '(905) 529-9000',
		) );
		$organizer_id = tribe_create_organizer( array(
			'post_status' => 'publish',
			'Organizer' => 'Brian Hogg',
			'Email' => 'brian@brianhogg.com',
			'Website' => 'https://brianhogg.com',
			'Phone' => '905-555-2343',
		) );

		tribe_create_event( array(
			'post_status' => 'publish',
			'post_title' => 'Evening Event',
			'post_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris hendrerit est eu est pellentesque posuere. Donec in nisi commodo, commodo velit a, convallis dui. Pellentesque ut est leo. Phasellus nec lobortis eros. Sed lacus mi, viverra in dolor quis, pharetra sollicitudin felis. Fusce neque massa, porttitor quis velit in, rutrum hendrerit massa. Mauris id diam a sem sollicitudin aliquet. Phasellus lobortis augue pulvinar efficitur sollicitudin. Duis imperdiet a urna a efficitur. Sed at augue ante. Vivamus ut lectus eros. Donec eget quam magna. Sed facilisis, lectus sit amet lacinia fringilla, leo felis congue purus, eget tristique massa risus at ipsum.

Vivamus accumsan lobortis nisl ac laoreet. Donec sem purus, tincidunt vel turpis quis, mattis semper nulla. Sed quis porta est. Aliquam ac tortor at felis elementum convallis. Nulla accumsan felis non dui tempus fermentum. Donec rhoncus, sem eu accumsan semper, ante tellus venenatis ipsum, nec porttitor justo ex non tellus. Vestibulum bibendum, urna mattis mattis lacinia, dui velit tristique erat, sollicitudin dictum risus mauris et dui. Nulla non elit sed tellus elementum dignissim. Nullam sollicitudin magna sed sapien finibus pharetra.

Nunc ut neque mi. Etiam consequat sollicitudin egestas. Nam elementum mollis nulla vitae faucibus. Maecenas eget sapien convallis, viverra felis ac, tristique metus. Nam venenatis erat nisi, vitae venenatis dui suscipit ut. Quisque eleifend ac ex nec elementum. Pellentesque diam augue, commodo ut nunc dapibus, commodo tristique ex. Suspendisse ullamcorper quam sit amet imperdiet ultrices. Aenean cursus metus ac ante auctor, sit amet tristique arcu laoreet. Morbi tempor enim magna, in feugiat sem consectetur vel. Vestibulum leo orci, interdum non maximus in, sagittis consectetur nibh. Sed cursus ex in ante sollicitudin, ac suscipit libero interdum. Curabitur nunc sem, porta a dui in, suscipit pellentesque turpis. Nunc maximus lacus id elit tempor, at gravida metus imperdiet. Sed auctor, mauris sit amet egestas laoreet, quam neque semper justo, nec congue nulla orci eget nunc. Fusce non diam sit amet velit posuere rhoncus quis a elit.',
			'EventStartDate' => date( 'Y-m-d', self::$time + ( 86400 * 2 ) ),
			'EventEndDate' => date( 'Y-m-d', self::$time + ( 86400 * 2 ) ),
			'EventAllDay' => false,
			'EventStartHour' => '06',
			'EventStartMinute' => '30',
			'EventStartMeridian' => 'pm',
			'EventEndHour' => '06',
			'EventEndMinute' => '30',
			'EventEndMeridian' => 'pm',
			'EventHideFromUpcoming' => false,
			'EventShowMapLink' => true,
			'EventShowMap' => true,
			'EventCost' => '50',
			'Venue' => array( 'VenueID' => $venue_id ),
			'Organizer' => array( 'OrganizerID' => $organizer_id ),
		) );

		tribe_create_event( array(
			'post_status' => 'publish',
			'post_title' => 'All day in 4 days',
			'post_content' => 'Nullam nec ex consequat, volutpat justo vel, ullamcorper eros. Aliquam aliquet purus metus, in convallis libero placerat eu. Maecenas molestie blandit libero nec lacinia. Aliquam ac dui eget elit auctor luctus. Proin eget dui eleifend, fringilla metus quis, vestibulum ligula. Phasellus eget lorem ut orci pharetra aliquam. Fusce malesuada dolor ac urna pulvinar lobortis. Curabitur ac leo facilisis, imperdiet purus a, luctus enim. Curabitur iaculis dapibus nunc, in sodales diam gravida sed. Proin et orci maximus, mattis magna quis, hendrerit elit. Nunc rhoncus leo nisi, scelerisque volutpat enim ornare at.',
			'EventStartDate' => date( 'Y-m-d', self::$time + ( 86400 * 4 ) ),
			'EventEndDate' => date( 'Y-m-d', self::$time + ( 86400 * 4 ) ),
			'EventAllDay' => true,
			'EventHideFromUpcoming' => false,
			'EventShowMapLink' => true,
			'EventShowMap' => true,
			'EventCost' => '0',
			'Venue' => array( 'VenueID' => $venue_id ),
			'Organizer' => array( 'OrganizerID' => $organizer_id ),
		) );

		// should not be included, hide from upcoming
		$hidden_event_id = tribe_create_event( array(
			'post_status' => 'publish',
			'post_title' => 'Event to ignore',
			'post_content' => 'Sed egestas libero eu neque sagittis laoreet. Quisque sed tortor ac orci posuere dignissim rutrum sed purus. Curabitur in nisl volutpat, commodo erat vel, ultricies odio. Donec euismod nisi et tortor pretium, a porta tellus sodales. Etiam facilisis, metus vitae ultrices malesuada, lorem turpis ultrices elit, sit amet accumsan ex mi nec mi. Nunc ac elit fermentum ipsum ultricies luctus. Nam non mollis erat. Aliquam egestas sapien sapien, nec suscipit ante lacinia eu. Fusce mollis eu risus a commodo. Nunc pretium id dolor sed volutpat. Suspendisse nec est bibendum, gravida ligula ut, sagittis magna. Nunc quis mauris diam. Aliquam at nulla nec diam pellentesque viverra vel quis purus. Nunc et eros nunc. Suspendisse potenti.',
			'EventStartDate' => date( 'Y-m-d', self::$time + ( 86400 * 6 ) ),
			'EventEndDate' => date( 'Y-m-d', self::$time + ( 86400 * 6 ) ),
			'EventAllDay' => true,
			'EventHideFromUpcoming' => true,
			'EventShowMapLink' => true,
			'EventShowMap' => true,
			'EventCost' => '0',
			'Venue' => array( 'VenueID' => $venue_id ),
			'Organizer' => array( 'OrganizerID' => $organizer_id ),
		) );
		update_post_meta( $hidden_event_id, '_EventHideFromUpcoming', 'yes' );

	}

	function tearDown() {
		parent::tearDown();
		Tribe__Events__Main::deactivate( false );
	}

	function testFeedIsAvailableToECN() {
		$this->assertEquals( 'ECNCalendarFeedTheEventsCalendar', get_class( self::$feed ) );
	}

	/**
	 * Test that we get our two events only (3rd one should be ignored "hide from upcoming")
	 */
	function testFeedReturnsTwoEvents() {
		$events = self::$feed->get_events( time(), time() + ( 86400 * 5 ) );
		$this->assertEquals( 2, count( $events ) );

		// TODO: Test 30 days (or whatever) and should still return 2
		$this->markTestIncomplete();
	}

	/**
	 * Test to make sure process output returns the event output
	 */
	function testProcessOutput() {
		global $ecn_admin_class;

		$data = array(
			'events_future_in_days' => 4,
			'event_calendar' => 'the-events-calendar',
			'format' => '{title} {start_date} {start_time}',
		);
		$output = $ecn_admin_class->process_output( $data );
		$this->assertEquals( "\nEvening Event " . date_i18n( get_option( 'date_format' ), self::$time + ( 86400 * 2 ) ) . " 6:30 pm\nAll day in 4 days " . date_i18n( get_option( 'date_format' ), self::$time + ( 86400 * 4 ) ) . " 12:00 am", $output, 'Should fetch right data output from the events calendar' );
	}
}