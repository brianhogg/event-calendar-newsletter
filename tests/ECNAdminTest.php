<?php
class ECNAdminTest extends WP_UnitTestCase {
	/**
	 * Basic test of generating output from events
	 */
	function testBasicFormat() {
		global $ecn_admin_class;
		$events = array(
			new ECNCalendarEvent( array(
					'title' => 'Test Title'
				)
			),
			new ECNCalendarEvent( array(
					'title' => 'Another title'
				)
			)
		);
		$this->assertEquals(
			"\n<p>Test Title</p>\n<p>Another title</p>",
			$ecn_admin_class->get_output_from_events( $events, array( 'format' => '<p>{title}</p>' ) ),
			'Basic output should match formatting'
		);
	}

	/**
	 * Test grouping events by date
	 *
	 * @exclude
	 */
	function testGroupEvents() {
		$this->markTestSkipped('Pro version required');
		global $ecn_admin_class;
		$events = array(
			new ECNCalendarEvent( array(
					'start_date' => strtotime( '2014-12-11 6:00pm' ),
					'title' => 'Test Title'
				)
			),
			new ECNCalendarEvent( array(
					'start_date' => strtotime( '2015-01-15 6:00pm' ),
					'title' => 'Another title'
				)
			),
			new ECNCalendarEvent( array(
					'start_date' => strtotime( '2015-01-15 11:00pm' ),
					'title' => 'Next title'
				)
			)
		);
		$this->assertEquals(
			"\n<h3 class=\"group_event_title\">" . date_i18n( apply_filters( 'ecn_group_events_date_format', get_option( 'date_format' ) ), strtotime( '2014-12-11 6:00pm' ) ) . "</h3><p>Test Title</p>\n<h3 class=\"group_event_title\">" . date_i18n( get_option( 'date_format' ), strtotime( '2015-01-15 6:00pm' ) ) . "</h3><p>Another title</p>\n<p>Next title</p>",
			$ecn_admin_class->get_output_from_events( $events, array( 'format' => '<p>{title}</p>', 'group_events' => 'day' ) ),
			'Events should be grouped by day'
		);
		$this->assertEquals(
			"\n<h3 class=\"group_event_title\">" . date_i18n( apply_filters( 'ecn_group_events_month_format', 'F' ), strtotime( '2014-12-11 6:00pm' ) ) . "</h3><p>Test Title</p>\n<h3 class=\"group_event_title\">" . date_i18n( 'F', strtotime( '2015-01-15 6:00pm' ) ) . "</h3><p>Another title</p>\n<p>Next title</p>",
			$ecn_admin_class->get_output_from_events( $events, array( 'format' => '<p>{title}</p>', 'group_events' => 'month' ) ),
			'Events should be grouped by month'
		);
	}

	/**
	 * DESIGN TESTS
	 */
	function testDefaultDesign() {
		global $ecn_admin_class;

		$event = new ECNCalendarEvent( array(
			'start_date' => '2015-01-06 13:00:00',
			'end_date' => '2015-01-06 16:00:00',
			'title' => 'Test Title',
		) );
        $this->assertEquals( "\n<h2>Test Title</h2>\n\n<p>January 6, 2015 @ 1:00 pm to 4:00 pm</p>\n<p></p>\n<p></p>", $ecn_admin_class->get_output_from_events( array( $event ), array( 'format' => '<p>{title}</p>', 'design' => 'default' ) ), 'Default design should override given format' );
	}

	function testCompactDesign() {
		global $ecn_admin_class;

		$event = new ECNCalendarEvent( array(
			'start_date' => '2015-01-06 13:00:00',
			'end_date' => '2015-01-06 16:00:00',
			'title' => 'Test Title',
		) );
		$this->assertEquals( "\n" . '<div><strong>January 6, 2015</strong> - Test Title 1:00 pm-4:00 pm </div>', $ecn_admin_class->get_output_from_events( array( $event ), array( 'format' => '<p>{title}</p>', 'design' => 'compact' ) ), 'Compact/minimal design should override given format' );
	}

}