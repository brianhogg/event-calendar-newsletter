<?php
class ECNDesignTest extends WP_UnitTestCase {
	function testDefaultDesignFormat() {
		global $ecn_admin_class;
		$this->assertEquals( false, $ecn_admin_class->get_design(), 'Design should be false by default' );

		$ecn_admin_class->save_format( '<p>{title}</p><p>{event_image}</p>' );
		$this->assertEquals( 'custom', $ecn_admin_class->get_design(), 'Design should be custom if there is already a saved format but no design' );

		$ecn_admin_class->save_design( 'compact' );
		$this->assertEquals( 'compact', $ecn_admin_class->get_design(), 'Design should be compact' );
	}
}