<div class="wrap">
    <h2><?php echo esc_html( apply_filters( 'ecn_settings_title', _x( 'Event Calendar Newsletter', 'Settings title', 'event-calendar-newsletter' ) ) ); ?></h2>
	<?php do_action( 'ecn_after_settings_title' ); ?>
    <?php if ( ! $data['available_plugins'] ): ?>
      <?php $calendars = ecn_available_pro_calendars(); ?>
      <?php if ( count( $calendars ) ): ?>
            <div id="no-supported-calendars">
                <h2><?php echo _n( 'Your calendar requires the pro version to function:', 'Your calendar requires the pro version to function', count( $calendars ), 'event-calendar-newsletter' ); ?></h2>
                <?php foreach ( $calendars as $calendar ): ?>
                    <p><strong><?php echo esc_html( $calendar ); ?></strong></p>
                <?php endforeach; ?>
                <p>Not all calendars are supported in the free version.</p>
                <p>You can either install a calendar supported with the free version (like The Events Calendar by Modern Tribe), or upgrade to pro. This will allow support for all calendars, along with other features like automatic sending with Mailchimp, Mailpoet, and more.</p>
                <p><?php echo sprintf( esc_html__( '%sLearn More About Event Calendar Newsletter Pro%s', 'event-calendar-newsletter' ), '<a class="ecs-button upgrade" target="_blank" href="https://eventcalendarnewsletter.com/?utm_source=plugin&utm_medium=link&utm_campaign=ecn-pro-only-calendar&utm_content=description">', '</a>' ); ?></p>            </div>
            </div>
        <?php else: ?>
          <div id="no-supported-calendars">
              <h2><?php echo esc_html( __( 'No supported event calendar plugin available.', 'event-calendar-newsletter' ) ); ?></h2>
            <p>
              <?php echo esc_html( __( 'Event Calendar Newsletter takes the details of your upcoming events to put inside your newsletter from one of the supported WordPress event calendar plugins.', 'event-calendar-newsletter' ) ); ?>
            </p>
              <p>
                  <strong><?php echo esc_html( __( 'Install one of the supported calendars, which include:', 'event-calendar-newsletter' ) ); ?></strong>
                  <p><a href="<?php echo admin_url( 'plugin-install.php?tab=search&type=term&s=the+events+calendar' ); ?>">The Events Calendar</a></p>
                  <p><a href="<?php echo admin_url( 'plugin-install.php?tab=search&s=events+manager' ); ?>">Events Manager</a> (<a target="_blank" href="https://wordpress.org/plugins/events-manager/"><?php echo esc_html( __( 'this Events Manager', 'event-calendar-newsletter' ) ); ?></a>)</p>
                  <p><a href="<?php echo admin_url( 'plugin-install.php?tab=search&s=event+organiser' ); ?>">Event Organiser</a></p>
                  <div><?php echo sprintf( esc_html( __( 'Note that %scertain calendars%s are only supported %sin the pro version of Event Calendar Newsletter%s', 'event-calendar-newsletter' ) ), '<a href="https://eventcalendarnewsletter.com/features/#calendars?utm_source=plugin&utm_campaign=pro-cal-support-ee" target="_blank">', '</a>', '<a href="https://eventcalendarnewsletter.com/?utm_source=plugin&utm_campaign=pro-cal-support" target="_blank">', '</a>' ); ?></div>
               </p>
            <h1><?php echo esc_html__( 'Preview of Event Calendar Newsletter', 'event-calendar-newsletter' ); ?></h1>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/rTwus0wTzX4" frameborder="0" allowfullscreen></iframe>
              <p>
                  <?php echo sprintf( esc_html( __( 'Still need help?  View %sfull instructions for setting up a supported calendar%s or %sreach out to support%s, we are here to help :)' ) ), '<a target="_blank" href="https://eventcalendarnewsletter.com/docs/set-event-calendar-wordpress-site/">', '</a>', '<a href="https://wordpress.org/support/plugin/event-calendar-newsletter/#new-post" target="_blank">', '</a>' ); ?>
              </p>
          </div>
      <?php endif; ?>
    <?php else: ?>
        <div id="ecn-admin">
            <?php wp_nonce_field( 'ecn_admin', 'wp_ecn_admin_nonce' ); ?>
            <div class="leftcol">
                <form>
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th scope="row"><?php echo esc_html( __( 'Event Calendar:', 'event-calendar-newsletter' ) ); ?></th>
                            <td>
                                <select name="event_calendar">
                                    <?php foreach ( $data['available_plugins'] as $plugin => $description ): ?>
                                        <option value="<?php echo esc_attr( $plugin ); ?>"<?php echo  $plugin == $data['event_calendar'] ? ' SELECTED' : ''; ?>><?php echo esc_html( $description ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div>
                                    <em><?php echo sprintf( esc_html( __( "Can't find the calendar with your events that you'd like to use?  %sLet us know%s!", 'event-calendar-newsletter' ) ), '<a href="mailto:info@eventcalendarnewsletter.com">', '</a>' ); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="events_future_in_days"><?php echo esc_html( __( 'Future Events to Use:', 'event-calendar-newsletter' ) ); ?></label></th>
                            <td>
                                <select id="events_future_in_days" name="events_future_in_days">
                                    <?php do_action( 'ecn_events_future_in_days_before', $data['events_future_in_days'] ); ?>
                                    <?php for ( $i = 1; $i < 4; $i++ ): ?>
                                        <option value="<?php echo $i * 7; ?>"<?php echo  $i * 7 == $data['events_future_in_days'] ? ' SELECTED' : ''; ?>><?php echo sprintf( _n( '%d week', '%d weeks', $i, 'event-calendar-newsletter' ), $i ); ?></option>
                                    <?php endfor; ?>
                                    <?php for ( $i = 1; $i <= 12; $i++ ): ?>
                                        <option value="<?php echo $i * 30; ?>"<?php echo  $i * 30 == $data['events_future_in_days'] ? ' SELECTED' : ''; ?>><?php echo sprintf( _n( '%d month', '%d months', $i, 'event-calendar-newsletter' ), $i ); ?></option>
                                    <?php endfor; ?>
                                    <?php do_action( 'ecn_events_future_in_days_after', $data['events_future_in_days'] ); ?>
                                </select>
	                            <?php do_action( 'ecn_events_future_in_days_after_select', $data ); ?>
                            </td>
                        </tr>
                        <?php do_action( 'ecn_events_future_in_days_after_tr', $data ); ?>
                        </tbody>
                        <tbody id="additional_filters">
                            <?php
                            $current_plugin = $data['event_calendar'];

        if ( ! $current_plugin ) {
            $all_plugins = array_keys( $data['available_plugins'] );
            $current_plugin = $all_plugins[0];
        }
        do_action( 'ecn_additional_filters_settings_html-' . $current_plugin, $data );
        do_action( 'ecn_additional_filters_settings_html', $current_plugin, $data );
        ?>
                        </tbody>
                        <tbody>
                        <tr>
	                        <th scope="row"><?php echo esc_html( __( 'Group events:', 'event-calendar-newsletter' ) ); ?></th>
	                        <td>
		                        <div>
			                        <select id="group_events" name="group_events">
				                        <option value="normal"><?php echo esc_html( __( 'None (Show events in order)', 'event-calendar-newsletter' ) ); ?></option>
				                        <?php do_action( 'ecn_additional_group_events_values', $data['group_events'] ); ?>
			                        </select>
		                        </div>
		                        <div class="ecn-groupby-message">
			                        <em>
				                        <?php echo esc_html( __( 'If you have lots of events, you can group them together by day or month with a header for each group', 'event-calendar-newsletter' ) ); ?>
				                        <?php if ( 'valid' != get_option( 'ecn_pro_license_status' ) ): ?>
					                        <?php echo sprintf( esc_html( __( 'with the %sPro version%s', 'event-calendar-newsletter' ) ), '<a target="_blank" href="https://eventcalendarnewsletter.com/pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=event-cal-plugin&utm_content=groupevents">', '</a>' ); ?>
				                        <?php endif; ?>
									</em>
		                        </div>
	                        </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo esc_html( __( 'Format/Design:', 'event-calendar-newsletter' ) ); ?></th>
                            <td>
	                            <div class="leftcol">
		                            <fieldset>
			                            <label><input type="radio" name="design" value="default"<?php if ( 'default' == $data['design'] or false === $data['design'] ) {
			                                checked( true );
			                            } ?>> Default</label><br />
			                            <label><input type="radio" name="design" value="compact"<?php checked( 'compact', $data['design'] ); ?>> Minimal/Compact</label><br />
			                            <?php do_action( 'ecn_designs', $data ); ?>
			                            <label><input type="radio" name="design" value="custom"<?php checked( 'custom', $data['design'] ); ?>> Custom</label><br />
			                        </fieldset>
	                            </div>
	                            <div class="right ecn-all-designs">
		                            <a target="_blank" href="https://eventcalendarnewsletter.com/designs?utm_source=wordpress.org&utm_medium=link&utm_campaign=event-cal-plugin&utm_content=design-link">See all designs</a>
	                            </div>

                                <div class="format_editor clearfix" style="display:none;">
                                    <select id="placeholder">
                                        <?php foreach ( ECNCalendarEvent::get_available_format_tags( $data['event_calendar'] ) as $tag => $description ): ?>
                                            <option value="<?php echo esc_attr( $tag ); ?>"><?php echo esc_html( $description ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input id="insert_placeholder" type="submit" value="<?php echo esc_attr( __( 'Insert', 'event-calendar-newsletter' ) ); ?>" class="button" />
	                                &nbsp; <a target="_blank" href="https://eventcalendarnewsletter.com/docs/tags/">View documentation on available tags</a>
                                </div>
                                <div class="format_editor">
	                                <?php wp_editor( $data['format'], 'format', [ 'editor_height' => 150, 'wpautop' => false, 'media_buttons' => false ] ); ?>
                                </div>
	                            <?php do_action( 'ecn_end_settings_page', $current_plugin, $data ); ?>
                            </td>
                        </tr>
	                    </tbody>
                    </table>
                </form>

                <div id="generate">
                    <input id="fetch_events" type="submit" value="<?php echo esc_attr( apply_filters( 'ecn_generate_button_text', __( 'Generate Newsletter Formatted Events', 'event-calendar-newsletter' ) ) ); ?>" class="button button-primary" />
                    <?php do_action( 'ecn_settings_after_fetch_events' ); ?>
	                <span class="spinner"></span>
                </div>

                <div class="result">
	                <?php do_action( 'ecn_main_before_results' ); ?>

                    <div id="copy_paste_info"><?php echo sprintf( esc_html__( 'Copy and paste the result into your Mailchimp, ActiveCampaign, MailPoet or other newsletter sending service.  You will likely want to use the "Results (HTML)" version. %sView a Quick Demo%s', 'event-calendar-newsletter' ), '<a target="_blank" href="http://www.youtube.com/watch?v=4oSIlU541Bo">', '</a>' ); ?></div>

                    <h2 class="nav-tab-wrapper">
                        <a id="results_tab" class="nav-tab nav-tab-active"><?php echo esc_html( __( 'Result', 'event-calendar-newsletter' ) ); ?></a>
                        <a id="results_html_tab" class="nav-tab"><?php echo esc_html( __( 'Result (HTML)', 'event-calendar-newsletter' ) ); ?></a>
                    </h2>

                    <div id="results" class="tab_container">
                        <span id="output"></span>
                    </div>
                    <div id="results_html" class="tab_container">
                        <p><button id="select_html_results" class="btn"><?php echo esc_html( __( 'Select All Text', 'event-calendar-newsletter' ) ); ?></button></p>
                        <textarea id="output_html" rows="10" cols="80"></textarea>
                    </div>

	                <?php do_action( 'ecn_main_after_results' ); ?>

                </div>
            </div>
            <div class="rightcol">
                <?php if ( ! class_exists( 'ECNPro' ) ): ?>
                    <div id="ecn-pro-description">
                        <h3><?php echo esc_html__( 'Want more control over what events are displayed?', 'event-calendar-newsletter' ); ?></h3>
                        <p><?php echo sprintf( esc_html__( 'Check out %sEvent Calendar Newsletter Pro%s:', 'event-calendar-newsletter' ), '<a target="_blank" href="https://eventcalendarnewsletter.com/?utm_source=plugin&utm_medium=link&utm_campaign=ecn-upgrade-sidebar&utm_content=description">', '</a>' ); ?></p>
                        <h4><?php echo esc_html__( 'Additional Filter Options', 'event-calendar-newsletter' ); ?></h4>
                        <p><?php echo esc_html__( 'Filter by one or more categories, tags, and things like Featured Events depending on your calendar', 'event-calendar-newsletter' ); ?></p>
                        <h4><?php echo esc_html__( 'Group Events', 'event-calendar-newsletter' ); ?></h4>
                        <p><?php echo esc_html__( 'Group events by day or month, making it easier for users to see the events they are interested in', 'event-calendar-newsletter' ); ?></p>
                        <h4><?php echo esc_html__( 'Custom date range', 'event-calendar-newsletter' ); ?></h4>
                        <p><?php echo esc_html__( 'Choose events in a specific range, or even starting a certain time in the future', 'event-calendar-newsletter' ); ?></p>
                        <h4><?php echo esc_html__( 'Automate sending', 'event-calendar-newsletter' ); ?></h4>
                        <p><?php echo esc_html__( 'Automatically include events in your MailChimp, MailPoet, Active Campaign and several other newsletter sending tools!', 'event-calendar-newsletter' ); ?></p>
                        <p><?php echo sprintf( esc_html__( '%sLearn More About Event Calendar Newsletter Pro%s', 'event-calendar-newsletter' ), '<a class="ecs-button" target="_blank" href="https://eventcalendarnewsletter.com/?utm_source=plugin&utm_medium=link&utm_campaign=ecn-help-after-options&utm_content=description">', '</a>' ); ?></p>
                    </div>
                    <hr/>

                  <form action="https://track.bentonow.com/forms/a8894430afd88aaaebff8ff7e8077553/$ecn_free?hardened=true" method="POST" enctype="multipart/form-data" class="bento-formkit">
                    <div class="bento-formkit-headline"><?php echo esc_html__( 'Get 20% Off!', 'event-calendar-newsletter' ); ?></div>
                    <div class="bento-formkit-subheader"><?php echo esc_html__( "Just enter your name and email and we'll send you a coupon for 20% off your upgrade to the Pro version", 'event-calendar-newsletter' ); ?></div>
                    <input type="hidden" name="redirect" value="https://eventcalendarnewsletter.com/thank-you/">
                    <input type="email" name="email" placeholder="Email ..." class="bento-formkit-input" />
                    <input type="text" name="fields_first_name" class="bento-formkit-input" placeholder="<?php echo esc_attr__( 'First Name' ); ?>"/>
                    <button type="submit" class="bento-formkit-button"><?php echo esc_html__( 'Send me the coupon', 'event-calendar-newsletter' ); ?></button>
                  </form>
                  <style>.bento-formkit { width: 100%; line-height:1.5em; max-width: 400px; box-sizing: border-box; padding: 20px; border-radius: 8px; background: #fff; border: 1px solid rgba(0, 0, 0, 0.15); box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1); position: relative;}.bento-formkit-headline { font-size: 18px; font-weight: bold; color: #333; }.bento-formkit-subheader { font-size: 16px; color: #666; }.bento-formkit input { display: block; width: 100%; background-color: #fff; border-radius: 8px; border: 1px solid #ccc; color: #333; cursor: text; margin: 8px 0 12px; padding: 9px 10px; box-sizing: border-box;}.bento-formkit button { text-align: center; background-color: #0095FF; font-weight: 800; color: white; padding: 12px 20px; margin: 0px 0 0; border: none; cursor: pointer; width: 100%; border-radius: 8px; box-sizing: border-box; box-shadow: 0 4px 12px 0 rgba(0,0,0,0.1);}</style>

	                <?php $current_user = wp_get_current_user(); ?>

					        <p color="#555555"><?php echo esc_html__( 'We promise not to use your email for anything else and you can unsubscribe with 1-click anytime.', 'event-calendar-newsletter' ); ?></p>

	                <hr/>
	                <p><?php echo sprintf( wp_kses( __( "<strong>Like this plugin?</strong><br>We'd love if you could show your support by leaving a %s&#9733;&#9733;&#9733;&#9733;&#9733; 5 star review on WordPress.org%s!", 'event-calendar-newsletter' ), [ 'strong' => [], 'br' => [] ] ), '<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/event-calendar-newsletter?filter=5#postform">', '</a>' ); ?></p>
                <?php endif; ?>

            </div>
        </div>
    <?php endif; ?>
</div>