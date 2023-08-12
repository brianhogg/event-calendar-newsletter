<div class="wrap">
	<h2><?php echo esc_html( __( 'Event Calendar Newsletter Settings', 'event-calendar-newsletter' ) ); ?></h2>
	<form method="post" action="<?php echo admin_url( 'admin.php?page=ecn-settings' ); ?>">
		<?php echo wp_nonce_field( 'ecn_settings', 'ecn_nonce' ); ?>
		<table class="form-table">
			<?php do_action( 'ecn_additional_settings_page_rows_before', $data ); ?>
			<tr valign="top">
				<th scope="row"><?php echo esc_html( __( 'Image Size Used', 'event-calendar-newsletter' ) ); ?></th>
				<td>
					<select name="image_size">
						<?php foreach ( $data['image_size'] as $image_size => $description ): ?>
							<option value="<?php echo esc_attr( $image_size ); ?>" <?php echo  get_ecn_option( 'image_size', 'medium' ) == $image_size ? ' SELECTED' : ''; ?>><?php echo esc_html( $description ); ?></option>
						<?php endforeach; ?>
					</select><br/>
					<?php echo sprintf( esc_html__( 'If your images are not showing in the correct size, try another or you may need to %sregenerate your thumbnails%s', 'event-calendar-newsletter' ), '<a href="https://en-ca.wordpress.org/plugins/regenerate-thumbnails/" target="_blank">', '</a>' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo esc_html( __( 'Additionally Allowed User Roles', 'event-calendar-newsletter' ) ); ?></th>
				<td>
					<?php foreach ( get_editable_roles() as $role => $role_details ): ?>
						<?php if ( 'administrator' == $role ) {
						    continue;
						} ?>
						<label><input type="checkbox" name="role[]" value="<?php echo esc_attr( $role ); ?>" <?php echo  get_role( $role )->has_cap( 'ecn_admin' ) ? ' checked' : ''; ?>> <?php echo esc_html( $role_details['name'] ); ?></label><br />
					<?php endforeach; ?>
				</td>
			</tr>
			<?php do_action( 'ecn_additional_settings_page_rows_after', $data ); ?>
		</table>
		<?php submit_button(); ?>
	</form>
</div>