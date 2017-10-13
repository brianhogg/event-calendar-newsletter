<div class="wrap">
	<h2><?= esc_html( __( 'Event Calendar Newsletter Settings', 'event-calendar-newsletter' ) ) ?></h2>
	<form method="post" action="<?= admin_url( 'admin.php?page=ecn-settings' ) ?>">
		<?= wp_nonce_field( 'ecn_settings', 'ecn_nonce' ); ?>
		<table class="form-table">
			<?php do_action( 'ecn_additional_settings_page_rows_before', $data ); ?>
			<tr valign="top">
				<th scope="row"><?= esc_html( __( 'Image Size Used', 'event-calendar-newsletter' ) ) ?></th>
				<td>
					<select name="image_size">
						<?php foreach ( $data['image_size'] as $image_size => $description ): ?>
							<option value="<?= esc_attr( $image_size ) ?>" <?= ( get_ecn_option( 'image_size', 'medium' ) == $image_size ? ' SELECTED' : '' ) ?>><?= esc_html( $description ) ?></option>
						<?php endforeach; ?>
					</select><br/>
					<?= sprintf( esc_html__( 'If your images are not showing in the correct size, try another or you may need to %sregenerate your thumbnails%s', 'event-calendar-newsletter' ), '<a href="https://en-ca.wordpress.org/plugins/regenerate-thumbnails/" target="_blank">', '</a>' ) ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?= esc_html( __( 'Additionally Allowed User Roles', 'event-calendar-newsletter' ) ) ?></th>
				<td>
					<?php foreach ( get_editable_roles() as $role => $role_details ): ?>
						<?php if ( 'administrator' == $role ) continue; ?>
						<label><input type="checkbox" name="role[]" value="<?= esc_attr( $role ) ?>" <?= ( get_role( $role )->has_cap( 'ecn_admin' ) ? ' checked' : '' ) ?>> <?= esc_html( $role_details['name'] ) ?></label><br />
					<?php endforeach; ?>
				</td>
			</tr>
			<?php do_action( 'ecn_additional_settings_page_rows_after', $data ); ?>
		</table>
		<?php submit_button(); ?>
	</form>
</div>