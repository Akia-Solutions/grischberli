<?php


new HCBRWPB_Frontend();

class HCBRWPB_Frontend {

	function __construct() {

		/*
		 * Attention: In the standalone WPBakery VC Plugin, this hook accepts 4 parameters
		 * But the bundled version with Impreza Theme (and maybe others) only accepts 3 parameters
		 * which will cause a Fatal Error in newer PHP Versions (not sure, but >= 7)
		 * We don´t necessarily need the fourth parameter $shortcode, so we remove it from the function
		 */
		add_filter( 'vc_shortcode_output', [ $this, 'filter_vc_output' ], 20, 3 );
	}


	function filter_vc_output( $output, $object, $prepared_atts ) {

		$show = true;
		if ( ! empty( $prepared_atts['hcbrwpb_visible_for_roles'] ) ) {
			$allowed_roles = explode( ',', $prepared_atts['hcbrwpb_visible_for_roles'] );

			if ( ! empty( $allowed_roles ) ) {
				$show = false;

				// special case: allowed for logged out?
				if(in_array('logged_out', $allowed_roles) && !is_user_logged_in()){
					$show = true;
				} else {
					// check normal roles
					foreach ( $allowed_roles as $role ) {
						if ( HCBRWPB_Utils::user_has_role( get_current_user_id(), $role ) ) {
							$show = true;
						}
					}
				}
			}
		}

		if ( $show ) {
			return $output;
		} else {
			return '';
		}
	}


}