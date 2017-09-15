<?php
if ( ! class_exists( 'ECNSettings' ) ) {
class ECNSettings {
	function __construct() {
		if ( is_admin() ) {
			add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		}
		add_filter( 'ecn_image_size', array( &$this, 'filter_image_size' ), 1 );
		add_filter( 'ecn_admin_capability', array( &$this, 'filter_allowed_roles' ) );
	}

	function admin_menu() {
		add_submenu_page(
			'eventcalendarnewsletter',
			__( 'Event Calendar Newsletter Pro', 'event-calendar-newsletter' ),
			__( 'Settings', 'event-calendar-newsletter' ),
			apply_filters( 'ecn_admin_capability', 'add_users' ),
			'ecn-settings',
			array( &$this, 'settings_page' )
		);
	}

	function settings_page() {
		global $_wp_additional_image_sizes;

		if ( isset( $_POST['submit'] ) ) {
			$this->settings_page_save();
		}

		$data = array( 'image_size' => array() );

		// Default image sizes for thumbnails
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$data['image_size'][$_size] = $_size . ' (' . get_option( "{$_size}_size_w" ) . 'x' . get_option( "{$_size}_size_h" ) . ')';
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$data['image_size'][$_size] = $_size . ' (' . $_wp_additional_image_sizes[ $_size ]['width'] . 'x' . $_wp_additional_image_sizes[ $_size ]['height'] . ')';
			}
		}

		$data = apply_filters( 'ecn_global_settings_data', $data );

		include( dirname( __FILE__ ) . '/admin/settings.php' );
	}

	function settings_page_save() {
		if ( ! wp_verify_nonce( $_POST['ecn_nonce'], 'ecn_settings' ) )
			die( 'Invalid' );

		if ( ! current_user_can( apply_filters( 'ecn_admin_capability', 'add_users' ) ) )
			die( 'Insufficient permissions to save' );

		$this->save_image_size();
		$this->save_roles();

		do_action( 'ecn_settings_save', $_POST );

		?>
			<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
				<p><strong>Settings saved.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
			</div>
		<?php
	}

	function save_image_size() {
		if ( isset( $_POST['image_size'] ) )
			save_ecn_option( 'image_size', $_POST['image_size'] );
	}

	function save_roles() {
		global $wp_roles;
		if ( isset( $_POST['role'] ) and is_array( $_POST['role'] ) ) {
			foreach ( get_editable_roles() as $role => $role_details ) {
				// Always add administrator
				if ( 'administrator' == $role ) {
					$wp_roles->add_cap( $role, 'ecn_admin' );
					continue;
				}

				if ( in_array( $role, $_POST['role'] ) )
					$wp_roles->add_cap( $role, 'ecn_admin' );
				else
					$wp_roles->remove_cap( $role, 'ecn_admin' );
			}
			$wp_roles->reinit();
		}
	}

	/**
	 *
	 * Filters for saved settings
	 *
	 */

	/**
	 * Default image size to use for output
	 * @param $image_size
	 *
	 * @return mixed
	 */
	function filter_image_size( $image_size ) {
		return get_ecn_option( 'image_size', $image_size );
	}

	/**
	 * Filter using our custom ecn_admin capability, if set
	 * @param $cap
	 */
	function filter_allowed_roles( $cap ) {
		if ( get_role( 'administrator' )->has_cap( 'ecn_admin' ) )
			// Admin has the role and we've saved the cap, so use our ecn_admin capability instead
			$cap = 'ecn_admin';

		return $cap;
	}
}

$GLOBALS['ecn_settings'] = new ECNSettings();
}