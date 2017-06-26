<?php
// Load WordPress test environment
// https://unit-tests.svn.wordpress.org/trunk/
//
// The path to wordpress-tests
$_tests_dir = getenv('WP_TESTS_DIR');
require_once $_tests_dir . '/includes/bootstrap.php';

// Include the main plugin files
require( dirname( __FILE__ ) . '/../../event-calendar-newsletter-pro/event-calendar-newsletter-pro.php' );
$license_data = new stdClass;
$license_data->license_limit = 5;
update_option( ECN_EDD_LICENSE_DATA, $license_data );

ecn_pro_add_core();
//require( dirname( __FILE__ ) . '/../event-calendar-newsletter.php' );
