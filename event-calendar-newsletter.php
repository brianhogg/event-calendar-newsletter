<?php
/*
Plugin Name: Event Calendar Newsletter
Plugin URI: http://wordpress.org/extend/plugins/event-calendar-newsletter/
Description: Easily put events from your WordPress event calendar inside of a newsletter. Spend less time promoting your events!
Version: 2.14.1
Author: Event Calendar Newsletter
Author URI: https://eventcalendarnewsletter.com/?utm_source=plugin&utm_campaign=author-link&utm_medium=link
Text Domain: event-calendar-newsletter
License: GPL2
*/

/*  Copyright Brian Hogg <email: brian@brianhogg.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'ECN_PLUGINS_FILE', __FILE__ );
define( 'ECN_PLUGINS_URL', plugins_url( '', __FILE__ ) );

if ( file_exists( __DIR__ . '/.env_dev.php' ) ) {
    include __DIR__ . '/.env_dev.php';
}

if ( !defined( 'ECN_PRODUCTION' ) ) {
    define( 'ECN_PRODUCTION', true );
}

include_once __DIR__ . '/includes/wp-requirements.php';

// Check plugin requirements before loading plugin.
$this_plugin_checks = new ECN_WP_Requirements( 'Event Calendar Newsletter', plugin_basename( __FILE__ ), array(
    'PHP' => '5.3.3',
    'WordPress' => '4.1',
    'Extensions' => array(
    ),
) );

if ( $this_plugin_checks->pass() === false ) {
    $this_plugin_checks->halt();

    return;
}

if ( file_exists( __DIR__ . '/config_dev.php' ) ) {
    include __DIR__ . '/config_dev.php';
}

require_once __DIR__ . '/includes/ecnadmin.class.php';
require_once __DIR__ . '/includes/ecncalendarevent.class.php';
require_once __DIR__ . '/includes/ecncalendarfeed.class.php';
require_once __DIR__ . '/includes/ecncalendarfeedfactory.class.php';
require_once __DIR__ . '/includes/ecnsettings.class.php';

// Supported plugins
require_once __DIR__ . '/includes/ecncalendarfeedajaxcalendar.class.php';
require_once __DIR__ . '/includes/ecncalendarfeedtheeventscalendar.class.php';
require_once __DIR__ . '/includes/ecncalendarfeedgooglecalendarevents.class.php';
require_once __DIR__ . '/includes/ecncalendarfeedai1ec.class.php';
require_once __DIR__ . '/includes/ecncalendarfeedeventsmanager.class.php';
require_once __DIR__ . '/includes/ecncalendarfeedeventorganiser.class.php';

// Upgrade link
if ( ! function_exists( 'ecn_add_action_links' ) ) {
    function ecn_add_action_links( $links ) {
        $mylinks = array(
            '<a target="_blank" style="color:#3db634; font-weight: bold;" href="https://eventcalendarnewsletter.com/pro/?utm_source=plugin-list&utm_medium=upgrade-link&utm_campaign=plugin-list&utm_content=action-link">Upgrade</a>',
        );

        return array_merge( $links, $mylinks );
    }
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ecn_add_action_links' );
}

if ( ! function_exists( 'ecn_load_textdomain' ) ) {
    /**
     * Load in any language files that we have setup
     */
    function ecn_load_textdomain() {
        load_plugin_textdomain( 'event-calendar-newsletter', false, plugin_basename( __DIR__ ) . '/languages' );
    }
    add_action( 'plugins_loaded', 'ecn_load_textdomain' );
}

/*
 * Check if a pro-only calendar exists, and what that calendar is
 *
 * @return string[]
 */
if ( ! function_exists( 'ecn_available_pro_calendars' ) ) {
    function ecn_available_pro_calendars() {
        $calendars = array();

        if ( class_exists( 'plugin_righthere_calendar' ) ) {
            $calendars[] = 'CalendarizeIt!';
        }

        if ( defined( 'CCT_MIDBI_VERSION' ) ) {
            $calendars[] = 'CCT Cloud';
        }

        if ( class_exists( 'Church_Theme_Content' ) ) {
            $calendars[] = 'Church Content';
        }

        if ( function_exists( 'espresso_version' ) ) {
            $calendars[] = 'Event Espresso';
        }

        if ( class_exists( 'EventON' ) ) {
            $calendars[] = 'EventON';
        }

        if ( defined( 'TEVOLUTION_EVENT_VERSION' ) ) {
            $calendars[] = 'Tevolution Events / Eventum';
        }

        if ( ( defined( 'GDEVENTS_VERSION' ) || defined( 'GEODIR_EVENT_VERSION' ) ) ) {
            $calendars[] = 'Geodirectory Events';
        }

        if ( class_exists( 'MEC_skins' ) ) {
            $calendars[] = 'Modern Events Calendar';
        }

        return $calendars;
    }
}

if ( ! class_exists( 'ECNPro' ) ) {
    /*
     * This function allows you to track usage of your plugin
     * Place in your main plugin file
     * Refer to https://wisdomplugin.com/support for help
     */
    if ( ! class_exists( 'ECN_Plugin_Usage_Tracker' ) ) {
        require_once __DIR__ . '/tracking/class-plugin-usage-tracker.php';
    }

    if ( ! function_exists( 'event_calendar_newsletter_start_plugin_tracking' ) ) {
        function event_calendar_newsletter_start_plugin_tracking() {
            $wisdom = new ECN_Plugin_Usage_Tracker(
                __FILE__,
                'https://track.eventcalendarnewsletter.com/',
                array( 'ecn_saved_options' ),
                true,
                true,
                2
            );
        }
        event_calendar_newsletter_start_plugin_tracking();
    }
}
