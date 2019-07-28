=== Plugin Name ===
Contributors: brianhogg
Donate link: https://eventcalendarnewsletter.com/
Tags: events, calendar, event, newsletter, all-in-one, calendar manager, custom calendar, custom calendars, events feed, google calendar, google
Requires at least: 4.1
Tested up to: 5.2
Stable tag: 2.10
Requires PHP: 5.3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily put events from your WordPress event calendar inside of a newsletter. Quickly use an included design or create your own!

== Description ==

Stop manually copying, pasting and formatting events you're promoting from your WordPress events calendar!  Take your events calendar and turn it into a newsletter-friendly format, so you can quickly copy your events into your newsletters (ie. MailChimp, MailPoet, Active Campaign, or other newsletter sending service).

All you have to do is select how far in the future you want events for your newsletter and click Generate.

There's no programming required.  You can preview the output then quickly copy/paste it into your newsletter.  Spend a lot less time creating newsletters of your upcoming events!

[youtube https://www.youtube.com/watch?v=rTwus0wTzX4]

**How it works**

Event Calendar Newsletter pulls the events for your newsletter from a WordPress event calendar plugin installed on your site.

If you don't already have a WordPress event calendar, see [Setting up an Event Calendar on your WordPress site](https://eventcalendarnewsletter.com/docs/set-event-calendar-wordpress-site/?utm_source=wordpress.org&utm_medium=link&utm_campaign=setup-calendar) or just install the plugin and it will guide you.

The plugin currently supports the following calendars:

* [The Events Calendar by Modern Tribe](https://wordpress.org/plugins/the-events-calendar/)
* [All-in-One Event Calendar by Time.ly](https://wordpress.org/plugins/all-in-one-event-calendar/)
* [Event Organiser](https://wordpress.org/plugins/event-organiser/)
* [Simple Calendar (aka Google Calendar Events)](https://wordpress.org/plugins/google-calendar-events/)
* [Events Manager](https://wordpress.org/plugins/events-manager/)

the [pro version](https://eventcalendarnewsletter.com/?utm_source=wordpress.org&utm_medium=link&utm_campaign=readme-pro-calendars&utm_content=description) additionally supports:

* [Event Espresso](https://eventcalendarnewsletter.com/event-espresso/?utm_source=wordpress.org&utm_medium=link&utm_campaign=eventum-pro-calendar)
* [EventON](http://www.myeventon.com/)
* Calendarize it!
* [Eventum (by Templatic)](https://eventcalendarnewsletter.com/eventum/?utm_source=wordpress.org&utm_medium=link&utm_campaign=eventum-pro-calendar)

**Free version**

* Get events from 1 week to 12 months to add to your newsletter
* Customize the formatting and add the information you want in your newsletter using a visual or HTML editor
* Quickly copy and paste the output into your newsletter

**PRO version**

Event Calendar Newsletter is available as a pro version with lots of extra features to save you even more time and get more people attending your events!

* Filter events - by category, tag or a specific calendar so you get only the events you want in your newsletter
* Group events - by day or month so they're easier to read
* Save multiple templates - quickly get the events you want in the right format
* Ability to automatically insert events into MailChimp, MailPoet and Newsletter plugins for WordPress, Active Campaign, Aweber and others
* Ability to configure automatic mailings and reminders of upcoming events
* Selecting less than a week (1-6 days) of events
* Custom date range - select only the events you want, ie. if you're creating a future newsletter in advance
* Start from date - start events a number of days in the future, letting you easily create sections in your newsletter (ie. next week, next weekend)
* Email support - get questions quickly answered and submit feature requests

[https://eventcalendarnewsletter.com](https://eventcalendarnewsletter.com/?utm_source=wordpress.org&utm_medium=link&utm_campaign=event-cal-readme&utm_content=description)

[Read Reviews &raquo;](https://eventcalendarnewsletter.com/testimonials/ "Event Calendar Newsletter WordPress Plugin")


== Installation ==

You can either search for Event Calendar Newsletter in the Plugins --> Add New area, or:

1. Go to Plugins --> Add New
2. Select the Upload option, then Choose File...
3. In the pop-up select the zip file downloaded from this plugin page
4. Follow the instructions after the upload completes
5. Go to Event Calendar Newsletter and complete the form

If you don't already have your event calendar plugin installed and configured, you'll also need to install that plugin.  Plugins currently supported:

* [The Events Calendar](https://wordpress.org/plugins/the-events-calendar/)
* [All-in-One Event Calendar by Time.ly](https://wordpress.org/plugins/all-in-one-event-calendar/)
* [Simple Calendar (aka Google Calendar Events)](https://wordpress.org/plugins/google-calendar-events/)
* [Event Calendar](http://wordpress.org/plugins/ajax-event-calendar/)

== Screenshots ==

1. Select the calendar where you'd like to pull your events from, and define the format.
2. Events are pulled and output in a newsletter-friendly format.  Just copy and paste into your Newsletter!
3. HTML output can be used in your newsletter instead.
4. Choose which events to include by how far in the future, Pro version can filter by categories or tags

== Changelog ==

= 2.10 =
* Adding ability to format start_date, start_time, end_time and end_date inline, ie. {start_date|l, F j, Y}
* Fix for adding multiple of the same if_ condition tags

= 2.9 =
* Fix for if_end_date condition not really doing anything

= 2.8 =
* Fix for WordPress 5.0 not showing custom editor at the right height
* Allowing custom added fields to be used with conditional checks
* Ensuring excerpt is an option for Events Manager
* Fix for Event Organiser not getting location_* field data properly

= 2.7 =
* Additional WP filters for date/time formatting and excerpt length
* Optional tracking to improve performance and compatibility

= 2.6.1 =
* Adding accessibility alt tag for images with The Events Calendar
* Updating email signup form

= 2.6 =
* Removing non-working 'select all' button
* Demo video for pasting the HTML
* Help text tweaks

= 2.5.5 =
* Improved i18n handling
* Text copy tweaks
* Additional ecn_get_excerpt filter
* Adds organizer details to available The Events Calendar fields

= 2.5.4 =
* Improved query performance for Events Manager

= 2.5.3 =
* Better handling for all day events in the default template
* Additional tags for The Events Calendar

= 2.5.2 =
* Fixes issues with links in all-in-one by time.ly

= 2.5 =
* Adding default and compact designs
* Adding {tags} and {tag_links} for certain calendars

= 2.4.1 =
* Compability change for older versions of PHP

= 2.4 =
* Adds Event Organiser support
* Support for additional conditional statements like {if_end_time}...{/if_end_time}
* Additional format options in dropdown
* Refactoring codebase and additional tests

= 2.3.5 =
* Adding class/function exists checks

= 2.3.4 =
* Adding location_phone tag
* Adding location website and phone for The Events Calendar

= 2.3.3 =
* Only including Published events in output for The Events Calendar
* Adding manual excerpt if there is none in post_excerpt

= 2.3.2 =
* Handling for multi-day events expanded in Simple Calendar

= 2.3.1 =
* Fixes bug with Events Manager where incorrect events selected based on date range

= 2.3 =
* Adding Events Manager support

= 2.2.2 =
* Adds check to see if previously saved plugin is no longer available

= 2.2.1 =
* Compatibility changes for The Events Calendar

= 2.2 =
* Adding {categories} and {category_links} tags

= 2.1.1 =
* Fixing issue in Simple Calendar with multiple events at the same day/time

= 2.1 =
* Adding settings page

= 2.0.3 =
* Fixing issue with The Events Calendar not returning all events

= 2.0.2 =
* Fixing the {all_day} tag

= 2.0.1 =
* Using Tribe__Events__Query for ECN
* Adding condition {if_all_day} and {if_not_all_day} tags

= 2.0 =
* Improved editing using the WordPress editor
* Additional formatting tags for Simple Calendar

= 1.9.2 =
* Fix to fetch events from all Simple Calendar calendars

= 1.9.1 =
* Fixing timezone issue with All-in-One Event Calendar

= 1.9 =
* Adding initial support for All-in-One Event Calendar by Time.ly

= 1.8 =
* Fixing date dropdowns

= 1.7 =
* Removing freemius
* Ensuring The Events Calendar events are in future

= 1.6.2 =
* Option to force fetching new events for Simple Calendar

= 1.6.1 =
* Fixing issue with Simple Calendar and past events
* Ensuring new events fetched when generating newsletter
* Updating Freemius to remove two menu items appearing before activation in 4.4

= 1.6 =
* Adding Simple Calendar support

= 1.5.1 =
* Updating version of freemius

= 1.5 =
* Added option for smaller time periods (1, 2 or 3 week)
* Added freemius stats to aid in feedback

= 1.4 =
* German translation
* Fixed issue with quotes in the HTML format
* Added {link_url}

= 1.3 =
* Added translation support

= 1.2 =
* Fix formatting of free event cost
* Added ecn_admin_capability filter to modify who has access to the events calendar screen

= 1.1 =
* Minor fixes

= 1.0 =
* Initial release
