<div class="wrap">
    <h2><?= esc_html( apply_filters( 'ecn_settings_title', _x( 'Event Calendar Newsletter', 'Settings title', 'event-calendar-newsletter' ) ) ) ?></h2>
	<?php do_action( 'ecn_after_settings_title' ); ?>
    <?php if ( ! $data['available_plugins'] ): ?>
	    <div id="no-supported-calendars">
	        <h1><?= esc_html( __( 'No supported event calendar plugins available.', 'event-calendar-newsletter' ) ) ?></h1>
		    <p>
			    <?= esc_html( __( 'Event Calendar Newsletter takes the details of your upcoming events to put inside your newsletter from one of the supported WordPress event calendar plugins.', 'event-calendar-newsletter' ) ); ?>
		    </p>
	        <p>
	            <strong><?= esc_html( __( 'Install one of the supported calendars, which include:', 'event-calendar-newsletter' ) ); ?></strong>
	            <ul>
	                <li><a href="<?= admin_url( 'plugin-install.php?tab=search&type=term&s=the+events+calendar' ); ?>">The Events Calendar by Modern Tribe, Inc</a></li>
	                <li><a href="<?= admin_url( 'plugin-install.php?tab=search&s=simple+calendar+google' ); ?>">Simple Calendar - Google Calendar Events</a></li>
	                <li><a href="<?= admin_url( 'plugin-install.php?tab=search&type=term&s=all+in+one+event+calendar+time.ly' ); ?>">All-in-One Event Calendar by time.ly</a></li>
	            </ul>
                <div><?= sprintf( esc_html( __( 'Note that certain calendars like %sEvent Espresso%s are only supported %sin the PRO version of Event Calendar Newsletter%s', 'event-calendar-newsletter' ) ), '<a href="https://eventcalendarnewsletter.com/features/#calendars?utm_source=plugin&utm_campaign=pro-cal-support-ee" target="_blank">', '</a>', '<a href="https://eventcalendarnewsletter.com/?utm_source=plugin&utm_campaign=pro-cal-support" target="_blank">', '</a>' ); ?></div>
		    </p>
		    <p><?= sprintf( esc_html( __( "Have another events calendar you'd like supported?  %sLet us know%s!", 'event-calendar-newsletter' ) ), '<a href="mailto:info@eventcalendarnewsletter.com">', '</a>' ); ?></p>
		    <p>
			    <?= sprintf( esc_html( __( 'Still need help?  View %sfull instructions for setting up a supported calendar%s' ) ), '<a target="_blank" href="https://eventcalendarnewsletter.com/docs/set-event-calendar-wordpress-site/">', '</a>' ); ?>
		    </p>
		    <h1><?php echo esc_html__( 'Preview of Event Calendar Newsletter', 'event-calendar-newsletter' ); ?></h1>
		    <iframe width="560" height="315" src="https://www.youtube.com/embed/rTwus0wTzX4" frameborder="0" allowfullscreen></iframe>
	    </div>
    <?php else: ?>
        <div id="ecn-admin">
            <?php wp_nonce_field( 'ecn_admin', 'wp_ecn_admin_nonce' ); ?>
            <div class="leftcol">
                <form>
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th scope="row"><?= esc_html( __( 'Event Calendar:', 'event-calendar-newsletter' ) ) ?></th>
                            <td>
                                <select name="event_calendar">
                                    <?php foreach ( $data['available_plugins'] as $plugin => $description ): ?>
                                        <option value="<?php echo esc_attr( $plugin ); ?>"<?php echo ( $plugin == $data['event_calendar'] ? ' SELECTED' : '' ); ?>><?php echo esc_html( $description ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div>
                                    <em><?= sprintf( esc_html( __( "Can't find the calendar with your events that you'd like to use?  %sLet us know%s!", 'event-calendar-newsletter' ) ), '<a href="mailto:info@eventcalendarnewsletter.com">', '</a>' ); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="events_future_in_days"><?php echo esc_html( __( 'Future Events to Use:', 'event-calendar-newsletter' ) ) ?></label></th>
                            <td>
                                <select id="events_future_in_days" name="events_future_in_days">
                                    <?php do_action( 'ecn_events_future_in_days_before', $data['events_future_in_days'] ); ?>
                                    <?php for ( $i = 1; $i < 4; $i++ ): ?>
                                        <option value="<?php echo ($i * 7); ?>"<?php echo ( $i * 7 == $data['events_future_in_days'] ? ' SELECTED' : '' ); ?>><?php echo sprintf( _n( '%d week', '%d weeks', $i, 'event-calendar-newsletter' ), $i ); ?></option>
                                    <?php endfor; ?>
                                    <?php for ( $i = 1; $i <= 12; $i++ ): ?>
                                        <option value="<?php echo ($i * 30); ?>"<?php echo ( $i * 30 == $data['events_future_in_days'] ? ' SELECTED' : '' ); ?>><?php echo sprintf( _n( '%d month', '%d months', $i, 'event-calendar-newsletter' ), $i ); ?></option>
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
	                        <th scope="row"><?php echo esc_html( __( 'Group events:', 'event-calendar-newsletter' ) ) ?></th>
	                        <td>
		                        <div>
			                        <select id="group_events" name="group_events">
				                        <option value="normal"><?php echo esc_html( __( 'None (Show events in order)', 'event-calendar-newsletter' ) ) ?></option>
				                        <?php do_action( 'ecn_additional_group_events_values', $data['group_events'] ); ?>
			                        </select>
		                        </div>
		                        <div>
			                        <em>
				                        <?php echo esc_html( __( 'If you have lots of events, you can group them together by day or month with a header for each group', 'event-calendar-newsletter' ) ) ?>
				                        <?php if ( 'valid' != get_option( 'ecn_pro_license_status' ) ): ?>
					                        <?php echo sprintf( esc_html( __( 'with the %sPro version%s', 'event-calendar-newsletter' ) ), '<a target="_blank" href="https://eventcalendarnewsletter.com/pro/?utm_source=wordpress.org&utm_medium=link&utm_campaign=event-cal-plugin&utm_content=groupevents">', '</a>' ); ?>
				                        <?php endif; ?>
									</em>
		                        </div>
	                        </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo esc_html( __( 'Format/Design:', 'event-calendar-newsletter' ) ) ?></th>
                            <td>
	                            <div class="leftcol">
		                            <fieldset>
			                            <label><input type="radio" name="design" value="default"<?php if ( 'default' == $data['design'] or false === $data['design'] ) checked( true ); ?>> Default</label><br />
			                            <label><input type="radio" name="design" value="compact"<?php checked( 'compact', $data['design'] ) ?>> Minimal/Compact</label><br />
			                            <?php do_action( 'ecn_designs', $data ); ?>
			                            <label><input type="radio" name="design" value="custom"<?php checked( 'custom', $data['design'] ) ?>> Custom</label><br />
			                        </fieldset>
	                            </div>
	                            <div class="right">
		                            <a target="_blank" href="https://eventcalendarnewsletter.com/designs?utm_source=wordpress.org&utm_medium=link&utm_campaign=event-cal-plugin&utm_content=design-link">See all designs</a>
	                            </div>

                                <div class="format_editor clearfix" style="display:none;">
                                    <select id="placeholder">
                                        <?php foreach ( ECNCalendarEvent::get_available_format_tags( $data['event_calendar'] ) as $tag => $description ): ?>
                                            <option value="<?php echo esc_attr( $tag ); ?>"><?php echo esc_html( $description ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input id="insert_placeholder" type="submit" value="<?= esc_attr( __( 'Insert', 'event-calendar-newsletter' ) ) ?>" class="button" />
	                                &nbsp; <a target="_blank" href="https://eventcalendarnewsletter.com/docs/tags/">View documentation on available tags</a>
                                </div>
                                <div class="format_editor">
	                                <?php wp_editor( $data['format'], 'format', array( 'editor_height' => 150, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                </div>
	                            <?php do_action( 'ecn_end_settings_page', $current_plugin, $data ) ?>
                            </td>
                        </tr>
	                    </tbody>
                    </table>
                </form>

                <div id="generate">
                    <input id="fetch_events" type="submit" value="<?= esc_attr( apply_filters( 'ecn_generate_button_text', __( 'Generate Newsletter Formatted Events', 'event-calendar-newsletter' ) ) ) ?>" class="button button-primary" />
                    <?php do_action( 'ecn_settings_after_fetch_events' ); ?>
	                <span class="spinner"></span>
                </div>

                <div class="result">
	                <?php do_action( 'ecn_main_before_results' ); ?>

                    <div id="copy_paste_info"><?php echo sprintf( esc_html__( 'Copy and paste the result into your MailChimp, ActiveCampaign, MailPoet or other newsletter sending service.  You will likely want to use the "Results (HTML)" version. %sView a Quick Demo%s', 'event-calendar-newsletter' ), '<a target="_blank" href="http://www.youtube.com/watch?v=4oSIlU541Bo">', '</a>' ); ?></div>

                    <h2 class="nav-tab-wrapper">
                        <a id="results_tab" class="nav-tab nav-tab-active"><?= esc_html( __( 'Result', 'event-calendar-newsletter' ) ) ?></a>
                        <a id="results_html_tab" class="nav-tab"><?= esc_html( __( 'Result (HTML)', 'event-calendar-newsletter' ) ) ?></a>
                    </h2>

                    <div id="results" class="tab_container">
                        <span id="output"></span>
                    </div>
                    <div id="results_html" class="tab_container">
                        <p><button id="select_html_results" class="btn"><?= esc_html( __( 'Select All Text', 'event-calendar-newsletter' ) ) ?></button></p>
                        <textarea id="output_html" rows="10" cols="80"></textarea>
                    </div>

	                <?php do_action( 'ecn_main_after_results' ); ?>

                </div>
            </div>
            <div class="rightcol">
                <?php if ( ! class_exists( 'ECNPro' ) ): ?>
                    <div id="ecn-pro-description">
                        <h3><?php echo esc_html__( 'Want more control over what events are displayed?', 'event-calendar-newsletter' ) ?></h3>
                        <p><?php echo sprintf( esc_html__( 'Check out %sEvent Calendar Newsletter Pro%s:', 'event-calendar-newsletter' ), '<a target="_blank" href="https://eventcalendarnewsletter.com/?utm_source=plugin&utm_medium=link&utm_campaign=ecn-upgrade-sidebar&utm_content=description">', '</a>' ); ?></p>
                        <h4><?php echo esc_html__( 'Additional Filter Options', 'event-calendar-newsletter' ) ?></h4>
                        <p><?php echo esc_html__( 'Filter by one or more categories, tags, and things like Featured Events depending on your calendar', 'event-calendar-newsletter' ) ?></p>
                        <h4><?php echo esc_html__( 'Group Events', 'event-calendar-newsletter' ) ?></h4>
                        <p><?php echo esc_html__( 'Group events by day or month, making it easier for users to see the events they are interested in', 'event-calendar-newsletter' ) ?></p>
                        <h4><?php echo esc_html__( 'Custom date range', 'event-calendar-newsletter' ) ?></h4>
                        <p><?php echo esc_html__( 'Choose events in a specific range, or even starting a certain time in the future', 'event-calendar-newsletter' ) ?></p>
                        <h4><?php echo esc_html__( 'Automate sending', 'event-calendar-newsletter' ) ?></h4>
                        <p><?php echo esc_html__( 'Automatically include events in your MailChimp, MailPoet, Active Campaign and several other newsletter sending tools!', 'event-calendar-newsletter' ) ?></p>
                        <p><?php echo sprintf( esc_html__( '%sLearn More About Event Calendar Newsletter Pro%s', 'event-calendar-newsletter' ), '<a class="ecs-button" target="_blank" href="https://eventcalendarnewsletter.com/?utm_source=plugin&utm_medium=link&utm_campaign=ecn-help-after-options&utm_content=description">', '</a>' ); ?></p>
                    </div>
                    <hr/>
	                <p><h2><?php echo esc_html__( 'Get 20% Off!', 'event-calendar-newsletter' ); ?></h2></p>
	                <p><h4><?php echo esc_html__( "Just enter your name and email and we'll send you a coupon for 20% off your upgrade to the Pro version", 'event-calendar-newsletter' ); ?></h4></p>

	                <?php $current_user = wp_get_current_user(); ?>

	                <!-- Begin MailChimp Signup Form -->
					<div id="mc_embed_signup">
					<form action="https://brianhogg.us3.list-manage.com/subscribe/post?u=98b752164e5f27815c50336ea&amp;id=f67eaf5c6b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					    <div id="mc_embed_signup_scroll">
					<div class="mc-field-group">
						<input type="email" value="<?= esc_attr( $current_user->user_email ) ?>" name="EMAIL" class="required email" placeholder="<?= __( 'Email', 'event-calendar-newsletter' ) ?>" id="mce-EMAIL">
					</div>
					<div class="mc-field-group">
						<input type="text" placeholder="<?= __( 'First name', 'event-calendar-newsletter' ) ?>" value="<?= esc_attr( $current_user->user_firstname ) ?>" name="FNAME" class="" id="mce-FNAME">
					</div>
					<input type="hidden" name="SIGNUP" id="SIGNUP" value="plugin" />
                            <input type="hidden" value="1" name="group[18831][1]" id="mce-group[18831]-18831-0">
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_98b752164e5f27815c50336ea_f67eaf5c6b" tabindex="-1" value=""></div>
					    <div class="clear"><input type="submit" value="<?php echo esc_attr__( 'Send me the coupon', 'event-calendar-newsletter' ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
					    </div>
					</form>
					</div>


					<p color="#555555"><?php echo esc_html__( 'We promise not to use your email for anything else and you can unsubscribe with 1-click anytime.', 'event-calendar-newsletter' ); ?></p>

					<!--End mc_embed_signup-->

	                <hr/>
	                <p><?php echo sprintf( wp_kses( __( "<strong>Like this plugin?</strong><br>We'd love if you could show your support by leaving a %s&#9733;&#9733;&#9733;&#9733;&#9733; 5 star review on WordPress.org%s!", 'event-calendar-newsletter' ), array( 'strong' => array(), 'br' => array() ) ), '<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/event-calendar-newsletter?filter=5#postform">', '</a>' ); ?></p>
                <?php endif; ?>

            </div>
        </div>
    <?php endif; ?>
</div>