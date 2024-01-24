<?php

class ECNCalendarEventTest extends WP_UnitTestCase {

    public function testCategories() {
        $category_id = wp_create_category( 'Test Category' );
        $category = get_category( $category_id );

        $event = new ECNCalendarEvent( [
            'title' => 'My title',
            'categories' => [
                $category,
            ],
        ] );

        $this->assertEquals( 'Test Category', $event->get_from_format( '{categories}' ), '{categories} tag should work' );
        $this->assertEquals( '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all events in %s', 'event-calendar-newsletter' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>', $event->get_from_format( '{category_links}' ), 'should output links for category' );

        $event = new ECNCalendarEvent( [
            'title' => 'My title',
            'categories' => [
                $category,
                $category,
            ],
        ] );

        $this->assertEquals( 'Test Category, Test Category', $event->get_from_format( '{categories}' ), '{categories} tag should work' );
    }

    public function testGuid() {
        $event = new ECNCalendarEvent( [
            'title' => 'My Title',
            'link' => 'http://myblog.com/event-test',
            'start_date' => '2015-01-06',
        ] );
        $this->assertEquals( md5( $event->get_title() . ' ' . $event->get_link() . ' ' . $event->get_start_date() ), $event->get_guid(), 'GUID should equal event link' );
    }

    public function testGuidNoLink() {
        $event = new ECNCalendarEvent( [
            'title' => 'My Title',
            'start_date' => '2015-01-06 13:00:00',
        ] );
        $this->assertEquals( md5( $event->get_title() . ' ' . $event->get_start_date() ), $event->get_guid(), 'GUID should equal hash of title and start date/time' );
    }

    public function testImageTags() {
        $event = new ECNCalendarEvent( [
            'event_image_url' => 'http://my.com/image.png',
        ] );
        $this->assertEquals( 'http://my.com/image.png', $event->get_event_image_url(), 'Event image URL should be accessible' );
        $this->assertEquals( 'http://my.com/image.png', $event->get_from_format( '{event_image_url}' ), '{event_image_url} tag should work' );
        $this->assertEquals( '<img src="http://my.com/image.png" alt="" />', $event->get_from_format( '{event_image}' ), '{event_image} tag should work' );
    }

    public function testLocationPhone() {
        $event = new ECNCalendarEvent( [
            'location_phone' => '905-333-4444',
        ] );
        $this->assertEquals( '905-333-4444', $event->get_location_phone(), 'Get event phone' );
        $this->assertEquals( '905-333-4444', $event->get_from_format( '{location_phone}' ), 'Get event phone' );
    }

    public function testStartAndEndDateFormatting() {
        $event = new ECNCalendarEvent( [
            'start_date' => '2019-07-26 13:00:00',
            'end_date' => '2019-07-26 17:00:00',
        ] );
        $this->assertEquals( 'Wednesday, July 26, 2019', $event->get_from_format( '{start_date|l, f j, Y}' ), 'Get event start date formatted' );
        $this->assertEquals( 'Wednesday, July 26, 2019', $event->get_from_format( '{end_date|l, f j, Y}' ), 'Get event end date formatted' );
        $this->assertEquals( '13', $event->get_from_format( '{start_time|G}' ), 'Get event start time formatted' );
        $this->assertEquals( '17', $event->get_from_format( '{end_time|G}' ), 'Get event end time formatted' );
    }

    public function testGenerateExcerpt() {
        $event = new ECNCalendarEvent( [
            'description' => 'Get out of the office and join us for a walk in the park!

This is a longer description so it should be truncated by the excerpt generation function or something but I\'m not really sure how long that 55 character limit will be so I will just keep on typing and hope that my rambling is long enough?',
        ] );
        $this->assertEquals( 'Get out of the office and join us for a walk in the park! This is a longer description so it should be truncated by the excerpt generation function or something but I\'m not really sure how long that 55 character limit will be so I will just keep on typing and hope that my [&hellip;]', $event->get_from_format( '{excerpt}', 'excerpt should be generated from the description' ) );
    }

    public function testFetchImageUrlFromContent() {
        $event = new ECNCalendarEvent( [
            'description' => '<img class="alignleft size-large wp-image-27584" src="http://i0.wp.com/vancitysounds.com/wp-content/uploads/2016/03/ture-1.jpg?resize=300%2C200" alt="ture" />
The Roxy Cabaret Presents True Doe
April 1, 2016 8 PM$10 through ticketzone $13 at the door 19 + to enter
TRUE DOE Formerly known as the AKA, True Doe is a Vancouver-based rock band put together in late 2005. Playing at the local hipster hangouts and getting paid for it in drink tickets is what we are all about! If you like cheap drinks (sometimes), complaining about your exes, seeing men with their shirts off, and/or watching people make complete fools of themselves at their own expense, then you’ll feel right at home at our next event!
http://truedoe.bandcamp.com

&nbsp;

<a href="http://www.ticketzone.com/wafform.aspx?_act=refevent&amp;_pky=322892&amp;afflky=1FBZBF" target="_blank">TICKETS</a>',
        ] );
        $this->assertEquals( 'http://i0.wp.com/vancitysounds.com/wp-content/uploads/2016/03/ture-1.jpg?resize=300%2C200', $event->get_from_format( '{event_image_url}' ), 'should pull event image from content, if exists' );
    }

    public function testAllDay() {
        $event = new ECNCalendarEvent( [
            'all_day' => true,
            'start_date' => '2015-01-06 13:00:00',
        ] );
        $this->assertEquals( 'All day', $event->get_from_format( '{all_day}' ), '{all_day} should display text' );
        $event = new ECNCalendarEvent( [
            'all_day' => false,
            'start_date' => '2015-01-06 13:00:00',
        ] );
        $this->assertEquals( '', $event->get_from_format( '{all_day}' ), '{all_day} should display text' );
    }

    public function testImageCondition() {
        $event = new ECNCalendarEvent( [
            'start_date' => '2015-01-06 13:00:00',
            'end_date' => '2015-01-06 13:00:00',
            'event_image_url' => 'http://testing.com/img.jpg',
        ] );
        $this->assertEquals( 'test', $event->get_from_format( '{if_event_image_url}test{/if_event_image_url}' ), 'Should handle event image URL conditional' );
        $this->assertEquals( 'test2', $event->get_from_format( '{if_event_image}test2{/if_event_image}' ), 'Should handle event image conditional' );
    }

    public function testEndTimeCondition() {
        $event = new ECNCalendarEvent( [
            'start_date' => '2015-01-06 13:00:00',
            'end_date' => '2015-01-06 13:00:00',
        ] );
        $this->assertEquals( '', $event->get_from_format( '{if_end_time}-{end_time}{/if_end_time}' ), 'Should not show end time text' );
        $event = new ECNCalendarEvent( [
            'start_date' => '2015-01-06 13:00:00',
            'end_date' => '2015-01-06 16:00:00',
        ] );
        $this->assertEquals( '-4:00 pm', $event->get_from_format( '{if_end_time}-{end_time}{/if_end_time}' ), 'Should show end time text' );
        $event = new ECNCalendarEvent( [
            'start_date' => '2015-01-06 13:00:00',
            'end_date' => '2015-01-06 16:00:00',
            'all_day' => true,
        ] );
        $this->assertEquals( '', $event->get_from_format( '{if_end_time}-{end_time}{/if_end_time}' ), 'Should not show end time text if all day' );
        $this->assertEquals( ' other stuff  and other', $event->get_from_format( '{if_end_time}-{end_time}{/if_end_time} other stuff {if_end_time}+{end_time}{/if_end_time} and other' ), 'Should look at multiple conditions separately' );
    }

    public function testLocationNameConditional() {
        $event = new ECNCalendarEvent( [
            'location_name' => 'My test location',
        ] );
        $this->assertEquals( 'at My test location', $event->get_from_format( '{if_location_name}at {location_name}{/if_location_name}' ), 'Should remove location name text' );
        $this->assertEquals( '', $event->get_from_format( '{if_not_location_name}Default location{/if_not_location_name}' ), 'Should remove default location text' );
        $event = new ECNCalendarEvent( [
            'location_name' => '',
        ] );
        $this->assertEquals( '', $event->get_from_format( '{if_location_name}at {location_name}{/if_location_name}' ), 'Should remove location name text' );
        $this->assertEquals( 'Default location', $event->get_from_format( '{if_not_location_name}Default location{/if_not_location_name}' ), 'Should remove default location text' );
    }

    public function testAllDayConditional() {
        $event = new ECNCalendarEvent( [
            'all_day' => true,
            'start_date' => '2015-01-06 13:00:00',
        ] );
        $this->assertEquals( '', $event->get_from_format( '{if_not_all_day}Text{/if_not_all_day}' ), 'Should remove not all day' );
        $this->assertEquals( 'Text', $event->get_from_format( '{if_all_day}Text{/if_all_day}' ), 'Should keep all day' );
        $this->assertEquals( 'Text', $event->get_from_format( '{if_all_day}Text{/if_all_day}{if_not_all_day}not all day{/if_not_all_day}' ), 'Should handle both all day and not all day' );
        $this->assertEquals( '
Text
', $event->get_from_format( '{if_all_day}
Text
{/if_all_day}' ), 'Should handle new lines' );
        $this->assertEquals( '', $event->get_from_format( '{if_not_all_day}
Text
{/if_not_all_day}' ), 'Should handle new lines (neg)' );

        $event = new ECNCalendarEvent( [
            'all_day' => false,
            'start_date' => '2015-01-06 13:00:00',
        ] );
        $this->assertEquals( 'Text', $event->get_from_format( '{if_not_all_day}Text{/if_not_all_day}' ), 'Should keep not all day' );
        $this->assertEquals( '', $event->get_from_format( '{if_all_day}Text{/if_all_day}' ), 'Should remove all day' );
        $this->assertEquals( 'not all day', $event->get_from_format( '{if_all_day}Text{/if_all_day}{if_not_all_day}not all day{/if_not_all_day}' ), 'Should handle both all day and not all day (all day = false)' );
        $this->assertEquals( '', $event->get_from_format( '{if_all_day}
Text
{/if_all_day}' ), 'Should handle new lines (false condition)' );
    }
}
